<?php
$token = $_GET["token"];
$token_hash = hash("sha256", $token);

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$sql = "SELECT verification_hash, verification_expires_at FROM users WHERE verification_hash = ?";
    $stmt = $_SESSION["conn"] -> prepare($sql);
    $stmt->bind_param("s", 
                        $token_hash);
    $stmt -> execute() ;

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["verification_expires_at"]) <= time()) {
    die("token has expired");
}

if ($user["verification_hash"] === $token_hash) {
    $verified = 1;
    $token_hash = "";
    $expiry = null;
    $userID = $_SESSION["user_id"];

    $sql = "UPDATE users SET verified = ?, verification_hash = ?, verification_expires_at = ? WHERE user_id = ?";
        $stmt = $_SESSION["conn"] -> prepare($sql);
        $stmt->bind_param("issi", 
                                $verified, 
                                $token_hash,
                                $expiry,
                                $userID);
        $stmt -> execute() ;
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
    <title>Verification Sent</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="javascript/scripts.js"></script>
    <script src="https://use.fontawesome.com/fe459689b4.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
   <?= makeNav() ?>
    <div class="login-wrapper">
        <div class="login-content">
            <h1>Account Creation</h1>
            <p>Thank you for creating an account with us! <br>
                Your email has been verified. <br>
                You can now log in to your account.
            </p>
        </div>
    </div>

    <div class="login-wrapper">
        <a href="login.php">Back to Login</a>
    </div>
</body>
</html>