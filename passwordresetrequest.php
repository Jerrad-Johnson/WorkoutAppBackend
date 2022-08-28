<?php
session_start();
include "./utilities/standardizedResponse.php";
include "./connect.php";
include "./utilities/getUID.php";

$email = json_decode(file_get_contents('php://input'));

    try {
        $stmt = $conn->prepare("SELECT email, id FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $userdata = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        standardizedResponse($e->getMessage());
    }

    if (empty($userdata)){
        standardizedResponse("Cannot find any users with that e-mail address.");
        return;
    }

if ($email === $userdata['email']){
    $randomString = generateRandomString();
    $hash = password_hash($randomString, PASSWORD_DEFAULT);
    try {
        $stmt = $conn->prepare("INSERT INTO passwordresetkeys (user_id, hash) VALUES (:uid, :hash)");
        $stmt->bindParam(":uid", $userdata['id']);
        $stmt->bindParam(":hash", $hash);
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

?>