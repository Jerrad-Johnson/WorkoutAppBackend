<?php
session_start();
include "./utilities/standardizedResponse.php";
include "./connect.php";
include "./utilities/getUID.php";

$entry = json_decode(file_get_contents('php://input'));
$uid = getUID();

if ($uid !== false){
    try {
            $stmt = $conn->prepare("
            INSERT INTO usersessiondefaults(user_id, reps, sets, exercises, weight) 
            VALUES(:uid, :reps, :sets, :exercises, :weight) 
            ON DUPLICATE KEY UPDATE reps = :reps, sets = :sets, exercises = :exercises, weight = :weight");
            $stmt->bindParam(':reps', $entry->reps);
            $stmt->bindParam(':sets', $entry->sets);
            $stmt->bindParam(':exercises', $entry->exercises);
            $stmt->bindParam(':weight', $entry->weight);
            $stmt->execute();
    } catch (Exception $e){
        standardizedResponse($e->getMessage());
    }
} else {
    standardizedResponse("Cannot find user; try logging in again.");
}

?>

