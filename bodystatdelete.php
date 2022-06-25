<html>
<body style="color: #999">

<?php
session_start();
include "./connect.php";
include "./utilities/getUID.php";
include "./utilities/standardizedResponse.php";

$placeholder = array(
    "date" => "2022-02-02",
    "user_stat" => "Chest"
);

$uid = getUID();

if ($uid !== false) {
    try {
        $stmt = $conn->prepare("DELETE FROM bodystats 
            WHERE user_id = :uid AND entry_date = :entry_date AND user_defined_stat = :user_stat");
        $stmt->bindParam(":uid", $uid);
        $stmt->bindParam(":entry_date", $placeholder['date']);
        $stmt->bindParam(":user_stat", $placeholder['user_stat']);
        $stmt->execute();
        standardizedResponse("Success");
    } catch (Exception $e) {
        standardizedResponse($e->getMessage());
        return;
    }
} else {
    standardizedResponse("Cannot find user; try logging in again.");
}

?>
</body>
</html>