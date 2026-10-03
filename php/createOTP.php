<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$oneTimePass = $_POST['oneTimePass'];

$stmt = $_SESSION["conn"] -> prepare("INSERT INTO oneTimePasscodes (oneTimePass) VALUES (?)");
    $stmt->bind_param("s",
                        $oneTimePass);

if ($stmt -> execute()) {
    echo "New record created successfully. One-time passcode: " . $oneTimePass;
    exit;
} else {
    die("something went wrong");
}

$stmt -> close();
mysqli_close($conn);
?>