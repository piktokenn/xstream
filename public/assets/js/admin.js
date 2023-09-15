/**
 * Copyright 2021 codelug
 * 
 * @author codelug
 * @version 1.0
 */
(function($) {
    'use strict';
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-tooltip="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            trigger: 'hover'
        });
    });


    $('body').on('click', '[data-bs-toggle="modal"]', function() {
        $($(this).data("bs-target") + ' .modal-dialog').load($(this).data("remote"), function() {

        });
    });
    $('body').on('submit', 'form[data-loader=""]', function(e) {
        $(this).find('button[type="submit"]').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>');
        $(this).find('button[type="submit"]').prop("disabled", true);
    });
    // Action Control

    $('body').on('click', '.confirm', function() {
        if (confirm(__('Do you want to remove it ?'))) {
            return true;
        } else {
            return false;
        }
    });

    // Cover Select 
    $(document).on('click', '.btn-upload', function() {
        var id = $(this).attr('data-id');
        $('#file-' + id).click();
        return false;
    });

    $(document).on('click', '.btn-clear', function() {
        var id = $(this).attr('data-id');
        $('.' + id).val('');
        $('.ratio-preview').removeClass('d-none');
        $('.' + id).css('background-image', '');
        $('.btn-clear').addClass('d-none');
        return false;
    });
    $(document).on('change', '.ratio-input', function() {
        var id = $(this).attr('data-preview');
        $('.btn-clear').removeClass('d-none');
        if (this.files && this.files[0]) {

            var reader = new FileReader();
            reader.onload = function(e) {
                $('.' + id).css('background-image', 'url(' + e.target.result + ')');
                $('.ratio-preview').addClass('d-none');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Bootstrap select
    $('.bs-select').selectpicker();

    $(document).on('change', '[data-ajax="post"]', function() {
        $('.season').removeClass('d-none');
        var id          = $(this).val();
        var season_id   = $(this).attr('data-id');
        $.ajax({
            type: 'POST',
            url: Base + '/admin/ajax/seasons',
            dataType: 'json',
            data: 'id=' + id,
            success: function(resp) {
                $('[name="season_id"]').attr('disabled', false);
                $('[name="season_id"]').empty();
                $.each(resp.data, function(i, val) {
                    $('[name="season_id"]').append($('<option>', {
                        value: resp.data[i].id,
                        text: resp.data[i].name
                    }));
                    $.each(resp.data[i].category, function(ii, val) {
                        $('[name="season_id"]').append($('<option>', {
                            value: resp.data[i].category[ii].id,
                            text: resp.data[i].category[ii].name
                        }));
                    });
                    $('[name="season_id"] option[value="' + season_id + '"]').prop('selected', true);

                });

                $('.bs-select').selectpicker('refresh');
            }
        });
    });
    // slide
    $(document).on('change', '[data-ajax="slide"]', function() {
        var id          = $(this).val();
        $.ajax({
            type: 'GET',
            url: Base + '/admin/ajax/post',
            dataType: 'json',
            data: 'id=' + id,
            success: function(resp) {
                $('[name="heading"]').val(resp.data.title);
                $('[name="description"]').val(resp.data.overview);

                $('.bs-select').selectpicker('refresh');
            }
        });
    });
    // Colorpicker
    $('.colorpicker').minicolors({
        control: $(this).attr('data-control') || 'hue',
        inline: $(this).attr('data-inline') === 'true',
        letterCase: 'lowercase',
        opacity: false,
        change: function(hex, opacity) {
            if (!hex) return;
            if (opacity) hex += ', ' + opacity;
            try {
                console.log(hex);
            } catch (e) {}
            $(this).select();
        },
        theme: 'bootstrap'
    });

    // Nav 
    $("[data-nav] a").on("click", function(e) {
        var $this = $(this),
            $active, $li, $li_li;

        $li = $this.parent();
        $li_li = $li.parents('li');

        $active = $li.closest("[data-nav]").find('.active');

        $li_li.addClass('active');
        ($this.next().is('ul') && $li.toggleClass('active')) || $li.addClass('active');

        $active.not($li_li).not($li).removeClass('active');

        if ($this.attr('href') && $this.attr('href') != '#') {
            $(document).trigger('Nav:changed');
        }
    });


    $('body').on('click', '.importer', function() {
        $('body').addClass('body-lock');
        var dataType = $(this).data('type');
        $.ajax({
            url: Base + '/api/' + dataType,
            type: 'POST',
            data: {
                'id': $('input[name="tmdb_id"]').val()
            },
            dataType: 'json',
            success: function(resp) {
                if(dataType == 'getMovie' || dataType == 'getSerie') {
                    $('input[name="title_sub"]').val(resp.original_title);
                    $('input[name="title"]').val(resp.title);
                    $('[name="overview"]').val(resp.overview);
                    $('.input-cover').css('background-image', 'url(' + resp.image + ')');
                    $('input[name="vote_average"]').val(resp.vote_average);
                    $('input[name="image_url"]').val(resp.image);
                    $('input[name="cover_url"]').val(resp.cover);
                    $('input[name="release_date"]').val(resp.release_date);
                    $('input[name="runtime"]').val(resp.runtime); 
                    $('input[name="trailer"]').val(resp.trailer);
                    $('[name="country"]').find('option[data-text="' + resp.country + '"]').attr('selected', 'selected');
                    $.each(resp.genres, function(index, data) {
                        $('[name="genres[]"]').find('option[data-text="' + resp.genres[index].name + '"]').attr('selected', 'selected');
                    });
                    $('.row-people').html('');
                    $.each(resp.people, function(index, data) {
                        if (resp.people[index].department == 'Directing') {
                            $('input[name="directing_id"]').val(resp.people[index].id);
                        }
                        $('#empty-cast').tmpl(resp.people[index]).appendTo('.row-people');
                    });
                    $.each(resp.season, function(index, data) {
                        $('#empty-season').tmpl(resp.season[index]).appendTo('.season-table');
                    });
                    $('[name="keywords"]').val(resp.tags);

                    $('.ratio-preview').addClass('d-none');
                    $('.btn-clear').removeClass('d-none');
                    $('.bs-select').selectpicker('refresh');
                } else if (dataType == 'getPeople') {
                    $('input[name="image_url"]').val(resp.image);
                    $('input[name="name"]').val(resp.name);
                    $('input[name="imdb_id"]').val(resp.imdb_id);
                    $('[name="biography"]').val(resp.biography);
                    $('[name="birthday"]').val(resp.birthday);
                    $('[name="department"]').find('option[value="' + resp.department + '"]').attr('selected', 'selected');
                    $('[name="gender"]').find('option[value="' + resp.gender + '"]').attr('selected', 'selected');
                    $('input[name="tmdb_id"]').val(resp.id);
                    $('.input-cover').css('background-image', 'url(' + resp.image + ')');
                    $('.ratio-preview').addClass('d-none');
                    $('.btn-clear').removeClass('d-none');
                } else if (dataType == 'getNetwork') {
                    $('input[name="name"]').val(resp.name);
                    $('.input-cover').css('background-image', 'url(' + resp.image + ')');
                    $('input[name="website"]').val(resp.homepage);
                    $('input[name="image_url"]').val(resp.image);
                    $('.ratio-preview').addClass('d-none');
                    $('.btn-clear').removeClass('d-none');
                    $('.bs-select').selectpicker('refresh');
                }
        $('body').removeClass('body-lock');
            }
        });
    });
    // add video
    $('body').on('click', '.add-video', function() {
        var id = $(".video-table tbody>tr:last").data('id') + 1;
        if (!id) { id = 0 } else { id = id }
        $('#empty-row').tmpl({ id: id }).appendTo('.video-table tbody'); 
        sortable('.video-table tbody', 'reload');
        return false;
    });

    // add video
    $('body').on('click', '.add-subtitle', function() {
        var id = $(".subtitle-table tbody>tr:last").data('id') + 1;
        if (!id) { id = 0 } else { id = id }
        $('#empty-subtitle').tmpl({ id: id }).appendTo('.subtitle-table tbody'); 
        sortable('.subtitle-table tbody', 'reload');
        return false;
    });

    // add season
    $('body').on('click', '.add-season', function() {
        var id = $(".season-table tbody>tr:last").data('id') + 1;
        if (!id) { id = 0 } else { id = id }
        $('#empty-season').tmpl({ id: id }).appendTo('.season-table tbody');
        sortable('.season-table tbody', 'reload');
        return false;

    });


    // remove
    $('body').on('click', '.remove', function() {
        var id = $(this).attr('data-id');
        var dataType = $(this).attr('data-type');
        if ($(this).data('ajax')) {
            $.ajax({
                type: 'POST',
                url: Base + '/admin/delete/' + dataType + '/' + id,
                success: function(resp) {
                    $('.' + dataType + '-table tbody>tr[data-id="' + id + '"]').remove();
                    if (dataType == 'cast') {
                        $('.col-' + dataType + '[data-id="' + id + '"]').remove();
                    } else if (dataType == 'media') {
                        $('.col-' + dataType + '[data-id="' + id + '"]').remove();
                    } else if (dataType == 'collection') {
                        $('.col-' + dataType + '[data-id="' + id + '"]').remove();
                    } else {
                        $('.' + dataType + '-table tbody>tr[data-id="' + id + '"]').remove();
                    }
                    Snackbar.show({ text: __('Deletion is successful') });
                }
            });
        } else {
            if (dataType == 'cast') {
                $('.col-' + dataType + '[data-id="' + id + '"]').remove();
            } else if (dataType == 'media') {
                $('.col-' + dataType + '[data-id="' + id + '"]').remove();
            } else if (dataType == 'collection') {
                $('.col-' + dataType + '[data-id="' + id + '"]').remove();
            } else {
                $('.' + dataType + '-table tbody>tr[data-id="' + id + '"]').remove();
            }
            Snackbar.show({ text: __('Deletion is successful') });
        }
    });

    // sortable
    if ($('.sortable-video').length > 0) {
        sortable('.sortable-video', {
            forcePlaceholderSize: true,
            handle: '.js-handle'
        });
        sortable('.sortable-video')[0].addEventListener('sortupdate', function(e) {
            $('.sortable-video tr').each(function(i, el) {
                $(el).find('.sortable-input').val(i);
            });
        });
    }

    if ($('.sortable-module').length > 0) {
        sortable('.sortable-module', {
            forcePlaceholderSize: true,
            handle: '.js-handle'
        });
        sortable('.sortable-module')[0].addEventListener('sortupdate', function(e) {
            $('.sortable-module .card').each(function(i, el) {
                $(el).find('.sortable-input').val(i);
            });
        });
    }

    if ($('.sortable-subtitle').length > 0) {
        sortable('.sortable-subtitle', {
            forcePlaceholderSize: true,
            handle: '.js-handle'
        });
        sortable('.sortable-subtitle')[0].addEventListener('sortupdate', function(e) {
            $('.sortable-subtitle tr').each(function(i, el) {
                $(el).find('.sortable-input').val(i);
            });
        });
    }
    if ($('.sortable-season').length > 0) {
        sortable('.sortable-season', {
            forcePlaceholderSize: true,
            handle: '.js-handle'
        });
        sortable('.sortable-season')[0].addEventListener('sortupdate', function(e) {
            $('.sortable-season tr').each(function(i, el) {
                $(el).find('.sortable-input').val(i);
            });
        });
    }



    // add people
    $('.selectize-people').selectize({
        valueField: 'id',
        labelField: 'name',
        searchField: 'name',
        options: [],
        maxItems: 1,
        render: {
            option: function(item, escape) {
                return '<div class="d-flex align-items-center px-3 py-1">' +
                    '<div class="ratio ratio-1x1 w-50px bg-img-cover rounded-3" style="background-image:url(' + escape(item.image) + '"></div>' +
                    '<div class="ms-3">' +
                    (item.name ? '<div class="fs-sm fw-semibold">' + escape(item.name) + '</div>' : '') +
                    (item.department ? '<div class="text-muted fs-xs">' + escape(item.department) + '</div>' : '') +
                    '</div>' +
                    '</div>';
            }
        },
        load: function(query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: Base + '/admin/ajax/peoples?q=' + encodeURIComponent(query),
                type: 'GET',
                dataType: 'json',
                error: function() {
                    callback();
                },
                success: function(res) {
                    if (res.data.length > 0 || resp.data) {
                        callback(res.data.slice(0, 10));
                    }
                }
            });
        },
        create: false,
        onChange: function(value) {

            $.ajax({
                url: Base + '/admin/ajax/people?id=' + value,
                type: 'GET',
                dataType: 'json',
                success: function(resp) {
                    var id = $(".row-people > div").children().length;
                    $('#empty-cast').tmpl(resp.data).appendTo('.row-people');
                }
            });
            $('.selectize-people')[0].selectize.clear();
        }
    });


    // add post
    $('.selectize-collection').selectize({
        valueField: 'id',
        labelField: 'title',
        searchField: 'title',
        options: [],
        maxItems: 1,
        render: {
            option: function(item, escape) {
                return '<div class="d-flex align-items-center px-3 py-1">' +
                    '<div class="ratio ratio-1x1 w-50px bg-img-cover rounded-1" style="background-image:url(' + escape(item.image) + '"></div>' +
                    '<div class="ms-3">' +
                    (item.title ? '<div class="fs-sm fw-semibold">' + escape(item.title) + '</div>' : '') +
                    (item.type ? '<div class="text-muted fs-xs">' + escape(item.type) + '</div>' : '') +
                    '</div>' +
                    '</div>';
            }
        },
        load: function(query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: Base + '/admin/ajax/posts?q=' + encodeURIComponent(query),
                type: 'GET',
                dataType: 'json',
                error: function() {
                    callback();
                },
                success: function(res) {
                    if (res.data.length > 0 || resp.data) {
                        callback(res.data.slice(0, 10));
                    }
                }
            });
        },
        create: false,
        onChange: function(value) {

            $.ajax({
                url: Base + '/admin/ajax/post?id=' + value,
                type: 'GET',
                dataType: 'json',
                success: function(resp) {
                    var id = $(".row-collection > div").children().length;
                    if(resp.data) {
                        $('#empty-collection').tmpl(resp.data).appendTo('.row-collection');
                    }
                }
            });

            $('.selectize-collection')[0].selectize.clear();
        }
    });

    // Multimedia upload
    function ui_multi_add_file(id, file, data) {
        var template = $('#files-template').text();
        template = template.replace('%%filename%%', file.name);
        template = template.replace('%%id%%', id);


        template = $(template);
        template.prop('id', 'uploaderFile' + id);
        template.data('file-id', id);

        $('#files').find('li.empty').fadeOut();
        $('#files').prepend(template);
    }

    function ui_multi_update_file_status(id, status, message) {
        $('#uploaderFile' + id).find('span').html(message).prop('class', 'status text-' + status);
    }

    function ui_multi_update_file_name(id, data) {
        var template = $('#files-url').text();
        template = template.replace('%%id%%', id);
        if (data) {
            template = template.replace('%%file_name%%', data);
        }
        template = $(template);

        $('#files').prepend(template);
    }


    function ui_multi_update_file_progress(id, percent, color, active) {
        color = (typeof color === 'undefined' ? false : color);
        active = (typeof active === 'undefined' ? true : active);

        var bar = $('#uploaderFile' + id).find('div.progress-bar');

        bar.width(percent + '%').attr('aria-valuenow', percent);
        bar.toggleClass('progress-bar-striped progress-bar-animated', active);


        if (color !== false) {
            bar.removeClass('bg-success bg-info bg-warning bg-danger');
            bar.addClass('bg-' + color);
        }
    }

    $('#drag-and-drop-zone').dmUploader({ //
        url: Base + '/admin/ajax/upload',
        maxFileSize: 3000000, // 3 Megs   
        onNewFile: function(id, file) {
            ui_multi_add_file(id, file);
        },
        onBeforeUpload: function(id) {
            ui_multi_update_file_status(id, 'uploading', 'Uploading...');
            ui_multi_update_file_progress(id, 0, '', true);
        },
        onUploadCanceled: function(id) {
            // Happens when a file is directly canceled by the user.
            ui_multi_update_file_status(id, 'warning', 'Canceled');
            ui_multi_update_file_progress(id, 0, 'warning', false);
        },
        onUploadProgress: function(id, percent) {
            // Updating file progress
            ui_multi_update_file_progress(id, percent);
        },
        onUploadSuccess: function(id, data) {
            var data = JSON.parse(data);
            ui_multi_update_file_status(id, 'success', 'Uploaded');
            ui_multi_update_file_progress(id, 100, 'success', false);
            ui_multi_update_file_name(id, data.file_name);
        },
        onUploadError: function(id, xhr, status, message) {
            ui_multi_update_file_status(id, 'danger', message);
            ui_multi_update_file_progress(id, 0, 'danger', false);
        },
        onFileSizeError: function(file) {
            Snackbar.show({ text: __('3 mb Maximum file size') });
        }
    });
})(jQuery);