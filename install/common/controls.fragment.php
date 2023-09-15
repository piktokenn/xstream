<form method="post" id="controls" class="step">
    <input type="hidden" name="_ACTION" value="install">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php if($Notify) { ?>
            <div class="bg-danger alert text-white fs-sm text-center mb-3">
                <?php echo $Notify;?>
            </div>
            <?php } ?>
            <div class="h4 text-body mb-3">Database</div>
            <div class="mb-3">
                <label class="form-label">Database Host</label>
                <input type="text" class="form-control form-control-lg shadow-sm" name="db_host" value="<?php echo isset($_POST['db_host']) ? $_POST['db_host'] : null;?>" placeholder="Database Host">
            </div>
            <div class="mb-3">
                <label class="form-label">Database Name</label>
                <input type="text" class="form-control form-control-lg shadow-sm" name="db_name" value="<?php echo isset($_POST['db_name']) ? $_POST['db_name'] : null;?>" placeholder="Database Name">
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control form-control-lg shadow-sm" name="db_username" value="<?php echo isset($_POST['db_username']) ? $_POST['db_username'] : null;?>" placeholder="Username">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="text" class="form-control form-control-lg shadow-sm" name="db_password" value="<?php echo isset($_POST['db_password']) ? $_POST['db_password'] : null;?>" placeholder="Password">
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-success shadow next-btn btn-lg" data-next="#controls">Finish Installation</button>
            </div>
        </div>
    </div>
</form>