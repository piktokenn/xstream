<?php require PATH . '/view/common/head.php'; ?>
<?php require PATH . '/view/common/header.php'; ?>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="_ACTION" value="save">
    <input type="hidden" name="_TOKEN" value="<?php echo $Token?>">
    <div class="row gx-xl-5 h-100 justify-content-center">
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
        </div>
        <div class="col-xl-auto">
            <div class="h-100 w-xl-300 border-start border-gray-100 mt-lg-5 py-lg-3">
                <div class="mb-3">
                    <label class="form-label">
                        <?php echo self::translate('TV Show');?></label>
                    <div>
                        <select name="post_id" class="bs-select" data-live-search="true" required="true" data-ajax="post" data-id="<?php echo isset($Listing['season_id']) ? $Listing['season_id'] : null;?>">
                            <option value="">
                                <?php echo $this->translate('Choose');?>
                            </option>
                            <?php foreach($Series as $Serie) { ?>
                            <option value="<?php echo $Serie['id'];?>" <?php if(isset($Listing['post_id']) AND $Serie['id']==$Listing['post_id']) echo ' selected=""' ;?>
                                <?php echo 'data-text="'.$Serie['id'].'"';?>>
                                <?php echo $Serie['title'];?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3 d-none season">
                    <label class="form-label">
                        <?php echo self::translate('Season');?></label>
                    <div>
                        <select name="season_id" class="bs-select" data-live-search="true" required="true">
                            <option value="">
                                <?php echo $this->translate('Choose');?>
                            </option>
                        </select>
                    </div>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-success px-xl-7 py-3">
                        <?php echo $this->translate('Save changes');?></button>
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
                        <input class="form-check-input" type="checkbox" id="private" name="private" value="1" <?php if(isset($Listing['private']) AND $Listing['private']==1) echo 'checked' ;?>>
                        <label class="form-check-label" for="private">
                            <?php echo $this->translate('Members only');?></label>
                    </div>
                    <div class="form-switch mb-1">
                        <input class="form-check-input" type="checkbox" id="comment" name="data[comment]" value="1" <?php if(isset($Data['comment']) AND $Data['comment']=='1' ) echo 'checked="true"' ;?>>
                        <label class="form-check-label" for="comment">
                            <?php echo $this->translate('Closed comment');?></label>
                    </div>
                    <div class="form-switch mb-1">
                        <input class="form-check-input" id="politicy" name="data[politicy]" type="checkbox" value="1" <?php if(isset($Data['politicy']) AND $Data['politicy']=='1' ) echo 'checked="true"' ;?>>
                        <label class="form-check-label" for="politicy">
                            <?php echo $this->translate('Copyright');?></label>
                    </div>
                    <div class="form-switch mb-1">
                        <input class="form-check-input" id="upcoming" name="upcoming" type="checkbox" value="1" <?php if(isset($Listing['upcoming']) AND $Listing['upcoming']=='1' ) echo 'checked="true"' ;?>>
                        <label class="form-check-label" for="upcoming">
                            <?php echo $this->translate('Upcoming');?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php require PATH . '/view/common/javascript.php'; ?>
<script type="text/javascript">
<?php if(isset($_GET['tv'])) { ?>
$('[name="post_id"]').find('option[data-text="<?php echo $_GET['tv'];?>"]').attr('selected', 'selected');
$('.bs-select').selectpicker('refresh');
<?php } ?>
$('[data-ajax="post"]').trigger('change');
</script>
<?php require PATH . '/view/common/footer.php'; ?>