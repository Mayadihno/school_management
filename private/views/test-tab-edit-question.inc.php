<?php if (is_object($quest)) :  ?>

    <center>
        <h5>Edit <?= ucfirst($quest->question_type) ?> Test Questions</h5>
    </center>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="question" class="form-label">Question</label>
            <textarea placeholder="Enter Question" class="form-control" id="question" name="question" rows="3"><?= get_value('question', $quest->question) ?>
        </textarea>

            <div class="input-group mb-3 pt-3">
                <label class="input-group-text " for="inputGroupFile01">Comment (Optional)</label>
                <input type="text" value="<?= get_value('comment', $quest->comment) ?>" class="form-control" name="comment" placeholder="Comment" id="inputGroupFile01">
            </div>

        </div>

        <div class="input-group mb-3 pt-3">
            <label class="input-group-text" for="inputGroupFile01"><i class="fa fa-image pe-1"></i> Image</label>
            <input type="file" name="image" class="form-control" id="inputGroupFile01">
        </div>

        <?php if (file_exists($quest->image)) : ?>
            <div class="input-group mb-3 pt-3">
                <label class="input-group-text" for="inputGroupFile01">Current Image</label>
                <img src="<?= ROOT . $quest->image ?>" class="img-fluid rounded-start w-50" alt="...">
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['type']) && $_GET['type'] == 'objective'): ?>
            <div class="input-group mb-3 pt-3">
                <label class="input-group-text" for="inputGroupFile01">Answer</label>
                <input type="text" value="<?= get_value('correct_answer', $quest->correct_answer) ?>" name="correct_answer" class="form-control" id="inputGroupFile01" placeholder="Enter Answer">
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['type']) && $_GET['type'] == 'multiple'): ?>
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    Multiple Choice Answers <button type="button" onclick="add_choice()" class="btn btn-sm btn-primary float-end"><i class="fa fa-plus"></i>Add Choices</button>
                </div>
                <ul class="list-group list-group-flush choice-list">
                    <?php if (isset($_POST['choice_a'])): ?>

                        <?php
                        //check for multiple choice answers
                        $num = 0;
                        $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
                        foreach ($_POST as $key => $value) {
                            // code...
                            if (strstr($key, 'choice')) {
                        ?>
                                <li class="list-group-item">
                                    <?= $letters[$num] ?> : <input type="text" class="form-control" value="<?= $value ?>" name="<?= $key ?>" placeholder="Type your answer here">
                                    <label style="cursor: pointer;"><input type="radio" <?= $letters[$num] == $_POST['correct_answer'] ? 'checked' : ''; ?> value="<?= $letters[$num] ?>" name="correct_answer"> Correct answer</label>
                                </li>
                        <?php
                                $num++;
                            }
                        }
                        ?>
                    <?php else: ?>

                        <?php $choices = json_decode($quest->choices); ?>
                        <?php foreach ($choices as $letter => $answer): ?>
                            <li class="list-group-item"><?= $letter ?>: <?= $answer ?>
                                <input type="text" class="form-control" value="<?= $answer ?>" name="<?= $letter ?>" placeholder="Type your answer here">
                                <label style="cursor: pointer;"><input type="radio" <?= $letter == $quest->correct_answer ? 'checked' : ''; ?> value="<?= $letter ?>" name="correct_answer"> Correct answer</label>
                            </li>
                        <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            </div>
        <?php endif; ?>

        <input type="hidden" name="test_id" value="<?= $test->test_id ?>">
        <a href="<?= ROOT ?>single_test/<?= $test->id ?>?tab=view" class="btn btn-danger">Back</a>
        <button type="submit" class="btn btn-primary ms-5">Submit Question</button>

    </form>
<?php else : ?>
    <div class="alert alert-danger text-center" role="alert">
        No question found for this test.
        <br>
        <a href="<?= ROOT ?>single_test/<?= $test->id ?>?tab=view" class="btn btn-danger mt-2">Back</a>
    </div>
<?php endif; ?>