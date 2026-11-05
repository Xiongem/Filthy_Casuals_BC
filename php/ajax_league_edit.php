<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$league = $_POST['leagueName'];

?>

<div class="title">
    <h2>Change Users' Leagues</h2>
</div>
<div class="userList-container">
    <?php $sql = $_SESSION["conn"]->query("SELECT * FROM `users` WHERE `league` = '$league'");
    $row = mysqli_num_rows($sql);
    if($row>0) {
        while ($leagueName = mysqli_fetch_array($sql)) {
            $userID = $leagueName["user_id"];
            $username = $leagueName["username"];
            $imageName = htmlspecialchars($leagueName['pfpName']);
            $imageType = $leagueName['pfpType'];
            $imageData = base64_encode($leagueName['pfpData']);
    ?>
        <div class="userList">
            <div class="userInfo">
                <img class="userList-pfp" src="data:<?=$imageType?>;base64,<?=$imageData?>" alt="<?=$imageName?>">
                <div class="userList-username"><?=$username?></div>
            </div>
            <div class="userList-league">
                <select class="inputs" name="league" id="league" onchange="changeLeague(<?=$userID?>, this.value)">
                    <option value="Gorogoro" <?php if ($league == "Gorogoro") { ?>selected="selected"<?php } ?>>Gorogoro</option>
                    <option value="Futsuu" <?php if ($league == "Futsuu") { ?>selected="selected"<?php } ?>>Futsuu</option>
                    <option value="Hayai" <?php if ($league == "Hayai") { ?>selected="selected"<?php } ?>>Hayai</option>
                    <option value="Yabai" <?php if ($league == "Yabai") { ?>selected="selected"<?php } ?>>Yabai</option>
                </select>
            </div>
        </div>
    <?php }} ?>
</div>

<script>
    function changeLeague(userID, newLeague) {
        $.ajax({
            url: 'php/process-leagueEdit.php',
            type: 'POST',
            data: { user_ID: userID, leagueName: newLeague },
            success: function(response) {
                console.log('League updated successfully');
            },
            error: function(xhr, status, error) {
                console.error('Error updating league:', error);
            }
        });
    }
</script>
