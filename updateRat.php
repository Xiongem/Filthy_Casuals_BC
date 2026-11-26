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
    <meta property="og:image" content="https://filthycasualsbc.com/images/FCBClogo.svg"> 
    <meta property="og:url" content="https://filthycasualsbc.com/update.php">
    <title>Update Reading History</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/update.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <script type="text/javascript" src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="javascript/ajax_tags.js"> </script>
</head>
<body id="body">
    <div class="popup-wrapper hide" id="modHelpPopup">
        <div class="popup-container">
            <div class="close-wrapper">
                <ion-icon name="close" onclick="closeModHelp()"></ion-icon>
            </div>
            <div class="popup-content">
                <div class="title-wrapper">
                    <h1>Reading Modifier Guide:</h1>
                </div>
                <div class="help-grid">
                    <div class="grid-item modName">Normal:</div>
                    <div class="grid-item descript">Regular novels, fanfiction, poems</div>
                    <div class="grid-item modName">Manga/ Comics:</div>
                    <div class="grid-item descript">Things with more picture than words such as webtoons, comics, graphic novels</div>
                    <div class="grid-item modName">Challenge:</div>
                    <div class="grid-item descript">Counts towards the monthly <a href="https://filthycasualsbc.com/challenges.php">challenge</a></div>
                    <div class="grid-item modName">Buddy Read:</div>
                    <div class="grid-item descript">Read something together with another participant and discussed</div>
                    <div class="grid-item modName">Friend Recommendation:</div>
                    <div class="grid-item descript">Read something recommended in <a href="https://filthycasualsbc.com/friendRec.php">Friend Recs</a></div>
                    <div class="grid-item modName">Seasonal:</div>
                    <div class="grid-item descript">Read something that fits the current season. See <a href="https://filthycasualsbc.com/challenges.php">challenge</a> for more info</div>
                    <div class="grid-item modName">Read-a-thon:</div>
                    <div class="grid-item descript">Something read while the monthly read-a-thon is ongoing</div>
                    <div class="grid-item modName">Educational:</div>
                    <div class="grid-item descript">Read something academic based like research papers, or written in a foreign language</div>
                </div>
            </div>
        </div>
    </div>
    <header>
        <?= makeNav() ?>
    </header>
    <div class="update-wrapper">
        <div class="update-content">
            <div class="title-wrapper">
                <h1>Update Your Reading History</h1>
            </div>
            <form action="php/process-updateRat.php" method="post" id="updateForm" onkeydown="if(event.keyCode === 13) {
                                                        return false;}">
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

                <!--//! ADD TAG EXPLANATION -->

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

                <div class="notch-wrapper" id="notchWrapper"></div>

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

                <div class="box-wrapper" id="ongoingWrapper">
                    <label for="ongoing" class="labels">Ongoing:</label>
                    <input type="checkbox"
                        name="ongoing"
                        id="ongoing"
                        class="checkbox">
                </div>

                <div class="box-wrapper" id="fanficWrapper">
                    <label for="fanfic" class="labels">Fanfiction?</label>
                    <input type="checkbox"
                            name="fanfic"
                            id="fanfic"
                            class="checkbox" 
                            onclick="showFanfic();">
                </div>

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
                                maxlength="10"
                                required>
                            <div id="fanficMathResultOut"></div>
                        </div>
                    </div>
                </div>

                <div class="spacing">
                    <h3>Modifiers for pages read OUTSIDE read-a-thon</h3>
                    <div class="mod-wrapper">
                        <div id="mod1-wrapper" class="mod-content">
                            <label for="mod-1-Out" class="labels">Modifier 1:</label>
                            <select name="mod-1-Out" id="mod-1-Out" class="inputs" onchange="check()">
                                <option value="1">Normal</option>
                                <option value="2">Manga/Comic</option>
                                <option value="3">Challenge</option>
                                <option value="4">Challenge: Manga/Comics</option>
                                <option value="5">Buddy Read</option>
                                <option value="6">Friend Recommendation</option>
                                <option value="7">Seasonal</option>
                                <option value="9">Educational</option>
                                <option value="10">Educational: Manga/Comics</option>
                            </select>
                        </div>

                        <div id="mod2-wrapper" class="mod-content">
                            <label for="mod-2-Out" class="labels">Modifier 2:</label>
                            <select name="mod-2-Out" id="mod-2-Out" class="inputs" onchange="check()">
                                <option value="1">Normal</option>
                                <option value="2">Challenge</option>
                                <option value="3">Buddy Read</option>
                                <option value="4">Friend Recommendation</option>
                                <option value="5">Seasonal</option>
                                <option value="7">Educational</option>
                                <option value="8">Educational: Manga/Comics</option>
                            </select>
                        </div>
                        <ion-icon class="modHelp" name="help-circle" onclick="showModHelp()"></ion-icon>
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
                                maxlength="10"
                                required>
                            <div id="fanficMathResultIn"></div>
                        </div>
                    </div>
                </div>

                <div class="spacing">
                    <h3>Modifiers for pages read DURING read-a-thon</h3>
                    <div class="mod-wrapper">
                        <div id="mod1-wrapper" class="mod-content">
                            <label for="mod-1-In" class="labels">Modifier 1:</label>
                            <select name="mod-1-In" id="mod-1-In" class="inputs">
                                <option value="8">Read-a-thon</option>
                            </select>
                        </div>

                        <div id="mod2-wrapper" class="mod-content">
                            <label for="mod-2-In" class="labels">Modifier 2:</label>
                            <select name="mod-2-In" id="mod-2-In" class="inputs" onchange="check()">
                                <option value="1">Normal</option>
                                <option value="2">Challenge</option>
                                <option value="3">Buddy Read</option>
                                <option value="4">Friend Recommendation</option>
                                <option value="5">Seasonal</option>
                                <option value="7">Educational</option>
                                <option value="8">Educational: Manga/Comics</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="modResults"></div>

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
                <textarea name="comment" id="comment" class="inputs" placeholder="(Optional)" maxlength="200"></textarea>

                <div class="button-wrapper">
                    <a href="updateRat.php">Read both in and outside of RAT</a>
                    <button type="submit" id="updateButton" class="inputs buttons">Update</button>
                </div>

            </form>
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