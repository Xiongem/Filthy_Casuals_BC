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
<body>
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
                <div class="row">
                    <h3 class="rank"><?=$rank?></h3>
                    <p class="rules" id="<?=$ruleID?>"><?=$rule?></p>
                </div>
            <?php }} ?>
            </div>
        </div>

        <div class="divider"></div>

        <div class="content-wrapper">
            <div class="activity-content">
                <h1>Activities</h1>
                <div class="activity">
                    <div id="activity">Buddy Read:</div>
                    <div id="instruct">Grab a buddy and choose a book. The pages you read together can be marked as "buddy read" in the update page and count for extra points!</div>
                </div>
                <div class="activity">
                    <div id="activity">Friend Recommendation:</div>
                    <div id="instruct">Check out <a>Friend Recs</a> to find your next read. Any pages read from a friend rec earn bonus points.</div>
                </div>
                <div class="activity">
                    <div id="activity">Read-a-thon:</div>
                    <div id="instruct">One week a month will be designated as a read-a-thon week, mark everything you read during that time as "read-a-thon" in the update page and earn bonus points.</div>
                </div>
                <div class="activity">
                    <div id="activity">Seasonal:</div>
                    <div id="instruct">Each quarter of the year </div>
                </div>
            </div>
        </div>
    </div>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>