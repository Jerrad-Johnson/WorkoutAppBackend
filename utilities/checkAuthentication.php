<?php

function checkAuth(){
    if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
        return true;
    } else {
        return false;
    }
}

?>