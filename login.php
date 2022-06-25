<?php
session_start();
include "./connect.php";
include "./utilities/checkAuthentication.php";

$entry = json_decode(file_get_contents('php://input'));

if (!checkAuth()){
    try {
        $stmt = $conn->prepare("SELECT password, username FROM users WHERE username = :username");
        $stmt->bindParam(':username', $entry->username);
        $stmt->execute();
        $results = $stmt->fetch();

        if (password_verify($entry->password, $results['password'])){
            $_SESSION['authenticated'] = true;
            $_SESSION['username'] = $entry->username;
            echo "Correct password.";
        } else {
            echo "Wrong password.";
        }

    } catch (Exception $e){
        echo json_encode($e->getMessage());
        return;
    }
} else {
    echo "Already logged in.";
}

?>
