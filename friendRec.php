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
        $recPoints = $user["recPoints"];
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
    <title>Friend Recs</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/friendRecs.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body id="body">
    <div class="popup-wrapper hide" id="editPopup">
        <div class="popup-container">
            <div class="close-wrapper">
                <ion-icon name="close" onclick="closeRecPopup()"></ion-icon>
            </div>
            <!--//* AJAX DISPLAYED CONTENT -->
            <div class="popup-content" id="editResults"></div>
        </div>
    </div>
    <div class="popup-wrapper hide" id="pointsPopup">
        <div class="popup-container">
            <div class="close-wrapper">
                <ion-icon name="close" onclick="closePointsPopup()"></ion-icon>
            </div>
            <div class="popup-content">
                <h2>Award Points?</h2>
                <div class="label">
                    Give <span id="username"></span> 20 points for recommending <span id="rec"></span>, which you read?
                </div>
                <div class="award buttons" onclick="givePoints($('#username').val())">Award!</div>
                <div id="pointsResults"></div>
            </div>
            <script>
                function givePoints(username) {
                    $.ajax({
                        url: "php/process-giveRecPoints.php",
                        method: "post",
                        data: {
                            username:username
                        }, success: function(result) {
                            $("#pointsResults").html(result)
                        }
                    })
                }
            </script>
        </div>
    </div>
    <header>
        <?= makeNav() ?>
    </header>
    <div class="earned-points-wrapper">
        <div class="labels">Points Earned:</div>
        <div class="points" id="points"><?=$recPoints?></div>
    </div>
    <div class="button-wrapper">
        <div class="rec-input-button buttons" onclick="showRecPopup(<?=$userID?>)">
            <p>update</p>
        </div>
    </div>
    <div class="wrapper">
        <div class="rec-wrapper">
        <?php $stmt = $_SESSION["conn"]->query("SELECT * FROM friendRecs");
            $row = mysqli_num_rows($stmt);
            if($row > 0) {
                while($row = mysqli_fetch_assoc($stmt)) {
                    $username = $row["username"];
                    $rec1Title = $row["rec1_title"];
                    $rec1Author = $row["rec1_author"];
                    $rec2Title = $row["rec2_title"];
                    $rec2Author = $row["rec2_author"];
                    $rec3Title = $row["rec3_title"];
                    $rec3Author = $row["rec3_author"];
                    $rec4Title = $row["rec4_title"];
                    $rec4Author = $row["rec4_author"];
                    $rec5Title = $row["rec5_title"];
                    $rec5Author = $row["rec5_author"];
        ?>
            <div class="name" id="<?=$username?>">
                <h2><?=$username?></h2>
            </div> 
            <div class="read-wrapper" onclick="showPoints("<?=$username?>", <?=$rec1Title?>)">
                <div class="rank">1.</div>
                <div class="info-wrapper">
                    <h5 class="label">Title:</h5>
                    <div class="info" id="<?=$rec1Title?>">
                        <?=$rec1Title?>
                    </div>
                </div>
                <div class="info-wrapper">
                    <h5 class="label">Author:</h5>
                    <div class="info" id="<?=$rec1Author?>">
                        <?=$rec1Author?>
                    </div>
                </div>
            </div>
        
            <div class="read-wrapper" onclick="showPoints(<?=$username?>, <?=$rec2Title?>)">
                <div class="rank">2.</div>
                <div class="info-wrapper">
                    <h5 class="label">Title:</h5>
                    <div class="info" id="<?=$rec2Title?>">
                        <?=$rec2Title?>
                    </div>
                </div>
                <div class="info-wrapper">
                    <h5 class="label">Author:</h5>
                    <div class="info" id="<?=$rec2Author?>">
                        <?=$rec2Author?>
                    </div>
                </div>
            </div>

            <div class="read-wrapper" onclick="showPoints(<?=$username?>, <?=$rec3Title?>)">
                <div class="rank">3.</div>
                <div class="info-wrapper">
                    <h5 class="label">Title:</h5>
                    <div class="info" id="<?=$rec3Title?>">
                        <?=$rec3Title?>
                    </div>
                </div>
                <div class="info-wrapper">
                    <h5 class="label">Author:</h5>
                    <div class="info" id="<?=$rec3Author?>">
                        <?=$rec3Author?>
                    </div>
                </div>
            </div>

            <div class="read-wrapper" onclick="showPoints(<?=$username?>, <?=$rec4Title?>)">
                <div class="rank">4.</div>
                <div class="info-wrapper">
                    <h5 class="label">Title:</h5>
                    <div class="info" id="<?=$rec4Title?>">
                        <?=$rec4Title?>
                    </div>
                </div>
                <div class="info-wrapper">
                    <h5 class="label">Author:</h5>
                    <div class="info" id="<?=$rec4Author?>">
                        <?=$rec4Author?>
                    </div>
                </div>
            </div>

            <div class="read-wrapper" onclick="showPoints(<?=$username?>, <?=$rec5Title?>)">
                <div class="rank">5.</div>
                <div class="info-wrapper">
                    <h5 class="label">Title:</h5>
                    <div class="info" id="<?=$rec5Title?>">
                        <?=$rec5Title?>
                    </div>
                </div>
                <div class="info-wrapper">
                    <h5 class="label">Author:</h5>
                    <div class="info" id="<?=$rec5Author?>">
                        <?=$rec5Author?>
                    </div>
                </div>
            </div>
        <?php }}?>
        </div>
    </div>
    <script>
        function showPoints(username, rec) {
            $("#pointsPopup").css({"display": "flex"});
            var pointsPopup = document.getElementById("pointsPopup");
            pointsPopup.scrollIntoView();
            setTimeout(hideBackground, 500);

            $("#username").html(username);
            $("#rec").html(rec);
        }
        function closePointsPopup() {
            $("#pointsPopup").hide();
            $("#body").css({"height": "unset", "overflow": "unset"});
            location.reload(true);
        }

        function showRecPopup(userID) {
            $("#editPopup").css({"display": "flex"});
            var editPopup = document.getElementById("editPopup");
            editPopup.scrollIntoView();
            setTimeout(hideBackground, 500);

            $.ajax({
                url: 'php/ajax_friendrec_edit.php',
                method: 'post',
                data: {userID: userID},
                success: function(result) {
                    $("#editResults").html(result);
                }
            });
        }
        function closeRecPopup() {
            $("#editPopup").hide();
            $("#body").css({"height": "unset", "overflow": "unset"});
            location.reload(true);
        }
    </script>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>