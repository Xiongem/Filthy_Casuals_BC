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

<div class="title">
<h1>Delete Activity</h1>
<div class="delete-wrapper">
    <h3 class="spacing">Delete <?=$actName?>:</h3>
    <p class="spacing" id="<?=$actID?>"><?=$actInfo?></p>
</div>
<div class="button-wrapper">
    <div class="buttons" onclick="deleteAct(<?=$actID?>)">Delete</div>
</div>

<script>
    function deleteAct(actID) {
        $.ajax({
            url: "php/process-deleteAct.php",
            method: "post",
            data: {
                act_id:actID
            },success:function (result) {
                $("#deleteActResults").html(result);
            }
        })
    }
</script>