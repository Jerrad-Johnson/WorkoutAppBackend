<?php
session_start();
include "./connect.php";
include "./utilities/getUID.php";

$placeholder = array(
    "date" => "2022-02-02",
);

$uid = getUID();

if ($uid !== false) {
    try {
        $stmt = $conn->prepare("DELETE FROM sessions WHERE session_date = :date AND user_id = :uid");
        $stmt->bindParam(':date', $placeholder['date']);
        $stmt->bindParam(':uid', $uid);
        $stmt->execute();
        echo "Success";
    } catch (Exception $e) {
        echo json_encode($e->getMessage());
        return;
    }
}

?>