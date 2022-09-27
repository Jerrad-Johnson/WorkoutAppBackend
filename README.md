# Strength Training Tracker

## About

This is meant to make tracking your workout sessions easier. You can quickly add exercises to your workout, sets to your exercises, and reps and weight to your sets.

You can also load a previous session as a template, and perhaps for example the only thing you need to change is the number of reps performed; all else may be the same.

The app also graphs your progress with each exercise, showing your calculated 1RM across time.

# Front-end install / deployment

- Instructions in [repository](https://github.com/Jerrad-Johnson/WorkoutAppRedo)

# Back-end install / deployment

- Get [repository](https://github.com/Jerrad-Johnson/WorkoutAppBackend)
- Create a database

Example:
```
CREATE DATABASE workoutapp;
CREATE USER 'workoutappadmin'@'172.17.0.1' IDENTIFIED WITH mysql_native_password BY 'somepassword';
GRANT ALL PRIVILEGES ON workoutapp.* TO 'workoutappadmin'@'172.17.0.1';
```

- Create `connect.php` and `sendgridKey.php` in parent php folder. Sample formats:
### connect.php
```
<?php

$servername = "localhost";
$username = "someusername";
$password = "somepassword";
$db = "workoutapp";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $e) {
    standardizedResponse($e->getMessage());
    return;
}

?>
```
### sendgridKey.php
```
<?php
$sendgridKey = "Your key goes here";
?>
```
- Run setupTables.php

## Known backend issues

- Need to update e-mail address so that messages come from my domain, rather than (presently) from my school e-mail address.