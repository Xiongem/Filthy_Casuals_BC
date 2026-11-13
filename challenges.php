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

$sql2 = "SELECT * FROM `challenges`";
    $result2 = $_SESSION["conn"]->query($sql2);
    $challenge = $result2->fetch_assoc();
        $jan = $challenge["month_jan"];
        $feb = $challenge["month_feb"];
        $march = $challenge["month_march"];
        $april = $challenge["month_april"];
        $may = $challenge["month_may"];
        $june = $challenge["month_june"];
        $july = $challenge["month_july"];
        $aug = $challenge["month_aug"];
        $sept = $challenge["month_sept"];
        $oct = $challenge["month_oct"];
        $nov = $challenge["month_nov"];
        $dec = $challenge["month_dec"];
            $janDescr = $challenge["jan_descr"];
            $febDescr = $challenge["feb_descr"];
            $marchDescr = $challenge["march_descr"];
            $aprilDescr = $challenge["april_descr"];
            $mayDescr = $challenge["may_descr"];
            $juneDescr = $challenge["june_descr"];
            $julyDescr = $challenge["july_descr"];
            $augDescr = $challenge["aug_descr"];
            $septDescr = $challenge["sept_descr"];
            $octDescr = $challenge["oct_descr"];
            $novDescr = $challenge["nov_descr"];
            $decDescr = $challenge["dec_descr"];
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
    <title>Challenges</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/rules-and-challenges.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body id="body">
    <div class="popup-wrapper hide" id="newActPopup">
        <div class="popup-container">
            <div class="close-wrapper">
                <ion-icon name="close" onclick="closeNewAct()"></ion-icon>
            </div>
            <!--//? AJAX INSERT HTML-->
            <div class="popup-content" id="newActResults">
                <div class="title">
                    <h2>Create New Activity</h2>
                 </div>
                <form method="post" action="php/process-createNewAct.php">
                    <div class="actRow spacing">
                        <label class="label" for="newActName">Activity Name:</label>
                        <input class="inputs" type="text" name="newActName">

                        <label for="newActDescr">Activity Description:</label>
                        <textarea class="inputs" name="newActDescr" maxlength="200"></textarea>
                    </div>
                    <div class="button-wrapper">
                        <button class="buttons" type="submit">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="popup-wrapper hide" id="deleteActPopup">
        <div class="popup-container">
            <div class="close-wrapper">
                <ion-icon name="close" onclick="closeRemoveAct()"></ion-icon>
            </div>
            <!--//? AJAX INSERT HTML-->
            <div class="popup-content" id="deleteActResults">
            </div>
        </div>
    </div>
    <div class="popup-wrapper hide" id="actEditPopup">
        <div class="popup-container">
            <div class="close-wrapper">
                <ion-icon name="close" onclick="closeActEdit()"></ion-icon>
            </div>
            <!--//? AJAX INSERT HTML-->
            <div class="popup-content" id="actEditResults">
            </div>
        </div>
    </div>
    <header>
        <?= makeNav() ?>
    </header>
    <div class="wrapper">
        <div class="challenge-wrapper">
            <div class="challenge-content">
                <div class="title">
                    <h1>Challenges</h1>
                </div>
                <div class="challenge-grid">
                    <div class="challenges">
                        <div class="month">Jan:</div>
                        <div class="info name"><?=$jan?></div>
                        <div class="info"><?=$janDescr?></div>
                    </div>
                    <div class="challenges">
                        <div class="month">Feb:</div>
                        <div class="info name"><?=$feb?></div>
                        <div class="info"><?=$febDescr?></div>
                    </div>
                    <div class="challenges">
                        <div class="month">March:</div>
                        <div class="info name"><?=$march?></div>
                        <div class="info"><?=$marchDescr?></div>
                    </div>
                    <div class="challenges">
                        <div class="month">April:</div>
                        <div class="info name"><?=$april?></div>
                        <div class="info"><?=$aprilDescr?></div>
                    </div>
                    <div class="challenges">
                        <div class="month">May:</div>
                        <div class="info name"><?=$may?></div>
                        <div class="info"><?=$mayDescr?></div>
                    </div>
                    <div class="challenges">
                        <div class="month">June:</div>
                        <div class="info name"><?=$june?></div>
                        <div class="info"><?=$juneDescr?></div>
                    </div>
                    <div class="challenges">
                        <div class="month">July:</div>
                        <div class="info name"><?=$july?></div>
                        <div class="info"><?=$julyDescr?></div>
                    </div>
                    <div class="challenges">
                        <div class="month">Aug:</div>
                        <div class="info name"><?=$aug?></div>
                        <div class="info"><?=$augDescr?></div>
                    </div>
                    <div class="challenges">
                        <div class="month">Sept:</div>
                        <div class="info name"><?=$sept?></div>
                        <div class="info"><?=$septDescr?></div>
                    </div>
                    <div class="challenges">
                        <div class="month">Oct:</div>
                        <div class="info name"><?=$oct?></div>
                        <div class="info"><?=$octDescr?></div>
                    </div>
                    <div class="challenges">
                        <div class="month">Nov:</div>
                        <div class="info name"><?=$nov?></div>
                        <div class="info"><?=$novDescr?></div>
                    </div>
                    <div class="challenges">
                        <div class="month">Dec:</div>
                        <div class="info name"><?=$dec?></div>
                        <div class="info"><?=$decDescr?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="divider"></div>

        <div class="content-wrapper">
            <div class="activity-content">
                <h1>Activities</h1>
                <?php $stmt2 = $_SESSION["conn"]->query("SELECT * FROM `activities`");
                    $act = mysqli_num_rows($stmt2);
                    if ($act > 0) {
                        while ($act = mysqli_fetch_assoc($stmt2)) {
                            $actID = $act["act_id"];
                            $actName = $act["act_name"];
                            $actInfo = $act["act_descr"];
                ?>
                <div class="<?php if($admin== 1){echo ("activity");}else{echo ("activity2");} ?>" id="<?=$actID?>">
                    <?php if ($admin == 1) { ?>
                    <ion-icon class="icon" name="settings-outline" onclick="showActEdit(<?=$actID?>)"></ion-icon>
                    <?php } ?>
                    <div id="activity"><?=$actName?></div>
                    <div id="instruct"><?=$actInfo?></div>
                    <?php if ($admin == 1) { ?>
                    <ion-icon class="warning icon" name="remove-circle" onclick="showRemoveAct(<?=$actID?>)"></ion-icon>
                    <?php } ?>
                </div>
                <?php }} else { ?>
                <div class="act-wrapper spacing">
                    <h3>No Activities Found</h3>
                </div>
                <?php } ?>
                <?php if ($admin == 1) { ?>
                <div class="add-wrapper">
                    <p>Add New Activity</p>
                        <ion-icon class="icon" name="add-circle-outline" onclick="showNewAct()"></ion-icon>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <script>
        function showNewAct() {
            $("#newActPopup").css({"display": "flex"});
            var newActPopup = document.getElementById("newActPopup");
            newActPopup.scrollIntoView();
            setTimeout(hideBackground, 500);
        }
        function closeNewAct() {
            $("#newActPopup").hide();
            $("#body").css({"height": "unset", "overflow": "unset"});
            location.reload(true);
        }

        function showActEdit(actID) {
            $("#actEditPopup").css({"display": "flex"});
            var actEditPopup = document.getElementById("actEditPopup");
            actEditPopup.scrollIntoView();
            setTimeout(hideBackground, 500);

            $.ajax({
                url: "php/ajax_edit_act.php",
                method: "post",
                data: {
                    act_id:actID
                },success:function(result) {
                    $("#actEditResults").html(result);
                }
            })
        }
        function closeActEdit() {
            $("#actEditPopup").hide();
            $("#body").css({"height": "unset", "overflow": "unset"});
            location.reload(true);
        }

        function showRemoveAct(actID) {
            $("#deleteActPopup").css({"display": "flex"});
            var deleteActPopup = document.getElementById("deleteActPopup");
            deleteActPopup.scrollIntoView();
            setTimeout(hideBackground, 500);

            $.ajax({
                url: "php/ajax_delete_act.php",
                method: "post",
                data: {
                    act_id:actID
                },success:function(result) {
                    $("#deleteActResults").html(result);
                }
            })
        }
        function closeRemoveAct() {
            $("#deleteActPopup").hide();
            $("#body").css({"height": "unset", "overflow": "unset"});
            location.reload(true);
        }
    </script>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>