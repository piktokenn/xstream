<div class="mb-3">
    <select name="name" class="form-control selectize-people" data-placeholder="<?php echo self::translate('Search');?> .."></select>
</div>
<div class="row row-cols-xxl-8 row-people">
    <?php if(isset($Peoples)) { ?>
    <?php foreach($Peoples as $People) { ?>
    <div class="col-md-3 col-cast" data-id="<?php echo $People['people_id'];?>">
        <input type="hidden" name="peoples[<?php echo $People['id'];?>][id]" value="<?php echo $People['id'];?>">
        <div class="card card-people border-0">
            <div class="position-relative">
                <?php echo picture(PEOPLE_FOLDER,$People['image'],'card-img-top',$Listing['title'],PEOPLE_X.',auto');?>
                <div class="card-overlay d-flex justify-content-center text-center p-2">
                    <div class="btn btn-danger btn-sm btn-icon-text rounded-pill confirm remove" data-id="<?php echo $People['people_id'];?>" data-type="cast" data-ajax="true">
                        <svg width="16" height="18" fill="currentColor">
                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#delete';?>"></use>
                        </svg>
                        <span class="d-none d-lg-block ms-2 fs-xs">
                            <?php echo $this->translate('Remove');?></span>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <h3 class="fs-sm h-1x fw-semibold">
                    <?php echo $People['name'];?>
                </h3>
                <div class="text-muted fs-xs">
                    <?php echo $People['department'];?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php } ?>
</div>
<script id="empty-cast" type="text/x-jquery-tmpl">
<div class="col-md-3 col-cast" data-id="${id}">
    <div class="card card-people border-0">
        <div class="position-relative">
            <img src="${image}" class="img-fluid rounded-1" width="<?php echo PEOPLE_X;?>" height="auto">
            <div class="card-overlay d-flex justify-content-center text-center p-2">
                <div class="btn btn-danger btn-sm btn-icon-text rounded-pill confirm remove" data-id="${id}" data-type="cast">
                    <svg width="16" height="18" fill="currentColor">
                        <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#delete';?>"></use>
                    </svg>
                    <span class="d-none d-lg-block ms-2 fs-xs">
                        <?php echo $this->translate('Remove');?></span>
                </div>
            </div>
        </div>
        <div class="card-body p-3">
            <h3 class="fs-sm h-1x fw-semibold">${name}</h3>
            <div class="text-muted fs-xs">${department}</div>
        </div>
    </div>
    {{if api === true}}
    <input type="hidden" name="peoples[${id}][tmdb_id]" value="${id}">
    <input type="hidden" name="peoples[${id}][department]" value="${department}">
    {{/if}}
    {{if api === false}}
    <input type="hidden" name="peoples[${id}][people_id]" value="${id}">
    {{/if}}
</div>
</script>