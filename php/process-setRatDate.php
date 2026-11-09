<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$userID = $_POST['userID'];

$sql = "SELECT username FROM `users` WHERE `user_id` = $userID";
    $result = $_SESSION["conn"]->query($sql);
    $user = $result->fetch_assoc();
        $username = $user["username"];

$now = date("Y-m-d H:i:s");

$stmt = $_SESSION['conn'] -> prepare("UPDATE `adminStuff` SET `setBy` = ?,
                                                                `ratStart` = ?, 
                                                                `ratEnd` = ?,
                                                                `setAt` = ?
                                                            WHERE `adminID` = 1");
    $stmt -> bind_param("ssss", 
                        $username,
                        $_POST["startDate"],
                        $_POST["endDate"],
                        $now);

if ($stmt -> execute()) {
    echo "Successfully set RAT date!";
    exit;
} else {
    die("failed to set RAT date.");
}