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

$sql2 = "SELECT * FROM `bingoNames` WHERE `active` = 1";
    $result2 = $_SESSION["conn"]->query($sql2);
    $bingoActive = $result2->fetch_assoc();
    if ($bingoActive) {
        $activeBingo = $bingoActive["bingo_name"];
    } else {
        $activeBingo = false;
    }

$sql3 = "SELECT * FROM `challenges`";
    $result3 = $_SESSION["conn"]->query($sql3);
    $challenge = $result3->fetch_assoc();
        $jan = $challenge["month_jan"];
        $feb = $challenge["month_feb"];
        $march = $challenge["month_march"];
        $april = $challenge["month_april"];
        $may = $challenge["month_may"];
        $june = $challenge["month_june"];
        $july = $challenge["month_july"];
        $aug = $challenge["month_aug"];
        $sept = $challenge["month_sept"];
        $oct = $challenge["month_oct"];
        $nov = $challenge["month_nov"];
        $dec = $challenge["month_dec"];
            $janDescr = $challenge["jan_descr"];
            $febDescr = $challenge["feb_descr"];
            $marchDescr = $challenge["march_descr"];
            $aprilDescr = $challenge["april_descr"];
            $mayDescr = $challenge["may_descr"];
            $juneDescr = $challenge["june_descr"];
            $julyDescr = $challenge["july_descr"];
            $augDescr = $challenge["aug_descr"];
            $septDescr = $challenge["sept_descr"];
            $octDescr = $challenge["oct_descr"];
            $novDescr = $challenge["nov_descr"];
            $decDescr = $challenge["dec_descr"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="Filthy Casual Book Challenge"> 
    <meta property="og:description" content="A competition for filthy casuals."> 
    <meta property="og:image" content="https://filthycasualsbc.com/images/FCBClogo.svg"> 
    <meta property="og:url" content="https://filthycasualsbc.com/admin.php">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <?= makeNav() ?>
    </header>
        <div class="wrapper">
            <div class="wrapper-content div1" id="rat-wrapper">
                <div class="title-wrapper">
                    <h2>Set RAT Date:</h2>
                </div>
                <div class="date-wrapper">
                    <div class="date-input-wrapper">
                        <label for="startDate">Start:</label>
                        <input class="inputs" type="date" name="startDate" id="startDate">
                    </div>
                    <p class="hyphen">-</p>
                    <div class="date-input-wrapper">
                        <label for="endDate">End:</label>
                        <input class="inputs" type="date" name="endDate" id="endDate">
                    </div>
                </div>
                <div class="button-wrapper">
                    <div class="buttons" onclick="setRatDate()">Set</div>
                </div>
                <div class="setResult results" id="setResult"></div>
            </div>

            <div class="divider div2" id="rat-divider"></div>

            <div class="wrapper-content div3" id="bingo-wrapper">
                <div class="title-wrapper">
                    <h2>Bingo Controls</h2>
                </div>
                <div class="bingo-wrapper">
                    <?php if ($activeBingo) { ?>
                    <div class="label-wrapper">
                        <label>Deactivate <?=$activeBingo?> Bingo</label>
                        <div class="buttons spacing" onclick="deactivateBingo('<?=$activeBingo?>')">deactivate</div>
                    </div>
                    <div id="deactivateResult" class="results"></div>
                    <?php } else { ?>
                        <select name="bingo" id="bingo" class="inputs spacing">
                            <option value="0">Select Active Bingo</option>
                            <?php $stmt = $_SESSION["conn"]->query("SELECT * FROM `bingoNames`"); 
                                    $bingo = mysqli_num_rows($stmt);
                                    if ($bingo > 0) {
                                        while ($bingo = mysqli_fetch_assoc($stmt)) {
                                            $bingoID = $bingo["bingo_name_id"];
                                            $bingoName = $bingo["bingo_name"];
                                    ?>
                            <option id="<?=$bingoID?>" value="<?=$bingoName?>"><?=$bingoName?></option>
                            <?php }} ?>
                        </select>
                        <div class="button-wrapper">
                            <div class="buttons" onclick="activateBingo()">Activate</div>
                        </div>
                        <div class="results" id="bingoResult"></div>
                    <?php } ?>  
                </div>
            </div>

            <div class="divider div4" id="bingo-divider"></div>

            <div class="wrapper-content div5" id="challenge-wrapper">
                <div class="title-wrapper">
                    <h2>Monthly Challenges</h2>
                </div>
                <div class="form-wrapper">
                    <div class="row">
                        <div class="month">Jan:</div>
                        <input class="inputs" name="jan" id="jan" value="<?=$jan?>">
                        <textarea class="inputs" name="janDescr" id="janDescr" maxlength="200"><?=$janDescr?></textarea>
                    </div>
                    <div class="row">
                        <div class="month">Feb:</div>
                        <input class="inputs" name="feb" id="feb" value="<?=$feb?>">
                        <textarea class="inputs" name="febDescr" id="febDescr" maxlength="300"><?=$febDescr?></textarea>
                    </div>
                    <div class="row">
                        <div class="month">March:</div>
                        <input class="inputs" name="march" id="march" value="<?=$march?>">
                        <textarea class="inputs" name="marchDescr" id="marchDescr" maxlength="300"><?=$marchDescr?></textarea>
                    </div>
                    <div class="row">
                        <div class="month">April:</div>
                        <input class="inputs" name="april" id="april" value="<?=$april?>">
                        <textarea class="inputs" name="aprilDescr" id="aprilDescr" maxlength="300"><?=$aprilDescr?></textarea>
                    </div>
                    <div class="row">
                        <div class="month">May:</div>
                        <input class="inputs" name="may" id="may" value="<?=$may?>">
                        <textarea class="inputs" name="mayDescr" id="mayDescr" maxlength="300"><?=$mayDescr?></textarea>
                    </div>
                    <div class="row">
                        <div class="month">June:</div>
                        <input class="inputs" name="june" id="june" value="<?=$june?>">
                        <textarea class="inputs" name="juneDescr" id="juneDescr" maxlength="300"><?=$juneDescr?></textarea>
                    </div>
                    <div class="row">
                        <div class="month">July:</div>
                        <input class="inputs" name="july" id="july" value="<?=$july?>">
                        <textarea class="inputs" name="julyDescr" id="julyDescr" maxlength="300"><?=$julyDescr?></textarea>
                    </div>
                    <div class="row">
                        <div class="month">Aug:</div>
                        <input class="inputs" name="aug" id="aug" value="<?=$aug?>">
                        <textarea class="inputs" name="augDescr" id="augDescr" maxlength="300"><?=$augDescr?></textarea>
                    </div>
                    <div class="row">
                        <div class="month">Sept:</div>
                        <input class="inputs" name="sept" id="sept" value="<?=$sept?>">
                        <textarea class="inputs" name="septDescr" id="septDescr" maxlength="300"><?=$septDescr?></textarea>
                    </div>
                    <div class="row">
                        <div class="month">Oct:</div>
                        <input class="inputs" name="oct" id="oct" value="<?=$oct?>">
                        <textarea class="inputs" name="octDescr" id="octDescr" maxlength="300"><?=$octDescr?></textarea>
                    </div>
                    <div class="row">
                        <div class="month">Nov:</div>
                        <input class="inputs" name="nov" id="nov" value="<?=$nov?>">
                        <textarea class="inputs" name="novDescr" id="novDescr" maxlength="300"><?=$novDescr?></textarea>
                    </div>
                    <div class="row">
                        <div class="month">Dec:</div>
                        <input class="inputs" name="dec" id="dec" value="<?=$dec?>">
                        <textarea class="inputs" name="decDescr" id="decDescr" maxlength="300"><?=$decDescr?></textarea>
                    </div>
                </div>
                <div class="button-wrapper">
                    <div class="buttons" onclick="setChallenges()">set</div>
                </div>
                <div class="results" id="challengeResult"></div>
            </div>

            <div class="divider" id="challenge-divider"></div>

            <div class="wrapper-content div6" id="admin-wrapper">
                <div class="title-wrapper">
                    <h2>Add Admin</h2>
                </div>
                <div class="admin-wrapper">
                    <div class="search-admin-wrapper">
                        <div class="search">
                            <label for="keyword" class="labels">Username:</label>
                            <input type="text" 
                                name="keyword" 
                                id="username" 
                                class="username inputs" 
                                onkeyup="adminAutocomplete()">
                        </div>
                    </div>
                    <div id="search_results" class="search-wrapper"></div>
                    <div id="addAdminResult"></div>
                </div>
            </div>

            <div class="divider div7"></div>

            <div class="wrapper-content div8" id="otp-wrapper">
                <div class="title-wrapper">
                    <h2>Generate One-time Passcode</h2>
                </div>
                <div class="button-wrapper">
                    <button id="createOTPButton" class="inputs buttons" onclick="createOTP()">Create OTP</button>
                </div>
                <div class="OTP-wrapper" id="OTPWrapper">
                    <label class="labels">One-time Passcode:</label>
                    <div class="span-wrapper">
                        <span id="OTP" class="labels"></span>
                        <div class="copy-wrapper">
                            <p id="copy">copy</p>
                            <ion-icon class="copy" name="copy-outline"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    <script>
        //sends the start and end dates for RAT to the database
        function setRatDate() {
            var userID = <?=$userID?>;
            var startDate = $("#startDate").val();
            var endDate = $("#endDate").val();

            if (startDate && endDate) {
                $.ajax({
                    url: "php/process-setRatDate.php",
                    method: "post",
                    data: {startDate:startDate,
                            endDate:endDate,
                            userID:userID},
                    success:function(result) {
                        $("#setResult").html(result)
                    }
                })
            }else{
                $("#setResult").html("Please set dates before submitting.")
            }
        }

        function refresh(){
            location.reload();
        }

        function deactivateBingo(bingoName) {
            // var bingo = bingoName;
            $.ajax({
                url: "php/process-deactivateBingo.php",
                method: "post",
                data: {bingoName:bingoName},
                success:function(result) {
                    $("#deactivateResult").html(result);
                    setTimeout(refresh, 3000);
                }
            })
        }

        function activateBingo() {
            var bingo = $("#bingo").val();
            if (bingo !== 0) {
                $.ajax({
                    url: "php/process-activateBingo.php",
                    method: "post",
                    data: {bingoName:bingo},
                    success:function(result) {
                        $("#bingoResult").html(result)
                        setTimeout(refresh, 3000);
                    }
                })
            }
        }
        function resetWords() {
            $("#challengeResult").html("");
        }

        function setChallenges() {
            var jan = $("#jan").val();
            var feb = $("#feb").val();
            var march = $("#march").val();
            var april = $("#april").val();
            var may = $("#may").val();
            var june = $("#june").val();
            var july = $("#july").val();
            var aug = $("#aug").val();
            var sept = $("#sept").val();
            var oct = $("#oct").val();
            var nov = $("#nov").val();
            var dec = $("#dec").val();
                var janDescr = $("#janDescr").val();
                var febDescr = $("#febDescr").val();
                var marchDescr = $("#marchDescr").val();
                var aprilDescr = $("#aprilDescr").val();
                var mayDescr = $("#mayDescr").val();
                var juneDescr = $("#juneDescr").val();
                var julyDescr = $("#julyDescr").val();
                var augDescr = $("#augDescr").val();
                var septDescr = $("#septDescr").val();
                var octDescr = $("#octDescr").val();
                var novDescr = $("#novDescr").val();
                var decDescr = $("#decDescr").val();

            $.ajax({
                url: "php/process-updateChallenges.php",
                method: "post",
                data: {month_jan:jan,
                    month_feb:feb,
                    month_march:march,
                    month_april:april,
                    month_may:may,
                    month_june:june,
                    month_july:july,
                    month_aug:aug,
                    month_sept:sept,
                    month_oct:oct,
                    month_nov:nov,
                    month_dec:dec,
                        jan_Descr:janDescr,
                        feb_Descr:febDescr,
                        march_Descr:marchDescr,
                        april_Descr:aprilDescr,
                        may_Descr:mayDescr,
                        june_Descr:juneDescr,
                        july_Descr:julyDescr,
                        aug_Descr:augDescr,
                        sept_Descr:septDescr,
                        oct_Descr:octDescr,
                        nov_Descr:novDescr,
                        dec_Descr:decDescr},
                success:function(result) {
                    $("#challengeResult").html(result);
                    setTimeout(resetWords, 3000);
                }
            })
        }

        //copies otp when user clicks the otp span
        const span = document.querySelector("span");
        span.onclick = function() {
            document.execCommand("copy");
        }
        span.addEventListener("copy", function(event) {
        event.preventDefault();
            if (event.clipboardData) {
                event.clipboardData.setData("text/plain", span.textContent);
                $("#copy").text("copied")
                console.log(event.clipboardData.getData("text"))
            }
        });

        //displays otp after generate button is clicked
        // function showOTP(otp) {
        //     document.getElementById("OTP").innerHTML = otp;
        //     document.getElementById("OTPWrapper").style.display = "flex";
        // }

        //randomly generates a otp, posts it to the database, and then passes the otp to the show otp function
        function createOTP() {
                var oneTimePass = "";
                var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                var charactersLength = characters.length;
                for ( var i = 0; i < 16; i++ ) {
                    oneTimePass += characters.charAt(Math.floor(Math.random() * charactersLength));
                }
            
            //begin post method
            $.ajax ({
                url: "php/createOTP.php",
                method: "post",
                data: {oneTimePass: oneTimePass},
                success:function(response) {
                    $("#OTP").html(response);
                }
            })

            // $.post("php/createOTP.php", {
            //     oneTimePass: oneTimePass
            // }, function(response) {
            //     $("#OTP").html(response);
            // });
        }

        function adminAutocomplete() {
            var min_length = 0; // min characters to display the autocomplete
            var keyword = $("#username").val();
            
            if (keyword.length > min_length) {
                $.ajax({
                    url: 'php/ajax_username_processing.php',
                    type: 'POST',
                    data: {keyword:keyword},
                    success:function(data){
                        $('#search_results').show();
                        $('#search_results').html(data);
                    }
                });
            } else {
                $('#search_results').hide();
            }
        }

        function addAdmin(userID) {
            $.ajax ({
                url: "php/process-addAdmin.php",
                method: "post",
                data: {user_id:userID},
                success:function (result) {
                    $("#addAdminResult").html(result);
                }
            })
        }
    </script>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>