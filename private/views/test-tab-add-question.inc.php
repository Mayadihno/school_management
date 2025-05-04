<?php
$type = ' Subjective';
if (isset($_GET['type']) && $_GET['type'] == 'objective') {
    $type = ' Objective';
} elseif (isset($_GET['type']) && $_GET['type'] == 'multiple') {
    $type = ' Multiple Choice';
}
?>
<center>
    <h5>Add <?= $type ?> Test Questions</h5>
</center>

<form method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="question" class="form-label">Question</label>
        <textarea placeholder="Enter Question" value="<?= get_value('question') ?>" class="form-control" id="question" name="question" rows="3"></textarea>

        <div class="input-group mb-3 pt-3">
            <label class="input-group-text " for="inputGroupFile01">Comment (Optional)</label>
            <input type="text" value="<?= get_value('comment') ?>" class="form-control" name="comment" placeholder="Comment" id="inputGroupFile01">
        </div>

    </div>

    <div class="input-group mb-3 pt-3">
        <label class="input-group-text" for="inputGroupFile01"><i class="fa fa-image pe-1"></i> Image</label>
        <input type="file" name="image" class="form-control" id="inputGroupFile01">
    </div>

    <?php if (isset($_GET['type']) && $_GET['type'] == 'objective'): ?>
        <div class="input-group mb-3 pt-3">
            <label class="input-group-text" for="inputGroupFile01">Answer</label>
            <input type="text" value="<?= get_value('correct_answer') ?>" name="correct_answer" class="form-control" id="inputGroupFile01" placeholder="Enter Answer">
        </div>
    <?php endif; ?>

    <input type="hidden" name="test_id" value="<?= $test->test_id ?>">
    <a href="<?= ROOT ?>single_test/<?= $test->id ?>?tab=view" class="btn btn-danger">Back</a>
    <button type="submit" class="btn btn-primary ms-5">Submit Question</button>

</form>