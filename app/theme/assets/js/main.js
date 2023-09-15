/**
 * Copyright 2022
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


    // scroll up
    $('body').on('click', '.btn-scroll', function(e) {
        $("html, body").animate({ scrollTop: 0 }, 0);
    });

    $(document).scroll(function() {
        if ($(this).scrollTop() > 150) {
            $(".btn-scroll").addClass('show');
        } else {
            $(".btn-scroll").removeClass('show');
        }
    });
    $('body').on('click', '.btn-stream', function(e) {
        var id = $(this).attr('data-id');
        $('.btn-stream').removeClass('active');
        $(this).addClass('active');
        $.ajax({
            url: Base + '/ajax/embed',
            type: 'POST',
            data: {
                'id': id
            },
            success: function(resp) {
                $('.ratio-embed').html(resp);
                var videoElem = document.getElementById('player');
                videojs(videoElem);


                if (document.getElementById("player") !== null && ad_vast) {
    
                    var s = document.createElement("script");
                    s.type = "text/javascript";
                    s.src = "//imasdk.googleapis.com/js/sdkloader/ima3.js";
                    $("head").append(s);
                    var contentPlayer = document.getElementById('player');
                    var player = videojs(contentPlayer);
                    var options = {
                        id: 'player',
                        adTagUrl: ad_vast
                    };
                    player.ima(options);
                    var startEvent = 'click';
                    player.one(startEvent, function() {
                        player.ima.initializeAdDisplayContainer();
                        player.ima.requestAds();
                        player.play();
                    });
                }
            }
        });
    });
    $('.btn-stream.active').trigger('click');

    $(document).on('change', '.episode-check', function(e) {

        var episode_id = $(this).val();
        var post_id = $(this).data('post');
        if (!_Auth) {
            Snackbar.show({ text: __('You must sign in'), customClass: 'bg-danger' });
            return false;
        }
        $.ajax({
            url: Base + '/ajax/viewed',
            type: 'post',
            data: {
                'episode_id': episode_id,
                'post_id': post_id
            }
        });
    });
    // Bootstrap remote modal
    $('body').on('click', '[data-bs-toggle="modal"]', function() {
        $($(this).data("bs-target") + ' .modal-dialog').load($(this).data("remote"), function() {

            var videoElem = document.getElementById('trailer');
            videojs(videoElem);

            if (document.getElementById("trailer") !== null && ad_vast !== null) {
                var s = document.createElement("script");
                s.type = "text/javascript";
                s.src = "//imasdk.googleapis.com/js/sdkloader/ima3.js";
                $("head").append(s);
                var contentPlayer = document.getElementById('trailer');
                var player = videojs(contentPlayer);
                var options = {
                    id: 'player',
                    adTagUrl: ad_vast
                };
                player.ima(options);
                var startEvent = 'click';
                player.one(startEvent, function() {
                    player.ima.initializeAdDisplayContainer();
                    player.ima.requestAds();
                    player.play();
                });
            }
        });
    });
    $('.modal').on('hide.bs.modal', function(e) {
        $('.modal-dialog').html('');
    });
    if (document.getElementById("trailer") !== null && ad_vast !== null) {
        var s = document.createElement("script");
        s.type = "text/javascript";
        s.src = "//imasdk.googleapis.com/js/sdkloader/ima3.js";
        $("head").append(s);
        var contentPlayer = document.getElementById('trailer');
        var player = videojs(contentPlayer);
        var options = {
            id: 'player',
            adTagUrl: ad_vast
        };
        player.ima(options);
        var startEvent = 'click';
        player.one(startEvent, function() {
            player.ima.initializeAdDisplayContainer();
            player.ima.requestAds();
            player.play();
        });
    }


    // Reaction
    $('body').on('click', '.btn-reaction', function(e) {
        var id = $(this).attr('data-id');
        if (!_Auth) {
            window.location.href = Base + '/login';
            return false;
        }
        e.preventDefault();
        var UP = 'up',
            DOWN = 'down',
            REMOVE_UP = '-up',
            REMOVE_DOWN = '-down',
            type,
            $el = $(e.currentTarget),
            $votes = $el.parent(),
            $upvote = $votes.find('.btn-like'),
            $downvote = $votes.find('.btn-dislike'),
            $upvotes = $votes.find('.like-count'),
            $downvotes = $votes.find('.dislike-count'),
            upvotes = parseInt($upvotes.data('votes')),
            downvotes = parseInt($downvotes.data('votes')),
            setUpvotes = function(val) {
                $upvotes.data('votes', val).text(val || '0');
            },
            setDownvotes = function(val) {
                $downvotes.data('votes', val).text(val || '0');
            };
        if ($el.hasClass('btn-like')) {
            if ($el.hasClass('active')) {
                $el.removeClass('active');
                setUpvotes(upvotes - 1);
                type = REMOVE_UP;
            } else {
                type = UP;

                if ($downvote.hasClass('active')) {
                    $downvote.removeClass('active');
                    setDownvotes(downvotes - 1);
                }

                $el.addClass('active');
                setUpvotes(upvotes + 1);
            }
        } else {
            if ($el.hasClass('active')) {
                $el.removeClass('active');
                setDownvotes(downvotes - 1);
                type = REMOVE_DOWN;
            } else {
                type = DOWN;

                if ($upvote.hasClass('active')) {
                    $upvote.removeClass('active');
                    setUpvotes(upvotes - 1);
                }

                $el.addClass('active');
                setDownvotes(downvotes + 1);
            }
        }

        $.ajax({
            url: Base + '/ajax/reaction',
            type: 'post',
            data: {
                'type': type,
                'id': id
            }
        });
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

    // more & less
    var showChar = 300;
    var ellipsestext = "...";
    var moretext = __("more");
    var lesstext = __("less");


    $('[data-more=""]').each(function() {
        var content = $(this).html();

        if (content.length > showChar) {

            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);

            var html = c + '<span class="more-content">' + ellipsestext + '</span><span class="morecontent"><span>' + h + '</span><div class="more">' + moretext + '</div></span>';

            $(this).html(html);
        }

    });

    $('body').on('click', '.more', function() {
        if ($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
    // Slider
    if ($('#layoutSlider').children().length > 0) {
        var myCarousel = document.getElementById("layoutSlider");
        var carouselIndicators = myCarousel.querySelectorAll(
            ".carousel-indicators .slide-btn .progress-bar"
        );
        var intervalID;

        var carousel = new bootstrap.Carousel(myCarousel);

        $(document).on('click', '.carousel-indicators .slide-btn a', function() {
            window.location.href = $(this).attr('href');
            return $(this).attr('href');
        });
        window.addEventListener("load", function() {
            fillCarouselIndicator(1);
        });

        myCarousel.addEventListener("slide.bs.carousel", function(e) {
            var index = e.to;
            fillCarouselIndicator(++index);
        });

        function fillCarouselIndicator(index) {
            var i = 0;
            for (const carouselIndicator of carouselIndicators) {
                carouselIndicator.style.width = 0;
            }
            clearInterval(intervalID);
            carousel.pause();

            intervalID = setInterval(function() {
                i++;
                myCarousel.querySelector(".carousel-indicators .active .progress-bar").style.width =
                    i + "%";
                if (i >= 100) {
                    carousel.next();
                }
            }, 50);
        }
    }
    // request button
    $(document).on('click', '.btn-request', function(e) {
        var tmdb_id = $(this).attr('data-id');
        var media_type = $(this).attr('data-type');
        var btn = $(this);
        $.ajax({
            url: Base + '/ajax/request',
            type: 'post',
            data: {
                'tmdb_id': tmdb_id,
                'media_type': media_type
            },
            dataType: 'json',
            success: function(resp) {
                if (resp.status === 'success') {
                    btn.attr('data-id', '');
                    btn.addClass('btn-success');
                    btn.removeClass('btn-ghost');
                    btn.text(__('Ready'));
                }
                Snackbar.show({ text: resp.text, customClass: 'bg-' + resp.status });
            }
        });
    });
    $('body').on('submit', 'form[data-loader=""]', function(e) {
        // add spinner to button
        $(this).find('button[type="submit"]').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>');
        $(this).find('button[type="submit"]').prop("disabled", true);
    });
    // cookie modal
    $('body').on('click', '.close-cookie', function(e) {
        localStorage.setItem('modal_cookie', 1);
        $registerModal.addClass('d-none');
    });

    // cookie 
    var $registerModal = $(".modal-cookie");
    var $registerCookies = localStorage.getItem('modal_cookie');
    if (!$registerCookies) {
        $registerModal.removeClass('d-none');
    } else {
        $registerModal.addClass('d-none');
    }

    // Ajax tab
    $('body').on('click', '[data-ajax-tab=""] a', function() {
        loadingBar(1);
        var $this = $(this),
            changeurl = $this.attr('href'),
            loadurl = $this.attr('data-url');
        $('[data-ajax-tab=""] a').removeClass('active');
        $(this).addClass('active');
        $.get(loadurl, function(data) {
            $('.layout-tab-content').html(data);
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-tooltip="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    trigger: 'hover'
                });
            });
            Codelug.comment();
            loadingBar(0);
        });
        window.history.pushState("data", null, changeurl);
        return false;
    });
    $('body').on('submit', '[data-form="ajax"]', function() {
        loadPage($(this).attr('action'), 1, $(this).serialize() + '&ajax=true');
        return false;
    });
    $('body').on('click', '#content .pagination a', function() {
        var linkUrl = jQuery(this).attr('href');
        loadPage(linkUrl, 0, { ajax: 1 });
        return false;
    });

    // share click
    $('body').on({
        click: function() {
            var $this = $(this),
                dataType = $this.attr('data-type'),
                dataTitle = $this.attr('data-title'),
                dataMedia = $this.attr('data-media'),
                dataSef = $this.attr('data-sef');

            switch (dataType) {
                case 'facebook':
                    shareWindow('https://www.facebook.com/sharer/sharer.php?u=' + dataSef);
                    break;

                case 'twitter':
                    shareWindow('https://twitter.com/intent/tweet?text=' + encodeURIComponent(dataTitle) + ' ' + encodeURIComponent(dataSef));
                    break;

                case 'whatsapp':
                    shareWindow('whatsapp://send?text=' + encodeURIComponent(dataTitle) + ' ' + encodeURIComponent(dataSef));
                    break;
                case 'telegram':
                    shareWindow('https://t.me/share/url?url=' + encodeURIComponent(dataSef) + '&text=' + encodeURIComponent(dataTitle) + ' 🎮 ');
                    break;
            }

            function shareWindow(url) {
                window.open(url, "_blank");
            }

        }
    }, '.btn-share');

    function loadingBar(type) {
        if (type) {
            jQuery("#loading-bar").show();
            jQuery("#loading-bar").width((50 + Math.random() * 30) + "%");
        } else {
            jQuery("#loading-bar").width("100%").delay(50).fadeOut(400, function() {
                jQuery(this).width("0");
            });
        }
    }

    function loadPage(argUrl, argType, argParams, options = { loadingBar: true }) {
        loadingBar(1);
        if (argType == 1) {
            argType = "POST";
        } else {
            argType = "GET";

            // Store the url to the last page accessed
            if (argUrl != window.location) {
                window.history.pushState({ path: argUrl }, '', argUrl);
            }
        }

        // Request the page
        $.ajax({
            url: argUrl,
            type: argType,
            data: argParams,
            success: function(data) {
                $('#content').html(data);
                if (argType == 'POST') {
                    window.history.pushState({ path: $('input[name="_PAGE"]').val() }, '', $('input[name="_PAGE"]').val());
                }
                Codelug.filter();
                jQuery(document).scrollTop(0);
                loadingBar(0);
            }
        })
    }
    Codelug.comment();
    Codelug.filter();

})(jQuery);