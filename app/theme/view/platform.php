<?php require PATH . '/theme/view/common/head.php'; ?>
<?php require PATH . '/theme/view/common/header.php'; ?>
<div class="layout-section">
    <ol class="breadcrumb d-inline-flex text-muted mb-3">
        <li class="breadcrumb-item"><a href="<?php echo APP.'/'.$this->translate('platforms');?>">
                <?php echo $this->translate('Platforms');?></a></li>
        <li class="breadcrumb-item active" aria-current="page">
            <?php echo $Listing['name'];?>
        </li>
    </ol>
    <div class="row gx-xl-5">
        <div class="col-md-auto d-none d-lg-block">
            <?php echo picture(PLATFORM_FOLDER,$Listing['image'],'img-fluid',$Listing['name'],'150,auto');?>
        </div>
        <div class="col-md">
            <h1 class="mb-1 h3 fw-semibold">
                <?php echo $Listing['name'];?>
            </h1>
            <?php if(isset($Listing['website'])) { ?>
            <a href="<?php echo $Listing['website'];?>" rel="nofollow" class="fs-sm mb-2 d-block text-current">
                <?php echo $Listing['website'];?>
            </a>
            <?php } ?>
        </div>
    </div>
    <div class="layout-section mt-4">
        <div class="layout-heading mb-3">
            <h3 class="layout-title fw-semibold fs-base">
                <?php echo $Listing['name'].' '.$this->translate('Filmography');?>
            </h3>
        </div>
        <div class="row <?php if(get($Settings, 'data.header', 'customize') == 'v2') { echo 'row-cols-xxl-'.(int)get($Settings,'data.column','customize'); } else { echo 'row-cols-xxl-'.(int)get($Settings,'data.column','customize'); } ?> row-cols-md-4 row-cols-2">
            <?php foreach ($Posts as $Post) { ?>
            <div class="col-lg-2">
                <a href="<?php echo post($Post['id'],$Post['self'],$Post['type']);?>" class="card card-movie">
                    <div class="card-overlay">
                        <?php echo picture(POST_FOLDER,$Post['image'],'img-fluid rounded-1',$Post['title'],POST_X.','.POST_Y);?>
                        <?php if(isset($Post['vote_average'])) { ?>
                        <div class="card-imdb">
                            <div>
                                <?php echo $Post['vote_average'];?>
                            </div>
                            <svg x="0px" y="0px" width="36px" height="36px" viewBox="0 0 36 36">
                                <circle fill="none" stroke-width="1" cx="18" cy="18" r="16" stroke-dasharray="77 100" stroke-dashoffset="0" transform="rotate(-90 18 18)"></circle>
                            </svg>
                        </div>
                        <?php } ?>
                        <?php if(isset($Post['upcoming']) AND $Post['upcoming'] == 1) { ?>
                        <div class="card-upcoming">
                            <?php echo $this->translate('Upcoming');?>
                        </div>
                        <?php } ?>
                        <div class="card-play"></div>
                    </div>
                    <div class="card-body">
                        <ul class="list-inline list-separator fs-xs text-muted mb-1">
                            <li class="list-inline-item">
                                <?php echo $Post['name'];?>
                            </li>
                            <li class="list-inline-item">
                                <?php echo dating($Post['release_date']);?>
                            </li>
                        </ul>
                        <h3 class="title">
                            <?php echo $Post['title'];?>
                        </h3>
                        <?php if(get($Settings,'data.subtitle','general') == 1) { ?>
                        <h4 class="title_sub">
                            <?php echo $Post['title_sub'];?>
                        </h4>
                        <?php } ?>
                    </div>
                </a>
            </div>
            <?php } ?>
        </div>
        <div class="text-center">
            <?php echo $Pagination;?>
        </div>
    </div>
</div>
<?php echo ads($Ads,1,'mx-lg-auto py-3 px-3 mb-3');?>
<?php require PATH . '/theme/view/common/javascript.php'; ?>
<?php require PATH . '/theme/view/common/footer.php'; ?>