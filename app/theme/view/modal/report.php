<?php require PATH . '/config/array.config.php'; ?>
<div class="modal-content">
    <div class="modal-body p-4 p-xl-5 position-relative">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post">
            <input type="hidden" name="_ACTION" value="report">
            <input type="hidden" name="_TOKEN" value="<?php echo $Token;?>">
            <div class="mb-3">
                <label class="form-label">
                    <?php echo $this->translate('Report');?></label>
                <select name="report" class="form-select" required="true">
                    <option value="">
                        <?php echo $this->translate('Choose');?>
                    </option>
                    <?php foreach($Reports as $key => $value) { ?>
                    <option value="<?php echo $key;?>">
                        <?php echo $value;?>
                    </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">
                    <?php echo $this->translate('Description');?></label>
                <textarea name="body" class="form-control" placeholder="<?php echo $this->translate('Description');?>" maxlength="300" rows="5"></textarea>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-theme py-3">
                    <?php echo $this->translate('Submit');?></button>
            </div>
        </form>
    </div>
</div>