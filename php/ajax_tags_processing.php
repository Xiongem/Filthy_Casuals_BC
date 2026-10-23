<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

// $string0 = $_POST['keyword0'];

// // echo "result: " . $string0;

// $sql = "SELECT tags FROM tags WHERE tags LIKE '%$string0%' ";
//     $result = $_SESSION["conn"]->query($sql);

// while ($row = $result -> fetch_assoc()) {
//     $tags0 = $row['tags'];
//     $num_rows0 = mysqli_num_rows($result);
//     if ($num_rows0 !='1') {
//         //
//     } else {
//         echo "$tags0";
//     }
// } 

if (isset($_POST['query'])) {
    $inpText = $_POST['query'];

        $sql = "SELECT tags FROM tags WHERE tags LIKE '%$inpText%' ";
        $result = $_SESSION["conn"]->query($sql);
        $results = $result->fetch_assoc();

    // $stmt = $_SESSION["conn"]->prepare("SELECT tags FROM tags WHERE tags LIKE ?");
    // $stmt->bind_param("s", 
    //                     '%$inpText%');
    // $stmt->execute(); 
    // $result = $stmt->get_result();
    // $results = $result->fetch_assoc();

    if ($results) {
      foreach ($results as $row) {
        echo '<a href="#" class="searchResult">$row["tags"]</a>';
      }
    } else {
      echo '<p class="list-group-item border-1">No Record</p>';
    }
  }
//   ['tags' => '%' . $inpText . '%']


// $sql = 'SELECT country_name FROM countries WHERE country_name LIKE :country';
//     $stmt = $conn->prepare($sql);
//     $stmt->execute(['country' => '%' . $inpText . '%']);
//     $result = $stmt->fetchAll();


//     $stmt1 = $_SESSION["conn"]->prepare("SELECT * 
//                                         FROM `readHistory`
//                                         WHERE `user_id` = $ID AND `ongoing` = 1 
//                                         ORDER BY `month` 
//                                         DESC LIMIT ?,?");
//     // Calculate the page to get the results we need from our table.
    
//     $stmt1->bind_param('ii', $calc_page_ongoing, $num_results_on_page_ongoing);
//     $stmt1->execute(); 
//     // Get the results...
//     $result_ongoing = $stmt1->get_result();
//     $stmt1->close();

//     while ($readHistory = $result_ongoing->fetch_assoc()) {}