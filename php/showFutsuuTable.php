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
$stmt4 = $_SESSION["conn"]->query("SELECT * FROM users WHERE league = 'Futsuu' ORDER BY pointsYear DESC");
$rowFutsuu = mysqli_num_rows($stmt4);
if($rowFutsuu > 0) {
    $rankFutsuu = 0;
    while ($rowFutsuu = mysqli_fetch_array($stmt4)) {
        $idFutsuu = $rowFutsuu["user_id"];
        $usernameFutsuu = $rowFutsuu["username"];
        $pointsFutsuu = $rowFutsuu["pointsYear"];
        $imageName = htmlspecialchars($rowFutsuu["pfpName"]);
        $imageType = $rowFutsuu["pfpType"];
        $imageData = base64_encode($rowFutsuu["pfpData"]);
        if (isset($rowFutsuu['color'])) {
            $color = $rowFutsuu['color'];
        } else {
            $color = "#2b361c";
        }
            $rankFutsuu++;
?>
    <div class="table-rows">
        <div class="tr"><?=$rankFutsuu?></div>
        <div class="tr userLink" onclick="goUser('<?=$idFutsuu?>')" style="color: <?=$color?>">
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