<?php

$Collections = $this->db->from(null,'
        SELECT
            collections.*,   
            collections_post.post_id,  
            users.avatar,
            users.color as avatar_color,
            users.username,
            (SELECT 
            COUNT(collections_post.id) 
            FROM collections_post 
            WHERE collection_id = collections.id) AS total
        FROM
            `collections`   
        LEFT JOIN collections_post ON collections.id = collections_post.post_id
        LEFT JOIN users ON users.id = collections.user_id
        WHERE collections.featured = 1
        GROUP BY collections.id
        ORDER BY collections.id DESC
        LIMIT 0,'.(int)$Module['data_limit'])
    ->all(); 
?>
<div class="layout-section">

        <div class="row gx-xl-5">
            <div class="col-xl-auto">
                <div class="w-xl-250 mb-3 text-muted">
                    <h3 class="mb-3 fw-semibold fs-lg"><?php echo $Module['name'];?></h3>
                    <div class="text-muted fs-sm mb-3"><?php echo $this->translate('If you are looking for new series and movies to watch, these lists are for you');?></div>
                </div>
            </div>
            <div class="col-xl">
                <div class="row">
                    <?php foreach ($Collections as $Collection) { ?>
                    <?php 
                    $Posts = $this->db->from(null,'
                                SELECT 
                                posts.id,   
                                posts.self, 
                                posts.image, 
                                posts.type
                                FROM `collections_post` 
                                LEFT JOIN posts ON posts.id = collections_post.post_id  
                                WHERE posts.status = "1" AND collections_post.collection_id = '.$Collection['id'].'
                                ORDER BY collections_post.id DESC
                                LIMIT 0,3')
                                ->all();
                    ?>
                    <div class="col-xxl-4 col-xl-6">
                        <div class="card card-collection">
                            <div class="card-cover">
                                <?php foreach($Posts as $Post) { ?>
                                    <?php echo picture(POST_FOLDER,'thumb-'.$Post['image'],'img-fluid rounded-1',$Post['id'],POST_X.','.POST_Y);?>
                                <?php } ?>
                            </div>
                            <div class="ps-4">
                                <h3 class="title mb-1"><a href="<?php echo collection($Collection['id'],$Collection['self']);?>" class="text-current"><?php echo $Collection['name'];?></a></h3>
                            <ul class="list-inline list-separator fs-xs text-gray-500">
                                <li class="list-inline-item"><a href="<?php echo user($Collection['user_id'],$Collection['username']);?>" class="text-current fw-semibold"><?php echo $Collection['username'];?></a></li>
                    <li class="list-inline-item">
                        <?php echo $Collection['total'].' '.$this->translate('post available');?></li>
                            </ul>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
</div>