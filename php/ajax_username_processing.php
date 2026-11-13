<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$string = $_POST['keyword'];

// echo "result: " . $string0;

$sql = "SELECT `user_id`, `username` FROM `users` WHERE `username` LIKE '%$string%' ";
    $result = $_SESSION["conn"]->query($sql);

while ($row = $result -> fetch_assoc()) {
    $userID = $row['user_id'];
    $username = $row['username'];
    
     $htmlContent = <<<HTML
        <a href="#" class="searchResult" onclick="addAdmin($userID)">$username</a>
    HTML;
        echo $htmlContent;
}