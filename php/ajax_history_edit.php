<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

//assign POST data from ajax to variables
$readID = $_POST['read_ID'];
$ID = $_POST['user_ID'];

//pull data from database for the chosen entry and assign required variables
$sql = "SELECT * FROM `readHistory` WHERE `user_id` = $ID  AND read_ID = $readID";
    $result = $_SESSION["conn"]->query($sql);
    $read = $result->fetch_assoc();
        $title = $read["title"];
        $author = $read["author"];
        $dateFinished = $read["finishedDate"];
        $pages = $read["pages"];
        $ongoing = $read["ongoing"];
        $mod1 = $read["mod1"];
        $mod2 = $read["mod2"];

//set variables for columns that can be NULL in the db
if (isset($read["startedDate"])) {
    $startedDate = $read["startedDate"];
} else {
    $startedDate = "";
}

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
?>


<h1>Edit an Entry</h1>
<form action="php/process-editEntry.php" method="post">
    <!-- assigns entry id to input field -->
    <input type="hidden" name="read_ID" id="<?=$readID?>" value="<?=$readID?>">

    <!--//? TITLE -->
    <div class="label-wrapper">
        <label for="title" class="labels">Title:</label>
        <span class="required">*</span>
    </div>
    <input type="text"
        name="title"
        id="title"
        class="inputs"
        value="<?=$title?>"
        required>

    <!--//? AUTHOR -->
    <div class="label-wrapper">
        <label for="author" class="labels">Author:</label>
        <span class="required">*</span>
    </div>
    <input type="text"
        name="author"
        id="author"
        class="inputs"
        value="<?=$author?>"
        required>

    <!--//? TAGS -->
    <div class="tag-wrapper">
        <div class="search-tag-wrapper">
            <div class="tag">
                <label for="keyword0" class="labels">Tags:</label>
                <input type="text" 
                    name="keyword0" 
                    id="tags_id0" 
                    class="tags" 
                    onkeyup="autocomplet0()"
                    onkeypress="clickPress(event)">
            </div>
                <ion-icon name="add-circle" size="large" id="enter-circle" aria-label="add" onclick="createTag()"></ion-icon>
        </div>
        <div id="search_results0" class="search-wrapper"></div>
    </div>

    <!--//? SHOWS ASSIGNED TAGS AND ASSIGNS EACH TO AN INPUT FIELD -->
    <div class="notch-wrapper" id="notchWrapper">
        <?php if (isset($tags_array)) { 
            foreach ($tags_array as $key => $tag_name) {?>
                <div class="notch-arrow" id="<?=$tag_name?>" onclick="removeTag(<?=$tag_name?>)">
                    <p class='tag-content' id='tagContent'><?=$tag_name?></p>
                    <input type="hidden" name="tag[<?=$tag_name?>]" id="tag_<?=$tag_name?>" value="<?=$tag_name?>">
                </div>
        <?php }} ?>
    </div>

    <!--//? FINISHED DATE -->
    <label for="dateFinished" class="labels">Date Finished:</label>
    <input type="date"
        name="dateFinished"
        id="dateFinished"
        class="inputs dates"
        value="<?=$dateFinished?>"
        required>

    <!--//? DATE STARTED -->
    <label for="dateStarted" class="labels">Date Started:</label>
    <input type="date"
        name="dateStarted"
        id="dateStarted"
        class="inputs dates"
        value="<?=$startedDate?>">

    <!--//? NUMBER OF PAGES READ -->
    <div class="page-wrapper">
        <div class="label-wrapper">
            <label for="pages" class="labels">Number of Pages:</label>
            <span class="required">*</span>
        </div>
        <input type="number"
            name="pages"
            id="pages"
            class="inputs"
            value="<?=$pages?>"
            required>
    </div>

    <!--//? ONGOING CHECKBOX -->
    <div class="box-wrapper" id="ongoingWrapper">
        <label for="ongoing" class="labels">Ongoing:</label>
        <input type="checkbox"
            name="ongoing"
            id="ongoing"
            class="checkbox"
            <?php if($read['ongoing']==1){ ?>checked="checked"<?php } ?>>
    </div>

    <!--//? 1ST MODIFIER SELECTOR -->
    <div class="mod-wrapper">
        <div id="mod1-wrapper" class="mod-content">
            <label for="mod-1" class="labels">Modifier 1:</label>
            <select name="mod-1" id="mod-1" class="inputs">
                <option value="1" <?php if($read['mod1']==1){ ?>selected="selected"<?php } ?>>Normal</option>
                <option value="2" <?php if($read['mod1']==2){ ?>selected="selected"<?php } ?>>Manga/Comic</option>
                <option value="3" <?php if($read['mod1']==3){ ?>selected="selected"<?php } ?>>Challenge</option>
                <option value="4" <?php if($read['mod1']==4){ ?>selected="selected"<?php } ?>>Challenge: Manga/Comics</option>
                <option value="5" <?php if($read['mod1']==5){ ?>selected="selected"<?php } ?>>Buddy Read</option>
                <option value="6" <?php if($read['mod1']==6){ ?>selected="selected"<?php } ?>>Friend Recommendation</option>
                <option value="7" <?php if($read['mod1']==7){ ?>selected="selected"<?php } ?>>Seasonal</option>
                <option value="8" <?php if($read['mod1']==8){ ?>selected="selected"<?php } ?>>Read-a-thon</option>
                <option value="9" <?php if($read['mod1']==9){ ?>selected="selected"<?php } ?>>Educational</option>
                <option value="10" <?php if($read['mod1']==10){ ?>selected="selected"<?php } ?>>Educational: Manga/Comics</option>
            </select>
        </div>

        <!--//? 2ND MODIFIER SELECTOR -->
        <div id="mod2-wrapper" class="mod-content">
            <label for="mod-2" class="labels">Modifier 2:</label>
            <select name="mod-2" id="mod-2" class="inputs">
                <option value="1" <?php if($read['mod2']==1){ ?>selected="selected"<?php } ?>>Normal</option>
                <option value="2" <?php if($read['mod2']==2){ ?>selected="selected"<?php } ?>>Challenge</option>
                <option value="3" <?php if($read['mod2']==3){ ?>selected="selected"<?php } ?>>Buddy Read</option>
                <option value="4" <?php if($read['mod2']==4){ ?>selected="selected"<?php } ?>>Friend Recommendation</option>
                <option value="5" <?php if($read['mod2']==5){ ?>selected="selected"<?php } ?>>Seasonal</option>
                <option value="6" <?php if($read['mod2']==6){ ?>selected="selected"<?php } ?>>Read-a-thon</option>
                <option value="7" <?php if($read['mod2']==7){ ?>selected="selected"<?php } ?>>Educational</option>
                <option value="8" <?php if($read['mod2']==8){ ?>selected="selected"<?php } ?>>Educational: Manga/Comics</option>
            </select>
        </div>
    </div>

    <!--//? COMMENTS -->
    <label for="comment" class="labels">Comment:</label>
    <textarea name="comment" id="comment" class="inputs" placeholder="(Optional)"><?=$comment?></textarea>

    <!--//? SUMBIT BUTTON -->
    <div class="button-wrapper">
        <button type="submit" id="updateButton" class="inputs buttons">Update</button>
    </div>
</form>