<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();
forceLogin();

$userID = $_SESSION["user_id"];

$sql = "SELECT * FROM users WHERE user_id = $userID";
    $result = $_SESSION["conn"]->query($sql);
    $user = $result->fetch_assoc();
        $admin = $user['admin'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="Filthy Casual Book Challenge"> 
    <meta property="og:description" content="A competition for filthy casuals."> 
    <meta property="og:image" content="https://filthycasualsbc.com/images/FCBClogo.svg"> 
    <meta property="og:url" content="https://filthycasualsbc.com/rules.php">
    <title>Rules</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/rules-and-challenges.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body id="body">
    <div class="popup-wrapper hide" id="rulesPopup">
        <div class="popup-container">
            <div class="close-wrapper">
                <ion-icon name="close" onclick="closeNewRule()"></ion-icon>
            </div>
            <div class="popup-content" id="rulesResults">
                <div class="title">
                    <h1>Create New Rule</h1>
                </div>
                <form method="post" action="php/process-createNewRule.php">
                    <div class="row-wrapper" id="rowWrapper">
                        <div class="newRow">
                            <div class="label-wrapper">
                                <label class="label" for="newRule">New Rule:</label>
                                <textarea class="rule inputs" name="newRule[]" maxlength="400"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="add-wrapper spacing">
                        <p>Add Another Rule</p>
                            <ion-icon name="add-circle-outline" onclick="addNewRule()"></ion-icon>
                    </div>
                    <div class="button-wrapper">
                        <button class="buttons" type="submit">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="popup-wrapper hide" id="deletePopup">
        <div class="popup-container">
            <div class="close-wrapper">
                <ion-icon name="close" onclick="closeRemoveRule()"></ion-icon>
            </div>
            <!--//? AJAX INSERT HTML-->
            <div class="popup-content" id="deleteResults">
            </div>
        </div>
    </div>
    <div class="popup-wrapper hide" id="ruleEditPopup">
        <div class="popup-container">
            <div class="close-wrapper">
                <ion-icon name="close" onclick="closeRuleEdit()"></ion-icon>
            </div>
            <!--//? AJAX INSERT HTML-->
            <div class="popup-content" id="ruleEditResults">
            </div>
        </div>
    </div>
    <header>
        <?= makeNav() ?>
    </header>
    <div class="full-wrapper">
        <div class="content-wrapper">
            <h1>Rules</h1>
            <div class="rules-content">
                <?php $stmt = $_SESSION["conn"]->query("SELECT * FROM `rules`");
                    $rules = mysqli_num_rows($stmt);
                    $rank = 0;
                    if ($rules > 0) {
                        while ($rules = mysqli_fetch_assoc($stmt)) {
                            $rank++;
                            $ruleID = $rules["rule_id"];
                            $rule = $rules["rule_info"];
                ?>
                <div class="<?php if($admin== 1){echo ("row");}else{echo ("row2");} ?>">
                    <?php if ($admin == 1) { ?>
                    <ion-icon class="icon" name="settings-outline" onclick="showRuleEdit(<?=$ruleID?>)"></ion-icon>
                    <?php } ?>
                    <h2 class="rank"><?=$rank?></h2>
                    <p class="rules" id="<?=$ruleID?>"><?=$rule?></p>
                    <?php if ($admin == 1) { ?>
                    <ion-icon class="warning icon" name="remove-circle" onclick="showRemoveRule(<?=$ruleID?>, <?=$rank?>)"></ion-icon>
                    <?php } ?>
                </div>
            <?php }} else { ?>
                <div class="row">
                    <h3>No Rules Found</h3>
                </div>
                <?php } ?>
                <?php if ($admin == 1) { ?>
                <div class="add-wrapper">
                    <p>Add New Rule</p>
                        <ion-icon class="icon" name="add-circle-outline" onclick="showNewRule()"></ion-icon>
                </div>
                <?php } ?>
            </div>
        </div>     
    <script>
        function showNewRule() {
            $("#rulesPopup").css({"display": "flex"});
            var rulesPopup = document.getElementById("rulesPopup");
            rulesPopup.scrollIntoView();
            setTimeout(hideBackground, 500);
        }
        function closeNewRule() {
            $("#rulesPopup").hide();
            $("#body").css({"height": "unset", "overflow": "unset"});
            location.reload(true);
        }

        function showRemoveRule(ruleID, rank) {
            $("#deletePopup").css({"display": "flex"});
            var deletePopup = document.getElementById("deletePopup");
            deletePopup.scrollIntoView();
            setTimeout(hideBackground, 500);

            $.ajax({
                url: "php/ajax_delete_rule.php",
                method: "post",
                data: {
                    rule_id:ruleID,
                    rank:rank
                },success:function(result) {
                    $("#deleteResults").html(result);
                }
            })
        }
        function closeRemoveRule() {
            $("#deletePopup").hide();
            $("#body").css({"height": "unset", "overflow": "unset"});
            location.reload(true);
        }

        function addNewRule() {
            $('#rowWrapper').append([
                $('<div/>',{ "class": "newRow spacing" }).append([
                    $('<div/>',{ "class": "label-wrapper" }).append([
                        $('<label/>',{ "class": "label", for: "newRule", text: "New Rule:" }),
                        $('<textarea/>',{ "class": "rule inputs", name: "newRule[]", maxlength: "200" })
                    ])
                ])
            ]);           
        }

        function showRuleEdit(ruleID) {
            $("#ruleEditPopup").css({"display": "flex"});
            var ruleEditPopup = document.getElementById("ruleEditPopup");
            ruleEditPopup.scrollIntoView();
            setTimeout(hideBackground, 500);

            $.ajax({
                url: "php/ajax_edit_rule.php",
                method: "post",
                data: {
                    rule_id:ruleID
                },success:function(result) {
                    $("#ruleEditResults").html(result);
                }
            })
        }
        function closeRuleEdit() {
            $("#ruleEditPopup").hide();
            $("#body").css({"height": "unset", "overflow": "unset"});
            location.reload(true);
        }
    </script>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>