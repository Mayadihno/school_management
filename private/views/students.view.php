<?php $this->view('includes/header'); ?>
<?php $this->view('includes/nav'); ?>

<div class="container-fluid p-4 shadow mt-5" style="max-width: 1000px; margin: auto;">
    <?php $this->view('includes/crumbs', ['crumbs' => $crumbs]); ?>
    <div class=" d-flex justify-content-between align-items-center mb-3">
        <nav class="navbar bg-body-tertiary" style="width: 90%;">
            <form class="container-fluid">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Serach" aria-label="Search" aria-describedby="basic-addon1">
                </div>
            </form>
        </nav>
        <a href="<?= ROOT ?>register?mode=students">
            <button class="btn btn-sm btn-primary"><i class="fas fa-plus pe-2"></i>Add New</button>
        </a>
    </div>
    <div class="card-group justify-content-center">

        <?php if ($students) : ?>
            <?php foreach ($students as $student) : ?>
                <?php $image = get_image($student->image, $student->gender); ?>
                <div class="card shadow m-2" style="max-width: 14rem; min-width:14rem">
                    <img src="<?= $image  ?>" class="card-img-top" alt="">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?= $student->firstname . ' ' . $student->lastname; ?>
                        </h5>
                        <p class="card-text">Rank: <?= ucwords(str_replace('-', ' ', $student->rank)); ?></p>
                        <a href="<?= ROOT ?>profile/<?= $student->user_id ?>" class="btn btn-primary">Profile</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="alert alert-danger" role="alert">
                No student found at this time
            </div>
        <?php endif; ?>
    </div>


</div>



<?php $this->view('includes/footer'); ?>