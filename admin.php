<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();
forceLogin();

$userID = $_SESSION["user_id"];

 $sql = "SELECT * FROM users WHERE user_id = $userID";
        $result = $_SESSION["conn"]->query($sql);
        $user = $result->fetch_assoc();
            $admin = $user['admin'];
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
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <script src="https://kit.fontawesome.com/ea9288eda1.js" crossorigin="anonymous"></script> -->
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <?= makeNav() ?>
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
                <div class="span-wrapper">
                    <span id="OTP" class="labels" style="font-size: 1.5rem;"></span>
                    <div class="copy-wrapper">
                        <p>copy</p>
                        <ion-icon class="copy" name="copy-outline"></ion-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const span = document.querySelector("span");

        span.onclick = function() {
            document.execCommand("copy");
        }

        span.addEventListener("copy", function(event) {
        event.preventDefault();
            if (event.clipboardData) {
                event.clipboardData.setData("text/plain", span.textContent);
                console.log(event.clipboardData.getData("text"))
            }
        });

        function showOTP(otp) {
            document.getElementById("OTP").innerHTML = otp;
            document.getElementById("OTPWrapper").style.display = "flex";
        }
        function createOTP() {
            <?php
                $oneTimePass = bin2hex(random_bytes(16));
            ?>
            //assign values
            var oneTimePass = <?= json_encode($oneTimePass) ?>;
            //begin post method
            $.post("php/createOTP.php", {
                //DATA
                oneTimePass: oneTimePass
            }, function(response) {
                showOTP(<?= json_encode($oneTimePass) ?>);
            });
        }
    </script>
</body>
</html>