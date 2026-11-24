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
            $janDescr = $challenge["jan_descr"];
            $febDescr = $challenge["feb_descr"];
            $marchDescr = $challenge["march_descr"];
            $aprilDescr = $challenge["april_descr"];
            $mayDescr = $challenge["may_descr"];
            $juneDescr = $challenge["june_descr"];
            $julyDescr = $challenge["july_descr"];
            $augDescr = $challenge["aug_descr"];
            $septDescr = $challenge["sept_descr"];
            $octDescr = $challenge["oct_descr"];
            $novDescr = $challenge["nov_descr"];
            $decDescr = $challenge["dec_descr"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="Filthy Casual Book Challenge"> 
    <meta property="og:description" content="A competition for filthy casuals."> 
    <meta property="og:image" content="https://filthycasualsbc.com/images/FCBClogo.svg"> 
    <meta property="og:url" content="https://filthycasualsbc.com/challenges.php">
    <title>Challenges Edit</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="css/rules-and-challenges.css"> -->
    <link rel="stylesheet" href="css/admin.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body id="body">
    <header>
        <?= makeNav() ?>
    </header>
    <div class="full-wrapper">
        <div class="wrapper-content" id="challenge-wrapper">
            <div class="title-wrapper">
                <h2>Monthly Challenges</h2>
            </div>
            <form class="form-wrapper" method="post" action="php/process-updateChallenges.php">
                <div class="row">
                    <div class="month">Jan:</div>
                    <input class="inputs" name="month_jan" id="jan" value="<?=$jan?>">
                    <textarea class="inputs" name="jan_Descr" id="janDescr" maxlength="400"><?=$janDescr?></textarea>
                </div>
                <div class="row">
                    <div class="month">Feb:</div>
                    <input class="inputs" name="month_feb" id="feb" value="<?=$feb?>">
                    <textarea class="inputs" name="feb_Descr" id="febDescr" maxlength="400"><?=$febDescr?></textarea>
                </div>
                <div class="row">
                    <div class="month">March:</div>
                    <input class="inputs" name="month_march" id="march" value="<?=$march?>">
                    <textarea class="inputs" name="march_Descr" id="marchDescr" maxlength="400"><?=$marchDescr?></textarea>
                </div>
                <div class="row">
                    <div class="month">April:</div>
                    <input class="inputs" name="month_april" id="april" value="<?=$april?>">
                    <textarea class="inputs" name="april_Descr" id="aprilDescr" maxlength="400"><?=$aprilDescr?></textarea>
                </div>
                <div class="row">
                    <div class="month">May:</div>
                    <input class="inputs" name="month_may" id="may" value="<?=$may?>">
                    <textarea class="inputs" name="may_Descr" id="mayDescr" maxlength="400"><?=$mayDescr?></textarea>
                </div>
                <div class="row">
                    <div class="month">June:</div>
                    <input class="inputs" name="month_june" id="june" value="<?=$june?>">
                    <textarea class="inputs" name="june_Descr" id="juneDescr" maxlength="400"><?=$juneDescr?></textarea>
                </div>
                <div class="row">
                    <div class="month">July:</div>
                    <input class="inputs" name="month_july" id="july" value="<?=$july?>">
                    <textarea class="inputs" name="july_Descr" id="julyDescr" maxlength="400"><?=$julyDescr?></textarea>
                </div>
                <div class="row">
                    <div class="month">Aug:</div>
                    <input class="inputs" name="month_aug" id="aug" value="<?=$aug?>">
                    <textarea class="inputs" name="aug_Descr" id="augDescr" maxlength="400"><?=$augDescr?></textarea>
                </div>
                <div class="row">
                    <div class="month">Sept:</div>
                    <input class="inputs" name="month_sept" id="sept" value="<?=$sept?>">
                    <textarea class="inputs" name="sept_Descr" id="septDescr" maxlength="400"><?=$septDescr?></textarea>
                </div>
                <div class="row">
                    <div class="month">Oct:</div>
                    <input class="inputs" name="month_oct" id="oct" value="<?=$oct?>">
                    <textarea class="inputs" name="oct_Descr" id="octDescr" maxlength="400"><?=$octDescr?></textarea>
                </div>
                <div class="row">
                    <div class="month">Nov:</div>
                    <input class="inputs" name="month_nov" id="nov" value="<?=$nov?>">
                    <textarea class="inputs" name="nov_Descr" id="novDescr" maxlength="400"><?=$novDescr?></textarea>
                </div>
                <div class="row">
                    <div class="month">Dec:</div>
                    <input class="inputs" name="month_dec" id="dec" value="<?=$dec?>">
                    <textarea class="inputs" name="dec_Descr" id="decDescr" maxlength="400"><?=$decDescr?></textarea>
                </div>
            
                <div class="button-wrapper" id="challenge-button-wrapper">
                    <button class="buttons" type="submit">set</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function log(text) {
            var txtArea = $('textarea');
            txtArea.value += text + '\r\n';
        }
    </script>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>