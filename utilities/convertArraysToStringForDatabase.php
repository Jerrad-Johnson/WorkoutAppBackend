<?php

function convertArraysToStringForDatabase($dataAsArray){
    $dataAsString = "";
    for ($i = 0; $i < count($dataAsArray); $i++){
        $dataAsString .= implode(',', $dataAsArray[$i]);

        if ($i !== count($dataAsArray) -1){
            $dataAsString .= "-";
        }
    }
    return $dataAsString;
}

?>