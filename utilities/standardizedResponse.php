<?php

function standardizedResponse($message = null, $data = null){
    $response = array("message" => $message, "data" => $data);
    echo json_encode($response);
}

?>