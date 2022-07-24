<?php
session_start();
include "./utilities/standardizedResponse.php";
include "./connect.php";
include "./utilities/getUID.php";
include "./utilities/replyAfterQueries.php";

$exercise = json_decode(file_get_contents('php://input'));
$uid = getUID();


if ($uid !== false) {
    try {
        $stmt = $conn->prepare("DELETE FROM exercises WHERE exercise = :exercise AND user_id = :uid");
        $stmt->bindParam(':exercise', $exercise);
        $stmt->bindParam(':uid', $uid);
        $stmt->execute();
        standardizedResponse("Success");
    } catch (Exception $e) {
        standardizedResponse($e->getMessage());
        return;
    }
}

?>