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
                <?php echo $this->translate('Code');?></label>
            <input type="text" name="code" class="form-control" placeholder="<?php echo $this->translate('Code');?>" value="<?php if(isset($Listing['code'])) echo $Listing['code'];?>">
        </div>
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('Language');?></label>
            <input type="text" name="language" class="form-control" placeholder="<?php echo $this->translate('Language');?>" value="<?php if(isset($Listing['language'])) echo $Listing['language'];?>">
        </div>
        <div class="mb-3">
            <label for="icon" class="form-label">
                <?php echo $this->translate('Icon');?></label>
            <input class="form-control" name="icon" type="file" id="icon">
            <?php if(isset($Listing['icon'])) { ?>
            <a href="<?php echo UPLOAD. '/icon/'.$Listing['icon'];?>" target="_blank" class="mt-2 fs-xs text-current d-inline-block">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5">
                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#image';?>"></use>
                </svg>
                <span class="ms-1"><?php echo $Listing['icon'];?></span>
            </a>
            <?php } ?>
        </div>
        <button type="submit" class="btn btn-primary w-xl-300 py-3 mb-3"><?php echo $this->translate('Save changes');?></button> 
        <div class="mb-3">
            <label class="form-label fs-xs">
                <?php echo $this->translate('Advanced');?></label>
            <div class="form-switch mb-1">
                        <input class="form-check-input" type="checkbox" id="subtitle" name="subtitle" value="1" <?php if(isset($Listing['subtitle']) AND $Listing['subtitle'] == 1) echo 'checked=""';?>>
                <label class="form-check-label" for="subtitle">
                    <?php echo $this->translate('Subtitle');?></label>
            </div>
        </div>
    </form>
</div>
<?php require PATH . '/view/common/javascript.php'; ?>
<?php require PATH . '/view/common/footer.php'; ?>