<?php
ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$string0 = $_POST['keyword0'];
$sql0 = "select tags from tags where tags like '%$string0%' ";
$sql0_query = $con->query($sql0);

while ($row = mysqli_fetch_array($sql0_query)) {
  $tags0 = $row['tags'];
  $num_rows0 = mysqli_num_rows($sql0_query);
  if ($num_rows0 !='1') {}
  else {echo "$tags0";}
}