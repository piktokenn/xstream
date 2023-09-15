<?php require PATH . '/view/common/head.php'; ?>
<?php require PATH . '/view/common/header.php'; ?>
<?php require_once PATH.'/config/array.config.php'; ?>
<div class="container">
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="_ACTION" value="save">
        <input type="hidden" name="_TOKEN" value="<?php echo $Token?>">
        <div class="row mb-3 align-items-center">
            <div class="col-lg-6">
                
                <div class="d-flex align-items-center">
                    <div>
                        <?php echo gravatar($Listing['user_id'],$Listing['username'],$Listing['avatar'],'avatar rounded-circle text-white fs-xs',$Listing['color']);?>
                    </div>
                    <div class="ps-3 d-none d-lg-block lh-xs">
                        <div class="fs-sm fw-semibold">
                            <?php echo $Listing['firstname'].' '.$Listing['lastname'];?>
                        </div>
                        <div class="text-muted fs-xs">
                            <?php echo $Listing['email'];?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="d-flex align-items-center">
                    <div>
                        <?php echo picture(POST_FOLDER,$Listing['image'],'img-fluid rounded-1',$Listing['id'],'40,60');?>
                    </div>
                    <div class="ps-3 lh-sm py-2">
                        <div class="fw-semibold text-current fs-sm d-inline-block">
                            <?php echo $Listing['post_title'];?></div>
                        <div class="fs-xs text-muted">
                            <?php echo $Listing['title_sub'];?>
                            <?php if(isset($Listing['title_number'])) { ?>
                            <span class="fs-xs text-muted ms-1">
                                <span class="mx-1">-</span>
                                <?php echo $this->translate('Season').' '.$Listing['name'].', '.$this->translate('Episode').' '.$Listing['title_number'];?>
                            </span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('Comment');?></label>
            <textarea name="comment" class="form-control" rows="3" placeholder="<?php echo $this->translate('Comment');?>"><?php if(isset($Listing['comment'])) echo $Listing['comment'];?></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-xl-300 py-3 mb-3">
            <?php echo $this->translate('Save changes');?></button>
        <div class="mb-3">
            <label class="form-label fs-xs">
                <?php echo $this->translate('Advanced');?></label>
            <div class="form-switch mb-1">
                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" <?php if(isset($Listing['status']) AND $Listing['status']==1) echo 'checked=""' ;?>>
                <label class="form-check-label" for="status">
                    <?php echo $this->translate('Publish');?></label>
            </div>
            <div class="form-switch mb-1">
                <input class="form-check-input" type="checkbox" id="spoiler" name="spoiler" value="1" <?php if(isset($Listing['spoiler']) AND $Listing['spoiler']==1) echo 'checked=""' ;?>>
                <label class="form-check-label" for="spoiler">
                    <?php echo $this->translate('Spoiler');?></label>
            </div>
        </div>
    </form>
</div>
<?php require PATH . '/view/common/javascript.php'; ?>
<?php require PATH . '/view/common/footer.php'; ?>