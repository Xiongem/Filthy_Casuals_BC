<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

//assigns POST data from ajax to variables
$readID = $_POST['read_ID'];
$userID = $_POST['user_ID'];

//gets total points for the entry being deleted
$sql = "SELECT `totalPoints` 
            FROM `readHistory` 
            WHERE `user_id` = $userID  AND read_ID = $readID";
    $result = $_SESSION["conn"]->query($sql);
    $read = $result->fetch_assoc();
        $totalPoints = $read["totalPoints"];

//gets total points user has earned
$sql = "SELECT `PointsMonth` 
            FROM `users` 
            WHERE `user_id` = $userID";
    $result = $_SESSION["conn"]->query($sql);
    $user = $result->fetch_assoc();
        $PointsMonth = $user["PointsMonth"];

//removes entry points from user points and assigns the new total to a variable
$newTotal = $PointsMonth - $totalPoints;

//statement 1: sends new point total to database
$stmt1 = $_SESSION["conn"] -> prepare("UPDATE `users` 
                                        SET `PointsMonth` = ? 
                                        WHERE `user_id` = ?");
$stmt1->bind_param("ii", 
                        $newTotal,
                        $userID);


if($stmt1->execute()) {
    //statement 2: deletes entry
    $stmt2 = $_SESSION["conn"] -> prepare("DELETE FROM `readHistory` 
                                            WHERE `user_id` = ?  AND read_ID = ?");
    $stmt2->bind_param("ii",
                            $userID,
                            $readID);
    $stmt2->execute();
    //sends new html to edit popup telling the user if the deletion was a success or not
    $result = $stmt2->get_result();
    if ($result->num_rows > 0) { ?>
        <div class="deleteNotif">
            <h1>Entry successfully deleted</h1>
        </div>
<?php } else { ?>
        <div class="deleteNotif">
            <h1>Failed to delete entry.</h1>
            <h2>Please try again</h2>
        </div>
<?php } 
} ?>