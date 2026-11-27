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
$stmt5 = $_SESSION["conn"]->query("SELECT * FROM users WHERE league = 'Hayai' ORDER BY pointsYear DESC");
$rowHayai = mysqli_num_rows($stmt5);
if($rowHayai > 0) {
    $rankHayai = 0;
    while ($rowHayai = mysqli_fetch_array($stmt5)) {
        $idHayai = $rowHayai["user_id"];
        $usernameHayai = $rowHayai["username"];
        $pointsHayai = $rowHayai["pointsYear"];
        $imageName = htmlspecialchars($rowHayai["pfpName"]);
        $imageType = $rowHayai["pfpType"];
        $imageData = base64_encode($rowHayai["pfpData"]);
        if (isset($rowHayai['color'])) {
            $color = $rowHayai['color'];
        } else {
            $color = "#2b361c";
        }
            $rankHayai++;
?>
    <div class="table-rows">
        <div class="tr"><?=$rankHayai?></div>
        <div class="tr userLink" onclick="goUser('<?=$idHayai?>')" style="color: <?=$color?>">
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