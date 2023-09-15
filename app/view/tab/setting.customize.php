<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Color');?></label>
    <input type="text" name="data[<?php echo $key;?>][color]" class="form-control form-control-lg colorpicker" placeholder="#000" value="<?php echo get($Settings, 'data.color', $key);?>" maxlength="255">
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Background');?></label>
    <input type="text" name="data[<?php echo $key;?>][background]" class="form-control form-control-lg colorpicker" placeholder="#000" value="<?php echo get($Settings, 'data.background', $key);?>" maxlength="255">
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Header');?></label>
    <select name="data[<?php echo $key?>][header]" class="form-select">
        <option value="v1" <?php if(empty(get($Settings,'data.header',$key)) OR get($Settings,'data.header',$key)=='v1' ) echo 'selected' ;?>>
            Header v1
        </option>
        <option value="v2" <?php if(get($Settings,'data.header',$key)=='v2' ) echo 'selected' ;?>>
            Header v2
        </option>
    </select>
</div>
<div class="mb-3">
    <label class="form-label"><?php echo $this->translate('Layout width');?></label>
    <input type="text" name="data[<?php echo $key?>][width]" value="<?php echo get($Settings,'data.width',$key);?>" class="form-control" placeholder="<?php echo $this->translate('Layout width');?>" maxlength="160">
</div>
<div class="mb-3">
    <label class="form-label"><?php echo $this->translate('Column count');?></label>
    <select class="form-select" name="data[<?php echo $key?>][column]">
        <option value="8"<?php if(get($Settings,'data.column',$key) == 8) echo 'selected=""';?>>8</option>
        <option value="6"<?php if(get($Settings,'data.column',$key) == 6) echo 'selected=""';?>>6</option>
        <option value="4"<?php if(get($Settings,'data.column',$key) == 4) echo 'selected=""';?>>4</option>
    </select>
</div>
<hr class="my-4">
<label class="form-label">What to display in the Menu</label>
<div class="d-flex align-items-center">
    <div class="form-switch mb-2 text-nowrap">
        <input class="form-check-input" id="explore" type="checkbox" name="data[<?php echo $key?>][explore]" value="1" <?php if(get($Settings,'data.explore',$key)=='1' ) echo 'checked="true"' ;?>>
        <label class="form-check-label" for="explore">
            <?php echo $this->translate('Explore');?></label>
    </div>
    <div class="form-switch mb-2 text-nowrap ms-3">
        <input class="form-check-input" id="movies" type="checkbox" name="data[<?php echo $key?>][movies]" value="1" <?php if(get($Settings,'data.movies',$key)=='1' ) echo 'checked="true"' ;?>>
        <label class="form-check-label" for="movies">
            <?php echo $this->translate('Movies');?></label>
    </div>
    <div class="form-switch mb-2 text-nowrap ms-3">
        <input class="form-check-input" id="series" type="checkbox" name="data[<?php echo $key?>][series]" value="1" <?php if(get($Settings,'data.series',$key)=='1' ) echo 'checked="true"' ;?>>
        <label class="form-check-label" for="series">
            <?php echo $this->translate('TV Shows');?></label>
    </div>
    <div class="form-switch mb-2 text-nowrap ms-3">
        <input class="form-check-input" id="topimdb" type="checkbox" name="data[<?php echo $key?>][topimdb]" value="1" <?php if(get($Settings,'data.topimdb',$key)=='1' ) echo 'checked="true"' ;?>>
        <label class="form-check-label" for="topimdb">
            <?php echo $this->translate('Top IMDb');?></label>
    </div>
    <div class="form-switch mb-2 text-nowrap ms-3">
        <input class="form-check-input" id="community" type="checkbox" name="data[<?php echo $key?>][community]" value="1" <?php if(get($Settings,'data.community',$key)=='1' ) echo 'checked="true"' ;?>>
        <label class="form-check-label" for="community">
            <?php echo $this->translate('Community');?></label>
    </div>
    <div class="form-switch mb-2 text-nowrap ms-3">
        <input class="form-check-input" id="Request" type="checkbox" name="data[<?php echo $key?>][request]" value="1" <?php if(get($Settings,'data.request',$key)=='1' ) echo 'checked="true"' ;?>>
        <label class="form-check-label" for="Request">
            <?php echo $this->translate('Request');?></label>
    </div>
    <div class="form-switch mb-2 text-nowrap ms-3">
        <input class="form-check-input" id="platform" type="checkbox" name="data[<?php echo $key?>][platform]" value="1" <?php if(get($Settings,'data.platform',$key)=='1' ) echo 'checked="true"' ;?>>
        <label class="form-check-label" for="platform">
            <?php echo $this->translate('Platform');?></label>
    </div>
    <div class="form-switch mb-2 text-nowrap ms-3">
        <input class="form-check-input" id="people" type="checkbox" name="data[<?php echo $key?>][people]" value="1" <?php if(get($Settings,'data.people',$key)=='1' ) echo 'checked="true"' ;?>>
        <label class="form-check-label" for="people">
            <?php echo $this->translate('People');?></label>
    </div>
</div>
<hr class="my-3">
<div class="sortable-module">
    <?php 
    foreach ($Modules as $Module) { 
    $ModuleData       = json_decode($Module['data'], true);
    ?>
    <div class="card shadow-none mb-1" data-id="<?php echo $Module['id'];?>">
        <input type="hidden" name="module[<?php echo $Module['id'];?>][id]" value="<?php echo $Module['id'];?>">
        <input type="hidden" name="module[<?php echo $Module['id'];?>][page]" value="<?php echo $Module['page'];?>">
        <input type="hidden" name="module[<?php echo $Module['id'];?>][sortable]" value="<?php echo $Module['sortable'];?>" class="sortable-input">
        <div class="card-header border-gray-100 py-2 px-3 d-flex align-items-center">
            <button type="button" class="btn btn-square btn-ghost rounded-circle btn-sm js-handle">
                <svg width="20" height="20" fill="currentColor">
                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#drag';?>"></use>
                </svg>
            </button>
            <div class="flex-fill px-3 fs-sm text-body fw-semibold" data-bs-toggle="collapse" href="#c<?php echo $Module['id'];?>" role="button" aria-expanded="false" aria-controls="c<?php echo $Module['id'];?>">
                <?php echo $Module['name'];?>
            </div>
        </div>
        <div class="collapse" id="c<?php echo $Module['id'];?>">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">
                        <?php echo $this->translate('Heading');?></label>
                    <input type="text" name="module[<?php echo $Module['id'];?>][name]" class="form-control form-control-lg" placeholder="<?php echo $this->translate('Heading');?>" value="<?php echo $Module['name'];?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">
                        <?php echo $this->translate('Sorting');?></label>
                    <select name="module[<?php echo $Module['id'];?>][data][sorting]" class="form-select">
                        <option value="id desc" <?php if(isset($ModuleData['sorting']) AND $ModuleData['sorting']=='id.desc' ) echo 'selected=""' ;?>>
                            <?php echo $this->translate('Newest');?>
                        </option>
                        <option value="hit desc" <?php if(isset($ModuleData['sorting']) AND $ModuleData['sorting']=='hit.desc' ) echo 'selected=""' ;?>>
                            <?php echo $this->translate('Popular');?>
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">
                        <?php echo $this->translate('Limit');?></label>
                    <input type="text" name="module[<?php echo $Module['id'];?>][data_limit]" class="form-control" placeholder="Limit" value="<?php echo $Module['data_limit'];?>">
                </div>
                <div class="form-switch mb-2">
                    <input class="form-check-input" id="m<?php echo $Module['id'];?>" type="checkbox" name="module[<?php echo $Module['id'];?>][status]" value="1" <?php if($Module['status']=='1' ) echo 'checked="true"' ;?>>
                    <label class="form-check-label" for="m<?php echo $Module['id'];?>">
                        <?php echo $this->translate('Active');?></label>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>