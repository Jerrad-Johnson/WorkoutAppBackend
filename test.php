<?php
header('Content-Type: application/json');
session_start();
/*$reply = array("Stuff", "Stuff2");
$reply = json_encode($reply);*/
//echo $post = json_encode(file_get_contents('php://input'));

/*if (version_compare(phpversion(), '5.5', '<')) {
    echo "version older than 5.5";
} else {
    echo "version newer than 5.5";
}*/

echo "php version " . phpversion();

echo " " . $_SESSION["color"];
?>