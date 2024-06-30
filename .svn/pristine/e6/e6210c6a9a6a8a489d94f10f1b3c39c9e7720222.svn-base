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

session_start();

$stmt = $con->prepare('SELECT COUNT(*) FROM users');
$stmt->execute();
$userCount = $stmt->fetchColumn();

if ($userCount > 0) {
    header('Location: account_exists.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = sha1($username . ":" . $password);
    $create_datetime = date("Y-m-d H:i:s");

    $stmt = $con->prepare('INSERT INTO users (username, email, password, create_datetime) VALUES (?, ?, ?, ?)');
    $stmt->execute([$username, $email, $hashed_password, $create_datetime]);

    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Violet PWM</title>
    <link rel="stylesheet" href="css/style.css">
	<link rel="icon" type="image/x-icon" href="img/favicon.ico"> <!-- Add this line -->
</head>
<body>
    <div class="container">
        <h1 class="title">Register</h1>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
