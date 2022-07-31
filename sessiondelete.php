<?php
session_start();
include "./connect.php";
include "./utilities/getUID.php";
include "./utilities/standardizedResponse.php";

$entry = json_decode(file_get_contents('php://input'));
$uid = getUID();

if ($uid !== false) {
    try {
        $stmt = $conn->prepare("DELETE FROM sessions WHERE session_date = :date AND user_id = :uid AND session_title = :title");
        $stmt->bindParam(':date', $entry->date);
        $stmt->bindParam(':title', $entry->title);
        $stmt->bindParam(':uid', $uid);
        $stmt->execute();
        standardizedResponse("Success");
    } catch (Exception $e) {
        standardizedResponse($e->getMessage());
        return;
    }
}

?>