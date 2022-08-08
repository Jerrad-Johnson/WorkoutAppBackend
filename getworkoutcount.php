<?php
session_start();
include "./utilities/standardizedResponse.php";
include "./connect.php";
include "./utilities/getUID.php";
include "./utilities/replyAfterQueries.php";

$uid = getUID();
$type = json_decode(file_get_contents('php://input'));

if ($uid === false) {
    standardizedResponse("Not logged in");
    return;
}

if ($type === "last365") {
    try {
        $stmt = $conn->prepare("SELECT DISTINCT session_date, session_title FROM sessions WHERE session_date 
            BETWEEN NOW() - INTERVAL 365 DAY AND NOW() AND user_id = :uid");
        $stmt->bindParam(":uid", $uid);
        $stmt->execute();
        standardizedResponse("Success", $stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        standardizedResponse($e->getMessage());
    }
}

//if ($type === )

        /*$stmt = $conn->prepare("SELECT DISTINCT session_date, session_title FROM sessions WHERE user_id = :id AND YEAR(session_date) = YEAR(:selectedYear)");*/
