<?php
include "./connect.php";
include "./utilities/standardizedResponse.php";

$entry = json_decode(file_get_contents('php://input'));

$hashedPassword = password_hash($entry->password, PASSWORD_DEFAULT);

try {
    $sth = $conn->prepare("INSERT INTO users (username, password, email) VALUES(:user, :pass, :email)");
    $sth->bindParam(':user', $entry->username);
    $sth->bindParam(':pass', $hashedPassword);
    $sth->bindParam(':email', $entry->email);
    $sth->execute();
    //echo $sth->fetch();
    standardizedResponse("Success");
} catch(Exception $e){
    standardizedResponse($e->getMessage());
    return;
}
$conn = null;

?>