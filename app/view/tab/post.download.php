<!-- table -->
<button class="btn btn-primary btn-icon-text rounded-pill me-3 add-video">
    <svg width="16" height="18" stroke="currentColor" stroke-width="1.75" fill="none">
        <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#add';?>"></use>
    </svg>
    <span class="d-none d-lg-block ms-2 fs-xs">
        <?php echo $this->translate('Add new');?></span>
</button>
<!-- table -->
<div class="table-responsive-sm">
    <table class="table table-themev2 shadow-none border-gray-100 align-middle video-table">
        <thead>
            <tr class="text-gray-500 fs-xs">
                <th scope="col" width="5"></th>
                <th scope="col">
                    <?php echo $this->translate('Service');?>
                </th>
                <th scope="col">
                    <?php echo $this->translate('Type');?>
                </th>
                <th scope="col">
                    <?php echo $this->translate('URL');?>
                </th>
                <th scope="col" width="5" class="text-end"></th>
            </tr>
        </thead>
        <tbody class="sortable-video">
            <?php if(isset($Videos)) { ?>
            <?php foreach($Videos as $Video) { ?>
            <input type="hidden" name="video[<?php echo $Video['id'];?>][id]" value="<?php echo $Video['id'];?>">
            <tr class="empty-row" data-id="<?php echo $Video['id'];?>">
                <td>
                    <input type="hidden" name="video[<?php echo $Video['id'];?>][sortable]" class="sortable-input" value="<?php echo $Video['sortable'];?>">
                    <div class="btn btn-square btn-ghost rounded-circle js-handle">
                        <svg width="20" height="20" fill="currentColor">
                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#drag';?>"></use>
                        </svg>
                    </div>
                </td>
                <td>
                    <select name="video[<?php echo $Video['id'];?>][service]" class="form-select">
                        <option value="">
                            <?php echo $this->translate('Choose');?>
                        </option>
                        <?php foreach($Services as $Service) { ?>
                        <option value="<?php echo $Service['id'];?>" <?php if($Video['service_id']==$Service['id']) echo 'selected' ;?>>
                            <?php echo $Service['name'];?>
                        </option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <select name="video[<?php echo $Video['id'];?>][source]" class="form-select">
                        <option value="">
                            <?php echo $this->translate('Choose');?>
                        </option>
                        <option value="youtube" <?php if($Video['source']=='youtube' ) echo 'selected' ;?>>Youtube</option>
                        <option value="mp4" <?php if($Video['source']=='mp4' ) echo 'selected' ;?>>Mp4</option>
                        <option value="mkv" <?php if($Video['source']=='mkv' ) echo 'selected' ;?>>Mkv</option>
                        <option value="webm" <?php if($Video['source']=='webm' ) echo 'selected' ;?>>Webm</option>
                        <option value="embed" <?php if($Video['source']=='embed' ) echo 'selected' ;?>>Embed</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="video[<?php echo $Video['id'];?>][embed]" class="form-control" placeholder="<?php echo $this->translate('URL');?>" value="<?php echo $Video['embed'];?>">
                </td>
                <td class="text-end">
                    <div class="btn btn-square btn-sm btn-ghost rounded-circle confirm remove" data-id="<?php echo $Video['id'];?>" data-type="video" data-ajax="true">
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
<script id="empty-row" type="text/x-jquery-tmpl">
    <tr class="empty-row" data-id="${id}">
    <td>
        <input type="hidden" name="video[${id}][sortable]" class="sortable-input" value="${id}">
        <div class="btn btn-square btn-ghost rounded-circle js-handle">
            <svg width="20" height="20" fill="currentColor">
                <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#drag';?>"></use>
            </svg>
        </div>
    </td>
    <td>
        <select name="video[${id}][service]" class="form-select">
            <option value="">
                <?php echo $this->translate('Choose');?>
            </option>
            <?php foreach($Services as $Service) { ?>
            <option value="<?php echo $Service['id'];?>">
                <?php echo $Service['name'];?>
            </option>
            <?php } ?>
        </select>
    </td>
    <td>
        <select name="video[${id}][source]" class="form-select">
            <option value="">
                <?php echo $this->translate('Choose');?>
            </option>
                        <option value="youtube">Youtube</option>
                        <option value="mp4">Mp4</option>
                        <option value="mkv">Mkv</option>
                        <option value="webm">Webm</option>
                        <option value="embed">Embed</option>
        </select>
    </td>
    <td>
        <input type="text" name="video[${id}][embed]" class="form-control" placeholder="<?php echo $this->translate('URL');?>">
    </td>
    <td class="text-end">
        <div class="btn btn-square btn-sm btn-ghost rounded-circle confirm remove" data-id="${id}" data-type="video">
            <svg width="18" height="18" fill="currentColor">
                <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#delete';?>"></use>
            </svg>
        </div>
    </td>
</tr>
</script>