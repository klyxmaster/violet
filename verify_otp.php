<?php
session_start();
/**
 * Proprietary License
 *
 * Copyright (c) 2024 Richard Scorpio
 *
 * All rights reserved. This software is proprietary and confidential. Unauthorized copying of this file, via any medium, is strictly prohibited.
 * Contact rickscorpio@proton.me for licensing information.
 * Subject: Violet PWM
 */
 
if (!isset($_SESSION['2fa_pending')) {
    header('Location: login.php');
    exit();
}

include 'includes/config.php';
include 'includes/dbconnect.php';
include 'includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = $_POST['code'];
    $stmt = $con->prepare('SELECT username, 2fa_str FROM users WHERE id = ?');
    $stmt->execute($_SESSION['2fa_pending']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $new_codes_str = use2FACode($code, $user['2fa_str');
        if ($new_codes_str !== false) {
            $stmt = $con->prepare('UPDATE users SET 2fa_str = ? WHERE id = ?');
            $stmt->execute($new_codes_str, $_SESSION['2fa_pending']);

            $_SESSION['user_id'] = $_SESSION['2fa_pending'];
            $_SESSION['username'] = $user['username'];
            unset($_SESSION['2fa_pending');
            header('Location: index.php');
            exit();
        } else {
            $error = "Invalid 2FA code.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2FA Verification - Violet PWM</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="title">2FA Verification</h1>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <label for="code">Enter 2FA Code:</label>
                <input type="text" id="code" name="code" required>
            </div>
            <button type="submit">Verify</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
