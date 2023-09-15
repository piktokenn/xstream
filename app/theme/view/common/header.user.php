
            <ul class="navbar-nav mb-2 mb-lg-0 fw-semibold flex-row align-items-lg-center ms-xl-auto">
                <?php if(isset($AuthUser['id'])) { ?>
                <?php 
                $ProfileRank    = ranked((int)$AuthUser['xp'],$Rank); 
                $ArrayId        = array_search($ProfileRank['level'], array_column($Rank, 'level'))+1;
                $ArrayId        = ($ArrayId >= count($Rank) ? array_key_last($Rank) : $ArrayId);
                if(isset($ArrayId) AND $ArrayId < count($Rank)){
                    $NextRank           = $Rank[$ArrayId];
                    if($AuthUser['xp'] > $NextRank['xp']) {
                        $HeaderProgressBar  = 100;
                    } else {
                        $HeaderProgressBar  = 100 * ((int)$AuthUser['xp'] - $ProfileRank['xp']) / ($NextRank['xp'] - $ProfileRank['xp']);  
                    }
                }
                ?>
                <?php 
                $TotalNotification  = $this->db->from(null,'
                    SELECT count(notifications.id) as total FROM `notifications` WHERE user_id = '.$AuthUser['id'].' AND status = 2'
                )->total();
                ?>
                <li class="nav-item dropdown" data-notify="">
                    <a href="#" class="nav-link dropdown-toggle" href="#" id="notifyDropdown" data-bs-type="ajax" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" data-remote="<?php echo APP.'/modal/notifications';?>">
                        <div class="position-relative">
                            <svg width="18" height="18" stroke="currentColor" stroke-width="1.75" fill="none">
                                <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#bell';?>"></use>
                            </svg>
                            <span class="notify-badge <?php if($TotalNotification == 0) { echo 'd-none';} ?>"></span>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end w-lg-400 mt-3 border-0 rounded-3 p-4" aria-labelledby="notifyDropdown">
                        <?php require PATH . '/theme/view/common/header.notification.php'; ?>
                    </div>
                </li>
                <li class="nav-item dropdown ms-lg-0 ms-3">
                    <a class="nav-link dropdown-toggle d-flex align-items-center py-0" role="button" id="Profile" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="position-relative">
                            <?php echo gravatar($AuthUser['id'],$AuthUser['username'],$AuthUser['avatar'],'avatar rounded-circle text-white fs-xs',$AuthUser['color']);?>
                        </div>
                        <div class="ps-3 lh-xs d-block d-lg-none">
                        <div class="text-muted fs-xs"><?php echo $this->translate('Hello');?>,</div>
                        <div class="fs-xs fw-semibold"><?php echo $AuthUser['firstname'];?></div>
                    </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-md border-0 mt-3 py-4 px-3 rounded-3" aria-labelledby="Profile">
                        <div class="px-3">
                            <div class="row align-items-center mb-3">
                                <div class="col-8">
                                    <div class="fs-xs text-heading fw-semibold">
                                        <?php echo $ProfileRank['name'];?>
                                    </div>
                                    <div class="fs-xxs text-muted fw-bold">
                                        <?php echo (int)$AuthUser['xp'].' XP';?>
                                    </div>
                                    <div class="progress mt-2 bg-gray-300" style="height: 6px;">
                                        <div class="progress-bar bg-theme rounded-pill" role="progressbar" style="width: <?php echo $HeaderProgressBar ?>%" aria-valuenow="<?php echo $HeaderProgressBar ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-3 ms-auto">
                                    <img src="<?php echo LOCAL.'/rank/'.$ProfileRank['level'].'.svg';?>" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <?php if($AuthUser['account_type'] == 'admin') { ?>
                        <div class="px-1 my-3 d-grid">
                            <a class="btn btn-theme fs-xs rounded-pill" href="<?php echo APP.'/admin';?>" target="_blank">
                                <?php echo $this->translate('Admin panel');?>
                            </a>
                        </div>
                        <?php } ?>
                        <a class="dropdown-item fs-sm" href="<?php echo user($AuthUser['id'],$AuthUser['username']);?>">
                            <?php echo $this->translate('Profile');?>
                        </a>
                        <a class="dropdown-item fs-sm" href="<?php echo user($AuthUser['id'],$AuthUser['username']).'/history';?>">
                            <?php echo $this->translate('Watch history');?>
                        </a>
                        <a class="dropdown-item fs-sm" href="<?php echo user($AuthUser['id'],$AuthUser['username']).'/like';?>">
                            <?php echo $this->translate('Likes');?>
                        </a>
                        <a class="dropdown-item fs-sm" href="<?php echo user($AuthUser['id'],$AuthUser['username']).'/collection';?>">
                            <?php echo $this->translate('Collections');?>
                        </a>
                        <div class="dropdown-item fs-xs text-muted mt-3"></div>
                        <a class="dropdown-item fs-sm" href="<?php echo APP.'/dashboard/settings';?>">
                            <?php echo $this->translate('Settings');?>
                        </a>
                        <a class="dropdown-item fs-sm" href="<?php echo APP.'/logout';?>">
                            <?php echo $this->translate('Logout');?>
                        </a>
                    </div>
                </li>
                <?php } else { ?>
                <li class="nav-item">
                    <a href="<?php echo APP.'/'.$this->translate('login');?>" class="nav-link fs-sm fw-normal">
                        <?php echo $this->translate('Login');?></a>
                </li>
                <li class="nav-item ms-lg-0 ms-3">
                    <a href="<?php echo APP.'/'.$this->translate('register');?>" class="nav-link fs-sm fw-normal">
                        <?php echo $this->translate('Sign up');?></a>
                </li>
                <?php } ?>
            </ul>