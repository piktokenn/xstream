/**
 * Codelug Namespace
 */
var Codelug = {};

/**
 * Comment
 */
Codelug.comment = function() {

    if ($('.comments').length > 0) {
        var post_id = $('.comments').attr('data-content');
        var post_type = $('.comments').attr('data-type');
        new Comments($('.comments'), {
            ajaxUrl: Base + "/comments",
            content: post_id,
            type: post_type,
            sortBy: 1,
            replies: true,
            maxDepth: 1,
        });
    }
}
Codelug.filter = function() {
    $(".range-slider").ionRangeSlider({
        skin: "round"
    });
}