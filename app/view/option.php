<?php require PATH . '/view/common/head.php'; ?>
<?php require PATH . '/view/common/header.php'; ?>
<?php require_once PATH.'/config/array.config.php'; ?>
<div class="container">
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="_ACTION" value="save">
        <input type="hidden" name="_TOKEN" value="<?php echo $Token?>">
        <div class="mb-3">
            <label class="form-label">
                <?php echo $this->translate('Name');?></label>
            <input type="text" name="name" class="form-control form-control-lg" placeholder="<?php echo $this->translate('Name');?>" required="true" value="<?php if(isset($Listing['name'])) echo $Listing['name'];?>">
        </div>
        <div class="mb-3">
            <label class="form-label"><?php echo $this->translate('Type');?></label>
            <select name="type" class="form-select" required="true">
                <option value=""><?php echo $this->translate('Choose');?></option>
                <?php foreach ($OptionType as $key => $value) { ?>
                <option value="<?php echo $key;?>" <?php if(isset($Listing['type']) AND $key==$Listing['type']) echo 'selected="true"' ;?>>
                    <?php echo $value;?>
                </option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-xl-250 py-3 mb-3">
            <?php echo $this->translate('Save changes');?></button>
    </form>
</div>
<?php require PATH . '/view/common/javascript.php'; ?>
<script type="text/javascript">
(function($) {
    'use strict';
    $('body').on('click', '.importer', function() {
        $.ajax({
            url: Base + '/api/getMovie',
            type: 'POST',
            data: {
                'id': $('input[name="tmdb_id"]').val()
            },
            dataType: 'json',
            success: function(resp) {
                $('input[name="title_sub"]').val(resp.title);
                $('input[name="title"]').val(resp.original_title);
                $('[name="overview"]').val(resp.overview);
                $('.input-cover').css('background-image', 'url(' + resp.image + ')');
                $('input[name="vote_average"]').val(resp.vote_average);
                $('input[name="release_date"]').val(resp.release_date);
                $('input[name="runtime"]').val(resp.runtime);
                $('input[name="trailer"]').val(resp.trailer);
                $.each(resp.genres, function(index, data) {
                    $('[name="genres[]"]').find('option[data-text="' + resp.genres[index].name + '"]').attr('selected', 'selected');
                });
                $('.row-people').html('');
                $.each(resp.people, function(index, data) {
                    if (resp.people[index].department == 'Directing') {
                        $('input[name="directing"]').val(resp.people[index].id);
                    }
                    $('#card-people').tmpl(resp.people[index]).appendTo('.row-people');
                });
                $('.ratio-preview').addClass('d-none');
                $('.btn-clear').removeClass('d-none');
                $('.bs-select').selectpicker('refresh');
            }
        });
    });
})(jQuery);
</script>
<?php require PATH . '/view/common/footer.php'; ?>