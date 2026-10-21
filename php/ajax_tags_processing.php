<?php
ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$string0 = $_POST['tags'];
$sql0 = "SELECT tag_name FROM tags WHERE tag_name LIKE '%$string0%' ";
$sql0_query = $_SESSION["conn"]->query($sql0);

while ($row = mysqli_fetch_array($sql0_query)) {
  $tags0 = $row['tag_name'];
  $num_rows0 = mysqli_num_rows($sql0_query);
  if ($num_rows0 !='1') {}
  else {echo "$tags0";}
}