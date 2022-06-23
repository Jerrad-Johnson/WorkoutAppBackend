<?php
header('Content-Type: application/json');

echo $post = json_encode(file_get_contents('php://input'));

?>