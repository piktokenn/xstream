
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Title');?></label>
    <input type="text" name="title" class="form-control form-control-lg" placeholder="<?php echo $this->translate('Title');?>" required="true" value="<?php if(isset($Listing['title'])) echo $Listing['title'];?>">
    <?php if(isset($Listing['self'])) { ?>
    <div class="fs-xs mt-2">
        <span class="fw-semibold">Permalink : </span>
        <span class="permalink">
            <?php echo APP;?>/<input type="text" name="self" class="form-control d-inline-block fs-xs py-0 bg-transparent border-0 shadow-none px-0 fw-semibold w-auto" value="<?php echo $Listing['self'];?>"></span>
    </div>
    <?php } ?>
</div>
<div class="mb-3">
    <label for="number" class="form-label">
        <?php echo $this->translate('Number');?></label>
    <input type="number" name="title_number" placeholder="<?php echo $this->translate('Number');?>" class="form-control" id="number" required="true" value="<?php echo isset($Listing['title_number']) ? $Listing['title_number'] : null;?>">
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Overview');?></label>
    <textarea name="overview" class="form-control" rows="3" placeholder="<?php echo $this->translate('Overview');?>"><?php if(isset($Listing['overview'])) echo $Listing['overview'];?></textarea>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('Release date');?></label>
            <input type="date" name="release_date" class="form-control" placeholder="<?php echo $this->translate('Release date');?>" value="<?php echo isset($Listing['release_date']) ? $Listing['release_date'] : null;?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('Duration');?></label>
            <input type="text" name="runtime" class="form-control" placeholder="<?php echo $this->translate('Duration');?>" value="<?php echo isset($Listing['runtime']) ? $Listing['runtime'] : null;?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('View');?></label>
            <input type="text" name="view" class="form-control" placeholder="<?php echo $this->translate('View');?>" value="<?php echo isset($Listing['view']) ? $Listing['view'] : null;?>">
        </div>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Trailer');?></label>
    <input type="text" name="trailer" class="form-control" placeholder="<?php echo $this->translate('Trailer');?>" value="<?php echo isset($Listing['trailer']) ? $Listing['trailer'] : null;?>">
    <div class="fs-xs text-muted py-2">exm: https://youtube.com/embed/0000</div>
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Information box');?></label>
    <input type="text" name="data[notification]" class="form-control" placeholder="<?php echo $this->translate('Information box');?>" value="<?php if(isset($Data['notification'])) echo $Data['notification']; ?>">
</div>