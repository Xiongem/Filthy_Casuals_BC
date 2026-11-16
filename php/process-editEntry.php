<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
require($_SERVER['DOCUMENT_ROOT'] . '/php/modMath.php');
dbConnect();

//assign data for user ID and entry ID to variables
$userID = $_SESSION["user_id"];
$readID = $_POST["read_ID"];

//pulls all user data from db
$sql = "SELECT * FROM users WHERE user_id = $userID";
            $result = $_SESSION["conn"]->query($sql);
            $user = $result->fetch_assoc();  
                $yearTotal = $user["pointsYear"];

$sql = "SELECT `totalPoints` FROM `readHistory` WHERE `user_id` = $userID  AND read_ID = $readID";
    $result = $_SESSION["conn"]->query($sql);
    $read = $result->fetch_assoc();
        $oldTotal = $read["totalPoints"];

//assigns timezone to varible depending on if the timezone session token is set or not
if (isset($_SESSION["timezone"])) {
    $timezone = $_SESSION["timezone"];
} else {
    $timezone = $user["timezone"];
}

//set default timezone to user's timezone instead of server's
date_default_timezone_set("$timezone");

if (isset($_POST["fanfic"])) {
    $pages = $_POST["pages"];

    $newGoal = str_replace( ',', '', $pages );

    if( is_numeric( $newGoal ) ) {
        $pages = $newGoal;

        $pages = round($pages / 280);
        
        if ($pages < 1) {
            $pages = 1;
        }
    }
} else {
        $pages = $_POST["pages"];

        $newGoal = str_replace( ',', '', $pages );

        if( is_numeric( $newGoal ) ) {
            $pages = $newGoal;
        }
}

//set month variable according to month of the finish date for the entry
$month = date("n",strtotime($_POST["dateFinished"]));
//calls to calculate function to math total points earned from modifiers
$newTotal = calculateTotalPoints($pages, $_POST["mod-1"], $_POST["mod-2"]);

//if user added tags, take tags from array and insert them into a string separated by ,
if (isset($_POST["tag"])) {
    $tags = $_POST["tag"];
    $insert_tags = implode(",", $tags);
} else {
    $insert_tags = NULL;
}

if (isset($_POST["diffDate"])) {
    $dateFinished = $_POST["dateFinished"];
} else {
    $dateFinished = date('Y-m-d');
}

//assigns boolean value to ongoing variable. 0 = not checked, 1 = checked.
if (isset($_POST["ongoing"])) {
    $ongoing = 1;
} else {
    $ongoing = 0;
}

if (isset($_POST["fanfic"])) {
    $fanfic = 1;
} else {
    $fanfic = 0;
}

//first query
// $stmt1 = $_SESSION["conn"] -> prepare("UPDATE `readHistory` 
//                                         SET  `title` = ?, 
//                                             `author` = ?,
//                                             `finishedDate` = ?, 
//                                             `startedDate` = ?, 
//                                             `pages` = ?, 
//                                             `ongoing` = ?, 
//                                             `mod1` = ?, 
//                                             `mod2` = ?,
//                                             `tags` = ?, 
//                                             `comment` = ?, 
//                                             `month` = ?, 
//                                             `totalPoints` = ?
//                                         WHERE `read_ID` = ? AND `user_id` = ?");
// //binds values to columns
// $stmt1->bind_param("ssssiiiissiiii",
//                         $_POST["title"],
//                         $_POST["author"],
//                         $_POST["dateFinished"],
//                         $_POST["dateStarted"],
//                         $pages,
//                         $ongoing,
//                         $_POST["mod-1"],
//                         $_POST["mod-2"],
//                         $insert_tags,
//                         $_POST["comment"],
//                         $month,
//                         $newTotal,
//                         $readID,
//                         $userID);            
// //executes first statement
// if ($stmt1 -> execute()) {
    //if the total points for this entry in the database is the same as total points calculated from function (aka, points didn't change)
    if ($oldTotal == $newTotal) {

        $newPointsYear == $newPointsYear;

    } elseif ($newTotal > $oldTotal) {

        $subTotal = $newTotal - $oldTotal;
        $newPointsYear = $yearTotal + $subTotal;

    } elseif ($newTotal < $oldTotal) {

        $subTotal = $oldTotal - $newTotal;
        $newPointsYear = $yearTotal - $subTotal;

        if ($newPointsYear < 0) {
            $newPointsYear = 0;
        }

    }

    echo ("old total: ".$oldTotal."<br>");
    echo ("new total: ".$newTotal."<br>");
    echo ("New year points: ".$newPointsYear."<br>");
    
    //second query
//     $stmt2 = $_SESSION["conn"] -> prepare("UPDATE `users` 
//                                             SET `pointsYear` = ? 
//                                             WHERE `user_id` = ?");
//     //bind values to columns
//     $stmt2->bind_param("ii", 
//                         $newPointsYear, 
//                         $userID);
//     //executes second statement
//     if ($stmt2->execute()) {
//         //loops through tags array. Inserts them into tags table if it doesn't already exist. Updates if it does.
//         if ($insert_tags !== NULL) {
//             foreach ($tags as $value) {
//                 $stmt3 = $_SESSION["conn"] -> prepare("INSERT INTO `tags` (`tags`) VALUES (?)
//                     ON DUPLICATE KEY UPDATE `tags` = ?;");
//                 $stmt3->bind_param("ss", 
//                                     $value,
//                                     $value);

//                 $stmt3->execute();
//             }
//         }
//         //sends user back to history page    
//         header("Location: /readHistory.php?user_id=$userID");
        
//         exit;
//     } else {
//         die("an unexpected error occured");
//     }
// } else {
//     die("an unexpected error occured");
// }