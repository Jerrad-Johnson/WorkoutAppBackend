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
    standardizedResponse("Incorrect e-mail or reset key."); // It's actually the e-mail. This is to reduce the risk of account theft/stalking.
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
} catch (Exception $e) {
    standardizedResponse($e->getMessage());
    return;
}

try {
    $stmt = $conn->prepare("DELETE FROM password_reset_keys WHERE user_id = :uid");
    $stmt->bindParam(":uid", $uid);
    $stmt->execute();
} catch (Exception $e) {
    standardizedResponse($e->getMessage());
    return;
}

standardizedResponse("Password Changed.");

$email = new \SendGrid\Mail\Mail();
$email->setFrom("j_johnson21@mail.fhsu.edu", "Jerrad Johnson");
$email->setSubject("Password Reset Successful.");
$email->addTo($emailAddress, "Workout App User");
$email->addContent("text/plain", "Your password has been reset.");
$email->addContent(
    "text/html", "Your password has been reset."
);
$sendgrid = new \SendGrid($sendgridKey);

//TODO Send email