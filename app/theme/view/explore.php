<?php require PATH . '/theme/view/common/head.php'; ?>
<?php require PATH . '/theme/view/common/header.php'; ?>
<?php require PATH . '/config/array.config.php'; ?>
<?php 
    if(isset($_GET['released'])) {
        $Released = explode(';', $_GET['released']);
    }
    if(isset($_GET['imdb'])) {
        $Imdb = explode(';', $_GET['imdb']);
    }
    if(isset($_GET['genre'])) {
        $Genre = explode(',', $_GET['genre']);
    }
?>
<div class="layout-section">
    <ol class="breadcrumb d-inline-flex text-muted mb-2">
        <li class="breadcrumb-item"><a href="<?php echo APP;?>">
                <?php echo $this->translate('Home');?></a></li>
        <li class="breadcrumb-item active" aria-current="page">
            <?php echo $this->translate('Explore');?>
        </li>
    </ol>
    <div id="content">
        <?php require PATH . '/theme/view/common/listing.php'; ?>
    </div>
</div>
<?php echo ads($Ads,1,'mx-lg-auto py-3 px-3 mb-3');?>
<?php require PATH . '/theme/view/common/javascript.php'; ?>
<?php require PATH . '/theme/view/common/footer.php'; ?>