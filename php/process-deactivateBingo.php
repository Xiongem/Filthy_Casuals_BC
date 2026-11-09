<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$resetActive = 0;
$stmt1 = $_SESSION['conn']->prepare("UPDATE `bingoNames` SET `active` = ? WHERE `active` = 1 AND `bingo_name` = ?");
$stmt1 -> bind_param("is",
                        $resetActive,
                        $_POST["bingoName"]); 

if ($stmt1 -> execute() && $stmt1 -> affected_rows > 0) {?>
    <select name="bingo" id="bingo" class="inputs">
        <option value="0">Select Active Bingo</option>
        <?php $stmt = $_SESSION["conn"]->query("SELECT * FROM `bingoNames`"); 
                $bingo = mysqli_num_rows($stmt);
                if ($bingo > 0) {
                    while ($bingo = mysqli_fetch_assoc($stmt)) {
                        $bingoID = $bingo["bingo_name_id"];
                        $bingoName = $bingo["bingo_name"];
                ?>
        <option id="<?=$bingoID?>" value="<?=$bingoName?>"><?=$bingoName?></option>
        <?php }} ?>
    </select>
    <div class="button-wrapper">
        <div class="buttons" onclick="activateBingo()">Activate</div>
    </div>
    <div id="bingoResult"></div>
<?php } else {
    die("Failed to deactivate bingo" . $stmt1 -> error);
}
