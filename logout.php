<?php
session_start();
include "./utilities/standardizedResponse.php";

if ($_SESSION['username'] === null) {
    $data["loggedout"] = "true";
    return standardizedResponse("Already logged out.", $data);
}

$_SESSION['authenticated'] = false;
$_SESSION['username'] = null;

if ($_SESSION['username'] === null) {
    $data["loggedout"] = "true";
    return standardizedResponse("Logged out.", $data);
}

?>

