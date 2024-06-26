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

if (isset($_GET['add_website'])) {
    $address = $_GET['address'];
    $sitename = $_GET['sitename'];
    $login = $_GET['login'];
    $password = $_GET['password'];

    addWebsite($con, $address, $sitename, $login, $password);

    $_SESSION['success'] = 'Website details added successfully!';
    header('Location: add_website.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Website - VIOLET</title>
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
            echo '<p><a href="add_website.php">Add Another</a> or <a href="index.php">Go Back to Main Menu</a></p>';
        } else {
            echo '
            <h2>Add Website Details</h2>
            <form action="add_website.php" method="get">
                <input type="text" name="address" placeholder="Website Address" required><br>
                <input type="text" name="sitename" placeholder="Website Name" required><br>
                <input type="text" name="login" placeholder="Login" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <button type="submit" name="add_website">Add Website</button>
            </form>
            <p><a href="index.php">Back to Home</a></p>
            ';
        }
        ?>
    </div>
</body>
</html>
