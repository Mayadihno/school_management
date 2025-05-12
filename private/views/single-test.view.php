<?php $this->view('includes/header'); ?>
<?php $this->view('includes/nav'); ?>

<div class="container-fluid p-4 shadow mt-5" style="max-width: 1000px; margin: auto;">
    <?php if (isset($test)):  ?>
        <?php $this->view('includes/crumbs', ['crumbs' => $crumbs]); ?>
        <h4 class="">Test Profile</h4>

        <div class="row my-3">
            <div class="col-sm-12 col-md-12 bg-light p-3 rounded shadow">
                <div class=" d-flex justify-content-evenly align-items-center mb-2">
                    <h4 class="text-center"><?= esc(ucwords($test->test)) ?></h4>
                    <a href="<?= ROOT ?>single_class/<?= $test->class_id ?>?tab=tests">
                        <button class="btn btn-sm btn-primary"><i class="fas fa-chevron-right pe-2"></i>View Class</button>
                    </a>
                    <a href="<?= ROOT ?>single_test/<?= $test->id ?>?tab=scores">
                        <button class="btn btn-sm btn-primary"><i class="fas fa-chevron-right pe-2"></i>View Scores</button>
                    </a>
                </div>
                <table class="table table-hover table-bordered table-striped">
                    <tr>
                        <th>Test Name: </th>
                        <td><?= esc($test->test) ?></td>

                    </tr>
                    <tr>
                        <th>Created by: </th>
                        <td><?= esc($test->user->firstname) ?> <?= esc($test->user->lastname) ?></td>

                    </tr>
                    <tr>
                        <th>Date Created: </th>
                        <td><?= esc(get_date($test->date)) ?></td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Test Status:</strong> <?= $test->disabled == 0 ? 'Active' : 'Inactive' ?>
                            <?php if ($test->disabled == 0): ?>
                                <a href="<?= ROOT ?>single_test/<?= $test->id ?>?disabled=true" class="float-end">
                                    <button class="btn btn-sm btn-danger ms-3">
                                        Disable Test
                                    </button>
                                </a>
                            <?php else: ?>
                                <a href="<?= ROOT ?>single_test/<?= $test->id ?>?disabled=false" class="float-end">
                                    <button class=" btn btn-sm btn-success ms-3">
                                        Enable Test
                                    </button>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8">
                            <strong>Test Description:</strong> <?= esc($test->description) ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div>
            <?php
            switch ($page_tab) {
                case 'view':
                    include(view_path('test-tab-view'));
                    break;
                case 'add-question':
                    include(view_path('test-tab-add-question'));
                    break;
                case 'edit-question':
                    include(view_path('test-tab-edit-question'));
                    break;
                case 'delete':
                    include(view_path('test-tab-delete'));
                    break;
                case 'scores':
                    include(view_path('test-tab-scores'));
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
                No Test found
            </h4>
        </div>
    <?php endif; ?>


</div>

<?php $this->view('includes/footer'); ?>