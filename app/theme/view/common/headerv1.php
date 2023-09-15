<?php if(ads($Ads,5)) { ?>
<div class="layout-skin"></div>
<?php } ?>
<div class="container">
    <div class="<?php if(ads($Ads,5)) { ?>layout-app<?php } ?>">
        <nav class="navbar navbar-expand-lg layout-header navbar-dark">
            <button class="navbar-toggler border-0 shadow-none px-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Logo -->
            <a href="<?php echo APP;?>" class="navbar-brand me-xl-4 me-lg-3 text-gray-900">
                <img src="<?php echo LOCAL.'/'.get($Settings,'data.logo','general');?>" width="156" height="28" alt="<?php echo get($Settings,'data.company','general');?>">
            </a>
            <button class="navbar-toggler border-0 shadow-none px-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <svg width="20" height="20" stroke="currentColor" stroke-width="2" fill="none">
                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#search';?>"></use>
                </svg>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav mb-2 mb-lg-0 fs-sm align-items-xl-center">
                    <?php if(get($Settings,'data.explore','customize') == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP.'/'.$this->translate('explore');?>">
                            <?php echo $this->translate('Explore');?></a>
                    </li>
                    <?php } ?>
                    <?php if(get($Settings,'data.movies','customize') == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP.'/'.$this->translate('movies');?>">
                            <?php echo $this->translate('Movies');?></a>
                    </li>
                    <?php } ?>
                    <?php if(get($Settings,'data.series','customize') == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP.'/'.$this->translate('series');?>">
                            <?php echo $this->translate('TV Shows');?></a>
                    </li>
                    <?php } ?>
                    <?php if(get($Settings,'data.topimdb','customize') == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP.'/'.$this->translate('top-imdb');?>">
                            <?php echo $this->translate('Top IMDb');?></a>
                    </li>
                    <?php } ?>
                    <li class="mx-xxl-3"></li>
                    <?php if(get($Settings,'data.community','customize') == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP.'/'.$this->translate('community');?>">
                            <?php echo $this->translate('Community');?></a>
                    </li>
                    <?php } ?>
                    <?php if(get($Settings,'data.request','customize') == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP.'/'.$this->translate('request');?>">
                            <?php echo $this->translate('Request');?></a>
                    </li>
                    <?php } ?>
                </ul>
                <form class="form-search w-lg-250 ms-xl-4 mb-3 mb-lg-0" action="<?php echo APP.'/'.$this->translate('search');?>" method="post">
                    <input type="hidden" name="_TOKEN" value="<?php echo $Token;?>">
                    <input type="hidden" name="_ACTION" value="search">
                    <div class="input-group input-group-inline shadow-none">
                        <span class="input-group-text bg-transparent border-0 text-gray-500 shadow-none">
                            <svg width="18" height="18" stroke="currentColor" stroke-width="1.75" fill="none">
                                <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#search';?>"></use>
                            </svg>
                        </span>
                        <input type="text" name="q" class="form-control form-control-flush bg-transparent border-0 ps-0" id="search" placeholder="<?php echo $this->translate('Search');?> .." aria-label="Search" required="true" minlength="3">
                    </div>
                </form>
                <?php require PATH . '/theme/view/common/header.user.php'; ?>
            </div>
        </nav>