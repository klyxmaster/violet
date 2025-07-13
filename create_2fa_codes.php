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

$stmt = $con->prepare('SELECT username FROM users WHERE id = ?');
$stmt->execute($_SESSION['user_id']);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codes = generate2FACodes($user['username'], CODE_GEN_MAX);
    $codes_str = obfuscate2FACodes($codes); // Store obfuscated codes in the database
    try {
        $stmt = $con->prepare('UPDATE users SET 2fa_str = ? WHERE id = ?');
        $stmt->execute($codes_str, $_SESSION['user_id']);
        $success = "New 2FA codes have been generated.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    $stmt = $con->prepare('SELECT 2fa_str FROM users WHERE id = ?');
    $stmt->execute($_SESSION['user_id']);
    $user_2fa = $stmt->fetch(PDO::FETCH_ASSOC);
    $codes = $user_2fa['2fa_str'] ? deobfuscate2FACodes($user_2fa['2fa_str') : [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New 2FA Codes - Violet PWM</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Create New 2FA Codes</h1>
        <?php if (isset($success)) echo "<p>$success</p>"; ?>
        <p>Click the button below to generate new 2FA codes. This will replace any existing codes.</p>
        <form method="POST">
            <button type="submit">Generate New 2FA Codes</button>
        </form>
        <p>Current 2FA codes:</p>
        <table class="codes-table">
            <?php foreach (array_chunk($codes, 5) as $chunk): ?>
                <tr>
                    <?php foreach ($chunk as $code): ?>
                        <td><?php echo htmlspecialchars($code) ?: 'Code Used'; ?></td> <!-- Display 'Code Used' if the cell is empty -->
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
        <button onclick="window.location.href='index.php'">Return to Menu</button>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
