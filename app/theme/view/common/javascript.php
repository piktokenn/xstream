
<div class="position-fixed start-0 bottom-0 p-xl-4 p-3 modal-cookie d-none">
    <div class="position-relative">
        <div class="card shadow-lg bg-white border-0 rounded-lg-pill">
            <div class="card-body text-center px-4 d-flex align-items-center flex-nowrap">
                <p class="fs-sm text-muted mb-0 me-3">
                    <?php echo $this->translate('This website uses cookies to ensure you get the best experience on our website');?> <a href="<?php echo page(null,'cookie');?>" class="text-theme">
                        <?php echo $this->translate('Cookie policy');?></a></p>
                <button type="button" class="btn-close close-cookie btn-sm ms-auto shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo THEME.'/js/jquery.min.js?v='.VERSION;?>"></script>
<script src="<?php echo THEME.'/js/bootstrap.js?v='.VERSION;?>"></script>
<script src="<?php echo THEME.'/js/lazysizes.js?v='.VERSION;?>"></script>

<script src="<?php echo THEME.'/js/jquery.snackbar.js?v='.VERSION;?>"></script>
<script src="<?php echo THEME.'/js/jquery.range.js?v='.VERSION;?>"></script>
<script src="<?php echo THEME.'/js/plugin.js?v='.VERSION;?>"></script>

<?php 
$Allowed = array(
    'Serie',
    'Episode',
    'Thread',
    'Movie'
);
if(isset($Route->target) AND in_array($Route->target, $Allowed)) { 
?>
<script src="<?php echo THEME.'/js/jquery.tmpl.js?v='.VERSION;?>"></script>
<script src="<?php echo THEME.'/js/jquery.comment.js?v='.VERSION;?>"></script>
<script src="<?php echo THEME.'/js/jquery.lightbox.js?v='.VERSION;?>"></script>
<script src="<?php echo ASSETS.'/player/videojs/js/video.min.js?v='.VERSION;?>"></script>
<script src="<?php echo ASSETS.'/player/videojs/js/ads.min.js?v='.VERSION;?>"></script>
<script src="<?php echo ASSETS.'/player/videojs/js/youtube.min.js?v='.VERSION;?>"></script>
<script src="<?php echo ASSETS.'/player/videojs/js/ima.js?v='.VERSION;?>"></script>
<?php } ?>
<script src="<?php echo THEME.'/js/main.js?v='.VERSION;?>"></script>
<?php if(isset($_SESSION["notify"]["text"])) { ?>
<script type="text/javascript">
(function($) {
    'use strict';
    Snackbar.show({ text: '<?php echo $_SESSION["notify"]["text"] ?>', });
})(jQuery);
</script>
<?php } ?>