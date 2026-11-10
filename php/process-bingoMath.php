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


//? MATH
$bingoSize = $_POST["bingoSize"];
$bingo_total = $_POST["total"];

$new_total = $bingo_total + $total__points;

//? SEND NEW POINT TOTAL TO DB
$stmt1 = $_SESSION["conn"]->prepare("UPDATE `users` SET `pointsYear` = ? WHERE `user_id` = ?");
$stmt1->bind_param("ii", 
                    $new_total,
                    $userID);

if ($stmt1->execute() && $stmt1->affected_rows > 0) {
    //? SWITCH - SET AS USED
    switch ($bingoSize) {
        case '4':
            $inputs = array($_POST['input1'], 
                            $_POST['input2'], 
                            $_POST['input3'], 
                            $_POST['input4']);
            
            foreach ($inputs as $key => $value) {
                $stmt2 = $_SESSION['conn']->prepare('UPDATE `bingo` SET `used` = 0 WHERE `bingo_id` = ?');
                $stmt2->bind_param('i',
                                    $value);
                $stmt2->execute();
            }
            exit('successfully awarded bingo points!');
            break;

        case '5':
            $inputs = array($_POST['input1'], 
                            $_POST['input2'], 
                            $_POST['input3'], 
                            $_POST['input4'], 
                            $_POST['input5']);
            
            foreach ($inputs as $key => $value) {
                $stmt2 = $_SESSION['conn']->prepare('UPDATE `bingo` SET `used` = 0 WHERE `bingo_id` = ?');
                $stmt2->bind_param('i',
                                    $value);
                $stmt2->execute();
            }
            exit('successfully awarded bingo points!');
            break;

        case '6':
            $inputs = array($_POST['input1'], 
                            $_POST['input2'], 
                            $_POST['input3'], 
                            $_POST['input4'], 
                            $_POST['input5'], 
                            $_POST['input6']);
            
            foreach ($inputs as $key => $value) {
                $stmt2 = $_SESSION['conn']->prepare('UPDATE `bingo` SET `used` = 0 WHERE `bingo_id` = ?');
                $stmt2->bind_param('i',
                                    $value);
                $stmt2->execute();
            }
            exit('successfully awarded bingo points!');
            break;

        case '7':
            $inputs = array($_POST['input1'], 
                            $_POST['input2'], 
                            $_POST['input3'], 
                            $_POST['input4'], 
                            $_POST['input5'], 
                            $_POST['input6'], 
                            $_POST['input7']);
            
            foreach ($inputs as $key => $value) {
                $stmt2 = $_SESSION['conn']->prepare('UPDATE `bingo` SET `used` = 0 WHERE `bingo_id` = ?');
                $stmt2->bind_param('i',
                                    $value);
                $stmt2->execute();
            }
            exit('successfully awarded bingo points!');
            break;

        case '8':
            $inputs = array($_POST['input1'], 
                            $_POST['input2'], 
                            $_POST['input3'], 
                            $_POST['input4'], 
                            $_POST['input5'], 
                            $_POST['input6'], 
                            $_POST['input7'],
                            $_POST['input8']);
            
            foreach ($inputs as $key => $value) {
                $stmt2 = $_SESSION['conn']->prepare('UPDATE `bingo` SET `used` = 0 WHERE `bingo_id` = ?');
                $stmt2->bind_param('i',
                                    $value);
                $stmt2->execute();
            }
            exit('successfully awarded bingo points!');
            break;

        case '9':
            $inputs = array($_POST['input1'], 
                            $_POST['input2'], 
                            $_POST['input3'], 
                            $_POST['input4'], 
                            $_POST['input5'], 
                            $_POST['input6'], 
                            $_POST['input7'],
                            $_POST['input8'],
                            $_POST['input9']);
            
            foreach ($inputs as $key => $value) {
                $stmt2 = $_SESSION['conn']->prepare('UPDATE `bingo` SET `used` = 0 WHERE `bingo_id` = ?');
                $stmt2->bind_param('i',
                                    $value);
                $stmt2->execute();
            }
            exit('successfully awarded bingo points!');
            break;

        case '10':
            $inputs = array($_POST['input1'], 
                            $_POST['input2'], 
                            $_POST['input3'], 
                            $_POST['input4'], 
                            $_POST['input5'], 
                            $_POST['input6'], 
                            $_POST['input7'],
                            $_POST['input8'],
                            $_POST['input9'],
                            $_POST['input10']);
            
            foreach ($inputs as $key => $value) {
                $stmt2 = $_SESSION['conn']->prepare('UPDATE `bingo` SET `used` = 1 WHERE `bingo_id` = ?');
                $stmt2->bind_param('i',
                                    $value);
                $stmt2->execute();
            }

            exit('successfully awarded ' . $bingo_total . ' bingo points!');
            break;
        
        default:
            # code...
            break;
    }
} else {
    die('failed to update points');
}