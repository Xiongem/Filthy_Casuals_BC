<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

//assigns POST data from ajax to variables
$ruleID = $_POST['rule_id'];
$rank = $_POST['rank'];


$sql = "SELECT `rule_info` 
            FROM `rules` 
            WHERE `rule_id` = $ruleID";
    $result = $_SESSION["conn"]->query($sql);
    $rule = $result->fetch_assoc();
        $ruleInfo = $rule["rule_info"];
?>

<div class="title">
<h1>Delete Rule</h1>
<div class="delete-wrapper">
    <h3>Delete rule number <?=$rank?>:</h3>
    <p id="<?=$ruleID?>"><?=$ruleInfo?></p>
</div>
<div class="button-wrapper">
    <div class="buttons" onclick="deleteRule(<?=$ruleID?>)">Delete</div>
</div>

<script>
    function deleteRule(ruleID) {
        $.ajax({
            url: "php/process-deleteRule.php",
            method: "post",
            data: {
                rule_id:ruleID
            },success:function (result) {
                $("#deleteResults").html(result);
            }
        })
    }
</script>