<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

//assigns POST data from ajax to variables
$actID = $_POST['act_id'];


$sql = "SELECT * 
            FROM `activities` 
            WHERE `act_id` = $actID";
    $result = $_SESSION["conn"]->query($sql);
    $act = $result->fetch_assoc();
        $actName = $act["act_name"];
        $actInfo = $act["act_descr"];
?>

<div class="edit-wrapper">
    <label class="label" for="actNameEdit">activity:</label>
    <input type="text" id="actNameEdit" name="actNameEdit" class="inputs" value="<?=$actName?>">

    <label class="label" for="actInfoEdit"></label>
    <textarea id="actInfoEdit" name="actInfoEdit" class="inputs" maxlength="200"><?=$actInfo?></textarea>
</div>
<div class="button-wrapper">
    <div class="buttons" onclick="editAct(<?=$actID?>)">Submit</div>
</div>
<script>
    function editAct(actID) {
        var actName = $("#actNameEdit").val();
        var actInfo = $("#actInfoEdit").val();
        $.ajax({
            url: "php/process-editActs.php",
            method: "post",
            data: {
                act_id:actID,
                act_name:actName,
                act_info:actInfo
            },success:function (result) {
                $("#actEditResults").html(result);
            }
        })
    }
</script>