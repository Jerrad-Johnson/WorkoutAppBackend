<?php
session_start();
include "./utilities/standardizedResponse.php";
include "./connect.php";
include "./utilities/getUID.php";
include "./utilities/replyAfterQueries.php";

$uid = getUID();
$sessionToFind = json_decode(file_get_contents('php://input'));

if ($uid !== false){
    try {
        $stmt = $conn->prepare("SELECT DISTINCT session_date, session_title FROM sessions WHERE session_date BETWEEN NOW() - INTERVAL 365 DAY AND NOW()");
        $stmt->execute();
        standardizedResponse($stmt->fetchAll(PDO::FETCH_COLUMN););
    } catch (Exception $e){
        standardizedResponse($e->getMessage());
    }
}
        /*$stmt = $conn->prepare("SELECT DISTINCT session_date, session_title FROM sessions WHERE user_id = :id AND YEAR(session_date) = YEAR(:selectedYear)");*/
