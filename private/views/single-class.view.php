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
                        aria-current="page" href="<?= ROOT ?>single_class/<?= $class->id ?>?tab=lecturers">Lecturers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $page_tab == 'students' ? 'active' : '' ?>"
                        href="<?= ROOT ?>single_class/<?= $class->id ?>?tab=students">Students</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $page_tab == 'tests' ? 'active' : '' ?>"
                        href="<?= ROOT ?>single_class/<?= $class->id ?>?tab=tests">Tests</a>
                </li>
            </ul>


            <?php
            switch ($page_tab) {
                case 'lecturers':
                    include(view_path('class-tab-lecturers'));
                    break;
                case 'lecturers-add':
                    include(view_path('class-tab-lecturers-add'));
                    break;
                case 'lecturers-remove':
                    include(view_path('class-tab-lecturers-remove'));
                    break;
                case 'students':
                    include(view_path('class-tab-students'));
                    break;
                case 'students-add':
                    include(view_path('class-tab-students-add'));
                    break;
                case 'tests':
                    include(view_path('class-tab-tests'));
                    break;
                case 'tests-add':
                    include(view_path('class-tab-tests-add'));
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