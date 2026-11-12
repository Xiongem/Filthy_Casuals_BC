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
        $username = $user["username"];
        $timezone = $user["timezone"];

// $timezone = $_SESSION["timezone"];
date_default_timezone_set("$timezone");

$now = date("Y-m-d H:i:s");

$stmt = $_SESSION['conn'] -> prepare("UPDATE `challenges` SET `updated_by` = ?,
                                                                `updated_at` = ?,
                                                                `month_jan` = ?, 
                                                                `month_feb` = ?,
                                                                `month_march` = ?,
                                                                `month_april` = ?,
                                                                `month_may` = ?,
                                                                `month_june` = ?,
                                                                `month_july` = ?,
                                                                `month_aug` = ?,
                                                                `month_sept` = ?,
                                                                `month_oct` = ?,
                                                                `month_nov` = ?,
                                                                `month_dec` = ?,
                                                                    `jan_descr` = ?,
                                                                    `feb_descr` = ?,
                                                                    `march_descr` = ?,
                                                                    `april_descr` = ?,
                                                                    `may_descr` = ?,
                                                                    `june_descr` = ?,
                                                                    `july_descr` = ?,
                                                                    `aug_descr` = ?,
                                                                    `sept_descr` = ?,
                                                                    `oct_descr` = ?,
                                                                    `nov_descr` = ?,
                                                                    `dec_descr` = ?");
    $stmt -> bind_param("ssssssssssssssssssssssssss", 
                        $username, 
                        $now,
                        $_POST["month_jan"],
                        $_POST["month_feb"],
                        $_POST["month_march"],
                        $_POST["month_april"],
                        $_POST["month_may"],
                        $_POST["month_june"],
                        $_POST["month_july"],
                        $_POST["month_aug"],
                        $_POST["month_sept"],
                        $_POST["month_oct"],
                        $_POST["month_nov"],
                        $_POST["month_dec"],
                            $_POST["jan_Descr"],
                            $_POST["feb_Descr"],
                            $_POST["march_Descr"],
                            $_POST["april_Descr"],
                            $_POST["may_Descr"],
                            $_POST["june_Descr"],
                            $_POST["july_Descr"],
                            $_POST["aug_Descr"],
                            $_POST["sept_Descr"],
                            $_POST["oct_Descr"],
                            $_POST["nov_Descr"],
                            $_POST["dec_Descr"],);

    if ($stmt -> execute() && $stmt -> affected_rows > 0) {
        echo "Challenges updated successfully";
    } else {
        echo "Error updating challenges: " . $stmt -> error;
    }