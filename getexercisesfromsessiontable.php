<?php
session_start();
include "./utilities/standardizedResponse.php";
include "./connect.php";
include "./utilities/getUID.php";
include "./utilities/replyAfterQueries.php";

$uid = getUID();

if ($uid !== false){
    try {
        $stmt = $conn->prepare("SELECT DISTINCT exercise FROM sessions WHERE user_id = :uid");
        $stmt->bindParam(":uid", $uid);
        $stmt->execute();
        standardizedResponse("Success", $stmt->fetchAll(PDO::FETCH_COLUMN));
    } catch (Exception $e){
        standardizedResponse($e->getMessage());
    }
}

?>