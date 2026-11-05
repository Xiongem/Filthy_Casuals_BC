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

// $sql1 = "SELECT * FROM users WHERE user_id = $userID";
//     $result1 = $_SESSION["conn"]->query($sql1);
//     $user = $result1->fetch_assoc();
//         $username = $user["username"];
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
    <title>Friend Recs</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/friendRecs.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <?= makeNav() ?>
    </header>
    <div class="button-wrapper">
        <div class="rec-input-button buttons" onclick="showRecPopup()">
            <p>update</p>
        </div>
    </div>
    <div class="wrapper">
        <div class="rec-wrapper">
        <?php $stmt = $_SESSION["conn"]->query("SELECT * FROM friendRecs");
            $row = mysqli_num_rows($stmt);
            if($row > 0) {
                while($row = mysqli_fetch_assoc($stmt)) {
                    $username = $row["username"];
                    $rec1Title = $row["rec1_title"];
                    $rec1Author = $row["rec1_author"];
                    $rec1Series = $row["rec1_series"];
                    $rec2Title = $row["rec2_title"];
                    $rec2Author = $row["rec2_author"];
                    $rec2Series = $row["rec2_series"];
                    $rec3Title = $row["rec3_title"];
                    $rec3Author = $row["rec3_author"];
                    $rec3Series = $row["rec3_series"];
                    $rec4Title = $row["rec4_title"];
                    $rec4Author = $row["rec4_author"];
                    $rec4Series = $row["rec4_series"];
                    $rec5Title = $row["rec5_title"];
                    $rec5Author = $row["rec5_author"];
                    $rec5Series = $row["rec5_series"];
        ?>
            <div class="name" id="<?=$username?>">
                <h2><?=$username?></h2>
            </div>
            <div class="read-wrapper">
                <div class="rank">1.</div>
                <div class="info-wrapper">
                    <h5 class="label">Title:</h5>
                    <div class="info" id="<?=$rec1Title?>">
                        <?=$rec1Title?>
                    </div>
                </div>
                <div class="info-wrapper">
                    <h5 class="label">Author:</h5>
                    <div class="info" id="<?=$rec1Author?>">
                        <?=$rec1Author?>
                    </div>
                </div>
                <div class="info-wrapper">
                    <h5 class="label">Series:</h5>
                    <div class="info" id="<?=$rec1Series?>">
                        <?=$rec1Series?>
                    </div>
                </div>
            </div>
        
            <div class="read-wrapper">
                <div class="rank">2.</div>
                <div class="info-wrapper">
                    <h5 class="label">Title:</h5>
                    <div class="info" id="<?=$rec2Title?>">
                        <?=$rec2Title?>
                    </div>
                </div>
                <div class="info-wrapper">
                    <h5 class="label">Author:</h5>
                    <div class="info" id="<?=$rec2Author?>">
                        <?=$rec2Author?>
                    </div>
                </div>
                <div class="info-wrapper">
                    <h5 class="label">Series:</h5>
                    <div class="info" id="<?=$rec2Series?>">
                        <?=$rec2Series?>
                    </div>
                </div>
            </div>

            <div class="read-wrapper">
                <div class="rank">3.</div>
                <div class="info-wrapper">
                    <h5 class="label">Title:</h5>
                    <div class="info" id="<?=$rec3Title?>">
                        <?=$rec3Title?>
                    </div>
                </div>
                <div class="info-wrapper">
                    <h5 class="label">Author:</h5>
                    <div class="info" id="<?=$rec3Author?>">
                        <?=$rec3Author?>
                    </div>
                </div>
                <div class="info-wrapper">
                    <h5 class="label">Series:</h5>
                    <div class="info" id="<?=$rec3Series?>">
                        <?=$rec3Series?>
                    </div>
                </div>
            </div>

            <div class="read-wrapper">
                <div class="rank">4.</div>
                <div class="info-wrapper">
                    <h5 class="label">Title:</h5>
                    <div class="info" id="<?=$rec4Title?>">
                        <?=$rec4Title?>
                    </div>
                </div>
                <div class="info-wrapper">
                    <h5 class="label">Author:</h5>
                    <div class="info" id="<?=$rec4Author?>">
                        <?=$rec4Author?>
                    </div>
                </div>
                <div class="info-wrapper">
                    <h5 class="label">Series:</h5>
                    <div class="info" id="<?=$rec4Series?>">
                        <?=$rec4Series?>
                    </div>
                </div>
            </div>

            <div class="read-wrapper">
                <div class="rank">5.</div>
                <div class="info-wrapper">
                    <h5 class="label">Title:</h5>
                    <div class="info" id="<?=$rec5Title?>">
                        <?=$rec5Title?>
                    </div>
                </div>
                <div class="info-wrapper">
                    <h5 class="label">Author:</h5>
                    <div class="info" id="<?=$rec5Author?>">
                        <?=$rec5Author?>
                    </div>
                </div>
                <div class="info-wrapper">
                    <h5 class="label">Series:</h5>
                    <div class="info" id="<?=$rec5Series?>">
                        <?=$rec5Series?>
                    </div>
                </div>
            </div>
        <?php }}?>
        </div>
    </div>
<script type="module" src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@8.0.13/dist/ionicons/ionicons.js"></script>
</body>
</html>