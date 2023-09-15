<?php require PATH . '/theme/view/common/head.php'; ?>
<?php require PATH . '/theme/view/common/header.php'; ?>
<div class="layout-section">
    <h1 class="h2 mb-2">
        <?php echo $Listing['name'];?>
    </h1>
    <div class="text-editor">
        <?php echo htmlspecialchars_decode($Listing['body']);?>
    </div>
</div>
<?php require PATH . '/theme/view/common/javascript.php'; ?>
<?php require PATH . '/theme/view/common/footer.php'; ?>