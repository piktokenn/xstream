<div class="row gx-xl-5">
    <?php 
    foreach ($Downloads as $Download) { 
    ?>
    <div class="col-lg-4">
        <div class="d-flex align-items-center py-2 border-bottom border-light">
            <div class="flex-fill fs-sm">
                <?php echo getDomain($Download['embed']);?>
            </div>
            <div>
                <a href="<?php echo $Download['embed'];?>" rel="nofollow" target="_blank" class="btn btn-ghost"><?php echo $this->translate('Download');?></a>
            </div>
        </div>
    </div>
    <?php } ?>
</div>