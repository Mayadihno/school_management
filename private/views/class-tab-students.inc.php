 <nav class="navbar bg-body-tertiary d-flex justify-content-between align-items-center">
     <form class="w-75">
         <div class=" input-group">
             <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
             <input type="text" class="form-control" placeholder="Serach" aria-label="Search" aria-describedby="basic-addon1">
         </div>

     </form>

     <?php if (Auth::access('lecturer')): ?>
         <div class="">
             <a href="<?= ROOT ?>single_class/studentsadd/<?= $class->class_id ?>?select=true">
                 <button class="btn btn-sm btn-primary"><i class="fas fa-plus pe-2"></i>Add New</button>
             </a>
             <a href="<?= ROOT ?>single_class/studentsremove/<?= $class->id ?>?select=true">
                 <button class="btn btn-sm btn-danger"><i class="fas fa-minus pe-2"></i>Remove</button>
             </a>
         </div>
     <?php endif; ?>
 </nav>

 <!-- <?php show($students) ?> -->
 <div class="card-group">
     <?php if (is_array($students)) : ?>
         <?php foreach ($students as $user) : ?>
             <?php
                $user = $user->user;
                include(view_path('user'))
                ?>
         <?php endforeach; ?>
     <?php else: ?>
         <div class="alert alert-danger" role="alert">
             No students found at this time
         </div>

     <?php endif; ?>
 </div>
 <?php $pager->display() ?>