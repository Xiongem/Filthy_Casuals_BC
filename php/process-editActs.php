<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$userID = $_SESSION["user_id"];

$sql = "SELECT * FROM users WHERE user_id = $userID";
    $result = $_SESSION["conn"]->query($sql);
    $user = $result->fetch_assoc();
        $username = $user["username"];
        $timezone = $user["timezone"];

date_default_timezone_set("$timezone");

$actID = $_POST['act_id'];
$actName = $_POST['act_name'];
$actInfo = $_POST['act_info'];

$now = date("Y-m-d H:i:s");

$stmt = $_SESSION['conn'] -> prepare("UPDATE `activities` SET `act_name` = ?, `act_descr` = ?, `set_by` = ?, `set_at` = ? WHERE `act_id` = ?");
    $stmt -> bind_param("ssssi",
                        $actName, 
                        $actInfo,
                        $username,
                        $now, 
                        $actID);

    if ($stmt -> execute()) {
        echo "Activity updated successfully";
    } else {
        echo "Error updating activity: " . $stmt -> error;
    }