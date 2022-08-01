<?php
session_start();
include "./connect.php";
include "./utilities/getUID.php";
include "./utilities/standardizedResponse.php";

$passwords = json_decode(file_get_contents('php://input'));
$uid = getUID();
$oldPasswordFromFrontendHashed = password_hash($passwords->oldPassword);

if ($uid !== false) {
    try {
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = :uid");
        $stmt->bindParam(':uid', $uid);
        $stmt->execute();
        $hashedOldPWFromDB = $stmt->fetch();
    } catch (Exception $e) {
        standardizedResponse($e->getMessage());
    }

    if (password_verify($hashedOldPWFromDB) === password_verify($oldPasswordFromFrontendHashed)) {
        try {
            $newPasswordHashed = password_hash($passwords->newPassword);
            $stmt = $conn->prepare("UPDATE users SET password = :newPasswordHashed WHERE id = :uid");
            $stmt->bindParam(':uid', $uid);
            $stmt->bindParam(':newPasswordHashed', $newPasswordHashed);
            $stmt->execute();
            $oldPassword = $stmt->fetch();
            standardizedResponse("Password updated");
        } catch (Exception $e) {
            standardizedResponse($e->getMessage());
        }
    } else {
        standardizedResponse("Wrong password");
    }
}

?>