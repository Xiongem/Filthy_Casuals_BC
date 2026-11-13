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


$sql = "SELECT `rule_info` 
            FROM `rules` 
            WHERE `rule_id` = $ruleID";
    $result = $_SESSION["conn"]->query($sql);
    $rule = $result->fetch_assoc();
        $ruleInfo = $rule["rule_info"];
?>

<div class="edit-wrapper">
    <label for="ruleEdit">Rule:</label>
    <textarea id="<?=$ruleID?>" name="ruleEdit" class="inputs"><?=$ruleInfo?></textarea>
</div>
<div class="button-wrapper">
    <div class="buttons" onclick="editRule(<?=$ruleID?>, this.value)">Submit</div>
</div>
<script>
    function editRule(ruleID, ruleInfo) {
        $.ajax({
            url: "php/process-editRules.php",
            method: "post",
            data: {
                rule_id:ruleID,
                rule_info:ruleInfo
            },success:function (result) {
                $("#ruleEditResults").html(result);
            }
        })
    }
</script>