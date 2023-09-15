<div class="row gx-xl-5">
    <div class="col-md-auto">
        <div class="w-md-200 w-150px mb-3 d-none d-lg-block mx-auto">
            <?php echo picture(POST_FOLDER,$Listing['image'],'img-fluid rounded-1',$Listing['title'],POST_X.','.POST_Y);?>
        </div>
    </div>
    <div class="col-md">
        <div class="row gx-lg-5">
            <div class="col-lg">
                <ul class="list-inline list-separator fs-xs text-gray-500 mb-1">
                    <?php if(isset($Listing['country_name'])) { ?>
                    <li class="list-inline-item"><a href="" class="text-current fw-semibold">
                            <?php echo $Listing['country_name'];?></a></li>
                    <?php } ?>
                    <li class="list-inline-item">
                        <?php echo dating($Listing['release_date']);?>
                    </li>
                    <?php if(isset($Listing['runtime'])) { ?>
                    <li class="list-inline-item">
                        <?php echo duration($Listing['runtime']);?>
                    </li>
                    <?php } ?>
                </ul>
                <h1 class="h3 fw-semibold mb-1">
                    <?php echo $Listing['title'];?>
                </h1>
                <h2 class="fs-base fw-normal text-muted mb-2">
                    <?php echo $Listing['title_sub'];?>
                </h2>
                <div class="mb-3 d-flex align-items-center mt-2 mt-md-0">
                    <?php if(isset($Listing['trailer'])) { ?>
                    <button class="btn btn-ghost rounded-pill me-2 px-xl-4" data-bs-toggle="modal" data-bs-target="#xl" data-remote="<?php echo APP.'/modal/trailer?link='.$Listing['trailer'];?>">
                        <?php echo $this->translate('Watch trailer');?></button>
                    <?php } ?>
                    <?php if(isset($AuthUser['id'])) { ?>
                    <div class="dropdown">
                        <button class="btn btn-square btn-transparent rounded-circle dropdown-toggle" type="button" id="moreDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg width="16" height="16" fill="currentColor">
                                <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#dot-vertical';?>"></use>
                            </svg>
                        </button>
                        <ul class="dropdown-menu mt-2" aria-labelledby="moreDropdown">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sm" data-remote="<?php echo APP.'/modal/bookmark?id='.$Listing['id'];?>"><?php echo $this->translate('Save bookmark');?></a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#m" data-remote="<?php echo APP.'/modal/share?url='.$Config['url'].'&title='.urlencode($Config['title']);?>"><?php echo $this->translate('Share');?></a></li> 
                            <li class="dropdown-divider bg-gray-300"></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sm" data-remote="<?php echo APP.'/modal/report?id='.$Listing['id'];?>"><?php echo $this->translate('Report');?></a></li>
                        </ul>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-auto">
                <div class="w-100 w-lg-150px mt-2 mt-lg-0">
                    <div class="text-lg-end">
                        <div class="fs-sm">
                            <?php echo hitview($Listing['view']);?>
                        </div>
                        <div class="progress bg-gray-200 mt-2" style="height: 6px;">
                            <div class="progress-bar bg-theme rounded-pill" role="progressbar" style="width: 100%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="mt-3 mb-3">
                            <button class="btn btn-square btn-ghost rounded-circle btn-reaction btn-like <?php if(isset($Vote['reaction']) AND $Vote['reaction'] == 'up') echo 'active';?>" data-id="<?php echo $Listing['id'];?>">
                                <svg width="16" height="16" fill="currentColor">
                                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#like';?>"></use>
                                </svg>
                                <span class="like-count" data-votes="<?php echo (int)$Listing['likes'];?>">
                                    <?php echo (int)$Listing['likes'];?></span>
                            </button>
                            <button class="btn btn-square btn-ghost rounded-circle btn-reaction btn-dislike ms-1 <?php if(isset($Vote['reaction']) AND $Vote['reaction'] == 'down') echo 'active';?>" data-id="<?php echo $Listing['id'];?>">
                                <svg width="16" height="16" fill="currentColor">
                                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#dislike';?>"></use>
                                </svg>
                                <span class="dislike-count" data-votes="<?php echo (int)$Listing['dislikes'];?>">
                                    <?php echo (int)$Listing['dislikes'];?></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fs-xs text-muted">
            <?php echo $this->translate('Category');?>
        </div>
        <div class="card-tag mb-3">
            <?php foreach($Genres as $Genre) { ?>
            <a href="<?php echo genre($Genre['id'],$Genre['self']);?>">
                <?php echo $Genre['name'];?></a>
            <?php } ?>
        </div>
        <?php if(isset($Listing['platform_name'])) { ?>
        <div class="fs-xs text-muted mb-3">
            <div class="mb-2">
                <?php echo $this->translate('Platform');?>
            </div>
            <a href="<?php echo platform($Listing['platform'],$Listing['platform_self']);?>" class="d-inline-block py-1" data-bs-tooltip="tooltip" data-bs-placement="top" title="<?php echo $Listing['platform_name'];?>"><img src="<?php echo UPLOAD.'/'.PLATFORM_FOLDER.'/'.$Listing['platform_image'];?>" height="24"></a>
        </div>
        <?php } ?>
        <?php if(isset($Listing['overview'])) { ?>
        <p class="text-muted fs-sm" data-more="" data-limit="200">
            <?php echo $Listing['overview'];?>
        </p>
        <?php } ?>
        <?php if(isset($Listing['keywords'])) { ?>
        <?php $Keywords = explode(',', $Listing['keywords']); ?>
        <?php if(count($Keywords)>=1 AND strlen($Keywords[0])>0) { ?>
        <div class="card-tags">
            <?php foreach($Keywords as $Keyword) { ?>
            <a href="<?php echo tag(tagger($Keyword));?>" class="">
                <?php echo $Keyword;?></a>
            <?php } ?>
        </div>
        <?php } ?>
        <?php } ?>
    </div>
</div>