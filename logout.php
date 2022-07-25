<?php
session_start();
include "./utilities/standardizedResponse.php";

try {
    if (!isset($_SESSION['username'])){
        $data["loggedout"] = "true";
        return standardizedResponse("Already logged out.", $data);
    }

    $_SESSION['authenticated'] = false;
    $_SESSION['username'] = null;

    if ($_SESSION['username'] === null) {
        $data["loggedout"] = "true";
        return standardizedResponse("Logged out.", $data);
    }
} catch (Exception $e) {
    echo $e;
}
?>

