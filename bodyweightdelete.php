<?php
session_start();
include "./connect.php";
include "./utilities/getUID.php";

$placeholder = array(
    "date" => "2022-02-02",
    "bodyweight" => 120
);

$uid = getUID();

if ($uid !== false) {
    try {
        $stmt = $conn->prepare("DELETE FROM bodystats 
            WHERE user_id = :uid AND entry_date = :entry_date AND body_weight = :bodyweight");
        $stmt->bindParam(":uid", $uid);
        $stmt->bindParam(":entry_date", $placeholder['date']);
        $stmt->bindParam(":bodyweight", $placeholder['bodyweight']);
        $stmt->execute();
        echo "Success";
    } catch (Exception $e) {
        echo json_encode($e->getMessage());
        return;
    }
} else {
    echo "Cannot find user; try logging in again.";
}

?>