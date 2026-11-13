<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$userID = $_SESSION["user_id"];

 $sql = "SELECT email, username FROM users WHERE user_id = $userID";
        $result = $_SESSION["conn"]->query($sql);
        $user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="Filthy Casual Book Challenge"> 
    <meta property="og:description" content="A competition for filthy casuals."> 
    <meta property="og:image" content="https://filthycasualsbc.com/images/FCBClogo.svg"> 
    <meta property="og:url" content="https://filthycasualsbc.com/verificationSent.php">
    <title>Verification Sent</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="javascript/scripts.js"></script>
    <script src="https://use.fontawesome.com/fe459689b4.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
   <?= makeNav() ?>
    <div class="login-wrapper">
        <div class="login-content">
            <h1 class="title">Account Creation</h1>
            <p class="spacing">Thank you for creating an account with us! <br>
                We need to make sure you're not a bot trying to infiltrate the system. <br><br>
                Please check your email for a verification link. <br><br>
                This link will expire in 30 minutes.
            </p>
        
            <p class="spacing">Didn't receive the email? Check your spam folder or click the button below to resend the verification email.</p>
            
            <div class="button-wrapper">
                <a href="mailVerification.php" class="buttons spacing">
                        Resend Verification Email
                </a>
            </div>

            <div class="login-wrapper spacing">
                <a href="login.php">Back to Login</a>
            </div>

        </div>
    </div>
</body>
</html>