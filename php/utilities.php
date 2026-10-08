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

dbConnect();
$userID = $_SESSION["user_id"];

 $sql = "SELECT * FROM users WHERE user_id = $userID";
        $result = $_SESSION["conn"]->query($sql);
        $user = $result->fetch_assoc();
            $pfp = $user['pfp'];

function makeNav() {
        $htmlContent = <<<HTML
            <div class="nav-wrapper" id="nav-wrapper">
                <div class="icon-wrapper">
                    <i class="fa fa-bars" id="nav-menu-icon"></i>
                    <div class="nav-menu-wrapper" id="nav-menu-wrapper">
                        <div class="nav-menu-content" id="nav-menu-content">
                            <a class="nav-item" href="index.php">Home</a>
                            <a class="nav-item" href="challenges.php">Challenges</a>
                            <a class="nav-item" href="rules.php">Rules</a>
                            <a class="nav-item" href="settings.php">Settings</a>
                            <a class="nav-item" href="logout.php">Logout</a>
                        </div>
                    </div>
                </div>
                <a href="profile.php" id="profile">
                    <img src="uploads/<?= $pfp ?>" alt="Profile Picture" id="profile-picture">
                </a>
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