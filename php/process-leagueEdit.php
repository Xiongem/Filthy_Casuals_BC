<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$userID = $_POST['user_ID'];
$newLeague = $_POST['leagueName'];

$stmt = $_SESSION['conn'] -> prepare("UPDATE `users` SET `league` = ? WHERE `user_id` = ?");
    $stmt -> bind_param("si", 
                        $newLeague, 
                        $userID);

    if ($stmt -> execute()) {
        echo "League updated successfully";
    } else {
        echo "Error updating league: " . $stmt -> error;
    }