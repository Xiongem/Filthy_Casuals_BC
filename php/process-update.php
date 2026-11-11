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

$timezone = $_SESSION["timezone"];
date_default_timezone_set("$timezone");

$pages = $_POST["pages"];

$newGoal = str_replace( ',', '', $pages );
if( is_numeric( $newGoal ) ) {
    $pages = $newGoal;
}

if ($_POST["fanfic"]) {
    $pages = round($pages / 280);
    if ($pages < 1) {
        $pages = 1;
    }
    echo $pages;
}

// // $month = date('n');
// $month = date("n",strtotime($_POST["dateFinished"]));
// $totalPoints = calculateTotalPoints($pages, $_POST["mod-1"], $_POST["mod-2"]);

// // print_r($tags);

// if (isset($_POST["tag"])) {
//     $tags = $_POST["tag"];
//     $insert_tags = implode(",", $tags);
// } else {
//     $insert_tags = NULL;
// }
// // print_r($insert_tags);

// if (isset($_POST["diffDate"])) {
//     $dateFinished = $_POST["dateFinished"];
// } else {
//     $dateFinished = date('Y-m-d');
// }

// if (isset($_POST["ongoing"])) {
//     $ongoing = 1;
// } else {
//     $ongoing = 0;
// }


// $stmt1 = $_SESSION["conn"] -> prepare("INSERT INTO `readHistory` (`user_id`, 
//                                                                 `username`, 
//                                                                 `title`, 
//                                                                 `author`, 
//                                                                 `finishedDate`, 
//                                                                 `startedDate`, 
//                                                                 `pages`, 
//                                                                 `ongoing`, 
//                                                                 `mod1`, 
//                                                                 `mod2`,
//                                                                 `tags`, 
//                                                                 `comment`, 
//                                                                 `month`, 
//                                                                 `totalPoints`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
//     $stmt1->bind_param("isssssiiiissii",
//                         $userID,
//                         $user["username"],
//                         $_POST["title"],
//                         $_POST["author"],
//                         $dateFinished,
//                         $_POST["dateStarted"],
//                         $_POST["pages"],
//                         $ongoing,
//                         $_POST["mod-1"],
//                         $_POST["mod-2"],
//                         $insert_tags,
//                         $_POST["comment"],
//                         $month,
//                         $totalPoints);

// if ($stmt1 -> execute()) {
//     $newPointsYear = $user["pointsYear"] + $totalPoints;
//     $stmt2 = $_SESSION["conn"] -> prepare("UPDATE `users` SET `pointsYear` = ? WHERE `user_id` = ?");
//         $stmt2->bind_param("ii", 
//                             $newPointsYear, 
//                             $userID);
//     if ($stmt2->execute()) {
//         if ($insert_tags !== NULL) {
//             foreach ($tags as $key => $value) {
//                 $stmt3 = $_SESSION["conn"] -> prepare("INSERT INTO `tags` (`tags`) VALUES (?)
//                     ON DUPLICATE KEY UPDATE `tags` = ?;");
//                 $stmt3->bind_param("ss", 
//                                     $value,
//                                     $value);
//             }
//             $stmt3->execute();
//         }
        
//         if ($_POST["bingoName"]) {
//             $stmt4 = $_SESSION["conn"] -> prepare("INSERT INTO `bingo` (`user_id`,
//                                                                     `bingo_name`,
//                                                                     `title`,
//                                                                     `author`,
//                                                                     `total_points`)
//                                                     VALUES (?, ?, ?, ?, ?)");
//             $stmt4->bind_param("isssi",
//                                 $userID,
//                                 $_POST["bingoName"],
//                                 $_POST["title"],
//                                 $_POST["author"],
//                                 $totalPoints);
//             $stmt4->execute();
//         }
//         header("Location: /readHistory.php?user_id=$userID");
    
//         exit;
//     } else {
//         die("an unexpected error occured");
//     }
// } else {
//     die("an unexpected error occured");
// }