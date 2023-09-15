<div class="btn btn-primary btn-icon-text rounded-pill mb-3 add-season">
    <svg width="16" height="18" stroke="currentColor" stroke-width="1.75" fill="none">
        <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#add';?>"></use>
    </svg>
    <span class="d-none d-lg-block ms-2 fs-xs">
        <?php echo $this->translate('Add season');?></span>
</div>
<div class="table-responsive-sm">
    <table class="table table-themev2 shadow-none border-gray-100 align-middle season-table">
        <thead>
            <tr class="text-gray-500 fs-xs">
                <th scope="col" width="70"></th>
                <th scope="col">
                    <?php echo $this->translate('Name');?>
                </th>
                <th scope="col" width="70" class="text-end"></th>
            </tr>
        </thead>
        <tbody class="sortable-season">
            <?php if(isset($Seasons)) { ?>
            <?php foreach ($Seasons as $Season) { ?>
            <tr class="empty-row" data-id="<?php echo $Season['id'];?>">
                <td>
                    <input type="hidden" name="season[<?php echo $Season['id'];?>][sortable]" class="sortable-input" value="<?php echo $Season['sortable'];?>">
                    <input type="hidden" name="season[<?php echo $Season['id'];?>][id]" value="<?php echo $Season['id'];?>">
                    <div class="btn btn-square btn-ghost rounded-circle js-handle">
                        <svg width="20" height="20" fill="currentColor">
                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#drag';?>"></use>
                        </svg>
                    </div>
                </td>
                <td class="px-0">
                    <input type="text" name="season[<?php echo $Season['id'];?>][name]" class="form-control" placeholder="<?php echo $this->translate('Name');?>" value="<?php echo $Season['name'];?>">
                </td>
                <td class="text-end">
                    <div class="btn btn-square btn-ghost rounded-circle confirm remove" data-id="<?php echo $Season['id'];?>" data-type="season" data-ajax="true">
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
<script id="empty-season" type="text/x-jquery-tmpl">
    <tr class="empty-row" data-id="${id}">
        <td>
            <input type="hidden" name="season[][sortable]" class="sortable-input" value="${id}">
            <div class="btn btn-square btn-ghost rounded-circle js-handle">
                <svg width="20" height="20" fill="currentColor">
                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#drag';?>"></use>
                </svg>
            </div>
        </td>
        <td class="px-0">
            <input type="text" name="season[][name]" class="form-control" placeholder="<?php echo $this->translate('Name');?>" value="${name}">
        </td>  
        <td class="text-end">
            <div class="btn btn-square btn-ghost rounded-circle confirm remove" data-id="${id}" data-type="season">
                <svg width="18" height="18" fill="currentColor">
                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#delete';?>"></use>
                </svg>
            </div>
        </td>
    </tr>
</script>