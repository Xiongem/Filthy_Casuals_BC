  <div class="row">
                    <div class="table-item"> <?= htmlspecialchars($title) ?> </div>
                    <div class="table-item"> <?= htmlspecialchars($author) ?> </div>
                    <div class="table-item"> <?= htmlspecialchars($startedDate) ?> </div>
                    <div class="table-item"> <?= htmlspecialchars($finishedDate) ?></div>
                    <div class="table-item"> <?= htmlspecialchars($pages) ?> </div>
                    <div class="table-item"> <?= $ongoingChecked ?> </div>
                    <div class="table-item"> <?= htmlspecialchars($comment) ?> </div>
                    <div class="table-item"> <?= htmlspecialchars($month) ?> </div>
                    <div class="table-item"> <?= htmlspecialchars($totalPoints) ?> </div>
                </div>
                <div class="notch-wrapper" id="notchWrapper">
                    <?php if (isset($readHistory['tags'])) { ?>
                        <?php foreach ($tags as $key => $value) { ?>
                            <div class="notch-arrow" id="<?= htmlspecialchars($value) ?>" onclick="removeTag(<?= htmlspecialchars($value) ?>)">
                                <p class='tag-content' id='tagContent'><?= htmlspecialchars($value) ?></p>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>