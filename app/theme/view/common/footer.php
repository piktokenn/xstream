
<?php if(get($Settings, 'data.header', 'customize') == 'v2') { ?>
</div>
<?php } ?>
<div class="py-3">
    <div class="row">
        <div class="col-lg-4 col-md-12">
            <div class="mb-3">
                <a href="<?php echo APP;?>" class="mb-3 d-inline-block">
                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo LOCAL.'/'.get($Settings,'data.logo','general');?>" class="lazyload" width="156" height="28" alt="<?php echo get($Settings,'data.company','general');?>">
                </a>
                <div class="mb-3 fs-sm pe-lg-4">
                    <p>
                        <?php echo get($Settings, 'data.description', 'general');?>
                    </p>
                </div>
                <div class="row gx-lg-3 mb-3">
                    <?php if(get($Settings,'data.google_play','general')) { ?>
                    <div class="col-md-5">
                        <a href="<?php echo get($Settings,'data.google_play','general');?>" target="_blank" class="btn btn-ghost d-flex mb-3 align-items-center rounded-2 text-align-start">
                            <svg width="20" height="20" fill="currentColor">
                                <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#google-play';?>"></use>
                            </svg>
                            <div class="ps-3 text-start">
                                <div class="fs-xxs text-uppercase fw-bold text-white-50">Get it on</div>
                                <div class="fs-sm fw-semibold">Google Play</div>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                    <?php if(get($Settings,'data.app_store','general')) { ?>
                    <div class="col-md-5">
                        <a href="<?php echo get($Settings,'data.app_store','general');?>" target="_blank" class="btn btn-ghost mb-3 d-flex align-items-center rounded-2 text-align-start">
                            <svg width="24" height="24" fill="currentColor">
                                <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#app-store';?>"></use>
                            </svg>
                            <div class="ps-3 text-start">
                                <div class="fs-xxs text-white-50">Download on the</div>
                                <div class="fs-sm fw-semibold">App Store</div>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                </div>
                <div class="fs-xs text-muted">
                    <span>Copyright ©
                        <?php echo date('Y');?>
                        <?php echo DOMAIN;?>.</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="mb-4">
                <!-- list -->
                <h3 class="fs-xs text-muted fw-semibold mb-2">
                    <?php echo $this->translate('Genre');?>
                </h3>
                <ul class="list-unstyled nav nav-footer fs-sm row">
                    <?php foreach($HomeGenres as $HomeGenre) { ?>
                    <li class="col-4"><a href="<?php echo genre($HomeGenre['id'],$HomeGenre['self']);?>" class="nav-link px-0 py-1">
                            <?php echo $HomeGenre['name'];?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="mb-4">
                <!-- list -->
                <h3 class="fs-xs text-muted fw-semibold mb-2">
                    <?php echo $this->translate('Menu');?>
                </h3>
                <ul class="list-unstyled nav flex-column nav-footer fs-sm">
                    <?php if(get($Settings,'data.discovery','customize') == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link px-0 py-1" href="<?php echo APP.'/'.$this->translate('discovery');?>">
                            <?php echo $this->translate('Discovery');?></a>
                    </li>
                    <?php } ?>
                    <?php if(get($Settings,'data.movies','customize') == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link px-0 py-1" href="<?php echo APP.'/'.$this->translate('movies');?>">
                            <?php echo $this->translate('Movies');?></a>
                    </li>
                    <?php } ?>
                    <?php if(get($Settings,'data.series','customize') == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link px-0 py-1" href="<?php echo APP.'/'.$this->translate('series');?>">
                            <?php echo $this->translate('TV Shows');?></a>
                    </li>
                    <?php } ?>
                    <?php if(get($Settings,'data.community','customize') == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link px-0 py-1" href="<?php echo APP.'/'.$this->translate('community');?>">
                            <?php echo $this->translate('Community');?></a>
                    </li>
                    <?php } ?>
                    <?php if(get($Settings,'data.discussions','customize') == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link px-0 py-1" href="<?php echo APP.'/'.$this->translate('discussions');?>">
                            <?php echo $this->translate('Discussions');?></a>
                    </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link px-0 py-1" href="<?php echo APP.'/'.$this->translate('peoples');?>">
                            <?php echo $this->translate('Peoples');?></a>
                    </li>
                    <?php if(get($Settings,'data.request','customize') == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link px-0 py-1" href="<?php echo APP.'/'.$this->translate('request');?>">
                            <?php echo $this->translate('Request');?></a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="mb-4">
                <!-- list -->
                <h3 class="fs-xs text-muted fw-semibold mb-2">
                    <?php echo $this->translate('Page');?>
                </h3>
                <ul class="list-unstyled nav flex-column nav-footer fs-sm">
                    <?php 
                        $Pages = $this->db->from('pages')->where('status',1)->all();
                        foreach($Pages as $Page) {
                        ?>
                    <li class="nav-item">
                        <a class="nav-link px-0 py-1" href="<?php echo page($Page['id'],$Page['self']);?>">
                            <?php echo $Page['name'];?></a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php if(get($Settings, 'data.header', 'customize') == 'v2') { ?> 
</div>
</div>
</div>
<?php } else { ?>
</div>
</div>
<?php } ?>
<div class="modal-box">
    <div class="modal-box-content text-center">
        <img src="<?php echo THEME.'/img/adblock.webp';?>" class="mb-4" width="80px" height="80px">
        <h3 class="h3 mb-2"><?php echo $this->translate('Adblock Detected');?></h3>
        <div class="text-muted"><?php echo $this->translate('Please disable AdBlock to proceed to the destination page');?></div>
    </div>
</div>
<button type="button" class="btn btn-square btn-scroll btn-lg rounded-circle">
    <svg width="18" height="18" fill="currentColor">
        <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#up';?>"></use>
    </svg>
</button>
<div class="modal" id="xl" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
        </div>
    </div>
</div>
<div class="modal" id="lg" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>
<div class="modal" id="m" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        </div>
    </div>
</div>
<div class="modal" id="sm" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
        </div>
    </div>
</div>
</body>

</html>