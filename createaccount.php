<?php
include "./connect.php";
?>

<br />

<?php

$placeholder = array(
    "password" => "abc",
    "username" => "elseif",
    "email" => "j_johnson21@mail.fhsu.edu"
);

$hash = password_hash($placeholder['password'], PASSWORD_DEFAULT);

try {
    $sth = $conn->prepare("INSERT INTO users (username, password, email) VALUES(:user, :pass, :email)");
    $sth->bindParam(':user', $placeholder['username']);
    $sth->bindParam(':pass', $hash);
    $sth->bindParam(':email', $placeholder['email']);
    $sth->execute();
    echo $sth->fetch();
    echo "Success";
} catch(Exception $e){
    echo json_encode($e->getMessage());
    return;
}
$conn = null;

?>