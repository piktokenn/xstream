<?php require PATH . '/theme/view/common/head.php'; ?>
<?php require PATH . '/theme/view/common/header.php'; ?>
<?php require PATH . '/config/array.config.php'; ?>
<div class="layout-section">
    <ol class="breadcrumb d-inline-flex text-muted mb-2">
        <li class="breadcrumb-item"><a href="<?php echo APP;?>">
                <?php echo $this->translate('Home');?></a></li>
        <li class="breadcrumb-item active" aria-current="page">
            <?php echo $this->translate('Platforms');?>
        </li>
    </ol>
    <div class="layout-heading mb-3">
        <h1 class="mb-0 h3">
            <?php echo $this->translate('Platforms');?>
        </h1> 
    </div>
    <div class="row row-cols-lg-8 row-cols-md-4 row-cols-2">
        <?php foreach ($Listings as $Listing) { ?>
        <div class="col-lg-2">
            <a href="<?php echo platform($Listing['id'],$Listing['self']);?>" class="card card-platform">
                <div class="ratio bg-transparent align-items-center">
                    <?php echo picture(PLATFORM_FOLDER,$Listing['image'],'img-fluid',$Listing['name'],PLATFORM_X.',auto');?>
                </div>
                <div class="card-body text-center">
                    <h3 class="title">
                        <?php echo $Listing['name'];?>
                    </h3>
                    <div class="count">
                        <?php echo (int)$Listing['posts'].' '.$this->translate('post available');?>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>
    </div>
    <div class="text-center">
        <?php echo $Pagination;?>
    </div>
</div>
<?php echo ads($Ads,1,'mx-lg-auto py-3 px-3 mb-3');?>
<?php require PATH . '/theme/view/common/javascript.php'; ?>
<?php require PATH . '/theme/view/common/footer.php'; ?>