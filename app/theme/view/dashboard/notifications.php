<?php require PATH . '/theme/view/common/head.php'; ?>
<?php require PATH . '/theme/view/common/header.php'; ?>
<div class="layout-section">
    <div class="container">
        <?php if(count($Listings) > 0) { ?>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <?php foreach($Listings as $Listing) { ?>
                <div class="py-2 border-bottom border-gray-200">
                    <div class="row gx-3">
                        <div class="col-auto">
                            <?php echo gravatar($Listing['action_user'],$Listing['username'],$Listing['avatar'],'avatar rounded-circle text-white fs-sm',$Listing['color']);?>
                        </div>
                        <div class="col-10">
                            <?php if($Listing['type'] == 'comment') { ?>
                            <a href="<?php echo post($Listing['action_id'],$Listing['self'],$Listing['post_type']).'/comments';?>" class="fs-xs text-wrap">
                                <span class="text-white fw-bold d-inline-block">
                                    <?php echo $Listing['username'];?></span>
                                <span class="text-muted fw-normal me-2">
                                    <?php echo $this->translate('replied to your comment');?></span>
                            </a>
                            <?php } ?>
                            <div class="text-muted text-cap mt-1 fs-xs fw-normal">
                                <?php echo timeago($Listing['created']);?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php echo $Pagination;?>
        <?php } else { ?>
        <div class="text-center py-xl-6 py-5">
            <div class="text-white fs-base fw-semibold">
                <?php echo $this->translate('No notifications yet');?>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php require PATH . '/theme/view/common/javascript.php'; ?>
<?php require PATH . '/theme/view/common/footer.php'; ?>