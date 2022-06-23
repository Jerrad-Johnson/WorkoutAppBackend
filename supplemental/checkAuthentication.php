<?php

function checkAuth(){
    if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] == (null || false)) {
        return true;
    } else {
        return false;
    }
}

?>