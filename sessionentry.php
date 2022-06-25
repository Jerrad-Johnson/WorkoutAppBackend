<?php
session_start();
include "./connect.php";
//include "./supplemental/checkAuthentication.php";
include "./utilities/getUID.php";

$entries = json_decode(file_get_contents('php://input'));
$uid = getUID();
$count = 0;

if($uid !== false){
    foreach ($entries as $entry){
        $repsAsString = implode(",", $entry->reps);
        $weightLiftedAsString = implode(",", $entry->weightLifted);
        try {
            $stmt = $conn->prepare("INSERT INTO sessions (user_id, session_date, session_title, exercise, weight_lifted, reps) 
                VALUES (:user, :date, :title, :exercise, :weight_lifted, :reps)");
            $stmt->bindParam(':user', $uid);
            $stmt->bindParam(':date', $entry->date);
            $stmt->bindParam(':title', $entry->title);
            $stmt->bindParam(':exercise', $entry->exercise);
            $stmt->bindParam(':weight_lifted', $weightLiftedAsString);
            $stmt->bindParam(':reps', $repsAsString);
            $stmt->execute();
            replyAfterSetOfQueries($count, $entries);
        } catch (Exception $e) {
            standardizedResponse($e->getMessage());
            return;
        }
    }
} else {
    echo "Cannot find user; try logging in again.";
}

function replyAfterSetOfQueries(&$count, $entries){
    $count++;
    if ($count === count($entries)){
        standardizedResponse("Success");
    }
}

?>

