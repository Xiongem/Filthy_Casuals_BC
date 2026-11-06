<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', '/path/to/php_errors.log');

ob_start();
require($_SERVER['DOCUMENT_ROOT'] . '/php/utilities.php');
dbConnect();

$userID = $_POST['userID'];
$sql = "SELECT * FROM `friendRecs` WHERE `user_id` = '$userID'";
    $result = $_SESSION["conn"]->query($sql);
    $rec = $result->fetch_assoc();
        if (isset($rec)) {
            $rec1Title = $rec["rec1_title"];
            $rec2Title = $rec["rec2_title"];
            $rec3Title = $rec["rec3_title"];
            $rec4Title = $rec["rec4_title"];
            $rec5Title = $rec["rec5_title"];
            $rec1Author = $rec["rec1_author"];
            $rec2Author = $rec["rec2_author"];
            $rec3Author = $rec["rec3_author"];
            $rec4Author = $rec["rec4_author"];
            $rec5Author = $rec["rec5_author"];
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
                            <input type="text" class="inputs" name="rec1Title" id="rec1Title" value="<?=$rec1Title?>">
                        </div>
                        <div class="rec-item">
                            <label for="rec1Author">Author:</label>
                            <input type="text" class="inputs" name="rec1Author" id="rec1Author" value="<?=$rec1Author?>">
                        </div>
                    </div>
                    <div class="rec-row">
                        <h3>2.</h3>
                        <div class="rec-item">
                            <label for="rec2Title">Title:</label>
                            <input type="text" class="inputs" name="rec2Title" id="rec2Title" value="<?=$rec2Title?>">
                        </div>
                        <div class="rec-item">
                            <label for="rec2Author">Author:</label>
                            <input type="text" class="inputs" name="rec2Author" id="rec2Author" value="<?=$rec2Author?>">
                        </div>
                    </div>
                    <div class="rec-row">
                        <h3>3.</h3>
                        <div class="rec-item">
                            <label for="rec3Title">Title:</label>
                            <input type="text" class="inputs" name="rec3Title" id="rec3Title" value="<?=$rec3Title?>">
                        </div>
                        <div class="rec-item">
                            <label for="rec3Author">Author:</label>
                            <input type="text" class="inputs" name="rec3Author" id="rec3Author" value="<?=$rec3Author?>">
                        </div>
                    </div>
                    <div class="rec-row">
                        <h3>4.</h3>
                        <div class="rec-item">
                            <label for="rec4Title">Title:</label>
                            <input type="text" class="inputs" name="rec4Title" id="rec4Title" value="<?=$rec4Title?>">
                        </div>
                        <div class="rec-item">
                            <label for="rec4Author">Author:</label>
                            <input type="text" class="inputs" name="rec4Author" id="rec4Author" value="<?=$rec4Author?>">
                        </div>
                    </div>
                    <div class="rec-row">
                        <h3>5.</h3>
                        <div class="rec-item">
                            <label for="rec5Title">Title:</label>
                            <input type="text" class="inputs" name="rec5Title" id="rec5Title" value="<?=$rec5Title?>">
                        </div>
                        <div class="rec-item">
                            <label for="rec5Author">Author:</label>
                            <input type="text" class="inputs" name="rec5Author" id="rec5Author" value="<?=$rec5Author?>">
                        </div>
                    </div>
                </div>
                <div class="rec-form-submit button-wrapper">
                    <button class="buttons" type="submit" value="Submit">Submit</button>
                </div>
            </form>
        <?php } else { ?>
            <form class="rec-form" id="recForm" method="post" action="php/process-friendRecAdd.php">
                <input type="hidden" name="userID" value="<?=$userID?>">
                <div class="rec-form-title">
                    <h2>Update Friend Recommendations</h2>
                </div>
                <div class="rec-form-inputs">
                    <div class="rec-row">
                        <h3>1.</h3>
                        <div class="rec-item">
                            <label for="rec1Title">Title:</label>
                            <input type="text" class="inputs" name="rec1Title" id="rec1Title">
                        </div>
                        <div class="rec-item">
                            <label for="rec1Author">Author:</label>
                            <input type="text" class="inputs" name="rec1Author" id="rec1Author">
                        </div>
                    </div>
                    <div class="rec-row">
                        <h3>2.</h3>
                        <div class="rec-item">
                            <label for="rec2Title">Title:</label>
                            <input type="text" class="inputs" name="rec2Title" id="rec2Title">
                        </div>
                        <div class="rec-item">
                            <label for="rec2Author">Author:</label>
                            <input type="text" class="inputs" name="rec2Author" id="rec2Author">
                        </div>
                    </div>
                    <div class="rec-row">
                        <h3>3.</h3>
                        <div class="rec-item">
                            <label for="rec3Title">Title:</label>
                            <input type="text" class="inputs" name="rec3Title" id="rec3Title">
                        </div>
                        <div class="rec-item">
                            <label for="rec3Author">Author:</label>
                            <input type="text" class="inputs" name="rec3Author" id="rec3Author">
                        </div>
                    </div>
                    <div class="rec-row">
                        <h3>4.</h3>
                        <div class="rec-item">
                            <label for="rec4Title">Title:</label>
                            <input type="text" class="inputs" name="rec4Title" id="rec4Title">
                        </div>
                        <div class="rec-item">
                            <label for="rec4Author">Author:</label>
                            <input type="text" class="inputs" name="rec4Author" id="rec4Author">
                        </div>
                    </div>
                    <div class="rec-row">
                        <h3>5.</h3>
                        <div class="rec-item">
                            <label for="rec5Title">Title:</label>
                            <input type="text" class="inputs" name="rec5Title" id="rec5Title">
                        </div>
                        <div class="rec-item">
                            <label for="rec5Author">Author:</label>
                            <input type="text" class="inputs" name="rec5Author" id="rec5Author">
                        </div>
                    </div>
                </div>
                <div class="rec-form-submit button-wrapper">
                    <button class="buttons" type="submit" value="Submit">Submit</button>
                </div>
            </form>
        <?php } ?>