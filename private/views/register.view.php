<?php $this->view('includes/header'); ?>
<?php $form_submitted = $_SERVER['REQUEST_METHOD'] == 'POST'; ?>

<div class="container-fluid">
    <form method="post">
        <div class="mx-auto p-4 shadow rounded mt-5" style="width: 100%; max-width: 340px;">
            <h2 class="text-center">My school</h2>
            <img src="<?= ROOT ?>assets/logo.avif" alt="" class="border border-success d-block mx-auto rounded-circle" style="width: 120px; height: 120px;">
            <h2 class="text-primary mb-2">Register</h2>

            <input type="text" value="<?= get_value('firstname') ?>" name="firstname" placeholder="First Name" class="form-control mb-1">
            <?php if ($form_submitted && !empty($errors['firstname'])) : ?>
                <small class="text-danger"><?= $errors['firstname'] ?></small>
            <?php endif; ?>

            <input type="text" value="<?= get_value('lastname') ?>" name="lastname" placeholder="Last Name" class="form-control mb-1">
            <?php if ($form_submitted && !empty($errors['lastname'])) : ?>
                <small class="text-danger"><?= $errors['lastname'] ?></small>
            <?php endif; ?>

            <input type="email" value="<?= get_value('email') ?>" name="email" placeholder="Email address" class="form-control mb-1">
            <?php if ($form_submitted && !empty($errors['email'])) : ?>
                <small class="text-danger"><?= $errors['email'] ?></small>
            <?php endif; ?>

            <select name="gender" class="form-select mb-1">
                <option <?= get_select('gender', '') ?> value="">--Select Gender--</option>
                <option <?= get_select('gender', 'male') ?> value="male">Male</option>
                <option <?= get_select('gender', 'female') ?> value="female">Female</option>
                <option <?= get_select('gender', 'other') ?> value="other">Other</option>
            </select>
            <?php if ($form_submitted && !empty($errors['gender'])) : ?>
                <small class="text-danger"><?= $errors['gender'] ?></small>
            <?php endif; ?>

            <select name="rank" class="form-select mb-1">
                <option <?= get_select('rank', '') ?> value="">--Select Rank--</option>
                <option <?= get_select('rank', 'student') ?> value="student">Student</option>
                <option <?= get_select('rank', 'reception') ?> value="reception">Reception</option>
                <option <?= get_select('rank', 'lecturer') ?> value="lecturer">Lecturer</option>
                <option <?= get_select('rank', 'admin') ?> value="admin">Admin</option>
                <option <?= get_select('rank', 'super-admin') ?> value="super-admin">Super Admin</option>
            </select>
            <?php if ($form_submitted && !empty($errors['rank'])) : ?>
                <small class="text-danger"><?= $errors['rank'] ?></small>
            <?php endif; ?>

            <input type="password" value="<?= get_value('password') ?>" name="password" placeholder="Password" class="form-control mb-1">
            <?php if ($form_submitted && !empty($errors['password'])) : ?>
                <small class="text-danger"><?= $errors['password'] ?></small>
            <?php endif; ?>

            <input type="password" value="<?= get_value('confirm-password') ?>" name="confirm-password" placeholder="Confirm Password" class="form-control mb-1">
            <?php if ($form_submitted && !empty($errors['confirm-password'])) : ?>
                <small class="text-danger"><?= $errors['confirm-password'] ?></small>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <button type="button" class="btn btn-danger">Cancel</button>
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </div>
    </form>
</div>


<?php $this->view('includes/footer'); ?>