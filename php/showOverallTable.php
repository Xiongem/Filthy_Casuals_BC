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
        if (isset($rowOverall['color'])) {
            $color = $rowOverall['color'];
        } else {
            $color = "#2b361c";
        }
            $rankOverall++;  
    ?>

    <div class="table-rows">
        <div class="tr"><?=$rankOverall?></div>
        <div class="tr userLink" onclick="goUser('<?=$idOverall?>')" style="color: <?=$color?>">
            <?=$usernameOverall?>
        </div>
        <div class="tr"><?=$pointsOverall?></div>
    </div>
<?php }} ?>