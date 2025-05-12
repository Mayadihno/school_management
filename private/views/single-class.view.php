<?php $this->view('includes/header'); ?>
<?php $this->view('includes/nav'); ?>

<div class="container-fluid p-4 shadow mt-5" style="max-width: 1000px; margin: auto;">
    <?php if ($class): ?>
        <?php $this->view('includes/crumbs', ['crumbs' => $crumbs]); ?>
        <h4 class="">Class Profile</h4>
        <div class="row my-3">
            <div class="col-sm-12 col-md-12 bg-light p-3 rounded shadow">
                <h4 class="text-center"><?= esc(ucwords($class->class)) ?></h4>
                <table class="table table-hover table-bordered table-striped">
                    <tr>
                        <th>Class Name:
                        <td><?= esc($class->class) ?></td>
                        </th>
                    </tr>
                    <tr>
                        <th>Created by:
                        <td><?= esc($class->user->firstname) ?> <?= esc($class->user->lastname) ?></td>
                        </th>
                    </tr>
                    <tr>
                        <th>Date Created:
                        <td><?= esc(get_date($class->date)) ?></td>
                        </th>
                    </tr>
                </table>
            </div>
        </div>
        <div>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link <?= $page_tab == 'lecturers' ? 'active' : '' ?>"
                        aria-current="page" href="<?= ROOT ?>single_class/<?= $class->class_id ?>?tab=lecturers">Lecturers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $page_tab == 'students' ? 'active' : '' ?>"
                        href="<?= ROOT ?>single_class/<?= $class->class_id ?>?tab=students">Students</a>
                </li>
                <?php if (Auth::access('lecturer')) : ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $page_tab == 'tests' ? 'active' : '' ?>"
                            href="<?= ROOT ?>single_class/<?= $class->class_id ?>?tab=tests">Tests</a>
                    </li>
                <?php endif ?>
            </ul>


            <?php
            switch ($page_tab) {
                case 'lecturers':
                    include(view_path('class-tab-lecturers'));
                    break;
                case 'lecturers-add':
                    if (Auth::access('lecturer')) {
                        include(view_path('class-tab-lecturers-add'));
                    } else {
                        include(view_path('access-denied'));
                    }
                    break;
                case 'lecturers-remove':
                    if (Auth::access('admin')) {
                        include(view_path('class-tab-lecturers-remove'));
                    } else {
                        include(view_path('access-denied'));
                    }
                    break;
                case 'students':
                    include(view_path('class-tab-students'));
                    break;
                case 'students-add':
                    if (Auth::access('lecturer')) {
                        include(view_path('class-tab-students-add'));
                    } else {
                        include(view_path('access-denied'));
                    }
                    break;
                case 'students-remove':
                    if (Auth::access('lecturer')) {
                        include(view_path('class-tab-students-remove'));
                    } else {
                        include(view_path('access-denied'));
                    }
                    break;
                case 'tests':
                    if (Auth::access('lecturer')) {
                        include(view_path('class-tab-tests'));
                    } else {
                        include(view_path('access-denied'));
                    }
                    break;
                case 'test-add':
                    if (Auth::access('lecturer')) {
                        include(view_path('class-tab-test-add'));
                    } else {
                        include(view_path('access-denied'));
                    }
                    break;
                case 'test-edit':
                    if (Auth::access('lecturer')) {
                        include(view_path('class-tab-test-edit'));
                    } else {
                        include(view_path('access-denied'));
                    }
                    break;
                case 'test-delete':
                    if (Auth::access('lecturer')) {
                        include(view_path('class-tab-test-delete'));
                    } else {
                        include(view_path('access-denied'));
                    }

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
                No class found
            </h4>
        </div>
    <?php endif; ?>


</div>

<?php $this->view('includes/footer'); ?>