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
    $website = getWebsiteById($con, $id);
}

if (isset($_POST['update_website')) {
    $id = $_POST['id'];
    $address = $_POST['address'];
    $sitename = $_POST['sitename'];
    $login = $_POST['login'];
    $password = $_POST['password'];

    updateWebsite($con, $id, $address, $sitename, $login, $password);

    // Redirect to vault.php without asking for the password again
    $_SESSION['success'] = 'Website details updated successfully!';
    header('Location: vault.php?type=websites');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Website - VIOLET</title>
    <link rel="stylesheet" href="css/style.css">
	<link rel="icon" type="image/x-icon" href="img/favicon.ico"> <!-- Add this line -->
</head>
<body>
    <div class="container">
        <h1 class="title">VIOLET</h1>
        <p class="subtitle">My Personal Password Manager</p>
        <h2>Edit Website Details</h2>
        <form action="edit_website.php" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($website['Web_ID'); ?>">
            <input type="text" name="address" placeholder="Website Address" value="<?= htmlspecialchars($website['Web_Address'); ?>" required><br>
            <input type="text" name="sitename" placeholder="Website Name" value="<?= htmlspecialchars($website['Web_Name'); ?>" required><br>
            <input type="text" name="login" placeholder="Login" value="<?= htmlspecialchars($website['Web_Login'); ?>" required><br>
            <input type="password" name="password" placeholder="Password" value="<?= htmlspecialchars(decryptData($website['Web_Password')); ?>" required><br>
            <button type="submit" name="update_website">Update Website</button>
        </form>
        <p><a href="vault.php?type=websites">Back to Vault</a></p>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
