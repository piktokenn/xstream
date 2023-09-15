<div class="row row-cols-xl-8 gx-2">
    <?php foreach ($Multimedia as $Media) { ?>
    <div class="col-lg-3 mb-2">
        <a href="<?php echo UPLOAD.'/'.MEDIA_FOLDER.'/'.$Media['image'];?>" data-lightbox="image-1">
            <?php echo picture(MEDIA_FOLDER,'thumb-'.$Media['image'],'img-fluid rounded-1',$Media['image'],MEDIA_X.',auto');?>
        </a>
    </div>
    <?php } ?>
</div>