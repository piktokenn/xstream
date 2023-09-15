<div class="mb-3">
    <label class="form-label">Tmdb api key</label>
    <input type="text" name="data[<?php echo $key;?>][tmdb_api]" class="form-control form-control-lg" placeholder="Tmdb api key" value="<?php echo get($Settings, 'data.tmdb_api', $key);?>">
    <div class="mt-2 fs-xs text-muted">** Thememoviedb api key get <a href="https://www.themoviedb.org/settings/api" class="fw-semibold" target="_blank">themoviedb.org</a></div>
</div>
<div class="mb-3">
    <label class="form-label">Tmdb language</label>
    <input type="text" name="data[<?php echo $key;?>][tmdb_language]" class="form-control" placeholder="en" value="<?php echo get($Settings, 'data.tmdb_language', $key);?>">
    <div class="mt-2 fs-xs text-muted">**
        <?php echo $this->translate('Language code to pull from api');?>
    </div>
</div>
<div class="mb-3">
    <div class="form-switch">
        <input class="form-check-input" id="peoplex" type="checkbox" name="data[<?php echo $key?>][tmdb_people]" value="1" <?php if(get($Settings,'data.tmdb_people',$key)=='1' ) echo 'checked="true"' ;?>>
        <label class="form-check-label" for="peoplex">
            <?php echo $this->translate('Adding people');?></label>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Adding people limit');?></label>
    <input type="number" name="data[<?php echo $key;?>][tmdb_people_limit]" class="form-control" placeholder="<?php echo $this->translate('Adding people limit');?>" value="<?php echo get($Settings, 'data.tmdb_people_limit', $key);?>">
</div>