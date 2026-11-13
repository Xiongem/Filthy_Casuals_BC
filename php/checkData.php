<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

if (! empty($_POST["username"])) {
    $sql = "SELECT `username` FROM `users` WHERE `username` = ?";
        $statement = $_SESSION["conn"]->prepare($sql);
            $statement->bind_param('s', 
                        $_POST["username"]);
                        
        $statement->execute();
    $result = $statement->get_result();
    if ($result->num_rows > 0) {
        echo '<span class="warning">Username Already In Use</span>';
    } else {
        echo '<span class="success">Username Available</span>';
    }
 exit();
}
if (! empty($_POST["email"])) {
    $sql = "SELECT `email` FROM `users` WHERE `email` = ?";
        $statement = $_SESSION["conn"]->prepare($sql);
            $statement->bind_param('s', 
                        $_POST["email"]);

        $statement->execute();
    $result = $statement->get_result();
    if ($result->num_rows > 0) {
        echo '<span class="warning">Email Already in Use</span>';
    } else {
        echo '<span class="success">Email Available</span>';
    }
 exit();
}