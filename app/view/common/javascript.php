    </div>
</div>
<script src="<?php echo ASSETS.'/js/jquery.js?v='.VERSION;?>"></script>
<script src="<?php echo ASSETS.'/js/bootstrap.bundle.js?v='.VERSION;?>"></script>
<script src="<?php echo ASSETS.'/js/lazysizes.js?v='.VERSION;?>"></script>
<script src="<?php echo ASSETS.'/js/jquery.uploader.js?v='.VERSION;?>"></script>
<script src="<?php echo ASSETS.'/js/jquery.tmpl.js?v='.VERSION;?>"></script>
<script src="<?php echo ASSETS.'/js/bootstrap.select.js?v='.VERSION;?>"></script>
<script src="<?php echo ASSETS.'/js/jquery.snackbar.js?v='.VERSION;?>"></script>
<script src="<?php echo ASSETS.'/js/jquery.colorpicker.js?v='.VERSION;?>"></script>
<script src="<?php echo ASSETS.'/js/jquery.sortable.js?v='.VERSION;?>"></script>
<script src="<?php echo ASSETS.'/js/jquery.selectize.js?v='.VERSION;?>"></script>
<script src="<?php echo ASSETS.'/js/admin.js?v='.VERSION;?>"></script>
<?php if(isset($_SESSION["notify"]["text"])) { ?>
<script type="text/javascript">
(function($) {
    'use strict';
    Snackbar.show({ text: '<?php echo $_SESSION["notify"]["text"] ?>', });
})(jQuery);
</script>
<?php } ?>