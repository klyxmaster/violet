<?php
session_start();
include 'includes/dbconnect.php';
include 'includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = sha1($username . ':' . $password); // Adjust as per your hashing method

    $stmt = $con->prepare('SELECT id, username, password, 2fa_str FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $hashed_password === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        
        // Check the number of remaining codes
        $remaining_codes = get2FACodes($user['2fa_str']);
        if (count($remaining_codes) <= 5) {
            $_SESSION['2fa_reminder'] = "You have " . count($remaining_codes) . " 2FA codes left. Please generate new codes.";
        }

        header('Location: index.php');
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Violet PWM</title>
    <link rel="stylesheet" href="css/style.css">
	<link rel="icon" type="image/x-icon" href="img/favicon.ico"> <!-- Add this line -->
</head>
<body>
    <div class="container">
        <h1 class="title">Login</h1>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
