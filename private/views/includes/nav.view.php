<style>
    nav ul li a {
        width: 110px;
        text-align: center;
        border-left: solid thin #eee;
        border-right: solid thin #fff;
    }

    nav ul li a:hover {
        background-color: grey !important;
        color: #fff !important;
    }
</style>
<nav class="navbar navbar-expand-lg bg-body-tertiary p-3">
    <div class="container-fluid">
        <a class="navbar-brand me-5" href="<?= ROOT ?>">
            <img src="<?= ASSETS ?>/logo.avif" alt="Logo" width="50" height="50" class=" rounded-circle">
            <?= Auth::getSchool_name() ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active text-uppercase" aria-current="page" href="<?= ROOT ?>">Dashboard</a>
                </li>
                <?php if (Auth::access('super-admin')): ?>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase" href="<?= ROOT ?>schools">schools</a>
                    </li>
                <?php endif; ?>

                <?php if (Auth::access('admin')): ?>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase" href="<?= ROOT ?>users">staff</a>
                    </li>
                <?php endif; ?>

                <?php if (Auth::access('reception')): ?>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase" href="<?= ROOT ?>students">students</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link text-uppercase" href="<?= ROOT ?>classes">classes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase" href="<?= ROOT ?>tests">test</a>
                </li>

            </ul>
            <ul class="ms-auto navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-uppercase" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= Auth::getFirstname() ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?= ROOT ?>profile/<?= Auth::getUser_id() ?>">Profile</a></li>
                        <li><a class="dropdown-item" href="<?= ROOT ?>">Dashboard</a></li>
                        <div class="dropdown-divider"></div>
                        <li><a class="dropdown-item" href="<?= ROOT ?>logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>