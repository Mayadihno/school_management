<?php $percent = get_answer_percentage($test->id, Auth::getUser_id()); ?>

<div class=" container-fluid text-center mb-2">
    <div class="" style="color: <?= $percent > 50 ? 'green' : 'red' ?>"> <?= $percent ?>% Answered</div>
    <div class="bg-primary" style="height: 5px; width: <?= $percent ?>%"></div>
</div>
<nav class="navbar navbar-expand-lg d-flex justify-content-between navbar-light bg-light">
    <center class="">
        <h5>Take Test</h5>
    </center>
    <h5>Total Questions: <?= $total_questions ?></h5>
</nav>

<hr>

<?php if (isset($questions) && is_array($questions)) : ?>
    <form action="" method="post">

        <?php $num = 0; ?>


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



                        <input type="text" value="<?= $my_answer ?>" class="form-control" name="answer[<?= $question->id ?>]" placeholder="Your answer here">

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
                                            <input <?= $my_answer == $letter ? ' checked ' : '' ?> style="transform: scale(1.4);" type="radio" value="<?= $letter ?>" name="answer[<?= $question->id ?>]" required>
                                            <span class="ms-2"><?= $letter ?>: <?= $answer ?></span>
                                        </label>
                                    </li>
                                <?php endforeach; ?>

                            </ul>
                        </div>
                    <?php endif; ?>

                </div>
            </div>



        <?php endforeach; ?>
        <center>
            <small>Click save answer before moving to another page to save your answer</small> <br>
            <button class="btn btn-primary">Submit</button>
        </center>
    </form>
    <?php $pager->display() ?>
<?php else : ?>
    <div class="alert alert-danger" role="alert">
        No questions found for this test.
    </div>

<?php endif; ?>