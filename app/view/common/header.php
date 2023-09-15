<div class="layout-sidenav sticky" id="aside" aria-hidden="true">
    <div class="nav-sidenav h-100 m-0 modal-dialog">
        <div class="navbar text-gray-600 pe-xl-3">
            <a href="<?php echo APP.'/admin';?>" class="navbar-brand text-gray-900">
                <img src="<?php echo ASSETS.'/img/logo.svg';?>" height="20">
            </a>
            <a href="<?php echo APP;?>" class="ms-auto btn btn-square btn-sm btn-ghost rounded-circle shadow-none" target="_blank" data-bs-tooltip="tooltip" data-bs-placement="bottom" title="<?php echo $this->translate('Go Frontend');?>">
                <svg width="16" height="16" stroke="currentColor" stroke-width="1.75" fill="none">
                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#earth';?>"></use>
                </svg>
            </a>
            <button type="button" class="btn-close d-block d-lg-none shadow-none ms-4" data-bs-dismiss="modal" data-bs-target="#aside" aria-label="Close"></button>
        </div>
        <!-- Flex nav content -->
        <div class="flex scrollable hover">
            <div class="nav-border text-gray-700" data-nav>
                <ul class="nav fs-sm">
                    <?php
                        $Count['reports']   = $this->db->from(null,'SELECT count(reports.id) as total FROM `reports` WHERE status = 2')->total(); 
                        $Count['comments']  = $this->db->from(null,'SELECT count(comments.id) as total FROM `comments` WHERE status = 2')->total(); 
                        require_once PATH . '/config/menu.config.php';
                        echo nav($DashboardNav, isset($Config['nav']) ? $Config['nav'] : null, $Count);
                    ?>
                </ul>
            </div>
        </div>
        <!-- sidenav bottom -->
        <div class="no-shrink mt-auto d-flex align-items-center text-body">
            <div class="text-muted fs-xs">Version
                <?php echo VERSION;?>
            </div>
        </div>
    </div>
</div>
<div class="layout-content">
    <div class="navbar navbar-expand-lg layout-header navbar-light ps-xl-3">
        <div class="collapse navbar-collapse" id="navbarToggler">
            <?php if(isset($Config['search'])) { ?>
            <form class="form-light ms-xl-auto w-xl-200" method="post">
                <input type="hidden" name="_ACTION" value="filter">
                <div class="input-group input-group-inline">
                    <span class="input-group-text bg-transparent border-0 shadow-none ps-0 pe-3">
                        <svg width="18" height="18" stroke="currentColor" stroke-width="1.75" fill="none">
                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#search';?>"></use>
                        </svg>
                    </span>
                    <input type="text" name="q" class="form-control shadow-none bg-transparent border-0 ps-1" id="search" placeholder="<?php echo $this->translate('Search');?> .." aria-label="Search">
                </div>
            </form>
            <?php } ?>
        </div>
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="modal" data-bs-target="#aside" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a href="" class="navbar-brand d-block d-lg-none">
            <img src="<?php echo ASSETS.'/img/logo.svg';?>" height="20">
        </a>
        <ul class="nav navbar-menu align-items-center">
            <!-- User dropdown menu -->
            <li class="nav-item dropdown">
                <a href="#" data-bs-toggle="dropdown" class="nav-link d-flex align-items-center px-0 px-lg-3">
                    <?php echo gravatar($AuthUser['id'],$AuthUser['username'],$AuthUser['avatar'],'avatar avatar-sm text-white rounded-circle',$AuthUser['color']);?>
                    <div class="ps-3 lh-xs">
                        <div class="text-muted fs-xs"><?php echo $this->translate('Hello');?>,</div>
                        <div class="fs-xs fw-semibold"><?php echo $AuthUser['firstname'];?></div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <div class="">