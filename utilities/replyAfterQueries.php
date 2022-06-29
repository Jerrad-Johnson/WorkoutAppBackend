<?php

$count = 0;

function replyAfterQueries(&$count, $entryArray){
    $count++;
    if ($count === count($entryArray)){
        standardizedResponse("Success");
    }
}

?>
