<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$string0 = $_POST['keyword0'];

$tags0 = array();
// echo "result: " . $string0;

$sql = "SELECT tags FROM tags WHERE tags LIKE '% $string0 %' OR tags LIKE '$string0 %' OR tags LIKE '% $string0' OR tags = '$string0' ";
    $result = $_SESSION["conn"]->query($sql);

    if ($result->numRows()>0) {
        while ($row = mysqli_fetch_array($result)) {
            $tags0 = array_merge($tags0, explode(" ", $row[0]));
        }
        $tags0 = array_unique_compact($tags0);

        for ($i=0;$i<count($tags0);$i++) {
            echo '<a href="/fonts?t='.$tags0[$i].'">'. $tags0[$i].'</a>';
            if ($i<count($tags0)-1) 
                { echo ",\n";
            }
        }
    }

    function array_unique_compact($a){
        $tmparr = array_unique($a);
        $i=0;
        foreach ($tmparr as $v) {
            $newarr[$i] = $v;
            $i++;
        }
        return $newarr;
    }

// $types = array();
// $rs = $db->select("select tags from fonts");
// if($db->numRows()>0)
// {
//   while($ftypes = mysql_fetch_array($rs))
//   {
//     $types = array_merge($types, explode(" ", $ftypes[0]));
//   }

//   $types = array_unique_compact($types);

//   for($i=0;$i<count($types);$i++)
//   {
//     echo '<a href="/fonts?t='.$types[$i].'">'. $types[$i].'</a>';
//     if($i<count($types)-1) echo ",\n";
//   }
// }

 // $tags0 = $row['tags'];
            // $num_rows0 = mysqli_num_rows($result);
            // if ($num_rows0 !='1') {
            //     //
            // } else {
            //     echo "$tags0";
            //     for($i=0;$i<count($tags0);$i++) {
            //         echo $tags0;
            //         if($i<count($tags0)-1) echo ",\n";
            //     }

            // }