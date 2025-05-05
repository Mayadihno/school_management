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
    <?php if (count($errors) > 0): ?>
        <div class="alert alert-warning alert-dismissible fade show p-1" role="alert">
            <strong>Errors:</strong>
            <?php foreach ($errors as $error): ?>
                <br><?= $error ?>
            <?php endforeach; ?>
            <span type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </span>
        </div>
    <?php endif; ?>

    <div class="mb-3">
        <label for="question" class="form-label">Question</label>
        <textarea placeholder="Enter Question" class="form-control" id="question" name="question" rows="3"><?= get_value('question') ?></textarea>

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
                    <li class="list-group-item">A:
                        <input type="text" name="choice_a" class="form-control" placeholder="Enter Answer A">
                        <label for="a">
                            <input type="radio" name="correct_answer" value="A" id="a"> Correct Answer
                        </label>
                    </li>
                    <li class="list-group-item">B:
                        <input type="text" name="choice_b" class="form-control" placeholder="Enter Answer B">
                        <label for="b">
                            <input type="radio" name="correct_answer" value="B" id="b"> Correct Answer
                        </label>
                    </li>
            </ul>
        <?php endif; ?>
        </div>
    <?php endif; ?>


    <a href="<?= ROOT ?>single_test/<?= $test->id ?>?tab=view" class="btn btn-danger">Back</a>
    <button type="submit" class="btn btn-primary ms-5">Submit Question</button>

</form>

<script>
    let letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

    function add_choice() {
        var choice = document.querySelector('.choice-list');
        if (choice.children.length >= 25) {
            alert('You can only add a maximum of 25 choices.');
            return;
        }
        choice.innerHTML += `<li class="list-group-item">${letters[choice.children.length]}:
            <input type="text" name="choice_${letters[choice.children.length].toLowerCase()}" id="" class="form-control" placeholder="Enter Answer ${letters[choice.children.length]}">
            <input type="radio" name="correct_answer" value="${letters[choice.children.length]}"" id=""> Correct Answer
        </li>`;


    }
</script>