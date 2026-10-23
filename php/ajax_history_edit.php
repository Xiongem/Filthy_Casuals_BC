<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$readID = $_POST['read_ID'];
$ID = $_POST['userID'];

$sql = "SELECT * FROM `readHistory` WHERE `user_id` = ?  AND read_ID = ?";
    $stmt = $_SESSION["conn"]->prepare($sql);
        $stmt->bind_param("ii",
                                $ID,
                                $readID);

if ($stmt -> execute()) {
        $result = $_SESSION["conn"]->query($sql);
        $user = $result->fetch_assoc();
            $title = $read["username"];
            $author = $read["author"];
            $dateFinished = $read["finishedDate"];
            $startedDate = $read["startedDate"];
            $pages = $read["pages"];
            $ongoing = $read["ongoing"];
            $mod1 = $read["mod1"];
            $mod2 = $read["mod2"];
            $tags = $read["tags"];
            $comment = $read["comment"];
} else {
    echo "something went wrong";
}
?>


<h1>Edit an Entry</h1>
<form action="php/process-editEntry.php" method="post">
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

<div class="tag-wrapper">
    <label for="keyword0" class="labels">Tags:</label>
    <input type="text" 
        name="keyword0" 
        id="tags_id0" 
        class="inputs" 
        onkeyup="autocomplet0()"
        onkeypress="clickPress(event)">

        <!-- //?ADD BUTTON TO ALLOW PEEPS TO ADD NEW TAGS WITHOUT NEEDING ENTER KEY -->

    <a id="search_results0" class="searchResult" onclick="setTag()"></a>
</div>

<div class="notch-wrapper" id="notchWrapper"></div>

        <label for="dateFinished" class="labels">Date Finished:</label>
        <input type="date"
            name="dateFinished"
            id="dateFinished"
            class="inputs dates"
            value="<?=$dateFinished?>"
            required>

<label for="dateStarted" class="labels">Date Started:</label>
<input type="date"
    name="dateStarted"
    id="dateStarted"
    class="inputs dates"
    value="<?=$startedDate?>">

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

<div class="box-wrapper" id="ongoingWrapper">
    <label for="ongoing" class="labels">Ongoing:</label>
    <input type="checkbox"
        name="ongoing"
        id="ongoing"
        class="checkbox"
        value="<?=$ongoing?>">
</div>

<div class="mod-wrapper">
    <div id="mod1-wrapper" class="mod-content">
        <label for="mod-1" class="labels">Modifier 1:</label>
        <select name="mod-1" id="mod-1" class="inputs" value="<?=$mod1?>">
            <option value="1">Normal</option>
            <option value="2">Manga/Comic</option>
            <option value="3">Challenge</option>
            <option value="4">Challenge: Manga/Comics</option>
            <option value="5">Buddy Read</option>
            <option value="6">Friend Recommendation</option>
            <option value="7">Seasonal</option>
            <option value="8">Read-a-thon</option>
            <option value="9">Educational</option>
            <option value="10">Educational: Manga/Comics</option>
        </select>
    </div>

    <div id="mod2-wrapper" class="mod-content">
        <label for="mod-2" class="labels">Modifier 2:</label>
        <select name="mod-2" id="mod-2" class="inputs" value="<?=$mod2?>">
            <option value="1">Normal</option>
            <option value="2">Challenge</option>
            <option value="3">Buddy Read</option>
            <option value="4">Friend Recommendation</option>
            <option value="5">Seasonal</option>
            <option value="6">Read-a-thon</option>
            <option value="7">Educational</option>
            <option value="8">Educational: Manga/Comics</option>
        </select>
    </div>
</div>

<label for="comment" class="labels">Comment:</label>
<textarea name="comment" id="comment" class="inputs" placeholder="(Optional)"><?=$comment?></textarea>

<div class="button-wrapper">
    <button type="submit" id="updateButton" class="inputs buttons">Update</button>
</div>

</form>

<script>
function showDateFinished() {
    document.getElementById('dateFinishedWrapper').classList.toggle("hide");
}
function showDateStarted() {
    document.getElementById('dateStartedWrapper').classList.toggle("hide");
}
</script>