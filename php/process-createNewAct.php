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

$now = date("Y-m-d H:i:s");

$actName = $_POST['newActName'];
$actDescr = $_POST['newActDescr'];


    $stmt = $_SESSION['conn'] -> prepare("INSERT INTO `activities` (`act_name`,
                                                                    `act_descr`,
                                                                    `set_by`,
                                                                    `set_at`)
                                            VALUES (?, ?, ?, ?)");
                                            
        $stmt -> bind_param("ssss", 
                            $actName,
                            $actDescr,
                            $username,
                            $now);

    ;

if ($stmt -> execute() && $stmt -> affected_rows > 0) {
    // echo "Rule created successfully";
    header("Location: /challenges.php");
} else {
    // echo "Error creating rule: " . $stmt -> error;
    die("Error creating rule: " . $stmt -> error);
}
