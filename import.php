<?php
/**
 * Proprietary License
 *
 * Copyright (c) 2024 Richard Scorpio
 *
 * All rights reserved. This software is proprietary and confidential. Unauthorized copying of this file, via any medium, is strictly prohibited.
 * Contact rickscorpio@proton.me for licensing information.
 * Subject: Violet PWM
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'includes/config.php';
include 'includes/dbconnect.php';
include 'includes/functions.php';

$type = isset($_GET['type']) ? $_GET['type'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file']['tmp_name'];
    $xml = simplexml_load_file($file);

    if ($type === 'websites') {
        foreach ($xml->item as $item) {
            $address = (string)$item->Web_Address;
            $name = (string)$item->Web_Name;
            $login = (string)$item->Web_Login;
            $password = encryptData((string)$item->Web_Password);

            $stmt = $con->prepare('INSERT INTO websitedetails (Web_Address, Web_Name, Web_Login, Web_Password) VALUES (?, ?, ?, ?)');
            $stmt->execute([$address, $name, $login, $password]);
        }
    } elseif ($type === 'banks') {
        foreach ($xml->item as $item) {
            $name = (string)$item->Bank_Name;
            $cardNum = encryptData((string)$item->Bank_CardNum);
            $validThru = (string)$item->Bank_ValidThru;
            $cardHolder = (string)$item->Bank_CardHolder;
            $cvv = encryptData((string)$item->Bank_Cvv);
            $cardType = (string)$item->Bank_CardType;
            $pin = encryptData((string)$item->Bank_Pin);

            $stmt = $con->prepare('INSERT INTO bankdetails (Bank_Name, Bank_CardNum, Bank_ValidThru, Bank_CardHolder, Bank_Cvv, Bank_CardType, Bank_Pin) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$name, $cardNum, $validThru, $cardHolder, $cvv, $cardType, $pin]);
        }
    } else {
        die('Invalid import type.');
    }

    $_SESSION['success'] = ucfirst($type) . ' data imported successfully!';
    header('Location: vault.php?type=' . $type);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Data - VIOLET</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="title">VIOLET</h1>
        <p class="subtitle">Import Data</p>
        <form method="POST" enctype="multipart/form-data">
            <p>Select XML file to import <?= htmlspecialchars($type) ?> data:</p>
            <input type="file" name="file" accept=".xml" required>
            <button type="submit">Import</button>
        </form>
        <p><a href="index.php">Back to Home</a></p>
    </di
