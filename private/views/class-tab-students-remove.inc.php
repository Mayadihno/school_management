<form action="" method="post" class="form mx-auto">
    <h3 class="fs-4 mt-2">Remove Student</h3>
    <?php if (count($errors) > 0) : ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Errors:</strong><?php foreach ($errors as $error) : ?>
                <br>
                <li class="text-danger"><?= $error ?></li>
            <?php endforeach; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <input type="text" value="<?= get_value('name') ?>" name="name" class="form-control w-50 my-3" placeholder="Student Name">
    <div class=" d-flex align-items-center">
        <a href="<?= ROOT ?>single_class/<?= $class->id ?>?tab=students">
            <button type="button" class="btn btn-danger">Cancel</button>
        </a>
        <button class="btn btn-secondary ms-4" name="search">Search</button>
    </div>
</form>

<div class="container-fluid my-4">
    <!-- <?php show($_POST) ?> -->
    <form method="post">
        <?php if (isset($results) && $results) : ?>
            <?php foreach ($results as $user) : ?>
                <?php include(view_path('user')) ?>
            <?php endforeach; ?>
        <?php else : ?>
            <?php if (count($_POST) > 0) : ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <center> No result found at this time</center>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </form>
</div>