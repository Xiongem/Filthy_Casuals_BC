<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$userID = $_POST["user_id"];

$sql = "SELECT * FROM users WHERE user_id = $userID";
    $result = $_SESSION["conn"]->query($sql);
    $user = $result->fetch_assoc();
        $username = $user["username"];
        $email = $user["email"];
        $timezone = $user["timezone"];
        $imageName = htmlspecialchars($user['pfpName']);
        $imageType = $user['pfpType'];
        $imageData = base64_encode($user['pfpData']); 
?>
<div class="settings-account-wrapper">
    <div class="settings-account-content">
        
        <div class="account-title-wrapper">
            <h1>Account</h1>
        </div>
        <form method="post" action="php/" enctype="multipart/form-data">
            <div class="pfp-wrapper">
                <?= '<img id="profilePic" src="data:$imageType;base64,' . base64_encode($user['pfpData']) . '" alt="$imageName">';?>
            </div>

            <div class="upload-wrapper">
                <label class="labels">Upload Profile Picture:</label>
               
                     <?= '<img class="profile-picture id="profilePic" src="data:$imageType;base64,' . base64_encode($user['pfpData']) . '" alt="$imageName">';?>
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

            <div class="username-wrapper">
                <label>Username:</label>
                <input type="text" 
                        name="username" 
                        id="username" 
                        class="inputs" 
                        onchange="checkName();"
                        value="<?=$username?>">
            </div>

            <span id="user-availability-status"></span>

            <div class="email-wrapper">
                <label>Email:</label>
                <input type="email" 
                        name="email" 
                        id="email" 
                        class="inputs" 
                        onchange="checkEmail();"
                        value="<?=$email?>">
            </div>

            <span id="email-availability-status"></span>

            <div class="timezone-wrapper">
                <label for="imezone">Choose Your Timezone:</label>
                <select id="timezone" name="timezone" class="form-select inputs" required>
                    <option value="Asia/Tokyo" <?php if($timezone == "Asia/Tokyo"){ ?>selected="selected"<?php } ?>>
                        (GMT+09:00) Osaka, Sapporo, Tokyo
                    </option>
                    <option value="America/Los_Angeles" <?php if($timezone == "America/Los_Angeles"){ ?>selected="selected"<?php } ?>>
                        (GMT-08:00) Pacific Time (US & Canada)
                    </option>
                    <option value="America/Denver" <?php if($timezone == "America/Denver"){ ?>selected="selected"<?php } ?>>
                        (GMT-07:00) Mountain Time (US & Canada)
                    </option>
                    <option value="America/Dawson_Creek" <?php if($timezone == "America/Dawson_Creek"){ ?>selected="selected"<?php } ?>>
                        (GMT-07:00) Arizona
                    </option>
                    <option value="America/Chicago" <?php if($timezone == "America/Chicago"){ ?>selected="selected"<?php } ?>>
                        (GMT-06:00) Central Time (US & Canada)
                    </option>
                    <option value="America/New_York" <?php if($timezone == "America/New_York"){ ?>selected="selected"<?php } ?>>
                        (GMT-05:00) Eastern Time (US & Canada)
                    </option>
                    <option value="America/Glace_Bay" <?php if($timezone == "America/Glace_Bay"){ ?>selected="selected"<?php } ?>>
                        (GMT-04:00) Atlantic Time (Canada)
                    </option>
                    <option value="America/Adak" <?php if($timezone == "America/Adak"){ ?>selected="selected"<?php } ?>>
                        (GMT-10:00) Hawaii-Aleutian
                    </option>
                    <option value="Etc/GMT+10" <?php if($timezone == "Etc/GMT+10"){ ?>selected="selected"<?php } ?>>
                        (GMT-10:00) Hawaii
                    </option>
                    <option value="Pacific/Midway" <?php if($timezone == "Pacific/Midway"){ ?>selected="selected"<?php } ?>>
                        (GMT-11:00) Midway Island
                    </option>
                    <option value="Pacific/Marquesas" <?php if($timezone == "Pacific/Marquesas"){ ?>selected="selected"<?php } ?>>
                        (GMT-09:30) Marquesas Islands
                    </option>
                    <option value="Pacific/Gambier" <?php if($timezone == "Pacific/Gambier"){ ?>selected="selected"<?php } ?>>
                        (GMT-09:00) Gambier Islands
                    </option>
                    <option value="America/Anchorage" <?php if($timezone == "America/Anchorage"){ ?>selected="selected"<?php } ?>>
                        (GMT-09:00) Alaska
                    </option>
                    <option value="America/Ensenada" <?php if($timezone == "America/Ensenada"){ ?>selected="selected"<?php } ?>>
                        (GMT-08:00) Tijuana, Baja California
                    </option>
                    <option value="Etc/GMT+8" <?php if($timezone == "Etc/GMT+8"){ ?>selected="selected"<?php } ?>>
                        (GMT-08:00) Pitcairn Islands
                    </option>
                    <option value="America/Chihuahua" <?php if($timezone == "America/Chihuahua"){ ?>selected="selected"<?php } ?>>
                        (GMT-07:00) Chihuahua, La Paz, Mazatlan
                    </option>
                    <option value="America/Belize" <?php if($timezone == "America/Belize"){ ?>selected="selected"<?php } ?>>
                        (GMT-06:00) Saskatchewan, Central America
                    </option>
                    <option value="America/Cancun" <?php if($timezone == "America/Cancun"){ ?>selected="selected"<?php } ?>>
                        (GMT-06:00) Guadalajara, Mexico City, Monterrey
                    </option>
                    <option value="Chile/EasterIsland" <?php if($timezone == "Chile/EasterIsland"){ ?>selected="selected"<?php } ?>>
                        (GMT-06:00) Easter Island
                    </option>
                    <option value="America/Havana" <?php if($timezone == "America/Havana"){ ?>selected="selected"<?php } ?>>
                        (GMT-05:00) Cuba
                    </option>
                    <option value="America/Bogota" <?php if($timezone == "America/Bogota"){ ?>selected="selected"<?php } ?>>
                        (GMT-05:00) Bogota, Lima, Quito, Rio Branco
                    </option>
                    <option value="America/Caracas" <?php if($timezone == "America/Caracas"){ ?>selected="selected"<?php } ?>>
                        (GMT-04:30) Caracas
                    </option>
                    <option value="America/Santiago" <?php if($timezone == "America/Santiago"){ ?>selected="selected"<?php } ?>>
                        (GMT-04:00) Santiago
                    </option>
                    <option value="America/La_Paz" <?php if($timezone == "America/La_Paz"){ ?>selected="selected"<?php } ?>>
                        (GMT-04:00) La Paz
                    </option>
                    <option value="Atlantic/Stanley" <?php if($timezone == "Atlantic/Stanley"){ ?>selected="selected"<?php } ?>>
                        (GMT-04:00) Faukland Islands
                    </option>
                    <option value="America/Campo_Grande" <?php if($timezone == "America/Campo_Grande"){ ?>selected="selected"<?php } ?>>
                        (GMT-04:00) Brazil
                    </option>
                    <option value="America/Goose_Bay" <?php if($timezone == "America/Goose_Bay"){ ?>selected="selected"<?php } ?>>
                        (GMT-04:00) Atlantic Time (Goose Bay)
                    </option>
                    <option value="America/St_Johns" <?php if($timezone == "America/St_Johns"){ ?>selected="selected"<?php } ?>>
                        (GMT-03:30) Newfoundland
                    </option>
                    <option value="America/Araguaina" <?php if($timezone == "America/Araguaina"){ ?>selected="selected"<?php } ?>>
                        (GMT-03:00) UTC-3
                    </option>
                    <option value="America/Montevideo" <?php if($timezone == "America/Montevideo"){ ?>selected="selected"<?php } ?>>
                        (GMT-03:00) Montevideo
                    </option>
                    <option value="America/Miquelon" <?php if($timezone == "America/Miquelon"){ ?>selected="selected"<?php } ?>>
                        (GMT-03:00) Miquelon, St. Pierre
                    </option>
                    <option value="America/Godthab" <?php if($timezone == "America/Godthab"){ ?>selected="selected"<?php } ?>>
                        (GMT-03:00) Greenland
                    </option>
                    <option value="America/Argentina/Buenos_Aires" <?php if($timezone == "America/Argentina/Buenos_Aires"){ ?>selected="selected"<?php } ?>>
                        (GMT-03:00) Buenos Aires
                    </option>
                    <option value="America/Sao_Paulo" <?php if($timezone == "America/Sao_Paulo"){ ?>selected="selected"<?php } ?>>
                        (GMT-03:00) Brasilia
                    </option>
                    <option value="America/Noronha" <?php if($timezone == "America/Noronha"){ ?>selected="selected"<?php } ?>>
                        (GMT-02:00) Mid-Atlantic
                    </option>
                    <option value="Atlantic/Cape_Verde" <?php if($timezone == "Atlantic/Cape_Verde"){ ?>selected="selected"<?php } ?>>
                        (GMT-01:00) Cape Verde Is.
                    </option>
                    <option value="Atlantic/Azores" <?php if($timezone == "Atlantic/Azores"){ ?>selected="selected"<?php } ?>>
                        (GMT-01:00) Azores
                    </option>
                    <option value="Europe/Belfast" <?php if($timezone == "Europe/Belfast"){ ?>selected="selected"<?php } ?>>
                        (GMT) Greenwich Mean Time : Belfast
                    </option>
                    <option value="Europe/Dublin" <?php if($timezone == "Europe/Dublin"){ ?>selected="selected"<?php } ?>>
                        (GMT) Greenwich Mean Time : Dublin
                    </option>
                    <option value="Europe/Lisbon" <?php if($timezone == "Europe/Lisbon"){ ?>selected="selected"<?php } ?>>
                        (GMT) Greenwich Mean Time : Lisbon
                    </option>
                    <option value="Europe/London" <?php if($timezone == "Europe/London"){ ?>selected="selected"<?php } ?>>
                        (GMT) Greenwich Mean Time : London
                    </option>
                    <option value="Africa/Abidjan" <?php if($timezone == "Africa/Abidjan"){ ?>selected="selected"<?php } ?>>
                        (GMT) Monrovia, Reykjavik
                    </option>
                    <option value="Europe/Amsterdam" <?php if($timezone == "Europe/Amsterdam"){ ?>selected="selected"<?php } ?>>
                        (GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna
                    </option>
                    <option value="Europe/Belgrade" <?php if($timezone == "Europe/Belgrade"){ ?>selected="selected"<?php } ?>>
                        (GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague
                    </option>
                    <option value="Europe/Brussels" <?php if($timezone == "Europe/Brussels"){ ?>selected="selected"<?php } ?>>
                        (GMT+01:00) Brussels, Copenhagen, Madrid, Paris
                    </option>
                    <option value="Africa/Algiers" <?php if($timezone == "Africa/Algiers"){ ?>selected="selected"<?php } ?>>
                        (GMT+01:00) West Central Africa</option>
                    <option value="Africa/Windhoek" <?php if($timezone == "Africa/Windhoek"){ ?>selected="selected"<?php } ?>>
                        (GMT+01:00) Windhoek
                    </option>
                    <option value="Asia/Beirut" <?php if($timezone == "Asia/Beirut"){ ?>selected="selected"<?php } ?>>
                        (GMT+02:00) Beirut
                    </option>
                    <option value="Africa/Cairo" <?php if($timezone == "Africa/Cairo"){ ?>selected="selected"<?php } ?>>
                        (GMT+02:00) Cairo
                    </option>
                    <option value="Asia/Gaza" <?php if($timezone == "Asia/Gaza"){ ?>selected="selected"<?php } ?>>
                        (GMT+02:00) Gaza
                    </option>
                    <option value="Africa/Blantyre" <?php if($timezone == "Africa/Blantyre"){ ?>selected="selected"<?php } ?>>
                        (GMT+02:00) Harare, Pretoria
                    </option>
                    <option value="Asia/Jerusalem" <?php if($timezone == "Asia/Jerusalem"){ ?>selected="selected"<?php } ?>>
                        (GMT+02:00) Jerusalem
                    </option>
                    <option value="Europe/Minsk" <?php if($timezone == "Europe/Minsk"){ ?>selected="selected"<?php } ?>>
                        (GMT+02:00) Minsk
                    </option>
                    <option value="Asia/Damascus" <?php if($timezone == "Asia/Damascus"){ ?>selected="selected"<?php } ?>>
                        (GMT+02:00) Syria
                    </option>
                    <option value="Europe/Moscow" <?php if($timezone == "Europe/Moscow"){ ?>selected="selected"<?php } ?>>
                        (GMT+03:00) Moscow, St. Petersburg, Volgograd
                    </option>
                    <option value="Africa/Addis_Ababa" <?php if($timezone == "Africa/Addis_Ababa"){ ?>selected="selected"<?php } ?>>
                        (GMT+03:00) Nairobi
                    </option>
                    <option value="Asia/Tehran" <?php if($timezone == "Asia/Tehran"){ ?>selected="selected"<?php } ?>>
                        (GMT+03:30) Tehran
                    </option>
                    <option value="Asia/Dubai" <?php if($timezone == "Asia/Dubai"){ ?>selected="selected"<?php } ?>>
                        (GMT+04:00) Abu Dhabi, Muscat
                    </option>
                    <option value="Asia/Yerevan" <?php if($timezone == "Asia/Yerevan"){ ?>selected="selected"<?php } ?>>
                        (GMT+04:00) Yerevan
                    </option>
                    <option value="Asia/Kabul" <?php if($timezone == "Asia/Kabul"){ ?>selected="selected"<?php } ?>>
                        (GMT+04:30) Kabul
                    </option>
                    <option value="Asia/Yekaterinburg" <?php if($timezone == "Asia/Yekaterinburg"){ ?>selected="selected"<?php } ?>>
                        (GMT+05:00) Ekaterinburg
                    </option>
                    <option value="Asia/Tashkent" <?php if($timezone == "Asia/Tashkent"){ ?>selected="selected"<?php } ?>>
                        (GMT+05:00) Tashkent
                    </option>
                    <option value="Asia/Kolkata" <?php if($timezone == "Asia/Kolkata"){ ?>selected="selected"<?php } ?>>
                        (GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi
                    </option>
                    <option value="Asia/Katmandu" <?php if($timezone == "Asia/Katmandu"){ ?>selected="selected"<?php } ?>>
                        (GMT+05:45) Kathmandu
                    </option>
                    <option value="Asia/Dhaka" <?php if($timezone == "Asia/Dhaka"){ ?>selected="selected"<?php } ?>>
                        (GMT+06:00) Astana, Dhaka
                    </option>
                    <option value="Asia/Novosibirsk" <?php if($timezone == "Asia/Novosibirsk"){ ?>selected="selected"<?php } ?>>
                        (GMT+06:00) Novosibirsk
                    </option>
                    <option value="Asia/Rangoon" <?php if($timezone == "Asia/Rangoon"){ ?>selected="selected"<?php } ?>>
                        (GMT+06:30) Yangon (Rangoon)
                    </option>
                    <option value="Asia/Bangkok" <?php if($timezone == "Asia/Bangkok"){ ?>selected="selected"<?php } ?>>
                        (GMT+07:00) Bangkok, Hanoi, Jakarta
                    </option>
                    <option value="Asia/Krasnoyarsk" <?php if($timezone == "Asia/Krasnoyarsk"){ ?>selected="selected"<?php } ?>>
                        (GMT+07:00) Krasnoyarsk
                    </option>
                    <option value="Asia/Hong_Kong" <?php if($timezone == "Asia/Hong_Kong"){ ?>selected="selected"<?php } ?>>
                        (GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi
                    </option>
                    <option value="Asia/Irkutsk" <?php if($timezone == "Asia/Irkutsk"){ ?>selected="selected"<?php } ?>>
                        (GMT+08:00) Irkutsk, Ulaan Bataar
                    </option>
                    <option value="Australia/Perth" <?php if($timezone == "Australia/Perth"){ ?>selected="selected"<?php } ?>>
                        (GMT+08:00) Perth
                    </option>
                    <option value="Australia/Eucla" <?php if($timezone == "Australia/Eucla"){ ?>selected="selected"<?php } ?>>
                        (GMT+08:45) Eucla
                    </option>
                    <option value="Asia/Seoul" <?php if($timezone == "Asia/Seoul"){ ?>selected="selected"<?php } ?>>
                        (GMT+09:00) Seoul
                    </option>
                    <option value="Asia/Yakutsk" <?php if($timezone == "Asia/Yakutsk"){ ?>selected="selected"<?php } ?>>
                        (GMT+09:00) Yakutsk
                    </option>
                    <option value="Australia/Adelaide" <?php if($timezone == "Australia/Adelaide"){ ?>selected="selected"<?php } ?>>
                        (GMT+09:30) Adelaide
                    </option>
                    <option value="Australia/Darwin" <?php if($timezone == "Australia/Darwin"){ ?>selected="selected"<?php } ?>>
                        (GMT+09:30) Darwin
                    </option>
                    <option value="Australia/Brisbane" <?php if($timezone == "Australia/Brisbane"){ ?>selected="selected"<?php } ?>>
                        (GMT+10:00) Brisbane
                    </option>
                    <option value="Australia/Hobart" <?php if($timezone == "Australia/Hobart"){ ?>selected="selected"<?php } ?>>
                        (GMT+10:00) Hobart
                    </option>
                    <option value="Asia/Vladivostok" <?php if($timezone == "Asia/Vladivostok"){ ?>selected="selected"<?php } ?>>
                        (GMT+10:00) Vladivostok
                    </option>
                    <option value="Australia/Lord_Howe" <?php if($timezone == "Australia/Lord_Howe"){ ?>selected="selected"<?php } ?>>
                        (GMT+10:30) Lord Howe Island
                    </option>
                    <option value="Etc/GMT-11" <?php if($timezone == "Etc/GMT-1"){ ?>selected="selected"<?php } ?>>
                        (GMT+11:00) Solomon Is., New Caledonia
                    </option>
                    <option value="Asia/Magadan" <?php if($timezone == "Asia/Magadan"){ ?>selected="selected"<?php } ?>>
                        (GMT+11:00) Magadan
                    </option>
                    <option value="Pacific/Norfolk" <?php if($timezone == "Pacific/Norfolk"){ ?>selected="selected"<?php } ?>>
                        (GMT+11:30) Norfolk Island
                    </option>
                    <option value="Asia/Anadyr" <?php if($timezone == "Asia/Anadyr"){ ?>selected="selected"<?php } ?>>
                        (GMT+12:00) Anadyr, Kamchatka
                    </option>
                    <option value="Pacific/Auckland" <?php if($timezone == "Pacific/Auckland"){ ?>selected="selected"<?php } ?>>
                        (GMT+12:00) Auckland, Wellington
                    </option>
                    <option value="Etc/GMT-12" <?php if($timezone == "Etc/GMT-12"){ ?>selected="selected"<?php } ?>>
                        (GMT+12:00) Fiji, Kamchatka, Marshall Is.
                    </option>
                    <option value="Pacific/Chatham" <?php if($timezone == "Pacific/Chatham"){ ?>selected="selected"<?php } ?>>
                        (GMT+12:45) Chatham Islands
                    </option>
                    <option value="Pacific/Tongatapu" <?php if($timezone == "Pacific/Tongatapu"){ ?>selected="selected"<?php } ?>>
                        (GMT+13:00) Nuku'alofa
                    </option>
                    <option value="Pacific/Kiritimati" <?php if($timezone == "Pacific/Kiritimati"){ ?>selected="selected"<?php } ?>>
                        (GMT+14:00) Kiritimati
                    </option>
                </select>
            </div>

            <div class="reset-wrapper">
                <a href="#">Reset Password</a>
            </div>

            <div class="button-wrapper">
                <button type="submit" id="accountButton" class="buttons">Submit</button>
            </div>
        </form>
    </div>
</div>