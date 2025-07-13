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
if (!isset($_SESSION['user_id')) {
    header('Location: login.php');
    exit();
}

include 'includes/config.php';
include 'includes/dbconnect.php';
include 'includes/functions.php';

$type = isset($_GET['type') ? $_GET['type'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $type) {
    try {
        if ($type === 'websites') {
            $data = getAllWebsites($con);
            $filename = 'websites_export.xml';
        } elseif ($type === 'banks') {
            $data = getAllBanks($con);
            $filename = 'banks_export.xml';
        } else {
            throw new Exception('Invalid export type.');
        }

        if (empty($data)) {
            throw new Exception('No data available for export.');
        }

        header('Content-Type: application/xml');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $xml = new SimpleXMLElement('<root/>');
        foreach ($data as $item) {
            $itemNode = $xml->addChild('item');
            foreach ($item as $key => $value) {
                $itemNode->addChild($key, htmlspecialchars($value));
            }
        }

        echo $xml->asXML();
        exit();
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo 'Error: ' . $e->getMessage();
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Data - VIOLET</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="title">VIOLET</h1>
        <p class="subtitle">Export Data</p>
        <form method="POST">
            <p>Are you sure you want to export all <?= htmlspecialchars($type) ?> data?</p>
            <button type="submit">Export</button>
        </form>
        <p><a href="index.php">Back to Home</a></p>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
