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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIOLET</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .menu {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">VIOLET</h1>
        <p class="subtitle">My Personal Password Manager</p>
        <p>Welcome, <strong><?= htmlspecialchars($_SESSION['username']); ?></strong>!</p>
        <div class="menu">
            <p><a href="vault.php?type=websites">View Website Details</a></p>
            <p><a href="vault.php?type=banks">View Bank Details</a></p>
            <p><a href="add_website.php">Add Website Details</a></p>
            <p><a href="add_bank.php">Add Bank Details</a></p>
            <p><a href="logout.php">Logout</a></p>
        </div>
    </div>
</body>
</html>
