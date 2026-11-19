<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
require($_SERVER['DOCUMENT_ROOT'] . '/php/modMath.php');
dbConnect();

$userID = $_SESSION["user_id"];

$sql = "SELECT * FROM users WHERE user_id = $userID";
            $result = $_SESSION["conn"]->query($sql);
            $user = $result->fetch_assoc();  
                $yearTotal = $user["pointsYear"];

$sql2 = "SELECT * FROM `bingoNames` WHERE `active` = 1";
$result2 = $_SESSION["conn"]->query($sql2);
    $bingo2 = $result2->fetch_assoc();
    if ($bingo2) {
        $active = $bingo2["active"];
        $activeName = $bingo2["bingo_name"];
    } else {
        $active = 0;
        $activeName = NULL;
    }

$timezone = $_SESSION["timezone"];
date_default_timezone_set("$timezone");

if (isset($_POST["fanfic"])) {
    $pages = $_POST["pages"];
    $words = $_POST["pages"];
    $fanfic = 1;

    $newGoal = str_replace( ',', '', $pages );//removes , from numbers

    if( is_numeric( $newGoal ) ) {
        $pages = $newGoal;

        $pages = round($pages / 280);
        
        if ($pages < 1) {
            $pages = 1;
        }
    }
} else {
    $pages = $_POST["pages"];
    $words = NULL;
    $fanfic = 0;

    $newGoal = str_replace( ',', '', $pages );

    if( is_numeric( $newGoal ) ) {
        $pages = $newGoal;
    }
}

$totalPoints = calculateTotalPoints($pages, $_POST["mod-1"], $_POST["mod-2"]);

$month = date("n",strtotime($_POST["dateFinished"]));
$year = date('y');


if (isset($_POST["tag"])) {
    $tags = $_POST["tag"];
    $tags = str_replace("'", '', $tags); //replaces ' with nothing
    $insert_tags = implode(",", $tags); //separates tags in post array and inserts , between them
} else {
    $insert_tags = NULL;
}

if (isset($_POST["diffDate"])) {
    $dateFinished = $_POST["dateFinished"];
} else {
    $time = time();
    $dateFinished = date("Y-m-d H:i", $time);
}

if (isset($_POST["ongoing"])) {
    $ongoing = 1;
} else {
    $ongoing = 0;
}

if (isset($_POST["bingoName"])) {
    $bingoName = $activeName;
} else {
    $bingoName = NULL;
}

$stmt1 = $_SESSION["conn"] -> prepare("INSERT INTO `readHistory` (`user_id`, 
                                                                `username`, 
                                                                `title`, 
                                                                `author`, 
                                                                `finishedDate`, 
                                                                `startedDate`, 
                                                                `pages`, 
                                                                `ongoing`,
                                                                `fanfic`, 
                                                                `words`,
                                                                `mod1`, 
                                                                `mod2`,
                                                                `tags`, 
                                                                `comment`, 
                                                                `month`, 
                                                                `bingo_name`,
                                                                `totalPoints`,
                                                                `year`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param("isssssiiiiiissisis",
                        $userID,
                        $user["username"],
                        $_POST["title"],
                        $_POST["author"],
                        $dateFinished,
                        $_POST["dateStarted"],
                        $pages,
                        $ongoing,
                        $fanfic,
                        $words,
                        $_POST["mod-1"],
                        $_POST["mod-2"],
                        $insert_tags,
                        $_POST["comment"],
                        $month,
                        $bingoName,
                        $totalPoints,
                        $year);

if ($stmt1 -> execute() && $stmt1 -> affected_rows > 0) {
    $newPointsYear = $yearTotal + $totalPoints;

    $stmt2 = $_SESSION["conn"] -> prepare("UPDATE `users` SET `pointsYear` = ? WHERE `user_id` = ?");
        $stmt2->bind_param("ii", 
                            $newPointsYear, 
                            $userID);
    if ($stmt2->execute() && $stmt2 -> affected_rows > 0) {
        if ($insert_tags !== NULL) {
            foreach ($tags as $value) {
                $stmt3 = $_SESSION["conn"] -> prepare("INSERT INTO `tags` (`tags`) VALUES (?)
                    ON DUPLICATE KEY UPDATE `tags` = ?;");
                $stmt3->bind_param("ss", 
                                    $value,
                                    $value);

                $stmt3->execute();
            }
        }
        // echo ("Entry Total: ".$totalPoints."<br>");
        // echo ("Year Total: ".$yearTotal."<br>");
        // echo ("New Total: ".$newPointsYear."<br>");
        header("Location: /readHistory.php?user_id=$userID");
    
        exit;
    } else {
        die("an unexpected error occured" . $stmt2 -> error);
    }
} else {
    die("an unexpected error occured" . $stmt1 -> error);
}