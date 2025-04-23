<?php $this->view('includes/header'); ?>
<?php $this->view('includes/nav'); ?>

<div class="container-fluid p-4 shadow mt-5" style="max-width: 1000px; margin: auto;">
    <?php $this->view('includes/crumbs', ['crumbs' => $crumbs]); ?>
    <a href="<?= ROOT ?>register">
        <button class="btn btn-sm btn-primary"><i class="fas fa-plus pe-2"></i>Add New</button>
    </a>
    <div class="card-group justify-content-center">

        <?php if ($users) : ?>
            <?php foreach ($users as $user) : ?>
                <?php $image = get_image($user->image, $user->gender); ?>
                <div class="card shadow m-2" style="max-width: 14rem; min-width:14rem">
                    <img src="<?= $image  ?>" class="card-img-top" alt="">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?= $user->firstname . ' ' . $user->lastname; ?>
                        </h5>
                        <p class="card-text">Rank: <?= ucwords(str_replace('-', ' ', $user->rank)); ?></p>
                        <a href="<?= ROOT ?>profile/<?= $user->user_id ?>" class="btn btn-primary">Profile</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="alert alert-danger" role="alert">
                No users found at this time
            </div>
        <?php endif; ?>
    </div>


</div>



<?php $this->view('includes/footer'); ?>