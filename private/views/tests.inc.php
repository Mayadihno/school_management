 <div class="w-100 table-responsive">
     <table class="table table-hover table-striped table-bordered text-center">
         <tr>
             <?php if (Auth::getRank() != 'student'): ?>
                 <th></th>
             <?php endif; ?>
             <th>Test Name</th>
             <th>Created by</th>
             <th>Active</th>
             <th>Date</th>
             <th>Answered</th>
             <th></th>



         </tr>

         <?php if (isset($tests) && $tests) : ?>
             <?php foreach ($tests as $test) : ?>
                 <tr>
                     <?php if (Auth::access('lecturer')): ?>
                         <td>
                             <a href="<?= ROOT ?>single_test/<?= $test->id ?>">
                                 <button class="btn btn-primary btn-sm"><i class="fa fa-chevron-right"></i></button>
                             </a>
                         </td>
                     <?php endif; ?>
                     <td><?= $test->test ?></td>
                     <td><?= $test->user->lastname ?> <?= $test->user->firstname ?> </td>
                     <td><?= $test->disabled == 0 ? 'Yes' : 'No' ?></td>
                     <td><?= get_date($test->date) ?></td>
                     <td>
                         <?php

                            $myId = $this::class == 'Profile' ? $user->user_id : Auth::getUser_id();
                            $percent = get_answer_percentage($test->id, $myId);
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

                     <?php if (Auth::access('lecturer')): ?>
                         <td>
                             <a href="<?= ROOT ?>single_class/testedit/<?= $test->class_id ?>/<?= $test->test_id ?>?tab=tests">
                                 <button class="btn btn-sm btn-primary"><i class="fas fa-edit pe-2"></i>Edit</button>
                             </a>
                             <a href="<?= ROOT ?>single_class/testdelete/<?= $test->class_id ?>/<?= $test->test_id ?>?tab=tests">
                                 <button class="btn btn-sm btn-danger"><i class="fas fa-trash pe-2"></i>Delete</button>
                             </a>
                         </td>
                     <?php endif; ?>

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