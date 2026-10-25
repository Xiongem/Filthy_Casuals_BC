<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

//assign POST data from ajax to variables
$readID = $_POST['read_ID'];
$ID = $_POST['user_ID'];

$stmt = $_SESSION["conn"] -> prepare("DELETE FROM `readHistory` WHERE `user_id` = ?  AND read_ID = ?");
$stmt->bind_param("ii",
                        $readID,
                        $ID);

$stmt->execute();