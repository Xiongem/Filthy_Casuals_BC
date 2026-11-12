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

$sql = "SELECT * FROM users WHERE user_id = $userID";
    $result = $_SESSION["conn"]->query($sql);
    $user = $result->fetch_assoc();
        $admin = $user['admin'];

$sql2 = "SELECT * FROM `challenges`";
    $result2 = $_SESSION["conn"]->query($sql2);
    $challenge = $result2->fetch_assoc();
        $jan = $challenge["month_jan"];
        $feb = $challenge["month_feb"];
        $march = $challenge["month_march"];
        $april = $challenge["month_april"];
        $may = $challenge["month_may"];
        $june = $challenge["month_june"];
        $july = $challenge["month_july"];
        $aug = $challenge["month_aug"];
        $sept = $challenge["month_sept"];
        $oct = $challenge["month_oct"];
        $nov = $challenge["month_nov"];
        $dec = $challenge["month_dec"];
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
    <title>Challenges</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/rules-and-challenges.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <?= makeNav() ?>
    </header>
    <div class="challenge-wrapper">
        <div class="challenge-content">
            <div class="title">
                <h1>Challenges</h1>
            </div>
            <div class="challenges">
                <div class="month">Jan:</div>
                <div class="info"><?=$jan?></div>
                <div class="month">Feb:</div>
                <div class="info"><?=$feb?></div>
                <div class="month">March:</div>
                <div class="info"><?=$march?></div>
                <div class="month">April:</div>
                <div class="info"><?=$april?></div>
                <div class="month">May:</div>
                <div class="info"><?=$may?></div>
                <div class="month">June:</div>
                <div class="info"><?=$june?></div>
                <div class="month">July:</div>
                <div class="info"><?=$july?></div>
                <div class="month">Aug:</div>
                <div class="info"><?=$aug?></div>
                <div class="month">Sept:</div>
                <div class="info"><?=$sept?></div>
                <div class="month">Oct:</div>
                <div class="info"><?=$oct?></div>
                <div class="month">Nov:</div>
                <div class="info"><?=$nov?></div>
                <div class="month">Dec:</div>
                <div class="info"><?=$dec?></div>
            </div>
        </div>
    </div>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>