 <table class="table table-hover table-striped table-bordered text-center">
     <tr>
         <th></th>
         <th>Test Name</th>
         <th>Created by</th>
         <th>Date</th>

         <?php if (Auth::access('admin')): ?>
             <th>
                 <a href="<?= ROOT ?>tests/add">
                     <button class="btn btn-sm btn-primary"><i class="fas fa-plus pe-2"></i>Add New</button>
                 </a>
             </th>
         <?php endif; ?>
     </tr>

     <?php if (isset($tests) && $tests) : ?>
         <?php foreach ($tests as $test) : ?>
             <tr>
                 <td>
                     <a href="<?= ROOT ?>single_test/<?= $test->id ?>">
                         <button class="btn btn-primary btn-sm"><i class="fa fa-chevron-right"></i></button>
                     </a>
                 </td>
                 <td><?= $test->test ?></td>
                 <td><?= $test->user->lastname ?> <?= $test->user->firstname ?> </td>
                 <td><?= get_date($test->date) ?></td>
                 <td>
                     <?php if (Auth::access('lecturer')): ?>
                         <a href="<?= ROOT ?>tests/edit/<?= $test->id ?>">
                             <button class="btn btn-sm btn-primary"><i class="fas fa-edit pe-2"></i>Edit</button>
                         </a>
                         <a href="<?= ROOT ?>tests/delete/<?= $test->id ?>">
                             <button class="btn btn-sm btn-danger"><i class="fas fa-trash pe-2"></i>Delete</button>
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