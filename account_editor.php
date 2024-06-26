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

// Fetch user data
$stmt = $con->prepare('SELECT username, email, password FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_account'])) {
        // Delete user and reset tables
        $stmt = $con->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$_SESSION['user_id']]);

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
    } else {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Verify current password for any changes
        if (sha1($user['username'] . ":" . $current_password) !== $user['password']) {
            $error = "Current password is incorrect.";
        } elseif ($new_password !== $confirm_password) {
            $error = "New passwords do not match.";
        } else {
            // Update user data
            $new_encrypted_password = $new_password ? sha1($username . ":" . $new_password) : $user['password'];
            $stmt = $con->prepare('UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?');
            $stmt->execute([$username, $email, $new_encrypted_password, $_SESSION['user_id']]);

            $success = "Account details updated successfully!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Editor - Violet PWM</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Account Editor</h1>
        <?php if (isset($success)) echo "<p>$success</p>"; ?>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="current_password">Current Password:</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password:</label>
                    <input type="password" id="confirm_password"  name="confirm_password">
                </div>
                <button type="submit">Save Changes</button>
                <button type="button" onclick="window.location.href='index.php'">Cancel</button>
            </form>
            <form method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action is irreversible.');">
                <input type="hidden" name="delete_account" value="1">
                <button type="submit">Delete Account</button>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>

