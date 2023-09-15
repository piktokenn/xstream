<div class="mb-4">
    <?php if(isset($Data['politicy']) AND $Data['politicy'] == 1) { ?>
    <div class="ratio ratio-21x9 rounded ratio-embed overflow-hidden">
        <div class="d-flex align-items-center justify-content-center flex-column noting">
            <div class="glitch" data-text="<?php echo $this->translate('Removed');?>">
                <?php echo $this->translate('Removed');?>
            </div>
            <div class="glitch glitch-text" data-text="<?php echo $this->translate('Removed at owner\'s request');?>">
                <?php echo $this->translate('Removed at owner\'s request');?>
            </div>
        </div>
    </div>
    <?php } elseif(isset($Listing['upcoming']) AND $Listing['upcoming'] == '1') { ?>
    <div class="ratio ratio-21x9 rounded ratio-embed overflow-hidden">
        <div class="d-flex align-items-center justify-content-center flex-column noting">
            <div class="glitch" data-text="<?php echo $this->translate('Upcoming');?>">
                <?php echo $this->translate('Upcoming');?>
            </div>
            <div class="glitch glitch-text" data-text="<?php echo $this->translate('Content not yet trackable');?>">
                <?php echo $this->translate('Content not yet trackable');?>
            </div>
        </div>
    </div>
    <?php } elseif(empty($AuthUser['id']) AND isset($Listing['private']) AND $Listing['private'] == '1') { ?>
    <div class="ratio ratio-21x9 rounded ratio-embed overflow-hidden">
        <div class="d-flex align-items-center justify-content-center flex-column">
            <div class="fs-2xl text-white fw-semibold">
                <?php echo $this->translate('Members only');?>
            </div>
            <div class="text-muted fs-base">
                <?php echo $this->translate('This content is only for members.');?> <a href="<?php echo APP.'/'.$this->translate('login');?>" class="text-white fw-semibold">
                    <?php echo $this->translate('Login');?></a>, <a href="<?php echo APP.'/'.$this->translate('register');?>" class="text-white fw-semibold">
                    <?php echo $this->translate('Register');?></a></div>
        </div>
    </div>
    <?php } elseif(count($Videos) == 0) { ?>
    <div class="ratio ratio-16x9 rounded ratio-trailer overflow-hidden">
        <?php if(isset($Listing['trailer'])) { ?>
        <video id="trailer" class="video-js vjs-default-skin" controls data-setup='{ "techOrder": ["youtube"], "poster":"", "sources": [{ "type": "video/youtube", "src": "<?php echo str_replace(' embed/', 'watch?v=' , $Listing['trailer']);?>"}], "youtube": { "customVars": { "wmode": "transparent" ,"iv_load_policy": 1,"ytControls": 0} } }'></video>
        <?php } else { ?>
        <div class="d-flex align-items-center justify-content-center flex-column noting">
            <div class="glitch" data-text="<?php echo $this->translate('Not yet available');?>">
                <?php echo $this->translate('Not yet available');?>
            </div>
            <div class="glitch glitch-text" data-text="<?php echo $this->translate('Content not yet trackable');?>">
                <?php echo $this->translate('Content not yet trackable');?>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } else { ?>
    <div class="ratio ratio-16x9 rounded overflow-hidden">
        <div class="embed-responsive-item ratio-embed"></div>
    </div>
    <?php if(isset($Videos)) { ?>
    <div class="card-stream mt-2 <?php if(count($Videos) < 2) echo 'd-none';?>">
        <?php $i = 1; ?>
        <?php foreach ($Videos as $Video) { ?>
        <button class="btn btn-stream btn-ghost btn-sm me-1 <?php if($i == 1) echo 'active';?>" data-id="<?php echo $Video['id'];?>">
            <?php echo isset($Video['service_name']) ? $Video['service_name'] : $this->translate('Stream').' #'.$i;?></button>
        <?php $i++; ?>
        <?php } ?>
    </div>
    <?php } ?>
    <?php } ?>
</div>