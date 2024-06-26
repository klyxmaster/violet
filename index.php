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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIOLET</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .menu {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">VIOLET</h1>
        <p class="subtitle">My Personal Password Manager</p>
        <p>Welcome, <strong><?= htmlspecialchars($_SESSION['username']); ?></strong>!</p>
        <div class="navbar">
			<a href="index.php">Home</a>
			<a href="vault.php?type=websites">View Websites</a>
			<a href="vault.php?type=banks">View Banks</a>
			<div class="dropdown">
				<button class="dropbtn">Add/Edit
					<i class="fa fa-caret-down"></i>
				</button>
				<div class="dropdown-content">
					<a href="add_website.php">Add Website</a>
					<a href="add_bank.php">Add Bank</a>
					<a href="account_editor.php">Edit Account</a>
				</div>
			</div> 
			<a href="about.php">About</a>
			<a href="donate.php">Donate</a>
			<a href="logoff.php">Logoff</a>
		</div>
	
    </div>
	  <?php include 'footer.php'; ?>
</body>
</html>
