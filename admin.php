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
                        <label class="labels">Deactivate <?=$activeBingo?> Bingo</label>
                        <div class="buttons spacing" onclick="deactivateBingo('<?=$activeBingo?>')">deactivate</div>
                    </div>
                    <div id="deactivateResult" class="results"></div>
                    <?php } else { ?>
                        <label class="labels">Activate Bingo:</label>
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

                        <div class="label-wrapper spacing">
                            <label class="labels">Create New Bingo:</label>
                            <input class="inputs" type="text" name="newBingo" id="newBingo" maxlength="50">
                            <div class="buttons spacing" onclick="createNewBingo()">Create</div>
                            <div class="results" id="newBingoResult"></div>
                        </div>
                    <?php } ?>  
                </div>
            </div>

            <div class="divider div4" id="bingo-divider"></div>

            <div class="link-wrapper wrapper-content div5">
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

            <div class="divider div6" id="challenge-divider"></div>

            <div class="wrapper-content div7" id="admin-wrapper">
                 <div class="admin-wrapper">
                    <div class="title-wrapper">
                        <h2>Current Admins</h2>
                    </div>
                    <?php $stmt2 = $_SESSION["conn"]->query("SELECT * FROM `users` WHERE `admin` = 1");
                            $admins = mysqli_num_rows($stmt2);

                            if ($admins > 0) {
                                while ($admins = mysqli_fetch_assoc($stmt2)) {
                                    $adminsID = $admins["user_id"];
                                    $adminsName = $admins["username"];
                                    $imageName = htmlspecialchars($admins['pfpName']);
                                    $imageType = $admins['pfpType'];
                                    $imageData = base64_encode($admins['pfpData']);
                        ?>
                    <div class="admin-row">
                        <img class="adminPfp item center" src="data:<?=$imageType?>;base64,<?=$imageData?>" alt="<?=$imageName?>">
                        <div class="adminName item" id="<?=$adminsID?>"><?=$adminsName?></div>
                    </div>
                    <?php }} ?>
                </div>
            </div>

            <div class="divider div8"></div>

            <div class="wrapper-content div9">
                <div class="admin-button-wrapper">
                    <div class="title-wrapper">
                        <h2>Challenges</h2>
                    </div>
                    <div class="buttons">
                        <a href="challengesEdit.php">Edit Challenges</a>
                    </div>
                </div>
            </div>

            <div class="divider div10"></div>

            <div class="wrapper-content div11" id="otp-wrapper">
                <div class="title-wrapper">
                    <h2>Generate One-time Passcode</h2>
                </div>
                <div class="button-wrapper">
                    <div id="createOTPButton" class="buttons" onclick="createOTP()">Create OTP</div>
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
            
            <div class="divider div12"></div>

        </div>
    <script>
        function createNewBingo() {
            var newBingo = $("#newBingo").val();

            $.ajax ({
                url: "php/process-createNewBingo.php",
                method: "post",
                data: {newBingo:newBingo},
                success:function(result) {
                    $("#newBingoResult").html(result);
                    setTimeout(refresh, 3000);
                }
            })
        }

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

        //randomly generates a otp, posts it to the database, and then passes the otp to the otp span
        function createOTP() {
                var oneTimePass = "";
                var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                var charactersLength = characters.length;
                for ( var i = 0; i < 32; i++ ) {
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
        }

        //
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
                    $('#search_results').hide();
                    $("#addAdminResult").html(result);
                }
            })
        }
    </script>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>