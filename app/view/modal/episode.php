<div class="modal-content">
    <div class="modal-body p-4 p-xl-5 position-relative">
        <form method="post" class="episode-form">
            <input type="hidden" name="season" value="<?php echo $_GET['season'];?>">
            <div class="mb-3">
                <label class="form-label">
                    <?php echo $this->translate('Title');?></label>
                <input type="text" name="title" class="form-control" placeholder="<?php echo $this->translate('Title');?>" value="<?php if(isset($Listing['title'])) echo $Listing['title'];?>">
                <div class="text-muted fs-xs mt-2">*
                    <?php echo $this->translate('Alternative title is used for the translation of the content into your language.');?>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">
                    <?php echo $this->translate('Number');?></label>
                <input type="number" name="number" class="form-control" placeholder="<?php echo $this->translate('Number');?>" value="<?php if(isset($Listing['number'])) echo $Listing['number'];?>">
            </div>
            <div class="mb-3">
                <label class="form-label">
                    <?php echo $this->translate('Release date');?></label>
                <input type="date" name="release_date" class="form-control" placeholder="<?php echo $this->translate('Release date');?>" value="<?php echo isset($Listing['release_date']) ? $Listing['release_date'] : null;?>">
            </div>
            <div class="mb-3">
                <label class="form-label">
                    <?php echo $this->translate('Overview');?></label>
                <textarea name="overview" class="form-control" rows="4" placeholder="<?php echo $this->translate('Overview');?>"><?php if(isset($Listing['overview'])) echo $Listing['overview'];?></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-xl-300 py-3 btn-episode">
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