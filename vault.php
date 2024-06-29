<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

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

$showData = false;
$type = '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 7;
$offset = ($page - 1) * $items_per_page;

if (isset($_SESSION['unlock'])) {
    $showData = true;
    $type = $_GET['type'];
    //unset($_SESSION['unlock']);
}

if (isset($_GET['unlock'])) {
    $password = sha1($_SESSION['username'] . ':' . $_GET['password']);

    $user = getUserByUsernameAndPassword($con, $_SESSION['username'], $password);

    if ($user) {
        $_SESSION['unlock'] = true;
        $type = $_GET['type'];
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
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#search').on('input', function() {
                var searchQuery = $(this).val();
                var type = '<?= $type ?>';
                $.ajax({
                    url: 'search_vault.php',
                    method: 'GET',
                    data: { query: searchQuery, type: type },
                    success: function(response) {
                        $('#results').html(response);
                    }
                });
            });
        });
    </script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #2d2d2d;
            color: #f5f5f5;
            font-size: 14px; /* Adjust the font size */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #4b4b4b;
            text-align: left;
        }

        table th {
            background-color: #4b4b4b;
            color: #d6d4e0;
        }

        table tr:nth-child(even) {
            background-color: #3d3d3d;
        }

        table tr:hover {
            background-color: #555555;
        }

        .button-link {
            text-decoration: none;
            color: #fff;
            background-color: #5b9aa0;
            padding: 10px 20px;
            margin: 5px;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-size: 16px;
            display: inline-block;
        }

        .button-link:hover {
            background-color: #d6d4e0;
            color: #622569;
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .button-link:active {
            transform: scale(1);
            box-shadow: none;
        }
    </style>
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
            <input type="text" id="search" placeholder="Search...">
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="vault.php?type=<?= $type ?>&page=<?= $page - 1 ?>" class="button-link">Prev</a>
                <?php endif; ?>
                <a href="index.php" class="button-link">Menu</a>
                <?php if ($page < $total_pages): ?>
                    <a href="vault.php?type=<?= $type ?>&page=<?= $page + 1 ?>" class="button-link">Next</a>
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
							echo '<td>' . htmlspecialchars($row['Web_Address'] ?? '') . '</td>';
							echo '<td>' . htmlspecialchars($row['Web_Name'] ?? '') . '</td>';
							echo '<td>' . htmlspecialchars($row['Web_Login'] ?? '') . '</td>';
							echo '<td>' . htmlspecialchars(decryptData($row['Web_Password'] ?? '')) . '</td>';
							echo '<td>
									<a href="edit_website.php?id=' . htmlspecialchars($row['Web_ID'] ?? '') . '">Edit</a> | 
									<a href="delete_website.php?id=' . htmlspecialchars($row['Web_ID'] ?? '') . '" onclick="return confirm(\'Are you sure you want to delete this entry?\')">Delete</a>
								  </td>';
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
                            <th>Card Holder</th>
                            <th>CVV</th>
                            <th>Card Type</th>
                                                        <th>PIN</th>
                            <th>Actions</th>
                            <th>Date Created</th>
                            <th>Date Edited</th>
                        </tr>
                        <?php
                        $banks = getItems($con, 'banks', $items_per_page, $offset);                        
						foreach ($banks as $row) {
							echo '<tr>';
							echo '<td>' . htmlspecialchars($row['Bank_ID'] ?? '') . '</td>';
							echo '<td>' . htmlspecialchars($row['Bank_Name'] ?? '') . '</td>';
							echo '<td>' . htmlspecialchars(decryptData($row['Bank_CardNum'] ?? '')) . '</td>';
							echo '<td>' . htmlspecialchars($row['Bank_ValidThru'] ?? '') . '</td>';
							echo '<td>' . htmlspecialchars($row['Bank_CardHolder'] ?? '') . '</td>';
							echo '<td>' . htmlspecialchars(decryptData($row['Bank_Cvv'] ?? '')) . '</td>';
							echo '<td>' . htmlspecialchars($row['Bank_CardType'] ?? '') . '</td>';
							echo '<td>' . htmlspecialchars(decryptData($row['Bank_Pin'] ?? '')) . '</td>';
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
            <form action="vault.php" method="get">
                <input type="password" name="password" placeholder="Enter your password to unlock" required autofocus><br>
                <input type="hidden" name="type" value="<?= htmlspecialchars($_GET['type']) ?>">
                <button type="submit" name="unlock">Unlock</button>
            </form>
        <?php endif; ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>

