<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

if ($_POST["bingoName"]) {
    $resetActive = 0;
    $stmt1 = $_SESSION['conn']->prepare("UPDATE `bingoNames` SET `active` = ? WHERE `active` = 1");
    $stmt1 -> bind_param("i",
                            $resetActive);      
    
    if ($stmt1 -> execute()) {
        $bingoName =  $_POST["bingoName"];
        $active = 1;
        $stmt = $_SESSION['conn'] -> prepare("UPDATE `bingoNames` SET `active` = ? WHERE `bingo_name` = ?");
        $stmt -> bind_param("is", 
                            $active, 
                            $bingoName);

        if ($stmt -> execute()) {
            echo "$bingoName bingo has been activated!";
        } else {
            echo "Error activating bingo: " . $stmt -> error;
        }
    }
} else {
    echo "Please choose a bingo before submitting";
}
