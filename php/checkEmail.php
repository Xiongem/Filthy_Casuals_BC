<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$email = $_POST["email"];

$stmt = $_SESSION["conn"]->prepare("SELECT `email` FROM `users` WHERE `email` = ?");
    $stmt->bind_param("s",
                        $email);

    $stmt->execute();
    $result = $stmt->get_result();
    if ($result -> num_rows > 0) {
        echo '<p class="success">Email Found</p>
                <div class="button-wrapper spacing">
                    <button type="submit" id="submitButton" class="buttons">Send</button>
                </div>';
    } else {
        echo '<p class="error">Email Not Found</p>';
    }