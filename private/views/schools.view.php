<?php $this->view('includes/header'); ?>
<?php $this->view('includes/nav'); ?>

<div class="container-fluid p-4 shadow mt-5" style="max-width: 1000px; margin: auto;">
    <?php $this->view('includes/crumbs'); ?>
    <div class="card-group justify-content-center">
        <?php if ($schools) : ?>
            <?php foreach ($schools as $school) : ?>

            <?php endforeach; ?>
        <?php else : ?>
            <div class="alert alert-danger" role="alert">
                No schools found at this time
            </div>
        <?php endif; ?>
    </div>


</div>



<?php $this->view('includes/footer'); ?>