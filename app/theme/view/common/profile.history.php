<div class="layout-section">
    <div class="layout-heading mb-3 text-muted d-flex align-items-center">
        <h3 class="fs-lg fw-bold mb-0">
            <?php echo $this->translate('Watch history');?>
        </h3>
    </div>
    <?php if(isset($Posts)) { ?>
    <div class="row row-cols-2">
        <?php foreach ($Posts as $Post) { ?>
        <div class="col-lg-3">
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
    <?php echo $Pagination; ?>
    <?php } else { ?>
    <div class="fs-sm text-muted">
        <?php echo $this->translate('No watch yet');?>
    </div>
    <?php } ?>
</div>