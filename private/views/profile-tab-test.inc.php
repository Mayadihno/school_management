<h3>Test</h3>
<nav class="navbar bg-body-tertiary">
    <form class="container-fluid">
        <div class="input-group">
            <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
            <input value="<?= !empty($_GET['find']) ? $_GET['find'] : '' ?>" type="text" name="find" class="form-control" placeholder="Serach" aria-label="Search" aria-describedby="basic-addon1">
            <input type="hidden" name="tab" value="tests">

        </div>
    </form>
</nav>


<?php if ($user->rank == 'student') : ?>
    <?php include(view_path('marked')) ?>
<?php else: ?>
    <?php include(view_path('tests')) ?>
<?php endif ?>