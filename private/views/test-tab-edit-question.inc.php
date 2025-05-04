<?php if (is_object($quest)) : ?>
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