
<?php require PATH . '/config/array.config.php'; ?>
<div class="modal-content">
    <div class="modal-body p-4 p-xl-5 position-relative">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post">
            <input type="hidden" name="_ACTION" value="thread">
            <input type="hidden" name="_TOKEN" value="<?php echo $Token;?>">
            <div class="mb-3">
                <label class="form-label">
                    <?php echo $this->translate('Heading');?></label>
                    <input type="text" name="title" class="form-control form-control-lg" placeholder="<?php echo $this->translate('Heading');?>">
            </div>
            <div class="mb-3">
                <label class="form-label">
                    <?php echo $this->translate('Description');?></label>
                <textarea name="description" class="form-control" placeholder="<?php echo $this->translate('Description');?>" maxlength="300" rows="5"></textarea>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-theme py-3">
                    <?php echo $this->translate('Open thread');?></button>
            </div>
        </form>
    </div>
</div>