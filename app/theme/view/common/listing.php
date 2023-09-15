<?php require PATH . '/config/array.config.php'; ?>
<?php 
    if(isset($_GET['released'])) {
        $Released = explode(';', $_GET['released']);
    }
    if(isset($_GET['imdb'])) {
        $Imdb = explode(';', $_GET['imdb']);
    }
    if(isset($_GET['genre'])) {
        $Genre = explode(',', $_GET['genre']);
    }
?>
<input type="hidden" name="_PAGE" value="<?php echo $Config['link'];?>">
<div class="layout-filter">
    <h1 class="mb-0 h3">
        <?php echo $Config['page'];?>
    </h1>
    <form method="post" action="<?php echo $Config['link'];?>" class="flex-fill d-flex align-items-center ms-xl-5 ms-md-4" data-form="ajax">
        <input type="hidden" name="_TOKEN" value="<?php echo $Token;?>">
        <input type="hidden" name="_ACTION" value="filter">
        <div class="dropdown-filter">
            <div class="dropdown-toggle <?php if(isset($Genre)) { echo 'selected';}?>" role="button" id="filter-type" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-auto-close="outside">
                <div class="dropdown-value">
                    <?php echo $this->translate('Genre');?>
                    <?php if(isset($Genre)) { echo '<span class="fs-xs">( '.count($Genre).' )</span>';} ?>
                </div>
                <div class="dropdown-btn"></div>
            </div>
            <div class="dropdown-menu dropdown-menu-lg border-0 w-lg-300 p-4" aria-labelledby="filter-type">
                <div class="form-category">
                    <?php foreach($Genres as $Genre) { ?>
                    <label class="form-check">
                        <input type="checkbox" name="genre[]" value="<?php echo $Genre['id'];?>" class="form-check-input" <?php if(isset($_GET['genre']) AND in_array($Genre['id'], explode(',', $_GET['genre']))) echo 'checked=""' ;?>>
                        <span class="form-check-label">
                            <?php echo $Genre['name'];?></span>
                    </label>
                    <?php } ?>
                </div>
                <div class="mt-3 d-grid">
                    <button type="submit" class="btn btn-theme rounded-pill">
                        <?php echo $this->translate('Apply');?></button>
                </div>
            </div>
        </div>
        <div class="dropdown-filter">
            <div class="dropdown-toggle <?php if(isset($Released)) { echo 'selected';}?>" role="button" id="filter-type" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-auto-close="outside">
                <div class="dropdown-value">
                    <?php echo $this->translate('Release date');?>
                    <?php if(isset($Released)) { echo '<span class="fs-xs">( '.$Released[0].' - '.$Released[1].' )</span>';} ?>
                </div>
                <div class="dropdown-btn"></div>
            </div>
            <div class="dropdown-menu dropdown-menu-md border-0 w-300 px-4 pb-3 pt-3" aria-labelledby="filter-type">
                <label class="form-label fs-xs text-muted">
                    <?php echo $this->translate('Release date');?>
                </label>
                <input class="range-slider" type="text" name="released" value="" data-min="1960" data-prettify-enabled="false" data-max="<?php echo date('Y');?>" data-from="<?php if(isset($Released)) { echo $Released[0];} else { echo '1960'; } ?>" data-to="<?php if(isset($Released)) { echo $Released[1];} else { echo date('Y'); } ?>" data-type="double" data-grid="true">
                <div class="mt-3 d-grid">
                    <button type="submit" class="btn btn-theme rounded-pill">
                        <?php echo $this->translate('Apply');?></button>
                </div>
                <div class="text-muted d-flex align-items-center fs-xs mt-2">
                    <a href="<?php echo APP.'/'.$this->translate('movies').'/?released=2022;2022';?>" class="text-current p-2">This year</a>
                    <a href="<?php echo APP.'/'.$this->translate('movies').'/?released=2021;2021';?>" class="text-current p-2">Last year</a>
                </div>
            </div>
        </div>
        <div class="dropdown-filter">
            <div class="dropdown-toggle <?php if(isset($Imdb)) { echo 'selected';}?>" role="button" id="filter-type" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-auto-close="outside">
                <div class="dropdown-value">
                    <?php echo $this->translate('Imdb');?>
                    <?php if(isset($Imdb)) { echo '<span class="fs-xs">( '.$Imdb[0].' - '.$Imdb[1].' )</span>';} ?>
                </div>
                <div class="dropdown-btn"></div>
            </div>
            <div class="dropdown-menu dropdown-menu-md border-0 w-300 px-4 pb-4 pt-3" aria-labelledby="filter-type">
                <label class="form-label fs-xs text-muted">
                    <?php echo $this->translate('Imdb');?>
                </label>
                <input class="range-slider" type="text" name="imdb" value="" data-min="5" data-prettify-enabled="false" data-max="10" data-from="<?php if(isset($Imdb)) { echo $Imdb[0]; } else { echo '5.0'; } ?>" data-to="<?php if(isset($Imdb)) { echo $Imdb[1]; } else { echo '10.0'; } ?>" data-type="double" data-grid="true" data-step="0.1">
                <div class="mt-3 d-grid">
                    <button type="submit" class="btn btn-theme rounded-pill">
                        <?php echo $this->translate('Apply');?></button>
                </div>
            </div>
        </div>
        <div class="dropdown-filter">
            <div class="dropdown-toggle <?php if(isset($_GET['sorting'])) { echo 'selected';}?>" role="button" id="filter-type" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-auto-close="outside">
                <div class="dropdown-value">
                    <?php echo $this->translate('Sorting');?>
                    <?php if(isset($_GET['sorting'])) { echo '<span class="fs-xs">( '.$SortArray[$_GET['sorting']].' )</span>';} ?>
                </div>
                <div class="dropdown-btn"></div>
            </div>
            <div class="dropdown-menu border-0 w-200 px-3 pb-3 pt-3" aria-labelledby="filter-type">
                <div class="form-radio">
                    <?php foreach($SortArray as $key => $value) { ?>
                    <label class="form-check d-flex">
                        <input type="radio" name="sorting" value="<?php echo $key;?>" class="form-check-input" <?php if(isset($_GET['sorting']) AND $_GET['sorting']==$key) echo 'checked=""' ;?>>
                        <span class="form-check-label">
                            <?php echo $value;?></span>
                    </label>
                    <?php } ?>
                </div>
                <div class="mt-3 d-grid">
                    <button type="submit" class="btn btn-theme rounded-pill">
                        <?php echo $this->translate('Apply');?></button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="row <?php if(get($Settings, 'data.header', 'customize') == 'v2') { echo 'row-cols-xxl-'.(int)get($Settings,'data.column','customize'); } else { echo 'row-cols-xxl-'.(int)get($Settings,'data.column','customize'); } ?> row-cols-md-4 row-cols-2" id="content">
    <?php foreach ($Listings as $Listing) { ?>
    <div class="col-lg-2">
        <a href="<?php echo post($Listing['id'],$Listing['self'],$Listing['type']);?>" class="card card-movie">
            <div class="card-overlay">
                <?php echo picture(POST_FOLDER,$Listing['image'],'img-fluid rounded-1',$Listing['title'],POST_X.','.POST_Y);?>
                <?php if(isset($Listing['vote_average'])) { ?>
                <div class="card-imdb">
                    <div>
                        <?php echo $Listing['vote_average'];?>
                    </div>
                    <svg x="0px" y="0px" width="36px" height="36px" viewBox="0 0 36 36">
                        <circle fill="none" stroke-width="1" cx="18" cy="18" r="16" stroke-dasharray="77 100" stroke-dashoffset="0" transform="rotate(-90 18 18)"></circle>
                    </svg>
                </div>
                <?php } ?>
                <?php if(isset($Listing['upcoming']) AND $Listing['upcoming'] == 1) { ?>
                <div class="card-upcoming">
                    <?php echo $this->translate('Upcoming');?>
                </div>
                <?php } ?>
                <div class="card-play"></div>
            </div>
            <div class="card-body">
                <ul class="list-inline list-separator fs-xs text-muted mb-1">
                    <li class="list-inline-item">
                        <?php echo $Listing['name'];?>
                    </li>
                    <li class="list-inline-item">
                        <?php echo dating($Listing['release_date'],true);?>
                    </li>
                </ul>
                <h3 class="title">
                    <?php echo $Listing['title'];?>
                </h3>
                <?php if(get($Settings,'data.subtitle','general') == 1) { ?>
                <h4 class="title_sub">
                    <?php echo $Listing['title_sub'];?>
                </h4>
                <?php } ?>
            </div>
        </a>
    </div>
    <?php } ?>
</div>
<div class="text-center">
    <?php echo $Pagination;?>
</div>