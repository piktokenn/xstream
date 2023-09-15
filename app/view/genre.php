<?php require PATH . '/view/common/head.php'; ?>
<?php require PATH . '/view/common/header.php'; ?>
<?php require_once PATH.'/config/array.config.php'; ?>
<div class="container">
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="_ACTION" value="save">
        <input type="hidden" name="_TOKEN" value="<?php echo $Token?>">
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('Name');?></label>
            <input type="text" name="name" class="form-control form-control-lg" placeholder="<?php echo $this->translate('Name');?>" required="true" value="<?php if(isset($Listing['name'])) echo $Listing['name'];?>">
            <?php if(isset($Listing['self'])) { ?>
            <div class="fs-xs mt-2">
                <span class="fw-semibold">Permalink : </span>
                <span class="permalink">
                    <?php echo APP;?>/<input type="text" name="self" class="form-control d-inline-block fs-xs py-0 bg-transparent border-0 shadow-none px-0 fw-semibold w-auto" value="<?php echo $Listing['self'];?>"></span>
            </div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('Color');?></label>
            <input type="text" name="color" class="form-control colorpicker" placeholder="#000" value="<?php echo isset($Listing['color']) ? $Listing['color'] : null;?>" maxlength="255">
        </div>
        <button type="submit" class="btn btn-primary w-xl-300 py-3 mb-3">
            <?php echo $this->translate('Save changes');?></button>
        <div class="mb-3">
            <label class="form-label fs-xs">
                <?php echo $this->translate('Advanced');?></label>
            <div class="form-switch mb-1">
                        <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" <?php if(isset($Listing['featured']) AND $Listing['featured'] == 1) echo 'checked=""';?>>
                <label class="form-check-label" for="featured">
                    <?php echo $this->translate('Featured');?></label>
            </div>
        </div>
    </form>
</div>
<?php require PATH . '/view/common/javascript.php'; ?>
<?php require PATH . '/view/common/footer.php'; ?>