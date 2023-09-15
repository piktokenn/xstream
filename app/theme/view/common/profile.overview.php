<div class="layout-section">
    <div class="row gx-lg-5 align-items-lg-center">
        <div class="col-lg-auto">
            <img src="<?php echo LOCAL.'/rank/'.$ProfileRank['level'].'.svg';?>" height="100">
        </div>
        <div class="col-lg">
            <div class="h4 mb-1">
                <?php echo $ProfileRank['name'].' '.$this->translate('Level').' '.$ProfileRank['level'];?>
            </div>
            <div class="fs-sm text-muted">
                <?php echo $this->translate('This player have exceeded');?>
                <?php echo (int)$Listing['xp'];?> xp</div>
            <div class="progress mt-3 bg-gray-200" style="height: 12px;">
                <div class="progress-bar bg-theme rounded-pill" role="progressbar" style="width: <?php echo $ProgressBar ?>%" aria-valuenow="<?php echo $ProgressBar ?>" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
</div>
<div class="layout-section">
    <div class="layout-heading mb-3 text-muted d-flex align-items-center">
        <h3 class="fs-lg fw-bold mb-0">
            <?php echo $this->translate('Watch history');?>
        </h3>
        <?php if(count($Historys) > 0) { ?>
        <a href="<?php echo user($Listing['id'],$Listing['username']).'/history';?>" class="fs-sm text-current ms-auto">
            <?php echo $this->translate('View all');?></a>
        <?php } ?>
    </div>
    <?php if(count($Historys) > 0) { ?>
    <div class="row row-cols-2">
        <?php foreach ($Historys as $History) { ?>
        <div class="col-lg-3">
            <a href="<?php echo post($History['id'],$History['self'],$History['type']);?>" class="card card-movie">
                <div class="card-overlay">
                    <?php echo picture(POST_FOLDER,$History['image'],'img-fluid rounded-1',$History['title'],POST_X.','.POST_Y);?>
                    <?php if(isset($History['vote_average'])) { ?>
                    <div class="card-imdb">
                        <div>
                            <?php echo $History['vote_average'];?>
                        </div>
                        <svg x="0px" y="0px" width="36px" height="36px" viewBox="0 0 36 36">
                            <circle fill="none" stroke-width="1" cx="18" cy="18" r="16" stroke-dasharray="77 100" stroke-dashoffset="0" transform="rotate(-90 18 18)"></circle>
                        </svg>
                    </div>
                    <?php } ?>
                    <?php if(isset($History['upcoming']) AND $History['upcoming'] == 1) { ?>
                    <div class="card-upcoming">
                        <?php echo $this->translate('Upcoming');?>
                    </div>
                    <?php } ?>
                    <div class="card-play"></div>
                </div>
                <div class="card-body">
                    <ul class="list-inline list-separator fs-xs text-muted mb-1">
                        <li class="list-inline-item">
                            <?php echo $History['name'];?>
                        </li>
                        <li class="list-inline-item">
                            <?php echo dating($History['release_date']);?>
                        </li>
                    </ul>
                    <h3 class="title">
                        <?php echo $History['title'];?>
                    </h3>
                    <?php if(get($Settings,'data.subtitle','general') == 1) { ?>
                    <h4 class="title_sub">
                        <?php echo $History['title_sub'];?>
                    </h4>
                    <?php } ?>
                </div>
            </a>
        </div>
        <?php } ?>
    </div>
    <?php } else { ?>
    <div class="fs-sm text-muted">
        <?php echo $this->translate('Nothing watched yet');?>
    </div>
    <?php } ?>
</div>
<div class="layout-section">
    <div class="layout-heading mb-3 text-muted d-flex align-items-center">
        <h3 class="fs-lg fw-bold mb-0">
            <?php echo $this->translate('Collections');?>
        </h3>
        <?php if(count($Collections) > 0) { ?>
        <a href="<?php echo user($Listing['id'],$Listing['username']).'/collection';?>" class="fs-sm text-current ms-auto"><?php echo $this->translate('View all');?></a>
        <?php } ?>
    </div>
    <?php if(count($Collections) > 0) { ?>
    <div class="row">
        <?php foreach ($Collections as $Collection) { ?>
        <div class="col-lg-4">
            <div class="card card-collection h-100" style="background-color: <?php echo $Collection['color'];?>">
                <div class="card-body">
                    <h3 class="title mb-1"><a href="<?php echo collection($Collection['id'],$Collection['self']);?>" class="text-white">
                            <?php echo $Collection['name'];?></a></h3>
                    <ul class="list-inline mb-0 fs-xs text-white-50">
                        <li class="list-inline-item"><a href="<?php echo user($Listing['id'],$Listing['username']);?>" class="text-current fw-semibold">
                                <?php echo $Listing['username'];?></a></li>
                        <li class="list-inline-item">
                            <?php echo $Collection['total'].' '.$this->translate('post avaible');?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } else { ?>
    <div class="fs-sm text-muted">
        <?php echo $this->translate('No collections yet');?>
    </div>
    <?php } ?>
</div>
<div class="layout-section">
    <div class="layout-heading mb-3 text-muted d-flex align-items-center">
        <h3 class="fs-lg fw-bold mb-0">
            <?php echo $this->translate('What I like');?>
        </h3>
        <?php if(count($Likes) > 0) { ?>
        <a href="<?php echo user($Listing['id'],$Listing['username']).'/like';?>" class="fs-sm text-current ms-auto">
            <?php echo $this->translate('View all');?></a>
        <?php } ?>
    </div>
    <?php if(count($Likes) > 0) { ?>
    <div class="row row-cols-2">
        <?php foreach ($Likes as $Like) { ?>
        <div class="col-lg-3">
            <a href="<?php echo post($Like['id'],$Like['self'],$Like['type']);?>" class="card card-movie">
                <div class="card-overlay">
                    <?php echo picture(POST_FOLDER,$Like['image'],'img-fluid rounded-1',$Like['title'],POST_X.','.POST_Y);?>
                    <?php if(isset($Like['vote_average'])) { ?>
                    <div class="card-imdb">
                        <div>
                            <?php echo $Like['vote_average'];?>
                        </div>
                        <svg x="0px" y="0px" width="36px" height="36px" viewBox="0 0 36 36">
                            <circle fill="none" stroke-width="1" cx="18" cy="18" r="16" stroke-dasharray="77 100" stroke-dashoffset="0" transform="rotate(-90 18 18)"></circle>
                        </svg>
                    </div>
                    <?php } ?>
                    <?php if(isset($Like['upcoming']) AND $Like['upcoming'] == 1) { ?>
                    <div class="card-upcoming">
                        <?php echo $this->translate('Upcoming');?>
                    </div>
                    <?php } ?>
                    <div class="card-play"></div>
                </div>
                <div class="card-body">
                    <ul class="list-inline list-separator fs-xs text-muted mb-1">
                        <li class="list-inline-item">
                            <?php echo $Like['name'];?>
                        </li>
                        <li class="list-inline-item">
                            <?php echo dating($Like['release_date']);?>
                        </li>
                    </ul>
                    <h3 class="title">
                        <?php echo $Like['title'];?>
                    </h3>
                    <?php if(get($Settings,'data.subtitle','general') == 1) { ?>
                    <h4 class="title_sub">
                        <?php echo $Like['title_sub'];?>
                    </h4>
                    <?php } ?>
                </div>
            </a>
        </div>
        <?php } ?>
    </div>
    <?php } else { ?>
    <div class="fs-sm text-muted">
        <?php echo $this->translate('No likes yet');?>
    </div>
    <?php } ?>
</div>