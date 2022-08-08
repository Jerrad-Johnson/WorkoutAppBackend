<?php
session_start();
include "./utilities/standardizedResponse.php";
include "./connect.php";
include "./utilities/getUID.php";
include "./utilities/replyAfterQueries.php";
$uid = getUID();

if ($uid === false) {
    standardizedResponse("Not logged in");
    return;
}

try {
    $stmt = $conn->prepare("SELECT DISTINCT YEAR(session_date) FROM sessions WHERE user_id = :uid");
    $stmt->bindParam(":uid", $uid);
    $stmt->execute();
    standardizedResponse("Success", $stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    standardizedResponse($e->getMessage());
}
