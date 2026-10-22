<?php
ob_start();
session_start();

function logout() {
    if (isset($_SESSION['loggedin'])) {
    unset($_SESSION['loggedin']);     // unset $_SESSION variable for the run-time 
        $_SESSION['loggedin'] = "false";
    } 
}

session_unset();
session_destroy();

header("Location: /login.php");
exit();