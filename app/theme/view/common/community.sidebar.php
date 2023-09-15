<div class="w-xl-300">
    <?php echo ads($Ads,2,'mb-3');?>
    <div class="mb-3 d-grid">
        <?php if(isset($AuthUser['id'])) { ?>
        <button type="button" class="btn btn-theme py-3" data-bs-toggle="modal" data-bs-target="#m" data-remote="<?php echo APP.'/modal/thread';?>">
            <?php echo $this->translate('Open thread');?></button>
        <?php } else { ?>
        <a href="<?php echo APP.'/'.$this->translate('login');?>" class="btn btn-theme py-3">
            <?php echo $this->translate('Open thread');?></a>
        <?php } ?>
    </div>
    <div class="card bg-gray-200 mb-3">
        <div class="card-body">
            <h3 class="fw-semibold fs-sm mb-3">
                <?php echo $this->translate('Leaderboard');?>
            </h3>
            <?php $i = 1 ;?>
            <div class="leaderboard">
                <?php foreach($Users as $User) { ?>
                <?php $Ranked    = ranked((int)$User['xp'],$Rank); ?>
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <a href="<?php echo user($User['id'],$User['username']);?>" class="d-block avatar" data-bs-tooltip="tooltip" data-bs-placement="top" title="<?php echo $User['firstname'];?> - @<?php echo $User['username'];?>">
                            <?php echo gravatar($User['id'],$User['username'],$User['avatar'],'avatar-body rounded-circle text-white fs-xs',$User['color']);?>
                            <span class="avatar-badge">
                                <?php echo $i;?></span>
                        </a>
                    </div>
                    <div class="col text-gray-700 lh-sm">
                        <div class="text-uppercase text-muted fw-bold fs-xxs">
                            <?php echo $Ranked['name'];?>
                        </div>
                        <a href="<?php echo user($User['id'],$User['username']);?>" class="text-current fs-xs fw-semibold">
                            <?php echo $User['username'];?></a>
                    </div>
                    <div class="col-auto">
                        <div class="fs-xxs fw-bold text-theme">
                            <?php echo (int)$User['xp'].' XP';?>
                        </div>
                    </div>
                </div>
                <?php $i++; } ?>
            </div>
        </div>
    </div>
</div>