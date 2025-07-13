<?php
session_start();
if (!isset($_SESSION['user_id')) {
    header('Location: login.php');
    exit();
}

include 'includes/dbconnect.php';
include 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['import_file')) {
    $type = $_POST['type'];
    $xml = simplexml_load_file($_FILES['import_file']['tmp_name');

    if ($type == 'websites') {
        $stmt = $con->prepare('INSERT INTO websitedetails (Web_ID, Web_Address, Web_Name, Web_Login, Web_Password) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE Web_Address = VALUES(Web_Address), Web_Name = VALUES(Web_Name), Web_Login = VALUES(Web_Login), Web_Password = VALUES(Web_Password)');
    } elseif ($type == 'banks') {
        $stmt = $con->prepare('INSERT INTO bankdetails (Bank_ID, Bank_Name, Bank_CardNum, Bank_ValidThru, Bank_CardHolder, Bank_Cvv, Bank_CardType, Bank_Pin) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE Bank_Name = VALUES(Bank_Name), Bank_CardNum = VALUES(Bank_CardNum), Bank_ValidThru = VALUES(Bank_ValidThru), Bank_CardHolder = VALUES(Bank_CardHolder), Bank_Cvv = VALUES(Bank_Cvv), Bank_CardType = VALUES(Bank_CardType), Bank_Pin = VALUES(Bank_Pin)');
    } else {
        die('Invalid type');
    }

    foreach ($xml as $item) {
        if ($type == 'websites') {
            $stmt->execute($item->Web_ID, $item->Web_Address, $item->Web_Name, $item->Web_Login, $item->Web_Password);
        } elseif ($type == 'banks') {
            $stmt->execute($item->Bank_ID, $item->Bank_Name, $item->Bank_CardNum, $item->Bank_ValidThru, $item->Bank_CardHolder, $item->Bank_Cvv, $item->Bank_CardType, $item->Bank_Pin);
        }
    }

    $_SESSION['success'] = ucfirst($type) . ' imported successfully!';
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Data - VIOLET</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Import Data</h1>
        <form action="import.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="type" value="<?= htmlspecialchars($_GET['type'); ?>">
            <input type="file" name="import_file" required><br>
            <button type="submit">Import</button>
        </form>
        <p><a href="index.php">Back to Home</a></p>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
