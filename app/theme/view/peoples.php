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
            <?php echo $this->translate('Peoples');?>
        </li>
    </ol>
    <div class="layout-heading mb-3">
        <h1 class="mb-0 h3">
            <?php echo $this->translate('Peoples');?>
        </h1>
        <div class="layout-heading-filter">
            <a href="<?php echo APP.'/'.$this->translate('peoples');?>" class="fs-sm <?php if(empty($_GET['sort'])) echo 'text-white';?>">
                <?php echo $this->translate('Newest');?></a>
            <a href="<?php echo APP.'/'.$this->translate('peoples').'?sort=popular';?>" class="fs-sm <?php if(isset($_GET['sort'])) echo 'text-white';?>">
                <?php echo $this->translate('Most popular');?></a>
        </div>
    </div>
    <div class="row <?php if(get($Settings, 'data.header', 'customize') == 'v2') { echo 'row-cols-xxl-'.(int)get($Settings,'data.column','customize'); } else { echo 'row-cols-xxl-'.(int)get($Settings,'data.column','customize'); } ?> row-cols-md-4 row-cols-2">
        <?php foreach ($Listings as $Listing) { ?>
        <div class="col-lg-2">
            <a href="<?php echo people($Listing['id'],$Listing['self']);?>" class="card card-people">
                <?php echo picture(PEOPLE_FOLDER,$Listing['image'],'img-fluid rounded-1',$Listing['name'],PEOPLE_X.','.PEOPLE_Y);?>
                <div class="card-body text-center">
                    <h3 class="title">
                        <?php echo $Listing['name'];?>
                    </h3>
                    <div class="department">
                        <?php echo $this->translate($Listing['department']);?>
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