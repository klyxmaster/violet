<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'includes/dbconnect.php';
include 'includes/functions.php';

$stmt = $con->prepare('SELECT 2fa_str FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$codes = $user['2fa_str'] ? get2FACodes($user['2fa_str']) : [];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2FA Codes - Violet PWM</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="title">2FA Codes</h1>
        <p>Please save these 2FA codes securely.</p>
        <table class="codes-table">
            <?php foreach (array_chunk($codes, 10) as $chunk): ?>
                <tr>
                    <?php foreach ($chunk as $code): ?>
                        <td><?php echo htmlspecialchars($code); ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
        <button onclick="window.location.href='index.php'">Return to Menu</button>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
