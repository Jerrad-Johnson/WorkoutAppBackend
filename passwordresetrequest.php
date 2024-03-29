<?php
session_start();
include "./utilities/standardizedResponse.php";
include "./connect.php";
include "./utilities/getUID.php";
include "sendgridKey.php";
require 'vendor/autoload.php';

$emailAddress = json_decode(file_get_contents('php://input'));

    try {
        $stmt = $conn->prepare("SELECT email, id FROM users WHERE email = :email");
        $stmt->bindParam(":email", $emailAddress);
        $stmt->execute();
        $userdata = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        standardizedResponse($e->getMessage());
    }

    if (empty($userdata)){
        standardizedResponse("Cannot find any users with that e-mail address.");
        return;
    }

if ($emailAddress === $userdata['email']){
    $randomString = generateRandomString();
    try {
        $stmt = $conn->prepare("INSERT INTO password_reset_keys (user_id, reset_key) VALUES (:uid, :hash)");
        $stmt->bindParam(":uid", $userdata['id']);
        $stmt->bindParam(":hash", $randomString);
        $stmt->execute();
        $databaseEmail = $stmt->fetchColumn();
        standardizedResponse("Please check your e-mail for a link to reset your password.");
    } catch (Exception $e) {
        standardizedResponse($e->getMessage());
    }
} else {
    standardizedResponse("Cannot find user; try logging in again.");
    return;
}

function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$email = new \SendGrid\Mail\Mail();
$email->setFrom("j_johnson21@mail.fhsu.edu", "Jerrad Johnson");
$email->setSubject("Password Reset Link.");
$email->addTo($emailAddress, "Workout App User");
$email->addContent("text/plain", "Please visit https://workout.jerradjohnson.com/ResetCheck?resetKey=$randomString&email=$emailAddress to reset your password. This link is good for only 30 minutes.");
$email->addContent(
    "text/html", "<a href=\"https://workout.jerradjohnson.com/ResetCheck?resetKey=$randomString&email=$emailAddress\">Reset Password</a>. This link is good for only 30 minutes."
);
$sendgrid = new \SendGrid($sendgridKey);

try {
    $sendgrid->send($email);
} catch (Exception $e) {
    echo 'Caught exception: '. $e->getMessage() ."\n";
}

?>