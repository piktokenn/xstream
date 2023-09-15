<?php require PATH . '/theme/view/common/head.php'; ?>
<?php require PATH . '/theme/view/common/header.php'; ?>
<div class="layout-section">
    <ol class="breadcrumb d-inline-flex text-muted mb-2">
        <li class="breadcrumb-item"><a href="<?php echo APP;?>">
                <?php echo $this->translate('Home');?></a></li>
        <li class="breadcrumb-item active" aria-current="page">
            <?php echo $this->translate('Community');?>
        </li>
    </ol>
    <div class="row gx-xl-5 justify-content-lg-center">
        <div class="col-lg">
            <div class="layout-heading mb-3">
        <h1 class="mb-0 h3">
                    <?php echo $this->translate('Community');?>
                </h1>
                <div class="layout-heading-filter">
                    <a href="<?php echo community();?>" class="fs-sm <?php if(empty($Route->params->sort)) echo 'text-white';?>">
                        <?php echo $this->translate('Newest');?></a>
                    <a href="<?php echo community('popular');?>" class="fs-sm <?php if(isset($Route->params->sort)) echo 'text-white';?>">
                        <?php echo $this->translate('Most popular');?></a>
                </div>
            </div>
            <?php foreach ($Listings as $Listing) { ?>
            <div class="py-2 mb-2">
                <div class="row">
                    <div class="col-auto">
                        <a href="<?php echo user($Listing['user_id'],$Listing['username']);?>" class="d-block" data-bs-tooltip="tooltip" data-bs-placement="top" title="<?php echo $Listing['firstname'];?> - @<?php echo $Listing['username'];?>">
                            <?php echo gravatar($Listing['user_id'],$Listing['username'],$Listing['avatar'],'avatar avatar-xl rounded-circle text-white fs-xs',$Listing['color']);?>
                        </a>
                    </div>
                    <div class="col text-gray-600">
                        <ul class="list-inline list-separator fs-xs text-gray-500 mb-1">
                            <li class="list-inline-item"><a href="<?php echo user($Listing['user_id'],$Listing['username']);?>" class="text-current fw-semibold">
                                    <?php echo $Listing['username'];?></a></li>
                            <li class="list-inline-item">
                                <?php echo dating($Listing['created']);?>
                            </li>
                            <li class="list-inline-item">
                                <?php echo $Listing['reply'].' '.$this->translate('reply');?>
                            </li>
                        </ul>
                        <h3 class="fs-sm text-heading fw-semibold mb-1 h-1x"><a href="<?php echo thread($Listing['id'],$Listing['self']);?>" class="text-current">
                                <?php echo $Listing['title'];?></a></h3>
                        <p class="fs-sm h-1x mb-2 text-muted">
                            <?php echo $Listing['description'];?>
                        </p>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="d-flex justify-content-center flex-nowrap mt-3">
                <?php echo $Pagination;?>
            </div>
        </div>
        <div class="col-lg-auto">
            <?php require PATH . '/theme/view/common/community.sidebar.php'; ?>
        </div>
    </div>
</div>
<?php echo ads($Ads,1,'mx-lg-auto py-3 px-3 mb-3');?>
<?php require PATH . '/theme/view/common/javascript.php'; ?>
<?php require PATH . '/theme/view/common/footer.php'; ?>