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

$sql2 = "SELECT * FROM `adminStuff`";
    $result2 = $_SESSION["conn"]->query($sql2);
    $adminStuff = $result2->fetch_assoc();
        if (isset($adminStuff)) {
            $ratStart = $adminStuff["ratStart"];
            $ratEnd = $adminStuff["ratEnd"];
            $active = $adminStuff["active"];
        }

$active = 1;
$ratStart = "11/21/2026";
$ratEnd = "11/28/2026";
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
    <?php if ($active == 1) { ?>
    <div class="rat-wrapper">
        <div class="rat-title">
             <h2>Next Read-a-thon Date:</h2>
        </div>
        <div class="rat-date">
            <h3><?=$ratStart?> - <?=$ratEnd?></h3>
        </div>
    </div>
    <?php } ?>
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
                        $imageName = htmlspecialchars($rowOverall['pfpName']);
                        $imageType = $rowOverall['pfpType'];
                        $imageData = base64_encode($rowOverall['pfpData']);
                            $rankOverall++;  
                    ?>

                    <div class="table-rows">
                        <div class="tr"><?=$rankOverall?></div>
                        <div class="tr">
                            <img class="tablePfp" src="data:<?=$imageType?>;base64,<?=$imageData?>" alt="<?=$imageName?>">
                            <?=$usernameOverall?>
                        </div>
                        <div class="tr"><?=$pointsOverall?></div>
                    </div>
                <?php }} ?>
            </div>
        </div>
        <div class="table-wrapper" id="mobile">
            <div class="title">
                <h1>
                    <?=$league?> Ranking
                </h1>
                <ion-icon size="large" class="caret" name="caret-down-outline" id="leagueClose" onclick="hideTable('#league', '#leagueClose', '#leagueOpen')"></ion-icon>
                <ion-icon size="large" class="caret" name="caret-up-outline" id="leagueOpen" onclick="showTable('#league', '#leagueOpen', '#leagueClose')"></ion-icon>
            </div>
            <div class="content-wrapper" id="league">
                <div class="thead-wrapper">
                    <div class="thead">Rank</div>
                    <div class="thead">User</div>
                    <div class="thead">Points</div>
                </div>
                <!--//? DISPLAY RANKINGS HERE -->
                <?php if ($stmt2 = $_SESSION["conn"]->prepare("SELECT * FROM users WHERE league = ? ORDER BY pointsYear DESC")) {
                    $stmt2->bind_param('s', $league);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    $stmt2->close();

                    $rankLeague = 0;
                    while ($rowLeague = $result2->fetch_assoc()) {
                        $usernameLeague = $rowLeague["username"];
                        $pointsLeague = $rowLeague["pointsYear"];
                        $imageName = htmlspecialchars($rowLeague['pfpName']);
                        $imageType = $rowLeague['pfpType'];
                        $imageData = base64_encode($rowLeague['pfpData']);
                            $rankLeague++;
                ?>
                    <div class="table-rows">
                        <div class="tr"><?=$rankLeague?></div>
                        <div class="tr">
                            <img class="tablePfp" src="data:<?=$imageType?>;base64,<?=$imageData?>" alt="<?=$imageName?>">
                            <?=$usernameLeague?>
                        </div>
                        <div class="tr"><?=$pointsLeague?></div>
                    </div>
                <?php }} ?>
            </div>
        </div>
        <div class="desktop-table-wrapper">
            <div class="table-wrapper">
                <div class="title">
                    <h1>
                        Gorogoro Ranking
                    </h1>
                </div>
                <div class="content-wrapper" id="Gorogoro">
                    <div class="thead-wrapper">
                        <div class="thead">Rank</div>
                        <div class="thead">User</div>
                        <div class="thead">Points</div>
                    </div>
                    <!--//? DISPLAY RANKINGS HERE -->
                    <?php 
                    $stmt3 = $_SESSION["conn"]->query("SELECT * FROM users WHERE league = 'Gorogoro' ORDER BY pointsYear DESC");
                    $rowGoro = mysqli_num_rows($stmt3);
                    if($rowGoro>0) {
                        $rankGoro = 0;
                        while ($rowGoro = mysqli_fetch_array($stmt3)) {
                            $usernameGoro = $rowGoro["username"];
                            $pointsGoro = $rowGoro["pointsYear"];
                            $imageName = htmlspecialchars($rowGoro['pfpName']);
                            $imageType = $rowGoro['pfpType'];
                            $imageData = base64_encode($rowGoro['pfpData']);
                                $rankGoro++;
                    ?>
                        <div class="table-rows">
                            <div class="tr"><?=$rankGoro?></div>
                            <div class="tr">
                                <img class="tablePfp" src="data:<?=$imageType?>;base64,<?=$imageData?>" alt="<?=$imageName?>">
                                <?=$usernameGoro?>
                            </div>
                            <div class="tr"><?=$pointsGoro?></div>
                        </div>
                    <?php }} else { ?>
                        <div class="nothing">
                            <div class="tr">No users found</div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="table-wrapper">
                <div class="title">
                    <h1>
                        Futsuu Ranking
                    </h1>
                </div>
                <div class="content-wrapper" id="Futsuu">
                    <div class="thead-wrapper">
                        <div class="thead">Rank</div>
                        <div class="thead">User</div>
                        <div class="thead">Points</div>
                    </div>
                    <!--//? DISPLAY RANKINGS HERE -->
                    <?php 
                    $stmt4 = $_SESSION["conn"]->query("SELECT * FROM users WHERE league = 'Futsuu' ORDER BY pointsYear DESC");
                    $rowFutsuu = mysqli_num_rows($stmt4);
                    if($rowFutsuu>0) {
                        $rankFutsuu = 0;
                        while ($rowFutsuu = mysqli_fetch_array($stmt4)) {
                            $usernameFutsuu = $rowFutsuu["username"];
                            $pointsFutsuu = $rowFutsuu["pointsYear"];
                            $imageName = htmlspecialchars($rowFutsuu['pfpName']);
                            $imageType = $rowFutsuu['pfpType'];
                            $imageData = base64_encode($rowFutsuu['pfpData']);
                                $rankFutsuu++;
                    ?>
                        <div class="table-rows">
                            <div class="tr"><?=$rankFutsuu?></div>
                            <div class="tr">
                                <img class="tablePfp" src="data:<?=$imageType?>;base64,<?=$imageData?>" alt="<?=$imageName?>">
                                <?=$usernameFutsuu?>
                            </div>
                            <div class="tr"><?=$pointsFutsuu?></div>
                        </div>
                    <?php }} else { ?>
                        <div class="nothing">
                            <div class="tr">No users found</div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="table-wrapper">
                <div class="title">
                    <h1>
                        Hayai Ranking
                    </h1>
                </div>
                <div class="content-wrapper" id="Hayai">
                    <div class="thead-wrapper">
                        <div class="thead">Rank</div>
                        <div class="thead">User</div>
                        <div class="thead">Points</div>
                    </div>
                    <!--//? DISPLAY RANKINGS HERE -->
                    <?php 
                    $stmt5 = $_SESSION["conn"]->query("SELECT * FROM users WHERE league = 'Hayai' ORDER BY pointsYear DESC");
                    $rowHayai = mysqli_num_rows($stmt5);
                    if($rowHayai>0) {
                        $rankHayai = 0;
                        while ($rowHayai = mysqli_fetch_array($stmt5)) {
                            $usernameHayai = $rowHayai["username"];
                            $pointsHayai = $rowHayai["pointsYear"];
                            $imageName = htmlspecialchars($rowHayai['pfpName']);
                            $imageType = $rowHayai['pfpType'];
                            $imageData = base64_encode($rowHayai['pfpData']);
                                $rankHayai++;
                    ?>
                        <div class="table-rows">
                            <div class="tr"><?=$rankHayai?></div>
                            <div class="tr">
                                <img class="tablePfp" src="data:<?=$imageType?>;base64,<?=$imageData?>" alt="<?=$imageName?>">
                                <?=$usernameHayai?>
                            </div>
                            <div class="tr"><?=$pointsHayai?></div>
                        </div>
                    <?php }} else { ?>
                        <div class="nothing">
                            <div class="tr">No users found</div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="table-wrapper">
                <div class="title">
                    <h1>
                        Yabai Ranking
                    </h1>
                </div>
                <div class="content-wrapper" id="Yabai">
                    <div class="thead-wrapper">
                        <div class="thead">Rank</div>
                        <div class="thead">User</div>
                        <div class="thead">Points</div>
                    </div>
                    <!--//? DISPLAY RANKINGS HERE -->
                    <?php 
                    $stmt6 = $_SESSION["conn"]->query("SELECT * FROM users WHERE league = 'Yabai' ORDER BY pointsYear DESC");
                    $rowYabai = mysqli_num_rows($stmt6);
                    if($rowYabai>0) {
                        $rankYabai = 0;
                        while ($rowYabai = mysqli_fetch_array($stmt6)) {
                            $usernameYabai = $rowYabai["username"];
                            $pointsYabai = $rowYabai["pointsYear"];
                            $imageName = htmlspecialchars($rowYabai["pfpName"]);
                            $imageType = $rowYabai["pfpType"];
                            $imageData = base64_encode($rowYabai["pfpData"]);
                                $rankYabai++;
                    ?>
                        <div class="table-rows">
                            <div class="tr"><?=$rankYabai?></div>
                            <div class="tr">
                                <img class="tablePfp" src="data:<?=$imageType?>;base64,<?=$imageData?>" alt="<?=$imageName?>">
                                <?=$usernameYabai?>
                            </div>
                            <div class="tr"><?=$pointsYabai?></div>
                        </div>
                    <?php }} else { ?>
                        <div class="nothing">
                            <div class="tr">No users found</div>
                        </div>
                    <?php } ?>
                </div>
            </div>
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