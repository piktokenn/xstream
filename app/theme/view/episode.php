<?php require PATH . '/theme/view/common/head.php'; ?>
<?php require PATH . '/theme/view/common/header.php'; ?>
<div class="layout-section">
    <ol class="breadcrumb d-inline-flex text-muted mb-3">
        <li class="breadcrumb-item"><a href="<?php echo APP.'/'.$this->translate('series');?>">
                <?php echo $this->translate('Episode');?></a></li>
        <li class="breadcrumb-item active" aria-current="page">
            <?php echo $Listing['title'];?>
        </li>
    </ol>
    <div class="row gx-lg-4 gx-0">
        <div class="col-lg">
            <?php require PATH . '/theme/view/common/post.header.php'; ?>
        </div>
        <div class="col-lg-auto">
            <div class="w-lg-300 d-none d-lg-block">
                <?php echo ads($Ads,2,'mx-lg-auto mb-3');?>
                <div class="d-flex align-items-center flex-nowrap justify-content-between mb-3">
                    <?php if(isset($Prev['title_number'])) { ?>
                    <a href="<?php echo episode($Listing['id'],$Listing['self'],$Prev['season_name'],$Prev['title_number']);?>" class="btn btn-square btn-ghost rounded-circle">
                        <svg width="18" height="18" stroke="currentColor" fill="none" stroke-width="2">
                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#prev';?>" />
                        </svg>
                    </a>
                    <?php } ?>
                    <div class="fw-semibold fs-sm">
                        <?php echo $this->translate('Episodes of the TV Show');?>
                    </div>
                    <?php if(isset($Next['title_number'])) { ?>
                    <a href="<?php echo episode($Listing['id'],$Listing['self'],$Next['season_name'],$Next['title_number']);?>" class="btn btn-square btn-ghost rounded-circle">
                        <svg width="18" height="18" stroke="currentColor" fill="none" stroke-width="2">
                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#next';?>" />
                        </svg>
                    </a>
                    <?php } ?>
                </div>
                <?php 
                        // Episodes
                        $Episodes = $this->db->from(null,'
                                SELECT 
                                posts_episode.id,  
                                posts_episode.title,  
                                posts_episode.title_number,  
                                posts_episode.release_date
                                FROM `posts_episode`
                                WHERE posts_episode.status = "1" AND posts_episode.post_id = '.$Listing['id'].' AND posts_episode.season_id = '.$Listing['season_id'].'
                                ')
                        ->all();
                    ?>
                <ul class="card-episode-nav">
                    <?php foreach ($Episodes as $Episode) { ?>
                    <li><a href="<?php echo episode($Listing['id'],$Listing['self'],$Listing['season_name'],$Episode['title_number']);?>" <?php if($Episode['title_number']==$Listing['title_number']) echo 'class="active"' ;?> title="<?php echo $Listing['title'].' '.$Listing['season_name'].'. '.$this->translate('Season').' '.$Episode['title_number'].'. '.$this->translate('Episode');?>">
                            <?php echo $Episode['title_number'];?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <?php require PATH . '/theme/view/common/episode.tab.php'; ?>
    <?php echo ads($Ads,1,'mx-lg-auto mb-3');?>
    <div class="layout-section">
        <div class="layout-heading mb-3">
            <h3 class="layout-title fw-semibold fs-lg">
                <?php echo $this->translate('Recommended For You');?>
            </h3>
        </div>
        <div class="row row-cols-xxl-8 row-cols-lg-6 row-cols-2">
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
<?php require PATH . '/theme/view/common/schema.episode.php';?>
<?php require PATH . '/theme/view/common/footer.php'; ?>