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
echo $bingoName;
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
<body id="body">
    <div class="popup-wrapper hide" id="editPopup">
        <div class="popup-container">
            <div class="close-wrapper">
                <ion-icon name="close" onclick="closeLeagueEdit()"></ion-icon>
            </div>
            <!--//* AJAX DISPLAYED CONTENT -->
            <div class="popup-content" id="editResults"></div>
        </div>
    </div>
    <div class="popup-wrapper hide" id="bingoPopup">
        <div class="popup-container">
            <div class="close-wrapper">
                <ion-icon name="close" onclick="closeBingoPopup()"></ion-icon>
            </div>
            <div class="bingo-title">
                <h3>Assign Bingo Squares</h3>
            </div>
            <div class="label-wrapper">
                <label>Bingo Dimensions:</label>
                <select name="bingoSize" id="bingoSize" class="inputs"  onchange="createInputs()">
                    <option value="4">4x4</option>
                    <option value="5">5x5</option>
                    <option value="6">6x6</option>
                    <option value="7">7x7</option>
                    <option value="8">8x8</option>
                    <option value="9">9x9</option>
                    <option value="10">10x10</option>
                </select>
            </div>
            <div class="popup-content" id="bingoResults"></div>
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
            <div class="buttons" onclick="showBingoPopup()">BINGO!</div>
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
                        $idOverall = $rowOverall["user_id"];
                        $usernameOverall = $rowOverall["username"];
                        $pointsOverall = $rowOverall["pointsYear"];
                        $imageName = htmlspecialchars($rowOverall['pfpName']);
                        $imageType = $rowOverall['pfpType'];
                        $imageData = base64_encode($rowOverall['pfpData']);
                            $rankOverall++;  
                    ?>

                    <div class="table-rows">
                        <div class="tr"><?=$rankOverall?></div>
                        <div class="tr userLink" onclick="goUser('<?=$idOverall?>')">
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
                        $idLeague = $rowLeague['user_id'];
                        $usernameLeague = $rowLeague["username"];
                        $pointsLeague = $rowLeague["pointsYear"];
                        $imageName = htmlspecialchars($rowLeague['pfpName']);
                        $imageType = $rowLeague['pfpType'];
                        $imageData = base64_encode($rowLeague['pfpData']);
                            $rankLeague++;
                ?>
                    <div class="table-rows">
                        <div class="tr"><?=$rankLeague?></div>
                        <div class="tr userLink" onclick="goUser('<?=$idLeague?>')">
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
                <ion-icon class="league-edit" name="cog-outline" onclick="showLeagueEdit('Gorogoro')"></ion-icon>
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
                    if($rowGoro > 0) {
                        $rankGoro = 0;
                        while ($rowGoro = mysqli_fetch_array($stmt3)) {
                            $idGoro = $rowGoro["user_id"];
                            $usernameGoro = $rowGoro["username"];
                            $pointsGoro = $rowGoro["pointsYear"];
                            $imageName = htmlspecialchars($rowGoro['pfpName']);
                            $imageType = $rowGoro['pfpType'];
                            $imageData = base64_encode($rowGoro['pfpData']);
                                $rankGoro++;
                    ?>
                        <div class="table-rows">
                            <div class="tr"><?=$rankGoro?></div>
                            <div class="tr userLink" onclick="goUser('<?=$idGoro?>')">
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
                <ion-icon class="league-edit" name="cog-outline" onclick="showLeagueEdit('Futsuu')"></ion-icon>
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
                    if($rowFutsuu > 0) {
                        $rankFutsuu = 0;
                        while ($rowFutsuu = mysqli_fetch_array($stmt4)) {
                            $idFutsuu = $rowFutsuu["user_id"];
                            $usernameFutsuu = $rowFutsuu["username"];
                            $pointsFutsuu = $rowFutsuu["pointsYear"];
                            $imageName = htmlspecialchars($rowFutsuu['pfpName']);
                            $imageType = $rowFutsuu['pfpType'];
                            $imageData = base64_encode($rowFutsuu['pfpData']);
                                $rankFutsuu++;
                    ?>
                        <div class="table-rows">
                            <div class="tr"><?=$rankFutsuu?></div>
                            <div class="tr userLink" onclick="goUser('<?=$idFutsuu?>')">
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
                <ion-icon class="league-edit" name="cog-outline" onclick="showLeagueEdit('Hayai')"></ion-icon>
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
                    if($rowHayai > 0) {
                        $rankHayai = 0;
                        while ($rowHayai = mysqli_fetch_array($stmt5)) {
                            $idHayai = $rowHayai["user_id"];
                            $usernameHayai = $rowHayai["username"];
                            $pointsHayai = $rowHayai["pointsYear"];
                            $imageName = htmlspecialchars($rowHayai['pfpName']);
                            $imageType = $rowHayai['pfpType'];
                            $imageData = base64_encode($rowHayai['pfpData']);
                                $rankHayai++;
                    ?>
                        <div class="table-rows">
                            <div class="tr"><?=$rankHayai?></div>
                            <div class="tr userLink" onclick="goUser('<?=$idHayai?>')">
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
                <ion-icon class="league-edit" name="cog-outline" onclick="showLeagueEdit('Yabai')"></ion-icon>
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
                    if($rowYabai > 0) {
                        $rankYabai = 0;
                        while ($rowYabai = mysqli_fetch_array($stmt6)) {
                            $idYabai = $rowYabai["user_id"];
                            $usernameYabai = $rowYabai["username"];
                            $pointsYabai = $rowYabai["pointsYear"];
                            $imageName = htmlspecialchars($rowYabai["pfpName"]);
                            $imageType = $rowYabai["pfpType"];
                            $imageData = base64_encode($rowYabai["pfpData"]);
                                $rankYabai++;
                    ?>
                        <div class="table-rows">
                            <div class="tr"><?=$rankYabai?></div>
                            <div class="tr userLink" onclick="goUser('<?=$idYabai?>')">
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
        function goUser(userId) {
            window.location.href = "readHistory.php?user_id=" + userId;
        }
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
                    $("#editResults").html(result);
                }
            });
        }
        function closeLeagueEdit() {
            $("#editPopup").hide();
            $("#body").css({"height": "unset", "overflow": "unset"});
            location.reload(true);
        }

        function showBingoPopup() {
            $("#bingoPopup").css("display", "flex");
            var editPopup = document.getElementById("bingoPopup");
            editPopup.scrollIntoView();
            setTimeout(hideBackground, 500);
        }
        function closeBingoPopup() {
            $("#bingoPopup").hide();
            $("#body").css({"height": "unset", "overflow": "unset"});
            location.reload(true);
        }

        function createInputs() {
            var bingoSize = $("#bingoSize").val();
            for (let i = 0; i < bingoSize.length; i++) {
                var bingoSelect = [ 
                    <?php $stmt7 = $_SESSION["conn"]->query("SELECT * FROM `bingo` WHERE `user_id` = $userID AND `bingo_name` = '$bingoName'"); 
                            $bingorow = mysqli_num_rows($stmt7);
                        if ($bingorow > 0) {
                            while ($bingorow = mysqli_fetch_array($stmt7)) {
                                $bingoID = $bingorow["bingo_id"];
                                $bingoTitle = $bingorow["title"];
                                $bingoAuthor = $bingorow["author"];
                                $bingoPoints = $bingorow["total_points"];?>
                                {val : <?=$bingoTitle?>, text: '<?=$bingoTitle?> by <?=$bingoAuthor?>'}
                        <?php }} ?>
                ];

                var sel = $('<select>').appendTo('#bingoResults');
                $(bingoSelect).each(function() {
                    sel.append($("<option>").attr('value',this.val).text(this.text));
                });
            }
        }
    </script>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>