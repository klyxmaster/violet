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

function encryptData($data) {
    $key = hash('sha256', ENCRYPTION_KEY, true); // use raw binary
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($encryptedData . '::' . $iv);
}


function decryptData($data) {
    $key = hash('sha256', ENCRYPTION_KEY, true); // use raw binary

    $decoded = base64_decode($data, true);
    if ($decoded === false) return null;

    $parts = explode('::', $decoded);
    if (count($parts) !== 2) return null;

    list($encryptedData, $iv) = $parts;

    return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
}


function getUserByUsernameAndPassword($con, $username, $password) {
    $stmt = $con->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
    $stmt->execute([$username, $password]);
    return $stmt->fetch();
}

function addUser($con, $username, $email, $password, $create_datetime) {
    $stmt = $con->prepare('INSERT INTO users (username, email, password, create_datetime) VALUES (?, ?, ?, ?)');
    $stmt->execute($username, $email, $password, $create_datetime);
}

function addWebsite($con, $address, $sitename, $login, $password, $secretCode) {
    $encryptedPassword = encryptData($password);
    $date_created = date('Y-m-d H:i:s');
    $date_edited = $date_created; // Same as creation time
    $stmt = $con->prepare('INSERT INTO websitedetails (Web_Address, Web_Name, Web_Login, Web_Password, Web_SecretCode, Web_Date_Created, Web_Date_Edited) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute($address, $sitename, $login, $encryptedPassword, $secretCode, $date_created, $date_edited);
}

function updateWebsite($con, $id, $address, $sitename, $login, $password, $secretCode) {
    $encryptedPassword = encryptData($password);
    $date_edited = date('Y-m-d H:i:s');
    $stmt = $con->prepare('UPDATE websitedetails SET Web_Address = ?, Web_Name = ?, Web_Login = ?, Web_Password = ?, Web_SecretCode = ?, Web_Date_Edited = ? WHERE Web_ID = ?');
    $stmt->execute([$address, $sitename, $login, $encryptedPassword, $secretCode, $date_edited, $id]);
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
    $date_created = date('Y-m-d H:i:s');
    $date_edited = $date_created; // Same as creation time
    $stmt = $con->prepare('INSERT INTO bankdetails (Bank_Name, Bank_CardNum, Bank_ValidThru, Bank_CardHolder, Bank_Cvv, Bank_CardType, Bank_Pin, Bank_Date_Created, Bank_Date_Edited) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute($bankname, $encryptedCardNum, $validthru, $cardholder, $encryptedCvv, $cardtype, $encryptedPin, $date_created, $date_edited);
}


function updateBank($con, $id, $bankname, $cardnum, $validthru, $cvv, $cardtype) {
    $encryptedCardNum = encryptData($cardnum);
    $encryptedCvv = encryptData($cvv);
    
    $date_edited = date('Y-m-d H:i:s');
    $stmt = $con->prepare('UPDATE bankdetails SET Bank_Name = ?, Bank_CardNum = ?, Bank_ValidThru = ?, Bank_Cvv = ?, Bank_CardType = ?, Bank_Date_Edited = ? WHERE Bank_ID = ?');
    $stmt->execute([$bankname, $encryptedCardNum, $validthru,$encryptedCvv, $cardtype, $date_edited, $id]);
}


function getBankById($con, $id) {
    $stmt = $con->prepare('SELECT * FROM bankdetails WHERE Bank_ID = ?');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function deleteWebsite($con, $id) {
    $stmt = $con->prepare('DELETE FROM websitedetails WHERE Web_ID = ?');
    $stmt->execute($id);
}

function deleteBank($con, $id) {
    $stmt = $con->prepare('DELETE FROM bankdetails WHERE Bank_ID = ?');
    $stmt->execute($id);
}

function generate2FACodes($username, $count = 15) {
    //$codes = [];
    for ($i = 0; $i < $count; $i++) {
        $codes[] = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }
    return $codes;
}

function obfuscate2FACodes($codes) {
    return implode(',', array_map('base64_encode', $codes)); // Use base64_encode for obfuscation
}

function deobfuscate2FACodes($codes_str) {
    return array_map('base64_decode', explode(',', $codes_str)); // Use base64_decode for deobfuscation
}

function use2FACode($username, $code, $codes_str) {
    $codes = deobfuscate2FACodes($codes_str);
    if (($key = array_search($code, $codes)) !== false) {
        unset($codes,$key);
        return obfuscate2FACodes($codes);
    }
    return false;
}


function getTotalItems($con, $type) {
    if ($type == 'websites') {
        $stmt = $con->query('SELECT COUNT(*) FROM websitedetails');
    } else {
        $stmt = $con->query('SELECT COUNT(*) FROM bankdetails');
    }
    return $stmt->fetchColumn();
}

function getItems($con, $type, $limit, $offset) {
    if ($type == 'websites') {
        $stmt = $con->prepare("SELECT * FROM websitedetails ORDER BY Web_Name ASC LIMIT $limit OFFSET $offset");
    } else {
        $stmt = $con->prepare("SELECT * FROM bankdetails ORDER BY Bank_Name ASC LIMIT $limit OFFSET $offset");
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getItemsByType($con, $type, $limit, $offset) {
    if ($type === 'websites') {
        $stmt = $con->prepare('SELECT Web_ID as id, Web_Name as name, Web_Address as details FROM websitedetails LIMIT ? OFFSET ?');
    } else {
        $stmt = $con->prepare('SELECT Bank_ID as id, Bank_Name as name, Bank_CardNum as details FROM bankdetails LIMIT ? OFFSET ?');
    }
    $stmt->execute($limit, $offset);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}