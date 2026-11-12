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
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <script src="https://kit.fontawesome.com/ea9288eda1.js" crossorigin="anonymous"></script> -->
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <?= makeNav() ?>
    </header>
        <div class="wrapper">
            <div class="wrapper-content">
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

            <div class="divider"></div>

            <div class="wrapper-content">
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
                        <div id="bingoResult" class="results"></div>
                    <?php } ?>  
                </div>
            </div>

            <div class="divider"></div>

            <div class="wrapper-content">
                <div class="title-wrapper">
                    <h2>Monthly Challenges</h2>
                </div>
                <div class="form-wrapper">
                    <div class="month">Jan:</div>
                    <textarea name="jan" id="jan"><?php if(isset($jan)){echo $jan;} ?></textarea>
                    <div class="month">Feb:</div>
                    <textarea name="feb" id="feb"><?php if(isset($feb)){echo $feb;} ?></textarea>
                    <div class="month">March:</div>
                    <textarea name="march" id="march"><?php if(isset($march)){echo $march;} ?></textarea>
                    <div class="month">April:</div>
                    <textarea name="april" id="april"><?php if(isset($april)){echo $april;} ?></textarea>
                    <div class="month">May:</div>
                    <textarea name="may" id="may"><?php if(isset($may)){echo $may;} ?></textarea>
                    <div class="month">June:</div>
                    <textarea name="june" id="june"><?php if(isset($june)){echo $june;} ?></textarea>
                    <div class="month">July:</div>
                    <textarea name="july" id="july"><?php if(isset($july)){echo $july;} ?></textarea>
                    <div class="month">Aug:</div>
                    <textarea name="aug" id="aug"><?php if(isset($aug)){echo $aug;} ?></textarea>
                    <div class="month">Sept:</div>
                    <textarea name="sept" id="sept"><?php if(isset($sept)){echo $sept;} ?></textarea>
                    <div class="month">Oct:</div>
                    <textarea name="oct" id="oct"><?php if(isset($oct)){echo $oct;} ?></textarea>
                    <div class="month">Nov:</div>
                    <textarea name="nov" id="nov"><?php if(isset($nov)){echo $nov;} ?></textarea>
                    <div class="month">Dec:</div>
                    <textarea name="dec" id="dec"><?php if(isset($dec)){echo $dec;} ?></textarea>
                </div>
                <div class="button-wrapper">
                    <div class="buttons" onclick="setChallenges()">set</div>
                </div>
                <div id="challengeResult"></div>
            </div>

            <div class="divider"></div>

            <div class="wrapper-content">
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
                data: {
                    bingoName:bingoName
                },success:function(result) {
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
                    data: {
                        bingoName:bingo
                    },success:function(result) {
                        $("#bingoResult").html(result)
                        setTimeout(refresh, 3000);
                    }
                })
            }
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

            $.ajax({
                url: "php/process-updateChallenges.php",
                method: "post",
                data: {
                    month_jan:jan,
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
                    month_dec:dec
                },success:function(result) {
                    $("#challengeResult").html(result);
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
        function showOTP(otp) {
            document.getElementById("OTP").innerHTML = otp;
            document.getElementById("OTPWrapper").style.display = "flex";
        }

        //randomly generates a otp, posts it to the database, and then passes the otp to the show otp function
        function createOTP() {
            <?php
                $oneTimePass = bin2hex(random_bytes(16));
            ?>
            //assign values
            var oneTimePass = <?= json_encode($oneTimePass) ?>;
            //begin post method
            $.post("php/createOTP.php", {
                //DATA
                oneTimePass: oneTimePass
            }, function(response) {
                showOTP(<?= json_encode($oneTimePass) ?>);
            });
        }
    </script>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>