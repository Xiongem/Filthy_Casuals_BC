<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$userID = $_POST['userID'];

$stmt = $_SESSION['conn'] -> prepare("INSERT INTO `friendRecs` (`rec1_title`, 
                                                                `rec1_author`, 
                                                                `rec2_title`, 
                                                                `rec2_author`, 
                                                                `rec3_title`,
                                                                `rec3_author`,
                                                                `rec4_title`,
                                                                `rec4_author`,
                                                                `rec5_title`,
                                                                `rec5_author`)
                                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt -> bind_param("ssssssssssi", 
                        $_POST["rec1Title"],
                        $_POST["rec1Author"],
                        $_POST["rec2Title"],
                        $_POST["rec2Author"],
                        $_POST["rec3Title"],
                        $_POST["rec3Author"],
                        $_POST["rec4Title"],
                        $_POST["rec4Author"],
                        $_POST["rec5Title"],
                        $_POST["rec5Author"], 
                        $userID);

if ($stmt -> execute()) {
    header("Location: /friendRec.php");
    exit;
} else {
    die("failed to add friend recommendations");
}
