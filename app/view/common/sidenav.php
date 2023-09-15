<?php
$Count['multimedia'] = 10;
$Count['comments'] = 10;
?>
<div class="w-250 sidenav-sticky sticky-top" id="aside" tabindex="-1" aria-labelledby="Aside" aria-hidden="true">
    <nav class="navbar navbar-vertical navbar-expand-lg navbar-light bg-transparent align-items-start py-4 py-lg-0 h-100 w-100">
        <ul class="navbar-nav nav-active-border left mb-2 mb-lg-0 rounded fw-bold text-heading fs-sm w-100" data-nav>
            <?php
                require_once PATH . '/config/menu.config.php';
                echo nav($DashboardNav, isset($Config['nav']) ? $Config['nav'] : null, $Count);
            ?>
        </ul>
    </nav>
</div>