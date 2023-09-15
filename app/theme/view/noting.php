<?php require PATH . '/theme/view/common/head.php'; ?>
<?php require PATH . '/theme/view/common/header.php'; ?>

    <div class="noting py-lg-9 py-4 d-flex justify-content-center flex-column align-items-center">
        <div class="glitch glitch-text-lg" data-text="404">
            404
        </div>
        <div class="glitch glitch-text" data-text="<?php echo $this->translate('Page not found');?>">
            <?php echo $this->translate('Page not found');?>
        </div>
    </div>

<?php require PATH . '/theme/view/common/javascript.php'; ?>
<?php require PATH . '/theme/view/common/footer.php'; ?>