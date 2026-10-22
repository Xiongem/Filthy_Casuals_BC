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

    $sql = "SELECT * FROM users WHERE user_id = $userID";
            $result = $_SESSION["conn"]->query($sql);
            $user = $result->fetch_assoc();
                $admin = $user['admin'];
                // $image = imageDataUri($user['pfpType'], $user['pfpData']);
                $imageName = htmlspecialchars($user['pfpName']);
                $imageType = $user['pfpType'];
                $imageData = base64_encode($user['pfpData']);

        echo '<div class="nav-wrapper" id="nav-wrapper">
                <div class="icon-wrapper" id="icon-wrapper"">
                    <i class="fa fa-bars" id="nav-menu-icon"></i>
                    <div class="nav-menu-wrapper" id="nav-menu-wrapper">
                        <div class="nav-menu-content" id="nav-menu-content">
                            <a class="nav-item" href="index.php">Home</a>
                            <a class="nav-item" href="challenges.php">Challenges</a>
                            <a class="nav-item" href="rules.php">Rules</a>
                            <a class="nav-item" href="settings.php">Settings</a>
                            <a id="update" class="nav-item" href="update.php">
                                update
                                <div class="update-icon">
                                    <i class="fa fa-plus" id="icon"></i>
                                </div>
                            </a>
                            <a class="nav-item" href="readHistory.php">History</a>';
                            if ($admin == 1) {
                                echo '<a href="OTP.php" class="nav-item">Passcode</a>';
                            }
                        echo '<a class="nav-item" href="logout.php">Logout</a>
                        </div>
                    </div>
                </div>
                <a href="profile.php" id="profile">
                    <img id="profilePic" src="data:$imageType;base64,' . base64_encode($user['pfpData']) . '" alt="$imageName">';
            echo '</a>
            </div>';   
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


