<?php $this->view('includes/header'); ?>
<?php $this->view('includes/nav'); ?>

<div class="container-fluid p-4 shadow mt-5" style="max-width: 1000px; margin: auto;">
    <?php if (isset($test) && !$test->disabled && $answered_test_row && $submitted) :   ?>
        <?php $this->view('includes/crumbs', ['crumbs' => $crumbs]); ?>
        <h4 class="">Test Profile</h4>
        <div class="row my-3">
            <div class="col-sm-12 col-md-12 bg-light p-3 rounded shadow">
                <div class=" d-flex justify-content-evenly align-items-center mb-2">
                    <h4 class="text-center"><?= esc(ucwords($test->test)) ?></h4>
                    <?php if (Auth::access('lecturer')): ?>
                        <a href="<?= ROOT ?>single_class/<?= $test->class_id ?>?tab=tests">
                            <button class="btn btn-sm btn-primary"><i class="fas fa-chevron-right pe-2"></i>View Class</button>
                        </a>
                    <?php endif; ?>
                </div>
                <table class="table table-hover table-bordered table-striped">
                    <tr>
                        <th>Class Name: </th>
                        <td>
                            <a href="<?= ROOT ?>single_class/<?= $test->class_id ?>?tab=students">
                                <?= esc($test->class->class) ?>
                            </a>
                        </td>

                    </tr>
                    <tr>
                        <th>Test Name: </th>
                        <td>
                            <?= esc($test->test) ?>
                        </td>

                    </tr>
                    <tr>
                        <th>Student Name: </th>
                        <td>
                            <a href="<?= ROOT ?>profile/<?= $student_row->user_id ?>?tab=tests">
                                <?= esc($student_row->firstname) ?> <?= esc($student_row->lastname) ?>
                            </a>
                        </td>

                    </tr>
                    <tr>
                        <th>Created by: </th>
                        <td>
                            <a href="<?= ROOT ?>profile/<?= $test->user->user_id ?>?tab=tests">
                                <?= esc($test->user->firstname) ?> <?= esc($test->user->lastname) ?>
                            </a>
                        </td>

                    </tr>
                    <tr>
                        <th>Date Created: </th>
                        <td><?= esc(get_date($test->date)) ?></td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Test Status:</strong> <?= $test->disabled == 0 ? 'Active' : 'Inactive' ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8">
                            <strong>Test Description:</strong> <?= esc($test->description) ?>
                        </td>
                    </tr>
                </table>
                <a href="<?= ROOT ?>make_pdf/<?= $test->id ?>/<?= $student_row->user_id ?>?type=test">
                    <button class="btn btn-sm btn-primary text-uppercase float-end">
                        save as pdf
                    </button>
                </a>
            </div>
        </div>

        <div>
            <?php
            switch ($page_tab) {
                case 'view':
                    include(view_path('marked-single-tab-view'));
                    break;
                default:
                    # code...
                    break;
            }

            ?>
        </div>

    <?php else: ?>
        <div class=" text-center ">
            <h4>
                No Test found
            </h4>
        </div>
    <?php endif; ?>


</div>

<?php $this->view('includes/footer'); ?>