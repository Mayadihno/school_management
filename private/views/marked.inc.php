 <div class="w-100 table-responsive">
     <table class="table table-hover table-striped table-bordered text-center">
         <tr>
             <?php if (Auth::getRank() != 'student'): ?>
                 <th></th>
             <?php endif; ?>
             <th>Test Name</th>
             <th>Taken by</th>
             <th>Marked by</th>
             <th>Submitted Date</th>
             <th>Marked Date</th>
             <th>Answered</th>
             <th>Score</th>
             <th></th>



         </tr>

         <?php if (isset($marked) && $marked) : ?>
             <?php foreach ($marked as $test) : ?>
                 <tr>
                     <?php if (Auth::access('lecturer')): ?>
                         <td>
                             <a href="<?= ROOT ?>marked_single/<?= $test->test_details->id ?>/<?= $test->user->user_id ?>">
                                 <button class="btn btn-primary btn-sm">View test <i class="fa fa-chevron-right"></i></button>
                             </a>
                         </td>
                     <?php endif; ?>
                     <td><?= $test->test_details->test ?></td>
                     <td><?= $test->user->lastname ?> <?= $test->user->firstname ?> </td>
                     <td class="">
                         <?php
                            $user = new User();
                            $marked_by = $user->whereOne('user_id', $test->marked_by);
                            echo $marked_by->lastname . ' ' . $marked_by->firstname;
                            ?>
                     </td>
                     <td><?= get_date($test->submitted_date) ?></td>
                     <td><?= get_date($test->marked_date) ?></td>
                     <td>
                         <?php
                            $percent = get_answer_percentage($test->test_id, $test->user_id);
                            $percent_text = '';
                            if ($percent == 0) {
                                $percent_text = 'Not yet answered';
                            } else if ($percent == 100) {
                                $percent_text = 'Completed';
                            } else if ($percent < 100 && $percent > 0) {
                                $percent_text = 'Partially completed';
                            }
                            ?>
                         <?= $percent ?>% (<?= $percent_text ?>)
                     </td>
                     <td>
                         <?= $test_score = get_score_percentage($test->test_details->id, $test->user->user_id); ?> %
                     </td>
                     <td>
                         <a href="<?= ROOT ?>marked_single/<?= $test->test_details->id ?>/<?= $test->user->user_id ?>">
                             <button class="btn btn-primary btn-sm">View test <i class="fa fa-chevron-right"></i></button>
                         </a>

                     </td>



                 </tr>
             <?php endforeach; ?>
         <?php else : ?>
             <tr>
                 <td colspan="5">
                     <center class="alert alert-danger" role="alert">
                         No test found at this time
                     </center>
                 </td>
             </tr>
         <?php endif; ?>
     </table>
 </div>