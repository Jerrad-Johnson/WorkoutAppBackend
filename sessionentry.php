<html>
<body style="color: #999">

<?php
session_start();
include "./connect.php";
include "./supplemental/checkAuthentication.php";

$placeholder = array(
    array(
        "date" => "2022-02-02",
        "title" => "Upper Body",
        "exercise" => "Chest Press",
        "weightLifted" => array(150, 150, 150, 150),
        "reps" => array(10, 10, 10, 10)
    ),
    array(
        "date" => "2022-02-02",
        "title" => "Upper Body",
        "exercise" => "Bicep Curl",
        "weightLifted" => array(30, 30, 30),
        "reps" => array(5, 5, 5,)
    )
);


if (checkAuth() && $_SESSION['username']){
    try {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->bindParam(':username', $_SESSION['username']);
        $stmt->execute();
        $idResults = $stmt->fetch();
        //echo $idResults['id'];
    } catch (PDOException $e){
        echo $e->getMessage();
    }
} else {
    echo "Not logged in.";
}


if($idResults['id']){
    foreach ($placeholder as $entry){
        $repsAsString = implode(",", $entry['reps']);
        $weightLiftedAsString = implode(",", $entry['weightLifted']);
                try {
            $stmt = $conn->prepare("INSERT INTO sessions (user_id, session_date, session_title, exercise, weight_lifted, reps) 
                VALUES (:user, :date, :title, :exercise, :weight_lifted, :reps)");
            $stmt->bindParam(':user', $idResults['id']);
            $stmt->bindParam(':date', $entry['date']);
            $stmt->bindParam(':title', $entry['title']);
            $stmt->bindParam(':exercise', $entry['exercise']);
            $stmt->bindParam(':weight_lifted', $weightLiftedAsString);
            $stmt->bindParam(':reps', $repsAsString);
            $stmt->execute();
            echo "Success";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
} else {
    echo "Cannot find user; try logging in again.";
}


?>
</body>
</html>