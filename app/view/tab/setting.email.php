<div class="mb-3">
    <label class="form-label">SMTP Host</label>
    <input type="text" name="data[<?php echo $key?>][host]" value="<?php echo get($Settings,'data.host',$key);?>" class="form-control" placeholder="Smtp Host" maxlength="160">
</div>
<div class="mb-3">
    <label class="form-label">SMTP Username</label>
    <input type="text" name="data[<?php echo $key?>][username]" value="<?php echo get($Settings,'data.username',$key);?>" class="form-control" placeholder="Smtp Username" maxlength="160">
</div>
<div class="mb-3">
    <label class="form-label">SMTP Password</label>
    <input type="text" name="data[<?php echo $key?>][password]" value="<?php echo get($Settings,'data.password',$key);?>" class="form-control" placeholder="Smtp Password" maxlength="160">
</div>
<div class="mb-3">
    <label class="form-label">SMTP Port</label>
    <input type="text" name="data[<?php echo $key?>][port]" value="<?php echo get($Settings,'data.port',$key);?>" class="form-control" placeholder="Smtp Port" maxlength="10">
</div>
<div class="mb-3">
    <label class="form-label">SMTP Encryption</label>
    <select name="data[<?php echo $key?>][security]" class="form-select">
        <option value=""><?php echo $this->translate('Choose');?></option>
        <option value="tls" <?php if(get($Settings,'data.security',$key)=='tls' ) echo 'selected' ;?>>TLS</option>
        <option value="ssl" <?php if(get($Settings,'data.security',$key)=='ssl' ) echo 'selected' ;?>>SSL</option>
    </select>
</div>
<div class="mb-3">
    <label class="form-label">From Address</label>
    <input type="text" name="data[<?php echo $key?>][sendemail]" value="<?php echo get($Settings,'data.sendemail',$key);?>" class="form-control" placeholder="From Address" maxlength="160">
</div>