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
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s",time() + 60 * 30);

// $sql = "SELECT username FROM users WHERE email=$email";
//         $result = $_SESSION["conn"]->query($sql);
//         $user = $result->fetch_assoc();
//             $username = $user["username"];

$sql = "UPDATE users SET reset_token_hash = ?, reset_token_expires_at = ? WHERE email = ?";
    $stmt = $_SESSION["conn"] -> prepare($sql);
    $stmt->bind_param("sss", 
                            $token_hash, 
                            $expiry, 
                            $email);
    $stmt -> execute() ;

if($_SESSION["conn"] -> affected_rows) {
    $mail = require($_SERVER['DOCUMENT_ROOT'] . '/mailer.php');

    $mail -> setFrom("noreply@filthycasualsbc.com");
    $mail -> addAddress($email);
    $mail->Subject = "Password Reset";
    $mail -> Body = <<<END
        Hello, 
        <br><br>
        A request was made to reset your password. <br>
        The reset link will expire in 30 minutes. <br>
        Click <a href="http://filthycasualsbc.com/resetPassword.php?token=$token">here</a> to reset your password.
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
}

// echo "Message sent, please check your inbox.";
header("Location: /resetSentSuccess.php");