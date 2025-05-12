<?php
// $percent = get_answer_percentage($test->id, $user_id);
$mark_percent = get_mark_percentage($test->id, $user_id);


?>

<div class=" container-fluid text-center mb-2">
    <div class="" style="color: <?= $mark_percent > 50 ? 'green' : 'red' ?>"> <?= $mark_percent ?>% Marked</div>
    <div class="bg-primary" style="height: 5px; width: <?= $mark_percent ?>%"></div>

    <?php if ($submitted && !$marked): ?>
        <div class="text-success pt-1 d-flex justify-content-between align-items-center">
            Test submitted successfully on <?= get_date2($answered_test_row->submitted_date) ?>

            <div class="">
                <a href="<?= ROOT ?>mark_test/<?= $test->id ?>/<?= $user_id ?>?unsubmit=true"
                    data-bs-toggle="modal"
                    data-bs-target="#unsubmitTestModal"
                    onclick="event.preventDefault(); document.getElementById('unsubmitTestModalConfirm').setAttribute('href', this.href);">
                    <button class="btn btn-primary btn-sm">Unsubmit test</button>
                </a>
                <a href="<?= ROOT ?>mark_test/<?= $test->id ?>/<?= $user_id ?>?auto_mark=true"
                    data-bs-toggle="modal"
                    data-bs-target="#automarkTestModal"
                    onclick="event.preventDefault(); document.getElementById('automarkTestModalConfirm').setAttribute('href', this.href);">
                    <button class="btn btn-secondary btn-sm">Auto Mark test</button>
                </a>
                <a onclick="show_loader(event)" href="<?= ROOT ?>mark_test/<?= $test->id ?>/<?= $user_id ?>?set_as_mark=true"
                    <button class="btn btn-success btn-sm">Set Test as marked</button>
                </a>
            </div>

        </div>
    <?php endif; ?>



    <div class="modal fade" id="automarkTestModal" tabindex="-1" aria-labelledby="submitTestModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="submitTestModalLabel">Confirm Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to auto mark this test?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <!-- This is the real submission link triggered after confirmation -->
                    <a id="automarkTestModalConfirm" href="#" class="btn btn-primary">Yes, Auto Mark</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="unsubmitTestModal" tabindex="-1" aria-labelledby="submitTestModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="submitTestModalLabel">Confirm Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to unsubmit this test?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <!-- This is the real submission link triggered after confirmation -->
                    <a id="unsubmitTestModalConfirm" href="#" class="btn btn-primary">Yes, Unsubmit</a>
                </div>
            </div>
        </div>
    </div>

</div>

<?php if ($marked) : ?>
    <?php $test_score = get_score_percentage($test->id, $user_id); ?>
    <center>
        <?php if ($test_score > 50) : ?>
            <h5 class="text-success">Test score: <span class='fs-1'><?= $test_score ?>%</span></h5>
        <?php else : ?>
            <h5 class="text-danger">Test score: <span class='fs-1'><?= $test_score ?>%</span></h5>
        <?php endif; ?>
    </center>

<?php endif; ?>
<nav class="navbar navbar-expand-lg d-flex justify-content-between navbar-light bg-light">
    <center class="">
        <h5>Take Test</h5>
    </center>
    <h5>Total Questions: <?= $total_questions ?></h5>
</nav>

<hr>

<?php if (isset($questions) && is_array($questions)) : ?>
    <form method="post">

        <?php $num = $pager->offset; ?>


        <?php foreach ($questions as $question) : $num++; ?>
            <?php
            $my_answer = get_answer($saved_ans, $question->id);
            $my_mark = get_answer_mark($saved_ans, $question->id);
            ?>

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
                    <?php $type  = '' ?>
                    <?php if ($question->question_type != 'multiple') : ?>
                        <input type="text" value="<?= $my_answer ?>" disabled class="form-control" name="answer[<?= $question->id ?>]" placeholder="Your answer here">
                        <hr>
                        <h3>Teacher's Mark</h3>
                        <?php if (!$marked): ?>
                            <div class="form-check">
                                <input <?= $my_mark == 1 ? ' checked ' : '' ?> class="form-check-input" value="1" type="radio" name="<?= $question->id ?>" id="radioDefaultcorrect<?= $num ?>">
                                <label class="form-check-label" for="radioDefaultcorrect<?= $num ?>">
                                    Correct
                                </label>
                            </div>
                            <div class="form-check">
                                <input <?= $my_mark == 2 ? ' checked ' : '' ?> class="form-check-input" value="2" type="radio" name="<?= $question->id ?>" id="radioDefaultwrong<?= $num ?>">
                                <label class="form-check-label" for="radioDefaultwrong<?= $num ?>">
                                    Wrong
                                </label>
                            </div>
                        <?php else: ?>
                            <?php if ($my_mark == 1): ?>
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <span class="text-success">Correct</span>
                                    <i class="fa fa-check fs-1"></i>
                                </div>
                            <?php else: ?>
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <span class="text-danger">Wrong</span>
                                    <i class="fa-solid fa-xmark fs-1"></i>

                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>



                    <?php if ($question->question_type == 'multiple'):
                        $type = '?type=multiple';
                    ?>

                        <div class="card" style="width: 18rem;">
                            <div class="card-header">
                                Multiple choice
                            </div>
                            <ul class="list-group list-group-flush">

                                <?php $choices = json_decode($question->choices); ?>
                                <?php foreach ($choices as $letter => $answer): ?>
                                    <li class="list-group-item">
                                        <label style="cursor: pointer;" class="d-flex align-items-center">
                                            <?php if (!$submitted): ?>
                                                <input <?= $my_answer == $letter ? ' checked ' : '' ?> style="transform: scale(1.4);" type="radio" value="<?= $letter ?>" name="answer[<?= $question->id ?>]">
                                                <span class="ms-2"><?= $letter ?>: <?= $answer ?></span>
                                            <?php else: ?>
                                                <?php if ($my_answer == $letter): ?>
                                                    <div class="d-flex justify-content-between align-items-center w-100">
                                                        <span class="text-success"><?= $letter ?>: <?= $answer ?></span>
                                                        <i class="fa fa-check"></i>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-danger"><?= $letter ?>: <?= $answer ?></span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </label>

                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <hr>
                        <h3>Teacher's Mark</h3>
                        <?php if (!$marked): ?>
                            <div class="form-check">
                                <input <?= $my_mark == 1 ? ' checked ' : '' ?> class="form-check-input" value="1" type="radio" name="<?= $question->id ?>" id="radioDefaultcorrect<?= $num ?>">
                                <label class="form-check-label" for="radioDefaultcorrect<?= $num ?>">
                                    Correct
                                </label>
                            </div>
                            <div class="form-check">
                                <input <?= $my_mark == 2 ? ' checked ' : '' ?> class="form-check-input" value="2" type="radio" name="<?= $question->id ?>" id="radioDefaultwrong<?= $num ?>">
                                <label class="form-check-label" for="radioDefaultwrong<?= $num ?>">
                                    Wrong
                                </label>
                            </div>
                        <?php else: ?>
                            <?php if ($my_mark == 1): ?>
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <span class="text-success">Correct</span>
                                    <i class="fa fa-check fs-1"></i>
                                </div>
                            <?php else: ?>
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <span class="text-danger">Wrong</span>
                                    <i class="fa-solid fa-xmark fs-1"></i>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>

                </div>
            </div>



        <?php endforeach; ?>
        <?php if (!$marked): ?>
            <center>
                <small>Click save marks before moving to another page</small> <br>
                <button class="btn btn-primary">Save Marks</button>
            </center>
        <?php endif; ?>
    </form>
    <?php $pager->display() ?>
<?php else : ?>
    <div class="alert alert-danger" role="alert">
        No questions found for this test.
    </div>

<?php endif; ?>

<script>
    function show_loader(e) {
        var percent = <?= $mark_percent ?>;
        if (percent < 100) {
            e.preventDefault();
            alert("Please mark all questions before submitting");

        }

    }
</script>