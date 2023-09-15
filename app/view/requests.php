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
                <div class="dropdown-header fs-xxs text-uppercase ls-wider text-gray-400">
                    <?php echo $this->translate('Sortable');?>
                </div>
                <a class="dropdown-item" href="<?php echo APP.'/admin/'.$Config['nav'].'?sorting=DESC';?>">
                    <?php echo $this->translate('Newest');?></a>
                <a class="dropdown-item" href="<?php echo APP.'/admin/'.$Config['nav'].'?sorting=ASC';?>">
                    <?php echo $this->translate('Oldest');?></a>
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
                <th width="200" scope="col">
                    <?php echo $this->translate('Request');?>
                </th>
                <th width="200" scope="col">
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($Listings as $Listing) { ?>
            <?php  
            $TotalRecord        = $this->db->from(null,'SELECT count(requests.id) as total FROM `requests` WHERE tmdb_id = '.$Listing['tmdb_id'])->total(); 
            ?>
            <tr>
                <td class="fs-xs text-muted">#
                    <?php echo $Listing['id'];?>
                </td>
                <td class="d-flex">
                    <a href="<?php echo 'https://themoviedb.org/'.$Listing['media_type'].'/'.$Listing['tmdb_id'];?>">
                        <img src="<?php echo 'https://image.tmdb.org/t/p/w780'.$Listing['image'];?>" width="50" height="75" class="rounded-1">
                    </a>
                    <div class="ps-4 lh-sm">
                        <a href="<?php echo 'https://themoviedb.org/'.$Listing['media_type'].'/'.$Listing['tmdb_id'];?>" class="fw-semibold text-current fs-sm d-inline-block">
                            <?php echo $Listing['name'];?> </a>
                        <div class="fs-xs text-muted">
                            <?php echo $Listing['media_type'];?>
                        </div>
                    </div>
                </td>
                <td class="fs-sm text-body">
                    <?php echo (int)$TotalRecord;?>
                </td>
                <td class="text-end">
                    
                        <a href="<?php echo APP.'/admin/'.($Listing['media_type'] == 'tv' ? 'serie' : 'movie').'/?tmdb_id='.$Listing['tmdb_id'];?>" target="_blank" class="btn btn-primary btn-sm rounded-pill fs-xs"><?php echo $this->translate('Import');?></a>
                   
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