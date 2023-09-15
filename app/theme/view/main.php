<?php require PATH . '/theme/view/common/head.php'; ?>
<?php require PATH . '/theme/view/common/header.php'; ?>
<?php  
$iModule = 0;
foreach ($Modules as $Module) {
    if(isset($Module['data'])) {
        $ModuleData       = json_decode($Module['data'], true);
    }
    include PATH . '/theme/view/module/'.$Module['module_file'].'.php';
    if($iModule == 0 OR $iModule == 2 OR $iModule == 4) {
        echo ads($Ads,1,'mx-lg-auto px-3 mb-4');
    } 
    $iModule++;
} 
?>
<?php if(get($Settings,'data.footer_text','general')) { ?>
<div class="layout-section layout-text pb-2 pt-3">
    <?php echo htmlspecialchars_decode(get($Settings,'data.footer_text','general'));?>
</div>
<?php } ?>
<?php require PATH . '/theme/view/common/javascript.php'; ?>
<?php require PATH . '/theme/view/common/footer.php'; ?>