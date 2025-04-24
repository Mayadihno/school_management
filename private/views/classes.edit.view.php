<?php $this->view('includes/header'); ?>
<?php $this->view('includes/nav'); ?>

<div class="container-fluid p-4 shadow mt-5" style="max-width: 1000px; margin: auto;">
    <?php $this->view('includes/crumbs', ['crumbs' => $crumbs]); ?>
    <div class="card-group justify-content-center">
        <?php if ($classes) : ?>
            <form action="" method="post">
                <h3>Edit Class</h3>
                <?php if (count($errors) > 0) : ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Errors:</strong><?php foreach ($errors as $error) : ?>
                            <br>
                            <li class="text-danger"><?= $error ?></li>
                        <?php endforeach; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <input type="text" class="form-control mb-4" value="<?= get_value('class', $classes[0]->class) ?>" name="class">
                <input type="submit" class="btn btn-primary float-end" value="Save">
                <a href="<?= ROOT ?>classes">
                    <input type="button" class="btn btn-danger" value="Cancle">
                </a>
            </form>
        <?php else : ?>
            <div class="alert alert-danger" role="alert">
                <h3> No Class found at this time</h3> <br>
                <a href="<?= ROOT ?>classes">
                    <input type="button" class="btn btn-danger" value="Cancle">
                </a>
            </div>
        <?php endif; ?>
    </div>


</div>



<?php $this->view('includes/footer'); ?>