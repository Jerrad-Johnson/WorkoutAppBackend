<?php
session_start();
include "./utilities/standardizedResponse.php";

if ($_SESSION['username'] !== null){
    $data["loggedin"] = true;
    standardizedResponse("Already logged in.", $data);
} else {
    $data["loggedin"] = false;
    standardizedResponse("Not logged in.", $data);
}
?>
