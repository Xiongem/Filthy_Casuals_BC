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


$stmt1 = $_SESSION["conn"] -> prepare("INSERT INTO `readHistory` (`userID`, 
                                                                `username`, 
                                                                `title`, 
                                                                `author`, 
                                                                `finishedDate`, 
                                                                `startedDate`, 
                                                                `pages`, 
                                                                `ongoing`, 
                                                                `mod1`, 
                                                                `mod2`, 
                                                                `comment`, 
                                                                `month`, 
                                                                `totalPoints`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param("isssssiiiisii",
                        $userID,
                        $user["username"],
                        $_POST["title"],
                        $_POST["author"],
                        $dateFinished,
                        $_POST["dateStarted"],
                        $_POST["pages"],
                        $ongoing,
                        $_POST["mod-1"],
                        $_POST["mod-2"],
                        $_POST["comment"],
                        $month,
                        $totalPoints);

if ($stmt1 -> execute()) {
    $newPointsMonth = $user["PointsMonth"] + $totalPoints;
    $stmt2 = $_SESSION["conn"] -> prepare("UPDATE `users` SET `PointsMonth` = ? WHERE `user_id` = ?");
        $stmt2->bind_param("ii", 
                            $newPointsMonth, 
                            $userID);
        
        header("Location: /readHistory.php?user_id=$userID");
        
        exit;
    } else {
        die("an unexpected error occured");
}