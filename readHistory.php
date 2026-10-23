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

$ID = $_GET["user_id"];

// $sql = "SELECT * FROM users WHERE user_id = $ID";
//         $result = $_SESSION["conn"]->query($sql);
//         $user = $result->fetch_assoc();
//             $admin = $user['admin'];

//  $sql = "SELECT * FROM readHistory WHERE user_id = $ID";
//         $result = $_SESSION["conn"]->query($sql);
//         // $readHistory = $result->fetch_assoc();         
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="Filthy Casual Book Challenge"> 
    <meta property="og:description" content="A readHistory for filthy casuals."> 
    <meta property="og:image" content=""> 
    <meta property="og:url" content="">
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/readHistory.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/ea9288eda1.js" crossorigin="anonymous"></script>
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body id="body">
    <div class="popup-wrapper hide" id="editPopup">
        <div class="popup-container">
            <div class="close-wrapper">
                <i class="fa fa-close" onclick="closeEditRead()"></i>
            </div>
            <div class="popup-content">
                <h1>Edit The Thing</h1>
            </div>
        </div>
    </div>
    <header>
        <?= makeNav() ?>
    </header>
    <div class="history-wrapper" id="historyWrapper">
        <div class="title-wrapper">
            <h1>Your Reading History</h1>
        </div>


            <div class="history-table">
                <div class="sub-heading-wrapper">
                    <h2>Ongoing Reads</h2>
                </div>
                <div class="row">
                    <div class="head-edit">Edit</div>
                    <div class="table-head month">Month</div>
                    <div class="table-head title">Title</div>
                    <div class="table-head author">Author</div>
                    <div class="table-head pages">Pages</div>
                    <div class="table-head date">Date Started</div>
                    <div class="table-head date">Date Finished</div>
                    <div class="table-head ongoing">Ongoing</div>
                    <div class="table-head mod">mod1</div>
                    <div class="table-head mod">mod2</div>
                    <div class="table-head points">Points</div>
                    <div class="table-head comment">Comment</div>
                </div>
                <?php
                
                    $total_pages_ongoing = $_SESSION["conn"]->query("SELECT * 
                                                                        FROM `readHistory` 
                                                                        WHERE `user_id` = $ID AND `ongoing` = 1")->num_rows;

                    $page_ongoing = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

                    $num_results_on_page_ongoing = 15;
                if ($total_pages_ongoing > 0) {
                    if ($stmt1 = $_SESSION["conn"]->prepare("SELECT * 
                                                            FROM `readHistory`
                                                            WHERE `user_id` = $ID AND `ongoing` = 1 
                                                            ORDER BY `month` 
                                                            DESC LIMIT ?,?")) {
                        // Calculate the page to get the results we need from our table.
                        $calc_page_ongoing = ($page_ongoing - 1) * $num_results_on_page_ongoing;
                        $stmt1->bind_param('ii', $calc_page_ongoing, $num_results_on_page_ongoing);
                        $stmt1->execute(); 
                        // Get the results...
                        $result_ongoing = $stmt1->get_result();
                        $stmt1->close();
                    }
                
                    while ($readHistory = $result_ongoing->fetch_assoc()) {
                        $title = $readHistory['title'];
                        $author = $readHistory['author'];
                        $finishedDate = $readHistory['finishedDate'];
                        if ($readHistory['startedDate'] == "0000-00-00") {
                            $startedDate = '--';
                        } else {
                            $startedDate = $readHistory['startedDate'];
                        }
                        $pages = $readHistory['pages'];
                        $mod1 = $readHistory['mod1'];
                        switch ($mod1) {
                            case 1:
                                $mod1 = "normal";
                                break;
                            case 2:
                                $mod1 = "manga/comic";
                                break;
                            case 3:
                                $mod1 = "challenge";
                                break;
                            case 4:
                                $mod1 = "challenge: manga/comic";
                                break;
                            case 5:
                                $mod1 = "buddy read";
                                break;
                            case 6:
                                $mod1 = "friend rec";
                                break;
                            case 7:
                                $mod1 = "seasonal";
                                break;
                            case 8:
                                $mod1 = "read-a-thon";
                                break;
                            case 9:
                                $mod1 = "educational";
                                break;
                            case 10:
                                $mod1 = "educational: manga/comic";
                                break;
                        }
                        $mod2 = $readHistory['mod2'];
                        switch ($mod2) {
                            case 1:
                                $mod2 = "normal";
                                break;
                            case 2:
                                $mod2 = "challenge";
                                break;
                            case 3:
                                $mod2 = "buddy read";
                                break;
                            case 4:
                                $mod2 = "friend rec";
                                break;
                            case 5:
                                $mod2 = "seasonal";
                                break;
                            case 6:
                                $mod2 = "read-a-thon";
                                break;
                            case 7:
                                $mod2 = "educational";
                                break;
                            case 8:
                                $mod2 = "educational: manga/comic";
                                break;
                        }

                        $ongoing = $readHistory['ongoing'];
                        if ($readHistory['tags'] !== NULL) {
                            $tags = explode(",", $readHistory['tags']);
                        } else {
                            $tags = "";
                        }
                        if ($ongoing == 1) {
                            $ongoingChecked = 'yes';
                        } else {
                            $ongoingChecked = 'no';
                        }
                        if (isset($readHistory['comment'])) {
                            $comment = $readHistory['comment'];
                        } elseif ($readHistory['comment'] == '') {
                            $comment = '--';
                        } else {
                            $comment = '';
                        }

                        $totalPoints = $readHistory['totalPoints'];  

                        $month = $readHistory['month'];
                        switch ($month) {
                            case 1:
                                $tableMonth = "Jan";
                                break;
                            case 2:
                                $tableMonth = "Feb";
                                break;
                            case 3:
                                $tableMonth = "March";
                                break;
                            case 4:
                                $tableMonth = "April";
                                break;
                            case 5:
                                $tableMonth = "May";
                                break;
                            case 6:
                                $tableMonth = "June";
                                break;
                            case 7:
                                $tableMonth = "July";
                                break;
                            case 8:
                                $tableMonth = "Aug";
                                break;
                            case 9:
                                $tableMonth = "Sept";
                                break;
                            case 10:
                                $tableMonth = "Oct";
                                break;
                            case 11:
                                $tableMonth = "Nov";
                                break;
                            case 12:
                                $tableMonth = "Dec";
                                break;
                            default:
                                $tableMonth = $month;
                                break;
                        }
                ?>
                    <div class="row">
                        <div class="edit" id="edit"><i class="fa fa-gear" id="edit-icon" onclick="editRead()"></i></div>
                        <div class="table-item month"> <?= htmlspecialchars($tableMonth) ?> </div>
                        <div class="table-item title"> <?= htmlspecialchars($title) ?> </div>
                        <div class="table-item author"> <?= htmlspecialchars($author) ?> </div>
                        <div class="table-item pages"> <?= htmlspecialchars($pages) ?> </div>
                        <div class="table-item date"> <?= htmlspecialchars($startedDate) ?> </div>
                        <div class="table-item date"> <?= htmlspecialchars($finishedDate) ?></div>
                        <div class="table-item ongoing"> <?= $ongoingChecked ?> </div>
                        <div class="table-item mod"> <?= $mod1 ?> </div>
                        <div class="table-item mod"> <?= $mod2 ?> </div>
                        <div class="table-item points"> <?= htmlspecialchars($totalPoints) ?> </div>
                        <div class="table-item comment"> <?= htmlspecialchars($comment) ?> </div>
                    </div>
                    <div class="notch-wrapper" id="notchWrapper">
                        <?php if (isset($readHistory['tags'])) { ?>
                            <?php foreach ($tags as $key => $value) { ?>
                                <div class="notch-arrow" id="<?= htmlspecialchars($value) ?>" onclick="removeTag(<?= htmlspecialchars($value) ?>)">
                                    <p class='tag-content' id='tagContent'><?= htmlspecialchars($value) ?></p>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php }} else { ?>
                        <div class="not-found">No Ongoing Reading History Found</div>
                    <?php } ?>
            </div>
            <?php if (ceil($total_pages_ongoing / $num_results_on_page_ongoing) > 1) { ?>
                <div class="pages-wrapper">
                <?php if ($page_ongoing > 1) { ?>
                    <a class="prev" href="readHistory.php?user_id=<?=$ID?>&page=<?php echo $page_ongoing-1 ?>">Prev</a>
                <?php } ?>
                
                <?php if ($page_ongoing > 3) { ?>
                    <a class="start" href="readHistory.php?user_id=<?=$ID?>&page=1">1</a>
                    <span class="dots">...</span>
                <?php } ?>

                <?php if ($page_ongoing-2 > 0) {?>
                    <a class="page" href="readHistory.php?user_id=<?=$ID?>&page=<?php echo $page_ongoing-2 ?>"><?php echo $page_ongoing-2 ?></a>
                <?php } ?>
                <?php if ($page_ongoing-1 > 0) {?>
                    <a class="page" href="readHistory.php?user_id=<?=$ID?>&page=<?php echo $page_ongoing-1 ?>"><?php echo $page_ongoing-1 ?></a>
                <?php } ?>

                <a class="currentpage" href="readHistory.php?user_id=<?=$ID?>&page=<?php echo $page_ongoing ?>"><?php echo $page_ongoing ?></a>

                <?php if ($page_ongoing+1 < ceil($total_pages_ongoing / $num_results_on_page_ongoing)+1) {?>
                    <a class="page" href="readHistory.php?user_id=<?=$ID?>&page=<?php echo $page_ongoing+1 ?>"><?php echo $page_ongoing+1 ?></a>
                <?php } ?>
                <?php if ($page_ongoing+2 < ceil($total_pages_ongoing / $num_results_on_page_ongoing)+1) {?>
                    <a class="page" href="readHistory.php?user_id=<?=$ID?>&page=<?php echo $page_ongoing+2 ?>"><?php echo $page_ongoing+2 ?></a>
                <?php } ?>

                <?php if ($page_ongoing < ceil($total_pages_ongoing / $num_results_on_page_ongoing)-2) {?>
                    <span class="dots">...</span>
                    <a class="end" href="readHistory.php?user_id=<?=$ID?>&page=<?php echo ceil($total_pages_ongoing / $num_results_on_page_ongoing) ?>"><?php echo ceil($total_pages_ongoing / $num_results_on_page_ongoing) ?></a>
                <?php } ?>

                <?php if ($page_ongoing < ceil($total_pages_ongoing / $num_results_on_page_ongoing)) {?>
                    <a class="next" href="readHistory.php?user_id=<?=$ID?>&page=<?php echo $page_ongoing+1 ?>">Next</a>
                <?php } ?>
                </div>
            <?php } ?>
        


            <div class="form-group">
                <select class="form-control" onchange="selectdata(this.options[this.selectedIndex].value)">
                    <option value="All">All</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>

        
            <div class="history-table" id="fullHistory">
                <div class="sub-heading-wrapper">
                    <h2>Full History</h2>
                </div>
                <div class="row">
                    <div class="head-edit">Edit</div>
                    <div class="table-head month">Month</div>
                    <div class="table-head title">Title</div>
                    <div class="table-head author">Author</div>
                    <div class="table-head pages">Pages</div>
                    <div class="table-head date">Date Started</div>
                    <div class="table-head date">Date Finished</div>
                    <div class="table-head ongoing">Ongoing</div>
                    <div class="table-head mod">mod1</div>
                    <div class="table-head mod">mod2</div>
                    <div class="table-head points">Points</div>
                    <div class="table-head comment">Comment</div>
                </div>
                <div id="result">

                </div>
        
                <script type="text/javascript">
                $(document).ready(function(){
                showdata();
                });
                function showdata()
                {
                $.ajax({
                    url: 'php/showData.php',
                    method: 'post',
                    data: {user_id:$ID},
                    success: function(result)
                    {
                        $("#result").html(result);
                    }
                    });
                }

                function selectdata(cat)
                {
                $.ajax({
                    url: 'php/selectData.php',
                    method: 'post',
                    data: {cat_name:cat,
                            user_id:$ID},
                    success: function(result)
                    {
                    $("#result").html(result);
                    }
                });
                }
                </script>

    </div>
</body>
</html>