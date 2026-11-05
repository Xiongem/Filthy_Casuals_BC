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

//  $sql = "SELECT * FROM users WHERE user_id = $userID";
//         $result = $_SESSION["conn"]->query($sql);
//         $user = $result->fetch_assoc();
//             $admin = $user['admin'];
//             $imageName = htmlspecialchars($user['pfpName']);
//                 $imageType = $user['pfpType'];
//                 $imageData = base64_encode($user['pfpData']);
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
    <title>Home</title>
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
    <div class="full-wrapper">
        <div class="overall-wrapper">
            <div class="title">
                <h1>
                    Overall Ranking
                </h1>
                <ion-icon size="large" class="caret" name="caret-down-outline" id="listOpen" onclick="hideOverall()"></ion-icon>
                <ion-icon size="large" class="caret" name="caret-up-outline" id="listClose" onclick="showOverall()"></ion-icon>
            </div>
            <div class="content-wrapper" id="overall">
                <div class="thead-wrapper">
                    <div class="thead">Rank</div>
                    <div class="thead">User</div>
                    <div class="thead">Points</div>
                </div>
                <!--//? DISPLAY RANKINGS HERE -->
                <?php if ($stmt = $_SESSION["conn"]->prepare("SELECT * FROM users ORDER BY pointsYear DESC")) {
                    $stmt->execute(); 
                    // Get the results...
                    $result = $stmt->get_result();
                    $stmt->close();
                    
                    $rank = 0;
                    while ($row = $result->fetch_assoc()) {
                        $username = $row["username"];
                        $points = $row["pointsYear"];
                        $rank++;  
                    ?>

                    <div class="overall-rows">
                        <div class="tr"><?=$rank?></div>
                        <div class="tr"><?=$username?></div>
                        <div class="tr"><?=$points?></div>
                    </div>
                <?php }} ?>
            </div>
        </div>
    </div>
    <script>
        function hideOverall() {
            $("#overall").hide();
            $("#listOpen").show();
            $("#listClose").hide();
        }
        function showOverall() {
            $("#overall").show();
            $("#listOpen").hide();
            $("#listClose").show();
        }
    </script>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>