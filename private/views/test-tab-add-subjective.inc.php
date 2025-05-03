<center>
    <h5>Add Subjective Test Questions</h5>
</center>

<form method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="question" class="form-label">Question</label>
        <textarea placeholder="Enter Question" class="form-control" id="question" name="question" rows="3"></textarea>
    </div>

    <div class="input-group mb-3 pt-3">
        <label class="input-group-text" for="inputGroupFile01"><i class="fa fa-image pe-1"></i> Image</label>
        <input type="file" name="image" class="form-control" id="inputGroupFile01">
    </div>

    <input type="hidden" name="test_id" value="<?= $test->test_id ?>">
    <a href="<?= ROOT ?>single_test/<?= $test->id ?>?tab=view" class="btn btn-danger">Back</a>
    <button type="submit" class="btn btn-primary ms-5">Submit Question</button>

</form>