<?php
session_start();
include "./utilities/standardizedResponse.php";
include "./connect.php";
include "./utilities/getUID.php";

$uid = getUID();
$email = json_decode(file_get_contents('php://input'));

if ($uid !== false) {
    try {
        $stmt = $conn->prepare("SELECT email FROM users WHERE user_id = :uid");
        $stmt->bindParam(":uid", $uid);
        $stmt->execute();
        $databaseEmail = $stmt->fetchColumn();
    } catch (Exception $e) {
        standardizedResponse($e->getMessage());
    }
} else {
    standardizedResponse("Cannot find any users with that e-mail address.");
}

if ($email === $databaseEmail){
    $randomString = generateRandomString();
    $hash = password_hash($randomString);
    try {
        $stmt = $conn->prepare("INSERT INTO passwordresetkeys (user_id, hash) VALUES (:uid, :hash)");
        $stmt->bindParam(":uid", $uid);
        $stmt->bindParam(":hash", $hash);
        $stmt->execute();
        $databaseEmail = $stmt->fetchColumn();
    } catch (Exception $e) {
        standardizedResponse($e->getMessage());
    }
} else {
    standardizedResponse("Cannot find user; try logging in again.");
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