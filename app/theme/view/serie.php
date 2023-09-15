<?php require PATH . '/theme/view/common/head.php'; ?>
<?php require PATH . '/theme/view/common/header.php'; ?>
<div class="layout-section">
    <ol class="breadcrumb d-inline-flex text-muted mb-3">
        <li class="breadcrumb-item"><a href="<?php echo APP.'/'.$this->translate('series');?>">
                <?php echo $this->translate('TV Shows');?></a></li>
        <li class="breadcrumb-item active" aria-current="page">
            <?php echo $Listing['title'];?>
        </li>
    </ol>
    <div class="row gx-xl-5">
        <div class="col-md-auto">
            <div class="w-lg-250 w-md-200 w-150px mb-3 mx-auto d-none d-lg-block">
                <?php echo picture(POST_FOLDER,$Listing['image'],'img-fluid rounded-1 mb-3',$Listing['title'],POST_X.','.POST_Y);?>
                <?php if(isset($Listing['keywords'])) { ?>
                <?php $Keywords = explode(',', $Listing['keywords']); ?>
                <?php if(count($Keywords)>=1 AND strlen($Keywords[0])>0) { ?>
                <div class="card-tags">
                    <?php foreach($Keywords as $Keyword) { ?>
                    <a href="<?php echo tag(tagger($Keyword));?>">
                        <?php echo $Keyword;?></a>
                    <?php } ?>
                </div>
                <?php } ?>
                <?php } ?>
            </div>
        </div>
        <div class="col-md">
                <ul class="list-inline list-separator fs-xs text-gray-500 mb-1">
                    <?php if(isset($Listing['country_name'])) { ?>
                    <li class="list-inline-item"><a href="" class="text-current fw-semibold">
                            <?php echo $Listing['country_name'];?></a></li>
                    <?php } ?>
                    <li class="list-inline-item">
                        <?php echo dating($Listing['release_date']);?>
                    </li>
                    <?php if(isset($Listing['runtime'])) { ?>
                    <li class="list-inline-item">
                        <?php echo duration($Listing['runtime']);?>
                    </li>
                    <?php } ?>
                </ul>
            <h1 class="h3 mb-1">
                <?php echo $Listing['title'];?>
            </h1>
            <h2 class="fs-base mb-3 fw-normal text-gray-600">
                <?php echo $Listing['title_sub'];?>
            </h2>
                <div class="mb-3 d-flex align-items-center mt-2 mt-md-0">
                    <?php if(isset($Listing['trailer'])) { ?>
                    <button class="btn btn-ghost rounded-pill me-2 px-xl-4" data-bs-toggle="modal" data-bs-target="#xl" data-remote="<?php echo APP.'/modal/trailer?link='.$Listing['trailer'];?>">
                        <?php echo $this->translate('Watch trailer');?></button>
                    <?php } ?>
                    <?php if(isset($AuthUser['id'])) { ?>
                    <div class="dropdown">
                        <button class="btn btn-square btn-transparent rounded-circle dropdown-toggle" type="button" id="moreDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg width="16" height="16" fill="currentColor">
                                <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#dot-vertical';?>"></use>
                            </svg>
                        </button>
                        <ul class="dropdown-menu mt-2" aria-labelledby="moreDropdown">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sm" data-remote="<?php echo APP.'/modal/bookmark?id='.$Listing['id'];?>"><?php echo $this->translate('Save bookmark');?></a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#m" data-remote="<?php echo APP.'/modal/share?url='.$Config['url'].'&title='.urlencode($Config['title']);?>"><?php echo $this->translate('Share');?></a></li> 
                            <li class="dropdown-divider bg-gray-300"></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sm" data-remote="<?php echo APP.'/modal/report?id='.$Listing['id'];?>"><?php echo $this->translate('Report');?></a></li>
                        </ul>
                    </div>
                    <?php } ?>
                </div>
            <div class="fs-xs text-muted">
                <?php echo $this->translate('Category');?>
            </div>
            <div class="card-tag mb-3">
                <?php foreach($Genres as $Genre) { ?>
                <a href="<?php echo genre($Genre['id'],$Genre['self']);?>">
                    <?php echo $Genre['name'];?></a>
                <?php } ?>
            </div>
            <?php if(isset($Listing['platform_name'])) { ?>
            <div class="fs-xs text-muted mb-3">
                <div class="mb-2">
                    <?php echo $this->translate('Platform');?>
                </div>
                <a href="<?php echo platform($Listing['platform'],$Listing['platform_self']);?>" class="d-inline-block py-1" data-bs-tooltip="tooltip" data-bs-placement="top" title="<?php echo $Listing['platform_name'];?>"><img src="<?php echo UPLOAD.'/'.PLATFORM_FOLDER.'/'.$Listing['platform_image'];?>" height="24"></a>
            </div>
            <?php } ?>
            <p class="fs-sm text-muted" data-more="" data-limit="6">
                <?php echo $Listing['overview'];?>
            </p>
            <?php if(isset($Data['notification'])) { ?>
            <div class="bg-alert mb-4 fw-semibold text-center">
                <?php echo $Data['notification'];?>
            </div>
            <?php } ?>
            <div class="card-season">
                <?php 
                    // Season
                    $Seasons = $this->db->from(null,'
                        SELECT 
                        posts_season.id,  
                        posts_season.name
                        FROM `posts_season`
                        WHERE posts_season.post_id = "'.$Listing['id'].'"
                        ORDER BY cast(name as unsigned) ASC')
                    ->all(); 
                    ?>
                <div class="accordion season-accordion" id="seasonAccordion">
                    <?php 
                        $i=1;
                        foreach ($Seasons as $Season) {

                            // Episodes
                            $Episodes = $this->db->from(null,'
                                SELECT 
                                posts_episode.id,  
                                posts_episode.title,  
                                posts_episode.title_number,  
                                posts_episode.release_date,  
                                posts_episode.created
                                FROM `posts_episode`
                                WHERE posts_episode.status = "1" AND posts_episode.post_id = '.$Listing['id'].' AND posts_episode.season_id = '.$Season['id'].'
                                ')
                            ->all();
                        if(count($Episodes) > 0) {
                        ?>
                    <div class="accordion-item">
                        <div class="accordion-header" type="button" data-bs-toggle="collapse" data-bs-target="#season<?php echo $Season['id'];?>" aria-expanded="<?php echo ($i == 1 ? 'true' : 'false');?>" aria-controls="season<?php echo $Season['id'];?>">
                            <?php echo $this->translate('Season').' '.$Season['name'];?>
                        </div>
                        <div id="season<?php echo $Season['id'];?>" class="accordion-collapse collapse <?php if($i == 1) echo 'show';?>" aria-labelledby="season<?php echo $Season['id'];?>" data-bs-parent="#seasonAccordion">
                            <div class="py-2 episodes">
                                <?php 
                                    foreach ($Episodes as $Episode) { 
                                        if(isset($AuthUser['id'])) {
                                            $View = $this->db->from('posts_log')->where('user_id',$AuthUser['id'])->where('episode_id',$Episode['id'])->first();
                                        }
                                    ?>
                                <div class="card-episode">
                                    <div class="form-check form-switch me-2" data-bs-tooltip="tooltip" data-bs-placement="top" title="<?php echo $this->translate('Watched');?>">
                                        <input class="form-check-input episode-check" type="checkbox" role="switch" id="e<?php echo $Episode['id'];?>" value="<?php echo $Episode['id'];?>" <?php if(isset($View['episode_id'])) echo 'checked=""' ;?> data-post="
                                        <?php echo $Listing['id'];?>">
                                    </div>
                                    <a href="<?php echo episode($Listing['id'],$Listing['self'],$Season['name'],$Episode['title_number']);?>" class="episode">
                                        <?php echo $this->translate('Episode').' '.$Episode['title_number'];?>
                                    </a>
                                    <a href="<?php echo episode($Listing['id'],$Listing['self'],$Season['name'],$Episode['title_number']);?>" class="name">
                                        <?php echo $Episode['title'];?>
                                    </a>
                                    <div class="date">
                                        <?php if(empty($Episode['release_date'])) { ?>
                                        <?php echo dating($Episode['created']);?>
                                        <?php } else { ?>
                                        <?php echo dating($Episode['release_date']);?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php $i++; } ?>
                </div>
            </div>
            <div class="post-toolbar mt-4">
                <ul data-ajax-tab="">
                    <li>
                        <a href="<?php echo post($Listing['id'],$Listing['self'],$Listing['type'].'/casting');?>" data-url="<?php echo post($Listing['id'],$Listing['self'],$Listing['type']).'/casting?ajax=true';?>" class="<?php echo (empty($Route->params->tab) ? 'active' : '');?>">Casting</a>
                    </li>
                    <?php if(empty($Data['comment']) OR (isset($Data['comment']) AND $Data['comment'] != 1)) { ?>
                    <li>
                        <a href="<?php echo post($Listing['id'],$Listing['self'],$Listing['type']).'/comments';?>" data-url="<?php echo post($Listing['id'],$Listing['self'],$Listing['type']).'/comments?ajax=true';?>" class="<?php echo ((isset($Route->params->tab) AND $Route->params->tab == 'comments') ? 'active' : '');?>">Comment<span class="ms-2 fs-xs opacity-50">
                                <?php echo $Listing['comments'];?></span></a>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo post($Listing['id'],$Listing['self'],$Listing['type']).'/multimedia';?>" data-url="<?php echo post($Listing['id'],$Listing['self'],$Listing['type']).'/multimedia?ajax=true';?>" class="<?php echo ((isset($Route->params->tab) AND $Route->params->tab == 'multimedia') ? 'active' : '');?>">Multimedia</a>
                    </li>
                </ul>
            </div>
            <div class="layout-section pt-2">
                <div class="layout-tab-content">
                    <?php if(empty($Route->params->tab)) { ?>
                    <?php require PATH . '/theme/view/common/post.casting.php'; ?>
                    <?php } elseif(isset($Route->params->tab) AND in_array($Route->params->tab,array('comments','multimedia','casting','download','subtitle'))) { ?>
                    <?php require PATH . '/theme/view/common/post.'.$Route->params->tab.'.php'; ?>
                    <?php } else { ?>
                    <?php header('location:'.APP.'/404');?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php echo ads($Ads,1,'mx-lg-auto mb-3');?>
    <div class="layout-section pt-4">
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
</div>
<?php require PATH . '/theme/view/common/javascript.php'; ?>
<?php require PATH . '/theme/view/common/schema.serie.php';?>
<?php require PATH . '/theme/view/common/footer.php'; ?>