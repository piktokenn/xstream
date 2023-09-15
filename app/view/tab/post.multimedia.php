<!-- Our markup, the important part here! -->
<div id="drag-and-drop-zone" class="dm-uploader text-center p-4">
    <div class="fs-base text-muted mt-2">
        <?php echo $this->translate('Select image');?>
    </div>
    <div class="fs-xs text-muted">
        <?php echo $this->translate('Allow image type jpg, png, webp');?>
    </div>
    <div class="btn btn-primary mt-3 rounded-pill fw-semibold">
        <span>Open the file Browser</span>
        <input type="file" accept="image/jpg, image/jpeg,image/png, image/webp">
    </div>
</div><!-- /uploader -->
<ul class="list-unstyled py-4" id="files"></ul>

<div class="row row-cols-xxl-7">
    <?php if(isset($Multimedia)) { ?>
    <?php foreach($Multimedia as $Media) { ?>
    <div class="col-md-3 col-media" data-id="<?php echo $Media['id'];?>"> 
        <div class="card card-people border-0">
            <div class="position-relative">
                <?php echo picture(MEDIA_FOLDER,'thumb-'.$Media['image'],'card-img-top',$Media['image'],MEDIA_X.',auto');?>
                <div class="card-overlay d-flex justify-content-center text-center p-2">
                    <div class="btn btn-danger btn-sm btn-icon-text rounded-pill confirm remove" data-id="<?php echo $Media['id'];?>" data-type="media" data-ajax="true">
                        <svg width="16" height="18" fill="currentColor">
                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#delete';?>"></use>
                        </svg>
                        <span class="d-none d-lg-block ms-2 fs-xs">
                            <?php echo $this->translate('Remove');?></span>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <h3 class="fs-sm h-1x fw-semibold">
                    <?php echo $Media['name'];?>
                </h3>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php } ?>
</div>
<!-- /file list -->
<!-- File item template -->
<script type="text/html" id="files-template">
<li>
    <div class="mb-1">
        <p class="mb-2 fs-sm">
            <strong class="fw-semibold">%%filename%%</strong> - <span class="text-muted fw-bold">Waiting</span>
        </p>
        <div class="progress mb-2" style="height: 8px;">
            <div class="progress-bar progress-bar-striped rounded-pill progress-bar-animated bg-primary" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            </div>
        </div> 
    </div>
</li>
</script>
<script type="text/html" id="files-url">
    <input type="hidden" name="multimedia[%%id%%][name]" value="%%file_name%%">
</script>
<!-- Debug item template -->
<script type="text/html" id="debug-template">
    <li class="list-group-item text-%%color%%"><strong>%%date%%</strong>: %%message%%</li>
</script>