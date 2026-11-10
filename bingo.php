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
    <title>Bingo</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body id="body">
    <div class="wrapper">
        <div class="bingo-title spacing">
            <h2>Assign Bingo Squares</h2>
        </div>
        <div class="label-wrapper">
            <label>Bingo Dimensions:</label>
            <select name="bingoSize" id="bingoSize" class="inputs"  onchange="createInputs()">
                <option value="0">none</option>
                <option value="4">4x4</option>
                <option value="5">5x5</option>
                <option value="6">6x6</option>
                <option value="7">7x7</option>
                <option value="8">8x8</option>
                <option value="9">9x9</option>
                <option value="10">10x10</option>
            </select>
        </div>
        <div class="divider"></div>
        <div id="warn"></div>
        <div class="popup-content spacing" id="bingoResults"></div>
        <div id="sneakPeak" class="popup-content"></div>
        <div class="button-wrapper">
            <div id="bingoSubmit" onclick="sendBingoMath()">Submit</div>
        </div>
        <div class="popup-content" id="mathResults"></div>
    </div>
    <script>
        function createInputs() {
            $("#bingoResults").html("");
            var bingoSize = $("#bingoSize").val();

            var bingoSelect = [ 
                {   val : '0', text: 'Choose an option'},

            <?php $stmt7 = $_SESSION["conn"]->query("SELECT * FROM `bingo` WHERE `user_id` = $userID AND `bingo_name` = '$bingoName' AND `used` = 0"); 
                    $bingorow = mysqli_num_rows($stmt7);
                if ($bingorow > 0) {
                    while ($bingorow = mysqli_fetch_array($stmt7)) {
                        $bingoID = $bingorow["bingo_id"];
                        $bingoTitle = $bingorow["title"];
                        $bingoAuthor = $bingorow["author"];
                        $bingoPoints = $bingorow["total_points"];?>

            {   val : '<?=$bingoID?>', text: '<?=$bingoTitle?> by <?=$bingoAuthor?> (<?=$bingoPoints?>)'},
            <?php }
            } else { ?>
                {   val : '0', text: 'No available options found'}
            <?php } ?>
            ];
            
            for (let i = 0; i < bingoSize; i++) {
                var lab = $('<label>').appendTo('#bingoResults');
                lab.text("Square" + (i+1))

                var sel = $('<select>').appendTo('#bingoResults');
                sel.attr('class', 'inputs');
                sel.attr('name', "square" + (i+1));
                sel.attr('id', "square" + (i+1))

                for (var a in bingoSelect) {
                    sel.append($("<option>").attr('value',bingoSelect[a].val).text(bingoSelect[a].text));
                    sel.attr('onclick', 'bingoMath()')
                };
            }      
        }


        function bingoMath() {
            var bingoSize = $("#bingoSize").val();
            switch (bingoSize) {
                case '4':
                    square1 = $("#square1").val();
                    square2 = $("#square2").val();
                    square3 = $("#square3").val();
                    square4 = $("#square4").val();

                    if (square1 == square2 || square1 == square3 || square1 == square4 ||
                        square2 == square3 || square2 == square4 ||
                        square3 == square4
                    ) {
                        $("#warn").html("Squares cannot match");
                        $("#bingoSubmit").css("display", "none");
                    }else {
                        $("#warn").html("");
                        $("#bingoSubmit").css("display", "flex");
                    }

                    if (square1 > 0 && square2 > 0 && square3 > 0 && square4 > 0) {
                        $("#bingoSubmit").css("display", "flex");
                    }
                        
                    break;
            
                default:
                    break;
            }   
            
            switch (bingoSize) {
                case "4":
                    square1 = $("#square1").val();
                    square2 = $("#square2").val();
                    square3 = $("#square3").val();
                    square4 = $("#square4").val();
                    
                    $.ajax({
                        url: "php/bingoMath.php",
                        method: "post",
                        data: {
                            bingoSize:bingoSize,
                            square1:square1,
                            square2:square2,
                            square3:square3,
                            square4:square4
                        },success:function(result) {
                            $("#sneakPeak").html(result);
                        }
                    }) 
                    break;

                case "5":
                    square1 = $("#square1").val();
                    square2 = $("#square2").val();
                    square3 = $("#square3").val();
                    square4 = $("#square4").val();
                    square5 = $("#square5").val();

                    $.ajax({
                        url: "php/bingoMath.php",
                        method: "post",
                        data: {
                            bingoSize:bingoSize,
                            square1:square1,
                            square2:square2,
                            square3:square3,
                            square4:square4,
                            square5:square5
                        },success:function(result) {
                            $("#sneakPeak").html(result);
                        }
                    }) 
                    break;

                case "6":
                    square1 = $("#square1").val();
                    square2 = $("#square2").val();
                    square3 = $("#square3").val();
                    square4 = $("#square4").val();
                    square5 = $("#square5").val();
                    square6 = $("#square6").val();

                    $.ajax({
                        url: "php/bingoMath.php",
                        method: "post",
                        data: {
                            bingoSize:bingoSize,
                            square1:square1,
                            square2:square2,
                            square3:square3,
                            square4:square4,
                            square5:square5,
                            square6:square6
                        },success:function(result) {
                            $("#sneakPeak").html(result);
                        }
                    }) 
                    break;

                case "7":
                    square1 = $("#square1").val();
                    square2 = $("#square2").val();
                    square3 = $("#square3").val();
                    square4 = $("#square4").val();
                    square5 = $("#square5").val();
                    square6 = $("#square6").val();
                    square7 = $("#square7").val();

                    $.ajax({
                        url: "php/bingoMath.php",
                        method: "post",
                        data: {
                            bingoSize:bingoSize,
                            square1:square1,
                            square2:square2,
                            square3:square3,
                            square4:square4,
                            square5:square5,
                            square6:square6,
                            square7:square7
                        },success:function(result) {
                            $("#sneakPeak").html(result);
                        }
                    }) 
                    break;

                case "8":
                    square1 = $("#square1").val();
                    square2 = $("#square2").val();
                    square3 = $("#square3").val();
                    square4 = $("#square4").val();
                    square5 = $("#square5").val();
                    square6 = $("#square6").val();
                    square7 = $("#square7").val();
                    square8 = $("#square8").val();
                    $.ajax({
                        url: "php/bingoMath.php",
                        method: "post",
                        data: {
                            bingoSize:bingoSize,
                            square1:square1,
                            square2:square2,
                            square3:square3,
                            square4:square4,
                            square5:square5,
                            square6:square6,
                            square7:square7,
                            square8:square8
                        },success:function(result) {
                            $("#sneakPeak").html(result);
                        }
                    }) 
                    break;

                case "9":
                    square1 = $("#square1").val();
                    square2 = $("#square2").val();
                    square3 = $("#square3").val();
                    square4 = $("#square4").val();
                    square5 = $("#square5").val();
                    square6 = $("#square6").val();
                    square7 = $("#square7").val();
                    square8 = $("#square8").val();
                    square9 = $("#square9").val();

                    $.ajax({
                        url: "php/bingoMath.php",
                        method: "post",
                        data: {
                            bingoSize:bingoSize,
                            square1:square1,
                            square2:square2,
                            square3:square3,
                            square4:square4,
                            square5:square5,
                            square6:square6,
                            square7:square7,
                            square8:square8,
                            square9:square9
                        },success:function(result) {
                            $("#sneakPeak").html(result);
                        }
                    }) 
                    break;

                case "10":
                    square1 = $("#square1").val();
                    square2 = $("#square2").val();
                    square3 = $("#square3").val();
                    square4 = $("#square4").val();
                    square5 = $("#square5").val();
                    square6 = $("#square6").val();
                    square7 = $("#square7").val();
                    square8 = $("#square8").val();
                    square9 = $("#square9").val();
                    square10 = $("#square10").val();

                    $.ajax({
                        url: "php/bingoMath.php",
                        method: "post",
                        data: {
                            bingoSize:bingoSize,
                            square1:square1,
                            square2:square2,
                            square3:square3,
                            square4:square4,
                            square5:square5,
                            square6:square6,
                            square7:square7,
                            square8:square8,
                            square9:square9,
                            square10:square10
                        },success:function(result) {
                            $("#sneakPeak").html(result);
                        }
                    }) 
                    break;
            
                default:
                    break;
            }
        }

        function sendBingoMath() {
            var bingoSize = $("#bingoSize").val();
            
            switch (bingoSize) {
                case "4":
                    square1 = $("#square1").val();
                    square2 = $("#square2").val();
                    square3 = $("#square3").val();
                    square4 = $("#square4").val();
                    

                    $.ajax({
                        url: "php/process-bingoMath.php",
                        method: "post",
                        data: {
                            bingoSize:bingoSize,
                            square1:square1,
                            square2:square2,
                            square3:square3,
                            square4:square4
                        },success:function(result) {
                            $("#mathResults").html(result);
                        }
                    }) 
                    break;

                case "5":
                    square1 = $("#square1").val();
                    square2 = $("#square2").val();
                    square3 = $("#square3").val();
                    square4 = $("#square4").val();
                    square5 = $("#square5").val();

                    $.ajax({
                        url: "php/process-bingoMath.php",
                        method: "post",
                        data: {
                            bingoSize:bingoSize,
                            square1:square1,
                            square2:square2,
                            square3:square3,
                            square4:square4,
                            square5:square5
                        },success:function(result) {
                            $("#mathResults").html(result);
                        }
                    }) 
                    break;

                case "6":
                    square1 = $("#square1").val();
                    square2 = $("#square2").val();
                    square3 = $("#square3").val();
                    square4 = $("#square4").val();
                    square5 = $("#square5").val();
                    square6 = $("#square6").val();

                    $.ajax({
                        url: "php/process-bingoMath.php",
                        method: "post",
                        data: {
                            bingoSize:bingoSize,
                            square1:square1,
                            square2:square2,
                            square3:square3,
                            square4:square4,
                            square5:square5,
                            square6:square6
                        },success:function(result) {
                            $("#mathResults").html(result);
                        }
                    }) 
                    break;

                case "7":
                    square1 = $("#square1").val();
                    square2 = $("#square2").val();
                    square3 = $("#square3").val();
                    square4 = $("#square4").val();
                    square5 = $("#square5").val();
                    square6 = $("#square6").val();
                    square7 = $("#square7").val();

                    $.ajax({
                        url: "php/process-bingoMath.php",
                        method: "post",
                        data: {
                            bingoSize:bingoSize,
                            square1:square1,
                            square2:square2,
                            square3:square3,
                            square4:square4,
                            square5:square5,
                            square6:square6,
                            square7:square7
                        },success:function(result) {
                            $("#mathResults").html(result);
                        }
                    }) 
                    break;

                case "8":
                    square1 = $("#square1").val();
                    square2 = $("#square2").val();
                    square3 = $("#square3").val();
                    square4 = $("#square4").val();
                    square5 = $("#square5").val();
                    square6 = $("#square6").val();
                    square7 = $("#square7").val();
                    square8 = $("#square8").val();
                    $.ajax({
                        url: "php/process-bingoMath.php",
                        method: "post",
                        data: {
                            bingoSize:bingoSize,
                            square1:square1,
                            square2:square2,
                            square3:square3,
                            square4:square4,
                            square5:square5,
                            square6:square6,
                            square7:square7,
                            square8:square8
                        },success:function(result) {
                            $("#mathResults").html(result);
                        }
                    }) 
                    break;

                case "9":
                    square1 = $("#square1").val();
                    square2 = $("#square2").val();
                    square3 = $("#square3").val();
                    square4 = $("#square4").val();
                    square5 = $("#square5").val();
                    square6 = $("#square6").val();
                    square7 = $("#square7").val();
                    square8 = $("#square8").val();
                    square9 = $("#square9").val();

                    $.ajax({
                        url: "php/process-bingoMath.php",
                        method: "post",
                        data: {
                            bingoSize:bingoSize,
                            square1:square1,
                            square2:square2,
                            square3:square3,
                            square4:square4,
                            square5:square5,
                            square6:square6,
                            square7:square7,
                            square8:square8,
                            square9:square9
                        },success:function(result) {
                            $("#mathResults").html(result);
                        }
                    }) 
                    break;

                case "10":
                    square1 = $("#square1").val();
                    square2 = $("#square2").val();
                    square3 = $("#square3").val();
                    square4 = $("#square4").val();
                    square5 = $("#square5").val();
                    square6 = $("#square6").val();
                    square7 = $("#square7").val();
                    square8 = $("#square8").val();
                    square9 = $("#square9").val();
                    square10 = $("#square10").val();

                    $.ajax({
                        url: "php/process-bingoMath.php",
                        method: "post",
                        data: {
                            bingoSize:bingoSize,
                            square1:square1,
                            square2:square2,
                            square3:square3,
                            square4:square4,
                            square5:square5,
                            square6:square6,
                            square7:square7,
                            square8:square8,
                            square9:square9,
                            square10:square10
                        },success:function(result) {
                            $("#mathResults").html(result);
                        }
                    }) 
                    break;
            
                default:
                    break;
            }
        }
    </script>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>