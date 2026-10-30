<?php
session_start();

// database connection
function dbConnect() {
    $servername = "localhost";
    $database = "u792691800_FCBC";
    $username = "u792691800_jamieFCBC";
    $password = "Hi5gem601*";
    $_SESSION["conn"] = mysqli_connect($servername, $username, $password, $database);
    if (!$_SESSION["conn"]) {die("Connection failed: " . mysqli_connect_error()); }
}

function makeNav() {
    $userID = $_SESSION["user_id"];
    $admin = $_SESSION["admin"];

    $sql = "SELECT * FROM users WHERE user_id = $userID";
            $result = $_SESSION["conn"]->query($sql);
            $user = $result->fetch_assoc();
                // $admin = $user['admin'];
                // $image = imageDataUri($user['pfpType'], $user['pfpData']);
                $imageName = htmlspecialchars($user['pfpName']);
                $imageType = $user['pfpType'];
                $imageData = base64_encode($user['pfpData']);
    $htmlContent = <<<HTML
        <div class="nav-wrapper" id="nav-wrapper">
                <div class="icon-wrapper" id="icon-wrapper"">
                    <ion-icon name="menu" id="nav-menu-icon"></ion-icon>
                    <div class="nav-menu-wrapper" id="nav-menu-wrapper">
                        <div class="nav-menu-content" id="nav-menu-content">
                            <a class="nav-item" href="index.php">Home</a>
                            <a class="nav-item" href="challenges.php">Challenges</a>
                            <a class="nav-item" href="rules.php">Rules</a>
                            <a id="update" class="nav-item" href="update.php">
                                update
                                    <ion-icon name="add" id="icon"></ion-icon>
                            </a>
                            <a class="nav-item" href="readHistory.php?user_id=$userID">History</a>
                            <?php if ($admin == 1) { ?>
                                <a href="admin.php" class="nav-item">Admin</a>
                            <?php } ?>
                            <a class="nav-item" href="settings.php">Settings</a>
                            <a class="nav-item" href="php/logout.php">Logout</a>
                        </div>
                    </div>
                </div>
                <a href="profile.php" id="profile">
                    <img id="profilePic" src="data:$imageType;base64,$imageData" alt="$imageName">
                </a>
            </div>
            <div class="desktop-nav-wrapper">
                <div class="desktop-logo-wrapper">
                    <a class="desktop-nav-item" href="index.php">
                        <img class="logo" id="logo" src="./images/FCBClogo.svg" alt="cat laying on books logo">
                    </a>
                </div>
                <div class="desktop-menu-wrapper">
                    <a class="nav-item" href="challenges.php">Challenges</a>
                    <a class="nav-item" href="rules.php">Rules</a>
                    <a class="nav-item" href="readHistory.php?user_id=$userID">History</a>
                    <?php if ($admin == 1) { ?>
                        <a href="admin.php" class="nav-item">Admin</a>
                    <?php } ?>
                    <a class="nav-item" href="settings.php">Settings</a>
                    <a class="nav-item" href="php/logout.php">Logout</a>
                    <a id="update" class="desktop-nav-item" href="update.php">
                        <ion-icon size="large" name="add-circle-outline"></ion-icon>
                        <p id="explain">update</p>
                    </a>
                </div>
                <div id="profile">
                    <img id="profilePic" src="data:$imageType;base64,$imageData" alt="$imageName">
                </div>
            </div>
        HTML;
        echo $htmlContent;
}

function forceLogin() {
//    echo("forceLogin start"."<br>");
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
//    echo "Welcome to the member's area, " . htmlspecialchars($_SESSION["user_id"]) . "!";
    } else {
        echo ("redirecting");
        header("Location: /login.php");
        exit();
    }   
}


