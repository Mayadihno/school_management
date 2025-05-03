<nav class="navbar navbar-expand-lg d-flex justify-content-between navbar-light bg-light">
    <center class="">
        <h5>Test Questions</h5>
    </center>
    <h5>Total Questions: <?= $total_questions ?></h5>
    <div class="btn-group">
        <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <i class='fa fa-bars'></i> Add
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="<?= ROOT ?>single_test/addmultiple/<?= $test->test_id ?>">Add Multiple Choice Question</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="<?= ROOT ?>single_test/addsubjective/<?= $test->test_id ?>?type=objective">Add Objective Question</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="<?= ROOT ?>single_test/addsubjective/<?= $test->test_id ?>">Add Subjective Question</a></li>
        </ul>
    </div>
</nav>

<hr>

<?php if (isset($questions) && is_array($questions)) : ?>

    <?php $num = ($total_questions + 1); ?>


    <?php foreach ($questions as $question) : $num--; ?>

        <div class="card mb-4">
            <div class="card-header">
                <span class="badge bg-primary p-2"> Question number #<?= $num ?></span>
            </div>
            <div class="card-body">
                <h5 class="card-title"><?= ucfirst($question->question_type) ?> | <span class="fs-6 text-muted"><?= $question->comment ?></span> </h5>
                <p class="card-text"><?= esc($question->question) ?></p>
                <?php if ($question->image) : ?>
                    <img src="<?= ROOT . $question->image ?>" class="img-fluid rounded-start w-50" alt="...">
                <?php endif; ?>
            </div>
            <div class="card-footer text-body-secondary">
                <?= get_date2($question->date) ?> <br>
                <div class="float-end mt-2">
                    <a href="<?= ROOT ?>single_test/editquestion/<?= $question->id ?>/<?= $test->test_id ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit pe-2"></i>Edit</a>
                    <a href="<?= ROOT ?>single_test/deletequestion/<?= $question->id ?>/<?= $test->test_id ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash pe-2"></i>Delete</a>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

<?php else : ?>
    <div class="alert alert-danger" role="alert">
        No questions found for this test.
    </div>
<?php endif; ?>