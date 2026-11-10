<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$userID = $_SESSION["user_id"];

$bingoSize = $_POST["bingoSize"];

    //? SWITCH - SET AS USED
    switch ($bingoSize) {
        case '4':
            //?CREATE AN ARRAY OF ALL THE SQUARES' IDs
            $squares = array($_POST['square1'], 
                            $_POST['square2'], 
                            $_POST['square3'], 
                            $_POST['square4']);
            
           for ($i = 0; $i < count($squares); $i++) {
                $bingoID = $squares[$i];

                //? GET POINTS FOR EACH SQUARE FROM DB AND LOOP THROUGH TO ASSIGN THEM TO VARIABLES
                $sql2 = "SELECT `total_points` FROM `bingo` WHERE `bingo_id` = $bingoID";
                    $result2 = $_SESSION['conn']->query($sql2);
                    $bingo = $result2->fetch_assoc();
                    $bingo_points[$i + 1] = $bingo['total_points'];
            }

            //? MATH
            $sub_total1 = $bingo_points[1] * 1.10;
            $sub_total2 = $bingo_points[2] * 1.10;
            $sub_total3 = $bingo_points[3] * 1.10;
            $sub_total4 = $bingo_points[4] * 1.10;

            $bingo_total = round($sub_total1 
                                + $sub_total2 
                                + $sub_total3 
                                + $sub_total4);

            echo "Possible points: +" . $bingo_total;
            
            break;

        case '5':
            $squares = array($_POST['square1'], 
                            $_POST['square2'], 
                            $_POST['square3'], 
                            $_POST['square4'], 
                            $_POST['square5']);
            
            for ($i = 0; $i < count($squares); $i++) {
                $bingoID = $squares[$i];

                //? GET POINTS FOR EACH SQUARE FROM DB AND LOOP THROUGH TO ASSIGN THEM TO VARIABLES
                $sql2 = "SELECT `total_points` FROM `bingo` WHERE `bingo_id` = $bingoID";
                    $result2 = $_SESSION['conn']->query($sql2);
                    $bingo = $result2->fetch_assoc();
                    $bingo_points[$i + 1] = $bingo['total_points'];
            }

            //? MATH
            $sub_total1 = $bingo_points[1] * 1.10;
            $sub_total2 = $bingo_points[2] * 1.10;
            $sub_total3 = $bingo_points[3] * 1.10;
            $sub_total4 = $bingo_points[4] * 1.10;
            $sub_total5 = $bingo_points[5] * 1.10;

            $bingo_total = round($sub_total1 
                                    + $sub_total2 
                                    + $sub_total3 
                                    + $sub_total4 
                                    + $sub_total5);

            echo "Possible points: +" . $bingo_total;

            break;

        case '6':
            $squares = array($_POST['square1'], 
                            $_POST['square2'], 
                            $_POST['square3'], 
                            $_POST['square4'], 
                            $_POST['square5'],
                            $_POST['square6']);
            
            for ($i = 0; $i < count($squares); $i++) {
                $bingoID = $squares[$i];

                //? GET POINTS FOR EACH SQUARE FROM DB AND LOOP THROUGH TO ASSIGN THEM TO VARIABLES
                $sql2 = "SELECT `total_points` FROM `bingo` WHERE `bingo_id` = $bingoID";
                    $result2 = $_SESSION['conn']->query($sql2);
                    $bingo = $result2->fetch_assoc();
                    $bingo_points[$i + 1] = $bingo['total_points'];
            }

            //? MATH
            $sub_total1 = $bingo_points[1] * 1.10;
            $sub_total2 = $bingo_points[2] * 1.10;
            $sub_total3 = $bingo_points[3] * 1.10;
            $sub_total4 = $bingo_points[4] * 1.10;
            $sub_total5 = $bingo_points[5] * 1.10;
            $sub_total6 = $bingo_points[6] * 1.10;

            $bingo_total = round($sub_total1 
                                    + $sub_total2 
                                    + $sub_total3 
                                    + $sub_total4 
                                    + $sub_total5 
                                    + $sub_total6);

            echo "Possible points: +" . $bingo_total;

            break;

        case '7':
            $squares = array($_POST['square1'], 
                            $_POST['square2'], 
                            $_POST['square3'], 
                            $_POST['square4'], 
                            $_POST['square5'], 
                            $_POST['square6'], 
                            $_POST['square7']);
            
            for ($i = 0; $i < count($squares); $i++) {
                $bingoID = $squares[$i];

                //? GET POINTS FOR EACH SQUARE FROM DB AND LOOP THROUGH TO ASSIGN THEM TO VARIABLES
                $sql2 = "SELECT `total_points` FROM `bingo` WHERE `bingo_id` = $bingoID";
                    $result2 = $_SESSION['conn']->query($sql2);
                    $bingo = $result2->fetch_assoc();
                    $bingo_points[$i + 1] = $bingo['total_points'];
            }

            //? MATH
            $sub_total1 = $bingo_points[1] * 1.10;
            $sub_total2 = $bingo_points[2] * 1.10;
            $sub_total3 = $bingo_points[3] * 1.10;
            $sub_total4 = $bingo_points[4] * 1.10;
            $sub_total5 = $bingo_points[5] * 1.10;
            $sub_total6 = $bingo_points[6] * 1.10;
            $sub_total7 = $bingo_points[7] * 1.10;

            $bingo_total = round($sub_total1 
                                    + $sub_total2 
                                    + $sub_total3 
                                    + $sub_total4 
                                    + $sub_total5 
                                    + $sub_total6 
                                    + $sub_total7);

            echo "Possible points: +" . $bingo_total;

            break;

        case '8':
            $squares = array($_POST['square1'], 
                            $_POST['square2'], 
                            $_POST['square3'], 
                            $_POST['square4'], 
                            $_POST['square5'], 
                            $_POST['square6'], 
                            $_POST['square7'],
                            $_POST['square8']);
            
            for ($i = 0; $i < count($squares); $i++) {
                $bingoID = $squares[$i];

                //? GET POINTS FOR EACH SQUARE FROM DB AND LOOP THROUGH TO ASSIGN THEM TO VARIABLES
                $sql2 = "SELECT `total_points` FROM `bingo` WHERE `bingo_id` = $bingoID";
                    $result2 = $_SESSION['conn']->query($sql2);
                    $bingo = $result2->fetch_assoc();
                    $bingo_points[$i + 1] = $bingo['total_points'];
            }

            //? MATH
            $sub_total1 = $bingo_points[1] * 1.10;
            $sub_total2 = $bingo_points[2] * 1.10;
            $sub_total3 = $bingo_points[3] * 1.10;
            $sub_total4 = $bingo_points[4] * 1.10;
            $sub_total5 = $bingo_points[5] * 1.10;
            $sub_total6 = $bingo_points[6] * 1.10;
            $sub_total7 = $bingo_points[7] * 1.10;
            $sub_total8 = $bingo_points[8] * 1.10;

            $bingo_total = round($sub_total1 
                                    + $sub_total2 
                                    + $sub_total3 
                                    + $sub_total4 
                                    + $sub_total5 
                                    + $sub_total6 
                                    + $sub_total7 
                                    + $sub_total8);

            echo "Possible points: +" . $bingo_total;

            break;

        case '9':
            $squares = array($_POST['square1'], 
                            $_POST['square2'], 
                            $_POST['square3'], 
                            $_POST['square4'], 
                            $_POST['square5'], 
                            $_POST['square6'], 
                            $_POST['square7'],
                            $_POST['square8'],
                            $_POST['square9']);
            
            for ($i = 0; $i < count($squares); $i++) {
                $bingoID = $squares[$i];

                //? GET POINTS FOR EACH SQUARE FROM DB AND LOOP THROUGH TO ASSIGN THEM TO VARIABLES
                $sql2 = "SELECT `total_points` FROM `bingo` WHERE `bingo_id` = $bingoID";
                    $result2 = $_SESSION['conn']->query($sql2);
                    $bingo = $result2->fetch_assoc();
                    $bingo_points[$i + 1] = $bingo['total_points'];
            }

            //? MATH
            $sub_total1 = $bingo_points[1] * 1.10;
            $sub_total2 = $bingo_points[2] * 1.10;
            $sub_total3 = $bingo_points[3] * 1.10;
            $sub_total4 = $bingo_points[4] * 1.10;
            $sub_total5 = $bingo_points[5] * 1.10;
            $sub_total6 = $bingo_points[6] * 1.10;
            $sub_total7 = $bingo_points[7] * 1.10;
            $sub_total8 = $bingo_points[8] * 1.10;
            $sub_total9 = $bingo_points[9] * 1.10;

            $bingo_total = round($sub_total1 
                                    + $sub_total2 
                                    + $sub_total3 
                                    + $sub_total4 
                                    + $sub_total5 
                                    + $sub_total6 
                                    + $sub_total7 
                                    + $sub_total8 
                                    + $sub_total9);

            echo "Possible points: +" . $bingo_total;

            break;

        case '10':
            $squares = array($_POST['square1'], 
                            $_POST['square2'], 
                            $_POST['square3'], 
                            $_POST['square4'], 
                            $_POST['square5'], 
                            $_POST['square6'], 
                            $_POST['square7'],
                            $_POST['square8'],
                            $_POST['square9'],
                            $_POST['square10']);
            
            for ($i = 0; $i < count($squares); $i++) {
                $bingoID = $squares[$i];

                //? GET POINTS FOR EACH SQUARE FROM DB AND LOOP THROUGH TO ASSIGN THEM TO VARIABLES
                $sql2 = "SELECT `total_points` FROM `bingo` WHERE `bingo_id` = $bingoID";
                    $result2 = $_SESSION['conn']->query($sql2);
                    $bingo = $result2->fetch_assoc();
                    $bingo_points[$i + 1] = $bingo['total_points'];
            }

            //? MATH
            $sub_total1 = $bingo_points[1] * 1.10;
            $sub_total2 = $bingo_points[2] * 1.10;
            $sub_total3 = $bingo_points[3] * 1.10;
            $sub_total4 = $bingo_points[4] * 1.10;
            $sub_total5 = $bingo_points[5] * 1.10;
            $sub_total6 = $bingo_points[6] * 1.10;
            $sub_total7 = $bingo_points[7] * 1.10;
            $sub_total8 = $bingo_points[8] * 1.10;
            $sub_total9 = $bingo_points[9] * 1.10;
            $sub_total10 = $bingo_points[10] * 1.10;

            $bingo_total = round($sub_total1 
                                    + $sub_total2 
                                    + $sub_total3 
                                    + $sub_total4 
                                    + $sub_total5 
                                    + $sub_total6 
                                    + $sub_total7 
                                    + $sub_total8 
                                    + $sub_total9
                                    + $sub_total10);

            echo "Possible points: +" . $bingo_total;
            
            break;
        
        default:
            # code...
            break;
    }
