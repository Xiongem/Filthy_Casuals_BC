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
$stmt3 = $_SESSION["conn"]->query("SELECT * FROM users WHERE league = 'Gorogoro' ORDER BY pointsYear DESC");
$rowGoro = mysqli_num_rows($stmt3);
if($rowGoro > 0) {
    $rankGoro = 0;
    while ($rowGoro = mysqli_fetch_array($stmt3)) {
        $idGoro = $rowGoro["user_id"];
        $usernameGoro = $rowGoro["username"];
        $pointsGoro = $rowGoro["pointsYear"];
        $imageName = htmlspecialchars($rowGoro["pfpName"]);
        $imageType = $rowGoro["pfpType"];
        $imageData = base64_encode($rowGoro["pfpData"]);
        if (isset($rowGoro['color'])) {
            $color = $rowGoro['color'];
        } else {
            $color = "#2b361c";
        }
            $rankGoro++;
?>
    <div class="table-rows">
        <div class="tr"><?=$rankGoro?></div>
        <div class="tr userLink" onclick="goUser('<?=$idGoro?>')" style="color: <?=$color?>">
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