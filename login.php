<html>
<body style="color: #999">

<?php
include "./connect.php";
?>

<br />

<?php

$placeholder = array(
    "password" => "abc2",
    "username" => "elseif",
);

try {
    $stmt = $conn->prepare("SELECT password, username FROM users WHERE username = :username");
    $stmt->bindParam(':username', $placeholder['username']);
    $stmt->execute();
    $results = $stmt->fetch();

    if (password_verify($placeholder['password'], $results['password'])){
        echo "success";
    } else {
        echo "wrong password";
    }

} catch (PDOException $e){
    echo $e->getMessage();
}

?>

</body>
</html>