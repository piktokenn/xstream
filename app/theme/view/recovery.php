<?php require PATH . '/theme/view/common/head.php'; ?>
<?php require PATH . '/theme/view/common/header.php'; ?>
<div class="py-lg-7 py-5">
    <div class="h-100">
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-4 col-lg-5">
                <?php if(isset($_SESSION["notify"]["text"])) { ?>
                    <div class="alert bg-warning text-white fs-sm text-center"><?php echo $_SESSION["notify"]["text"] ?></div>
                <?php } ?>
                <form method="post" class="" name="login">
                    <input type="hidden" name="_TOKEN" value="<?php echo $Token;?>">
                    <input type="hidden" name="_ACTION" value="recovery">
                    <div class="mb-3">
                        <label for="password" class="form-label text-body"><?php echo $this->translate('New password');?></label>
                        <input type="text" name="password" placeholder="<?php echo $this->translate('New password');?>" class="form-control fs-sm form-control-lg bg-gray-200 border-0" id="password" autofocus="true" tabindex="1">
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-theme btn-lg" tabindex="3"><?php echo $this->translate('Reset password');?></button>
                    </div>
                </form>
                <div class="fs-sm text-center text-muted my-3"><?php echo $this->translate('Dont have an account ?');?><a href="<?php echo APP.'/'.$this->translate('register');?>" class="text-current fw-semibold ms-2" tabindex="4"><?php echo $this->translate('Sign up');?></a></div>
            </div>
        </div>
    </div>
</div>
<?php require PATH . '/theme/view/common/javascript.php'; ?>
<?php require PATH . '/theme/view/common/footer.php'; ?>