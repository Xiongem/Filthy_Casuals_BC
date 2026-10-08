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

//* Store the token and expiry in the database for the user
$sql = "UPDATE users SET verification_hash = ?, verification_expires_at = ? WHERE user_id = ?";
    $stmt = $_SESSION["conn"] -> prepare($sql);
    $stmt->bind_param("ssi", 
                            $token_hash, $expiry, $user['user_id']);
    $stmt -> execute() ;

//* Send the verification email to the user
if ($user['email'] && $user['username']) {
    $mail = require($_SERVER['DOCUMENT_ROOT'] . '/mailer.php');

    $mail -> setFrom("noreply@filthycasualsbc.com");
    $mail -> addAddress($user['email']);
    $mail->Subject = "Account Creation Verification";
    $mail -> Body = <<<END
        Hello, 
        <br><br>
        Thank you for creating an account with us! <br>
        We need to make sure you're not a bot trying to infiltrate the system. <br>
        Please click the link below to verify your email address: <br>
        Click <a href="http://filthycasualsbc.com/verify-email.php?token=$token">here</a> to verify your email. <br>
        This link will expire in 30 minutes.
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

    header("Location: /verificationSent.php");
} else {
    echo "Error occurred while sending verification email.";
}