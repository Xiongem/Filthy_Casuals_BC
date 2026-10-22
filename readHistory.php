<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();
forceLogin();

// $userID = $_SESSION["user_id"];

$userID = $_GET["user_id"];

$sql = "SELECT * FROM users WHERE user_id = $userID";
        $result = $_SESSION["conn"]->query($sql);
        $user = $result->fetch_assoc();
            $admin = $user['admin'];

 $sql = "SELECT * FROM readHistory WHERE user_id = $userID";
        $result = $_SESSION["conn"]->query($sql);
        // $readHistory = $result->fetch_assoc();

        
            
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
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/readHistory.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/ea9288eda1.js" crossorigin="anonymous"></script>
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body id="body">
    <div class="popup-wrapper hide" id="editPopup">
        <div class="popup-container">
            <div class="popup-content">
                <h1>Edit The Thing</h1>
            </div>
        </div>
    </div>
    <header>
        <?= makeNav() ?>
    </header>
    <div class="history-wrapper" id="historyWrapper">
        <div class="title-wrapper">
            <h1>Your Reading History</h1>
        </div>
        <div class="history-table">
            <div class="row">
                <div class="table-head edit">Edit</div>
                <div class="table-head title">Title</div>
                <div class="table-head author">Author</div>
                <div class="table-head pages">Pages</div>
                <div class="table-head date">Date Started</div>
                <div class="table-head date">Date Finished</div>
                <div class="table-head ongoing">Ongoing?</div>
                <div class="table-head month">Month</div>
                <div class="table-head points">Total Points</div>
                <div class="table-head comment">Comment</div>
            </div>
            <?php
            if ($result->num_rows > 0) {
                while ($readHistory = $result->fetch_assoc()) {
                    $title = $readHistory['title'];
                    $author = $readHistory['author'];
                    $finishedDate = $readHistory['finishedDate'];
                    if ($readHistory['startedDate'] == "0000-00-00") {
                        $startedDate = 'none';
                    } else {
                        $startedDate = $readHistory['startedDate'];
                    }
                    $pages = $readHistory['pages'];
                    $mod1 = $readHistory['mod1'];
                    $mod2 = $readHistory['mod2'];
                    $ongoing = $readHistory['ongoing'];
                    if ($readHistory['tags'] !== NULL) {
                        $tags = explode(",", $readHistory['tags']);
                    } else {
                        $tags = "";
                    }
                    if ($ongoing == 1) {
                        $ongoingChecked = 'yes';
                    } else {
                        $ongoingChecked = 'no';
                    }
                    if (isset($readHistory['comment'])) {
                        $comment = $readHistory['comment'];
                    } elseif ($readHistory['comment'] == '') {
                        $comment = 'none';
                    } else {
                        $comment = '';
                    }
                    $month = $readHistory['month'];
                    $totalPoints = $readHistory['totalPoints']; 

                    // print_r($tags);
                ?>
                <div class="row">
                    <div class="table-item edit" id="edit"><i class="fa fa-gear" id="edit-icon" onclick="editRead()"></i></div>
                    <div class="table-item title"> <?= htmlspecialchars($title) ?> </div>
                    <div class="table-item author"> <?= htmlspecialchars($author) ?> </div>
                    <div class="table-item pages"> <?= htmlspecialchars($pages) ?> </div>
                    <div class="table-item date"> <?= htmlspecialchars($startedDate) ?> </div>
                    <div class="table-item date"> <?= htmlspecialchars($finishedDate) ?></div>
                    <div class="table-item ongoing"> <?= $ongoingChecked ?> </div>
                    <div class="table-item month"> <?= htmlspecialchars($month) ?> </div>
                    <div class="table-item points"> <?= htmlspecialchars($totalPoints) ?> </div>
                    <div class="table-item comment"> <?= htmlspecialchars($comment) ?> </div>
                </div>
                <div class="notch-wrapper" id="notchWrapper">
                    <?php if (isset($readHistory['tags'])) { ?>
                        <?php foreach ($tags as $key => $value) { ?>
                            <div class="notch-arrow" id="<?= htmlspecialchars($value) ?>" onclick="removeTag(<?= htmlspecialchars($value) ?>)">
                                <p class='tag-content' id='tagContent'><?= htmlspecialchars($value) ?></p>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php }} else { ?> 
                <tr><td colspan='9'>No reading history found.</td></tr>
            <?php } ?>
        </div>
    </div>
    <!-- <script>
        function editRead() {
            $('#editPopup').show()
        }
    </script> -->
</body>
</html>