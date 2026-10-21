<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$string0 = $_POST['keyword0'];

// echo "result: " . $string0;

$sql = "SELECT tags FROM tags WHERE tags LIKE '%$string0%' ";
    $result = $_SESSION["conn"]->query($sql);

while ($row = mysqli_fetch_array($result)) {
    $tags0 = $row['tags'];
    $num_rows0 = mysqli_num_rows($result);
    if ($num_rows0 !='1') {
        //
    } else {
        // echo "$tags0";
        echo "<div class='notch-arrow'>
                <p class='tag-content'>$tags0</p>
            </div>";
    }
} 