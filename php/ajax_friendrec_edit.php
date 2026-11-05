<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$userID = $_POST['userID'];

?>

<form class="rec-form" id="recForm" method="post" action="php/process-friendRecEdit.php">
    <input type="hidden" name="userID" value="<?=$userID?>">
    <div class="rec-form-title">
        <h2>Update Friend Recommendations</h2>
    </div>
    <div class="rec-form-inputs">
        <div class="rec-row">
            <h3>1.</h3>
            <div class="rec-item">
                <label for="rec1Title">Title:</label>
                <input type="text" name="rec1Title" id="rec1Title" value="">
            </div>
            <div class="rec-item">
                <label for="rec1Author">Author:</label>
                <input type="text" name="rec1Author" id="rec1Author" value="">
            </div>
        </div>
        <div class="rec-row">
            <h3>2.</h3>
            <div class="rec-item">
                <label for="rec2Title">Title:</label>
                <input type="text" name="rec2Title" id="rec2Title" value="">
            </div>
            <div class="rec-item">
                <label for="rec2Author">Author:</label>
                <input type="text" name="rec2Author" id="rec2Author" value="">
            </div>
        </div>
        <div class="rec-row">
            <h3>3.</h3>
            <div class="rec-item">
                <label for="rec3Title">Title:</label>
                <input type="text" name="rec3Title" id="rec3Title" value="">
            </div>
            <div class="rec-item">
                <label for="rec3Author">Author:</label>
                <input type="text" name="rec3Author" id="rec3Author" value="">
            </div>
        </div>
        <div class="rec-row">
            <h3>4.</h3>
            <div class="rec-item">
                <label for="rec4Title">Title:</label>
                <input type="text" name="rec4Title" id="rec4Title" value="">
            </div>
            <div class="rec-item">
                <label for="rec4Author">Author:</label>
                <input type="text" name="rec4Author" id="rec4Author" value="">
            </div>
        </div>
        <div class="rec-row">
            <h3>5.</h3>
            <div class="rec-item">
                <label for="rec5Title">Title:</label>
                <input type="text" name="rec5Title" id="rec5Title" value="">
            </div>
            <div class="rec-item">
                <label for="rec5Author">Author:</label>
                <input type="text" name="rec5Author" id="rec5Author" value="">
            </div>
        </div>
    </div>
    <div class="rec-form-submit button-wrapper">
        <button class="button" type="submit" value="Submit">Submit</button>
    </div>
</form>