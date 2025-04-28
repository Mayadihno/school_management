<?php $this->view('includes/header'); ?>
<?php $this->view('includes/nav'); ?>

<div class="container-fluid p-4 shadow mt-5" style="max-width: 1000px; margin: auto;">
    <?php $this->view('includes/crumbs', ['crumbs' => $crumbs]); ?>
    <div class=" d-flex justify-content-between align-items-center mb-3">
        <nav class="navbar bg-body-tertiary" style="width: 90%;">
            <form class="container-fluid">
                <div class="input-group">
                    <button class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></button>
                    <input name="find" value="<?= isset($_GET['find']) ? $_GET['find'] : '' ?>" type="text" class="form-control" placeholder="Serach" aria-label="Search" aria-describedby="basic-addon1">
                </div>
            </form>
        </nav>
        <a href="<?= ROOT ?>register">
            <button class="btn btn-sm btn-primary"><i class="fas fa-plus pe-2"></i>Add New</button>
        </a>
    </div>
    <div class="card-group justify-content-center">

        <?php if ($users) : ?>
            <?php foreach ($users as $user) : ?>
                <?php include(view_path('user')) ?>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="alert alert-danger" role="alert">
                No users found at this time
            </div>
        <?php endif; ?>
    </div>


</div>



<?php $this->view('includes/footer'); ?>