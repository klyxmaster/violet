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
 
define('ENCRYPTION_KEY', 'your-secret-key'); // Replace with your own secret key

function encryptData($data) {
    $key = hash('sha256', ENCRYPTION_KEY);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encryptedData . '::' . $iv);
}

function decryptData($data) {
    $key = hash('sha256', ENCRYPTION_KEY);
    list($encryptedData, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
}

function getUserByUsernameAndPassword($con, $username, $password) {
    $stmt = $con->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
    $stmt->execute([$username, $password]);
    return $stmt->fetch();
}

function addUser($con, $username, $email, $password, $create_datetime) {
    $stmt = $con->prepare('INSERT INTO users (username, email, password, create_datetime) VALUES (?, ?, ?, ?)');
    $stmt->execute([$username, $email, $password, $create_datetime]);
}

function addWebsite($con, $address, $sitename, $login, $password) {
    $encryptedPassword = encryptData($password);
    $stmt = $con->prepare('INSERT INTO websitedetails (Web_Address, Web_Name, Web_Login, Web_Password) VALUES (?, ?, ?, ?)');
    $stmt->execute([$address, $sitename, $login, $encryptedPassword]);
}

function updateWebsite($con, $id, $address, $sitename, $login, $password) {
    $encryptedPassword = encryptData($password);
    $stmt = $con->prepare('UPDATE websitedetails SET Web_Address = ?, Web_Name = ?, Web_Login = ?, Web_Password = ? WHERE Web_ID = ?');
    $stmt->execute([$address, $sitename, $login, $encryptedPassword, $id]);
}

function getWebsiteById($con, $id) {
    $stmt = $con->prepare('SELECT * FROM websitedetails WHERE Web_ID = ?');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addBank($con, $bankname, $cardnum, $validthru, $cardholder, $cvv, $cardtype, $pin) {
    $encryptedCardNum = encryptData($cardnum);
    $encryptedCvv = encryptData($cvv);
    $encryptedPin = encryptData($pin);
    $stmt = $con->prepare('INSERT INTO bankdetails (Bank_Name, Bank_CardNum, Bank_ValidThru, Bank_CardHolder, Bank_Cvv, Bank_CardType, Bank_Pin) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$bankname, $encryptedCardNum, $validthru, $cardholder, $encryptedCvv, $cardtype, $encryptedPin]);
}

function updateBank($con, $id, $bankname, $cardnum, $validthru, $cardholder, $cvv, $cardtype, $pin) {
    $encryptedCardNum = encryptData($cardnum);
    $encryptedCvv = encryptData($cvv);
    $encryptedPin = encryptData($pin);
    $stmt = $con->prepare('UPDATE bankdetails SET Bank_Name = ?, Bank_CardNum = ?, Bank_ValidThru = ?, Bank_CardHolder = ?, Bank_Cvv = ?, Bank_CardType = ?, Bank_Pin = ? WHERE Bank_ID = ?');
    $stmt->execute([$bankname, $encryptedCardNum, $validthru, $cardholder, $encryptedCvv, $cardtype, $encryptedPin, $id]);
}

function getBankById($con, $id) {
    $stmt = $con->prepare('SELECT * FROM bankdetails WHERE Bank_ID = ?');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function deleteWebsite($con, $id) {
    $stmt = $con->prepare('DELETE FROM websitedetails WHERE Web_ID = ?');
    $stmt->execute([$id]);
}

function deleteBank($con, $id) {
    $stmt = $con->prepare('DELETE FROM bankdetails WHERE Bank_ID = ?');
    $stmt->execute([$id]);
}
?>
