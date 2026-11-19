<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$readID = $_POST["readID"];
$userID = $_POST["userID"];

//gets total points for the entry being deleted
$sql = "SELECT `totalPoints` 
            FROM `readHistory` 
            WHERE `user_id` = $userID  AND read_ID = $readID";
    $result = $_SESSION["conn"]->query($sql);
    $read = $result->fetch_assoc();
        $totalPoints = $read["totalPoints"];

//gets total points user has earned
$sql = "SELECT `pointsYear`, `recPoints` 
            FROM `users` 
            WHERE `user_id` = $userID";
    $result = $_SESSION["conn"]->query($sql);
    $user = $result->fetch_assoc();
        $pointsYear = $user["pointsYear"];
        $oldRecPoints = $user["recPoints"];

//removes entry points from user points and assigns the new total to a variable
$newTotal = $pointsYear - $totalPoints;
$newRecPoints = $oldRecPoints - 20;

if ($newTotal < 0) {
    $newTotal = 0;
}
if ($newRecPoints < 0) {
    $newRecPoints = 0;
}

//statement 1: sends new point total to database
$stmt1 = $_SESSION["conn"] -> prepare("UPDATE `users` 
                                        SET `pointsYear` = ?,
                                            `recPoints` = ? 
                                        WHERE `user_id` = ?");
$stmt1->bind_param("iii", 
                        $newTotal,
                        $newRecPoints,
                        $userID);


if($stmt1->execute() && $stmt1->affected_rows > 0) {
    //statement 2: deletes entry
    $stmt2 = $_SESSION["conn"] -> prepare("DELETE FROM `readHistory` 
                                            WHERE `user_id` = ?  AND read_ID = ?");
    $stmt2->bind_param("ii",
                            $userID,
                            $readID);

    if ($stmt2->execute() && $stmt2 -> affected_rows > 0) {
        echo ('<div class="deleteNotif">
                <h2>Bonus successfully deleted</h2>
            </div>');
    } else {
        die("Failed to delete bonus" . $stmt2->error);
    }
} else {
    die("Failed to delete bonus" . $stmt1->error);
}