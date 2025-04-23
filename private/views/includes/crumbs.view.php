<nav aria-label="breadcrumb ">
    <ol class="breadcrumb justify-content-center">
        <?php if (isset($crumbs)) : ?>
            <?php foreach ($crumbs as $crumb) : ?>
                <li class="breadcrumb-item">
                    <a href="<?= defined('ROOT') ? ROOT . $crumb[1] : $crumb[1] ?>"><?= $crumb[0] ?></a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ol>
</nav>