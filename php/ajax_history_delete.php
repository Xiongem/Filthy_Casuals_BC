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
$userID = $_POST['user_ID'];

echo "readID = " . $readID . ", userID = " . $userID;
?>
<div class="deleteNotif">
    <h1>Failed to delete entry.</h1>
    <h2>Please try again</h2>
</div>