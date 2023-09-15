<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Site name');?></label>
    <input type="text" name="data[<?php echo $key;?>][company]" class="form-control" placeholder="<?php echo $this->translate('Site name');?>" value="<?php echo get($Settings, 'data.company', $key);?>">
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="mb-3">
            <label for="icon" class="form-label">
                <?php echo $this->translate('Logo');?></label>
            <input class="form-control" name="logo" type="file" id="logo">
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            <label for="icon" class="form-label">
                <?php echo $this->translate('Favicon');?></label>
            <input class="form-control" name="favicon" type="file" id="favicon">
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('Language');?></label>
            <select name="data[<?php echo $key?>][language]" class="form-select">
                <?php foreach ($Languages as $Language) { ?>
                <option value="<?php echo $Language['language'];?>" <?php if(get($Settings,'data.language',$key)==$Language['language']) echo 'selected' ;?>>
                    <?php echo $Language['name'];?>
                </option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('Dashboard language');?></label>
            <select name="data[<?php echo $key?>][dashboard_language]" class="form-select">
                <?php foreach ($Languages as $Language) { ?>
                <option value="<?php echo $Language['language'];?>" <?php if(get($Settings,'data.dashboard_language',$key)==$Language['language']) echo 'selected' ;?>>
                    <?php echo $Language['name'];?>
                </option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Advanced');?></label>
    <div class="row row-cols-xl-5 row-cols-2">
        <div class="col-auto">
            <div class="form-switch mb-2">
                <input class="form-check-input" id="subtitle" type="checkbox" name="data[<?php echo $key?>][subtitle]" value="1" <?php if(get($Settings,'data.subtitle',$key)=='1' ) echo 'checked="true"' ;?>>
                <label class="form-check-label" for="subtitle">
                    <?php echo $this->translate('Show subtitle in listing');?></label>
            </div>
        </div>
        <div class="col-auto">
            <div class="form-switch mb-2">
                <input class="form-check-input" id="comment" type="checkbox" name="data[<?php echo $key?>][comment]" value="1" <?php if(get($Settings,'data.comment',$key)=='1' ) echo 'checked="true"' ;?>>
                <label class="form-check-label" for="comment">
                    <?php echo $this->translate('Confirm comments add');?></label>
            </div>
        </div>
        <div class="col-auto">
            <div class="form-switch mb-2">
                <input class="form-check-input" id="discussions" type="checkbox" name="data[<?php echo $key?>][discussions]" value="1" <?php if(get($Settings,'data.discussions',$key)=='1' ) echo 'checked="true"' ;?>>
                <label class="form-check-label" for="discussions">
                    <?php echo $this->translate('Confirm discussions add');?></label>
            </div>
        </div>
        <div class="col-auto">
            <div class="form-switch mb-2">
                <input class="form-check-input" id="history" type="checkbox" name="data[<?php echo $key?>][history]" value="1" <?php if(get($Settings,'data.history',$key)=='1' ) echo 'checked="true"' ;?>>
                <label class="form-check-label" for="history">
                    <?php echo $this->translate('Watch history');?></label>
            </div>
        </div>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Description');?></label>
    <textarea name="data[<?php echo $key;?>][description]" class="form-control" placeholder="<?php echo $this->translate('Description');?>" rows="4"><?php echo get($Settings, 'data.description', $key);?></textarea>
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Head custom code');?></label>
    <textarea name="data[<?php echo $key;?>][custom_code]" class="form-control" placeholder="<?php echo $this->translate('Head custom code');?>" rows="4"><?php echo get($Settings, 'data.custom_code', $key);?></textarea>
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Footer description');?></label>
    <div class="card p-2 shadow-none">
        <textarea name="data[<?php echo $key;?>][footer_text]" class="form-control" placeholder=""><?php echo get($Settings, 'data.footer_text', $key) ? htmlspecialchars_decode(get($Settings, 'data.footer_text', $key)) : null;?></textarea>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('Google play link');?></label>
            <input type="text" name="data[<?php echo $key;?>][google_play]" class="form-control" placeholder="<?php echo $this->translate('Google play link');?>" value="<?php echo get($Settings, 'data.google_play', $key);?>">
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('App store link');?></label>
            <input type="text" name="data[<?php echo $key;?>][app_store]" class="form-control" placeholder="<?php echo $this->translate('App store link');?>" value="<?php echo get($Settings, 'data.app_store', $key);?>">
        </div>
    </div>
</div>