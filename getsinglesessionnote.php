<?php
session_start();
include "./utilities/standardizedResponse.php";
include "./connect.php";
include "./utilities/getUID.php";
include "./utilities/replyAfterQueries.php";

$uid = getUID();
$id = json_decode(file_get_contents('php://input'));

if ($uid !== false) {
    try {
        $stmt = $conn->prepare("SELECT notes FROM usersessionnotes WHERE user_id = :uid AND id = :id");
        $stmt->bindParam(":uid", $uid);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        standardizedResponse("Success", $stmt->fetch(PDO::FETCH_COLUMN));
    } catch (Exception $e) {
        standardizedResponse($e->getMessage());
    }
} else {
    standardizedResponse("Cannot find user; try logging in again.");
}

?>