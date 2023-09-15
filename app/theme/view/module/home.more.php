<?php   
$Peoples        = $this->db->from("peoples")->where('featured','1')->limit(0,4)->all();

$Communitys = $this->db->from(null,'
            SELECT 
            discussions.id, 
            discussions.title,  
            discussions.self, 
            discussions.user_id, 
            discussions.created, 
            users.avatar, 
            users.color,
            users.username,
            users.firstname
            FROM `discussions` 
            LEFT JOIN users ON discussions.user_id = users.id  
            WHERE discussions.status = "1"
            ORDER BY discussions.id DESC
            LIMIT 0,4')
            ->all();
?>
<div class="layout-section">
        <div class="row gx-xl-5">
            <div class="col-xxl-5 col-xl-6">
                <div class="mb-3">
                <div class="layout-heading">
                    <div class="layout-title fs-base">
                        <?php echo $this->translate('Featured people');?>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($Peoples as $People) { ?>
                    <div class="col-lg-3 col-6">
                        <a href="<?php echo people($People['id'],$People['self']);?>" class="card card-people">
                            <?php echo picture(PEOPLE_FOLDER,$People['image'],'img-fluid rounded-1',$People['name'],PEOPLE_X.','.PEOPLE_Y);?>
                            <div class="card-body text-center">
                                <h3 class="title fs-xs">
                                    <?php echo $People['name'];?>
                                </h3>
                                <div class="department">
                                    <?php echo $this->translate($People['department']);?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                </div>
                </div>
            </div>
            <div class="col-xxl-4 col-xl-6">
                <div class="mb-3">
                <div class="layout-heading">
                    <div class="layout-title fs-base">
                        <?php echo $this->translate('Community');?>
                    </div>
                    <div class="layout-heading-filter">
                        <a href="<?php echo community();?>" class="fs-sm">
                            <?php echo $this->translate('Newest');?></a>
                        <a href="<?php echo community('popular');?>" class="fs-sm ">
                            <?php echo $this->translate('Most popular');?></a>
                    </div>
                </div>
                <?php foreach ($Communitys as $Community) { ?>
                <div class="py-2">
                    <div class="row">
                        <div class="col-auto">
                            <a href="<?php echo user($Community['user_id'],$Community['username']);?>" class="d-block" data-bs-tooltip="tooltip" data-bs-placement="top" title="<?php echo $Community['firstname'];?> - @<?php echo $Community['username'];?>">
                                <?php echo gravatar($Community['user_id'],$Community['username'],$Community['avatar'],'avatar avatar-lg rounded-circle text-white fs-xs',$Community['color']);?>
                            </a>
                        </div>
                        <div class="col text-gray-600">
                            <h3 class="fs-sm text-heading fw-semibold mb-1 h-1x"><a href="<?php echo thread($Community['id'],$Community['self']);?>" class="text-current">
                                    <?php echo $Community['title'];?></a></h3>
                            <ul class="list-inline list-separator fs-xs text-gray-500">
                                <li class="list-inline-item"><a href="<?php echo user($Community['user_id'],$Community['username']);?>" class="text-current fw-semibold">
                                        <?php echo $Community['username'];?></a></li>
                                <li class="list-inline-item">
                                    <?php echo dating($Community['created']);?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            </div>
            <div class="col-xxl-3 col-xl-12">
                <div class="mb-3">
                <div class="layout-heading">
                    <div class="layout-title fs-base">
                        <?php echo $this->translate('Genre');?>
                    </div>
                </div>
                <div class="card-genres">
                    <?php foreach($HomeGenres as $Genre) { ?>
                    <a href="<?php echo genre($Genre['id'],$Genre['self']);?>" class="fs-xs">
                        <?php echo $Genre['name'];?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>