<?php
session_start();
include "./utilities/standardizedResponse.php";
include "./utilities/checkAuthentication.php";
include "./connect.php";

$entry = json_decode(file_get_contents('php://input'));

if (!checkAuth()){
    try {
        $stmt = $conn->prepare("SELECT username FROM users WHERE username = :username");
        $stmt->bindParam(':username', $entry->username);
        $stmt->execute();
        $username = $stmt->fetchColumn();
        if (!$username) {
            standardizedResponse("Username not found.");
            return;
        }
    } catch (Exception $e) {
        standardizedResponse($e->getMessage());
    }

    try {
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = :username");
        $stmt->bindParam(':username', $entry->username);
        $stmt->execute();
        $passwordFromDB = $stmt->fetchColumn();

        if (password_verify($entry->password, $passwordFromDB)){
            $_SESSION['authenticated'] = true;
            $_SESSION['username'] = $entry->username;
            standardizedResponse("Correct password.");
        } else {
            standardizedResponse("Wrong password.");
        }
    } catch (Exception $e){
        standardizedResponse($e->getMessage());
        return;
    }
} else {
    standardizedResponse("Already logged in.");
}

?>
