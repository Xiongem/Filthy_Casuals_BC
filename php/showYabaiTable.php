<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();
?>

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
        if (isset($rowYabai['color'])) {
            $color = $rowYabai['color'];
        } else {
            $color = "#2b361c";
        }
            $rankYabai++;
?>
    <div class="table-rows">
        <div class="tr"><?=$rankYabai?></div>
        <div class="tr userLink" onclick="goUser('<?=$idYabai?>')" style="color: <?=$color?>">
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