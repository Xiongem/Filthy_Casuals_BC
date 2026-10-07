<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();

require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
require($_SERVER['DOCUMENT_ROOT'] . '/mailer.php');
require($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

$mail = new PHPMailer\PHPMailer\PHPMailer;
dbConnect();

$email = $_POST["email"];
$username = $_POST["username"];


if ($email && $username) {
    $mail = require($_SERVER['DOCUMENT_ROOT'] . '/mailer.php');

    $mail -> setFrom("noreply@filthycasualsBC.com");
    $mail -> addAddress($email);
    $mail->Subject = "Account Creation Verification";
    $mail -> Body = <<<END
        Hello, 
        <br><br>
        Thank you for creating an account with us! <br>
        Please click the link below to verify your email address: <br>
        Click <a href="http://filthycasualsBC.com/verify-email.php?token=$token">here</a> to verify your email.
        <br><br>
        If you did not make this request, please ignore this email.
        <br><br>
        This process is automated, please do not reply to this email.
    END;
    Try {
        $mail ->send();
    } catch(Exception $e) {
        echo "Message could not be sent. Mail Sending error: {$mail->ErrorInfo}";
    }
header("Location: /index.php");
} else {
    header("Location: /contact.php?result=fail");
}