<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();

require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();
require($_SERVER['DOCUMENT_ROOT'] . '/mailer.php');
require($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

$mail = new PHPMailer\PHPMailer\PHPMailer;

$userID = $_SESSION["user_id"];

 $sql = "SELECT email, username FROM users WHERE user_id = $userID";
        $result = $_SESSION["conn"]->query($sql);
        $user = $result->fetch_assoc();

//* Create a unique token for email verification
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s",time() + 60 * 30);
echo "Token: ". $token . "<br>";