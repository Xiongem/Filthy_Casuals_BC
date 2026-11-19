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

$sql2 = "SELECT * FROM `adminStuff` WHERE `adminID` = 1";
    $result2 = $_SESSION["conn"]->query($sql2);
    $adminStuff = $result2->fetch_assoc();
        if (isset($adminStuff)) {
            $ratStart = strtotime($adminStuff["ratStart"]);
            $ratEnd = strtotime($adminStuff["ratEnd"]);
        }
    
$sql3 = "SELECT * FROM `bingoNames` WHERE `active` = 1";
    $result3 = $_SESSION["conn"]->query($sql3);
    $bingo = $result3->fetch_assoc();
    if (isset($bingo)) {
        $bingoActive = $bingo["active"];
        $bingoName = $bingo["bingo_name"];   
    } else {
        $bingoActive = 0;
    }

$now = strtotime(date("Y-m-d"));

if ($now <= $ratEnd) {
    $ratActive = true;
    $ratStart = date("m/d/Y", $ratStart);
    $ratEnd = date("m/d/Y", $ratEnd);
} else {
    $ratActive = false;
}

//! REMOVE PHP IF LOAD TIMES ARE STILL TOO SLOW

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="Filthy Casual Book Challenge"> 
    <meta property="og:description" content="A competition for filthy casuals."> 
    <meta property="og:image" content="https://filthycasualsbc.com/images/FCBClogo.svg"> 
    <meta property="og:url" content="https://filthycasualsbc.com/index.php">
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body id="body">
    <div class="popup-wrapper hide" id="editPopup">
        <div class="popup-container">
            <div class="close-wrapper">
                <ion-icon name="close" onclick="closeLeagueEdit()"></ion-icon>
            </div>
            <!--//* AJAX DISPLAYED CONTENT -->
            <div class="popup-content" id="editResults">
                <div class="loader" id="loader"></div>
            </div>
        </div>
    </div>
    <header>
        <?= makeNav() ?>
    </header>
    <?php if ($ratActive === true) { ?>
        <div class="rat-wrapper">
            <div class="rat-title">
                <h2>Next Read-a-thon Date:</h2>
            </div>
            <div class="rat-date">
                <h3><?=$ratStart?>  -  <?=$ratEnd?></h3>
            </div>
        </div>
    <?php } ?>
    <?php if($bingoActive == 1) {?>
        <div class="bingo-wrapper">
            <h2><?=$bingoName?> bingo is happening now!</h2>
            <a class="buttons" href="bingo.php">BINGO!</a>
        </div>
    <?php } ?>
    <div class="full-wrapper">
        <div class="table-wrapper">
            
            <div class="title Overall">
                <h1>
                    Overall Ranking
                </h1>
                <ion-icon size="large" class="caret" name="caret-down-outline" id="overallClose" onclick="hideTable('#overall', '#overallClose', '#overallOpen')"></ion-icon>
                <ion-icon size="large" class="caret" name="caret-up-outline" id="overallOpen" onclick="showTable('#overall', '#overallOpen', '#overallClose')"></ion-icon>
                <ion-icon id="refresh" class="refresh icon rotate-center" size="large" name="refresh-circle" onclick="refreshData()"></ion-icon>
            </div>
            <div class="content-wrapper" id="overall">
                <!--//? AJAX DISPLAY OVERALL RANKINGS HERE -->
                <div class="loader-small" id="loaderOverall"></div>
            </div>
        </div>
        <div class="table-wrapper" id="mobile">
            <div class="title  <?=$league?>">
                <h1>
                    <?=$league?> Ranking
                </h1>
                <ion-icon size="large" class="caret" name="caret-down-outline" id="leagueClose" onclick="hideTable('#league', '#leagueClose', '#leagueOpen')"></ion-icon>
                <ion-icon size="large" class="caret" name="caret-up-outline" id="leagueOpen" onclick="showTable('#league', '#leagueOpen', '#leagueClose')"></ion-icon>
            </div>
            <div class="content-wrapper" id="league">
                <!--//? AJAX DISPLAY MOBILE LEAGUE HERE  -->
                <div class="loader-small" id="loaderLeague"></div>
            </div>
        </div>
        <div class="desktop-table-wrapper">
            <div class="table-wrapper">
                <?php if ($admin == 1) { ?>
                <ion-icon class="league-edit" name="cog-outline" onclick="showLeagueEdit('Gorogoro')"></ion-icon>
                <?php } ?>
                <div class="title Gorogoro">
                    <h1>
                        Gorogoro Ranking
                    </h1>
                </div>
                <div class="content-wrapper" id="Gorogoro">
                    <!--//? AJAX DISPLAY GOROGORO RANKINGS HERE -->
                    <div class="loader-small" id="loaderGoro"></div>
                </div>
            </div>
            <div class="table-wrapper">
                <?php if ($admin == 1) { ?>
                <ion-icon class="league-edit" name="cog-outline" onclick="showLeagueEdit('Futsuu')"></ion-icon>
                <?php } ?>
                <div class="title Futsuu">
                    <h1>
                        Futsuu Ranking
                    </h1>
                </div>
                <div class="content-wrapper" id="Futsuu">
                    <!--//? AJAX DISPLAY FUTSUU RANKINGS HERE -->
                    <div class="loader-small" id="loaderFutsuu"></div>
                </div>
            </div>
            <div class="table-wrapper">
                <?php if ($admin == 1) { ?>
                <ion-icon class="league-edit" name="cog-outline" onclick="showLeagueEdit('Hayai')"></ion-icon>
                <?php } ?>
                <div class="title Hayai">
                    <h1>
                        Hayai Ranking
                    </h1>
                </div>
                <div class="content-wrapper" id="Hayai">
                    <!--//? AJAX DISPLAY HAYAI RANKINGS HERE -->
                    <div class="loader-small" id="loaderHayai"></div>
                </div>
            </div>
            <div class="table-wrapper">
                <?php if ($admin == 1) { ?>
                <ion-icon class="league-edit" name="cog-outline" onclick="showLeagueEdit('Yabai')"></ion-icon>
                <?php } ?>
                <div class="title Yabai">
                    <h1>
                        Yabai Ranking
                    </h1>
                </div>
                <div class="content-wrapper" id="Yabai">
                   <!--//? AJAX DISPLAY YABAI RANKINGS HERE -->
                   <div class="loader-small" id="loaderYabai"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // display league and overall ranking data through ajax
         $(document).ready(function() {
            showOverallTable();
            showMobileLeague();
            showGoroTable();
            showFutsuuTable();
            showHayaiTable();
            showYabaiTable();
            $("#refresh").removeClass("rotate-center");
            setTimeout(refreshData, 60000)
        });
        // recall functions to display tables through ajax - set to refresh every 1 minute
        function refreshData() {
            $("#refresh").addClass("rotate-center");
            $("#loaderOverall").css("display", "block");
            showOverallTable();
            showMobileLeague();
            showGoroTable();
            showFutsuuTable();
            showHayaiTable();
            showYabaiTable();
            setTimeout(refreshData, 60000)
        }
        //display overall rankings
        function showOverallTable() {
            $.ajax({
                url: "php/showOverallTable.php",
                method: "post",
                data: {},
                success:function(result) {
                    $("#overall").html(result);
                    $("#loaderOverall").hide();
                }
            })
        }
        //display user's league
        function showMobileLeague() { 
            var league = '<?=$league?>';

            $.ajax ({
                url: "php/showMobileLeague.php",
                method: "post",
                data: {league:league},
                success:function(result) {
                    $("#league").html(result);
                    $("#loaderleague").hide();
                }
            })
        }
        //display gorogoro league
        function showGoroTable() { 
            $.ajax ({
                url: "php/showGoroTable.php",
                method: "post",
                data: {},
                success:function(result) {
                    $("#Gorogoro").html(result);
                    $("#loaderGoro").hide();
                }
            })
        }
        //display futsuu league
        function showFutsuuTable() { 
            $.ajax ({
                url: "php/showFutsuuTable.php",
                method: "post",
                data: {},
                success:function(result) {
                    $("#Futsuu").html(result);
                    $("#loaderFutsuu").hide();
                }
            })
        }
        //display hayai league
        function showHayaiTable() { 
            $.ajax({
                url: "php/showHayaiTable.php",
                method: "post",
                data: {},
                success:function(result) {
                    $("#Hayai").html(result);
                    $("#loaderHayai").hide();
                }
            })
        }
        //display yabai league
        function showYabaiTable() { 
            $.ajax({
                url: "php/showYabaiTable.php",
                method: "post",
                data: {},
                success:function(result) {
                    $("#Yabai").html(result);
                    $("#loaderYabai").hide();
                    $("#refresh").removeClass("rotate-center");
                }
            })
        }
        
        //sends user to the history page of whichever username they click on
        function goUser(userId) {
            window.location.href = "readHistory.php?user_id=" + userId;
        }

        //hides the table when the caret is clicked
        function hideTable(tableId, closeIconId, openIconId) {
            $(tableId).css("display", "none");
            $(closeIconId).css("display", "none");
            $(openIconId).css("display", "block");
        }
        //shows the table when the caret is clicked
        function showTable(tableId, openIconId, closeIconId) {
            $(tableId).css("display", "flex");
            $(closeIconId).css("display", "block");
            $(openIconId).css("display", "none");
        }

        //displays league edit popup to allow admins to move members from league to leagyue
        function showLeagueEdit(league) {
            $("#editPopup").css({"display": "flex"});
            var editPopup = document.getElementById("editPopup");
            editPopup.scrollIntoView();
            setTimeout(hideBackground, 500);

            $.ajax({
                url: 'php/ajax_league_edit.php',
                method: 'post',
                data: {leagueName:league},
                success: function(result) {
                    $("loader").hide();
                    $("#editResults").html(result);
                }
            });
        }
        //closes the league edit popup
        function closeLeagueEdit() {
            $("#editPopup").hide();
            $("#body").css({"height": "unset", "overflow": "unset"});
            location.reload(true);
        }
    </script>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>