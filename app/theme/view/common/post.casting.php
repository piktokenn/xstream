<div class="row">
    <?php foreach ($Peoples as $People) { ?>
    <div class="col-md-3 col-12">
        <div class="row mb-3 align-items-center">
            <div class="col-auto">
                <a href="<?php echo people($People['id'],$People['self']);?>" class="card-media">
                    <?php echo picture(PEOPLE_FOLDER,$People['image'],'img-fluid rounded',$People['name'],'60,60');?>
                </a>
            </div>
            <div class="col">
                <h3 class="fs-sm h-1x fw-normal"><a href="<?php echo people($People['id'],$People['self']);?>" class="text-current">
                        <?php echo $People['name'];?></a></h3>
                <div class="fs-xs text-muted">
                    <?php echo $People['department'];?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>