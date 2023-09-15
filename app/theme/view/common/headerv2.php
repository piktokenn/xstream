<?php if(ads($Ads,5)) { ?>
<div class="layout-skin"></div>
<?php } ?>
<div class="container">
    <div class="<?php if(ads($Ads,5)) { ?>layout-app<?php } ?>">
        <div class="row gx-lg-3 gx-0">
            <div class="col-lg-auto">
                <div class="w-lg-250">
                    <div class="navbar navbar-vertical navbar-expand-lg layout-header navbar-dark pt-3">
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
                            <ul class="navbar-nav mb-2 mt-3 mb-lg-0 fs-sm">
                                <?php if(get($Settings,'data.explore','customize') == 1) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo APP.'/'.$this->translate('explore');?>">
                                        <svg fill="currentColor">
                                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#compass';?>"></use>
                                        </svg>
                                        <?php echo $this->translate('Explore');?>
                                    </a>
                                </li>
                                <?php } ?>
                                <?php if(get($Settings,'data.movies','customize') == 1) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo APP.'/'.$this->translate('movies');?>">
                                        <svg fill="currentColor">
                                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#movies';?>"></use>
                                        </svg>
                                        <?php echo $this->translate('Movies');?>
                                    </a>
                                </li>
                                <?php } ?>
                                <?php if(get($Settings,'data.series','customize') == 1) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo APP.'/'.$this->translate('series');?>">
                                        <svg fill="currentColor">
                                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#series';?>"></use>
                                        </svg>
                                        <?php echo $this->translate('TV Shows');?>
                                    </a>
                                </li>
                                <?php } ?>
                                <?php if(get($Settings,'data.topimdb','customize') == 1) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo APP.'/'.$this->translate('top-imdb');?>">
                                        <svg fill="currentColor">
                                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#fire';?>"></use>
                                        </svg>
                                        <?php echo $this->translate('Top IMDb');?></a>
                                </li>
                                <?php } ?>
                                <?php if(get($Settings,'data.people','customize') == 1) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo APP.'/'.$this->translate('peoples');?>">
                                        <svg fill="currentColor">
                                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#user';?>"></use>
                                        </svg>
                                        <?php echo $this->translate('People');?></a>
                                </li>
                                <?php } ?>
                                <?php if(get($Settings,'data.platform','customize') == 1) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo APP.'/'.$this->translate('platforms');?>">
                                        <svg fill="currentColor">
                                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#platforms';?>"></use>
                                        </svg>
                                        <?php echo $this->translate('Platform');?></a>
                                </li>
                                <?php } ?>
                                <li class="my-lg-2"></li>
                                <li class="nav-heading">
                                    <?php echo $this->translate('Community');?>
                                </li>
                                <?php if(get($Settings,'data.community','customize') == 1) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo APP.'/'.$this->translate('community');?>">
                                        <svg fill="currentColor">
                                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#comment';?>"></use>
                                        </svg>
                                        <?php echo $this->translate('Community');?></a>
                                </li>
                                <?php } ?>
                                <?php if(get($Settings,'data.request','customize') == 1) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo APP.'/'.$this->translate('request');?>">
                                        <svg fill="currentColor">
                                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#requests';?>"></use>
                                        </svg>
                                        <?php echo $this->translate('Request');?></a>
                                </li>
                                <?php } ?>
                                <li class="my-lg-3 d-none d-lg-block"></li>
                                <li class="nav-heading d-none d-lg-block">
                                    <?php echo $this->translate('Most viewed');?>
                                </li>
                                <?php $i=1; foreach($Populars as $Popular) { ?>
                                <li class="nav-item d-none d-lg-block">
                                    <a href="<?php echo post($Popular['id'],$Popular['self'],$Popular['type']);?>" class="nav-link d-block text-wrap">
                                        <div class="fs-sm w-lg-200 h-2x">
                                            <?php echo $Popular['title'];?>
                                        </div>
                                        <div class="fs-xs text-muted">
                                            <?php echo hitview($Popular['view']);?>
                                        </div>
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md">
                <nav class="navbar navbar-expand-lg layout-header navbar-dark mb-lg-2 d-none d-lg-flex">
                    <div class="collapse navbar-collapse" id="navbar">
                        <form class="form-search w-lg-300 py-1 mb-3 mb-lg-0" action="<?php echo APP.'/'.$this->translate('search');?>" method="post">
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