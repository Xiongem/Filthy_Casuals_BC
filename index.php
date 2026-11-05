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
            $league = $user["league"];
            $admin = $user["admin"];
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
        <div class="table-wrapper">
            <div class="title">
                <h1>
                    Overall Ranking
                </h1>
                <ion-icon size="large" class="caret" name="caret-down-outline" id="overallClose" onclick="hideTable('#overall', '#overallClose', '#overallOpen')"></ion-icon>
                <ion-icon size="large" class="caret" name="caret-up-outline" id="overallOpen" onclick="showTable('#overall', '#overallOpen', '#overallClose')"></ion-icon>
            </div>
            <div class="content-wrapper" id="overall">
                <div class="thead-wrapper">
                    <div class="thead">Rank</div>
                    <div class="thead">User</div>
                    <div class="thead">Points</div>
                </div>
                <!--//? DISPLAY RANKINGS HERE -->
                <?php if ($stmt1 = $_SESSION["conn"]->prepare("SELECT * FROM users ORDER BY pointsYear DESC")) {
                    $stmt1->execute(); 
                    // Get the results...
                    $result1 = $stmt1->get_result();
                    $stmt1->close();
                    
                    $rankOverall = 0;
                    while ($rowOverall = $result1->fetch_assoc()) {
                        $usernameOverall = $rowOverall["username"];
                        $pointsOverall = $rowOverall["pointsYear"];
                        $rankOverall++;  
                    ?>

                    <div class="table-rows">
                        <div class="tr"><?=$rankOverall?></div>
                        <div class="tr"><?=$usernameOverall?></div>
                        <div class="tr"><?=$pointsOverall?></div>
                    </div>
                <?php }} ?>
            </div>
        </div>
        <div class="table-wrapper">
            <div class="title">
                <h1>
                    <?=$league?> Ranking
                </h1>
                <ion-icon size="large" class="caret" name="caret-down-outline" id="leagueClose" onclick="hideTable('#league', '#leagueClose', '#leagueOpen')"></ion-icon>
                <ion-icon size="large" class="caret" name="caret-up-outline" id="leagueOpen" onclick="showTable('#league', '#leagueOpen', '#leagueClose')"></ion-icon>
            </div>
            <div class="content-wrapper" id="overall">
                <div class="thead-wrapper">
                    <div class="thead">Rank</div>
                    <div class="thead">User</div>
                    <div class="thead">Points</div>
                </div>
                <!--//? DISPLAY RANKINGS HERE -->
                <?php if ($stmt2 = $_SESSION["conn"]->prepare("SELECT * FROM users WHERE league = ? ORDER BY points DESC")) {
                    $stmt2->bind_param('s', $league);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    $stmt2->close();

                    $rankLeague = 0;
                    while ($rowLeague = $result2->fetch_assoc()) {
                        $usernameLeague = $rowLeague["username"];
                        $pointsLeague = $rowLeague["points"];
                        $rankLeague++;
                ?>
                    <div class="table-rows">
                        <div class="tr"><?=$rankLeague?></div>
                        <div class="tr"><?=$usernameLeague?></div>
                        <div class="tr"><?=$pointsLeague?></div>
                    </div>
                <?php }} ?>
        </div>
    </div>
    <script>
        function hideTable(tableId, closeIconId, openIconId) {
            $(tableId).css("display", "none");
            $(closeIconId).css("display", "none");
            $(openIconId).css("display", "block");
        }
        function showTable(tableId, openIconId, closeIconId) {
            $(tableId).css("display", "flex");
            $(closeIconId).css("display", "block");
            $(openIconId).css("display", "none");
        }
    </script>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>