<?php

session_start();
include "./utilities/standardizedResponse.php";
include "./connect.php";
include "./utilities/getUID.php";
include "sendgridKey.php";
require 'vendor/autoload.php';

$userData = json_decode(file_get_contents('php://input'));

try {
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->bindParam(":email", $userData->email);
    $stmt->execute();
    $uid = $stmt->fetchColumn();
} catch (Exception $e) {
    standardizedResponse($e->getMessage());
}

if (empty($uid)) {
    standardizedResponse("Cannot find any users with that e-mail address.");
    return;
}

try {
    $stmt = $conn->prepare("SELECT reset_key, UNIX_TIMESTAMP(creation_date) FROM password_reset_keys WHERE user_id = :uid AND reset_key = :resetKey");
    $stmt->bindParam(":uid", $uid);
    $stmt->bindParam(":resetKey", $userData->resetKey);
    $stmt->execute();
    $matchingEntry = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    standardizedResponse($e->getMessage());
}


if (empty($matchingEntry)) {
    standardizedResponse("Cannot find an existing password reset request. Please do that first.");
    return;
}

$databaseTime = $matchingEntry["UNIX_TIMESTAMP(creation_date)"];
$currentTime = time();
$timeCompared = ($currentTime/3600) - ($databaseTime/3600);

if ($timeCompared > 0.5){
    standardizedResponse("Key expired, please send a new password reset request.");
    return;
}

$hash = password_hash($userData->newPassword, PASSWORD_DEFAULT);

try {
    $stmt = $conn->prepare("UPDATE users SET password = :hash WHERE id = :uid");
    $stmt->bindParam(":uid", $uid);
    $stmt->bindParam(":hash", $hash);
    $stmt->execute();
    standardizedResponse("Password Changed.");
} catch (Exception $e) {
    standardizedResponse($e->getMessage());
}