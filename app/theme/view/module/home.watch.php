<?php
if(isset($AuthUser['id'])) { 
$Historys = $this->db->from(null,'
    SELECT
        posts.id, 
        posts.title,  
        posts.title_sub,  
        posts.self, 
        posts.image, 
        posts.cover, 
        posts.type,
        posts.upcoming,
        posts.release_date,
        posts.vote_average
    FROM
        `posts_log`  
    LEFT JOIN posts ON posts.id = posts_log.post_id
    WHERE posts_log.user_id = '.$AuthUser['id'].'
    GROUP BY posts_log.post_id
    ORDER BY posts_log.id DESC
    LIMIT 0,'.$Module['data_limit'])
->all(); 
if(count($Historys) > 0) { 
?>
<div class="layout-section">
    <div class="layout-heading">
        <div class="layout-title">
            <?php echo $AuthUser['firstname'];?>,
            <?php echo $this->translate('continue watched');?>
        </div>
    </div>
    <div class="row <?php if(get($Settings, 'data.header', 'customize') == 'v2') { echo 'row-cols-xxl-'.(int)get($Settings,'data.column','customize'); } else { echo 'row-cols-xxl-'.(int)get($Settings,'data.column','customize'); } ?> row-cols-md-4 row-cols-2">
        <?php foreach ($Historys as $History) { ?>
        <div class="col-lg-2">
            <a href="<?php echo post($History['id'],$History['self'],$History['type']);?>" class="card card-movie">
                <div class="card-overlay">
                    <?php echo picture(POST_FOLDER,'thumb-'.$History['cover'],'img-fluid rounded-1',$History['title'],POST_COVER_THUMB_X.','.POST_COVER_THUMB_Y);?>
                    <div class="card-play"></div>
                </div>
                <div class="card-body">
                    <h3 class="title">
                        <?php echo $History['title'];?>
                    </h3>
                    <?php if(get($Settings,'data.subtitle','general') == 1) { ?>
                    <h4 class="title_sub">
                        <?php echo $History['title_sub'];?>
                    </h4>
                    <?php } ?>
                </div>
            </a>
        </div>
        <?php } ?>
    </div>
</div>
<?php } ?>
<?php } ?>