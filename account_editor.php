<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'includes/dbconnect.php';
include 'includes/functions.php';

$stmt = $con->prepare('SELECT username, email, password, 2fa_str FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $hashed_password = sha1($user['username'] . ':' . $current_password); // Adjust as per your hashing method

    if ($hashed_password === $user['password']) {
        if (isset($_POST['generate_2fa_codes'])) {
            $new_codes = generate2FACodes();
            $codes_str = save2FACodes($new_codes);
            $stmt = $con->prepare('UPDATE users SET 2fa_str = ? WHERE id = ?');
            $stmt->execute([$codes_str, $_SESSION['user_id']]);
            $user['2fa_str'] = $codes_str;
            header('Location: 2fa_codes.php'); // Redirect to view the new codes
            exit();
        } else {
            // Existing logic for updating username, email, password
            $username = $_POST['username'];
            $email = $_POST['email'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            if (!empty($new_password) && ($new_password === $confirm_password)) {
                $hashed_new_password = sha1($username . ':' . $new_password); // Adjust as per your hashing method
                $stmt = $con->prepare('UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?');
                $stmt->execute([$username, $email, $hashed_new_password, $_SESSION['user_id']]);
            } else {
                $stmt = $con->prepare('UPDATE users SET username = ?, email = ? WHERE id = ?');
                $stmt->execute([$username, $email, $_SESSION['user_id']]);
            }
        }
    } else {
        $error = "Incorrect current password.";
    }
}

$codes = $user['2fa_str'] ? get2FACodes($user['2fa_str']) : [];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Editor - Violet PWM</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        function toggle2FAButton() {
            var checkbox = document.getElementById('2fa_enabled');
            var button = document.getElementById('generate_2fa_button');
            if (checkbox.checked) {
                button.style.display = 'block';
            } else {
                button.style.display = 'none';
            }
        }
    </script>
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
                    <input type="password" id="confirm_password" name="confirm_password">
                </div>
                <div class="form-group">
                    <input type="checkbox" id="2fa_enabled" name="2fa_enabled" <?php if ($user['2fa_str']) echo 'checked'; ?> onclick="toggle2FAButton()">
                    <label for="2fa_enabled">Enable 2FA (Future Feature)</label>
                </div>
                <button type="submit">Save Changes</button>
                <button type="button" onclick="window.location.href='index.php'">Cancel</button>
            </form>
            <form method="POST">
                <input type="hidden" name="generate_2fa_codes" value="1">
                <button type="submit" id="generate_2fa_button" style="display: <?php echo ($user['2fa_str'] ? 'block' : 'none'); ?>">Generate New 2FA Codes</button>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
