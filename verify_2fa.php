<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['user_id')) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_otp = $_POST['otp'];
    require 'vendor/autoload.php';
    use OTPHP\TOTP;

    $secret = VIOLET_AUTH;
    $totp = TOTP::create($secret);

    if ($totp->verify($user_otp)) {
        $_SESSION['2fa_verified'] = true;
        header('Location: index.php');
        exit();
    } else {
        $error = "Invalid 2FA code.";
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
                <label for="otp">Enter 2FA Code:</label>
                <input type="text" id="otp" name="otp" required>
            </div>
            <button type="submit">Verify</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
