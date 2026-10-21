<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$newTag = $_POST['searchResult'];


    $htmlContent = <<<HTML
        <div class="notch-arrow" id="$newTag">
            <p class='tag-content' id='tagContent'>$newTag</p>
        </div>
    HTML;
        echo $htmlContent;
