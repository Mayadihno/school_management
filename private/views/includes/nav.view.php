<style>
    nav ul li a:hover {
        background-color: grey !important;
        color: #fff !important;
    }
</style>
<nav class="navbar navbar-expand-lg bg-body-tertiary p-3">
    <div class="container-fluid">
        <a class="navbar-brand me-5" href="#">
            <img src="<?php ROOT ?>assets/logo.avif" alt="Logo" width="50" height="50" class=" rounded-circle">
            <span class="" style="font-size: 13px; padding-top: 10px;">My School</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active text-uppercase" aria-current="page" href="<?php ROOT ?>home">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase" href="<?php ROOT ?>classes">classes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase" href="<?php ROOT ?>users">users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase" href="<?php ROOT ?>tests">test</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-uppercase" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        User
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php ROOT ?>profile">Profile</a></li>
                        <li><a class="dropdown-item" href="<?php ROOT ?>home">Dashboard</a></li>
                        <div class="dropdown-divider"></div>
                        <li><a class="dropdown-item" href="<?php ROOT ?>logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>