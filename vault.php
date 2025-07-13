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

include 'includes/config.php';
include 'includes/dbconnect.php';
include 'includes/functions.php';

$showData = false;
$type = '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 7;
$offset = ($page - 1) * $items_per_page;

if (isset($_SESSION['unlock'])) {
    $showData = true;
    $type = $_GET['type'];
    //unset($_SESSION['unlock');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unlock'])) {
    $password = sha1($_SESSION['username'] . ':' . $_POST['password']);
    $user = getUserByUsernameAndPassword($con, $_SESSION['username'], $password);

    if ($user) {
        $_SESSION['unlock'] = true;
        $type = htmlspecialchars(trim($_POST['type'])); // Sanitize $type
        $page = (int)$_POST['page']; // Sanitize $page
        header("Location: vault.php?type=$type&page=$page");
        exit();
    } else {
        $error = 'Invalid password';
    }
}

$total_items = getTotalItems($con, $type);
$total_pages = ceil($total_items / $items_per_page);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vault - VIOLET</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/vault.css"> <!-- Link to vault.css -->
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="js/totp.js"></script>
	<script>
	function show2FACode(secret) {
		console.log("Using secret:", secret);
		generateTOTP(secret)
			.then(code => {
				navigator.clipboard.writeText(code)
					.then(() => {
						alert("2FA Code copied to clipboard: " + code);
					})
					.catch(err => {
						alert("2FA Code: " + code + "\n(Clipboard copy failed: " + err.message + ")");
					});
			})
			.catch(err => {
				alert("TOTP Error: " + err.message);
			});
	}
	</script>



    
    <script src="js/vault.js"></script> <!-- Link to vault.js -->
</head>
<body>
    <div class="container">
        <h1 class="title">VIOLET</h1>
        <p class="subtitle">My Personal Password Manager</p>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
        <?php if (isset($_SESSION['success'])) {
            echo '<p>' . $_SESSION['success'] . '</p>';
            unset($_SESSION['success']);
        } ?>

        <?php if ($showData): ?>
            <input type="text" id="search" placeholder="Search..." data-type="<?= $type ?>">
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="vault.php?type=<?= htmlspecialchars($type) ?>&page=<?= $page - 1 ?>" class="button-link">Prev</a>
                <?php endif; ?>
                <a href="index.php" class="button-link">Menu</a>
                <?php if ($page < $total_pages): ?>
                    <a href="vault.php?type=<?= htmlspecialchars($type) ?>&page=<?= $page + 1 ?>" class="button-link">Next</a>
                <?php endif; ?>
            </div>
            <div id="results">
                <?php if ($type == 'websites'): ?>
                    <h2>Website Details</h2>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Address</th>
                            <th>Name</th>
                            <th>Login</th>
                            <th>Password</th>
                            <th>Actions</th>
                            <th>Date Created</th>
                            <th>Date Edited</th>
                        </tr>
                        <?php
                         $websites = getItems($con, 'websites', $items_per_page, $offset);
                        foreach ($websites as $row) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['Web_ID'] ?? '') . '</td>';
                            echo '<td class="copycell">' . htmlspecialchars($row['Web_Address'] ?? '') . '</td>';
                            echo '<td class="copycell">' . htmlspecialchars($row['Web_Name'] ?? '') . '</td>';
                            echo '<td class="copycell">' . htmlspecialchars($row['Web_Login'] ?? '') . '</td>';
                            echo '<td class="copycell">' . htmlspecialchars(decryptData($row['Web_Password'] ?? '')) . '</td>';
                            echo '<td class="copycell">
										<a href="edit_website.php?id=' . htmlspecialchars($row['Web_ID'] ?? '') . '">Edit</a> | 
										<a href="delete_website.php?id=' . htmlspecialchars($row['Web_ID'] ?? '') . '" onclick="return confirm(\'Are you sure you want to delete this entry?\')">Delete</a>';

								if (!empty($row['Web_SecretCode'])) {
									$safeSecret = htmlspecialchars($row['Web_SecretCode'], ENT_QUOTES);
									echo ' | <button onclick="show2FACode(\'' . $safeSecret . '\')" title="Generate 2FA Code">2FA</button>';
								}

							echo '</td>';

                            echo '<td>' . htmlspecialchars($row['Web_Date_Created'] ?? '') . '</td>';
                            echo '<td>' . htmlspecialchars($row['Web_Date_Edited'] ?? '') . '</td>';

                            echo '</tr>';
                            
                        }
                        ?>
                    </table>
                <?php elseif ($type == 'banks'): ?>
                    <h2>Bank Details</h2>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Bank Name</th>
                            <th>Card Number</th>
                            <th>Valid Thru</th>
                          
                            <th>CVV</th>
                            <th>Card Type</th>
                           
                            <th>Actions</th>
                            <th>Date Created</th>
                            <th>Date Edited</th>
                        </tr>
                        <?php
                        $banks = getItems($con, 'banks', $items_per_page, $offset);                        
                        foreach ($banks as $row) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['Bank_ID'] ?? '') . '</td>';
                            echo '<td class="copycell">' . htmlspecialchars($row['Bank_Name'] ?? '') . '</td>';
                            echo '<td class="copycell">' . htmlspecialchars(decryptData($row['Bank_CardNum'] ?? '')) . '</td>';
                            echo '<td class="copycell">' . htmlspecialchars($row['Bank_ValidThru'] ?? '') . '</td>';
                           
                            echo '<td class="copycell">' . htmlspecialchars(decryptData($row['Bank_Cvv'] ?? '')) . '</td>';
                            echo '<td>' . htmlspecialchars($row['Bank_CardType'] ?? '') . '</td>';
                           
                            echo '<td>
                                    <a href="edit_bank.php?id=' . htmlspecialchars($row['Bank_ID'] ?? '') . '">Edit</a> | 
                                    <a href="delete_bank.php?id=' . htmlspecialchars($row['Bank_ID'] ?? '') . '" onclick="return confirm(\'Are you sure you want to delete this entry?\')">Delete</a>
                                  </td>';
                            echo '<td>' . htmlspecialchars($row['Bank_Date_Created'] ?? '') . '</td>';
                            echo '<td>' . htmlspecialchars($row['Bank_Date_Edited'] ?? '') . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </table>
            <?php endif; ?>
            </div>
        <?php else: ?>
            <form action="vault.php" method="post">
                <input type="password" name="password" placeholder="Enter your password to unlock" required autofocus><br>
                <input type="hidden" name="type" value="<?= htmlspecialchars($_GET['type']) ?>">
                <input type="hidden" name="page" value="<?= htmlspecialchars($page) ?>">
                <button type="submit" name="unlock">Unlock</button>
            </form>
        <?php endif; ?>
    </div>
    <?php include 'footer.php'; ?>	
	
	<script>
	document.addEventListener('DOMContentLoaded', () => {
	  document.querySelectorAll('td.copycell').forEach(cell => {
		cell.style.cursor = 'pointer';
		cell.title = 'Click to copy';
		cell.addEventListener('click', () => {
		  const text = cell.textContent.trim();
		  navigator.clipboard.writeText(text).then(() => {
			cell.style.backgroundColor = '#d4edda'; // flash green
			setTimeout(() => cell.style.backgroundColor = '', 500);
		  });
		});
	  });
	});
	</script>

</body>
</html>

