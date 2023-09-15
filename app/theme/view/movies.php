<?php require PATH . '/theme/view/common/head.php'; ?>
<?php require PATH . '/theme/view/common/header.php'; ?>
<?php require PATH . '/config/array.config.php'; ?> 
<div class="layout-section">
        <ol class="breadcrumb d-inline-flex text-muted mb-2">
            <li class="breadcrumb-item"><a href="<?php echo APP;?>">
                    <?php echo $this->translate('Home');?></a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <?php echo $this->translate('Movies');?>
            </li>
        </ol>
        <div id="content">
            <?php require PATH . '/theme/view/common/listing.php'; ?>
        </div>

</div>
<?php echo ads($Ads,1,'mx-lg-auto py-3 px-3 mb-3');?>
<?php require PATH . '/theme/view/common/javascript.php'; ?>
<?php require PATH . '/theme/view/common/footer.php'; ?>