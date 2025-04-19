<?php $this->view('includes/header'); ?>

<div class="container-fluid">

    <div class="mx-auto p-4 shadow rounded mt-5" style="width: 100%;max-width: 340px;">
        <h2 class="text-center">My school</h2>
        <img src="<?php ROOT; ?>assets/logo.avif" alt="" class=" border border-success d-block mx-auto rounded-circle" style="width: 120px;height: 120px;">
        <h2 class="text-primary mb-2">Register</h2>
        <input type="text" name="firstname" placeholder="First Name" class="form-control mb-2">
        <input type="text" name="lastname" placeholder="Last Name" class="form-control mb-2">
        <input type="email" name="email" placeholder="Email address" class="form-control mb-2">
        <select class="form-select mb-2" aria-label="Default select example">
            <option selected>--Select Gender--</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
        <select class="form-select mb-2" aria-label="Default select example">
            <option selected>--Select Rank--</option>
            <option value="student">Student</option>
            <option value="reception">Reception</option>
            <option value="lecturer">Lecturer</option>
            <option value="admin">Admin</option>
            <option value="super_admin">Super Admin</option>
        </select>
        <input type="password" name="password" placeholder="Password" class="form-control mb-2">
        <input type="password" name="re-password" placeholder="Confirm Password" class="form-control mb-2">
        <div class=" d-flex justify-content-between align-items-center mt-4">
            <button class="btn btn-danger">Cancel</button>
            <button class="btn btn-primary">Register</button>

        </div>

    </div>
</div>

<?php $this->view('includes/footer'); ?>