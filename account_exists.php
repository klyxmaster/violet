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
include 'includes/config.php'; 
include 'includes/dbconnect.php';
include 'includes/functions.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Delete user and reset tables
    $stmt = $con->prepare('DELETE FROM users WHERE id = ?');
    $stmt->execute($_SESSION['user_id']);

    $stmt = $con->prepare('DELETE FROM websitedetails');
    $stmt->execute();

    $stmt = $con->prepare('DELETE FROM bankdetails');
    $stmt->execute();

    // Reset auto-increment values
    $stmt = $con->prepare('ALTER TABLE users AUTO_INCREMENT = 1');
    $stmt->execute();

    $stmt = $con->prepare('ALTER TABLE websitedetails AUTO_INCREMENT = 1');
    $stmt->execute();

    $stmt = $con->prepare('ALTER TABLE bankdetails AUTO_INCREMENT = 1');
    $stmt->execute();

    session_destroy();
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Exists - Violet PWM</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Account Already Exists</h1>
        <p>An account already exists in the system. Registration is currently disabled.</p>
        <p>If you wish to delete the existing account, please be aware that this action is irreversible and all data will be permanently removed.</p>
        <form method="POST" onsubmit="return confirm('Are you sure you want to delete the existing account? This action is irreversible.');">
            <button type="submit">Delete Account</button>
        </form>
        <p><a href="login.php">Return to Login</a></p>
    </div>
		 <?php include 'footer.php'; ?>
</body>
</html>
