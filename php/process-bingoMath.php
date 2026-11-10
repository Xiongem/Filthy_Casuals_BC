<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$userID = $_SESSION["user_id"];

$sql = "SELECT * FROM users WHERE user_id = $userID";
            $result = $_SESSION["conn"]->query($sql);
            $user = $result->fetch_assoc();  
                $total__points = $user["pointsYear"];

// $new_total = $bingo_total + $total__points;
//? MATH
$bingoSize = $_POST["bingoSize"];

//? SEND NEW POINT TOTAL TO DB
// $stmt1 = $_SESSION["conn"]->prepare("UPDATE `users` SET `pointsYear` = ? WHERE `user_id` = ?");
// $stmt1->bind_param("ii", 
//                     $new_total,
//                     $userID);

// if ($stmt1->execute() && $stmt1->affected_rows > 0) {
    //? SWITCH - SET AS USED
    switch ($bingoSize) {
        case '4':
            $squares = array($_POST['square1'], 
                            $_POST['square2'], 
                            $_POST['square3'], 
                            $_POST['square4']);
            
           for ($i = 0; $i < count($squares); $i++) {
                echo $squares[$i] . "<br>";
                $bingoID = $squares[$i];

                $sql2 = "SELECT `total_points` FROM `bingo` WHERE `bingo_id` = $bingoID";
                    $result2 = $_SESSION['conn']->query($sql2);
                    $bingo = $result2->fetch_assoc();
                    $sub_total[$i] = $bingo['total_points'];

                echo $sub_total[$i] . "<br>";

            
                // $stmt2 = $_SESSION['conn']->prepare('UPDATE `bingo` SET `used` = 1 WHERE `bingo_id` = ?');
                // $stmt2->bind_param('i',
                //                     $value);
            }
            //     if ($stmt2->execute() && $stmt2->affected_rows > 0) {
            //         exit('successfully awarded ' . $bingo_total . ' bingo points!');
            //     } else {
            //         die('failed to update bingos' . $stmt2 -> error);
            //     }
            // break;

        // case '5':
        //     $squares = array($_POST['square1'], 
        //                     $_POST['square2'], 
        //                     $_POST['square3'], 
        //                     $_POST['square4'], 
        //                     $_POST['square5']);
            
        //     foreach ($squares as $key => $value) {
        //         $stmt2 = $_SESSION['conn']->prepare('UPDATE `bingo` SET `used` = 1 WHERE `bingo_id` = ?');
        //         $stmt2->bind_param('i',
        //                             $value);
        //     }
        //         if ($stmt2->execute() && $stmt2->affected_rows > 0) {
        //             exit('successfully awarded ' . $bingo_total . ' bingo points!');
        //         } else {
        //             die('failed to update bingos' . $stmt2 -> error);
        //         }
        //     break;

        // case '6':
        //     $squares = array($_POST['square1'], 
        //                     $_POST['square2'], 
        //                     $_POST['square3'], 
        //                     $_POST['square4'], 
        //                     $_POST['square5'], 
        //                     $_POST['square6']);
            
        //     foreach ($squares as $key => $value) {
        //         $stmt2 = $_SESSION['conn']->prepare('UPDATE `bingo` SET `used` = 1 WHERE `bingo_id` = ?');
        //         $stmt2->bind_param('i',
        //                             $value);
        //     }
        //         if ($stmt2->execute() && $stmt2->affected_rows > 0) {
        //             exit('successfully awarded ' . $bingo_total . ' bingo points!');
        //         } else {
        //             die('failed to update bingos' . $stmt2 -> error);
        //         }
        //     break;

        // case '7':
        //     $squares = array($_POST['square1'], 
        //                     $_POST['square2'], 
        //                     $_POST['square3'], 
        //                     $_POST['square4'], 
        //                     $_POST['square5'], 
        //                     $_POST['square6'], 
        //                     $_POST['square7']);
            
        //     foreach ($squares as $key => $value) {
        //         $stmt2 = $_SESSION['conn']->prepare('UPDATE `bingo` SET `used` = 1 WHERE `bingo_id` = ?');
        //         $stmt2->bind_param('i',
        //                             $value);
        //     }
        //         if ($stmt2->execute() && $stmt2->affected_rows > 0) {
        //             exit('successfully awarded ' . $bingo_total . ' bingo points!');
        //         } else {
        //             die('failed to update bingos' . $stmt2 -> error);
        //         }
        //     break;

        // case '8':
        //     $squares = array($_POST['square1'], 
        //                     $_POST['square2'], 
        //                     $_POST['square3'], 
        //                     $_POST['square4'], 
        //                     $_POST['square5'], 
        //                     $_POST['square6'], 
        //                     $_POST['square7'],
        //                     $_POST['square8']);
            
        //     foreach ($squares as $key => $value) {
        //         $stmt2 = $_SESSION['conn']->prepare('UPDATE `bingo` SET `used` = 1 WHERE `bingo_id` = ?');
        //         $stmt2->bind_param('i',
        //                             $value);
        //     }
        //         if ($stmt2->execute() && $stmt2->affected_rows > 0) {
        //             exit('successfully awarded ' . $bingo_total . ' bingo points!');
        //         } else {
        //             die('failed to update bingos' . $stmt2 -> error);
        //         }
        //     break;

        // case '9':
        //     $squares = array($_POST['square1'], 
        //                     $_POST['square2'], 
        //                     $_POST['square3'], 
        //                     $_POST['square4'], 
        //                     $_POST['square5'], 
        //                     $_POST['square6'], 
        //                     $_POST['square7'],
        //                     $_POST['square8'],
        //                     $_POST['square9']);
            
        //     foreach ($squares as $key => $value) {
        //         $stmt2 = $_SESSION['conn']->prepare('UPDATE `bingo` SET `used` = 1 WHERE `bingo_id` = ?');
        //         $stmt2->bind_param('i',
        //                             $value);
        //     }
        //         if ($stmt2->execute() && $stmt2->affected_rows > 0) {
        //             exit('successfully awarded ' . $bingo_total . ' bingo points!');
        //         } else {
        //             die('failed to update bingos' . $stmt2 -> error);
        //         }
        //     break;

        // case '10':
        //     $squares = array($_POST['square1'], 
        //                     $_POST['square2'], 
        //                     $_POST['square3'], 
        //                     $_POST['square4'], 
        //                     $_POST['square5'], 
        //                     $_POST['square6'], 
        //                     $_POST['square7'],
        //                     $_POST['square8'],
        //                     $_POST['square9'],
        //                     $_POST['square10']);
            
        //     foreach ($squares as $key => $value) {
        //         $stmt2 = $_SESSION['conn']->prepare('UPDATE `bingo` SET `used` = 1 WHERE `bingo_id` = ?');
        //         $stmt2->bind_param('i',
        //                             $value);
        //     }
        //         if ($stmt2->execute() && $stmt2->affected_rows > 0) {
        //             exit('successfully awarded ' . $bingo_total . ' bingo points!');
        //         } else {
        //             die('failed to update bingos' . $stmt2 -> error);
        //         }
        //     break;
        
        // default:
        //     # code...
        //     break;
    }
// } else {
//     die('failed to update points' . $stmt1 -> error);
// }