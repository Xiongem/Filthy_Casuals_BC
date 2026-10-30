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
    <title>Settings</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/settings.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <script src="https://kit.fontawesome.com/ea9288eda1.js" crossorigin="anonymous"></script> -->
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        function checkName(){
            // var username=document.getElementById( "username" ).value;
            var username = $('#username').val();

            if(username){
                $.ajax({
                type: 'post',
                url: 'php/checkData.php',
                data: {
                    username: username,
                },
                success: function (data) {
                    $( '#user-availability-status' ).html(data);
                }
                });
            }
            else{
                $( '#user-availability-status' ).html("");
                console.log("Something went wrong")
                return false;
            }
        }
        function checkEmail(){
            // var email=document.getElementById( "email" ).value;
            var email = $('#email').val();
            
            if(email){
                $.ajax({
                type: 'post',
                url: 'php/checkData.php',
                data: {
                    email: email,
                },
                success: function (data) {
                    $( '#email-availability-status' ).html(data);
                }
                });
            }
            else{
                $( '#email-availability-status' ).html("");
                console.log("Something went wrong")
                return false;
            }
        }
    </script>
</head>
<body id="body">
    <div class="popup-wrapper hide" id="dangerPopup">
        <div class="popup-container">
            <div class="close-wrapper">
                <ion-icon name="close" onclick="closeDangerZone()"></ion-icon>
            </div>
            <div class="warning-content">
                <h1 class="warning-text"><strong>Delete Your Account?</strong></h1>
                <p class="warning-text">This is <strong><em>permanent</em></strong> and cannot be reversed.
                <br><br>
                Are you <strong>certain</strong> you want to delete your account?</p>
            </div>
            <div class="button-wrapper-warning">
                <div class="delete">
                    <a href="php-processes/delete-account.php" id="delete">Delete My Account</a>
                </div>
            </div>
        </div>
    </div>
    <header>
        <?= makeNav() ?>
    </header>
    <div class="settings-wrapper">
        <div class="settings-container">
            <div class="tab">
                <div class="tab-link" onclick="selectSettings('account')">
                    <p>Account</p>
                </div>
                <div class="tab-link" onclick="selectSettings('dangerZone')">
                    <p>Danger Zone</p>
                </div>
            </div>

            <!--//? AJAX DISPLAY TABS-->
            <div id="result">

            </div>
            
            <script type="text/javascript">
                $(document).ready(function() {
                    showSettings();
                });

                function showSettings() {
                    var user_ID = <?= $userID ?>;
                    $.ajax({
                        url: 'php/showSettings.php',
                        method: 'post',
                        data: {user_id:user_ID},
                        success: function(result) {
                            $("#result").html(result);
                        }
                    });
                }

                function selectSettings(tab) {
                    var user_ID = <?= $userID ?>;
                    $.ajax({
                        url: 'php/selectSettings.php',
                        method: 'post',
                        data: {tab_name:tab,
                                user_id:user_ID},
                        success: function(result) {
                            $("#result").html(result);
                        }
                    });
                }
            </script>
        </div>
    </div>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>