<?php require PATH . '/view/common/head.php'; ?>
<?php require PATH . '/view/common/header.php'; ?>
<div class="layout-heading">
    <div class="d-flex align-items-center text-nowrap">
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
<?php if(count($Listings) > 0) { ?>
<div class="table-responsive-lg">
    <table class="table table-theme border-gray-100 align-middle">
        <thead>
            <tr class="text-gray-500 fs-xs">
                <th scope="col" width="70">ID</th>
                <th scope="col">
                    <?php echo $this->translate('Content');?>
                </th>
                <th scope="col">
                    <?php echo $this->translate('User');?>
                </th>
                <th scope="col">
                    <?php echo $this->translate('Type');?>
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
                <td class="d-flex">
                    <a href="<?php echo APP.'/admin/'.$Config['btn'].'/'.$Listing['id'];?>">
                        <?php echo picture(POST_FOLDER,$Listing['image'],'img-fluid rounded-1',$Listing['id'],'50,75');?>
                    </a>
                    <div class="ps-4 lh-sm py-2">
                        <a href="<?php echo APP.'/admin/'.$Config['btn'].'/'.$Listing['id'];?>" class="fw-semibold text-current fs-sm d-inline-block">
                            <?php echo $Listing['post_title'];?></a>
                        <div class="fs-xs text-muted">
                            <?php echo $Listing['title_sub'];?>

                            <?php if(isset($Listing['title_number'])) { ?>
                            <span class="fs-xs text-muted ms-1">
                                <span class="mx-1">-</span>
                                <?php echo $this->translate('Season').' '.$Listing['name'].', '.$this->translate('Episode').' '.$Listing['title_number'];?>
                            </span>
                            <?php } ?>

                        <?php if(isset($Listing['status']) AND $Listing['status'] != 1) { ?>
                        <span class="text-warning fw-semibold fs-xs ms-2">
                            <?php echo $this->translate('Pending');?></span>
                        <?php } ?>
                        </div>
                    </div>
                </td>
                <td>
                    <a href="<?php echo APP.'/admin/'.$Config['btn'].'/'.$Listing['id'];?>" class="fw-semibold text-current fs-sm d-inline-block">
                        <?php echo $Listing['username'];?></a>
                </td>
                <td>
                    <div class="text-muted fs-xs d-inline-block">
                        <?php echo $this->translate($Listing['type']);?></div>
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
<?php echo $Pagination;?>
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