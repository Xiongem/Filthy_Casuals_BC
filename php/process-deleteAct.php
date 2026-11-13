<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$actID = $_POST["act_id"];

$stmt = $_SESSION["conn"]->prepare("DELETE FROM `activities` WHERE `act_id` = ?");

$stmt->bind_param("i",
                    $actID);

if ($stmt->execute() && $stmt -> affected_rows > 0) {
    echo ('<div class="deleteNotif">
            <h1>Activity successfully deleted</h1>
        </div>');
} else {
    die("Failed to delete activity" . $stmt->error);
}