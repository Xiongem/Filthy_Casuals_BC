<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$userID = $_SESSION['user_ID'];

$sql = "SELECT `username` FROM users WHERE user_id = $userID";
    $result = $_SESSION["conn"]->query($sql);
    $user = $result->fetch_assoc();
        $username = $user["username"];

$timezone = $_SESSION["timezone"];
date_default_timezone_set("$timezone");

$now = date("Y-m-d H:i:s");

$stmt = $_SESSION['conn'] -> prepare("UPDATE `challenges` SET `updated_by` = ?,
                                                                `updated_at` = ?,
                                                                `month_jan` = ?, 
                                                                `month_feb` = ?,
                                                                `month_march` = ?,
                                                                `month_april` = ?,
                                                                `month_may` = ?,
                                                                `month_june` = ?,
                                                                `month_july` = ?,
                                                                `month_aug` = ?,
                                                                `month_sept` = ?,
                                                                `month_oct` = ?,
                                                                `month_nov` = ?,
                                                                `month_dec` = ?");
    $stmt -> bind_param("ssssssssssssss", 
                        $username, 
                        $now,
                        $_POST["month_jan"],
                        $_POST["month_feb"],
                        $_POST["month_march"],
                        $_POST["month_april"],
                        $_POST["month_may"],
                        $_POST["month_june"],
                        $_POST["month_july"],
                        $_POST["month_aug"],
                        $_POST["month_sept"],
                        $_POST["month_oct"],
                        $_POST["month_nov"],
                        $_POST["month_dec"],);

    if ($stmt -> execute()) {
        echo "Challenges updated successfully";
    } else {
        echo "Error updating challenges: " . $stmt -> error;
    }