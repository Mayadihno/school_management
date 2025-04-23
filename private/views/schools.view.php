<?php $this->view('includes/header'); ?>
<?php $this->view('includes/nav'); ?>

<div class="container-fluid p-4 shadow mt-5" style="max-width: 1000px; margin: auto;">
    <?php $this->view('includes/crumbs', ['crumbs' => $crumbs]); ?>
    <div class="card-group justify-content-center">
        <table class="table table-hover table-striped table-bordered text-center">
            <tr>
                <th>School</th>
                <th>Created by</th>
                <th>Date</th>
                <th>
                    <a href="<?= ROOT ?>schools/add">
                        <button class="btn btn-sm btn-primary"><i class="fas fa-plus pe-2"></i>Add New</button>
                    </a>
                </th>
            </tr>

            <?php if ($schools) : ?>
                <?php foreach ($schools as $school) : ?>
                    <tr>
                        <td><?= $school->school ?></td>
                        <td><?= $school->user->lastname ?> <?= $school->user->firstname ?> </td>
                        <td><?= get_date($school->date) ?></td>
                        <td>
                            <a href="<?= ROOT ?>schools/edit/<?= $school->id ?>">
                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit pe-2"></i>Edit</button>
                            </a>
                            <a href="<?= ROOT ?>schools/delete/<?= $school->id ?>">
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash pe-2"></i>Delete</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="alert alert-danger" role="alert">
                    No schools found at this time
                </div>
            <?php endif; ?>
        </table>
    </div>


</div>



<?php $this->view('includes/footer'); ?>