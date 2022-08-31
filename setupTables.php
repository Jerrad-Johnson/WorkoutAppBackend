<?php

include "./connect.php";

try {
$sql = "CREATE TABLE users(
    id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    username VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(60) NOT NULL UNIQUE
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
   $sql = "CREATE TABLE user_session_defaults(
   id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   user_id INT(8) UNSIGNED NOT NULL UNIQUE,
   reps INT(2) UNSIGNED NOT NULL,
   sets INT(2) UNSIGNED NOT NULL,
   exercises INT(2) UNSIGNED NOT NULL,
   weight INT(8) UNSIGNED NOT NULL
   )";
   $conn->exec($sql);
    echo "<br /> Table user_session_defaults created successfully.<br />";
} catch (Exception $e){
    echo "<br />" . $sql . "<br>" . $e->getMessage();
}

try {
    $sql = "CREATE TABLE user_session_notes(
    id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY UNIQUE,
    user_id INT(8) UNSIGNED NOT NULL,
    notes VARCHAR(5000) NOT NULL,
    session_date DATE NOT NULL,
    session_title VARCHAR(40) NOT NULL
   )";
    $conn->exec($sql);
    echo "<br /> Table user_session_notes created successfully.<br />";
} catch (Exception $e){
    echo "<br />" . $sql . "<br>" . $e->getMessage();
}

try {
    $sql = "CREATE TABLE password_reset_keys(
    id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY UNIQUE,
    user_id INT(8) UNSIGNED NOT NULL,
    reset_key VARCHAR(20) NOT NULL,
    creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   )";
    $conn->exec($sql);
    echo "<br /> Table password_reset_keys created successfully.<br />";
} catch (Exception $e){
    echo "<br />" . $sql . "<br>" . $e->getMessage();
}

try {
    $sql = "CREATE TABLE years_of_entries(
    id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY UNIQUE,
    user_id INT(8) UNSIGNED NOT NULL,
    year INT(4) UNSIGNED NOT NULL
   )";
    $conn->exec($sql);
    echo "<br /> Table password_reset_keys created successfully.<br />";
} catch (Exception $e){
    echo "<br />" . $sql . "<br>" . $e->getMessage();
}

try{
    $sql = "ALTER TABLE exercises ADD UNIQUE INDEX unique_exercise_user_pair (user_id, exercise)";
    $conn->exec($sql);
    echo "<br /> Compound key unique_exercise_user_pair added.<br />";
} catch (Exception $e){
    echo "<br />" . $sql . "<br>" . $e->getMessage();
}

try{
    $sql = "ALTER TABLE user_session_notes ADD UNIQUE INDEX unique_session_notes (user_id, session_title, session_date)";
    $conn->exec($sql);
    echo "<br /> Compound key unique_session_notes added.<br />";
} catch (Exception $e){
    echo "<br />" . $sql . "<br>" . $e->getMessage();
}

try{
    $sql = "ALTER TABLE sessions ADD UNIQUE INDEX unique_sessions (user_id, session_title, session_date, exercise)";
    $conn->exec($sql);
    echo "<br /> Compound key unique_sessions added.<br />";
} catch (Exception $e){
    echo "<br />" . $sql . "<br>" . $e->getMessage();
}

try{
    $sql = "ALTER TABLE years_of_entries ADD UNIQUE INDEX unique_years (user_id, year)";
    $conn->exec($sql);
    echo "<br /> Compound key unique_years added.<br />";
} catch (Exception $e){
    echo "<br />" . $sql . "<br>" . $e->getMessage();
}

/* Also:
 * ALTER TABLE exercises ADD INDEX unique_exercise_user_pair (user_id, exercise);
 * DISALLOW EMPTY NOTES STRINGS IN user_session_notes
 */

?>

