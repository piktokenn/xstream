<div class="row">
    <?php foreach ($Subtitles as $Subtitle) { ?>
    <div class="col-xl-4">
        <div class="post-subtitle">
            <?php if(isset($Subtitle['icon'])) { ?>
            <div class="">
                <img src="<?php echo UPLOAD.'/icon/'.$Subtitle['icon'];?>">
            </div>
            <?php } ?>
            <div class="flex-fill fs-sm px-3">
                <?php echo $Subtitle['name'];?>
            </div>
            <div>
                <a href="<?php echo $Subtitle['link'];?>" rel="nofollow" target="_blank" class="btn btn-ghost">Download</a>
            </div>
        </div>
    </div>
    <?php } ?>
</div>