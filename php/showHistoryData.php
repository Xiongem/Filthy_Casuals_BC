<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

if (isset($_SESSION["user_id"])) {
    $userID = $_SESSION["user_id"];
} else {
    $userID = "none";
}

$admin = $_SESSION["admin"];
$ID = $_POST["user_id"];

$fetch_query = $_SESSION["conn"]->query("SELECT * FROM readHistory WHERE user_id = $ID ORDER BY `finishedDate` DESC");
$row = mysqli_num_rows($fetch_query);
if($row>0) {
    while($readHistory = mysqli_fetch_array($fetch_query)) {
        $readID = $readHistory["read_ID"];
        $title = $readHistory['title'];
        $author = $readHistory['author'];
        $date = strtotime($readHistory['finishedDate']);
        $finishedDate = date("Y-m-d H:i", $date);
        if ($readHistory['startedDate'] == "0000-00-00" || $readHistory['startedDate'] == NULL) {
            $startedDate = '- -';
        } else {
            $startedDate = $readHistory['startedDate'];
        }
        $pages = $readHistory['pages'];

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
        $totalPoints = $readHistory['totalPoints']; 
        $bingo = $readHistory['bingo']; 
        $friendRec = $readHistory['friend_rec']; 
    ?>
    <div class="row" id="<?= $readID ?>">
        <?php if ($userID === $ID || $admin == 1) { 
            if ($bingo == 1 || $friendRec == 1) {?>
                <a class="edit" id="edit" href="#" onclick="showDeletePopup(<?=$readID?>, <?=$ID?>)">
                    <ion-icon name="remove-circle" id="delete-icon"></ion-icon>
                </a>
            <?php } else { ?>
            <a class="edit" id="edit" href="readEdit.php?read_ID=<?=$readID?>&user_ID=<?=$ID?>">
                <ion-icon name="settings" id="edit-icon"></ion-icon>
            </a>
        <?php }} else { ?>
            <div class="edit" id="edit">
                <ion-icon name="lock-closed" id="close-icon"></ion-icon>
            </div>
        <?php }?>
        <div class="table-item month"> <?= htmlspecialchars($tableMonth) ?> </div>
        <div class="table-item title"> <?= htmlspecialchars($title) ?> </div>
        <div class="table-item author"> <?= htmlspecialchars($author) ?> </div>
        <div class="table-item pages"> <?= htmlspecialchars($pages) ?> </div>
        <div class="table-item date"> <?= htmlspecialchars($startedDate) ?> </div>
        <div class="table-item date"> <?= htmlspecialchars($finishedDate) ?></div>
        <div class="table-item ongoing"> <?= $ongoingChecked ?> </div>
        <?php if ($readHistory["rat"] == 1) {
            $mod1 = explode(",", $readHistory['mod1']);
            $mod2 = explode(",", $readHistory['mod2']);
            ?>

            <div class="table-item mod">
            <?php
            foreach ($mod1 as $key => $value1) {
                switch ($value1) {
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
                }?>
                    <p><?=htmlspecialchars($mod1)?></p>
            <?php }?>
            </div>
            <div class="table-item mod">
            <?php 
            foreach ($mod2 as $key => $value2) {
                switch ($value2) {
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
                }?>
                <p><?=htmlspecialchars($mod2)?></p>
            <?php } ?>
            </div>
        <?php } else {
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
            }?>
        <div class="table-item mod"> <?= $mod1 ?> </div>
        <div class="table-item mod"> <?= $mod2 ?> </div>
        <?php } ?>
        <div class="table-item points"> <?= htmlspecialchars($totalPoints) ?> </div>
        <div class="table-item comment"> <?= htmlspecialchars($comment) ?></div>
    </div>
    <!-- <div class="overflow-wrapper"> -->
        <div class="notch-wrapper" id="notchWrapper">
            <?php if (isset($readHistory['tags'])) { ?>
                <?php foreach ($tags as $key => $value) { 
                    $tagName = str_replace('_', ' ', $value);//removes underscore from visible part of tag?>
                    <div class="notch-arrow" id="<?= htmlspecialchars($value) ?>">
                        <p class='tag-content' id='tagContent'><?= htmlspecialchars($tagName) ?></p>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    <!-- </div> -->
<?php }} else { ?>
    <div class="not-found">No Reading History Found</div>       
<?php } ?>