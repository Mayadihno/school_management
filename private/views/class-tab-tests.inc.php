 <nav class="navbar bg-body-tertiary d-flex justify-content-between align-items-center">
     <form class=" container-fluid" style="width: 90%;">
         <div class=" input-group">
             <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
             <input type="text" class="form-control" placeholder="Serach" aria-label="Search" aria-describedby="basic-addon1">
         </div>
     </form>
     <a href="<?= ROOT ?>single_class/testadd/<?= $class->id ?>?tab=test-add">
         <button class="btn btn-sm btn-primary"><i class="fas fa-plus pe-2"></i>Add Test</button>
     </a>
 </nav>

 <table class="table table-hover table-striped table-bordered text-center">
     <tr>
         <th></th>
         <th>Test Name</th>
         <th>Created by</th>
         <th>Active</th>
         <th>Date</th>

         <?php if (Auth::access('lecturer')): ?>
             <th>
                 <a href="<?= ROOT ?>single_class/testadd/<?= $class->id ?>?tab=test-add">
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
                 <td><?= $test->disabled == 0 ? 'Yes' : 'No' ?></td>
                 <td><?= get_date($test->date) ?></td>
                 <td>
                     <?php if (Auth::access('lecturer')): ?>
                         <a href="<?= ROOT ?>single_class/testedit/<?= $test->class_id ?>/<?= $test->test_id ?>?tab=tests">
                             <button class="btn btn-sm btn-primary"><i class="fas fa-edit pe-2"></i>Edit</button>
                         </a>
                         <a href="<?= ROOT ?>single_class/testdelete/<?= $test->class_id ?>/<?= $test->test_id ?>?tab=tests">
                             <button class="btn btn-sm btn-danger"><i class="fas fa-trash pe-2"></i>Delete</button>
                         </a>
                     <?php endif; ?>
                 </td>
             </tr>
         <?php endforeach; ?>
     <?php else : ?>
         <tr>
             <td colspan="6">
                 <center class="alert alert-danger" role="alert">
                     No Test found at this time
                 </center>
             </td>
         </tr>
     <?php endif; ?>
 </table>