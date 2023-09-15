<?php require PATH . '/theme/view/common/head.php'; ?>
<?php require PATH . '/theme/view/common/header.php'; ?>
<div class="layout-section">
    <ol class="breadcrumb d-inline-flex text-muted mb-3">
        <li class="breadcrumb-item"><a href="<?php echo collections();?>">
                <?php echo $this->translate('Collections');?></a></li>
        <li class="breadcrumb-item active" aria-current="page">
            <?php echo $Listing['name'];?>
        </li>
    </ol>
    <?php if(isset($_GET['_ACTION']) AND $_GET['_ACTION'] == 'edit') { ?>
    <form method="post" class="collection-form" data-loader="">
        <?php } ?>
        <div class="layout-section">
            <div class="row mb-4">
                <div class="col-auto">
                    <a href="<?php echo user($Listing['user_id'],$Listing['username']);?>" class="d-block" data-bs-tooltip="tooltip" data-bs-placement="top" title="<?php echo $Listing['firstname'];?> - @<?php echo $Listing['username'];?>">
                        <?php echo gravatar($Listing['user_id'],$Listing['username'],$Listing['avatar'],'avatar avatar-xl rounded-circle text-white fs-xs',$Listing['color']);?>
                    </a>
                </div>
                <div class="col-lg text-gray-600">
                    <h1 class="h4 fw-semibold mb-1">
                        <?php echo $Listing['name'];?>
                    </h1>
                    <ul class="list-inline list-separator fs-xs text-gray-500">
                        <li class="list-inline-item"><a href="<?php echo user($Listing['user_id'],$Listing['username']);?>" class="text-current fw-semibold">
                                <?php echo $Listing['username'];?></a></li>
                        <li class="list-inline-item">
                            <?php echo $Listing['total'].' '.$this->translate('post avaible');?>
                        </li>
                        <?php if(isset($AuthUser['id']) AND $Listing['user_id'] == $AuthUser['id']) { ?>
                        <li class="list-inline-item text-heading">
                            <a href="<?php echo collection($Listing['id'],$Listing['self']).'?_ACTION=edit';?>" class="text-current fw-semibold">
                                <?php echo $this->translate('Edit');?></a>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php if(isset($_GET['_ACTION']) AND $_GET['_ACTION'] == 'edit') { ?>
                    <div class="my-4">
                        <input type="hidden" name="_ACTION" value="save">
                        <input type="hidden" name="_TOKEN" value="<?php echo $Token;?>">
                        <div class="mb-2">
                            <label class="form-label">
                                <?php echo $this->translate('Title');?></label>
                            <input type="text" name="name" class="form-control form-control-lg" placeholder="<?php echo $this->translate('Title');?>" required="true" minlength="3" value="<?php echo $Listing['name'];?>">
                        </div>
                        <div class="mb-2">
                            <button type="submit" class="btn btn-theme py-3 w-lg-300">
                                <?php echo $this->translate('Save changes');?></button>
                        </div>
                        <div class="form-switch">
                            <input class="form-check-input" type="checkbox" id="privacy" name="privacy" value="1" <?php if($Listing['privacy']==1) echo 'checked="true"' ;?>>
                            <label class="form-check-label ms-2 fs-sm" for="privacy">
                                <?php echo $this->translate('Private');?></label>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="row g-3">
                <?php if(count($Posts) > 0) { ?>
                <?php foreach($Posts as $Post) { ?>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-auto">
                            <div class="w-lg-75px">
                                <?php echo picture(POST_FOLDER,$Post['image'],'img-fluid rounded-1',$Post['title'],'100,auto');?>
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="fs-xs text-muted">
                                <?php echo $Post['title_sub'];?>
                            </div>
                            <a href="<?php echo post($Post['id'],$Post['self'],$Post['type']);?>" class="fw-semibold text-current fs-base d-inline-block mb-2">
                                <?php echo $Post['title'];?></a>
                            <div class="fs-xs h-2x text-muted">
                                <?php echo $Post['overview'];?>
                            </div>
                            <?php if(isset($_GET['_ACTION']) AND $_GET['_ACTION'] == 'edit') { ?>
                            <div class="form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="c<?php echo $Post['collection_post_id'];?>" name="collection[]" value="<?php echo $Post['collection_post_id'];?>">
                                <label class="form-check-label ms-2 fs-sm" for="c<?php echo $Post['collection_post_id'];?>">
                                    <?php echo $this->translate('Remove');?></label>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php } ?>
            </div>
        </div>
        <?php if(isset($_GET['_ACTION']) AND $_GET['_ACTION'] == 'edit') { ?>
    </form>
    <?php } ?>
</div>
<!-- section -->
<?php require PATH . '/theme/view/common/javascript.php'; ?>
<?php require PATH . '/theme/view/common/footer.php'; ?>