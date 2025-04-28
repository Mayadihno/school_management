<?php $this->view('includes/header'); ?>
<?php $this->view('includes/nav'); ?>

<div class="container-fluid p-4 shadow mt-5" style="max-width: 1000px; margin: auto;">
    <?php if ($user): ?>
        <?php $image = get_image($user->image, $user->gender); ?>
        <?php $this->view('includes/crumbs', ['crumbs' => $crumbs]); ?>
        <h4 class=""> Profile</h4>
        <div class="row my-3">
            <div class="col-sm-4 col-md-3">
                <img src="<?= $image ?>" class="border border-dark d-block mx-auto rounded-circle" alt="" width="150px">
                <h3 class="text-center pt-2"><?= esc($user->firstname) ?> <?= esc($user->lastname) ?></h3>
            </div>
            <div class="col-sm-8 col-md-9 bg-light p-3 rounded shadow">
                <h4 class="text-center">Personal Information</h4>
                <table class="table table-hover table-bordered table-striped">
                    <tr>
                        <th>First Name:
                        <td><?= esc($user->firstname) ?></td>
                        </th>
                    </tr>
                    <tr>
                        <th>Last Name:
                        <td><?= esc($user->lastname) ?></td>
                        </th>
                    </tr>
                    <tr>
                        <th>Email:
                        <td><?= esc($user->email) ?></td>
                        </th>
                    </tr>
                    <tr>
                        <th>Gender:
                        <td><?= esc(ucfirst($user->gender)) ?></td>
                        </th>
                    </tr>
                    <tr>
                        <th>Rank:
                        <td><?= esc(ucwords(str_replace('-', ' ', $user->rank))) ?></td>
                        </th>
                    </tr>
                    <tr>
                        <th>Date Created:
                        <td><?= esc(get_date($user->date)) ?></td>
                        </th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="container-fluid">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link <?= $page_tab == 'info' ? 'active' : '' ?>" aria-current="page" href="<?= ROOT ?>profile/<?= $user->user_id ?>">Basic Info</a>
                </li>
                <?php if (Auth::access('lecturer') || Auth::i_own_content($user)): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $page_tab == 'classes' ? 'active' : '' ?>" href="<?= ROOT ?>profile/<?= $user->user_id ?>?tab=classes">My Classes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $page_tab == 'tests' ? 'active' : '' ?>" href="<?= ROOT ?>profile/<?= $user->user_id ?>?tab=tests">Tests</a>
                    </li>
                <?php endif ?>

            </ul>

            <?php
            switch ($page_tab) {
                case 'info':
                    include(view_path('profile-tab-info'));
                    break;

                case 'classes':
                    if (Auth::access('lecturer') || Auth::i_own_content($user)) {
                        include(view_path('profile-tab-classes'));
                    } else {
                        include(view_path('access-denied'));
                    }
                    break;
                case 'tests':
                    include(view_path('profile-tab-test'));
                    break;

                default:
                    # code...
                    break;
            }
            ?>
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