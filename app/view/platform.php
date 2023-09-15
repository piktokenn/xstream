<?php require PATH . '/view/common/head.php'; ?>
<?php require PATH . '/view/common/header.php'; ?>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="_ACTION" value="save">
    <input type="hidden" name="_TOKEN" value="<?php echo $Token?>">
    <div class="row gx-xl-5 h-100 justify-content-center">
        <div class="col-lg">
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
                    <?php echo $this->translate('Website');?></label>
                <input type="text" id="website" name="website" class="form-control" placeholder="https://" value="<?php if(isset($Listing['website'])) echo $Listing['website'];?>">
            </div>
        </div>
        <div class="col-xl-auto">
            <div class="h-100 w-xl-300 border-start border-gray-100">
                
                <div class="mb-3">
                    <div class="ratio-select ratio ratio-cover rounded bg-img-cover position-relative input-cover" style="--bs-aspect-ratio: 100%;background-image: url(<?php if(isset($Listing['image'])) echo UPLOAD.'/'.PLATFORM_FOLDER.'/'.$Listing['image']; ?>);">
                        <div class="ratio-preview text-muted <?php if(isset($Listing['image'])) echo 'd-none';?> d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <svg width="34" height="34" fill="none" stroke="currentColor" stroke-width="1.75">
                                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#image';?>"></use>
                                </svg>
                                <div class="fs-base mt-2">
                                    <?php echo $this->translate('Select image');?>
                                </div>
                                <div class="fs-xs">
                                    <?php echo $this->translate('Allow image type jpg, png, webp');?>
                                </div>
                            </div>
                        </div>
                        <div class="ratio-btn">
                            <button class="btn btn-square p-0 rounded-circle btn-primary mx-1 btn-upload" data-id="input-cover">
                                <svg width="16" height="16" stroke="currentColor" stroke-width="2" fill="none">
                                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#upload';?>"></use>
                                </svg>
                            </button>
                            <button class="btn btn-square p-0 rounded-circle btn-light mx-1 btn-clear <?php if(empty($Listing['image'])) echo 'd-none';?>" data-id="input-cover">
                                <svg width="18" height="18" stroke="currentColor" stroke-width="2" fill="none">
                                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#close';?>"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <input type="file" name="image" class="ratio-input d-none" id="file-input-cover" data-preview="ratio-cover" accept="image/*">
                    <input type="hidden" name="image_url" value="">
                </div>
                <div class="mb-3">
                    <label class="form-label fs-xs">Themoviedb Importer</label>
                    <div class="input-group">
                        <input type="number" name="tmdb_id" class="form-control" placeholder="Themoviedb id" value="<?php echo isset($Listing['tmdb_id']) ? $Listing['tmdb_id'] : null;?>">
                        <div class="input-group-text importer cursor-pointer" id="basic-addon2" data-type="<?php echo $Config['api'];?>">
                            <svg width="14" height="14" stroke="currentColor" stroke-width="2" fill="none">
                                <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#upload';?>"></use>
                            </svg>
                        </div>
                    </div>
                    <div class="fs-xs text-muted py-2">tmdb id '000000'</div>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-success px-xl-7 py-3"><?php echo $this->translate('Save changes');?></button>
                </div>
                <div class="mb-3">
                    <label class="form-label fs-xs">
                        <?php echo $this->translate('Advanced');?></label>
                    <div class="form-switch mb-1">
                        <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" <?php if(isset($Listing['featured']) AND $Listing['featured'] == 1) echo 'checked=""';?>>
                        <label class="form-check-label" for="featured">
                            <?php echo $this->translate('Featured');?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php require PATH . '/view/common/javascript.php'; ?>
<?php require PATH . '/view/common/footer.php'; ?>