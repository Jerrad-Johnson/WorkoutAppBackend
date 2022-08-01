<?php
session_start();
include "./connect.php";
include "./utilities/getUID.php";
include "./utilities/standardizedResponse.php";

$email = json_decode(file_get_contents('php://input'));
$uid = getUID();

if ($uid !== false){
    try {
        $stmt = $conn->prepare("UPDATE users SET email = :newEmail WHERE id = :uid");
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':newEmail', $email->newEmailAddress);
        $stmt->execute();
        $oldPassword = $stmt->fetch();
        standardizedResponse("E-mail updated.");
    } catch (Exception $e) {
        standardizedResponse($e->getMessage());
    }
} else {
    standardizedResponse("Not logged in.");
}

?>