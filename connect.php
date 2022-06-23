<?php
$servername = "localhost";
$username = "workoutappadmin";
$password = "r12m6c5IK0jz92Q2lHz";
$db = "workoutapp";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected";
} catch(PDOException $e) {
    $_POST[json_encode("Failed" . $e->getMessage())];
    //echo "Connection failed: " . $e->getMessage();
}

?>