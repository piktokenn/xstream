<?php require PATH . '/view/common/head.php'; ?>
<?php require PATH . '/view/common/header.php'; ?>
<?php require_once PATH.'/config/array.config.php'; ?>
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
    <button type="submit" class="btn btn-success w-xl-300 py-3 mb-3">
        <?php echo $this->translate('Save changes');?></button>
    <div class="mb-4">
        <label class="form-label fs-xs">
            <?php echo $this->translate('Advanced');?></label>
        <div class="d-flex align-items-center">
            <div class="form-switch">
                <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" <?php if(isset($Listing['featured']) AND $Listing['featured']==1) echo 'checked=""' ;?>>
                <label class="form-check-label" for="featured">
                    <?php echo $this->translate('Featured');?></label>
            </div>
            <div class="form-switch ms-3">
                <input class="form-check-input" type="checkbox" id="privacy" name="privacy" value="1" <?php if(isset($Listing['privacy']) AND $Listing['privacy']==1) echo 'checked=""' ;?>>
                <label class="form-check-label" for="privacy">
                    <?php echo $this->translate('Private');?></label>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <select name="search" class="form-control selectize-collection" data-placeholder="<?php echo self::translate('Search');?> .."></select>
    </div>
    <div class="row row-cols-xxl-8 row-collection">
        <?php if(isset($Posts)) { ?>
        <?php foreach($Posts as $Post) { ?>
        <div class="col-md-3 col-collection" data-id="<?php echo $Post['id'];?>">
            <div class="card card-collection border-0">
                <div class="position-relative">
                    <?php echo picture(POST_FOLDER,$Post['image'],'card-img-top',$Post['title'],POST_X.',auto');?>
                    <div class="card-overlay d-flex justify-content-center text-center p-2">
                        <div class="btn btn-danger btn-sm btn-icon-text rounded-pill confirm remove" data-id="<?php echo $Post['id'];?>" data-type="collection" data-ajax="true">
                            <svg width="16" height="18" fill="currentColor">
                                <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#delete';?>"></use>
                            </svg>
                            <span class="d-none d-lg-block ms-2 fs-xs">
                                <?php echo $this->translate('Remove');?></span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <h3 class="fs-sm h-1x fw-semibold">
                        <?php echo $Post['title'];?>
                    </h3>
                    <div class="text-muted fs-xs">
                        <?php echo $Post['type'];?>
                    </div>
                </div>
            </div>
            <input type="hidden" name="collection[<?php echo $Post['id'];?>][id]" value="<?php echo $Post['id'];?>">
            <input type="hidden" name="collection[<?php echo $Post['id'];?>][post_id]" value="<?php echo $Post['id'];?>">
        </div>
        <?php } ?>
        <?php } ?>
    </div>
</form>
<?php require PATH . '/view/common/javascript.php'; ?>
<script id="empty-collection" type="text/x-jquery-tmpl">
<div class="col-md-3 col-collection" data-id="${id}">
        <div class="card card-collection border-0">
            <div class="position-relative">
                <img src="${image}" class="img-fluid card-img-top" width="<?php echo POST_X;?>" height="auto">
                <div class="card-overlay d-flex justify-content-center text-center p-2">
                    <div class="btn btn-danger btn-sm btn-icon-text rounded-pill confirm remove" data-id="${id}" data-type="collection">
                        <svg width="16" height="18" fill="currentColor">
                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#delete';?>"></use>
                        </svg>
                        <span class="d-none d-lg-block ms-2 fs-xs">
                            <?php echo $this->translate('Remove');?></span>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <h3 class="fs-sm h-1x fw-semibold">${title}</h3>
                <div class="text-muted fs-xs">${type}</div>
            </div>
        </div> 
    <input type="hidden" name="collection[${id}][post_id]" value="${id}">
</div>
</script>
<?php require PATH . '/view/common/footer.php'; ?>