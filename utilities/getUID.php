<?php
include "checkAuthentication.php";

function getUID(){
    include "../php/connect.php";
    if (checkAuth() && $_SESSION['username']){
        try {
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username");
            $test = $stmt->bindParam(':username', $_SESSION['username']);
            $stmt->execute();
            $idResult = $stmt->fetch();
            return $idResult['id'];
        } catch (Exception $e){
            echo json_encode($e->getMessage());
            return;
        }
    } else {
        return false;
    }
}

?>
