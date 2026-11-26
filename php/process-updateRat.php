<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
require($_SERVER['DOCUMENT_ROOT'] . '/php/modMathRat.php');
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
    $wordsOut = str_replace( ',', '', $_POST["pagesOut"]);
    $wordsIn = str_replace( ',', '', $_POST["pagesIn"]);
    $fanfic = 1;

    $newGoal1 = str_replace( ',', '', $_POST["pagesOut"] );//removes , from numbers
    $newGoal2 = str_replace( ',', '', $_POST["pagesIn"] );//removes , from numbers

    if( is_numeric( $newGoal1 ) ) {
        $pagesOut = round($newGoal1 / 280);
        
        if ($pagesOut < 1) {
            $pagesOut = 1;
        }
    }
    if( is_numeric( $newGoal2 ) ) {
        $pagesIn = round($newGoal2 / 280);
        
        if ($pagesIn < 1) {
            $pagesIn = 1;
        }
    }
    
    $pages = $pagesIn + $pagesOut;

    if( is_numeric( $wordsIn ) && is_numeric( $wordsOut ) ) {
        $words = $wordsIn + $wordsOut;
    }
} else {
    $pagesOut = $_POST["pagesOut"];
    $pagesIn = $_POST["pagesIn"];
    $words = NULL;
    $fanfic = 0;

    $newGoal1 = str_replace( ',', '', $pagesOut );

    if( is_numeric( $newGoal1 ) ) {
        $pagesOut = $newGoal1;
    }
    //*-------------------------------------------
    $newGoal2 = str_replace( ',', '', $pagesIn );

    if( is_numeric( $newGoal2 ) ) {
        $pagesIn = $newGoal2;
    }

    $pages = $pagesIn + $pagesOut;
}

$totalPoints = calculateTotalPoints($pagesOut, $pagesIn, $_POST["mod-1-Out"], $_POST["mod-2-Out"], $_POST["mod-2-In"]);

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

$mod1 = $_POST['mod-1-Out'].",8";
$mod2 = $_POST['mod-2-Out'].",".$_POST["mod-2-In"];

// echo "mod 1: ".$mod1;
// echo "mod 2: ".$mod2;

$rat = 1;

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
                                                                `year`,
                                                                `rat`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param("isssssiiiissssisisi",
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
                        $mod1,
                        $mod2,
                        $insert_tags,
                        $_POST["comment"],
                        $month,
                        $bingoName,
                        $totalPoints,
                        $year,
                        $rat);

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