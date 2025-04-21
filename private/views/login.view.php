<?php $this->view('includes/header'); ?>

<div class="container-fluid">

    <form action="" method="post">
        <div class="mx-auto p-4 shadow rounded mt-5" style="width: 100%;max-width: 340px;">
            <h2 class="text-center">My school</h2>
            <img src="<?php ROOT; ?>assets/logo.avif" alt="" class=" border border-success d-block mx-auto rounded-circle" style="width: 120px;height: 120px;">
            <h2 class="text-primary mb-2">Login</h2>
            <?php if (count($errors) > 0) : ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Errors:</strong><?php foreach ($errors as $error) : ?>
                        <br>
                        <li class="text-danger"><?= $error ?></li>
                    <?php endforeach; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <input type="email" value="<?php get_value('email') ?>" name="email" placeholder="Email address" class="form-control mb-2">
            <input type="password" value="<?php get_value('password') ?>" name="password" placeholder="Password" class="form-control mb-2">
            <button type="submit" class="btn btn-primary w-100 mt-2">Login</button>
        </div>
    </form>
</div>

<?php $this->view('includes/footer'); ?>