<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Original title');?></label>
    <input type="text" name="title" class="form-control form-control-lg" placeholder="<?php echo $this->translate('Original title');?>" required="true" value="<?php if(isset($Listing['title'])) echo $Listing['title'];?>">
    <?php if(isset($Listing['self'])) { ?>
    <div class="fs-xs mt-2">
        <span class="fw-semibold">Permalink : </span>
        <span class="permalink">
            <?php echo APP;?>/<input type="text" name="self" class="form-control d-inline-block fs-xs py-0 bg-transparent border-0 shadow-none px-0 fw-semibold w-auto" value="<?php echo $Listing['self'];?>"></span>
    </div>
    <?php } ?>
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Alternative title');?></label>
    <input type="text" name="title_sub" class="form-control" placeholder="<?php echo $this->translate('Alternative title');?>" value="<?php if(isset($Listing['title_sub'])) echo $Listing['title_sub'];?>">
    <div class="text-muted fs-xs mt-2">*
        <?php echo $this->translate('Alternative title is used for the translation of the content into your language.');?>
    </div>
</div>
<div class="mb-3">
    <label for="cover" class="form-label">
        <?php echo $this->translate('Cover');?></label>
    <input class="form-control" name="cover" type="file" id="cover" accept="image/*">
    <div class="fs-xs py-2 text-muted">
        *
        <?php echo $this->translate('Allow image type jpg, png, webp');?>
    </div>
    <input type="hidden" name="cover_url">
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo self::translate('Genre');?></label>
    <div>
        <select name="genres[]" class="bs-select" multiple data-live-search="true" required="true">
            <?php foreach($Genres as $Genre) { ?>
            <option value="<?php echo $Genre['id'];?>" <?php if(isset($SelectGenres) && in_array($Genre['id'], $SelectGenres)) echo ' selected=""' ;?>
                <?php echo 'data-text="'.$Genre['name'].'"';?>>
                <?php echo $Genre['name'];?>
            </option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Overview');?></label>
    <textarea name="overview" class="form-control" rows="4" placeholder="<?php echo $this->translate('Overview');?>"><?php if(isset($Listing['overview'])) echo $Listing['overview'];?></textarea>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('Country');?></label>
            <select name="country" class="bs-select" data-live-search="true">
                <option value="">
                    <?php echo $this->translate('Country');?>
                </option>
                <?php foreach ($Countries as $Country) { ?>
                <option value="<?php echo $Country['id'];?>" data-text="<?php echo $Country['language'];?>" <?php if(isset($Listing['country']) AND $Listing['country']==$Country['id']) echo 'selected="true"' ;?>>
                    <?php echo $Country['name'];?>
                </option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('Platform');?></label>
            <select name="platform" class="bs-select" data-live-search="true">
                <option value="">
                    <?php echo $this->translate('Platform');?>
                </option>
                <?php foreach ($Platforms as $Platform) { ?>
                <option value="<?php echo $Platform['id'];?>" <?php if(isset($Listing['platform']) AND $Listing['platform']==$Platform['id']) echo 'selected="true"' ;?>>
                    <?php echo $Platform['name'];?>
                </option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('IMDb Rating');?></label>
            <input type="text" name="vote_average" class="form-control" placeholder="<?php echo $this->translate('IMDb Rating');?>" value="<?php echo isset($Listing['vote_average']) ? $Listing['vote_average'] : null;?>">
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('Release date');?></label>
            <input type="date" name="release_date" class="form-control" placeholder="<?php echo $this->translate('Release date');?>" value="<?php echo isset($Listing['release_date']) ? $Listing['release_date'] : null;?>">
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('Duration');?></label>
            <input type="text" name="runtime" class="form-control" placeholder="<?php echo $this->translate('Duration');?>" value="<?php echo isset($Listing['runtime']) ? $Listing['runtime'] : null;?>">
        </div>
    </div>
    <div class="col-md-3">
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
<hr class="my-3 bg-gray-200">
<div class="mb-3">
    <label class="form-label" for="keywords">
        <?php echo $this->translate('Keywords');?></label>
    <textarea name="keywords" id="keywords" class="form-control" maxlength="999" placeholder="<?php echo $this->translate('Keywords');?>"><?php echo isset($Listing['keywords']) ? $Listing['keywords'] : null;?></textarea>
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Information box');?></label>
    <input type="text" name="data[notification]" class="form-control" placeholder="<?php echo $this->translate('Information box');?>" value="<?php if(isset($Data['notification'])) echo $Data['notification']; ?>">
</div>