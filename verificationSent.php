<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
dbConnect();
session_start();

$userID = $_SESSION["user_id"];

 $sql = "SELECT email, username FROM users WHERE id = $userID";
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
    <meta property="og:image" content=""> 
    <meta property="og:url" content="">
    <title>Account Creation</title>
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
            <h1>Account Creation</h1>
            <p>Thank you for creating an account with us! <br>
                We need to make sure you're not a bot trying to infiltrate the system. <br>
                Please check your email for a verification link. <br>
                This link will expire in 30 minutes.
            </p>
        </div>
    </div>
    <div>
        <p>Didn't receive the email? Check your spam folder or click the button below to resend the verification email.</p>
        <a href="mailVerification.php" class="btn">
            <div>
                Resend Verification Email
            </div>
        </a>
    </div>

    <div class="login-wrapper">
        <a href="login.php">Back to Login</a>
    </div>
</body>
</html>