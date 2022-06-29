<?php
session_start();
include "./utilities/standardizedResponse.php";
include "./connect.php";
include "./utilities/getUID.php";
include "./utilities/convertArraysToStringForDatabase.php";
include "./utilities/replyAfterQueries.php";

$entries = json_decode(file_get_contents('php://input'));
$uid = getUID();

if($uid !== false){
    for ($i = 0; $i < count($entries->reps); $i++){
        $repsAsString[$i] = implode(",", $entries->reps[$i]);
        $weightLiftedAsString[$i] = implode(",", $entries->weights[$i]);
        try {
            $stmt = $conn->prepare("INSERT INTO sessions (user_id, session_date, session_title, exercise, weight_lifted, reps) 
                VALUES (:user, :date, :title, :exercise, :weight_lifted, :reps)");
            $stmt->bindParam(':user', $uid);
            $stmt->bindParam(':date', $entries->date);
            $stmt->bindParam(':title', $entries->title);
            $stmt->bindParam(':exercise', $entries->exercises[$i]);
            $stmt->bindParam(':weight_lifted', $weightLiftedAsString[$i]);
            $stmt->bindParam(':reps', $repsAsString[$i]);
            $stmt->execute();
            replyAfterQueries($count, $entries);
        } catch (Exception $e) {
            standardizedResponse($e->getMessage());
            return;
        }
    }
} else {
    echo "Cannot find user; try logging in again.";
}

?>

