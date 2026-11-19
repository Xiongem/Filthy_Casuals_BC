<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

if ($_POST['username']) {
    $username = $_POST['username'];
    $giverID = $_POST["giverID"];

    $sql2 = "SELECT `username` FROM `users` WHERE `user_id` = $giverID";
        $result2 = $_SESSION["conn"]->query($sql2);
        $giver = $result2->fetch_assoc();
            $giverName = $giver["username"];

    $sql = "SELECT * FROM `users` WHERE `username` = '$username'";
        $result = $_SESSION["conn"]->query($sql);
        $user = $result->fetch_assoc();
            $userID = $user["user_id"];
            $oldTotal = $user["pointsYear"];
            $oldRecNum = $user["recPoints"];

    $newTotal = $oldTotal + 20;
    $newRecNum = $oldRecNum + 20;

    $stmt = $_SESSION["conn"] -> prepare("UPDATE `users` SET `pointsYear` = ?, `recPoints` = ? WHERE `username` = ?");
    $stmt -> bind_param("iis", 
                            $newTotal,
                            $newRecNum,
                            $username);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
            //? ADD NEW ENTRY TO HISTORY DB
            $title = "Friend Rec Points";
            $author = "From ".$giverName;
            $time = time();
            $dateFinished = date("Y-m-d H:i", $time);
            $month = date("n");
            $recPoints = 20;
            $friendRec = 1;

            $stmt2 = $_SESSION["conn"]->prepare("INSERT INTO `readHistory` (`user_id`,
                                                                            `title`,
                                                                            `author`,
                                                                            `finishedDate`,
                                                                            `month`,
                                                                            `totalPoints`,
                                                                            `friend_rec`) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt2->bind_param("isssiii",
                                    $userID,
                                    $title,
                                    $author,
                                    $dateFinished,
                                    $month,
                                    $recPoints,
                                    $friendRec);

        if ($stmt2->execute() && $stmt2->affected_rows > 0) {
            exit("Points awarded!");
        } else {
            die("Failed to award points.");
        }
    } else {
        die("Failed to award points.");
    }
} else {
    die("username empty");
}
