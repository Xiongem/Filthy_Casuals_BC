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

 $sql = "SELECT * FROM users WHERE user_id = $userID";
        $result = $_SESSION["conn"]->query($sql);
        $user = $result->fetch_assoc();
            $admin = $user['admin'];
            $timezone = $user["timezone"];

    //* Set the user's timezone
    if ($timezone) {
        $_SESSION["timezone"] = $timezone;
        date_default_timezone_set("$timezone");
    }

$sql2 = "SELECT * FROM `bingoNames` WHERE `active` = 1";
$result2 = $_SESSION["conn"]->query($sql2);
    $bingo2 = $result2->fetch_assoc();
    if ($bingo2) {
        $active = $bingo2["active"];
        $activeName = $bingo2["bingo_name"];
    } else {
        $active = 0;
    }

$today = date("Y-m-d");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="Filthy Casual Book Challenge"> 
    <meta property="og:description" content="A competition for filthy casuals."> 
    <meta property="og:image" content=""> 
    <meta property="og:url" content="">
    <title>Update Reading History</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/update.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <script type="text/javascript" src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="javascript/ajax_tags.js"> </script>
</head>
<body>
    <header>
        <?= makeNav() ?>
    </header>
    <div class="update-wrapper">
        <div class="update-content">
            <div class="title-wrapper">
                <h1>Update Your Reading History</h1>
            </div>
            <!-- <div class="instructions">
                <span class="required">* </span><span>= required</span>
            </div> -->
            <form action="php/process-update.php" method="post">
                <div class="label-wrapper">
                    <label for="title" class="labels">Title:</label>
                    <span class="required">*</span>
                </div>
                <input type="text"
                    name="title"
                    id="title"
                    class="inputs"
                    required>

                <div class="label-wrapper">
                    <label for="author" class="labels">Author:</label>
                    <span class="required">*</span>
                </div>
                <input type="text"
                    name="author"
                    id="author"
                    class="inputs"
                    required>

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

                <div class="notch-wrapper" id="notchWrapper"></div>
                <input type="hidden" name="test" id="test" value="67">

                <div class="box-wrapper">
                    <label for="diffDate" class="labels">Click if your finish date is not today:</label>
                    <input type="checkbox"
                        name="diffDate"
                        id="diffDate"
                        class="checkbox"
                        onclick="showDateFinished();">
                </div>

                <div class="hidden-wrapper">
                    <div id="dateFinishedWrapper" class="hide">
                        <label for="dateFinished" class="labels">Date Finished:</label>
                        <input type="date"
                            name="dateFinished"
                            id="dateFinished"
                            class="inputs dates"
                            value="<?=$today?>"
                            required>
                    </div>
                </div>

                <div class="box-wrapper">
                    <label for="startDate" class="labels">Set start date:</label>
                    <input type="checkbox"
                        name="startDate"
                        id="startDate"
                        class="checkbox"
                        onclick="showDateStarted();">
                </div>

                <div class="hidden-wrapper">
                    <div id="dateStartedWrapper" class="hide">
                        <label for="dateStarted" class="labels">Date Started:</label>
                        <input type="date"
                            name="dateStarted"
                            id="dateStarted"
                            class="inputs dates">
                    </div>
                </div>

                <div class="box-wrapper" id="fanficWrapper">
                    <label for="fanfic" class="labels">Fanfiction?</label>
                    <input type="checkbox"
                            name="fanfic"
                            id="fanfic"
                            class="checkbox" 
                            onclick="showFanfic();">
                </div>


                <div class="page-wrapper">
                    <div class="label-wrapper">
                        <label for="pages" class="labels" id="fanficResult">Number of Pages:</label>
                        <span class="required">*</span>
                    </div>
                    <div id="pageWrapper">
                        <div id="showFanficWarn"></div>
                        <input type="text"
                            name="pages"
                            id="pages"
                            class="inputs"
                            pattern="^\d+(,\d+)?$"
                            required>
                        <div id="fanficMathResult"></div>
                    </div>
                </div>

                <div class="box-wrapper" id="ongoingWrapper">
                    <label for="ongoing" class="labels">Ongoing:</label>
                    <input type="checkbox"
                        name="ongoing"
                        id="ongoing"
                        class="checkbox">
                </div>

                <div class="mod-wrapper">
                    <div id="mod1-wrapper" class="mod-content">
                        <label for="mod-1" class="labels">Modifier 1:</label>
                        <select name="mod-1" id="mod-1" class="inputs" onchange="check()">
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
                        <select name="mod-2" id="mod-2" class="inputs" onchange="check()">
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

                <div class="bingo-wrapper hide" id="bingo">
                    <div class="label-wrapper" id="bingoCheckbox">
                        <label class="labels">Counts towards bingo?</label>
                        <input type="checkbox"
                                name="bingoName"
                                id="bingo"
                                class="checkbox" value="<?=$activeName?>"> 
                    </div>
                </div>

                <label for="comment" class="labels">Comment:</label>
                <textarea name="comment" id="comment" class="inputs" placeholder="(Optional)"></textarea>

                <div class="button-wrapper">
                    <button type="submit" id="updateButton" class="inputs buttons">Update</button>
                </div>

            </form>
        </div>

        <script>
            function check() {
                var active = <?=$active?>;
                if (active == 1) {
                    var mod1 = $("#mod-1").val();
                    var mod2 = $("#mod-2").val();

                    if (mod1 == "3" || mod1 == "4" || mod2 == "2") {
                        $("#bingo").css("display", "flex");                                  
                    }else {
                        $("#bingo").hide();                    
                    }
                }
            }

            function showDateFinished() {
                document.getElementById('dateFinishedWrapper').classList.toggle("hide");
            }
            function showDateStarted() {
                document.getElementById('dateStartedWrapper').classList.toggle("hide");
            }            

            function showFanfic() {
                if ($('#fanfic').is(':checked')) {
                    $("#showFanficWarn").html("Input WORD COUNT");
                    $("#fanficResult").text("Number of WORDS:");

                    function fanficMath() {
                        var pages = $("#pages").val();
                        pages = pages.replace(/,/g, "");
                        if (pages > 0) {
                            var newPages = Math.round(pages / 280);
                            if (newPages < 1) {
                                newPages = 1;
                                return newPages;
                            } else {
                                return newPages;
                            }
                        }
                    }

                    var typingTimer;                //timer identifier
                    var doneTypingInterval = 500;  //time in ms, 1 seconds for example
                    var $input = $('#pages');

                    //on keyup, start the countdown
                    $input.on('keyup', function () {
                        clearTimeout(typingTimer);
                        typingTimer = setTimeout(doneTyping, doneTypingInterval);
                    });

                    //on keydown, clear the countdown 
                    $input.on('keydown', function () {
                        clearTimeout(typingTimer);
                    });

                    //user is "finished typing," do something
                    function doneTyping () {
                        var total = fanficMath();
                        $('#fanficMathResult').css("display", "flex");
                        $('#fanficMathResult').text("Pages: " + total);
                    }
                } else {
                    $("#showFanficWarn").html("");
                    $("#fanficResult").text("Number of Pages:");
                    $('#fanficMathResult').css("display", "none");
                }
            }
        </script>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>