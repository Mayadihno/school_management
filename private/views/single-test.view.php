<?php $this->view('includes/header'); ?>
<?php $this->view('includes/nav'); ?>

<div class="container-fluid p-4 shadow mt-5" style="max-width: 1000px; margin: auto;">
    <?php if ($test): ?>
        <?php $this->view('includes/crumbs', ['crumbs' => $crumbs]); ?>
        <h4 class="">Test Profile</h4>
        <div class="row my-3">
            <div class="col-sm-12 col-md-12 bg-light p-3 rounded shadow">
                <h4 class="text-center"><?= esc(ucwords($test->test)) ?></h4>
                <table class="table table-hover table-bordered table-striped">
                    <tr>
                        <th>Test Name:
                        <td><?= esc($test->test) ?></td>
                        </th>
                    </tr>
                    <tr>
                        <th>Created by:
                        <td><?= esc($test->user->firstname) ?> <?= esc($test->user->lastname) ?></td>
                        </th>
                    </tr>
                    <tr>
                        <th>Date Created:
                        <td><?= esc(get_date($test->date)) ?></td>
                        </th>
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
                case 'add':
                    include(view_path('test-tab-add'));
                    break;
                case 'edit':
                    include(view_path('test-tab-edit'));
                    break;
                case 'delete':
                    include(view_path('test-tab-delete'));
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