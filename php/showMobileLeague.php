<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$league = $_POST["league"];
?>
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
        if (isset($rowLeague['color'])) {
            $color = $rowLeague['color'];
        } else {
            $color = "#2b361c";
        }
            $rankLeague++;
?>
    <div class="table-rows">
        <div class="tr"><?=$rankLeague?></div>
        <div class="tr userLink"  style="color: <?=$color?>">
            <?=$usernameLeague?>
        </div>
        <div class="tr"><?=$pointsLeague?></div>
    </div>
<?php }} ?>