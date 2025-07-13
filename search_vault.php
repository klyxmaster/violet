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
    exit('Unauthorized access');
}

include 'includes/config.php';
include 'includes/dbconnect.php';
include 'includes/functions.php';

if (isset($_GET['query') && isset($_GET['type')) {
    $query = $_GET['query'];
    $type = $_GET['type'];

    if ($type == 'websites') {
        $stmt = $con->prepare('SELECT * FROM websitedetails WHERE Web_Address LIKE ? OR Web_Name LIKE ? OR Web_Login LIKE ?');
        $stmt->execute('%' . $query . '%', '%' . $query . '%', '%' . $query . '%');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            echo '<h2>Website Details</h2>';
            echo '<table>';
            echo '<tr><th>ID</th><th>Address</th><th>Name</th><th>Login</th><th>Password</th><th>Actions</th></tr>';
            foreach ($results as $row) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['Web_ID') . '</td>';
                echo '<td>' . htmlspecialchars($row['Web_Address') . '</td>';
                echo '<td>' . htmlspecialchars($row['Web_Name') . '</td>';
                echo '<td>' . htmlspecialchars($row['Web_Login') . '</td>';
                echo '<td>' . htmlspecialchars(decryptData($row['Web_Password')) . '</td>';
                echo '<td>
                        <a href="edit_website.php?id=' . htmlspecialchars($row['Web_ID') . '">Edit</a> | 
                        <a href="delete_website.php?id=' . htmlspecialchars($row['Web_ID') . '" onclick="return confirm(\'Are you sure you want to delete this entry?\')">Delete</a>
                      </td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No results found.</p>';
        }
    } elseif ($type == 'banks') {
        $stmt = $con->prepare('SELECT * FROM bankdetails WHERE Bank_Name LIKE ? OR Bank_CardHolder LIKE ?');
        $stmt->execute('%' . $query . '%', '%' . $query . '%');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            echo '<h2>Bank Details</h2>';
            echo '<table>';
            echo '<tr><th>ID</th><th>Bank Name</th><th>Card Number</th><th>Valid Thru</th><th>Card Holder</th><th>CVV</th><th>Card Type</th><th>PIN</th><th>Actions</th></tr>';
            foreach ($results as $row) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['Bank_ID') . '</td>';
                echo '<td>' . htmlspecialchars($row['Bank_Name') . '</td>';
                echo '<td>' . htmlspecialchars(decryptData($row['Bank_CardNum')) . '</td>';
                echo '<td>' . htmlspecialchars($row['Bank_ValidThru') . '</td>';
                echo '<td>' . htmlspecialchars($row['Bank_CardHolder') . '</td>';
                echo '<td>' . htmlspecialchars(decryptData($row['Bank_Cvv')) . '</td>';
                echo '<td>' . htmlspecialchars($row['Bank_CardType') . '</td>';
                echo '<td>' . htmlspecialchars(decryptData($row['Bank_Pin')) . '</td>';
                echo '<td>
                        <a href="edit_bank.php?id=' . htmlspecialchars($row['Bank_ID') . '">Edit</a> | 
                        <a href="delete_bank.php?id=' . htmlspecialchars($row['Bank_ID') . '" onclick="return confirm(\'Are you sure you want to delete this entry?\')">Delete</a>
                      </td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No results found.</p>';
        }
    }
}
?>

