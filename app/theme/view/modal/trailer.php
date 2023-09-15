<div class="modal-content">
    <div class="modal-body p-0 position-relative">
        <div class="ratio ratio-16x9 rounded ratio-trailer overflow-hidden"> 
            <video id="trailer" class="video-js vjs-default-skin" controls data-setup='{ "techOrder": ["youtube"], "sources": [{ "type": "video/youtube", "src": "<?php echo $_GET['link'];?>"}], "youtube": { "customVars": { "wmode": "transparent" ,"iv_load_policy": 1,"ytControls": 0} } }'></video>
        </div>
    </div>
</div>