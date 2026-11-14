<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$newBingo = $_POST["newBingo"];

$sql = "SELECT `bingo_name` FROM `bingoNames` WHERE `bingo_name` = ?";
    $stmt = $_SESSION["conn"]->prepare($sql);
    $stmt->bind_param("s",
                        $newBingo);
    $stmt->execute();

    $result = $stmt->get_result();
if ($result->num_rows <= 0) {
    $stmt2 = $_SESSION["conn"]->prepare("INSERT INTO `bingoNames` (`bingo_name`) VALUES (?)");
        $stmt2->bind_param("s",
                                $newBingo);

    if ($stmt2->execute() && $stmt2 -> affected_rows > 0) {
        echo "Successfully added new bingo";
    } else {
        die("Failed to add new bingo" . $stmt2 -> error);
    }
} else {
    echo "Bingo already exists";
}
    