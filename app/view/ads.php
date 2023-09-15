<?php require PATH . '/view/common/head.php'; ?>
<?php require PATH . '/view/common/header.php'; ?>
<div class="layout-heading">
    <div class="d-flex align-items-center text-nowrap">
        <a href="<?php echo APP.'/admin/'.$Config['btn'];?>" class="btn btn-primary btn-icon-text rounded-pill me-3">
            <svg width="16" height="18" stroke="currentColor" stroke-width="1.75" fill="none">
                <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#add';?>"></use>
            </svg>
            <span class="d-none d-lg-block ms-2 fs-xs">
                <?php echo $this->translate('Add new');?></span>
        </a>
        <div class="dropdown">
            <button class="btn btn-square btn-ghost rounded-circle shadow-none input-group-text d-none d-lg-block dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" id="filter-sorting" aria-expanded="false">
                <svg width="18" height="18" stroke="currentColor" stroke-width="1.75" fill="none">
                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#more';?>"></use>
                </svg>
            </button>
            <div class="dropdown-menu dropdown-menu-sm fs-sm border-0 shadow py-3" aria-labelledby="filter-sorting">
                <div class="dropdown-header fs-xxs text-uppercase ls-wider text-gray-400"><?php echo $this->translate('Sortable');?></div>
                <a class="dropdown-item" href="<?php echo APP.'/admin/'.$Config['nav'].'?sorting=DESC';?>"><?php echo $this->translate('Newest');?></a>
                <a class="dropdown-item" href="<?php echo APP.'/admin/'.$Config['nav'].'?sorting=ASC';?>"><?php echo $this->translate('Oldest');?></a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <?php if(count($Listings) > 0) { ?>
        <div class="table-responsive-lg">
            <table class="table table-theme table-lg border-gray-100 align-middle">
                <thead>
                    <tr class="text-gray-500 fs-xs">
                        <th scope="col" width="70">ID</th>
                        <th scope="col">
                            <?php echo $this->translate('Name');?>
                        </th>
                        <th width="200" scope="col"><?php echo $this->translate('Status');?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($Listings as $Listing) { ?>
                    <tr>
                        <td class="fs-xs text-muted">#
                            <?php echo $Listing['id'];?>
                        </td>
                        <td>
                            <a href="<?php echo APP.'/admin/'.$Config['btn'].'/'.$Listing['id'];?>" class="fw-semibold text-current fs-sm d-inline-block">
                                <?php echo $Listing['name'];?></a>
                        </td>
                        <td>
                            <?php if($Listing['status'] == '1') { ?>
                                <span class="text-success fs-xs fw-semibold"><?php echo $this->translate('Active');?></span>
                            <?php } else { ?>
                                <span class="text-warning fs-xs fw-semibold"><?php echo $this->translate('Disable');?></span>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if(isset($Ads['name'])) { ?>
    <div class="col-md-4">
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="_ACTION" value="save">
            <input type="hidden" name="_TOKEN" value="<?php echo $Token?>">
            <div class="py-4">
                <div class="mb-3">
                    <label class="form-label">Reklam</label>
                    <div class="text-body fs-sm fw-semibold">
                        <?php echo $Ads['name'];?>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipi</label>
                    <select name="type" class="form-select">
                        <option value="code" <?php if($Ads['type'] == 'code') echo 'selected';?>>Kod</option>
                        <option value="image" <?php if($Ads['type'] == 'image') echo 'selected';?>>Görsel</option>
                    </select>
                </div>
                <div class="d-none" data-type="image">
                    <div class="mb-3">
                        <label class="form-label">Görsel</label>
                        <input class="form-control" name="image" type="file" id="image">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link</label>
                        <input type="text" name="link" value="<?php echo isset($Data['link']) ? $Data['link'] : (isset($_POST['link']) ? $_POST['link'] : null);?>" class="form-control" placeholder="Link">
                    </div>
                </div>
                <div class="mb-3 d-none" data-type="code">
                    <label class="form-label">Kod</label>
                    <textarea name="ads_code" class="form-control" rows="4"><?php echo isset($Ads['ads_code']) ? $Ads['ads_code'] : (isset($_POST['link']) ? $_POST['link'] : null);?></textarea>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary py-3">Değişiklikleri kaydet</button>
                </div>
                <div class="mb-3">
                    <label class="form-label text-gray-400 fs-xs"><?php echo $this->translate('Advanced');?></label>
                    <div class="form-switch mb-1">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" <?php if(isset($Ads['status']) AND $Ads['status']==1) echo 'checked=""' ;?>>
                        <label class="form-check-label ms-2" for="status"><?php echo $this->translate('Publish');?></label>
                    </div>
                    <div class="form-switch mb-1">
                        <input class="form-check-input" type="checkbox" id="display_user" name="display_user" value="1" <?php if(isset($Ads['display_user']) AND $Ads['display_user']==1) echo 'checked=""' ;?>>
                        <label class="form-check-label ms-2" for="display_user"><?php echo $this->translate('Show to members');?></label>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php } ?>
</div>
<?php } else { ?>
<div class="py-4 px-xl-5 text-center py-xl-9 py-5">
    <img src="<?php echo ASSETS.'/img/not-found.svg';?>" alt="Not found" width="140" class="img-fluid">
    <div class="text-gray-400 fs-sm mt-4">
        Burası çok boş, hadi biraz dolduralım
    </div>
</div>
<?php } ?>
<?php require PATH . '/view/common/javascript.php'; ?>
<script type="text/javascript">
(function($) {
    'use strict';
    $(document).on('change', '[name="type"]', function() {
        var id = $(this).val();
        if (id == 'image') {
            $('[data-type="image"]').removeClass('d-none');
            $('[data-type="code"]').addClass('d-none');
        } else {
            $('[data-type="code"]').removeClass('d-none');
            $('[data-type="image"]').addClass('d-none');
        }
    });
    $('[name="type"]').trigger('change');
})(jQuery);
</script>
<?php require PATH . '/view/common/footer.php'; ?>