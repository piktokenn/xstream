<?php require PATH . '/theme/view/common/head.php'; ?>
<?php require PATH . '/theme/view/common/header.php'; ?>
<div class="layout-section">
    <ol class="breadcrumb d-inline-flex text-muted mb-2">
        <li class="breadcrumb-item"><a href="">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">
            <?php echo $this->translate('Request');?>
        </li>
    </ol>
    <?php if(isset($AuthUser['id'])) { ?>
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <form method="post" class="card shadow-none bg-gray-300 mb-4">
                <input type="hidden" name="_TOKEN" value="<?php echo $Token;?>">
                <input type="hidden" name="_ACTION" value="search">
                <div class="py-1 px-3">
                    <div class="row gx-xl-0 align-items-xl-center">
                        <div class="col-lg-3">
                            <select class="form-select border-0 shadow-none bg-gray-300 py-3">
                                <option value="movie"><?php echo $this->translate('Movie');?></option>
                                <option value="tv"><?php echo $this->translate('TV Show');?></option>
                            </select>
                        </div>
                        <div class="col">
                            <input type="search" name="q" class="form-control bg-transparent py-3 border-0 shadow-none" placeholder="Search a title .." value="<?php if(isset($_POST['q'])) echo $_POST['q'];?>">
                        </div>
                        <div class="col-lg-auto">
                            <button type="submit" class="btn btn-square lh-1 shadow-none">
                                <svg width="18" height="18" stroke="currentColor" stroke-width="2" fill="none">
                                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#search';?>"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php if(isset($Listings['results'])) { ?>
    <div class="row row-cols-xl-6">
        <?php foreach ($Listings['results'] as $Listing) { ?>
        <?php $Check = $this->db->from('requests')->where('user_id',$AuthUser['id'])->where('tmdb_id',$Listing['id'])->first(); ?>
        <?php if((isset($Listing['title']) OR isset($Listing['original_name'])) AND isset($Listing['id'])) { ?>
        <div class="col-lg-2">
            <div class="card card-movie">
                <div class="ratio rounded bg-img-cover" style="--bs-aspect-ratio: 150%;background-image:url(<?php echo 'https://image.tmdb.org/t/p/w780'.$Listing['poster_path'];?>);">
                </div>
                <div class="card-body">
                    <h3 class="title">
                        <?php echo ($Listing['media_type'] == 'movie' ? $Listing['original_title'] : $Listing['original_name']);?>
                    </h3>
                    <div class="d-grid mt-2">
                        <?php if(isset($Check['tmdb_id'])) { ?>
                        <button class="btn btn-success btn-sm">
                            <?php echo $this->translate('Ready');?></button>
                        <?php } else { ?>
                        <button class="btn btn-ghost btn-request btn-sm" data-id="<?php echo $Listing['id'];?>" data-type="<?php echo $Listing['media_type'];?>">
                            <?php echo $this->translate('Request');?></button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php } ?>
    </div>
    <?php } ?>
    <?php } else { ?>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="py-lg-5 py-4 text-center">
                <img src="<?php echo THEME.'/img/request.svg';?>" alt="Not found" class="img-fluid mb-5">
                <div class="fs-base w-lg-50 mx-auto text-white">
                    <?php echo $this->translate('Movie and TV series requests are exclusive to members');?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<?php echo ads($Ads,1,'mx-lg-auto py-3 px-3 mb-3');?>
<?php require PATH . '/theme/view/common/javascript.php'; ?>
<?php require PATH . '/theme/view/common/footer.php'; ?>