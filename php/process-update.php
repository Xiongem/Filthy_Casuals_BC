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

$month = date('n');
$totalPoints = calculateTotalPoints($_POST["pages"], $_POST["mod-1"], $_POST["mod-2"]);

$tags = $_POST["tag"][$newTag];

print_r($tags);

$test = $_POST["test"];
echo"$test";

$insert_tags = implode(",", $tags);

if (isset($_POST["diffDate"])) {
    $dateFinished = $_POST["dateFinished"];
} else {
    $dateFinished = date('Y-m-d');
}

if (isset($_POST["ongoing"])) {
    $ongoing = 1;
} else {
    $ongoing = 0;
}


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
//     $newPointsMonth = $user["PointsMonth"] + $totalPoints;
//     $stmt2 = $_SESSION["conn"] -> prepare("UPDATE `users` SET `PointsMonth` = ? WHERE `user_id` = ?");
//         $stmt2->bind_param("ii", 
//                             $newPointsMonth, 
//                             $userID);
//     if ($stmt2->execute()) {

//         // $sql = "SELECT tags FROM tags";
//         //         $result = $_SESSION["conn"]->query($sql);

//         foreach ($tags as $key => $value) {
//             $stmt3 = $_SESSION["conn"] -> prepare("INSERT INTO `tags` (`tags`) VALUES (?)
//                 ON DUPLICATE KEY UPDATE `tags` = ?;");
//             $stmt3->bind_param("s", 
//                                 $value);

//             $stmt3->execute();
//         }
                
//         header("Location: /readHistory.php?user_id=$userID");
        
//         exit;
//     } else {
//         die("an unexpected error occured");
//     }
// } else {
//     die("an unexpected error occured");
// }