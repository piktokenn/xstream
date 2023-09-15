<div class="layout-section">
    <div class="layout-heading mb-3 text-muted d-flex align-items-center">
        <h3 class="fs-lg fw-bold mb-0">
            <?php echo $this->translate('Collections');?>
        </h3>
    </div>
    <?php if(isset($Posts)) { ?>
    <div class="row">
        <?php foreach ($Posts as $Post) { ?>
        <div class="col-lg-4">
            <div class="card card-collection h-100" style="background-color: <?php echo $Post['color'];?>">
                <div class="card-body">
                    <h3 class="title mb-1"><a href="<?php echo collection($Post['id'],$Post['self']);?>" class="text-white">
                            <?php echo $Post['name'];?></a></h3>
                    <ul class="list-inline mb-0 fs-xs text-white-50">
                        <li class="list-inline-item"><a href="<?php echo user($Listing['id'],$Listing['username']);?>" class="text-current fw-semibold">
                                <?php echo $Listing['username'];?></a></li>
                        <li class="list-inline-item">
                            <?php echo $Post['total'].' '.$this->translate('post avaible');?>
                        </li>
                    </ul>
                </div>
            </div>
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