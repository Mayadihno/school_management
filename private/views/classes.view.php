<?php $this->view('includes/header'); ?>
<?php $this->view('includes/nav'); ?>


<div class="container-fluid p-4 shadow mt-5" style="max-width: 1000px; margin: auto;">
    <?php $this->view('includes/crumbs', ['crumbs' => $crumbs]); ?>
    <h5 class=" text-center">Classes</h5>
    <div class="card-group justify-content-center">

        <?php include(view_path('classes')) ?>

    </div>


</div>



<?php $this->view('includes/footer'); ?>