<?php require PATH . '/view/common/head.php'; ?>
<?php require PATH . '/view/common/header.php'; ?>
<?php require_once PATH.'/config/array.config.php'; ?>
<div class="container">
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="_ACTION" value="save">
        <input type="hidden" name="_TOKEN" value="<?php echo $Token?>">
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('Report');?></label>
            <div class="fw-semibold">
                <?php echo $Reports[$Listing['report']];?>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('Description');?></label>
            <div class="fs-sm">
                <?php echo $Listing['body'];?>
            </div>
        </div>
        <div class="mb-3 d-flex">
            <a href="<?php echo APP.'/admin/'.$Listing['type'].'/'.$Listing['id'];?>">
                <?php if(isset($Listing['type']) AND $Listing['type'] == 'movie') { ?>
                <?php echo picture(POST_FOLDER,$Listing['image'],'img-fluid rounded-1',$Listing['title'],'75,100');?>
                <?php } elseif(isset($Listing['serie_title'])) { ?>
                <?php echo picture(POST_FOLDER,$Listing['serie_image'],'img-fluid rounded-1',$Listing['title'],'75,100');?>
                <?php } ?>
            </a>
            <div class="ps-4 lh-sm py-2">
                <?php if(isset($Listing['type']) AND $Listing['type'] == 'movie') { ?>
                <div class="fs-xs text-muted">
                    <?php echo $Listing['title_sub'];?>
                </div>
                <div class="fw-semibold fs-base d-inline-block mb-2">
                    <?php echo $Listing['title'];?></div>
                <div class="text-muted fs-xs">
                    <?php echo $this->translate('Movie');?>
                </div>
                <?php } elseif(isset($Listing['serie_title'])) { ?>
                <div class="fs-xs text-muted">
                    <?php echo $Listing['serie_titlesub'];?>
                </div>
                <div class="fw-semibold fs-base d-inline-block mb-2">
                    <?php echo $Listing['serie_title'];?></div>
                <div class="text-muted fs-xs">
                    <?php echo $this->translate('Serie');?>
                </div>
                <div class="text-body fw-semibold fs-sm">
                    <?php echo 'S:'.$Listing['season_name'].', E:'.$Listing['title_number'];?>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('Release Date');?></label>
            <div class="fs-sm">
                <?php echo dating($Listing['created']);?>
            </div>
        </div>
            <div class="form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" <?php if(isset($Listing['status']) AND $Listing['status'] == 1) echo 'checked=""';?>>
                <label class="form-check-label" for="status">
                    <?php echo $this->translate('Solved');?></label>
            </div>
        <button type="submit" class="btn btn-primary w-xl-300 py-3 mb-3">
            <?php echo $this->translate('Save changes');?></button>
    </form>
</div>
<?php require PATH . '/view/common/javascript.php'; ?>
<?php require PATH . '/view/common/footer.php'; ?>