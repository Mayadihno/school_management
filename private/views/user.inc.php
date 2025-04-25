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