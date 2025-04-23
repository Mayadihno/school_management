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
                    <a class="nav-link active" aria-current="page" href="#">Basic Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Classes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Tests</a>
                </li>

            </ul>
            <nav class="navbar bg-body-tertiary">
                <form class="container-fluid">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="Serach" aria-label="Search" aria-describedby="basic-addon1">
                    </div>
                </form>
            </nav>
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