<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$userID = $_SESSION["user_id"];

$stmt1 = $_SESSION["conn"]->prepare("DELETE FROM `bingo` WHERE `user_id` = ?");

$stmt1->bind_param("i",
                    $userID);

$stmt1->execute();


    $stmt2 = $_SESSION["conn"]->prepare("DELETE FROM `friendRecs` WHERE `user_id` = ?");

    $stmt2->bind_param("i",
                        $userID);

    $stmt2->execute();


        $stmt3 = $_SESSION["conn"]->prepare("DELETE FROM `readHistory` WHERE `user_id` = ?");

        $stmt3->bind_param("i",
                            $userID);

        $stmt3->execute();


            $stmt4 = $_SESSION["conn"]->prepare("DELETE FROM `users` WHERE `user_id` = ?");

            $stmt4->bind_param("i",
                                $userID);

            if ($stmt4->execute() && $stmt4 -> affected_rows > 0) {
                header("Location: /login.php");
                exit;
            } else {
                die("something went wrong" . $stmt4 -> error);
            }