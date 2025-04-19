<?php $this->view('includes/header'); ?>

<div class="container-fluid">

    <div class="mx-auto p-4 shadow rounded mt-5" style="width: 100%;max-width: 340px;">
        <h2 class="text-center">My school</h2>
        <img src="<?php ROOT; ?>assets/logo.avif" alt="" class=" border border-success d-block mx-auto rounded-circle" style="width: 120px;height: 120px;">
        <h2 class="text-primary mb-2">Login</h2>
        <input type="email" name="email" placeholder="Email address" class="form-control mb-2">
        <input type="password" name="password" placeholder="Password" class="form-control mb-2">
        <button class="btn btn-primary w-100 mt-2">Login</button>
    </div>
</div>

<?php $this->view('includes/footer'); ?>