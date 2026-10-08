<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

    ob_start();
    require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
    dbConnect();

    if (!isset($_SESSION['passcode_verified']) || $_SESSION['passcode_verified'] !== true) {
        header("Location: onetimePasscode.php");
        exit;
    }
    
// $user_id = $_POST['user_id'];
$user_id = $_GET['user_id'];
$_SESSION["createAccount"] = true;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["username"])) {
        die("Username is required");
    }

    if (! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        die("Valid email is required");
    }

    if (strlen($_POST["password"]) < 8) {
        die("Password must be at least 8 characters");
    }

    if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
        die("Password must contain at least one letter");
    }

    if ( ! preg_match("/[0-9]/i", $_POST["password"])) {
        die("Password must contain at least one number");
    }

    if ($_POST["password"] !== $_POST["retypePassword"]) {
        die("Passwords must match");
    }

echo "hello 1";
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

//     $image = $_FILES['profilePicture']['name'];

// $tmp = $_FILES['profilePicture']['tmp_name'];

// $folder = "uploads/".$image;




    $filename = $_FILES['profilePicture']['name'];
        $tempname = $_FILES['profilePicture']['tmp_name'];
        $folder = "./images/userPFP/" . $filename;

    if ($_POST["username"] && $_POST["email"] && $_POST["password"] && $filename) {
        $stmt = $_SESSION["conn"] -> prepare("INSERT INTO users (user_id, username, email, password_hash, pfp) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss",
                            $user_id,
                            $_POST["username"],
                            $_POST["email"],
                            $password_hash,
                            $filename);


        if ($stmt -> execute() && move_uploaded_file($tempname, $folder)) {
            $sql = sprintf("SELECT * FROM users
                            WHERE username = '%s'",
                            $_SESSION["conn"]->real_escape_string($_POST["username"]));

            $result = $_SESSION["conn"]->query($sql);

            $user = $result->fetch_assoc();

                unset($_SESSION['createAccount']);
                $_SESSION["user_id"] = $user["user_id"];
                
                header("Location: /mailVerification.php");
                exit;
            } else {
                die("something went wrong");
        }
    } else {
        $_SESSION["createAccount"] = false;
                echo "something went wrong 2";
        // header("Location: /createAccount.php");
    }

    // $stmt -> close();
    // mysqli_close($conn);
}
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
    <script>
        function checkName(){
            var username = document.getElementById("username").value;
            
            if(username){
                $.ajax({
                type: 'post',
                url: 'php/checkData.php',
                data: {
                    username: username,
                },
                success: function (data) {
                    $('#user-availability-status').html(data);
                }
                });
            }
            else{
                $('#user-availability-status').html("");
                console.log("Something went wrong")
                return false;
            }
        }
        function checkEmail(){
            var email = document.getElementById("email").value;
            
            if(email){
                $.ajax({
                type: 'post',
                url: 'php/checkData.php',
                data: {
                    email: email,
                },
                success: function (data) {
                    $('#email-availability-status').html(data);
                }
                });
            }
            else{
                $('#email-availability-status').html("");
                console.log("Something went wrong")
                return false;
            }
        }
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="wrapper-content">
            <div class="title-wrapper">
                <h1>Account Creation</h1>
            </div>
            <form id="signup" action="#" method="post" enctype="multipart/form-data">
                <label class="labels">Email:</label>
                <input type="email"
                    name="email"
                    id="email"
                    class="inputs"
                    onchange="checkEmail();"
                    required>

                <span id="email-availability-status"></span>

                <label class="labels">Name/Nickname:</label>
                <input type="text"
                    name="username"
                    id="username"
                    class="inputs"
                    onchange="checkName();"
                    required>

                <span id="user-availability-status"></span>

                <label class="labels">Password:</label>
                <input type="password"
                    name="password"
                    id="password"
                    class="inputs"
                    required>

                <div class="span-wrapper">
                    <label class="labels">Retype Password:</label>
                    <span id="passwordError" class="error"></span>
                </div>

                <input type="password"
                    name="retypePassword"
                    id="retypePassword"
                    class="inputs"
                    required>

                <div class="checkbox-wrapper">
                    <label class="labels">Click to show password</label>
                    <input type="checkbox"
                        name="revealPass"
                        id="revealPass"
                        onclick="showPassword()">
                </div>

                <div class="upload-wrapper">
                    <label class="labels">Upload Profile Picture:</label>
                    <div class="profile-picture">
                        <h1 class="upload-icon">
                            <i class="fa fa-plus fa-2x" aria-hidden="true"></i>
                        </h1>
                        <input
                            name="profilePicture"
                            class="file-uploader"
                            type="file"
                            onchange="upload()"
                            
                            value="">
                    </div>
                </div>

                <?php if ($_SESSION["createAccount"] === false): ?>
                    <em class="required">Please Fill Out All Fields</em>
                <?php endif; ?>

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