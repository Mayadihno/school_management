  <?php if ($test->disabled): ?>
      <nav class="navbar navbar-expand-lg d-flex justify-content-between navbar-light bg-light">
          <center class="">
              <h5>Add Test Questions</h5>
          </center>
          <h5>Total Questions: <?= $total_questions ?></h5>
          <div class="btn-group">
              <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class='fa fa-bars'></i> Add
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href="<?= ROOT ?>single_test/addquestion/<?= $test->test_id ?>?type=multiple">Add Multiple Choice Question</a></li>
                  <li>
                      <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="<?= ROOT ?>single_test/addquestion/<?= $test->test_id ?>?type=objective">Add Objective Question</a></li>
                  <li>
                      <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="<?= ROOT ?>single_test/addquestion/<?= $test->test_id ?>">Add Subjective Question</a></li>
              </ul>
          </div>
      </nav>

      <hr>
  <?php endif; ?>

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
                  <?php $type  = '' ?>
                  <?php if ($question->question_type == 'objective') : $type = '?type=objective' ?>
                      <p class="card-text"><strong>Answer:</strong> <?= esc($question->correct_answer) ?></p>
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
                                  <li class="list-group-item"><?= $letter ?>: <?= $answer ?>

                                      <?php if (trim($letter) == trim($question->correct_answer)): ?>
                                          <i class="fa fa-check float-end"></i>
                                      <?php endif; ?>

                                  </li>
                              <?php endforeach; ?>

                          </ul>
                      </div>
                      <br>
                      <p class="card-text"><b>Answer:</b> <?= esc($question->correct_answer) ?></p>
                  <?php endif; ?>

              </div>
              <div class="card-footer text-body-secondary justify-content-between d-flex align-items-center">
                  <?= get_date2($question->date) ?>
                  <?php if ($test->editable): ?>
                      <div class="float-end">
                          <a href="<?= ROOT ?>single_test/editquestion/<?= $test->test_id ?>/<?= $question->id ?><?= $type ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit pe-2"></i>Edit</a>
                          <a href="<?= ROOT ?>single_test/deletequestion/<?= $test->test_id ?>/<?= $question->id ?><?= $type ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash pe-2"></i>Delete</a>
                      </div>
                  <?php endif; ?>
              </div>
          </div>

      <?php endforeach; ?>

  <?php else : ?>
      <div class="alert alert-danger" role="alert">
          No questions found for this test.
      </div>
  <?php endif; ?>