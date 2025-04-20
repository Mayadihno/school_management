<?php $this->view('includes/header'); ?>
<?php $this->view('includes/nav'); ?>

<div class="container-fluid p-4 shadow mt-5" style="max-width: 1000px; margin: auto;">
    <?php $this->view('includes/crumbs'); ?>
    <h4 class=""> Profile</h4>
    <div class="row my-3">
        <div class="col-sm-4 col-md-3">
            <img src="<?php ROOT ?>assets/female-icon.jpg" class="border border-dark d-block mx-auto rounded-circle" alt="" width="150px">
            <h3 class="text-center pt-2">Mary Abiodun</h3>
        </div>
        <div class="col-sm-8 col-md-9 bg-light p-3 rounded shadow">
            <h4 class="text-center">Personal Information</h4>
            <table class="table table-hover table-bordered table-striped">
                <tr>
                    <th>First Name:
                    <td>Mary</td>
                    </th>
                </tr>
                <tr>
                    <th>Last Name:
                    <td>Abiodun</td>
                    </th>
                </tr>
                <tr>
                    <th>Gender:
                    <td>Female</td>
                    </th>
                </tr>
                <tr>
                    <th>Date Created:
                    <td>02/02/2022</td>
                    </th>
                </tr>
            </table>
        </div>
    </div>
    <div class="container-fluid">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Basic Info</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Classes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Tests</a>
            </li>

        </ul>
        <nav class="navbar bg-body-tertiary">
            <form class="container-fluid">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Serach" aria-label="Search" aria-describedby="basic-addon1">
                </div>
            </form>
        </nav>
    </div>
</div>

<?php $this->view('includes/footer'); ?>