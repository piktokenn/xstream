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
                <div>
        <select name="post_id" class="bs-select" data-live-search="true" required="true" data-ajax="slide">
            <option value=""><?php echo $this->translate('Choose');?></option>
            <?php foreach($Posts as $Post) { ?>
            <option value="<?php echo $Post['id'];?>" <?php if(isset($Listing['post_id']) AND $Post['id'] == $Listing['post_id']) echo ' selected=""' ;?>
                <?php echo 'data-text="'.$Post['title'].'"';?>>
                <?php echo $Post['title'];?>
            </option>
            <?php } ?>
        </select>
    </div>
            </div>
            <div class="mb-3">
                <label class="form-label">
                    <?php echo $this->translate('Heading');?></label>
                <input type="text" id="heading" name="heading" class="form-control" placeholder="<?php echo $this->translate('Heading');?>" value="<?php if(isset($Listing['heading'])) echo $Listing['heading'];?>">
            </div>
            <div class="mb-3">
                <label class="form-label">
                    <?php echo $this->translate('Description');?></label>
                    <textarea name="description" class="form-control" placeholder="<?php echo $this->translate('Description');?>" rows="4"><?php if(isset($Listing['description'])) echo $Listing['description'];?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">
                    <?php echo $this->translate('Link');?></label>
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
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-success px-xl-7 py-3"><?php echo $this->translate('Save changes');?></button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php require PATH . '/view/common/javascript.php'; ?>
<?php require PATH . '/view/common/footer.php'; ?>