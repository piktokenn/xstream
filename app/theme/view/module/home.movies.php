<?php  
if(!$ModuleData['sorting']) {
    $OrderBy = 'id DESC';
}else{
    $OrderBy = $ModuleData['sorting'];
}
$Movies = $this->db->from(null,'
            SELECT 
            posts.id, 
            posts.title,  
            posts.title_sub,  
            posts.self, 
            posts.image, 
            posts.type,
            posts.release_date,
            posts.upcoming,
            posts.vote_average,
            genres.name
            FROM `posts` 
            LEFT JOIN posts_genre ON posts_genre.post_id = posts.id  
            LEFT JOIN genres ON genres.id = posts_genre.genre_id  
            WHERE posts.type = "movie" AND posts.status = "1"
            GROUP BY posts.id
            ORDER BY posts.'.$ModuleData['sorting'].'
            LIMIT 0,'.$Module['data_limit'])
            ->all();
?>
<div class="layout-section">
    <div class="layout-heading mb-4">
        <h3 class="layout-title">
            <?php echo $Module['name'];?>
        </h3>
        <div class="layout-heading-filter">
            <a href="<?php echo APP.'/'.$this->translate('movies');?>" class="fs-sm">
                <?php echo $this->translate('Newest');?></a>
            <a href="<?php echo APP.'/'.$this->translate('movies').'?sorting=popular';?>" class="fs-sm ">
                <?php echo $this->translate('Most popular');?></a>
        </div>
    </div>
    <div class="row <?php if(get($Settings, 'data.header', 'customize') == 'v2') { echo 'row-cols-xxl-'.(int)get($Settings,'data.column','customize'); } else { echo 'row-cols-xxl-'.(int)get($Settings,'data.column','customize'); } ?> row-cols-md-4 row-cols-2">
        <?php foreach ($Movies as $Movie) { ?>
        <div class="col-lg-2">
            <a href="<?php echo post($Movie['id'],$Movie['self'],$Movie['type']);?>" class="card card-movie">
                <div class="card-overlay">
                    <?php echo picture(POST_FOLDER,$Movie['image'],'img-fluid rounded-1',$Movie['title'],POST_X.','.POST_Y);?>
                    <?php if(isset($Movie['vote_average'])) { ?>
                    <div class="card-imdb">
                        <span>
                            <?php echo $Movie['vote_average'];?></span>
                        <svg x="0px" y="0px" width="36px" height="36px" viewBox="0 0 36 36">
                            <circle fill="none" stroke-width="1" cx="18" cy="18" r="16" stroke-dasharray="77 100" stroke-dashoffset="0" transform="rotate(-90 18 18)"></circle>
                        </svg>
                    </div>
                    <?php } ?>
                    <?php if(isset($Movie['upcoming']) AND $Movie['upcoming'] == 1) { ?>
                    <div class="card-upcoming">
                        <?php echo $this->translate('Upcoming');?>
                    </div>
                    <?php } ?>
                    <div class="card-play"></div>
                </div>
                <div class="card-body">
                    <ul class="list-inline list-separator fs-xs text-muted mb-1">
                        <li class="list-inline-item">
                            <?php echo $Movie['name'];?>
                        </li>
                        <li class="list-inline-item">
                            <?php echo dating($Movie['release_date'],true);?>
                        </li>
                    </ul>
                    <h3 class="title">
                        <?php echo $Movie['title'];?>
                    </h3>
                    <?php if(get($Settings,'data.subtitle','general') == 1) { ?>
                    <h4 class="title_sub">
                        <?php echo $Movie['title_sub'];?>
                    </h4>
                    <?php } ?>
                </div>
            </a>
        </div>
        <?php } ?>
    </div>
</div>