<?php

session_start();
include "./utilities/standardizedResponse.php";
include "./connect.php";
include "./utilities/getUID.php";
include "./utilities/replyAfterQueries.php";

$uid = getUID();
$sessionToFind = json_decode(file_get_contents('php://input'));

if ($uid !== false) {
    try {
        $stmt = $conn->prepare("SELECT session_date, session_title FROM sessions 
            WHERE user_id = :uid");
        $stmt->bindParam(":uid", $uid);
        $stmt->execute();
        standardizedResponse("Success", $stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        standardizedResponse($e->getMessage());
    }
}

?>