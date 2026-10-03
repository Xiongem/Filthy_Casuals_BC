<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();
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
    <title>OTP Creation</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="website icon" type="webp" href="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/ea9288eda1.js" crossorigin="anonymous"></script>
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <div class="nav-wrapper" id="nav-wrapper">
            <div class="icon-wrapper">
                <i class="fa fa-bars" id="nav-menu-icon"></i>
                <div class="nav-menu-wrapper" id="nav-menu-wrapper">
                    <div class="nav-menu-content" id="nav-menu-content">
                        <a class="nav-item">Home</a>
                        <a class="nav-item">Settings</a>
                        <a class="nav-item">Logout</a>
                    </div>
                </div>
            </div>
            <a href="login.html" id="login">login</a>
        </div>
    </header>
    <div class="wrapper">
        <div class="wrapper-content">
            <div class="title-wrapper">
                <h1>One-time Passcode Creation</h1>
            </div>
            <div class="button-wrapper">
                <button id="createOTPButton" class="inputs buttons" onclick="createOTP()">Create One-time Passcode</button>
            </div>
            <div class="OTP-wrapper" id="OTPWrapper">
                <label class="labels">One-time Passcode:</label>
                <span id="OTP" class="labels" style="font-size: 1.5rem;"></span>
            </div>
        </div>
    </div>
    <script>
        function showOTP(otp) {
            document.getElementById("OTP").innerHTML = otp;
            document.getElementById("OTPWrapper").style.display = "flex";
        }
        function createOTP() {
            <?php
                $oneTimePass = bin2hex(random_bytes(16));
                $oneTimePass_hash = hash("sha256", $oneTimePass);
            ?>
            //assign values
            var oneTimePass_hash = <?= json_encode($oneTimePass_hash) ?>;
            //begin post method
            $.post("php/createOTP.php", {
                //DATA
                oneTimePass_hash: oneTimePass_hash
            }, function(response) {
                showOTP(<?= json_encode($oneTimePass) ?>);
            });
        }
    </script>
</body>
</html>