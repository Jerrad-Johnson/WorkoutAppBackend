# Front-end install / deployment

- Get [repository](https://github.com/Jerrad-Johnson/WorkoutAppRedo)
- Run `npm install` in project folder
- Update `queries.tsx` variable `baseURL` to reference your php directory
- Use `npm run build` to create a deployable version of the frontend app, then navigate to the project's folder, then to the `build` subfolder. Upload the `build` folder's contents to a webserver, and set URL rewrites.

# Back-end install / deployment

- Get [repository](https://github.com/Jerrad-Johnson/WorkoutAppBackend)
- Create a database
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
