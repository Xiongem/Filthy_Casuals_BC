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
                    <h2>Set RAT Date:</h2>
                </div>
                <div class="date-wrapper">
                    <input class="inputs" type="date" name="startDate" id="startDate">
                    <p class="hyphen">-</p>
                    <input class="inputs" type="date" name="endDate" id="endDate">
                </div>
                <div class="button-wrapper">
                    <div class="buttons" onclick="setRatDate()">Set</div>
                </div>
                <div class="setResult" id="setResult"></div>
            </div>

            <div class="divider"></div>

            <div class="wrapper-content">
                <div class="title-wrapper">
                    <h2>Generate One-time Passcode</h2>
                </div>
                <div class="button-wrapper">
                    <button id="createOTPButton" class="inputs buttons" onclick="createOTP()">Create OTP</button>
                </div>
                <div class="OTP-wrapper" id="OTPWrapper">
                    <label class="labels">One-time Passcode:</label>
                    <div class="span-wrapper">
                        <span id="OTP" class="labels">171439b1ba92011f8a37f71f8f8d6290</span>
                        <div class="copy-wrapper">
                            <p id="copy">copy</p>
                            <ion-icon class="copy" name="copy-outline"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script>
        //sends the start and end dates for RAT to the database
        function setRatDate() {
            var userID = <?=$userID?>;
            var startDate = $("#startDate").val();
            var endDate = $("#endDate").val();

            if (startDate && endDate) {
                $.ajax({
                    url: "php/process-setRatDate.php",
                    method: "post",
                    data: {startDate:startDate,
                            endDate:endDate,
                            userID:userID},
                    success:function(result) {
                        $("#setResult").html(result)
                    }
                })
            }else{
                $("#setResult").html("Please set dates before submitting.")
            }
        }

        //copies otp when user clicks the otp span
        const span = document.querySelector("span");
        span.onclick = function() {
            document.execCommand("copy");
        }
        span.addEventListener("copy", function(event) {
        event.preventDefault();
            if (event.clipboardData) {
                event.clipboardData.setData("text/plain", span.textContent);
                $("#copy").text("copied")
                console.log(event.clipboardData.getData("text"))
            }
        });

        //displays otp after generate button is clicked
        function showOTP(otp) {
            document.getElementById("OTP").innerHTML = otp;
            document.getElementById("OTPWrapper").style.display = "flex";
        }

        //randomly generates a otp, posts it to the database, and then passes the otp to the show otp function
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
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>