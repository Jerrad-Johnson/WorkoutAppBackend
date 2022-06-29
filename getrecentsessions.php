<?php
session_start();
include "./utilities/standardizedResponse.php";
include "./connect.php";
include "./utilities/getUID.php";
include "./utilities/replyAfterQueries.php";

$uid = getUID();

if ($uid !== false){
    try {
        $stmt = $conn->prepare("SELECT DISTINCT session_date, session_title FROM sessions WHERE user_id = :uid 
            ORDER BY session_date DESC LIMIT 20");
        $stmt->bindParam(":uid", $uid);
        $stmt->execute();
        standardizedResponse("Success", $stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e){
        standardizedResponse($e->getMessage());
    }
}