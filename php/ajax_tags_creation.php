<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$newTag = $_POST['tag'];
$tagName = $_POST['tag'];

$newTag = preg_replace('/\s+/', '_', $newTag);

    $htmlContent = <<<HTML
        <div class="notch-arrow" id="$newTag" onclick="removeTag($newTag)">
            <p class='tag-content' id='tagContent'>$tagName</p>
            <input type="hidden" name="tag[$newTag]" id="tag_$newTag" value="$newTag">
        </div>
    HTML;
        echo $htmlContent;
