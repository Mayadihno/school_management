<form action="" method="post" class="form mx-auto">
    <h3 class="fs-4 mt-2">Add Lecturer</h3>
    <input type="text" name="name" class="form-control w-50 my-3" placeholder="Lecturer Name">
    <div class=" d-flex align-items-center">
        <a href="<?= ROOT ?>single_class/<?= $class->id ?>?tab=lecturers">
            <button type="button" class="btn btn-danger">Cancel</button>
        </a>
        <button class="btn btn-secondary ms-4">Search</button>
    </div>
</form>

<div class="container-fluid">
    <?php if (isset($result) && $result) : ?>
        <?php foreach ($result as $user) : ?>
            <?php include(view_path('user')) ?>
        <?php endforeach; ?>
    <?php else : ?>
        <?php if (count($_POST) > 0) : ?>
            <div class="alert alert-danger mt-3" role="alert">
                <center> No result found at this time</center>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>