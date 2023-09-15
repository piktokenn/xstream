<?php require PATH . '/view/common/head.php'; ?>
<?php require PATH . '/view/common/header.php'; ?>
<div class="container-fluid">
    <div class="card card-append mt-2 mb-3">
        <div class="card-body p-2 pe-3">
            <form method="post">
                <input type="hidden" name="_ACTION" value="filter">
                <input type="hidden" name="_TOKEN" value="<?php echo $Token?>">
                <div class="row gx-0 align-items-center">
                    <div class="col-lg-auto">
                        <div class="w-lg-200">
                            <select name="type" class="form-select border-0 shadow-none">
                                <option value="movie" <?php if(isset($Filter['type']) AND $Filter['type']=='movie' ) echo 'selected' ;?>>
                                    <?php echo $this->translate('Movie');?>
                                </option>
                                <option value="tv" <?php if(isset($Filter['type']) AND $Filter['type']=='tv' ) echo 'selected' ;?>>
                                    <?php echo $this->translate('TV Show');?>
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg">
                        <input type="text" name="" class="form-control border-0 shadow-none" placeholder="Search ..">
                    </div>
                    <div class="col-lg-auto">
                        <div class="w-lg-200">
                            <select name="sort" class="form-select border-0 shadow-none">
                                <option value="popularity.desc" <?php if(isset($Filter['sort']) AND $Filter['sort']=='popularity.desc' ) echo 'selected' ;?>>
                                    <?php echo $this->translate('Most popular');?>
                                </option>
                                <option value="release_date.desc" <?php if(isset($Filter['sort']) AND $Filter['sort']=='release_date.desc' ) echo 'selected' ;?>>
                                    <?php echo $this->translate('Newest');?>
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-auto">
                        <button type="submit" class="btn btn-ghost btn-square rounded-circle">
                            <svg width="18" height="18" stroke="currentColor" stroke-width="2" fill="none">
                                <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#search';?>"></use>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php if(isset($Listings) AND count($Listings) > 0) { ?>
    <div class="table-responsive-lg">
        <table class="table table-theme table-lg border-gray-100 align-middle">
            <thead>
                <tr class="text-gray-500 fs-xs">
                    <th scope="col" width="140">ThemovieDB ID</th>
                    <th scope="col">
                        <?php echo $this->translate('Name');?>
                    </th>
                    <th width="200" scope="col" class="text-end"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($Listings as $Listing) { ?>
                <?php 
                    $Check = $this->db->from('posts')->where('tmdb_id',$Listing['id'])->first(); 
                    if(empty($Check['id'])) { 
                ?>
                <tr>
                    <td class="fs-xs text-muted">#
                        <?php echo $Listing['id'];?>
                    </td>
                    <td class="d-flex">
                        <a href="<?php echo $Listing['link'];?>">
                            <div class="w-lg-50px">
                                <img src="<?php echo $Listing['image'];?>" class="img-fluid rounded-1">
                            </div>
                        </a>
                        <div class="ps-4 lh-sm py-2">
                            <div class="fs-xs text-muted">
                                <?php echo $Listing['original_title'];?>
                            </div>
                            <a href="<?php echo $Listing['link'];?>" class="fw-semibold text-current fs-base mb-1 d-inline-block">
                                <?php echo $Listing['title'];?></a>
                            <div class="fs-xs text-muted">
                                <?php echo $Listing['link'];?>
                            </div>
                        </div>
                    </td>
                    <td class="text-end">
                        <a href="<?php echo APP.'/admin/'.($Listing['type'] == 'tv' ? 'serie' : 'movie').'?tmdb_id='.$Listing['id'];?>" target="_blank" class="btn btn-ghost rounded-pill fs-xs btn-sm d-inline-flex align-items-center">
                            <svg width="20" height="20" fill="currentColor">
                                <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#tool';?>"></use>
                            </svg>
                            <span class="ms-2">Import</span>
                        </a>
                        <a class="btn btn-ghost rounded-pill fs-xs btn-sm">View</a>
                    </td>
                </tr>
                <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php echo $Pagination;?>
    <?php } ?>
</div>
<?php require PATH . '/view/common/javascript.php'; ?>
<?php require PATH . '/view/common/footer.php'; ?>