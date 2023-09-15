<?php require PATH . '/view/common/head.php'; ?>
<?php require PATH . '/view/common/header.php'; ?>
<div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 mb-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center px-3 py-4">
                            <div class="px-3 flex-fill">
                                <div class="text-muted fs-xs text-uppercase fw-bold">
                                    <?php echo $this->translate('Movie');?>
                                </div>
                                <h3 class="fw-bold text-dark my-1">
                                    <?php echo $Total['movies'];?>
                                </h3>
                                <div class="text-muted fs-xs">
                                    <?php echo $this->translate('There are total movies');?>
                                </div>
                            </div>
                            <div class="btn btn-square rounded-circle text-muted">
                                <svg width="36" height="36" fill="currentColor">
                                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#chart';?>"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center px-3 py-4">
                            <div class="px-3 flex-fill">
                                <div class="text-muted fs-xs text-uppercase fw-bold">
                                    <?php echo $this->translate('TV Show');?>
                                </div>
                                <h3 class="fw-bold text-dark my-1">
                                    <?php echo $Total['series'];?>
                                </h3>
                                <div class="text-muted fs-xs">
                                    <?php echo $this->translate('There are total tv shows');?>
                                </div>
                            </div>
                            <div class="btn btn-square rounded-circle text-muted">
                                <svg width="36" height="36" fill="currentColor">
                                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#chart';?>"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center px-3 py-4">
                            <div class="px-3 flex-fill">
                                <div class="text-muted fs-xs text-uppercase fw-bold">User</div>
                                <h3 class="fw-bold my-1">
                                    <?php echo $Total['users'];?>
                                </h3>
                                <div class="text-muted fs-xs">
                                    <?php echo $this->translate('There are total users');?>
                                </div>
                            </div>
                            <div class="btn btn-square rounded-circle text-muted">
                                <svg width="36" height="36" fill="currentColor">
                                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#chart';?>"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 mb-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center px-3 py-4">
                            <div class="px-3 flex-fill">
                                <div class="text-muted fs-xs text-uppercase fw-bold">
                                    <?php echo $this->translate('Comment');?>
                                </div>
                                <h3 class="fw-bold text-dark my-1">
                                    <?php echo $Total['comments'];?>
                                </h3>
                                <div class="text-muted fs-xs">
                                    <?php echo $this->translate('There are total comments');?>
                                </div>
                            </div>
                            <div class="btn btn-square rounded-circle text-muted">
                                <svg width="36" height="36" fill="currentColor">
                                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#chart';?>"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
    <?php if(count($Listings) > 0) { ?>
    <div class="table-responsive-lg">
        <table class="table table-theme table-lg align-middle">
            <thead>
                <tr class="text-gray-500 fs-xs">
                    <th scope="col" width="70">ID</th>
                    <th scope="col">
                        <?php echo $this->translate('Name');?>
                    </th>
                    <th width="200" scope="col">
                        <?php echo $this->translate('View');?>
                    </th>
                    <th width="200" scope="col">
                        <?php echo $this->translate('Imdb');?>
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
                        <a href="<?php echo APP.'/admin/'.$Listing['type'].'/'.$Listing['id'];?>" class="flex-shrink-0">
                            <?php echo picture(POST_FOLDER,$Listing['image'],'img-fluid rounded-1',$Listing['title'],'46,100%');?>
                        </a>
                        <div class="ps-3 lh-sm py-2">
                            <a href="<?php echo APP.'/admin/'.$Listing['type'].'/'.$Listing['id'];?>" class="fw-semibold text-current fs-sm d-inline-block">
                                <?php echo $Listing['title'];?></a>
                            <div class="fs-xs text-muted">
                                <?php echo $Listing['title_sub'];?>
                            </div>
                        </div>
                    </td>
                    <td class="fs-sm text-muted">
                        <?php echo $Listing['view'];?>
                    </td>
                    <td class="fs-sm text-muted">
                        <?php echo $Listing['vote_average'];?>
                    </td>
                    <td class="text-end">
                        <div class="dropdown">
                            <button class="btn btn-square btn-ghost rounded-circle dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg width="16" height="18" stroke="currentColor" stroke-width="1.75" fill="none">
                                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#more';?>"></use>
                                </svg>
                            </button>
                            <div class="dropdown-menu dropdown-menu-sm border-0 shadow py-3">
                                <a href="<?php echo APP.'/admin/'.$Listing['type'].'/'.$Listing['id'];?>" class="dropdown-item">
                                    <?php echo $this->translate('Edit');?>
                                </a>
                                <a href="<?php echo APP.'/admin/delete/'.$Listing['type'].'/'.$Listing['id'];?>" class="dropdown-item text-danger confirm">
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
    <?php } ?>
</div>
<?php require PATH . '/view/common/javascript.php'; ?>
<?php require PATH . '/view/common/main.javascript.php'; ?>
<?php require PATH . '/view/common/footer.php'; ?>