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
            <div class="input-wrapper spacing">
                <label for="email">Email:</label>
                <input class="reset-input inputs" type="email" name="email" id="forgetEmail" required onkeyup="clearError()">
            </div>
            <div id="error" class="error spacing"></div>
            <div class="button-wrapper">
                <div id="submitButton" class="buttons" onclick="checkEmail()">Send</div>
            </div>
        </div>
    </div>
    <script>
        function clearError() {
            $("#error").html("");
        }
        function checkEmail() {
            var email = $("#forgetEmail").val();

            $.ajax ({
                url: "php/checkEmail.php",
                method: "post",
                data: {email:email},
                success:function(result) {
                    if (result == 1) {
                        header("Location: /php/sendPasswordReset.php");
                    } else {
                        $("#error").html('email not found');
                    }
                }
            })
        }
    </script>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>