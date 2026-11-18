<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="Filthy Casual Book Challenge"> 
    <meta property="og:description" content="A competition for filthy casuals."> 
    <meta property="og:image" content="https://filthycasualsbc.com/images/FCBClogo.svg"> 
    <meta property="og:url" content="https://filthycasualsbc.com/forgotPassword.php">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="reset-wrapper">
        <div class="reset-content">
            <h3>Enter the email address associated with your account to receive an email to reset your password.</h3>
            <form id="reset-password" method="post" action="php/sendPasswordReset.php">
                <div class="input-wrapper spacing">
                    <label for="email">Email:</label>
                    <input class="reset-input inputs" type="email" name="email" id="forgetEmail" required
                        onkeydown="if(event.keyCode === 13) {return false;}">
                </div>
                <div id="response" class="spacing"></div>
            </form>
        </div>
    </div>
    <script>
        var typingTimer;                //timer identifier
        var doneTypingInterval = 500;  //time in ms, 1 seconds for example
        var $input = $('#forgetEmail');

        //on keyup, start the countdown
        $input.on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        //on keydown, clear the countdown 
        $input.on('keydown', function () {
            $("#response").html("");
            clearTimeout(typingTimer);
        });

        //user is "finished typing," do something
        function doneTyping () {
            var email = $("#forgetEmail").val();

            $.ajax ({
                url: "php/checkEmail.php",
                method: "post",
                data: {email:email},
                success:function(result) {
                    $("#response").html(result);
                }
            })
        }
    </script>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>