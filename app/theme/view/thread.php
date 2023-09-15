<?php require PATH . '/theme/view/common/head.php'; ?>
<?php require PATH . '/theme/view/common/header.php'; ?>
<div class="layout-section">
    <ol class="breadcrumb d-inline-flex text-muted mb-2">
        <li class="breadcrumb-item"><a href="<?php echo community();?>">
                <?php echo $this->translate('Community');?></a></li>
        <li class="breadcrumb-item active" aria-current="page">
            <?php echo $Listing['title'];?>
        </li>
    </ol>
    <div class="layout-section">
        <div class="row gx-xl-5 justify-content-lg-center">
            <div class="col-lg">
                <div class="row">
                    <div class="col-auto">
                        <a href="<?php echo user($Listing['user_id'],$Listing['username']);?>" class="d-block" data-bs-tooltip="tooltip" data-bs-placement="top" title="<?php echo $Listing['firstname'];?> - @<?php echo $Listing['username'];?>">
                            <?php echo gravatar($Listing['user_id'],$Listing['username'],$Listing['avatar'],'avatar avatar-xl rounded-circle text-white fs-xs',$Listing['color']);?>
                        </a>
                    </div>
                    <div class="col text-gray-600">
                        <h1 class="h3 mb-1 fw-semibold">
                            <?php echo $Listing['title'];?>
                        </h1>
                        <ul class="list-inline list-separator fs-xs text-gray-500 mb-3">
                            <li class="list-inline-item"><a href="<?php echo user($Listing['user_id'],$Listing['username']);?>" class="text-current fw-semibold">
                                    <?php echo $Listing['username'];?></a></li>
                            <li class="list-inline-item">
                                <?php echo dating($Listing['created']);?>
                            </li>
                            <li class="list-inline-item">
                                <?php echo $Listing['reply'].' '.$this->translate('reply');?>
                            </li>
                        </ul>
                        <p>
                            <?php echo $Listing['description'];?>
                        </p>
                        <?php if(isset($Listing['post_title'])) { ?>
                        <div class="mb-3 d-flex">
                            <a href="<?php echo post($Listing['post_id'],$Listing['post_self'],$Listing['post_type']);?>">
                                <?php echo picture(POST_FOLDER,$Listing['image'],'img-fluid rounded-1',$Listing['post_title'],'60,auto');?>
                            </a>
                            <a href="<?php echo post($Listing['post_id'],$Listing['post_self'],$Listing['post_type']);?>" class="ps-4 lh-sm py-2">
                                <div class="fs-xs text-muted">
                                    <?php echo $Listing['title_sub'];?>
                                </div>
                                <div class="fw-semibold text-white fs-base d-inline-block mb-2">
                                    <?php echo $Listing['post_title'];?>
                                </div>
                                <?php if(isset($Listing['post_type']) AND $Listing['post_type'] == 'movie') { ?>
                                <div class="text-muted fs-xs">
                                    <?php echo $this->translate('Movie');?>
                                </div>
                                <?php } elseif(isset($Listing['post_type']) AND $Listing['post_type'] == 'serie') { ?>
                                <div class="text-muted fs-xs">
                                    <?php echo $this->translate('TV Show');?>
                                </div>
                                <?php } ?>
                            </a>
                        </div>
                        <?php } ?>
                        <hr class="bg-gray-200 my-4">
                        <?php require PATH . '/theme/view/common/post.comments.php'; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-auto">
                <?php require PATH . '/theme/view/common/community.sidebar.php'; ?>
            </div>
        </div>
    </div>
</div>
<?php echo ads($Ads,1,'mx-lg-auto py-3 px-3 mb-3');?>
<?php require PATH . '/theme/view/common/javascript.php'; ?>
<?php require PATH . '/theme/view/common/footer.php'; ?>