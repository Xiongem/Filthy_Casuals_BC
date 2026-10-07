<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    ob_start();
    require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
    dbConnect();
    
    echo "hello 1";
    //query
    $sql = sprintf("SELECT * FROM one_time_passcodes
                    WHERE passcode = '%s'",
                    $_SESSION["conn"]->real_escape_string($_POST["OTP"]));

    $result = $_SESSION["conn"]->query($sql);

    $passcode = $result->fetch_assoc();
    $OTP = $passcode['oneTimePass'];
    $user_id = $passcode['user_id'];

    if ($passcode) {
        if ($OTP === $_POST["OTP"]) {
            echo "hello 2";
            session_start();
            $_SESSION['passcode_verified'] = true;
            header("Location: createAccount.php?user_id=" . $user_id);
            exit;
        }
        else {
            $_SESSION['passcode_verified'] = false;
        }
    }
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
    <title>One-time Passcode</title>
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
                <h1>Account Creation Checkpoint</h1>
            </div>
            <div class="label-wrapper">
                <label class="labels">One-time Passcode:</label>
                    <div class="questionMark-wrapper">
                        <img id="questionMark" src="images/questionMark.webp" alt="question mark icon">
                        <div class="popup-wrapper" id="OTPExplain">
                            <div class="popup">
                                <h4>This is a closed site that's only available to members.</h4>
                                <h4>If you're part of the Book Challenge on discord, reach out to 
                                    the site dev who will give you a one-time passcode to input below.</h4>
                            </div>
                        </div>
                    </div>
            </div>
            <form action="#" method="post">
                <input type="text"
                    name="OTP"
                    id="OTP"
                    class="inputs"
                    required>
                <div class="button-wrapper">
                    <button type="submit" id="OTPButton" class="inputs buttons">Submit</button>
                </div>
            </form>
            <!-- <a href="createAccount.php">account creation</a> -->
        </div>
    </div>
</body>
</html>