<?php require PATH . '/view/common/head.php'; ?>
<?php require PATH . '/view/common/header.php'; ?>
<?php require_once PATH.'/config/array.config.php'; ?>
<div class="container pb-5">
<div class="py-4 px-xl-5 text-center py-xl-9 py-5">
    <img src="<?php echo ASSETS.'/img/speed.svg';?>" alt="speed" width="180" class="img-fluid">
    <div class="fs-base fw-bold text-success mt-4">Cache cleared</div>
    <div class="text-gray-400 fs-sm">
        <?php echo $this->translate('Cache cleared completely');?>
    </div>
</div>
</div>
<?php require PATH . '/view/common/javascript.php'; ?>
<?php require PATH . '/view/common/footer.php'; ?>