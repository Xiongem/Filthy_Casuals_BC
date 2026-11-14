<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$userID = $_POST["user_id"];

$stmt = $_SESSION["conn"] -> prepare("UPDATE `users` SET `admin` = 1 WHERE `user_id` = ?");

$stmt->bind_param("i",
                    $userID);

if ($stmt->execute() && $stmt -> affected_rows > 0) {
    echo "Successfully added new admin.";
} else {
    die("failed to add new admin" . $stmt -> error);
}