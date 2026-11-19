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
$userID = $_POST["user_ID"];
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
    $words = $_POST["pages"];
    $fanfic = 1;

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
    $words = NULL;
    $fanfic = 0;

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

//assigns boolean value to ongoing variable. 0 = not checked, 1 = checked.
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

//first query
// $stmt1 = $_SESSION["conn"] -> prepare("UPDATE `readHistory` 
//                                         SET  `title` = ?, 
//                                             `author` = ?,
//                                             `finishedDate` = ?, 
//                                             `startedDate` = ?, 
//                                             `pages` = ?, 
//                                             `ongoing` = ?,
//                                             `fanfic` = ?,
//                                             `words` = ?, 
//                                             `mod1` = ?, 
//                                             `mod2` = ?,
//                                             `tags` = ?, 
//                                             `comment` = ?, 
//                                             `month` = ?,
//                                             `bingo_name` = ?, 
//                                             `totalPoints` = ?
//                                         WHERE `read_ID` = ? AND `user_id` = ?");
// //binds values to columns
// $stmt1->bind_param("ssssiiiiiissisiii",
//                         $_POST["title"],
//                         $_POST["author"],
//                         $_POST["dateFinished"],
//                         $_POST["dateStarted"],
//                         $pages,
//                         $ongoing,
//                         $fanfic,
//                         $words,
//                         $_POST["mod-1"],
//                         $_POST["mod-2"],
//                         $insert_tags,
//                         $_POST["comment"],
//                         $month,
//                         $bingoName,
//                         $newTotal,
//                         $readID,
//                         $userID);            
// //executes first statement
// if ($stmt1 -> execute()) {

    if ($oldTotal == $newTotal) { //if total points has not changed, keep points the same as what's in the database

        $newPointsYear == $yearTotal;

            echo ("old year total: ".$yearTotal."<br>");
            echo ("old total: ".$oldTotal."<br>");
            echo ("new total: ".$newTotal."<br>");
            echo ("New year points: ".$newPointsYear."<br>");

    } else { //if new points are different from DB, remove old points and add new points

        $subTotal = $yearTotal - $oldTotal;

        if ($subTotal < 0) {
            $subTotal = 0;
        }

        $newPointsYear = $subTotal + $newTotal;

            echo ("old year total: ".$yearTotal."<br>");
            echo ("old total: ".$oldTotal."<br>");
            echo ("subtotal: ".$subTotal."<br>");
            echo ("new total: ".$newTotal."<br>");
            echo ("New year points: ".$newPointsYear."<br>");

    }

    
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