<div class="layout-section">
    <div class="layout-heading">
        <div class="layout-title fs-base">
            <?php echo $Module['name'];?>
        </div>
    </div>
    <div class="row">
        <?php $i=1; foreach($Populars as $Popular) { ?>
        <div class="col-lg-3">
            <div class="card card-popular">
                <div class="number">
                    <?php echo $i;?>
                </div>
                <div class="px-4">
                    <h3 class="title"><a href="<?php echo post($Popular['id'],$Popular['self'],$Popular['type']);?>" class="text-current">
                            <?php echo $Popular['title'];?></a></h3>
                    <div class="view">
                        <?php echo hitview($Popular['view']);?>
                    </div>
                </div>
            </div>
        </div>
        <?php $i++; } ?>
    </div>
</div>