<?php

$count = 0;

function replyAfterQueries(&$count, $entries){
    $count++;
    if ($count === count($entries->reps)){
        standardizedResponse("Success");
    }
}

?>
