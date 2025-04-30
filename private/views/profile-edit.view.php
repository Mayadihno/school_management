<?php $this->view('includes/header'); ?>
<?php $this->view('includes/nav'); ?>
<?php $form_submitted = $_SERVER['REQUEST_METHOD'] == 'POST'; ?>

<div class="container-fluid p-4 shadow mt-5" style="max-width: 1000px; margin: auto;">
    <?php if ($user): ?>
        <?php $image = get_image($user->image, $user->gender); ?>
        <a href="<?= ROOT ?>profile/<?= $user->user_id ?>" class="btn btn-dark">
            Back to profile
        </a>
        <h4 class="text-center">Edit Profile</h4>
        <div class="row my-3">
            <div class="col-sm-4 col-md-3">
                <img src="<?= $image ?>" class="border d-block mt-3 mx-auto" alt="" width="180px">

                <?php if (Auth::myProfile($user)): ?>
                    <div class=" d-flex flex-column my-3">
                        <a href="<?= ROOT ?>profile/edit/<?= $user->user_id ?>" class="btn btn-info text-white mb-2">
                            Browse Image <i class="fa fa-image"></i>
                        </a>
                    </div>
                <?php endif ?>

            </div>
            <div class="col-sm-8 col-md-9 bg-light p-3 rounded shadow">
                <form method="post" class="mx-auto" style="max-width: 600px;">
                    <input type="text" value="<?= get_value('firstname', $user->firstname) ?>" name="firstname" placeholder="First Name" class="form-control mb-1">
                    <?php if ($form_submitted && !empty($errors['firstname'])) : ?>
                        <small class="text-danger"><?= $errors['firstname'] ?></small>
                    <?php endif; ?>

                    <input type="text" value="<?= get_value('lastname', $user->lastname) ?>" name="lastname" placeholder="Last Name" class="form-control mb-1">
                    <?php if ($form_submitted && !empty($errors['lastname'])) : ?>
                        <small class="text-danger"><?= $errors['lastname'] ?></small>
                    <?php endif; ?>

                    <input type="email" value="<?= get_value('email', $user->email) ?>" name="email" placeholder="Email address" class="form-control mb-1">
                    <?php if ($form_submitted && !empty($errors['email'])) : ?>
                        <small class="text-danger"><?= $errors['email'] ?></small>
                    <?php endif; ?>

                    <select name="gender" class="form-select mb-1">
                        <option <?= get_select('gender', '') ?> value="<?= $user->gender ?>"><?= $user->gender ?></option>
                        <option <?= get_select('gender', 'male') ?> value="male">Male</option>
                        <option <?= get_select('gender', 'female') ?> value="female">Female</option>
                        <option <?= get_select('gender', 'other') ?> value="other">Other</option>
                    </select>
                    <?php if ($form_submitted && !empty($errors['gender'])) : ?>
                        <small class="text-danger"><?= $errors['gender'] ?></small>
                    <?php endif; ?>

                    <select name="rank" class="form-select mb-1">
                        <option <?= get_select('rank', '') ?> value="<?= $user->rank ?>"><?= $user->rank ?> </option>
                        <option <?= get_select('rank', 'student') ?> value="student">Student</option>
                        <option <?= get_select('rank', 'reception') ?> value="reception">Reception</option>
                        <option <?= get_select('rank', 'lecturer') ?> value="lecturer">Lecturer</option>
                        <option <?= get_select('rank', 'admin') ?> value="admin">Admin</option>
                        <?php if (Auth::getRank() == 'super-admin'): ?>
                            <option <?= get_select('rank', 'super-admin') ?> value="super-admin">Super Admin</option>
                        <?php endif; ?>
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
                        <a href="<?= ROOT ?>profile/<?= $user->user_id ?>">
                            <button type="button" class="btn btn-danger">
                                Cancel
                            </button>
                        </a>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

    <?php else: ?>
        <div class="text-center ">
            <h4>
                No user found
            </h4>
        </div>
    <?php endif; ?>
</div>

<?php $this->view('includes/footer'); ?>