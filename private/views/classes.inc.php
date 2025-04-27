 <table class="table table-hover table-striped table-bordered text-center">
     <tr>
         <th></th>
         <th>Class Name</th>
         <th>Created by</th>
         <th>Date</th>
         <th>
             <a href="<?= ROOT ?>classes/add">
                 <button class="btn btn-sm btn-primary"><i class="fas fa-plus pe-2"></i>Add New</button>
             </a>
         </th>
     </tr>

     <?php if (isset($classes) && $classes) : ?>
         <?php foreach ($classes as $class) : ?>
             <tr>
                 <td>
                     <a href="<?= ROOT ?>single_class/<?= $class->id ?>">
                         <button class="btn btn-primary btn-sm"><i class="fa fa-chevron-right"></i></button>
                     </a>
                 </td>
                 <td><?= $class->class ?></td>
                 <td><?= $class->user->lastname ?> <?= $class->user->firstname ?> </td>
                 <td><?= get_date($class->date) ?></td>
                 <td>
                     <a href="<?= ROOT ?>classes/edit/<?= $class->id ?>">
                         <button class="btn btn-sm btn-primary"><i class="fas fa-edit pe-2"></i>Edit</button>
                     </a>
                     <a href="<?= ROOT ?>classes/delete/<?= $class->id ?>">
                         <button class="btn btn-sm btn-danger"><i class="fas fa-trash pe-2"></i>Delete</button>
                     </a>
                 </td>
             </tr>
         <?php endforeach; ?>
     <?php else : ?>
         <div class="alert alert-danger" role="alert">
             No class found at this time
         </div>
     <?php endif; ?>
 </table>