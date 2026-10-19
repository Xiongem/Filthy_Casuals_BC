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
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/ea9288eda1.js" crossorigin="anonymous"></script>
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <?= makeNav() ?>
    </header>
    <div class="history-wrapper" id="historyWrapper">
        <table class="history-table">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Date Finished</th>
                <th>Date Started</th>
                <th>Pages</th>
                <th>Ongoing?</th>
                <th>Comment</th>
                <th>Month</th>
                <th>Total Points</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                echo "hello1";
                while ($readHistory = $result->fetch_assoc()) {
                    $title = $readHistory['title'];
                    $author = $readHistory['author'];
                    $finishedDate = $readHistory['finishedDate'];
                    if (isset($readHistory['startedDate'])) {
                        $startedDate = $readHistory['startedDate'];
                    } else {
                        $startedDate = '';
                    }
                    $pages = $readHistory['pages'];
                    $mod1 = $readHistory['mod1'];
                    $mod2 = $readHistory['mod2'];
                    $ongoing = $readHistory['ongoing'];
                    if ($ongoing == 1) {
                        $ongoingChecked = 'yes';
                    } else {
                        $ongoingChecked = 'no';
                    }
                    if (isset($readHistory['comment'])) {
                        $comment = $readHistory['comment'];
                    } else {
                        $comment = '';
                    }
                    $month = $readHistory['month'];
                    $totalPoints = $readHistory['totalPoints'];
                echo "<tr>";
                echo "<td>" . htmlspecialchars($title) . "</td>";
                echo "<td>" . htmlspecialchars($author) . "</td>";
                echo "<td>" . htmlspecialchars($finishedDate) . "</td>";
                echo "<td>" . htmlspecialchars($startedDate) . "</td>";
                echo "<td>" . htmlspecialchars($pages) . "</td>";
                echo "<td>" . $ongoing . "</td>";
                echo "<td>" . htmlspecialchars($month) . "</td>";
                echo "<td>" . htmlspecialchars($totalPoints) . "</td>";
                echo "<td>" . htmlspecialchars($comment) . "</td>";
                echo "</tr>";
            }} else {
                echo "<tr><td colspan='9'>No reading history found.</td></tr>";
            }
            ?>
    </div>
</body>
</html>