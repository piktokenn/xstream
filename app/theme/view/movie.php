<?php require PATH . '/theme/view/common/head.php'; ?>
<?php require PATH . '/theme/view/common/header.php'; ?>
<div class="layout-section">
    <ol class="breadcrumb d-inline-flex text-muted mb-3">
        <li class="breadcrumb-item"><a href="<?php echo APP.'/'.$this->translate('movies');?>">
                <?php echo $this->translate('Movies');?></a></li>
        <li class="breadcrumb-item active" aria-current="page">
            <?php echo $Listing['title'];?>
        </li>
    </ol>
    <div class="row gx-lg-4 gx-0">
        <div class="col-lg">
            <?php require PATH . '/theme/view/common/post.header.php'; ?>
        </div>
        <?php if(isset($More['id']) AND ads($Ads,2,'mx-lg-auto mb-3')) { ?>
        <div class="col-lg-auto d-none d-xxl-block">
            <div class="w-lg-300">
                <?php if(ads($Ads,2,'mx-lg-auto mb-3')) { ?>
                <?php echo ads($Ads,2,'mx-lg-auto mb-3');?>
                <?php } ?>
                <?php if(isset($More['id'])) { ?>
                <h3 class="fs-base fw-semibold mb-3">
                    <?php echo $this->translate('More content');?>
                </h3>
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <a href="<?php echo post($More['id'],$More['self'],$More['type']);?>" class="d-block">
                            <?php echo picture(POST_FOLDER,'thumb-'.$More['image'],'img-fluid rounded-1',$More['title'],POST_THUMB_X.','.POST_THUMB_Y);?>
                        </a>
                    </div>
                    <div class="col-lg-8">
                        <h4 class="fs-xs mb-0 fw-normal text-muted h-1x mb-1"><a href="<?php echo post($More['id'],$More['self'],$More['type']);?>" class="text-current">
                                <?php echo $More['title_sub'];?></a></h4>
                        <h3 class="fs-sm mb-1 text-body fw-normal h-2x"><a href="<?php echo post($More['id'],$More['self'],$More['type']);?>" class="text-current">
                                <?php echo $More['title'];?></a></h3>
                        <ul class="list-inline list-separator mb-1 fs-xs text-muted">
                            <li class="list-inline-item">
                                <a href="<?php echo post($More['id'],$More['self'],$More['type']);?>" class="text-current">
                                    <?php echo $More['name'];?></a>
                            </li>
                            <li class="list-inline-item">
                                <a class="text-cap text-muted mb-0" href="<?php echo post($More['id'],$More['self'],$More['type']);?>">
                                    <?php echo (int)$More['view'];?> view</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="text-cap text-muted mb-0" href="<?php echo post($More['id'],$More['self'],$More['type']);?>">
                                    <?php echo dating($More['release_date'],true);?></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php if(isset($Data['notification'])) { ?>
    <div class="bg-alert mb-4 fw-semibold text-center">
        <?php echo $Data['notification'];?>
    </div>
    <?php } ?>
    <?php require PATH . '/theme/view/common/post.tab.php'; ?>
    <?php echo ads($Ads,1,'mx-lg-auto py-3 px-3 mb-3');?>
    <div class="layout-section">
        <div class="layout-heading mb-3">
            <h3 class="layout-title fw-semibold fs-lg">
                <?php echo $this->translate('Recommended For You');?>
            </h3>
        </div>
        <div class="row <?php if(get($Settings, 'data.header', 'customize') == 'v2') { echo 'row-cols-xxl-'.(int)get($Settings,'data.column','customize'); } else { echo 'row-cols-xxl-'.(int)get($Settings,'data.column','customize'); } ?> row-cols-md-4 row-cols-2">
            <?php foreach ($Recommends as $Recommend) { ?>
            <div class="col-lg-2">
                <a href="<?php echo post($Recommend['id'],$Recommend['self'],$Recommend['type']);?>" class="card card-movie">
                    <div class="card-overlay">
                        <?php echo picture(POST_FOLDER,$Recommend['image'],'img-fluid rounded-1',$Recommend['title'],POST_X.','.POST_Y);?>
                        <?php if(isset($Recommend['vote_average'])) { ?>
                        <div class="card-imdb">
                            <div>
                                <?php echo $Recommend['vote_average'];?>
                            </div>
                            <svg x="0px" y="0px" width="36px" height="36px" viewBox="0 0 36 36">
                                <circle fill="none" stroke-width="1" cx="18" cy="18" r="16" stroke-dasharray="77 100" stroke-dashoffset="0" transform="rotate(-90 18 18)"></circle>
                            </svg>
                        </div>
                        <?php } ?>
                        <?php if(isset($Recommend['upcoming']) AND $Recommend['upcoming'] == 1) { ?>
                        <div class="card-upcoming">
                            <?php echo $this->translate('Upcoming');?>
                        </div>
                        <?php } ?>
                        <div class="card-play"></div>
                    </div>
                    <div class="card-body">
                        <ul class="list-inline list-separator fs-xs text-muted mb-1">
                            <li class="list-inline-item">
                                <?php echo $Recommend['name'];?>
                            </li>
                            <li class="list-inline-item">
                                <?php echo dating($Recommend['release_date']);?>
                            </li>
                        </ul>
                        <h3 class="title">
                            <?php echo $Recommend['title'];?>
                        </h3>
                        <?php if(get($Settings,'data.subtitle','general') == 1) { ?>
                        <h4 class="title_sub">
                            <?php echo $Recommend['title_sub'];?>
                        </h4>
                        <?php } ?>
                    </div>
                </a>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php echo ads($Ads,1,'mx-lg-auto py-3 px-3 mb-3');?>
</div>
<?php require PATH . '/theme/view/common/javascript.php'; ?>
<?php require PATH . '/theme/view/common/schema.movie.php';?>
<?php require PATH . '/theme/view/common/footer.php'; ?>