<?php require PATH . '/view/common/head.php'; ?>
<?php require PATH . '/view/common/header.php'; ?>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="_ACTION" value="save">
    <input type="hidden" name="_TOKEN" value="<?php echo $Token?>">
    <div class="mb-3 text-center">
        <ul class="nav justify-content-center fw-normal d-inline-flex nav-segment bottom fs-sm" id="myTab" role="tablist">
            <?php 
                $i = 0;
                foreach ($TabNav as $key => $value) { 
                ?>
            <li class="nav-item">
                <a class="nav-link <?php echo ($i == 0) ? 'active' : ''; ?>" id="<?php echo $key;?>-tab" data-bs-toggle="tab" data-bs-target="#<?php echo $key;?>" type="button" role="tab" aria-controls="<?php echo $key;?>" aria-selected="<?php echo ($i == 0) ? 'true' : 'false'; ?>">
                    <?php echo $value;?></a>
            </li>
            <?php $i++; } ?>
        </ul>
    </div>
    <div class="tab-content" id="myTabContent">
        <?php 
            $i = 0;
            foreach ($TabNav as $key => $value) { 
            ?>
        <div class="tab-pane <?php if($i == 0) { echo 'active'; } ?>" id="<?php echo Input::seo($key);?>" role="tabpanel" aria-labelledby="<?php echo Input::seo($key);?>-tab">
            <?php include PATH.'/view/tab/setting.'.Input::seo($key).'.php';?>
        </div>
        <?php $i++; } ?>
    </div>
    <button type="submit" class="btn btn-primary w-xl-300 py-3 mt-3 mb-3">
        <?php echo $this->translate('Save changes');?></button>
</form>
<?php require PATH . '/view/common/javascript.php'; ?>
<script src="<?php echo ASSETS.'/js/tinymce/tinymce.min.js';?>"></script>

<script type="text/javascript">
tinymce.init({
    selector: '[name="data[general][footer_text]"]',
    plugins: 'image link media hr pagebreak lists codesample fullscreen code autoresize',
    menubar: '',
    toolbar: 'bold underline formatselect | alignleft aligncenter alignright | link | forecolor backcolor removeformat | code',
    height: 500,
    images_upload_url: Base + '/ajax/upload',

    convert_urls: false,
    /* we override default upload handler to simulate successful upload*/

    images_upload_handler: function(blobInfo, success, failure) {
        var xhr, formData;

        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', Base + '/admin/ajax/upload');

        xhr.onload = function() {
            var json;

            if (xhr.status != 200) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }

            json = JSON.parse(xhr.responseText);

            if (!json || typeof json.file_path != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }

            success(json.file_path);
        };

        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        xhr.send(formData);
    },
    skin: 'oxide',
    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable code',
    contextmenu: 'link image imagetools table configurepermanentpen',
    content_css: "<?php echo ASSETS.'/css/theme.css?v='.VERSION;?>",
    branding: false,
});
</script>
<?php require PATH . '/view/common/footer.php'; ?>