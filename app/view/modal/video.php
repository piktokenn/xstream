<div class="modal-content">
    <div class="modal-body p-4 p-xl-5 position-relative">
        <form method="post" class="episode-form">
            <input type="hidden" name="season" value="<?php echo $_GET['season'];?>">
            <div class="mb-3">
                <label class="form-label">
                    <?php echo $this->translate('Custom label');?></label>
                <input type="text" name="title" class="form-control" placeholder="<?php echo $this->translate('Custom label');?>" value="<?php if(isset($Listing['title'])) echo $Listing['title'];?>">
                <div class="text-muted fs-xs mt-2">*
                    <?php echo $this->translate('Alternative title is used for the translation of the content into your language.');?>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">
                    <?php echo $this->translate('Service');?></label>
                <select class="form-select">
                    <option value="">
                        <?php echo $this->translate('Choose');?>
                    </option>
                    <?php foreach($Services as $Service) { ?>
                    <option value=""><?php echo $Service['name'];?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">
                    <?php echo $this->translate('Source');?></label>
                <select class="form-select">
                    <option value="">
                        <?php echo $this->translate('Choose');?>
                    </option>
                    <option value="youtube">Youtube</option>
                    <option value="mp4">Mp4</option>
                    <option value="mp4">Mkv</option>
                    <option value="embed">Webm</option>
                    <option value="code">Embed</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">
                    <?php echo $this->translate('Url');?></label>
                <input type="text" name="url" class="form-control" placeholder="<?php echo $this->translate('Url');?>" value="<?php if(isset($Listing['url'])) echo $Listing['url'];?>">
            </div>
            <button type="submit" class="btn btn-primary w-xl-250 py-3 btn-episode">
                <?php echo $this->translate('Save changes');?></button>
            <button type="button" class="btn text-current shadow-none fs-xs" data-bs-dismiss="modal" aria-label="Close">
                <?php echo $this->translate('Cancel');?></button>
        </form>
    </div>
</div>
<script type="text/javascript">
(function($) {
    "use strict";
    $('body').on('click', '.btn-episode', function() {

        $('#empty-episode').tmpl($('.episode-form').serialize()).appendTo('#episode-sortable');
        $('.modal').modal('hide');
        return false;
    });
})(jQuery);
</script>