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

$duplicate_warning = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bank_name = $_POST['bank_name'];
    $card_num = encryptData($_POST['card_num']);
    $valid_thru = $_POST['valid_thru'];
    //$card_holder = $_POST['card_holder'];
    $cvv = encryptData($_POST['cvv']);
    $card_type = $_POST['card_type'];
    //$pin = encryptData($_POST['pin']);

    // Check for duplicates
    $stmt = $con->prepare('SELECT * FROM bankdetails WHERE Bank_Name = ? OR Bank_CardNum = ?');
    $stmt->execute([$bank_name, $card_num]);
    $duplicates = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($duplicates) > 0) {
        $duplicate_warning = "Duplicate bank entry found. Do you still want to add it?";
    }

    if (isset($_POST['confirm']) || count($duplicates) === 0) {
        $stmt = $con->prepare('INSERT INTO bankdetails (Bank_Name, Bank_CardNum, Bank_ValidThru, Bank_Cvv, Bank_CardType) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$bank_name, $card_num, $valid_thru, $cvv, $card_type]);

        $success = "Bank entry added successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Bank - Violet PWM</title>
    <link rel="stylesheet" href="css/style.css">
	<link rel="icon" type="image/x-icon" href="img/favicon.ico"> <!-- Add this line -->
</head>
<body>
    <div class="container">
        <h1 class="title">Add Bank</h1>
        <?php if (isset($success)) echo "<p>$success</p>"; ?>
        <?php if ($duplicate_warning) echo "<p>$duplicate_warning</p>"; ?>
        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label for="bank_name">Bank Name:</label>
                    <input type="text" id="bank_name" name="bank_name" required autofocus>
                </div>
                <div class="form-group">
                    <label for="card_num">Card Number:</label>
                    <input type="text" id="card_num" name="card_num" required>
                </div>
                <div class="form-group">
                    <label for="valid_thru">Valid Thru:</label>
                    <input type="text" id="valid_thru" name="valid_thru" required>
                </div>
                
                <div class="form-group">
                    <label for="cvv">CVV:</label>
                    <input type="text" id="cvv" name="cvv" required>
                </div>
                <div class="form-group">
                    <label for="card_type">Card Type:</label>
                    <input type="text" id="card_type" name="card_type" required>
                </div>
                
                <?php if ($duplicate_warning) echo '<input type="hidden" name="confirm" value="1">'; ?>
                <button type="submit">Add Bank</button>
            </form>
        </div>
        <p><a href="index.php">Back to Home</a></p>
    </div>
	<?php include 'footer.php'; ?>
</body>
</html>
