<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();
forceLogin();

$userID = $_SESSION["user_id"];

$ID = $_POST["user_id"];
$catname = $_POST['cat_name'];

if($catname!='All')
{
	$cond = "'$catname'";
}
else
{
	$cond = 0;
}

$fetch_query = $_SESSION["conn"]->query("SELECT * FROM readHistory WHERE user_id = $ID AND `month`= $cond");
$row = mysqli_num_rows($fetch_query);
if($row>0)
{
	while($res = mysqli_fetch_array($fetch_query))
	{?>
       <tr>
       	<td><?php echo $res['id']; ?></td>
       	<td><?php echo $res['name']; ?></td>
       	<td><?php echo $res['email']; ?></td>
        <td><?php echo $res['category']; ?></td>
       	<td><?php echo $res['phone']; ?></td>
       	<td><?php echo $res['address']; ?></td>
       </tr>
<?php	}
}
?>