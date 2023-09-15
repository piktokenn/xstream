<?php require PATH . '/view/common/head.php'; ?>
<?php require PATH . '/view/common/header.php'; ?>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="_ACTION" value="save">
    <input type="hidden" name="_TOKEN" value="<?php echo $Token?>">
    <div class="row gx-xl-4 h-100 justify-content-center">
        <div class="col-lg">
            <div class="text-center mb-3">
                <ul class="nav justify-content-center fw-normal d-inline-flex nav-segment bottom fs-sm" id="myTab" role="tablist">
                    <?php 
                $i = 0;
                foreach ($TabNav as $key => $value) { 
                ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($i == 0) ? 'active' : ''; ?>" id="<?php echo $key;?>-tab" data-bs-toggle="tab" data-bs-target="#<?php echo $key;?>" type="button" role="tab" aria-controls="<?php echo $key;?>" aria-selected="<?php echo ($i == 0) ? 'true' : 'false'; ?>">
                            <?php echo $value;?></a>
                    </li>
                    <?php $i++; } ?>
                </ul>
            </div>
            <div class="tab-content" id="myTabContent">
                <?php 
            $i = 0;
            foreach ($TabNav as $key => $value) { 
            ?>
                <div class="tab-pane <?php if($i == 0) { echo 'active'; } ?>" id="<?php echo Input::seo($key);?>" role="tabpanel" aria-labelledby="<?php echo Input::seo($key);?>-tab">
                    <?php include PATH.'/view/tab/post.'.Input::seo($key).'.php';?>
                </div>
                <?php $i++; } ?>
            </div>
            <input type="hidden" name="collection" value="<?php echo isset($Listing['collection']) ? $Listing['collection'] : null;?>">
            <input type="hidden" name="image_url">
            <input type="hidden" name="cover_url">
        </div>
        <div class="col-xl-auto">
            <div class="h-100 w-xl-300 border-start border-gray-100">
                <div class="mb-3">
                    <div class="ratio-select ratio ratio-cover rounded bg-img-cover position-relative input-cover" style="--bs-aspect-ratio: 150%;background-image: url(<?php if(isset($Listing['image'])) echo UPLOAD.'/'.POST_FOLDER.'/'.$Listing['image']; ?>);">
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
                </div>
                <div class="mb-3">
                    <label class="form-label fs-xs">Themoviedb Importer</label>
                    <div class="input-group">
                        <input type="number" name="tmdb_id" class="form-control" placeholder="Themoviedb id or iMDB id" value="<?php echo isset($Listing['tmdb_id']) ? $Listing['tmdb_id'] : null;?>">
                        <div class="input-group-text importer cursor-pointer" id="basic-addon2" data-type="<?php echo $Config['api'];?>">
                            <svg width="14" height="14" stroke="currentColor" stroke-width="2" fill="none">
                                <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#upload';?>"></use>
                            </svg>
                        </div>
                    </div>
                    <div class="fs-xs text-muted py-2">tmdb id '000000'</div>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary px-xl-7 py-3"><?php echo $this->translate('Save changes');?></button>
                </div>
                <div class="mb-3">
                    <label class="form-label fs-xs">
                        <?php echo $this->translate('Advanced');?></label>
                    <div class="form-switch mb-1">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" <?php if(empty($Listing['status']) || $Listing['status'] !=2) echo 'checked' ;?>>
                        <label class="form-check-label" for="status">
                            <?php echo $this->translate('Publish');?></label>
                    </div>
                    <div class="form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" <?php if(isset($Listing['featured']) AND $Listing['featured']==1) echo 'checked' ;?>>
                        <label class="form-check-label" for="featured">
                            <?php echo $this->translate('Featured');?></label>
                    </div>
                    <div class="form-switch mb-1">
                        <input class="form-check-input" type="checkbox" id="slider" name="slider" value="1" <?php if(isset($Listing['slider']) AND $Listing['slider']==1) echo 'checked' ;?>>
                        <label class="form-check-label" for="slider">
                            <?php echo $this->translate('Slider');?></label>
                    </div>
                    <div class="form-switch mb-1">
                        <input class="form-check-input" type="checkbox" id="private" name="private" value="1" <?php if(isset($Listing['private']) AND $Listing['private']==1) echo 'checked' ;?>>
                        <label class="form-check-label" for="private"><?php echo $this->translate('Members only');?></label>
                    </div>
                    <div class="form-switch mb-1">
                        <input class="form-check-input" type="checkbox" id="comment" name="data[comment]" value="1" <?php if(isset($Data['comment']) AND $Data['comment']=='1' ) echo 'checked="true"' ;?>>
                        <label class="form-check-label" for="comment"><?php echo $this->translate('Closed comment');?></label>
                    </div>
                    <div class="form-switch mb-1">
                        <input class="form-check-input" id="politicy" name="data[politicy]" type="checkbox" value="1" <?php if(isset($Data['politicy']) AND $Data['politicy']=='1' ) echo 'checked="true"' ;?>>
                        <label class="form-check-label" for="politicy"><?php echo $this->translate('Copyright');?></label>
                    </div>
                    <div class="form-switch mb-1">
                        <input class="form-check-input" id="upcoming" name="upcoming" type="checkbox" value="1" <?php if(isset($Listing['upcoming']) AND $Listing['upcoming']=='1' ) echo 'checked="true"' ;?>>
                        <label class="form-check-label" for="upcoming"><?php echo $this->translate('Upcoming');?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php require PATH . '/view/common/javascript.php'; ?>
<script type="text/javascript">
    <?php if(isset($_GET['tmdb_id'])) { ?>
        $('[name="tmdb_id"]').val('<?php echo $_GET['tmdb_id'];?>');
        $('.importer').trigger('click');
    <?php } ?>
</script>
<?php require PATH . '/view/common/footer.php'; ?>