<?php
session_start();
include "./utilities/standardizedResponse.php";
include "./connect.php";
include "./utilities/getUID.php";
include "./utilities/replyAfterQueries.php";

$uid = getUID();
$exercise = json_decode(file_get_contents('php://input'));

if ($uid !== false){
    try {
        $stmt = $conn->prepare("SELECT session_date, session_title, exercise, weight_lifted, reps FROM sessions WHERE user_id = :uid AND exercise = :exercise");
        $stmt->bindParam(":uid", $uid);
        $stmt->bindParam(":exercise", $exercise);
        $stmt->execute();
        standardizedResponse("Success", $stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e){
        standardizedResponse($e->getMessage());
    }
}

?>