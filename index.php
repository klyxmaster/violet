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
 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/Chicago');

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
</head>
<body>
    <div class="container">
        <h1 class="title">VIOLET</h1>
        <p class="subtitle">My Personal Password Manager</p>
        <p>Welcome, <strong><?= htmlspecialchars($_SESSION['username']); ?></strong>!</p>
        <div class="navbar">
            <div class="dropdown">
                <button class="dropbtn">View</button>
                <div class="dropdown-content">
                    <a href="vault.php?type=websites">View Websites</a>
                    <a href="vault.php?type=banks">View Banks</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Add</button>
                <div class="dropdown-content">
                    <a href="add_website.php">Add Website</a>
                    <a href="add_bank.php">Add Bank</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Other</button>
                <div class="dropdown-content">
                    <a href="account_editor.php">Edit Account</a>
                    <a href="about.php">About</a>                   
                    <a href="donate.php">Donate</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Import/Export</button>
                <div class="dropdown-content">
                    <a href="import.php?type=websites">Import Websites</a>
                    <a href="import.php?type=banks">Import Banks</a>
                    <a href="export.php?type=websites">Export Websites</a>
                    <a href="export.php?type=banks">Export Banks</a>
                </div>
            </div>
            <a href="logout.php">Logoff</a>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
