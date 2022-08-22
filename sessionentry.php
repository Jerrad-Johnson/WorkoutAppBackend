<?php
session_start();
include "./utilities/standardizedResponse.php";
include "./connect.php";
include "./utilities/getUID.php";
include "./utilities/convertArraysToStringForDatabase.php";
include "./utilities/replyAfterQueries.php";

$entries = json_decode(file_get_contents('php://input'));
$uid = getUID();
$year = substr($entries->date, 0, 4);

if ($uid !== false) {
    try {
        $stmt = $conn->prepare("SELECT id FROM sessions WHERE session_date = :date AND user_id = :uid AND session_title = :title");
        $stmt->bindParam(':date', $entries->date);
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':title', $entries->title);
        $stmt->execute();
        $entryExists = $stmt->fetch();
        if ($entryExists) {
            standardizedResponse("Entry with the same date and title already exists.");
            return;
        }
    } catch (Exception $e){
        standardizedResponse($e->getMessage());
        return;
    }

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
            replyAfterQueries($count, $entries->reps);
        } catch (Exception $e) {
            standardizedResponse($e->getMessage());
            return;
        }
    }

    try { /*TODO Make compound key*/
        for ($i = 0; $i < count($entries->exercises); $i++){
            $stmt = $conn->prepare("INSERT INTO exercises (user_id, exercise) VALUES (:uid, :exercise)");
            $stmt->bindParam(':uid', $uid);
            $stmt->bindParam(':exercise', $entries->exercises[$i]);
            $stmt->execute();
        }
    } catch (Exception $e){
    }

    try { /*TODO Is this still used?*/
        for ($i = 0; $i < count($entries->exercises); $i++){
            $stmt = $conn->prepare("INSERT INTO yearsofentries (user_id, year) VALUES (:uid, :year)");
            $stmt->bindParam(':uid', $uid);
            $stmt->bindParam(':year', $year);
            $stmt->execute();
        }
    } catch (Exception $e){
    }

    try { /*TODO Make compound key*/
        $stmt = $conn->prepare("INSERT INTO usersessionnotes (user_id, notes, session_title, session_date) VALUES (:uid, :notes, :title, :date)");
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':notes', $entries->notes);
        $stmt->bindParam(':title', $entries->title);
        $stmt->bindParam(':date', $entries->date);
        $stmt->execute();
    } catch (Exception $e){
    }



} else {
    standardizedResponse("Cannot find user; try logging in again.");
}

?>

