<html>
<body style="color: #999">

<?php
include "./connect.php";
?>

<br />

<?php
session_start();
include "./utilities/checkAuthentication.php";

$placeholder = array(
    "password" => "abc",
    "username" => "elseif",
);

if (!checkAuth()){
    try {
        $stmt = $conn->prepare("SELECT password, username FROM users WHERE username = :username");
        $stmt->bindParam(':username', $placeholder['username']);
        $stmt->execute();
        $results = $stmt->fetch();

        if (password_verify($placeholder['password'], $results['password'])){
            $_SESSION['authenticated'] = true;
            $_SESSION['username'] = $placeholder['username'];
            echo "Correct password.";
        } else {
            echo "Wrong password.";
        }

    } catch (PDOException $e){
        echo $e->getMessage();
    }
} else {
    echo "Already logged in.";
}

?>

</body>
</html>