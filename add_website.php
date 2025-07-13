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
    $web_address = $_POST['web_address'];
    $web_name = $_POST['web_name'];
    $web_login = $_POST['web_login'];
    $web_password = encryptData($_POST['web_password']);
	$web_secretCode = $_POST['web_secretCode'];
	$date_edited = date('Y-m-d H:i:s');
	$date_created = $date_edited;

    // Check for duplicates
    $stmt = $con->prepare('SELECT * FROM websitedetails WHERE Web_Address = ?');
    $stmt->execute([$web_address]);
    $duplicates = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($duplicates) > 0) {
        $duplicate_warning = "Duplicate website entry found. Do you still want to add it?";
    }

    if (isset($_POST['confirm']) || count($duplicates) === 0) {
        $stmt = $con->prepare('INSERT INTO websitedetails (Web_Address, Web_Name, Web_Login, Web_Password, Web_SecretCode, Web_Date_Created, Web_Date_Edited) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$web_address, $web_name, $web_login, $web_password, $web_secretCode, $date_created, $date_edited]);

        $success = "Website entry added successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Website - Violet PWM</title>
    <link rel="stylesheet" href="css/style.css">
	<link rel="icon" type="image/x-icon" href="img/favicon.ico"> <!-- Add this line -->
</head>
<body>
    <div class="container">
        <h1 class="title">Add Website</h1>
        <?php if (isset($success)) echo "<p>$success</p>"; ?>
        <?php if ($duplicate_warning) echo "<p>$duplicate_warning</p>"; ?>
        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label for="web_address">Website Address:</label>
                    <input type="text" id="web_address" name="web_address" required autofocus>
                </div>
                <div class="form-group">
                    <label for="web_name">Website Name:</label>
                    <input type="text" id="web_name" name="web_name" required>
                </div>
                <div class="form-group">
                    <label for="web_login">Login:</label>
                    <input type="text" id="web_login" name="web_login" required>
                </div>
                <div class="form-group">
                    <label for="web_password">Password:</label>
                    <input type="password" id="web_password" name="web_password" required>
                </div>
				<div class="form-group">
                    <label for="web_secretCode">2FA Code:</label>
                    <input type="password" id="web_secretCode" name="web_secretCode" required>
                </div>
                <?php if ($duplicate_warning) echo '<input type="hidden" name="confirm" value="1">'; ?>
                <button type="submit">Add Website</button>
            </form>
        </div>
        <p><a href="index.php">Back to Home</a></p>
    </div>
	 <?php include 'footer.php'; ?>
</body>
</html>
