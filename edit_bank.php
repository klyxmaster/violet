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

if (isset($_GET['id')) {
    $id = $_GET['id'];
    $bank = getBankById($con, $id);
}

if (isset($_POST['update_bank')) {
    $id = $_POST['id'];
    $bankname = $_POST['bankname'];
    $cardnum = $_POST['cardnum'];
    $validthru = $_POST['validthru'];
    $cardholder = $_POST['cardholder'];
    $cvv = $_POST['cvv'];
    $cardtype = $_POST['cardtype'];
    $pin = $_POST['pin'];

    updateBank($con, $id, $bankname, $cardnum, $validthru, $cardholder, $cvv, $cardtype, $pin);

    $_SESSION['success'] = 'Bank details updated successfully!';
    header('Location: vault.php?type=banks');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Bank - VIOLET</title>
    <link rel="stylesheet" href="css/style.css">
	<link rel="icon" type="image/x-icon" href="img/favicon.ico"> <!-- Add this line -->
</head>
<body>
    <div class="container">
        <h1 class="title">VIOLET</h1>
        <p class="subtitle">My Personal Password Manager</p>
        <h2>Edit Bank Details</h2>
        <form action="edit_bank.php" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($bank['Bank_ID'); ?>">
            <input type="text" name="bankname" placeholder="Bank Name" value="<?= htmlspecialchars($bank['Bank_Name'); ?>" required autofocus><br>
            <input type="text" name="cardnum" placeholder="Card Number" value="<?= htmlspecialchars(decryptData($bank['Bank_CardNum')); ?>" required><br>
            <input type="text" name="validthru" placeholder="Valid Thru" value="<?= htmlspecialchars($bank['Bank_ValidThru'); ?>" required><br>
            <input type="text" name="cardholder" placeholder="Card Holder" value="<?= htmlspecialchars($bank['Bank_CardHolder'); ?>" required><br>
            <input type="text" name="cvv" placeholder="CVV" value="<?= htmlspecialchars(decryptData($bank['Bank_Cvv')); ?>" required><br>
            <input type="text" name="cardtype" placeholder="Card Type" value="<?= htmlspecialchars($bank['Bank_CardType'); ?>" required><br>
            <input type="password" name="pin" placeholder="PIN" value="<?= htmlspecialchars(decryptData($bank['Bank_Pin')); ?>" required><br>
            <button type="submit" name="update_bank">Update Bank</button>
        </form>
        <p><a href="vault.php?type=banks">Back to Vault</a></p>
    </div>
	 <?php include 'footer.php'; ?>
</body>
</html>
