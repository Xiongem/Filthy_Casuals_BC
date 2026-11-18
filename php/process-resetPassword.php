<?php
ob_start();

require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$token = $_POST["token"];
$token_hash = hash("sha256", $token);

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

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);


// prepare and bind
$stmt = $_SESSION["conn"] -> prepare("UPDATE users 
        SET password_hash = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE user_id = ?");
$stmt->bind_param("si",
                        $password_hash,
                        $user["user_id"]);

    if ($stmt -> execute()) {
        header("Location: /login.php");
        exit;
    } else {
        die("an unexpected error occured");
    }
    $stmt -> close();
    mysqli_close($conn);
?>