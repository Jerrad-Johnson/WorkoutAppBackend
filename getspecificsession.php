<?php
session_start();
include "./utilities/standardizedResponse.php";
include "./connect.php";
include "./utilities/getUID.php";
include "./utilities/replyAfterQueries.php";

$uid = getUID();
$sessionToFind = json_decode(file_get_contents('php://input'));
echo $sessionToFind;

if ($uid !== false){
    try {
        $stmt = $conn->prepare("SELECT session_date, session_title, exercise, weight_lifted, reps FROM sessions 
            WHERE user_id = :uid AND session_date = :session_date AND session_title = :session_title");
        $stmt->bindParam(":uid", $uid);
        $stmt->bindParam(":session_date", $sessionToFind->date);
        $stmt->bindParam(":session_title", $sessionToFind->title);
        $stmt->execute();
        standardizedResponse("Success", $stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e){
        standardizedResponse($e->getMessage());
    }
}

?>