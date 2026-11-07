<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

if ($_POST['username']) {
    $username = $_POST['username'];

    $sql = "SELECT * FROM `users` WHERE `username` = '$username'";
        $result = $_SESSION["conn"]->query($sql);
        $user = $result->fetch_assoc();
            $oldTotal = $user["pointsYear"];
            $oldRecNum = $user["recPoints"];

    $newTotal = $oldTotal + 20;
    $newRecNum = $newTotal + 20;

    $stmt = $_SESSION["conn"] -> prepare("UPDATE `users` SET `pointsYear` = ?, `recPoints` = ? WHERE `username` = ?");
    $stmt -> bind_param("iis", 
                            $newTotal,
                            $oldRecNum,
                            $username);

    if ($stmt->execute()) {
        exit("Points awarded!");
    } else {
        die("Failed to award points.");
    }
} else {
    die("username empty");
}
