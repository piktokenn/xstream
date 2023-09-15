<!-- table -->
<button class="btn btn-primary btn-icon-text rounded-pill me-3 add-subtitle">
    <svg width="16" height="18" stroke="currentColor" stroke-width="1.75" fill="none">
        <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#add';?>"></use>
    </svg>
    <span class="d-none d-lg-block ms-2 fs-xs">
        <?php echo $this->translate('Add new');?></span>
</button>
<!-- table -->
<div class="table-responsive-sm">
    <table class="table table-themev2 shadow-none border-gray-100 align-middle subtitle-table">
        <thead>
            <tr class="text-gray-500 fs-xs">
                <th scope="col" width="5"></th>
                <th scope="col">
                    <?php echo $this->translate('Language');?>
                </th>
                <th scope="col">
                    <?php echo $this->translate('URL');?>
                </th>
                <th scope="col" width="5" class="text-end"></th>
            </tr>
        </thead>
        <tbody class="sortable-subtitle">
            <?php if(isset($Subtitles)) { ?>
            <?php foreach($Subtitles as $Subtitle) { ?>
            <input type="hidden" name="subtitle[<?php echo $Subtitle['id'];?>][id]" value="<?php echo $Subtitle['id'];?>">
            <tr class="empty-subtitle" data-id="<?php echo $Subtitle['id'];?>">
                <td>
                    <input type="hidden" name="subtitle[<?php echo $Subtitle['id'];?>][sortable]" class="sortable-input" value="<?php echo $Subtitle['sortable'];?>">
                    <div class="btn btn-square btn-ghost rounded-circle js-handle">
                        <svg width="20" height="20" fill="currentColor">
                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#drag';?>"></use>
                        </svg>
                    </div>
                </td>
                <td>
                    <select name="subtitle[<?php echo $Subtitle['id'];?>][language_id]" class="form-select">
                        <option value="">
                            <?php echo $this->translate('Choose');?>
                        </option>
                        <?php foreach($Countries as $Country) { ?>
                        <option value="<?php echo $Country['id'];?>" <?php if($Subtitle['language_id']==$Country['id']) echo 'selected' ;?>>
                            <?php echo $Country['name'];?>
                        </option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="subtitle[<?php echo $Subtitle['id'];?>][link]" class="form-control" placeholder="<?php echo $this->translate('URL');?>" value="<?php echo $Subtitle['link'];?>">
                </td>
                <td class="text-end">
                    <div class="btn btn-square btn-sm btn-ghost rounded-circle confirm remove" data-id="<?php echo $Subtitle['id'];?>" data-type="subtitle" data-ajax="true">
                        <svg width="18" height="18" fill="currentColor">
                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#delete';?>"></use>
                        </svg>
                    </div>
                </td>
            </tr>
            <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>
<!-- table -->
<script id="empty-subtitle" type="text/x-jquery-tmpl">
    <tr class="empty-subtitle" data-id="${id}">
    <td>
        <input type="hidden" name="subtitle[${id}][sortable]" class="sortable-input" value="${id}">
        <div class="btn btn-square btn-ghost rounded-circle js-handle">
            <svg width="20" height="20" fill="currentColor">
                <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#drag';?>"></use>
            </svg>
        </div>
    </td>
    <td>
        <select name="subtitle[${id}][language_id]" class="form-select">
            <option value="">
                <?php echo $this->translate('Choose');?>
            </option>
            <?php foreach($Countries as $Country) { ?>
            <option value="<?php echo $Country['id'];?>">
                <?php echo $Country['name'];?>
            </option>
            <?php } ?>
        </select>
    </td>
    <td>
        <input type="text" name="subtitle[${id}][link]" class="form-control" placeholder="<?php echo $this->translate('URL');?>">
    </td>
    <td class="text-end">
        <div class="btn btn-square btn-sm btn-ghost rounded-circle confirm remove" data-id="${id}" data-type="subtitle">
            <svg width="18" height="18" fill="currentColor">
                <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#delete';?>"></use>
            </svg>
        </div>
    </td>
</tr>
</script>