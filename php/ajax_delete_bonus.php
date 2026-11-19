<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$readID = $_POST["readID"];
$userID = $_POST["userID"];

$sql = "SELECT * 
            FROM `readHistory` 
            WHERE `read_ID` = $readID && `user_id` = $userID";
    $result = $_SESSION["conn"]->query($sql);
    $user = $result->fetch_assoc();
        $title = $user["title"];
        $totalPoints = $user["totalPoints"];
        if ($user["author"]) {
            $author = $user["author"];
        }
        
?>

<div class="title">
<h1>Delete Bonus Points?</h1>
<div class="delete-wrapper">
    <h3 class="spacing">Delete <?=$title?></h3>
    <?php if ($user["author"]) { ?>
        <h3 class="spacing">From <?=$author?></h3>
    <?php } ?>
    <p class="spacing" id="<?=$readID?>"> Worth <?=$totalPoints?>?</p>
</div>
<div class="button-wrapper">
    <div class="buttons" onclick="deleteBonus(<?=$readID?>, <?=$userID?>)">Delete</div>
</div>

<script>
    function deleteBonus(readID, userID) {
        $.ajax({
            url: "php/process-deleteBonus.php",
            method: "post",
            data: {readID:readID,
                    userID:userID},
            success:function (result) {
                $("#deleteResults").html(result);
            }
        })
    }
</script>