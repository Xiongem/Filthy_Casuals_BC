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
    $htmlContent = <<<HTML
        <div class="nav-wrapper" id="nav-wrapper">
            <div class="icon-wrapper">
                <i class="fa fa-bars" id="nav-menu-icon"></i>
                <div class="nav-menu-wrapper" id="nav-menu-wrapper">
                    <div class="nav-menu-content" id="nav-menu-content">
                        <a class="nav-item">Home</a>
                        <a class="nav-item">Settings</a>
                        <a class="nav-item">Logout</a>
                    </div>
                </div>
            </div>
            <a href="login.php" id="login">login</a>
        </div>
    HTML;
    echo $htmlContent;
}
?>