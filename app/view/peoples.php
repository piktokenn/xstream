<?php require PATH . '/view/common/head.php'; ?>
<?php require PATH . '/view/common/header.php'; ?>
<div class="layout-heading">
    <div class="d-flex align-items-center text-nowrap">
        <a href="<?php echo APP.'/admin/'.$Config['btn'];?>" class="btn btn-primary btn-icon-text rounded-pill me-3">
            <svg width="16" height="18" stroke="currentColor" stroke-width="1.75" fill="none">
                <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#add';?>"></use>
            </svg>
            <span class="d-none d-lg-block ms-2 fs-xs"><?php echo $this->translate('Add new');?></span>
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
        <div class="dropdown">
            <button class="btn btn-square btn-ghost rounded-circle shadow-none input-group-text dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                <svg width="18" height="18" stroke="currentColor" stroke-width="1.75" fill="none">
                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#filter';?>"></use>
                </svg>
            </button>
            <div class="dropdown-menu border-0 shadow dropdown-menu-md p-4">
                <form class="flex-fill" method="post">
                    <input type="hidden" name="_ACTION" value="filter">
                    <div class="mb-3">
                        <label class="form-label">
                            <?php echo $this->translate('Department');?></label>
                        <select name="department" class="form-select">
                            <option value="">
                                <?php echo $this->translate('All');?>
                            </option>
                            <option value="Acting" <?php if(isset($_GET['department']) AND $_GET['department']=='Acting' ) echo 'selected' ;?>>
                                <?php echo $this->translate('Acting');?>
                            </option>
                            <option value="Directing" <?php if(isset($_GET['department']) AND $_GET['department']=='Directing' ) echo 'selected' ;?>>
                                <?php echo $this->translate('Directing');?>
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            <?php echo $this->translate('Gender');?></label>
                        <select name="gender" class="form-select">
                            <option value="">
                                <?php echo $this->translate('All');?>
                            </option>
                            <option value="Male" <?php if(isset($_GET['gender']) AND $_GET['gender']=='Male' ) echo 'selected' ;?>>
                                <?php echo $this->translate('Male');?>
                            </option>
                            <option value="Female" <?php if(isset($_GET['gender']) AND $_GET['gender']=='Female' ) echo 'selected' ;?>>
                                <?php echo $this->translate('Female');?>
                            </option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $this->translate('Apply');?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php if(count($Listings) > 0) { ?>
<div class="table-responsive-lg">
    <table class="table table-theme table-lg border-gray-100 align-middle">
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
                <td class="d-flex align-items-center">
                    <a href="<?php echo APP.'/admin/'.$Config['btn'].'/'.$Listing['id'];?>">
                        <?php echo picture(PEOPLE_FOLDER,$Listing['image'],'img-fluid rounded',$Listing['name'],'48,48');?>
                    </a>
                    <div class="ps-3 lh-sm">
                        <a href="<?php echo APP.'/admin/'.$Config['btn'].'/'.$Listing['id'];?>" class="fw-semibold text-current fs-sm d-inline-block">
                            <?php echo $Listing['name'];?></a>
                        <div class="fs-xs text-muted">
                            <?php echo $Listing['department'];?>
                        </div>
                    </div>
                </td>
                <td class="text-end">
                    <div class="dropdown">
                        <button class="btn btn-square shadow-none dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg width="16" height="18" stroke="currentColor" stroke-width="1.75" fill="none">
                                <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#more';?>"></use>
                            </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-sm border-0 shadow py-3">
                            <a href="<?php echo APP.'/admin/'.$Config['btn'].'/'.$Listing['id'];?>" class="dropdown-item">
                                <?php echo $this->translate('Edit');?>
                            </a>
                            <a href="<?php echo APP.'/admin/delete/'.$Config['btn'].'/'.$Listing['id'];?>" class="dropdown-item text-danger confirm">
                                <?php echo $this->translate('Remove');?>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="<?php echo people($Listing['id'],$Listing['self']);?>" class="dropdown-item">
                                <?php echo $this->translate('View');?>
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