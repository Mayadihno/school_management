<?php $percent = get_answer_percentage($test->id, Auth::getUser_id()); ?>

<div class=" container-fluid text-center mb-2">
    <div class="" style="color: <?= $percent > 50 ? 'green' : 'red' ?>"> <?= $percent ?>% Answered</div>
    <div class="bg-primary" style="height: 5px; width: <?= $percent ?>%"></div>

    <?php if ($submitted): ?>
        <div class="text-success pt-1">
            Test submitted successfully on <?= get_date2($answered_test_row->submitted_date) ?>
        </div>
    <?php else: ?>
        <div class="d-flex justify-content-between align-items-center mt-1">
            <span class="fw-bold text-danger">Test not submitted yet</span>
            <a href="<?= ROOT ?>take_test/<?= $test->id ?>?submit=true"
                data-bs-toggle="modal"
                data-bs-target="#submitTestModal"
                onclick="event.preventDefault(); document.getElementById('submitTestModalConfirm').setAttribute('href', this.href);">
                <button class="btn btn-primary"> Submit test</button>
            </a>
        </div>
    <?php endif; ?>



    <div class="modal fade" id="submitTestModal" tabindex="-1" aria-labelledby="submitTestModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="submitTestModalLabel">Confirm Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to submit the test? You won't be able to change your answers after submission.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <!-- This is the real submission link triggered after confirmation -->
                    <a id="submitTestModalConfirm" href="#" class="btn btn-primary">Yes, Submit</a>
                </div>
            </div>
        </div>
    </div>

</div>
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
            <?php $my_answer = get_answer($saved_ans, $question->id); ?>

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
                        <?php if ($submitted):   ?>
                            <input <?= $answered_test_row->submitted ? 'disabled' : '' ?> type="text" value="<?= $my_answer ?>" class="form-control" name="answer[<?= $question->id ?>]" placeholder="Your answer here">
                        <?php else: ?>
                            <input type="text" value="<?= $my_answer ?>" class="form-control" name="answer[<?= $question->id ?>]" placeholder="Your answer here">
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
                    <?php endif; ?>

                </div>
            </div>



        <?php endforeach; ?>
        <?php if (!$submitted): ?>
            <center>
                <small>Click save answer before moving to another page to save your answer</small> <br>
                <button class="btn btn-primary">Save Answer</button>
            </center>
        <?php endif; ?>
    </form>
    <?php $pager->display() ?>
<?php else : ?>
    <div class="alert alert-danger" role="alert">
        No questions found for this test.
    </div>

<?php endif; ?>