<?php $this->view('includes/header'); ?>
<?php $this->view('includes/nav'); ?>

<div class="container-fluid p-4 shadow mt-5" style="max-width: 1000px; margin: auto;">
    <?php $this->view('includes/crumbs', ['crumbs' => $crumbs]); ?>
    <div class="card-group justify-content-center">
        <form action="" method="post">
            <h3>Add New Class</h3>
            <?php if (count($errors) > 0) : ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Errors:</strong><?php foreach ($errors as $error) : ?>
                        <br>
                        <li class="text-danger"><?= $error ?></li>
                    <?php endforeach; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <input type="text" class="form-control mb-4" placeholder="Class Name" value="<?= get_value('class') ?>" name="class">
            <input type="submit" class="btn btn-primary float-end" value="Create">
            <a href="<?= ROOT ?>classes">
                <input type="button" class="btn btn-danger" value="Cancle">
            </a>
        </form>
    </div>


</div>



<?php $this->view('includes/footer'); ?>