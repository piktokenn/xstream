<?php require PATH . '/theme/view/common/head.php'; ?>
<?php require PATH . '/theme/view/common/header.php'; ?>
<?php 

    $ProfileRank    = ranked((int)$Listing['xp'],$Rank); 
    $ArrayId        = array_search($ProfileRank['level'], array_column($Rank, 'level'))+1;
    $ArrayId        = ($ArrayId >= count($Rank) ? array_key_last($Rank) : $ArrayId);
    if(isset($ArrayId) AND $ArrayId < count($Rank)){
        $NextRank           = $Rank[$ArrayId];
        if($Listing['xp'] > $NextRank['xp']) {
            $ProgressBar  = 100;
        } else {
            $ProgressBar  = 100 * ((int)$Listing['xp'] - $ProfileRank['xp']) / ($NextRank['xp'] - $ProfileRank['xp']);  
        }
    }
?>
<div class="layout-section">
    <ol class="breadcrumb text-muted mb-3">
        <li class="breadcrumb-item"><a href="<?php echo APP;?>">
                <?php echo $this->translate('Home');?></a></li>
        <li class="breadcrumb-item active" aria-current="page">
            <?php echo $Listing['username'];?>
        </li>
    </ol>
    <div class="row gx-xl-6 gx-lg-5">
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body p-lg-5">
                    <div class="text-center">
                        <?php echo gravatar($Listing['id'],$Listing['username'],$Listing['avatar'],'avatar avatar-2xl rounded-circle text-white mb-3 fs-lg',$Listing['color']);?>
                        <h1 class="mb-0 h4 fw-semibold">
                            <?php echo $Listing['firstname'].' '.$Listing['lastname'];?>
                            <svg width="20" height="20" fill="var(--theme-color)" class="ms-1">
                                <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#badge-check';?>"></use>
                            </svg>
                        </h1>
                        <ul class="list-inline list-separator fs-xs text-muted mb-1">
                            <li class="list-inline-item">
                                <?php echo '@'.$Listing['username'];?>
                            </li>
                            <li class="list-inline-item">
                                <?php echo $this->translate('Joined').' '.dating($Listing['created']);?>
                            </li>
                        </ul>
                    </div>
                    <?php if(isset($Listing['about'])) { ?>
                    <hr class="bg-gray-300 my-4">
                    <h3 class="fs-sm fw-semibold mb-2">
                        <?php echo $this->translate('About');?>
                    </h3>
                    <div class="mb-2 d-block text-gray-600 fs-sm">
                        <?php echo $Listing['about'];?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <?php if(empty($Route->params->tab)) { ?>
            <?php require PATH . '/theme/view/common/profile.overview.php'; ?>
            <?php } elseif(isset($Route->params->tab) AND in_array($Route->params->tab,array('collection','like','history'))) { ?>
            <?php require PATH . '/theme/view/common/profile.'.$Route->params->tab.'.php'; ?>
            <?php } else { ?>
            <?php header('location:'.APP.'/404');?>
            <?php } ?>
        </div>
    </div>
</div>
<?php require PATH . '/theme/view/common/javascript.php'; ?>
<?php require PATH . '/theme/view/common/footer.php'; ?>