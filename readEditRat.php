<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();
forceLogin();

//assign POST data from ajax to variables
$readID = $_GET['read_ID'];
$ID = $_GET['user_ID'];

//pull data from database for the chosen entry and assign required variables
$sql = "SELECT * FROM `readHistory` WHERE `user_id` = $ID  AND read_ID = $readID";
    $result = $_SESSION["conn"]->query($sql);
    $read = $result->fetch_assoc();
        $title = $read["title"];
        $author = $read["author"];
        $dateFinished = $read["finishedDate"];
        $pages = $read["pages"];
        $pagesOut = $read["pagesOut"];
        $pagesIn = $read["pagesIn"];
        $ongoing = $read["ongoing"];
        list($mod1Out, $mod1In) = explode(",", $read["mod1"]);
        list($mod2Out, $mod2In) = explode(",", $read["mod2"]);
        $fanfic = $read["fanfic"];
        $words = $read["words"];

$sql2 = "SELECT * FROM `bingoNames` WHERE `active` = 1";
$result2 = $_SESSION["conn"]->query($sql2);
    $bingo2 = $result2->fetch_assoc();
    if ($bingo2) {
        $active = $bingo2["active"];
        $activeName = $bingo2["bingo_name"];
    } else {
        $active = 0;
        $activeName = NULL;
    }

//set variables for columns that can be NULL in the db
if (isset($read["startedDate"])) {
    $startedDate = $read["startedDate"];
} else {
    $startedDate = "";
}

$dateFinished = strtotime($dateFinished);
$dateFinished = date("Y-m-d", $dateFinished);

if (isset($read["tags"])) {
    $tags = $read["tags"];
    $tags_array = explode(",", $tags);
} else {
    $tags_array = NULL;
}

if (isset($read["comment"])) {
    $comment = $read["comment"];
} else {
    $comment = "";
}

if ($fanfic ==1) {
    if ($words) {
        $pages = $words;
    }
}
 echo $mod1Out;
?>
