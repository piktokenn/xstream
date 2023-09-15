<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Site title');?></label>
    <input type="text" name="data[<?php echo $key;?>][title]" class="form-control form-control-lg" placeholder="<?php echo $this->translate('Site title');?>" value="<?php echo get($Settings, 'data.title', $key);?>">
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Site description');?></label>
    <textarea name="data[<?php echo $key;?>][description]" class="form-control" placeholder="<?php echo $this->translate('Site description');?>"><?php echo get($Settings, 'data.title', $key);?></textarea>
</div>
<hr class="my-4 bg-gray-200">
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Movies title');?></label>
    <input type="text" name="data[<?php echo $key;?>][movies_title]" class="form-control" placeholder="<?php echo $this->translate('Movies title');?>" value="<?php echo get($Settings, 'data.movies_title', $key);?>">
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Movies description');?></label>
    <textarea name="data[<?php echo $key;?>][movies_description]" class="form-control" rows="3" placeholder="<?php echo $this->translate('Movies description');?>"><?php echo get($Settings, 'data.movies_description', $key);?></textarea>
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Movie detail title');?></label>
    <input type="text" name="data[<?php echo $key;?>][movie_title]" class="form-control" placeholder="<?php echo $this->translate('Movie detail title');?>" value="<?php echo get($Settings, 'data.movie_title', $key);?>">
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Movie detail description');?></label>
    <textarea name="data[<?php echo $key;?>][movie_description]" class="form-control" rows="3" placeholder="<?php echo $this->translate('Movie detail description');?>"><?php echo get($Settings, 'data.movie_description', $key);?></textarea>
</div>
<hr class="my-4 bg-gray-200">
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('TV Shows title');?></label>
    <input type="text" name="data[<?php echo $key;?>][series_title]" class="form-control" placeholder="<?php echo $this->translate('TV Shows title');?>" value="<?php echo get($Settings, 'data.series_title', $key);?>">
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('TV Shows description');?></label>
    <textarea name="data[<?php echo $key;?>][series_description]" class="form-control" rows="3" placeholder="<?php echo $this->translate('TV Shows description');?>"><?php echo get($Settings, 'data.series_description', $key);?></textarea>
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('TV Show detail title');?></label>
    <input type="text" name="data[<?php echo $key;?>][serie_title]" class="form-control" placeholder="<?php echo $this->translate('TV Show detail title');?>" value="<?php echo get($Settings, 'data.serie_title', $key);?>">
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('TV Show detail description');?></label>
    <textarea name="data[<?php echo $key;?>][serie_description]" class="form-control" rows="3" placeholder="<?php echo $this->translate('TV Show detail description');?>"><?php echo get($Settings, 'data.serie_description', $key);?></textarea>
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Episode title');?></label>
    <input type="text" name="data[<?php echo $key;?>][episode_title]" class="form-control" placeholder="<?php echo $this->translate('Episode title');?>" value="<?php echo get($Settings, 'data.episode_title', $key);?>">
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Episode description');?></label>
    <textarea name="data[<?php echo $key;?>][episode_description]" class="form-control" rows="3" placeholder="<?php echo $this->translate('Episode description');?>"><?php echo get($Settings, 'data.episode_description', $key);?></textarea>
</div>
<hr class="my-4 bg-gray-200">
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Category title');?></label>
    <input type="text" name="data[<?php echo $key;?>][category_title]" class="form-control" placeholder="<?php echo $this->translate('Category title');?>" value="<?php echo get($Settings, 'data.category_title', $key);?>">
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Category description');?></label>
    <textarea name="data[<?php echo $key;?>][category_description]" class="form-control" rows="3" placeholder="<?php echo $this->translate('Category description');?>"><?php echo get($Settings, 'data.category_description', $key);?></textarea>
</div>
<hr class="my-4 bg-gray-200">
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Tag title');?></label>
    <input type="text" name="data[<?php echo $key;?>][tag_title]" class="form-control" placeholder="<?php echo $this->translate('Tag title');?>" value="<?php echo get($Settings, 'data.tag_title', $key);?>">
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Tag description');?></label>
    <textarea name="data[<?php echo $key;?>][tag_description]" class="form-control" rows="3" placeholder="<?php echo $this->translate('Tag description');?>"><?php echo get($Settings, 'data.tag_description', $key);?></textarea>
</div>
<hr class="my-4 bg-gray-200">
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Explore title');?></label>
    <input type="text" name="data[<?php echo $key;?>][explore_title]" class="form-control" placeholder="<?php echo $this->translate('Explore title');?>" value="<?php echo get($Settings, 'data.explore_title', $key);?>">
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Explore description');?></label>
    <textarea name="data[<?php echo $key;?>][explore_description]" class="form-control" rows="3" placeholder="<?php echo $this->translate('Explore description');?>"><?php echo get($Settings, 'data.explore_description', $key);?></textarea>
</div>
<hr class="my-4 bg-gray-200">
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Search title');?></label>
    <input type="text" name="data[<?php echo $key;?>][search_title]" class="form-control" placeholder="<?php echo $this->translate('Search title');?>" value="<?php echo get($Settings, 'data.search_title', $key);?>">
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Search description');?></label>
    <textarea name="data[<?php echo $key;?>][search_description]" class="form-control" rows="3" placeholder="<?php echo $this->translate('Search description');?>"><?php echo get($Settings, 'data.search_description', $key);?></textarea>
</div>
<hr class="my-4 bg-gray-200">
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Peoples title');?></label>
    <input type="text" name="data[<?php echo $key;?>][peoples_title]" class="form-control" placeholder="<?php echo $this->translate('Peoples title');?>" value="<?php echo get($Settings, 'data.peoples_title', $key);?>">
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Peoples description');?></label>
    <textarea name="data[<?php echo $key;?>][peoples_description]" class="form-control" rows="3" placeholder="<?php echo $this->translate('Peoples description');?>"><?php echo get($Settings, 'data.peoples_description', $key);?></textarea>
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('People title');?></label>
    <input type="text" name="data[<?php echo $key;?>][people_title]" class="form-control" placeholder="<?php echo $this->translate('People title');?>" value="<?php echo get($Settings, 'data.people_title', $key);?>">
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('People description');?></label>
    <textarea name="data[<?php echo $key;?>][people_description]" class="form-control" rows="3" placeholder="<?php echo $this->translate('People description');?>"><?php echo get($Settings, 'data.people_description', $key);?></textarea>
</div>
<hr class="my-4 bg-gray-200">
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Community title');?></label>
    <input type="text" name="data[<?php echo $key;?>][community_title]" class="form-control" placeholder="<?php echo $this->translate('Community title');?>" value="<?php echo get($Settings, 'data.community_title', $key);?>">
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Community description');?></label>
    <textarea name="data[<?php echo $key;?>][community_description]" class="form-control" rows="3" placeholder="<?php echo $this->translate('Community description');?>"><?php echo get($Settings, 'data.community_description', $key);?></textarea>
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Thread title');?></label>
    <input type="text" name="data[<?php echo $key;?>][thread_title]" class="form-control" placeholder="<?php echo $this->translate('Thread title');?>" value="<?php echo get($Settings, 'data.thread_title', $key);?>">
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Thread description');?></label>
    <textarea name="data[<?php echo $key;?>][thread_description]" class="form-control" rows="3" placeholder="<?php echo $this->translate('Thread description');?>"><?php echo get($Settings, 'data.thread_description', $key);?></textarea>
</div>
<hr class="my-4 bg-gray-200">
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Platforms title');?></label>
    <input type="text" name="data[<?php echo $key;?>][platforms_title]" class="form-control" placeholder="<?php echo $this->translate('Platforms title');?>" value="<?php echo get($Settings, 'data.platforms_title', $key);?>">
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Platforms description');?></label>
    <textarea name="data[<?php echo $key;?>][platforms_description]" class="form-control" rows="3" placeholder="<?php echo $this->translate('Platforms description');?>"><?php echo get($Settings, 'data.platforms_description', $key);?></textarea>
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Platform title');?></label>
    <input type="text" name="data[<?php echo $key;?>][platform_title]" class="form-control" placeholder="<?php echo $this->translate('Platform title');?>" value="<?php echo get($Settings, 'data.platform_title', $key);?>">
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Platform description');?></label>
    <textarea name="data[<?php echo $key;?>][platform_description]" class="form-control" rows="3" placeholder="<?php echo $this->translate('Platform description');?>"><?php echo get($Settings, 'data.platform_description', $key);?></textarea>
</div>
<hr class="my-4 bg-gray-200">
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Profile title');?></label>
    <input type="text" name="data[<?php echo $key;?>][profile_title]" class="form-control" placeholder="<?php echo $this->translate('Profile title');?>" value="<?php echo get($Settings, 'data.profile_title', $key);?>">
</div>
<div class="mb-3">
    <label class="form-label">
        <?php echo $this->translate('Profile description');?></label>
    <textarea name="data[<?php echo $key;?>][profile_description]" class="form-control" rows="3" placeholder="<?php echo $this->translate('Profile description');?>"><?php echo get($Settings, 'data.profile_description', $key);?></textarea>
</div>