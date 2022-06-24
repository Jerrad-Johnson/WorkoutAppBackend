<html>
<body style="color: #999">

<?php
session_start();
include "./connect.php";
include "./utilities/getUID.php";

$placeholder = array(
    "date" => "2022-02-02",
    "bodyweight" => 145,
    "user_measurements" => 34.02,
    "user_stats" => "Chest"
);


$uid = getUID();

if ($uid !== false) {
    try {
        $stmt = $conn->prepare("INSERT INTO bodystats (user_id, entry_date, body_weight, user_defined_measurement, user_defined_stat)
            VALUES (:uid, :entry_date, :bodyweight, :user_measurement, :user_stat)");
        $stmt->bindParam(":uid", $uid);
        $stmt->bindParam(":entry_date", $placeholder['date']);
        $stmt->bindParam(":bodyweight", $placeholder['bodyweight']);
        $stmt->bindParam(":user_measurement", $placeholder['user_measurements']);
        $stmt->bindParam(":user_stat", $placeholder['user_stats']);
        $stmt->execute();
        echo "success";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    echo "Cannot find user; try logging in again.";
}


?>
</body>
</html>