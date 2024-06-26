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

include 'includes/dbconnect.php';
include 'includes/functions.php';

if (isset($_GET['add_bank'])) {
    $bankname = $_GET['bankname'];
    $cardnum = $_GET['cardnum'];
    $validthru = $_GET['validthru'];
    $cardholder = $_GET['cardholder'];
    $cvv = $_GET['cvv'];
    $cardtype = $_GET['cardtype'];
    $pin = $_GET['pin'];

    addBank($con, $bankname, $cardnum, $validthru, $cardholder, $cvv, $cardtype, $pin);

    $_SESSION['success'] = 'Bank details added successfully!';
    header('Location: add_bank.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Bank - VIOLET</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="title">VIOLET</h1>
        <p class="subtitle">My Personal Password Manager</p>
        <?php
        if (isset($_SESSION['success'])) {
            echo '<p>' . $_SESSION['success'] . '</p>';
            unset($_SESSION['success']);
            echo '<p><a href="add_bank.php">Add Another</a> or <a href="index.php">Go Back to Main Menu</a></p>';
        } else {
            echo '
            <h2>Add Bank Details</h2>
            <form action="add_bank.php" method="get">
                <input type="text" name="bankname" placeholder="Bank Name" required><br>
                <input type="text" name="cardnum" placeholder="Card Number" required><br>
                <input type="text" name="validthru" placeholder="Valid Thru" required><br>
                <input type="text" name="cardholder" placeholder="Card Holder" required><br>
                <input type="text" name="cvv" placeholder="CVV" required><br>
                <input type="text" name="cardtype" placeholder="Card Type" required><br>
                <input type="password" name="pin" placeholder="PIN" required><br>
                <button type="submit" name="add_bank">Add Bank</button>
            </form>
            <p><a href="index.php">Back to Home</a></p>
            ';
        }
        ?>
    </div>
</body>
</html>
