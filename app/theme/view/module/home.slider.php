<?php $Slider = $this->db->from('posts')->where('status',1)->where('slider',1)->limit(0,5)->orderby('id','DESC')->all(); ?>
<?php if(count($Slider) > 0) { ?>
<div class="layout-slider carousel slide carousel-fade" data-bs-ride="carousel" id="layoutSlider" data-bs-interval="5000" data-bs-pause="false">
    <div class="carousel-absolute">
        <div class="carousel-indicators">
            <?php 
                $i = 0;
                $ii=1;
                foreach($Slider as $Slide) { 
                ?>
            <div class="slide-btn <?php if($i == 0) echo 'active';?>" data-bs-target="#layoutSlider" data-bs-slide-to="<?php echo $i;?>" <?php if($i==0) echo 'aria-current="true"' ;?> aria-label="Slide
                <?php echo $i;?>">
                <div class="slide-heading">
                    <?php echo $Slide['title'];?>
                </div>
                <div class="slide-desc">
                    <div class="overview h-2x">
                        <?php echo $Slide['overview'];?>
                    </div>
                    <a href="<?php echo post($Slide['id'],$Slide['self'],$Slide['type']);?>" class="btn btn-theme">
                        <?php echo $this->translate('Watch now');?></a>
                    <a href="<?php echo post($Slide['id'],$Slide['self'],$Slide['type']);?>" class="btn d-none d-md-inline-block">
                        <?php echo $this->translate('More detail');?></a>
                </div>
                <div class="progress-bar"></div>
            </div>
            <?php $i++; } ?>
        </div>
    </div>
    <div class="carousel-inner">
        <?php 
        $ii = 0;
        foreach($Slider as $Slide) { 
        ?>
        <div class="carousel-item <?php if($ii == 0) echo 'active';?>">
            <div class="card card-slide">
                <div class="carousel-gradient"></div>
                <div class="ratio" style="--slide-aspect;background-image: url('<?php echo UPLOAD.'/'.POST_FOLDER.'/'.webper($Slide['cover']);?>');"></div>
            </div>
        </div>
        <?php $ii++;} ?>
    </div>
</div>
<?php } ?>