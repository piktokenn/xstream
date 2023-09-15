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
    </div>
</div>
<?php if(count($Listings) > 0) { ?>
<div class="table-responsive-lg">
    <table class="table table-theme border-gray-100 align-middle">
        <thead>
            <tr class="text-gray-500 fs-xs">
                <th scope="col" width="70">ID</th>
                <th scope="col">
                    <?php echo $this->translate('Name');?>
                </th>
                <th width="200" scope="col" class="text-end"></th>
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
                <td class="text-end">
                    <div class="dropdown">
                        <button class="btn btn-square btn-sm btn-ghost rounded-circle shadow-none dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg width="16" height="16" stroke="currentColor" stroke-width="1.75" fill="none">
                                <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#more';?>"></use>
                            </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-sm border-0 shadow py-3">
                            <a href="<?php echo APP.'/admin/'.$Config['btn'].'/'.$Listing['id'];?>" class="dropdown-item">
                                <?php echo $this->translate('Edit');?>
                            </a>
                            <a href="<?php echo APP.'/admin/delete/'.$Config['btn'].'/'.$Listing['id'];?>" class="dropdown-item confirm">
                                <?php echo $this->translate('Remove');?>
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php } else { ?>
<div class="py-4 px-xl-5 text-center py-xl-9 py-5">
    <img src="<?php echo ASSETS.'/img/not-found.svg';?>" alt="Not found" width="140" class="img-fluid">
    <div class="text-gray-400 fs-sm mt-4">
        <?php echo $this->translate('This place is so empty, let\'s fill it now');?>
    </div>
</div>
<?php } ?>
<?php require PATH . '/view/common/javascript.php'; ?>
<?php require PATH . '/view/common/footer.php'; ?>