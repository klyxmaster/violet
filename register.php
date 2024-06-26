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
 
include 'includes/dbconnect.php';
include 'includes/functions.php';

session_start();

if (isset($_GET['register'])) {
    $username = $_GET['username'];
    $email = $_GET['email'];
    $password = sha1($username . ':' . $_GET['password']);
    $create_datetime = date('Y-m-d H:i:s');

    addUser($con, $username, $email, $password, $create_datetime);

    $_SESSION['success'] = 'Registration successful! Please log in.';
    header('Location: register.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - VIOLET</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(function() {
                    window.location.href = 'login.php';
                }, 3000); // Redirect after 3 seconds
            }
        });
    </script>
</head>
<body>
    <div class="container">
        <h1 class="title">VIOLET</h1>
        <p class="subtitle">My Personal Password Manager</p>
        <?php
        if (isset($_SESSION['success'])) {
            echo '<p id="success-message">' . $_SESSION['success'] . '</p>';
            unset($_SESSION['success']);
        }
        ?>
        <form action="register.php" method="get">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit" name="register">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>
