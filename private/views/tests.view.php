<?php $this->view('includes/header'); ?>
<?php $this->view('includes/nav'); ?>


<div class="container-fluid p-4 shadow mt-5" style="max-width: 1000px; margin: auto;">
    <?php $this->view('includes/crumbs', ['crumbs' => $crumbs]); ?>
    <h5 class=" text-center">Tests</h5>
    <nav class="navbar bg-body-tertiary" style="width: 100%;">
        <form class="container-fluid">
            <div class="input-group">
                <button class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></button>
                <input name="find" value="<?= isset($_GET['find']) ? $_GET['find'] : '' ?>" type="text" class="form-control" placeholder="Serach" aria-label="Search" aria-describedby="basic-addon1">
            </div>
        </form>
    </nav>
    <div class="card-group justify-content-center">

        <?php include(view_path('tests')) ?>

    </div>


</div>



<?php $this->view('includes/footer'); ?>