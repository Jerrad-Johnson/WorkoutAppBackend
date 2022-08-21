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
        $stmt = $conn->prepare("SELECT session_date FROM usersessionnotes 
            WHERE user_id = :uid ORDER BY session_date DESC");
        $stmt->bindParam(":uid", $uid);
        $stmt->execute();
        standardizedResponse("Success", $stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        standardizedResponse($e->getMessage());
    }
} else {
    standardizedResponse("Cannot find user; try logging in again.");
}

?>