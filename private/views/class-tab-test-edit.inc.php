 <div class="card-group justify-content-center">
     <?php if (isset($test) && $test) : ?>
         <form action="" method="post">
             <h3>Edit Test</h3>
             <?php if (count($errors) > 0) : ?>
                 <div class="alert alert-warning alert-dismissible fade show" role="alert">
                     <strong>Errors:</strong><?php foreach ($errors as $error) : ?>
                         <br>
                         <li class="text-danger"><?= $error ?></li>
                     <?php endforeach; ?>
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                 </div>
             <?php endif; ?>
             <input type="text" class="form-control mb-4" placeholder="Test Name" value="<?= get_value('test', $test->test) ?>" name="test">
             <textarea name="description" id="" cols="30" rows="5" value="" class="form-control mb-4" placeholder="Test Description" id=""><?= get_value('description', $test->description) ?></textarea>
             <div class="my-3">
                 <?php

                    $disabled = get_value('disabled', $test->disabled);
                    $active_checked = $disabled ? "" : "checked";
                    $disabled_checked = $disabled ? "checked" : "";
                    ?>

                 <input type="radio" name="disabled" value="0" <?= $active_checked ?>> Active |
                 <input type="radio" name="disabled" value="1" <?= $disabled_checked ?>> Disabled <br><br>
             </div>
             <input type="submit" class="btn btn-primary float-end" value="Save">
             <a href="<?= ROOT ?>single_class/<?= $class->id ?>?tab=tests">
                 <input type="button" class="btn btn-danger" value="Back">
             </a>
         </form>
     <?php else: ?>
         <div class="alert alert-danger mt-3" role="alert">
             No test found at this time

             <div class="mt-3">
                 <a href="<?= ROOT ?>single_class/<?= $class->id ?>?tab=tests">
                     <input type="button" class="btn btn-danger" value="Back">
                 </a>
             </div>
         </div>

     <?php endif; ?>
 </div>