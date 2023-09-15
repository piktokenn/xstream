<div class="modal-content">
    <div class="modal-body p-4 p-xl-5 position-relative">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="text-center mb-4">
            <h3 class="mb-2"><?php echo $this->translate('Share with everyone');?></h3>
            <div class="fs-sm text-muted"><?php echo $this->translate('If you liked this item share it with your friends. They will thank you later.');?></div>
        </div>
        <div class="d-flex align-items-center justify-content-center">
            <button class="btn btn-square btn-lg rounded-circle bg-facebook text-white mx-2 btn-share" data-type="facebook" data-sef="<?php echo $_GET['url'];?>">
                <svg width="18" height="18" fill="currentColor">
                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#facebook';?>"></use>
                </svg>
            </button>
            <button class="btn btn-square btn-lg rounded-circle bg-twitter text-white mx-2 btn-share" data-type="twitter" data-title="<?php echo urldecode($_GET['title']);?>" data-sef="<?php echo $_GET['url'];?>">
                <svg width="20" height="20" fill="currentColor">
                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#twitter';?>"></use>
                </svg>
            </button>
            <button class="btn btn-square btn-lg rounded-circle bg-whatsapp text-white mx-2 btn-share" data-type="whatsapp" data-title="<?php echo urldecode($_GET['title']);?>" data-sef="<?php echo $_GET['url'];?>">
                <svg width="20" height="20" fill="currentColor">
                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#whatsapp';?>"></use>
                </svg>
            </button>
            <button class="btn btn-square btn-lg rounded-circle bg-telegram text-white mx-2 btn-share" data-type="telegram" data-title="<?php echo urldecode($_GET['title']);?>" data-sef="<?php echo $_GET['url'];?>">
                <svg width="20" height="20" fill="currentColor">
                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#telegram';?>"></use>
                </svg>
            </button>
        </div>
        <div class="input-group input-group-lg mt-4 code">
            <input type="text" class="form-control" placeholder="https://" value="<?php echo $_GET['url'];?>" id="code-input">
            <button type="button" class="input-group-text py-0" id="basic-addon1">
                <svg width="16" height="16" fill="currentColor">
                    <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#copy';?>"></use>
                </svg>
            </button>
        </div>
    </div>
</div>
<script type="text/javascript">
(function($) {
    'use strict';
    // Copy
    $('.code button').on('click', function() {
        var copyText = document.getElementById('code-input');
        copyText.select(); /* Select the text field */
        copyText.setSelectionRange(0, 99999); /* For mobile devices */
        document.execCommand("copy"); /* Copy the text inside the text field */

    });

    // share click
    $('body').on({
        click: function() {
            var $this = $(this),
                dataType = $this.attr('data-type'),
                dataTitle = $this.attr('data-title'),
                dataSef = $this.attr('data-sef');

            switch (dataType) {
                case 'facebook':
                    shareWindow('https://www.facebook.com/sharer/sharer.php?u=' + dataSef);
                    break;

                case 'twitter':
                    shareWindow('https://twitter.com/intent/tweet?text=' + encodeURIComponent(dataSef));
                    break;
                case 'whatsapp':
                    shareWindow('whatsapp://send?text=' + encodeURIComponent(dataSef));
                    break;
                case 'telegram':
                    shareWindow('https://t.me/share/url?url=' + encodeURIComponent(dataSef));
                    break;
            }

            function shareWindow(url) {
                window.open(url, "_blank");
            }

        }
    }, '.btn-share');
})(jQuery);
</script>