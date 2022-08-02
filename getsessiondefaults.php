<?php
session_start();
include "./utilities/standardizedResponse.php";
include "./connect.php";
include "./utilities/getUID.php";

$entry = json_decode(file_get_contents('php://input'));
$uid = getUID();

if ($uid !== false) {
    try {
        $stmt = $conn->prepare("SELECT exercises, reps, sets, weight FROM usersessiondefaults WHERE user_id = :uid");
        $stmt->bindParam(":uid", $uid);
        $stmt->execute();
        standardizedResponse("Success", $stmt->fetch(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        standardizedResponse($e->getMessage());
    }
} else {
    standardizedResponse("Cannot find user; try logging in again.");
}
