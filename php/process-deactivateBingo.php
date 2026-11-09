<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$resetActive = 0;
$stmt1 = $_SESSION['conn']->prepare("UPDATE `bingoNames` SET `active` = ? WHERE `active` = 1 AND `bingo_name` = ?");
$stmt1 -> bind_param("is",
                        $resetActive,
                        $_POST["bingoName"]); 

if ($stmt1 -> execute() && $stmt1 -> affected_rows > 0) {
    exit("Bingo deactivated");
} else {
    die("Failed to deactivate bingo" . $stmt1 -> error);
}
