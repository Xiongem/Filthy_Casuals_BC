<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    ob_start();
    require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
    dbConnect();

    //query
    $sql = sprintf("SELECT * FROM users
                    WHERE username = '%s'",
                    $_SESSION["conn"]->real_escape_string($_POST["username"]));

    $result = $_SESSION["conn"]->query($sql);

    $user = $result->fetch_assoc();

    if ($user) {
        if ($user["verified"] == 1) {
            if (password_verify($_POST["password"], $user["password_hash"]) ){

                session_start();

                $_SESSION['loggedin'] = true;
                $_SESSION["user_id"] = $user["user_id"];

                    header("Location: index.php");
                exit;
            }
        } 
    }

    $is_invalid = true;

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
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="wrapper">
        <div class="wrapper-content">
            <div class="title-wrapper">
                <h1>Login</h1>
            </div>
            <label for="email" class="labels">Email:</label>
            <input type="email"
                name="email"
                id="email"
                class="inputs"
                required>
            <label for="password" class="labels">Password:</label>
            <input type="password"
                name="password"
                id="password"
                class="inputs"
                required>
            <div class="button-wrapper">
                <button type="submit" id="loginButton" class="inputs buttons">Login</button>
            </div>
            <div class="link-wrapper">
                <a href="onetimePasscode.php">Account Creation</a>
                <a href="">Forgot Password?</a>
            </div>
        </div>
    </div>
</body>
</html>