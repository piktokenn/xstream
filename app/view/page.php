<?php require PATH . '/view/common/head.php'; ?>
<?php require PATH . '/view/common/header.php'; ?>
<div class="container">
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="_ACTION" value="save">
        <input type="hidden" name="_TOKEN" value="<?php echo $Token?>">
        <div class="mb-3">
            <label class="form-label"><?php echo $this->translate('Title');?></label>
            <input type="text" name="name" class="form-control form-control-lg" placeholder="<?php echo $this->translate('Title');?>" required="true" value="<?php if(isset($Listing['name'])) echo $Listing['name'];?>">
            <?php if(isset($Listing['self'])) { ?>
            <div class="fs-xs mt-2">
                <span class="fw-semibold">Permalink : </span>
                <span class="permalink">
                    <?php echo APP;?>/<input type="text" name="self" class="form-control d-inline-block fs-xs py-0 bg-transparent border-0 shadow-none px-0 fw-semibold w-auto" value="<?php echo $Listing['self'];?>"></span>
            </div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="icon" class="form-label"><?php echo $this->translate('Description');?></label>
            <textarea name="description" rows="3" class="form-control" placeholder="<?php echo $this->translate('Description');?>"><?php echo isset($Listing['description']) ? $Listing['description'] : null;?></textarea>
        </div>
        <div class="mb-3"> 
            <div class="card p-2 shadow-none">
                <textarea name="body" class="form-control" placeholder=""><?php echo isset($Listing['body']) ? htmlspecialchars_decode($Listing['body']) : null;?></textarea>
            </div>
        </div>
                    <button type="submit" class="btn btn-primary w-xl-300 py-3 mb-3"><?php echo $this->translate('Save changes');?></button>
        <div class="mb-3">
                    <label class="form-label fs-xs">
                        <?php echo $this->translate('Advanced');?></label>
            <div class="form-switch mb-1">
                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" <?php if(isset($Listing['status']) AND $Listing['status']==1) echo 'checked=""' ;?>>
                <label class="form-check-label ms-2" for="status"><?php echo $this->translate('Publish');?></label>
            </div>
        </div>
    </form>
</div>
<?php require PATH . '/view/common/javascript.php'; ?>
<script src="<?php echo ASSETS.'/js/tinymce/tinymce.min.js';?>"></script>
<script type="text/javascript">
tinymce.init({
    selector: '[name="body"]',
    plugins: 'image link media hr pagebreak lists codesample fullscreen code autoresize',
    menubar: '',
    toolbar: 'bold underline formatselect | alignleft aligncenter alignright | image media link | forecolor backcolor removeformat | codesample | charmap |   anchor pagebreak numlist bullist code',
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
$('[data-ajax="type"]').trigger('change');
$('[data-ajax="category"]').trigger('change');
</script>
<?php require PATH . '/view/common/footer.php'; ?>