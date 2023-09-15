<div class="modal-content">
    <div class="modal-body p-4 p-xl-5 position-relative">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="mb-4">
            <div class="collections"></div>
        </div>
        <input type="hidden" name="post_id" value="<?php echo Input::cleaner($Listing['id']);?>">
        <div class="fs-base fw-semibold mb-2">
            <?php echo $this->translate('New collection');?>
        </div>
        <form method="post" class="collection-form" data-loader="">
            <input type="hidden" name="_ACTION" value="save">
            <input type="hidden" name="_TOKEN" value="<?php echo $Token;?>">
            <div class="mb-2">
                <label class="form-label">
                    <?php echo $this->translate('Title');?></label>
                <input type="text" name="name" class="form-control form-control-lg" placeholder="<?php echo $this->translate('Title');?>" required="true" minlength="3">
            </div>
            <div class="d-grid mb-2">
                <button type="submit" class="btn btn-theme py-3">
                    <?php echo $this->translate('Create');?></button>
            </div>
            <div class="form-switch">
                <input class="form-check-input" type="checkbox" id="privacy" name="privacy" value="1">
                <label class="form-check-label ms-2 fs-sm" for="privacy">
                    <?php echo $this->translate('Private');?></label>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
$(function() {

    var post_id = $('[name="post_id"]').val();
    $.ajax({
        url: Base + '/ajax/collections',
        type: 'POST',
        data: 'post_id=' + post_id,
        dataType: 'json',
        success: function(resp) {
            $('#card-collection').tmpl(resp.data).appendTo('.collections');
        }
    });

    $(document).on('submit', '.collection-form', function() {
        $.ajax({
            url: Base + '/ajax/collection',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(resp) {
                $('form[data-loader=""]').find('button[type="submit"]').html('Create');
                $('form[data-loader=""]').find('button[type="submit"]').removeAttr('disabled');
                Snackbar.show({ text: resp.text, customClass: 'bg-' + resp.status });
                $('#card-collection').tmpl(resp.data).appendTo('.collections');
                $('.collection-form')[0].reset();
            }
        });

        return false;
    });
    $(document).on('change', '.collections input[name="collection"]', function(e) {
        var post_id = $('[name="post_id"]').val();
        var collection_id = $(this).val();
        $.ajax({
            url: Base + '/ajax/savecollection',
            type: 'POST',
            dataType: 'json',
            data: {
                'post_id': post_id,
                'collection_id': collection_id
            },
            success: function(resp) {
                $('.modal').modal('hide');
                Snackbar.show({ text: resp.text, customClass: 'bg-' + resp.status });
            }
        });
        return false;
    });
});
</script>
<script id="card-collection" type="text/x-jquery-tmpl">
<div class="form-switch mb-1">
    <input class="form-check-input" type="radio" id="bookmark${id}" name="collection" value="${id}" {{if selected===true}}checked="true"{{/if}}>
    <label class="form-check-label ms-2" for="bookmark${id}">${name}</label>
</div>
</script>