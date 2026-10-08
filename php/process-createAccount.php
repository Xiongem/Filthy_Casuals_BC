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
    
$user_id = $_POST['user_id'];

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

if ($_POST["password"] !== $_POST["confirm_password"]) {
    die("Passwords must match");
}


$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$filename = $_FILES["profilePicture"]["name"];
    $tempname = $_FILES["profilePicture"]["tmp_name"];
    $folder = "./images/userPFP/" . $filename;

if ($_POST["username"] && $_POST["email"] && $_POST["password"] && $_POST["profilePicture"]) {
    $stmt = $_SESSION["conn"] -> prepare("INSERT INTO users (user_id, username, email, password_hash, pfp) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss",
                        $_POST["user_id"],
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
            
    header("Location: /createAccount.php");
}


$stmt -> close();
mysqli_close($conn);
?>