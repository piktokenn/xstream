<?php require PATH . '/view/common/head.php'; ?>
<?php require PATH . '/view/common/header.php'; ?>
<?php require_once PATH.'/config/array.config.php'; ?>
<div class="container">
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="_ACTION" value="save">
        <input type="hidden" name="_TOKEN" value="<?php echo $Token?>">
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('Title');?></label>
            <input type="text" name="title" class="form-control form-control-lg" placeholder="<?php echo $this->translate('Title');?>" required="true" value="<?php if(isset($Listing['title'])) echo $Listing['title'];?>">
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
                <?php echo $this->translate('Description');?></label>
            <textarea name="description" class="form-control" rows="4" placeholder="<?php echo $this->translate('Description');?>"><?php if(isset($Listing['description'])) echo $Listing['description'];?></textarea>
        </div>
        <?php if(isset($Listing['post_title'])) { ?>
        <div class="mb-3 d-flex">
            <a href="<?php echo APP.'/admin/'.$Config['btn'].'/'.$Listing['id'];?>">
                <?php echo picture(POST_FOLDER,$Listing['image'],'img-fluid rounded-1',$Listing['post_title'],'75,150');?>
            </a>
            <div class="ps-4 lh-sm py-2">
                <div class="fs-xs text-muted">
                    <?php echo $Listing['title_sub'];?>
                </div>
                <div class="fw-semibold fs-base d-inline-block mb-2">
                    <?php echo $Listing['post_title'];?>
                </div>
                <?php if(isset($Listing['type']) AND $Listing['type'] == 'movie') { ?>
                <div class="text-muted fs-xs">
                    <?php echo $this->translate('Movie');?>
                </div>
                <?php } elseif(isset($Listing['type']) AND $Listing['type'] == 'serie') { ?>
                <div class="text-muted fs-xs">
                    <?php echo $this->translate('Serie');?>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } else { ?>
            
<div class="mb-3">
    <label class="form-label">
        <?php echo self::translate('Related Content');?></label>
    <div>
        <select name="genres[]" class="bs-select" multiple data-live-search="true">
            <?php foreach($Genres as $Genre) { ?>
            <option value="<?php echo $Genre['id'];?>" <?php if(isset($SelectGenres) && in_array($Genre['id'], $SelectGenres)) echo ' selected=""' ;?>
                <?php echo 'data-text="'.$Genre['name'].'"';?>>
                <?php echo $Genre['name'];?>
            </option>
            <?php } ?>
        </select>
    </div>
</div>
        <?php } ?>
        <button type="submit" class="btn btn-primary w-xl-300 py-3 mb-3">
            <?php echo $this->translate('Save changes');?></button>
        <div class="mb-3">
            <label class="form-label fs-xs">
                <?php echo $this->translate('Advanced');?></label>
            <div class="form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" <?php if(isset($Listing['featured']) AND $Listing['featured']==1) echo 'checked=""' ;?>>
                <label class="form-check-label" for="featured">
                    <?php echo $this->translate('Featured');?></label>
            </div>
            <div class="form-switch mb-1">
                <input class="form-check-input" type="checkbox" id="Published" name="status" value="1" <?php if(isset($Listing['status']) AND $Listing['status']==1) echo 'checked=""' ;?>>
                <label class="form-check-label" for="Published">
                    <?php echo $this->translate('Published');?></label>
            </div>
        </div>
    </form>
</div>
<?php require PATH . '/view/common/javascript.php'; ?>
<?php require PATH . '/view/common/footer.php'; ?>