<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'includes/dbconnect.php';
include 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];

    if ($type == 'websites') {
        $stmt = $con->prepare('SELECT * FROM websitedetails');
    } elseif ($type == 'banks') {
        $stmt = $con->prepare('SELECT * FROM bankdetails');
    } else {
        die('Invalid type');
    }

    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $filename = $type . '_backup_' . date('Y-m-d') . '.xml';
    header('Content-Type: application/xml');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    $xml = new SimpleXMLElement('<root/>');
    array_walk_recursive($data, array ($xml, 'addChild'));
    print $xml->asXML();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Data - VIOLET</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Export Data</h1>
        <form action="export.php" method="post">
            <label for="type">Select data type to export:</label>
            <select name="type" id="type" required>
                <option value="websites">Websites</option>
                <option value="banks">Banks</option>
            </select><br><br>
            <button type="submit">Export</button>
        </form>
        <p><a href="index.php">Back to Home</a></p>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
