 <div class="w-100 table-responsive">
     <table class="table table-hover table-striped table-bordered text-center">
         <tr>
             <?php if (Auth::getRank() != 'student'): ?>
                 <th></th>
             <?php endif; ?>
             <th>Test Name</th>
             <th>Taken by</th>
             <th>Submitted Date</th>
             <th>Answered</th>
             <th></th>



         </tr>

         <?php if (isset($to_mark) && $to_mark) : ?>
             <?php foreach ($to_mark as $test) : ?>
                 <tr>
                     <?php if (Auth::access('lecturer')): ?>
                         <td>
                             <a href="<?= ROOT ?>mark_test/<?= $test->test_id ?>/<?= $test->user->user_id ?>">
                                 <button class="btn btn-primary btn-sm">Mark this test <i class="fa fa-chevron-right"></i></button>
                             </a>
                         </td>
                     <?php endif; ?>
                     <td><?= $test->test_details->test ?></td>
                     <td><?= $test->user->lastname ?> <?= $test->user->firstname ?> </td>
                     <td><?= get_date($test->submitted_date) ?></td>
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
                         <?php if (can_take_test($test->test_id)): ?>
                             <a href="<?= ROOT ?>take_test/<?= $test->id ?>">
                                 <button class="btn btn-sm btn-primary"><i class="fas fa-edit pe-2"></i>Take this test</button>
                             </a>
                         <?php endif; ?>


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