<?php
/*header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,POST,PUT,OPTIONS");
header("Access-Control-Allow-Headers:*");*/

include "./connect.php";

try {
$sql = "CREATE TABLE users(
    id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    username VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(60) UNIQUE
    )";
  $conn->exec($sql);
  echo "<br /> Table users created successfully.<br />";
} catch(PDOException $e){
  echo "<br />" . $sql . "<br>" . $e->getMessage();
}


try {
    $sql = "CREATE TABLE exercises(
    id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(8) UNSIGNED NOT NULL,
    exercise VARCHAR(30) NOT NULL
    )";
    $conn->exec($sql);
    echo "<br /> Table exercises created successfully.<br />";
} catch(PDOException $e){
    echo "<br />" . $sql . "<br>" . $e->getMessage();
}


try {
    $sql = "CREATE TABLE sessions(
    id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(8) UNSIGNED NOT NULL,
    session_date DATE NOT NULL,
    session_title VARCHAR(40) NOT NULL,
    /*session_number INT(5) UNSIGNED NOT NULL, TODO Remove this column*/
    exercise VARCHAR(40) NOT NULL,
    weight_lifted VARCHAR(110) NOT NULL,
    reps VARCHAR(70) NOT NULL
    )";
    $conn->exec($sql);
    echo "<br /> Table sessions created successfully.<br />";
} catch(PDOException $e){
    echo "<br />" . $sql . "<br>" . $e->getMessage();
}

try {
    $sql = "CREATE TABLE bodystats(
    id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(8) UNSIGNED NOT NULL,
    entry_date DATE NOT NULL,
    body_weight INT(4) UNSIGNED,
    user_defined_measurement DECIMAL(7,2) UNSIGNED,
    user_defined_stat VARCHAR(30)
    )";
    $conn->exec($sql);
    echo "<br /> Table bodystats created successfully.<br />";
} catch(PDOException $e){
    echo "<br />" . $sql . "<br>" . $e->getMessage();
}

try {
   $sql = "CREATE TABLE usersessiondefaults(
   id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   user_id INT(8) UNSIGNED NOT NULL UNIQUE,
   reps INT(2) UNSIGNED NOT NULL,
   sets INT(2) UNSIGNED NOT NULL,
   exercises INT(2) UNSIGNED NOT NULL,
   weight INT(5) UNSIGNED NOT NULL
   )";
   $conn->exec($sql);
    echo "<br /> Table usersessiondefaults created successfully.<br />";
} catch (Exception $e){
    echo "<br />" . $sql . "<br>" . $e->getMessage();
}

try {
    $sql = "CREATE TABLE usersessionnotes(
    id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY UNIQUE,
    user_id INT(8) UNSIGNED NOT NULL,
    notes VARCHAR(5000) NOT NULL,
    session_date DATE NOT NULL,
    session_title VARCHAR(40) NOT NULL
   )";
    $conn->exec($sql);
    echo "<br /> Table usersessionnotes created successfully.<br />";
} catch (Exception $e){
    echo "<br />" . $sql . "<br>" . $e->getMessage();
}


/* Also:
 * ALTER TABLE exercises ADD INDEX unique_exercise_user_pair (user_id, exercise); -- TODO !important Does not work, allows duplicate entries. Fix this.
 *
 */

?>

