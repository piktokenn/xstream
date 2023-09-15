<?php  
if(!$ModuleData['sorting']) {
    $OrderBy = 'id DESC';
}else{
    $OrderBy = $ModuleData['sorting'];
}
$Series = $this->db->from(null,'
            SELECT 
            posts.id, 
            posts.title,  
            posts.title_sub,  
            posts.self, 
            posts.image, 
            posts.type,
            posts.release_date,
            posts.vote_average,
            posts.created,
            genres.name
            FROM `posts` 
            LEFT JOIN posts_genre ON posts_genre.post_id = posts.id  
            LEFT JOIN genres ON genres.id = posts_genre.genre_id  
            WHERE posts.type = "serie" AND posts.status = 1
            GROUP BY posts.id
            ORDER BY posts.'.$ModuleData['sorting'].'
            LIMIT 0,'.$Module['data_limit'])
            ->all();
?>
<div class="layout-section">
    <div class="layout-heading">
        <div class="layout-title">
            <?php echo $Module['name'];?>
        </div>
        <div class="layout-heading-filter">
            <a href="<?php echo APP.'/'.$this->translate('series');?>" class="fs-sm">
                <?php echo $this->translate('Newest');?></a>
            <a href="<?php echo APP.'/'.$this->translate('series').'?sorting=popular';?>" class="fs-sm ">
                <?php echo $this->translate('Most popular');?></a>
        </div>
    </div>
    <div class="row <?php if(get($Settings, 'data.header', 'customize') == 'v2') { echo 'row-cols-xxl-'.(int)get($Settings,'data.column','customize'); } else { echo 'row-cols-xxl-'.(int)get($Settings,'data.column','customize'); } ?> row-cols-md-4 row-cols-2">
        <?php foreach ($Series as $Serie) { ?>
        <div class="col-lg-2">
            <a href="<?php echo post($Serie['id'],$Serie['self'],$Serie['type']);?>" class="card card-movie">
                <div class="card-overlay">
                    <?php echo picture(POST_FOLDER,$Serie['image'],'img-fluid rounded-1',$Serie['title'],POST_X.','.POST_Y);?>
                    <?php if(isset($Serie['vote_average'])) { ?>
                    <div class="card-imdb">
                        <span>
                            <?php echo $Serie['vote_average'];?></span>
                        <svg x="0px" y="0px" width="36px" height="36px" viewBox="0 0 36 36">
                            <circle fill="none" stroke-width="1" cx="18" cy="18" r="16" stroke-dasharray="77 100" stroke-dashoffset="0" transform="rotate(-90 18 18)"></circle>
                        </svg>
                    </div>
                    <?php } ?>
                    <div class="card-play"></div>
                </div>
                <div class="card-body">
                    <ul class="list-inline list-separator fs-xs text-muted mb-1">
                        <li class="list-inline-item">
                            <?php echo $Serie['name'];?>
                        </li>
                        <li class="list-inline-item">
                            <?php echo dating($Serie['release_date'],true);?>
                        </li>
                    </ul>
                    <h3 class="title">
                        <?php echo $Serie['title'];?>
                    </h3>
                    <?php if(get($Settings,'data.subtitle','general') == 1) { ?>
                    <h4 class="title_sub">
                        <?php echo $Serie['title_sub'];?>
                    </h4>
                    <?php } ?>
                </div>
            </a>
        </div>
        <?php } ?>
    </div>
</div>