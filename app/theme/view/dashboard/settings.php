<?php require PATH . '/theme/view/common/head.php'; ?>
<?php require PATH . '/theme/view/common/header.php'; ?>
<div class="layout-section pt-3">
    <div class="container">
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="_ACTION" value="save">
            <input type="hidden" name="_TOKEN" value="<?php echo $Token?>">
            <div class="row gx-xl-5 h-100 justify-content-center">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="firstname" class="form-label">
                                    <?php echo $this->translate('Firstname');?></label>
                                <input type="text" name="firstname" placeholder="<?php echo $this->translate('Firstname');?>" class="form-control" id="firstname" required="true" minlength="3" value="<?php echo isset($AuthUser['firstname']) ? $AuthUser['firstname'] : null;?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="lastname" class="form-label">
                                    <?php echo $this->translate('Lastname');?></label>
                                <input type="text" name="lastname" placeholder="<?php echo $this->translate('Lastname');?>" class="form-control" id="lastname" required="true" minlength="3" value="<?php echo isset($AuthUser['lastname']) ? $AuthUser['lastname'] : null;?>">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <?php echo $this->translate('Email');?></label>
                        <input type="email" name="email" placeholder="<?php echo $this->translate('Email');?>" class="form-control" id="email" required="true" value="<?php echo isset($AuthUser['email']) ? $AuthUser['email'] : null;?>">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">
                            <?php echo $this->translate('Username');?></label>
                        <input type="text" name="username" placeholder="<?php echo $this->translate('Username');?>" class="form-control" id="username" required="true" value="<?php echo isset($AuthUser['username']) ? $AuthUser['username'] : null;?>">
                    </div>
                    <div class="mb-3">
                        <label for="about" class="form-label">
                            <?php echo $this->translate('About');?></label>
                        <textarea type="text" name="about" placeholder="<?php echo $this->translate('About');?>" class="form-control" id="about" minlength="3" rows="3"><?php echo isset($AuthUser['about']) ? $AuthUser['about'] : null;?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            <?php echo $this->translate('Gender');?></label>
                        <select name="gender" class="form-select">
                            <option value="">
                                <?php echo $this->translate('Choose');?>
                            </option>
                            <option value="Male" <?php if(isset($AuthUser['gender']) AND $AuthUser['gender']=='Male' ) echo 'selected' ;?>>
                                <?php echo $this->translate('Male');?>
                            </option>
                            <option value="Female" <?php if(isset($AuthUser['gender']) AND $AuthUser['gender']=='Female' ) echo 'selected' ;?>>
                                <?php echo $this->translate('Female');?>
                            </option>
                        </select>
                    </div>
                    <hr class="my-3">
                    <div class="mb-2">
                        <label for="password" class="form-label">
                            <?php echo $this->translate('New Password');?></label>
                        <input type="text" name="newpassword" placeholder="<?php echo $this->translate('New Password');?>" class="form-control" id="password" minlength="3" value="">
                        <div class="py-2 text-muted fs-xs">**
                            <?php echo $this->translate('You can use this field if you want to change your password');?>..</div>
                    </div>
                </div>
                <div class="col-xl-auto">
                    <div class="h-100 w-xl-300">
                        <div class="mb-3">
                            <div class="ratio-select ratio rounded position-relative input-cover" style="--bs-aspect-ratio: 100%;background-image: url(<?php if(isset($AuthUser['avatar'])) echo UPLOAD.'/'.AVATAR_FOLDER.'/'.$AuthUser['avatar']; ?>">
                                <div class="ratio-preview text-muted d-flex <?php if($AuthUser['avatar']) echo 'd-none';?> align-items-center justify-content-center">
                                    <div class="text-center">
                                        <svg width="34" height="34" fill="none" stroke="currentColor" stroke-width="1.75">
                                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#image';?>"></use>
                                        </svg>
                                        <div class="fs-base mt-2">
                                            <?php echo $this->translate('Select image');?>
                                        </div>
                                        <div class="fs-xs">
                                            <?php echo $this->translate('Allow image type jpg, png, webp');?>
                                        </div>
                                    </div>
                                </div>
                                <div class="ratio-btn p-3">
                                    <div class="btn btn-square p-0 rounded-circle btn-theme mx-1 btn-upload" data-id="input-cover">
                                        <svg width="16" height="16" stroke="currentColor" stroke-width="2" fill="none">
                                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#upload';?>"></use>
                                        </svg>
                                    </div>
                                    <div class="btn btn-square p-0 rounded-circle btn-light mx-1 btn-clear <?php if(empty($AuthUser['avatar'])) echo 'd-none';?>" data-id="input-cover">
                                        <svg width="18" height="18" stroke="currentColor" stroke-width="2" fill="none">
                                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#close';?>"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <input type="file" name="image" class="ratio-input d-none" id="file-input-cover" data-preview="ratio-select" accept="image/*">
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-theme py-3">
                                <?php echo $this->translate('Save changes');?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php require PATH . '/theme/view/common/javascript.php'; ?>
<?php require PATH . '/theme/view/common/footer.php'; ?>