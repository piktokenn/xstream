
<form method="post" class="form">
    <input type="hidden" name="_ACTION" value="filter">
    <div class="filter-toolbar">
        <?php if($FilterType == 1) { ?>
        <div class="filter-item" id="type">
            <label>
                <?php echo $this->translate('Type');?></label>
            <div class="filter-item-content dropdown-toggle" role="button" id="filter-type" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <input type="hidden" name="type" value="">
                <div class="filter-value"></div>
                <div class="dropdown-btn"></div>
            </div>
            <div class="dropdown-menu" aria-labelledby="filter-type">
                <li value="" <?php if(!$Filter['type']) echo 'class="selected"' ;?>>
                    <?php echo $this->translate('All');?>
                </li>
                <li value="movie" <?php if($Filter['type']=='movie' ) echo 'class="selected"' ;?>>
                    <?php echo $this->translate('Movie');?>
                </li>
                <li value="serie" <?php if($Filter['type']=='serie' ) echo 'class="selected"' ;?>>
                    <?php echo $this->translate('Serie');?>
                </li>
            </div>
        </div>
        <?php } ?>
        <div class="filter-item" id="category">
            <label>
                <?php echo $this->translate('Category');?></label>
            <div class="filter-item-content dropdown-toggle" role="button" id="filter-category" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <input type="hidden" name="category" value="">
                <div class="filter-value"></div>
                <div class="dropdown-btn"></div>
            </div>
            <div class="dropdown-menu dropdown-2x" aria-labelledby="filter-category">
                <li value="" <?php if(!$Filter['category']) echo 'class="selected"' ;?>>
                    <?php echo $this->translate('All');?>
                </li>
                <?php foreach ($Categories as $Category) { ?>
                <li value="<?php echo $Category['id'];?>" <?php if($Category['id']==$Filter['category'] || $Category['id']==$SelectCategory['id']) echo 'class="selected"' ;?>>
                    <?php echo $Category['name'];?>
                </li>
                <?php } ?>
            </div>
        </div>
        <div class="filter-item" id="imdb">
            <label>
                <?php echo $this->translate('Imdb');?></label>
            <div class="filter-item-content dropdown-toggle" role="button" id="filter-imdb" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <input type="hidden" name="imdb" value="">
                <div class="filter-value"></div>
                <div class="dropdown-btn"></div>
            </div>
            <div class="dropdown-menu" aria-labelledby="filter-imdb">
                <li value="" <?php if(!$Filter['imdb']) echo 'class="selected"' ;?>>
                    <?php echo $this->translate('Imdb');?>
                </li>
                <?php for ($i=4; $i <= 9; $i++) { ?>
                <li value="<?php echo $i;?>" <?php if($i==$Filter['imdb']) echo 'class="selected"' ;?>>
                    <?php echo $i.' '.$this->translate('and over');?>
                </li>
                <?php } ?>
            </div>
        </div>
        <div class="filter-item" id="quality">
            <label>
                <?php echo $this->translate('Quality');?></label>
            <div class="filter-item-content dropdown-toggle" role="button" id="filter-quality" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <input type="hidden" name="quality" value="">
                <div class="filter-value"></div>
                <div class="dropdown-btn"></div>
            </div>
            <div class="dropdown-menu" aria-labelledby="filter-quality">
                <li value="" <?php if(!$Filter['quality']) echo 'class="selected"' ;?>>
                    <?php echo $this->translate('Quality');?>
                </li>
                <?php foreach ($Qualities as $Quality) { ?>
                <li value="<?php echo $Quality;?>" <?php if($Quality==$Filter['quality']) echo 'class="selected"' ;?>>
                    <?php echo $Quality;?>
                </li>
                <?php } ?>
            </div>
        </div>
        <div class="filter-item" id="year">
            <label>
                <?php echo $this->translate('Released');?></label>
            <div class="filter-item-content dropdown-toggle" role="button" id="filter-released" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <input type="hidden" name="released" value="">
                <div class="filter-value"></div>
                <div class="dropdown-btn"></div>
            </div>
            <div class="dropdown-menu" aria-labelledby="filter-released">
                <li value="" <?php if(!$Filter['released']) echo 'class="selected"' ;?>>
                    <?php echo $this->translate('All');?>
                </li>
                <li value="2010-2020" <?php if('2010-'.date('Y')==$Filter['released']) echo 'class="selected"' ;?>>2010 -
                    <?php echo date('Y');?>
                </li>
                <li value="2000-2009" <?php if('2000-2009'==$Filter['released']) echo 'class="selected"' ;?>>2000 - 2009</li>
                <li value="1990-1999" <?php if('1990-1999'==$Filter['released']) echo 'class="selected"' ;?>>1990 - 1999</li>
                <li value="1980-1989" <?php if('1980-1989'==$Filter['released']) echo 'class="selected"' ;?>>1980 - 1989</li>
            </div>
        </div>
        <div class="filter-item" id="sorting">
            <label>
                <?php echo $this->translate('Sorting');?></label>
            <div class="filter-item-content dropdown-toggle" role="button" id="filter-sorting" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <input type="hidden" name="sorting" value="">
                <div class="filter-value"></div>
                <div class="dropdown-btn"></div>
            </div>
            <div class="dropdown-menu" aria-labelledby="filter-sorting">
                <li value="newest" <?php if('newest'==$Filter['sorting'] || !$Filter['sorting']) echo 'class="selected"' ;?>>
                    <?php echo $this->translate('Newest');?>
                </li>
                <li value="popular" <?php if('popular'==$Filter['sorting']) echo 'class="selected"' ;?>>
                    <?php echo $this->translate('Popular');?>
                </li>
                <li value="released" <?php if('featured'==$Filter['sorting']) echo 'class="selected"' ;?>>
                    <?php echo $this->translate('Featured');?>
                </li>
                <li value="released" <?php if('released'==$Filter['sorting']) echo 'class="selected"' ;?>>
                    <?php echo $this->translate('Released');?>
                </li>
                <li value="imdb" <?php if('imdb'==$Filter['sorting']) echo 'class="selected"' ;?>>
                    <?php echo $this->translate('Imdb');?>
                </li>
            </div>
        </div>
        <button type="submit" class="btn btn-theme btn-apply">
            <?php echo $this->translate('Apply');?></button>
    </div>
</form>