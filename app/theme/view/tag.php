<?php require PATH . '/theme/view/common/head.php'; ?>
<?php require PATH . '/theme/view/common/header.php'; ?>
<div class="layout-section">
    <ol class="breadcrumb d-inline-flex text-muted mb-2">
        <li class="breadcrumb-item"><a href="<?php echo APP;?>">
                <?php echo $this->translate('Home');?></a></li>
        <li class="breadcrumb-item active" aria-current="page">
            <?php echo Input::cleaner(mb_convert_case(str_replace('+', ' ', tagger($Route->params->q,true)), MB_CASE_TITLE, "UTF-8"));?>
        </li>
    </ol>
    <div class="layout-section">
        <div class="layout-heading">
            <div>
                <h1 class="layout-title">
                    <?php echo '"'.Input::cleaner(mb_convert_case(str_replace('+', ' ', tagger($Route->params->q,true)), MB_CASE_TITLE, "UTF-8")).'" '. $this->translate('containing the tag');?>
                </h1>
            </div>
        </div>
        <div class="row <?php if(get($Settings, 'data.header', 'customize') == 'v2') { echo 'row-cols-xxl-'.(int)get($Settings,'data.column','customize'); } else { echo 'row-cols-xxl-'.(int)get($Settings,'data.column','customize'); } ?> row-cols-md-4 row-cols-2">
            <?php foreach ($Listings as $Listing) { ?>
            <div class="col-lg-2">
                <a href="<?php echo post($Listing['id'],$Listing['self'],$Listing['type']);?>" class="card card-movie">
                    <div class="card-overlay">
                        <?php echo picture(POST_FOLDER,$Listing['image'],'img-fluid rounded-1',$Listing['title'],POST_X.','.POST_Y);?>
                        <?php if(isset($Listing['vote_average'])) { ?>
                        <div class="card-imdb">
                            <div>
                                <?php echo $Listing['vote_average'];?>
                            </div>
                            <svg x="0px" y="0px" width="36px" height="36px" viewBox="0 0 36 36">
                                <circle fill="none" stroke-width="1" cx="18" cy="18" r="16" stroke-dasharray="77 100" stroke-dashoffset="0" transform="rotate(-90 18 18)"></circle>
                            </svg>
                        </div>
                        <?php } ?>
                        <?php if(isset($Listing['upcoming']) AND $Listing['upcoming'] == 1) { ?>
                        <div class="card-upcoming">
                            <?php echo $this->translate('Upcoming');?>
                        </div>
                        <?php } ?>
                        <div class="card-play"></div>
                    </div>
                    <div class="card-body">
                        <ul class="list-inline list-separator fs-xs text-muted mb-1">
                            <li class="list-inline-item">
                                <?php echo $Listing['name'];?>
                            </li>
                            <li class="list-inline-item">
                                <?php echo dating($Listing['release_date']);?>
                            </li>
                        </ul>
                        <h3 class="title">
                            <?php echo $Listing['title'];?>
                        </h3>
                        <?php if(get($Settings,'data.subtitle','general') == 1) { ?>
                        <h4 class="title_sub">
                            <?php echo $Listing['title_sub'];?>
                        </h4>
                        <?php } ?>
                    </div>
                </a>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php echo ads($Ads,1,'mx-lg-auto py-3 px-3 mb-3');?>
<?php require PATH . '/theme/view/common/javascript.php'; ?>
<?php require PATH . '/theme/view/common/footer.php'; ?>