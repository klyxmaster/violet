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
include 'includes/dbconnect.php';
include 'includes/functions.php';

if (isset($_GET['login'])) {
    $username = $_GET['username'];
    $password = sha1($username . ':' . $_GET['password']);

    $user = getUserByUsernameAndPassword($con, $username, $password);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['unlock'] = true;
        header('Location: index.php');
        exit();
    } else {
        $error = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - VIOLET</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="title">VIOLET</h1>
        <p class="subtitle">My Personal Password Manager</p>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
        <form action="login.php" method="get">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit" name="login">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </div>
</body>
</html>
