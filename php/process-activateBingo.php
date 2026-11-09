<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$stmt = $_SESSION['conn'] -> prepare("UPDATE `bingoNames` SET `active` = ? WHERE `bingo_name` = ?");
    $stmt -> bind_param("is", 
                        1, 
                        $_POST["bingoName"]);

    if ($stmt -> execute()) {
        echo $_POST["bingoName"] . " bingo has been activated!";
    } else {
        echo "Error activating bingo: " . $stmt -> error;
    }