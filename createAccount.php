<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

    ob_start();
    require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
    dbConnect();

    if (!isset($_SESSION['passcode_verified']) || $_SESSION['passcode_verified'] !== true) {
        header("Location: onetimePasscode.php");
        exit;
    }
    
$user_id = $_GET['user_id'];
$_SESSION["createAccount"] = true;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["username"])) {
        die("Username is required");
    }

    if (! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        die("Valid email is required");
    }

    if (strlen($_POST["password"]) < 8) {
        die("Password must be at least 8 characters");
    }

    if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
        die("Password must contain at least one letter");
    }

    if ( ! preg_match("/[0-9]/i", $_POST["password"])) {
        die("Password must contain at least one number");
    }

    if ($_POST["password"] !== $_POST["retypePassword"]) {
        die("Passwords must match");
    }


    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $image = $_FILES['profilePicture'];


    if ($image === null) {
        return ['error', 'Please choose an image file.', null];
        echo "Please choose an image file.1";
    }

    if (($image['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return ['error', 'Please choose an image file.', null];
        echo "Please choose an image file.2";
    }

    if (($image['size'] ?? 0) > 2097152) {
        return ['error', 'Image size must be 5 MB or less.', null];
        echo "Image size must be 5 MB or less.";
    }

    $tmpName = $image['tmp_name'] ?? '';
    if ($tmpName === '' || !is_uploaded_file($tmpName)) {
        return ['error', 'The uploaded file is not valid.', null];
        echo "The uploaded file is not valid.";
    }

    $imageInfo = @getimagesize($tmpName);
    if ($imageInfo === false || empty($imageInfo['mime'])) {
        return ['error', 'Please upload a valid image file.', null];
        echo "Please upload a valid image file.";
    }

    $imageName = trim((string) ($image['name'] ?? ''));
    if ($imageName === '') {
        $imageName = 'image';
    }

    $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
    ];

    $mimeType = $imageInfo['mime'];
    if (!in_array($mimeType, $allowedMimeTypes, true)) {
        return ['error', 'Only JPG, PNG, GIF, and WebP files are allowed.', null];
        echo "Only JPG, PNG, GIF, and WebP files are allowed.";
    }

    $imageData = file_get_contents($tmpName);
    if ($imageData === false) {
        return ['error', 'Unable to read the uploaded file.', null];
        echo "Unable to read the uploaded file.";
    }


    if ($_POST["username"] && $_POST["email"] && $_POST["password"] && $image) {
        $stmt = $_SESSION["conn"] -> prepare("INSERT INTO users (user_id, username, email, password_hash, pfpName, pfpType, pfpData, timezone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssss",
                            $user_id,
                            $_POST["username"],
                            $_POST["email"],
                            $password_hash,
                            $imageName,
                            $mimeType,
                            $imageData,
                            $_POST["timezone"]);

                            echo "bound params";


        if ($stmt -> execute()) {
            $sql = sprintf("SELECT * FROM users
                            WHERE username = '%s'",
                            $_SESSION["conn"]->real_escape_string($_POST["username"]));

            $result = $_SESSION["conn"]->query($sql);

            $user = $result->fetch_assoc();

                unset($_SESSION['createAccount']);
                $_SESSION["user_id"] = $user["user_id"];
                
                header("Location: /mailVerification.php");
                exit;
            } else {
                die("failed to create account");
        }
    }
}
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
    <title>Account Creation</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="javascript/scripts.js"></script>
    <script src="https://use.fontawesome.com/fe459689b4.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        function checkName(){
            var username = document.getElementById("username").value;
            
            if(username){
                $.ajax({
                type: 'post',
                url: 'php/checkData.php',
                data: {
                    username: username,
                },
                success: function (data) {
                    $('#user-availability-status').html(data);
                }
                });
            }
            else{
                $('#user-availability-status').html("");
                console.log("Something went wrong")
                return false;
            }
        }
        function checkEmail(){
            var email = document.getElementById("email").value;
            
            if(email){
                $.ajax({
                type: 'post',
                url: 'php/checkData.php',
                data: {
                    email: email,
                },
                success: function (data) {
                    $('#email-availability-status').html(data);
                }
                });
            }
            else{
                $('#email-availability-status').html("");
                console.log("Something went wrong")
                return false;
            }
        }
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="wrapper-content">
            <div class="title-wrapper">
                <h1>Account Creation</h1>
            </div>
            <form id="signup" action="#" method="post" enctype="multipart/form-data">
                <div class="timezone-wrapper">
                    <label for="imezone">Choose Your Timezone:</label>
                    <select id="timezone" name="timezone" class="form-select inputs" required>
                        <option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
                        <option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US & Canada)</option>
                        <option value="America/Denver">(GMT-07:00) Mountain Time (US & Canada)</option>
                        <option value="America/Dawson_Creek">(GMT-07:00) Arizona</option>
                        <option value="America/Chicago">(GMT-06:00) Central Time (US & Canada)</option>
                        <option value="America/New_York">(GMT-05:00) Eastern Time (US & Canada)</option>
                        <option value="America/Glace_Bay">(GMT-04:00) Atlantic Time (Canada)</option>
                        <option value="America/Adak">(GMT-10:00) Hawaii-Aleutian</option>
                        <option value="Etc/GMT+10">(GMT-10:00) Hawaii</option>
                        <option value="Pacific/Midway">(GMT-11:00) Midway Island</option>
                        <option value="Pacific/Marquesas">(GMT-09:30) Marquesas Islands</option>
                        <option value="Pacific/Gambier">(GMT-09:00) Gambier Islands</option>
                        <option value="America/Anchorage">(GMT-09:00) Alaska</option>
                        <option value="America/Ensenada">(GMT-08:00) Tijuana, Baja California</option>
                        <option value="Etc/GMT+8">(GMT-08:00) Pitcairn Islands</option>
                        <option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                        <option value="America/Belize">(GMT-06:00) Saskatchewan, Central America</option>
                        <option value="America/Cancun">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                        <option value="Chile/EasterIsland">(GMT-06:00) Easter Island</option>
                        <option value="America/Havana">(GMT-05:00) Cuba</option>
                        <option value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                        <option value="America/Caracas">(GMT-04:30) Caracas</option>
                        <option value="America/Santiago">(GMT-04:00) Santiago</option>
                        <option value="America/La_Paz">(GMT-04:00) La Paz</option>
                        <option value="Atlantic/Stanley">(GMT-04:00) Faukland Islands</option>
                        <option value="America/Campo_Grande">(GMT-04:00) Brazil</option>
                        <option value="America/Goose_Bay">(GMT-04:00) Atlantic Time (Goose Bay)</option>
                        <option value="America/St_Johns">(GMT-03:30) Newfoundland</option>
                        <option value="America/Araguaina">(GMT-03:00) UTC-3</option>
                        <option value="America/Montevideo">(GMT-03:00) Montevideo</option>
                        <option value="America/Miquelon">(GMT-03:00) Miquelon, St. Pierre</option>
                        <option value="America/Godthab">(GMT-03:00) Greenland</option>
                        <option value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires</option>
                        <option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
                        <option value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>
                        <option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
                        <option value="Atlantic/Azores">(GMT-01:00) Azores</option>
                        <option value="Europe/Belfast">(GMT) Greenwich Mean Time : Belfast</option>
                        <option value="Europe/Dublin">(GMT) Greenwich Mean Time : Dublin</option>
                        <option value="Europe/Lisbon">(GMT) Greenwich Mean Time : Lisbon</option>
                        <option value="Europe/London">(GMT) Greenwich Mean Time : London</option>
                        <option value="Africa/Abidjan">(GMT) Monrovia, Reykjavik</option>
                        <option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                        <option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                        <option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                        <option value="Africa/Algiers">(GMT+01:00) West Central Africa</option>
                        <option value="Africa/Windhoek">(GMT+01:00) Windhoek</option>
                        <option value="Asia/Beirut">(GMT+02:00) Beirut</option>
                        <option value="Africa/Cairo">(GMT+02:00) Cairo</option>
                        <option value="Asia/Gaza">(GMT+02:00) Gaza</option>
                        <option value="Africa/Blantyre">(GMT+02:00) Harare, Pretoria</option>
                        <option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
                        <option value="Europe/Minsk">(GMT+02:00) Minsk</option>
                        <option value="Asia/Damascus">(GMT+02:00) Syria</option>
                        <option value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                        <option value="Africa/Addis_Ababa">(GMT+03:00) Nairobi</option>
                        <option value="Asia/Tehran">(GMT+03:30) Tehran</option>
                        <option value="Asia/Dubai">(GMT+04:00) Abu Dhabi, Muscat</option>
                        <option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
                        <option value="Asia/Kabul">(GMT+04:30) Kabul</option>
                        <option value="Asia/Yekaterinburg">(GMT+05:00) Ekaterinburg</option>
                        <option value="Asia/Tashkent">(GMT+05:00) Tashkent</option>
                        <option value="Asia/Kolkata">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                        <option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
                        <option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
                        <option value="Asia/Novosibirsk">(GMT+06:00) Novosibirsk</option>
                        <option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
                        <option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                        <option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
                        <option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                        <option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
                        <option value="Australia/Perth">(GMT+08:00) Perth</option>
                        <option value="Australia/Eucla">(GMT+08:45) Eucla</option>
                        <option value="Asia/Seoul">(GMT+09:00) Seoul</option>
                        <option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
                        <option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
                        <option value="Australia/Darwin">(GMT+09:30) Darwin</option>
                        <option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
                        <option value="Australia/Hobart">(GMT+10:00) Hobart</option>
                        <option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
                        <option value="Australia/Lord_Howe">(GMT+10:30) Lord Howe Island</option>
                        <option value="Etc/GMT-11">(GMT+11:00) Solomon Is., New Caledonia</option>
                        <option value="Asia/Magadan">(GMT+11:00) Magadan</option>
                        <option value="Pacific/Norfolk">(GMT+11:30) Norfolk Island</option>
                        <option value="Asia/Anadyr">(GMT+12:00) Anadyr, Kamchatka</option>
                        <option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
                        <option value="Etc/GMT-12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                        <option value="Pacific/Chatham">(GMT+12:45) Chatham Islands</option>
                        <option value="Pacific/Tongatapu">(GMT+13:00) Nuku'alofa</option>
                        <option value="Pacific/Kiritimati">(GMT+14:00) Kiritimati</option>
                    </select>
                </div>

                <label class="labels">Email:</label>
                <input type="email"
                    name="email"
                    id="email"
                    class="inputs"
                    onchange="checkEmail();"
                    required>

                <span id="email-availability-status"></span>

                <label class="labels">Name/Nickname:</label>
                <input type="text"
                    name="username"
                    id="username"
                    class="inputs"
                    onchange="checkName();"
                    required>

                <span id="user-availability-status"></span>

                <label class="labels">Password:</label>
                <input type="password"
                    name="password"
                    id="password"
                    class="inputs"
                    required>

                <div class="span-wrapper">
                    <label class="labels">Retype Password:</label>
                    <span id="passwordError" class="error"></span>
                </div>

                <input type="password"
                    name="retypePassword"
                    id="retypePassword"
                    class="inputs"
                    required>

                <div class="checkbox-wrapper">
                    <label class="labels">Click to show password</label>
                    <input type="checkbox"
                        name="revealPass"
                        id="revealPass"
                        onclick="showPassword()">
                </div>

                <div class="upload-wrapper">
                    <label class="labels">Upload Profile Picture:</label>
                    <div class="profile-picture">
                        <h1 class="upload-icon">
                            <ion-icon name="add" aria-hidden="true"></ion-icon>
                        </h1>
                        <input
                            name="profilePicture"
                            class="file-uploader"
                            type="file"
                            onchange="upload()"
                            
                            value="">
                    </div>
                </div>

                <?php if ($_SESSION["createAccount"] === false): ?>
                    <em class="required">Please Fill Out All Fields</em>
                <?php endif; ?>

                <div class="button-wrapper">
                    <button type="submit" id="accountButton" class="inputs buttons">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <script>
            document.getElementById('signup').addEventListener('input', function () {
                validateForm();
            });
    
            function validateForm() {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('retypePassword').value;
                const errorElement = document.getElementById('passwordError');
    
                if (password !== confirmPassword) {
                    errorElement.textContent = 'Passwords must match';
                    errorElement.classList.remove('success');
                    errorElement.classList.add('error');
                } else {
                    errorElement.textContent = 'Passwords match';
                    errorElement.classList.remove('error');
                    errorElement.classList.add('success');
                }
            }
        </script>
</body>
</html>