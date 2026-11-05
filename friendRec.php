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

// $sql1 = "SELECT * FROM users WHERE user_id = $userID";
//     $result1 = $_SESSION["conn"]->query($sql1);
//     $user = $result1->fetch_assoc();
//         $username = $user["username"];

$sql2 = "SELECT * From `friendRecs`";
    $result2 = $_SESSION["conn"]->query($sql2);
    $read = $result2->fetch_assoc();
        if (isset($read)) {
            $ID = $read["user_id"];
            $username = $read["username"];
            $title = $read["title"];
            $author = $read["author"];
            $series = $read["series"];
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
    <title>Friend Recs</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <?= makeNav() ?>
    </header>
    <div class="rec-input-button" onclick="showRecPopup()">
        <p>update</p>
    </div>
    <div class="wrapper">
        <div class="rec-wrapper">
            <div class="name" id="<?=$username?>"><?=$username?></div>
            <div class="read-wrapper"></div>
                <div class="title" id="<?=$title?>"><?=$title?></div>
                <div class="author" id="<?=$author?>"><?=$author?></div>
        </div>
    </div>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>