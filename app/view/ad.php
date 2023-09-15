<?php require PATH . '/view/common/head.php'; ?>
<?php require PATH . '/view/common/header.php'; ?>
<?php require_once PATH.'/config/array.config.php'; ?>
<div class="container">
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="_ACTION" value="save">
        <input type="hidden" name="_TOKEN" value="<?php echo $Token?>">
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('Name');?></label>
            <input type="text" name="name" class="form-control form-control-lg" placeholder="<?php echo $this->translate('Name');?>" required="true" value="<?php if(isset($Listing['name'])) echo $Listing['name'];?>">
        </div>
        <div class="mb-3">
            <label class="form-label"><?php echo $this->translate('Type');?></label>
            <select name="type" class="form-select">
                <option value="code" <?php if(isset($Listing['type']) AND $Listing['type']=='code' ) echo 'selected' ;?>><?php echo $this->translate('Code');?></option>
                <option value="image" <?php if(isset($Listing['type']) AND $Listing['type']=='image' ) echo 'selected' ;?>><?php echo $this->translate('Image');?></option>
            </select>
        </div>
        <div class="d-none" data-type="image">
            <div class="mb-3">
                <label class="form-label"><?php echo $this->translate('Image');?></label>
                <input class="form-control" name="image" type="file" id="image">
            </div>
            <div class="mb-3">
                <label class="form-label"><?php echo $this->translate('Link');?></label>
                <input type="text" name="link" value="<?php echo isset($Data['link']) ? $Data['link'] : (isset($_POST['link']) ? $_POST['link'] : null);?>" class="form-control" placeholder="Link">
            </div>
        </div>
        <div class="mb-3 d-none" data-type="code">
            <label class="form-label"><?php echo $this->translate('Code');?></label>
            <textarea name="ads_code" class="form-control" rows="4" placeholder="<?php echo $this->translate('Code');?>"><?php echo isset($Listing['ads_code']) ? $Listing['ads_code'] : (isset($_POST['link']) ? $_POST['link'] : null);?></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-xl-300 py-3 mb-3">
            <?php echo $this->translate('Save change');?></button>
        <div class="mb-3">
            <label class="form-label text-gray-400 fs-xs"><?php echo $this->translate('Advanced');?></label>
            <div class="form-switch mb-1">
                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" <?php if(isset($Listing['status']) AND $Listing['status']==1) echo 'checked=""' ;?>>
                <label class="form-check-label ms-2" for="status"><?php echo $this->translate('Publish');?></label>
            </div>
            <div class="form-switch mb-1">
                <input class="form-check-input" type="checkbox" id="display_user" name="display_user" value="1" <?php if(isset($Listing['display_user']) AND $Listing['display_user']==1) echo 'checked=""' ;?>>
                <label class="form-check-label ms-2" for="display_user"><?php echo $this->translate('Members not show');?></label>
            </div>
        </div>
    </form>
</div>
<?php require PATH . '/view/common/javascript.php'; ?>
<script type="text/javascript">
(function($) {
    'use strict';
    $(document).on('change', '[name="type"]', function() {
        var id = $(this).val();
        if (id == 'image') {
            $('[data-type="image"]').removeClass('d-none');
            $('[data-type="code"]').addClass('d-none');
        } else {
            $('[data-type="code"]').removeClass('d-none');
            $('[data-type="image"]').addClass('d-none');
        }
    });
    $('[name="type"]').trigger('change');
})(jQuery);
</script>
<?php require PATH . '/view/common/footer.php'; ?>