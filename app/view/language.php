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
        <div class="row">
            <div class="col-lg-4">
                <div class="mb-3">
                    <label class="form-label">
                        <?php echo $this->translate('Language code');?></label>
                    <input type="text" name="language" class="form-control" placeholder="<?php echo $this->translate('Language code');?>" required="true" value="<?php if(isset($Listing['language'])) echo $Listing['language'];?>">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mb-3">
                    <label class="form-label">
                        <?php echo $this->translate('Text direction');?></label>
                    <select name="text_direction" class="form-select">
                        <option value="ltr" <?php if(isset($Listing['text_direction']) AND $Listing['text_direction']=='ltr' ) echo 'selected=""' ;?>>LTR</option>
                        <option value="rtl" <?php if(isset($Listing['text_direction']) AND $Listing['text_direction']=='rtl' ) echo 'selected=""' ;?>>RTL</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mb-3">
                    <label class="form-label">
                        <?php echo $this->translate('Currency');?></label>
                    <input type="text" name="currency" class="form-control" placeholder="<?php echo $this->translate('Currency');?>" required="true" value="<?php if(isset($Listing['currency'])) echo $Listing['currency'];?>">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-xl-300 py-3 mb-3">
            <?php echo $this->translate('Save changes');?></button>
        <div class="mb-3">
            <label class="form-label fs-xs">
                <?php echo $this->translate('Advanced');?></label>
            <div class="form-switch mb-1">
                <input class="form-check-input" type="checkbox" id="Published" name="status" value="1" <?php if(isset($Listing['status']) AND $Listing['status']==1) echo 'checked=""' ;?>>
                <label class="form-check-label" for="Published">
                    <?php echo $this->translate('Active');?></label>
            </div>
        </div>
        <hr>
        <div class="row gx-xl-5">
            <?php foreach ($Lang as $key => $value) { ?>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">
                        <?php echo $key;?></label>
                    <input type="text" name="lang[<?php echo $key;?>]" class="form-control" placeholder="<?php echo $key;?>" value="<?php echo $value;?>">
                </div>
            </div>
            <?php } ?>
        </div>
    </form>
</div>
<?php require PATH . '/view/common/javascript.php'; ?>
<?php require PATH . '/view/common/footer.php'; ?>