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
    <meta property="og:image" content=""> 
    <meta property="og:url" content="">
    <title>Rules</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/rules-and-challenges.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body id="body">
    <div class="new-rule-wrapper">
        <div class="new-rule-content">
            <div class="title">
                <h1>Create New Rule</h1>
            </div>
            <form method="post" action="php/process-createNewRule.php" id="form">
                <div class="row">
                    <div class="label-wrapper">
                        <label class="label" for="newRule">New Rule:</label>
                        <textarea class="rule" name="newRule[]" maxlength="200"></textarea>
                    </div>
                </div>
                <div class="add-wrapper">
                    <p>Add New Rule</p>
                        <ion-icon name="add-circle-outline" onclick="addNewRule()"></ion-icon>
                </div>
                <div class="button-wrapper">
                    <button class="buttons" type="submit">Create</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function addNewRule() {
            $('#form').append([
                $('<div/>',{ "class": "row" }).append([
                    $('<div/>',{ "class": "label-wrapper" }).append([
                        $('<label/>',{ "class": "label", for: "newRule", text: "New Rule:" }),
                        $('<textarea/>',{ "class": "rule", name: "newRule[]", maxlength: "200" }),
                    ]);
                ]);
            ]);           
        }
    </script>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>