<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();
forceLogin();

//assign POST data from ajax to variables
$readID = $_GET['read_ID'];
$ID = $_GET['user_ID'];

//pull data from database for the chosen entry and assign required variables
$sql = "SELECT * FROM `readHistory` WHERE `user_id` = $ID  AND read_ID = $readID";
    $result = $_SESSION["conn"]->query($sql);
    $read = $result->fetch_assoc();
        $title = $read["title"];
        $author = $read["author"];
        $dateFinished = $read["finishedDate"];
        $pages = $read["pages"];
        $pagesOut = $read["pagesOut"];
        $pagesIn = $read["pagesIn"];
        $ongoing = $read["ongoing"];
        // list($mod1Out, $mod1In) = explode(",", $read["mod1"]);
        // list($mod2Out, $mod2In) = explode(",", $read["mod2"]);
        $fanfic = $read["fanfic"];
        $words = $read["words"];

$sql2 = "SELECT * FROM `bingoNames` WHERE `active` = 1";
$result2 = $_SESSION["conn"]->query($sql2);
    $bingo2 = $result2->fetch_assoc();
    if ($bingo2) {
        $active = $bingo2["active"];
        $activeName = $bingo2["bingo_name"];
    } else {
        $active = 0;
        $activeName = NULL;
    }

//set variables for columns that can be NULL in the db
if (isset($read["startedDate"])) {
    $startedDate = $read["startedDate"];
} else {
    $startedDate = "";
}

$dateFinished = strtotime($dateFinished);
$dateFinished = date("Y-m-d", $dateFinished);

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

if ($fanfic ==1) {
    if ($words) {
        $pages = $words;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="Filthy Casual Book Challenge"> 
    <meta property="og:description" content="A readHistory for filthy casuals."> 
    <meta property="og:image" content="https://filthycasualsbc.com/images/FCBClogo.svg"> 
    <meta property="og:url" content="https://filthycasualsbc.com/readHistory.php">
    <title>Reading History Edit</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/readHistory.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="javascript/ajax_tags.js"> </script>
</head>
<body id="body">
    <div class="popup-wrapper-history" id="editPopup">
        <div class="popup-container">
            <div class="close-wrapper">
                <ion-icon size="large" name="close" onclick="goBack()"></ion-icon>
            </div>
        <h1>Edit an Entry</h1>
        <form class="edit-form" action="php/process-editEntry.php" method="post" onkeydown="if(event.keyCode === 13) {
                                                                return false;}">
            <!-- assigns entry id to input field -->
            <input type="hidden" name="read_ID" id="<?=$readID?>" value="<?=$readID?>">
            <input type="hidden" name="user_ID" id="<?=$ID?>" value="<?=$ID?>">

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
                        <label for="keyword0" class="labels">Tags: <span id="help"><ion-icon name="help-circle"></ion-icon>
                            <div class="help-popup" id="helpPop">
                                <div class="help-content">
                                    <p>
                                            Type into the search field to see already created tags. Type in and press the 
                                            <ion-icon name="add-circle"></ion-icon> icon to create a new tag. Click the
                                            tag to delete it.
                                    </p>
                                </div>
                            </div>
                        </span></label>
                        <input type="text" 
                            name="keyword0" 
                            id="tags_id0" 
                            class="tags" 
                            maxlength="30"
                            onkeyup="autocomplet0()"
                            onkeypress="clickPress(event)">
                    </div>
                        <ion-icon name="add-circle" size="large" id="enter-circle" aria-label="add" onclick="createTag()"></ion-icon>
                </div>
                <div id="search_results0" class="search-wrapper"></div>
                <div id="error" class="error"></div>
            </div>

            <!--//? SHOWS ASSIGNED TAGS AND ASSIGNS EACH TO AN INPUT FIELD -->
            <div class="edit-notch-wrapper" id="notchWrapper">
                <?php if (isset($tags_array)) { 
                    foreach ($tags_array as $key => $tag_name) {
                        $newTag = str_replace('_', ' ', $tag_name);//removes underscore from visible part of tag?>
                        <div class="notch-arrow" id="<?=$tag_name?>" onclick="removeTag(<?=$tag_name?>)">
                            <p class='tag-content' id='tagContent'><?=$newTag?></p>
                            <input type="hidden" name="tag[<?=$tag_name?>]" id="tag_<?=$tag_name?>" value="<?=$tag_name?>">
                        </div>
                <?php }} ?>
            </div>

            <div class="dates-wrapper">
                <div class="date-content">
                    <!--//? FINISHED DATE -->
                    <label for="dateFinished" class="labels">Date Finished:</label>
                    <input type="date"
                        name="dateFinished"
                        id="dateFinished"
                        class="inputs dates"
                        value="<?=$dateFinished?>"
                        required>
                </div>

                <div class="date-content">
                    <!--//? DATE STARTED -->
                    <label for="dateStarted" class="labels">Date Started:</label>
                    <input type="date"
                        name="dateStarted"
                        id="dateStarted"
                        class="inputs dates"
                        value="<?=$startedDate?>">
                </div>
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

            <!-- //? FANFIC -->
            <div class="box-wrapper" id="fanficWrapper">
                <label for="fanfic" class="labels">Fanfiction?</label>
                <input type="checkbox"
                        name="fanfic"
                        id="fanfic"
                        class="checkbox" 
                        <?php if($fanfic==1){?>checked="checked"<?php } ?>
                        onclick="showFanfic();">
            </div>

            <!--//? NUMBER OF PAGES READ OUTSIDE RAT-->
            <div class="spacing">
                <div class="page-wrapper-rat">
                    <h2>Read OUTSIDE read-a-thon:</h2>
                    <div class="label-wrapper">
                        <label for="pages" class="labels" id="fanficResultOut">Number of Pages:</label>
                        <span class="required">*</span>
                    </div>
                    <div id="pageWrapperRat">
                        <div id="showFanficWarnOut"></div>
                        <input type="text"
                            name="pagesOut"
                            id="pagesOut"
                            class="inputs"
                            pattern="^\d+(,\d+)?$"
                            value="<?=$pagesOut?>"
                            maxlength="10"
                            onkeyup="check()"
                            required>
                        <div id="fanficMathResultOut"></div>
                    </div>
                </div>
            </div>

            <div class="spacing">
                <h3>Modifiers for pages read OUTSIDE read-a-thon</h3>
                <!--//? 1ST MODIFIER SELECTOR -->
                <div class="mod-wrapper">
                    <div id="mod1-wrapper" class="mod-content">
                        <label for="mod-1-Out" class="labels">Modifier 1:</label>
                        <select name="mod-1-Out" id="mod-1-Out" class="inputs" onchange="check()">
                            <option value="1" <?php if($mod1Out==1){ ?>selected="selected"<?php } ?>>Normal</option>
                            <option value="2" <?php if($mod1Out==2){ ?>selected="selected"<?php } ?>>Manga/Comic</option>
                            <option value="3" <?php if($mod1Out==3){ ?>selected="selected"<?php } ?>>Challenge</option>
                            <option value="4" <?php if($mod1Out==4){ ?>selected="selected"<?php } ?>>Challenge: Manga/Comics</option>
                            <option value="5" <?php if($mod1Out==5){ ?>selected="selected"<?php } ?>>Buddy Read</option>
                            <option value="6" <?php if($mod1Out==6){ ?>selected="selected"<?php } ?>>Friend Recommendation</option>
                            <option value="7" <?php if($mod1Out==7){ ?>selected="selected"<?php } ?>>Seasonal</option>
                            <option value="9" <?php if($mod1Out==9){ ?>selected="selected"<?php } ?>>Educational</option>
                            <option value="10" <?php if($mod1Out==10){ ?>selected="selected"<?php } ?>>Educational: Manga/Comics</option>
                        </select>
                    </div>

                    <!--//? 2ND MODIFIER SELECTOR -->
                    <div id="mod2-wrapper" class="mod-content">
                        <label for="mod-2-Out" class="labels">Modifier 2:</label>
                        <select name="mod-2-Out" id="mod-2-Out" class="inputs" onchange="check()">
                            <option value="1" <?php if($mod2Out==1){ ?>selected="selected"<?php } ?>>Normal</option>
                            <option value="2" <?php if($mod2Out==2){ ?>selected="selected"<?php } ?>>Challenge</option>
                            <option value="3" <?php if($mod2Out==3){ ?>selected="selected"<?php } ?>>Buddy Read</option>
                            <option value="4" <?php if($mod2Out==4){ ?>selected="selected"<?php } ?>>Friend Recommendation</option>
                            <option value="5" <?php if($mod2Out==5){ ?>selected="selected"<?php } ?>>Seasonal</option>
                            <option value="7" <?php if($mod2Out==7){ ?>selected="selected"<?php } ?>>Educational</option>
                            <option value="8" <?php if($mod2Out==8){ ?>selected="selected"<?php } ?>>Educational: Manga/Comics</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="spacing">
                <div class="page-wrapper-rat">
                    <h2>Read DURING read-a-thon:</h2>
                    <div class="label-wrapper">
                        <label for="pages" class="labels" id="fanficResultIn">Number of Pages:</label>
                        <span class="required">*</span>
                    </div>
                    <div id="pageWrapperRat">
                        <div id="showFanficWarnIn"></div>
                        <input type="text"
                            name="pagesIn"
                            id="pagesIn"
                            class="inputs"
                            pattern="^\d+(,\d+)?$"
                            value="<?=$pagesIn?>"
                            maxlength="10"
                            onkeyup="check()"
                            required>
                        <div id="fanficMathResultIn"></div>
                    </div>
                </div>
            </div>

            <div class="spacing">
                <h3>Modifiers for pages read DURING read-a-thon</h3>
                <!--//? 1ST MODIFIER SELECTOR -->
                <div class="mod-wrapper">
                    <div id="mod1-wrapper" class="mod-content">
                        <label for="mod-1-In" class="labels">Modifier 1:</label>
                        <select name="mod-1-In" id="mod-1-In" class="inputs" onchange="check()">
                            <option value="8">Read-a-thon</option>
                        </select>
                    </div>

                    <!--//? 2ND MODIFIER SELECTOR -->
                    <div id="mod2-wrapper" class="mod-content">
                        <label for="mod-2-In" class="labels">Modifier 2:</label>
                        <select name="mod-2-In" id="mod-2-In" class="inputs" onchange="check()">
                            <option value="1" <?php if($mod2In==1==1){ ?>selected="selected"<?php } ?>>Normal</option>
                            <option value="2" <?php if($mod2In==1==2){ ?>selected="selected"<?php } ?>>Challenge</option>
                            <option value="3" <?php if($mod2In==1==3){ ?>selected="selected"<?php } ?>>Buddy Read</option>
                            <option value="4" <?php if($mod2In==1==4){ ?>selected="selected"<?php } ?>>Friend Recommendation</option>
                            <option value="5" <?php if($mod2In==1==5){ ?>selected="selected"<?php } ?>>Seasonal</option>
                            <option value="7" <?php if($mod2In==1==7){ ?>selected="selected"<?php } ?>>Educational</option>
                            <option value="8" <?php if($mod2In==1==8){ ?>selected="selected"<?php } ?>>Educational: Manga/Comics</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bingo-wrapper hide" id="bingo">
                <div class="label-wrapper" id="bingoCheckbox">
                    <label class="labels">Counts towards bingo?</label>
                    <input type="checkbox"
                            name="bingoName"
                            id="bingo"
                            class="checkbox" value="<?=$activeName?>"
                    <?php if($activeName !== NULL){?>checked="checked"<?php } ?>> 
                </div>
            </div>

            <!--//? COMMENTS -->
            <label for="comment" class="labels">Comment:</label>
            <textarea name="comment" id="comment" class="inputs" placeholder="(Optional)" maxlength="200"><?=$comment?></textarea>

            <!--//? SUMBIT BUTTON -->
            <div class="edit-button-wrapper">
                <a id="deleteButton" href="php/process-deleteEntry.php?read_ID=<?=$readID?>&user_ID=<?=$ID?>">Delete</a>
                <button type="submit" id="updateButton" class="buttons">Update</button>
            </div>
        </form>
        </div>
    </div>
    <script>
        $('#tags_id0').on('input', function() {
            var c = this.selectionStart,
                r = /[^a-z0-9_ ]/gi,
                v = $(this).val();
            if(r.test(v)) {
                $(this).val(v.replace(r, ''));
                c--;
            }
            this.setSelectionRange(c, c);
        });

        $("#tags_id0").blur(function() {
            setTimeout(hideSearch, 300)
        });
        function hideSearch() {
            $('#search_results0').html("");
            $('#search_results0').hide();
        }


        function clickPress(event) {
            if (event.key == "Enter") {
                var createTag = document.getElementById('tags_id0').value;
                $.ajax({
                    url: 'php/ajax_tags_creation.php',
                    type: 'POST',
                    data: {tag:createTag},
                    success:function(data){
                        $('#notchWrapper').append(data);

                        $('#search_results0').html("");
                        $('#search_results0').hide();
                        var keyword0 = document.getElementById('tags_id0');
                        keyword0.value = '';
                    }
                });
            }
        }

        function check() {
            var active = <?=$active?>;

            if ($('#fanfic').is(':checked')) {
                var fanfic = 1;
            }else {
                var fanfic = 0;
            }

            var mod1Out = $("#mod-1-Out").val();
            var mod2Out = $("#mod-2-Out").val();
            var mod2In = $("#mod-2-In").val();
            if (active == 1) {
                if (mod1Out == "3" || mod1Out == "4" || mod2Out == "2" ||  mod2In == "2") {
                    $("#bingo").css("display", "flex");                                  
                }else {
                    $("#bingo").hide();                    
                }
            }

            var pagesOut = $("#pagesOut").val();
            var pagesIn = $("#pagesIn").val();

            if (pagesOut && pagesIn) {
                $.ajax ({
                    url: "php/modMathRatEst.php",
                    method: "post",
                    data: {pagesOut:pagesOut,
                        mod1Out:mod1Out,
                        mod2Out:mod2Out,
                        pagesIn:pagesIn,
                        mod2In:mod2In,
                        fanfic:fanfic},
                    success:function(result) {
                        $("#modResults").html(result);
                    }
                })
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
                $("#showFanficWarnOut").html("Input WORD COUNT");
                $("#fanficResultOut").text("Number of WORDS:");
                $("#showFanficWarnIn").html("Input WORD COUNT");
                $("#fanficResultIn").text("Number of WORDS:");

                function fanficMath() {
                    var pagesOut = $("#pagesOut").val();
                    pagesOut = pagesOut.replace(/,/g, "");
                    if (pagesOut > 0) {
                        var newPagesOut = Math.round(pagesOut / 280);
                        if (newPagesOut < 1) {
                            newPagesOut = 1;
                            return newPagesOut;
                        } else {
                            return newPagesOut;
                        }
                    }

                    var pagesIn = $("#pagesIn").val();
                    pagesIn = pagesIn.replace(/,/g, "");
                    if (pagesIn > 0) {
                        var newPagesIn = Math.round(pagesIn / 280);
                        if (newPagesIn < 1) {
                            newPagesIn = 1;
                            return newPagesIn;
                        } else {
                            return newPagesIn;
                        }
                    }
                }

                var typingTimer1;
                var typingTimer2;                 //timer identifier
                var doneTypingInterval1 = 500;
                var doneTypingInterval2 = 500;  //time in ms, 1 seconds for example
                var $input1 = $('#pagesOut');
                var $input2 = $('#pagesIn');

                //on keyup, start the countdown
                $input1.on('keyup', function () {
                    if ($('#fanfic').is(':checked')) {
                        clearTimeout(typingTimer1);
                        typingTimer1 = setTimeout(doneTypingOut, doneTypingInterval1);
                    }
                });

                //on keydown, clear the countdown 
                $input1.on('keydown', function () {
                    if ($('#fanfic').is(':checked')) {
                        clearTimeout(typingTimer1);
                    }
                });

                //user is "finished typing," do something
                function doneTypingOut () {
                    var total = fanficMath();
                    $('#fanficMathResultOut').text("Pages: " + total);
                }

                //*--------------------------------------------------

                //on keyup, start the countdown
                $input2.on('keyup', function () {
                    if ($('#fanfic').is(':checked')) {
                        clearTimeout(typingTimer2);
                        typingTimer2 = setTimeout(doneTypingIn, doneTypingInterval2);
                    }
                });

                //on keydown, clear the countdown 
                $input2.on('keydown', function () {
                    if ($('#fanfic').is(':checked')) {
                        clearTimeout(typingTimer2);
                    }
                });

                //user is "finished typing," do something
                function doneTypingIn () {
                    var total = fanficMath();
                    $('#fanficMathResultIn').text("Pages: " + total);
                }
            } else {
                $("#showFanficWarnOut").html("");
                $("#fanficResultOut").text("Number of Pages:");
                $('#fanficMathResultOut').text("")

                $("#showFanficWarnIn").html("");
                $("#fanficResultIn").text("Number of Pages:");
                $('#fanficMathResultIn').text("")
            }
        }

        function showModHelp() {
            $("#modHelpPopup").css({"display": "flex"});
            var modHelpPopup = document.getElementById("modHelpPopup");
            modHelpPopup.scrollIntoView();
            setTimeout(hideBackground, 500);
        }
        function closeModHelp() {
            $("#modHelpPopup").hide();
            $("#body").css({"height": "unset", "overflow": "unset"});
        }
    </script>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>