 <div class="card-group justify-content-center">
     <form action="" method="post">
         <h3>Add A Test</h3>
         <?php if (count($errors) > 0) : ?>
             <div class="alert alert-warning alert-dismissible fade show" role="alert">
                 <strong>Errors:</strong><?php foreach ($errors as $error) : ?>
                     <br>
                     <li class="text-danger"><?= $error ?></li>
                 <?php endforeach; ?>
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>
         <?php endif; ?>
         <input type="text" class="form-control mb-4" placeholder="Test Name" value="<?= get_value('test') ?>" name="test">
         <textarea name="description" id="" cols="30" rows="5" value="<?= get_value('description') ?>" class="form-control mb-4" placeholder="Test Description" id=""></textarea>
         <input type="submit" class="btn btn-primary float-end" value="Create">
         <a href="<?= ROOT ?>single_class/<?= $class->class_id ?>?tab=tests">
             <input type="button" class="btn btn-danger" value="Cancle">
         </a>
     </form>
 </div>