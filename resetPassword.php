<?php
$token = $_GET["token"];
$token_hash = hash("sha256", $token);

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$sql = "SELECT * FROM users WHERE reset_token_hash = ?";
    $stmt = $_SESSION["conn"] -> prepare($sql);
    $stmt->bind_param("s", $token_hash);
    $stmt -> execute() ;
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="Filthy Casual Book Challenge"> 
    <meta property="og:description" content="A competition for filthy casuals."> 
    <meta property="og:image" content="https://filthycasualsbc.com/images/FCBClogo.svg"> 
    <meta property="og:url" content="https://filthycasualsbc.com/resetPassword.php">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="reset-pass-wrapper">
        <div class="reset-pass-content">
            <form method="post" action="php/process-resetPassword.php">
                <div class="check-wrapper spacing">
                    <label class="labels">Password:</label>
                    <input type="password"
                        name="password"
                        id="password"
                        class="inputs"
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                        title="Must contain at least one number and one uppercase and lowercase letter, 
                        and at least 8 or more characters"
                        maxlength="20"
                        required>
                </div>

                <div class="span-wrapper">
                    <label class="labels">Retype Password:</label>
                    <span id="passwordError" class="error"></span>
                </div>

                <input type="password"
                    name="retypePassword"
                    id="retypePassword"
                    class="inputs spacing"
                    maxlength="20"
                    required>

                <div class="checkbox-wrapper">
                    <label class="labels">Click to show password</label>
                    <input type="checkbox"
                        name="revealPass"
                        id="revealPass"
                        onclick="showPassword()">
                </div>
                <div class="button-wrapper">
                    <button type="submit" id="accountButton" class="inputs buttons">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('signup').addEventListener('input', function () {
            validateForm();
        });

        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('retypePassword').value;
            const errorElement = document.getElementById('passwordError');

            if (password !== confirmPassword) {
                errorElement.textContent = 'Passwords must match';
                errorElement.classList.remove('success');
                errorElement.classList.add('error');
            } else {
                errorElement.textContent = 'Passwords match';
                errorElement.classList.remove('error');
                errorElement.classList.add('success');
            }
        }
    </script>
</body>
</html>