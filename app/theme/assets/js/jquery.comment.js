(function() {
    var cache = {};

    this.tmpl = function(str, data) {
        var fn = !/[^A-Za-z0-9_-]/.test(str) ?
            cache[str] = cache[str] || tmpl(document.getElementById(str).innerHTML) :
            new Function('obj',
                "var p=[],print=function(){p.push.apply(p,arguments);};" +
                "with(obj){p.push('" +
                str
                .replace(/[\r\t\n]/g, " ")
                .replace(/'(?=[^%]*%})/g, "\t")
                .split("'").join("\\'")
                .split("\t").join("'")
                .replace(/{%=(.+?)%}/g, "',$1,'")
                .split("{%").join("');")
                .split("%}").join("p.push('") +
                "');}return p.join('');"
            );

        return data ? fn(data) : fn;
    };
})();
 

(function(factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function($) {
    $.timeago = function(timestamp) {
        if (timestamp instanceof Date) {
            return inWords(timestamp);
        } else if (typeof timestamp === "string") {
            return inWords($.timeago.parse(timestamp));
        } else if (typeof timestamp === "number") {
            return inWords(new Date(timestamp));
        } else {
            return inWords($.timeago.datetime(timestamp));
        }
    };
    var $t = $.timeago;

    $.extend($.timeago, {
        settings: {
            refreshMillis: 60000,
            allowPast: true,
            allowFuture: false,
            localeTitle: false,
            cutoff: 0,
            strings: {
                prefixAgo: null,
                prefixFromNow: null,
                suffixAgo: "önce",
                suffixFromNow: "şimdi",
                inPast: 'şimdi',
                seconds: "az",
                minute: "%d dakika",
                minutes: "%d dakika",
                hour: "%d saat",
                hours: "%d saat",
                day: "%d gün",
                days: "%d gün",
                month: "%d ay",
                months: "%d ay",
                year: "%d yıl",
                years: "%d yıl",
                wordSeparator: " ",
                numbers: []
            }
        },

        inWords: function(distanceMillis) {
            if (!this.settings.allowPast && !this.settings.allowFuture) {
                throw 'timeago allowPast and allowFuture settings can not both be set to false.';
            }

            var $l = this.settings.strings;
            var prefix = $l.prefixAgo;
            var suffix = $l.suffixAgo;
            if (this.settings.allowFuture) {
                if (distanceMillis < 0) {
                    prefix = $l.prefixFromNow;
                    suffix = $l.suffixFromNow;
                }
            }

            if (!this.settings.allowPast && distanceMillis >= 0) {
                return this.settings.strings.inPast;
            }

            var seconds = Math.abs(distanceMillis) / 1000;
            var minutes = seconds / 60;
            var hours = minutes / 60;
            var days = hours / 24;
            var years = days / 365;

            function substitute(stringOrFunction, number) {
                var string = $.isFunction(stringOrFunction) ? stringOrFunction(number, distanceMillis) : stringOrFunction;
                var value = ($l.numbers && $l.numbers[number]) || number;
                return string.replace(/%d/i, value);
            }

            var words = seconds < 45 && substitute($l.seconds, Math.round(seconds)) ||
                seconds < 90 && substitute($l.minute, 1) ||
                minutes < 45 && substitute($l.minutes, Math.round(minutes)) ||
                minutes < 90 && substitute($l.hour, 1) ||
                hours < 24 && substitute($l.hours, Math.round(hours)) ||
                hours < 42 && substitute($l.day, 1) ||
                days < 30 && substitute($l.days, Math.round(days)) ||
                days < 45 && substitute($l.month, 1) ||
                days < 365 && substitute($l.months, Math.round(days / 30)) ||
                years < 1.5 && substitute($l.year, 1) ||
                substitute($l.years, Math.round(years));

            var separator = $l.wordSeparator || "";
            if ($l.wordSeparator === undefined) { separator = " "; }
            return $.trim([prefix, words, suffix].join(separator));
        },

        parse: function(iso8601) {
            var s = $.trim(iso8601);
            s = s.replace(/\.\d+/, ""); // remove milliseconds
            s = s.replace(/-/, "/").replace(/-/, "/");
            s = s.replace(/T/, " ").replace(/Z/, " UTC");
            s = s.replace(/([\+\-]\d\d)\:?(\d\d)/, " $1$2"); // -04:00 -> -0400
            s = s.replace(/([\+\-]\d\d)$/, " $100"); // +09 -> +0900
            return new Date(s);
        },
        datetime: function(elem) {
            var iso8601 = $t.isTime(elem) ? $(elem).attr("datetime") : $(elem).attr("title");
            return $t.parse(iso8601);
        },
        isTime: function(elem) {
            // jQuery's `is()` doesn't play well with HTML5 in IE
            return $(elem).get(0).tagName.toLowerCase() === "time"; // $(elem).is("time");
        }
    });

    // functions that can be called via $(el).timeago('action')
    // init is default when no action is given
    // functions are called with context of a single element
    var functions = {
        init: function() {
            var refresh_el = $.proxy(refresh, this);
            refresh_el();
            var $s = $t.settings;
            if ($s.refreshMillis > 0) {
                this._timeagoInterval = setInterval(refresh_el, $s.refreshMillis);
            }
        },
        update: function(time) {
            var parsedTime = $t.parse(time);
            $(this).data('timeago', { datetime: parsedTime });
            if ($t.settings.localeTitle) $(this).attr("title", parsedTime.toLocaleString());
            refresh.apply(this);
        },
        updateFromDOM: function() {
            $(this).data('timeago', { datetime: $t.parse($t.isTime(this) ? $(this).attr("datetime") : $(this).attr("title")) });
            refresh.apply(this);
        },
        dispose: function() {
            if (this._timeagoInterval) {
                window.clearInterval(this._timeagoInterval);
                this._timeagoInterval = null;
            }
        }
    };

    $.fn.timeago = function(action, options) {
        var fn = action ? functions[action] : functions.init;
        if (!fn) {
            throw new Error("Unknown function name '" + action + "' for timeago");
        }
        // each over objects here and call the requested function
        this.each(function() {
            fn.call(this, options);
        });
        return this;
    };

    function refresh() {
        var data = prepareData(this);
        var $s = $t.settings;

        if (!isNaN(data.datetime)) {
            if ($s.cutoff == 0 || Math.abs(distance(data.datetime)) < $s.cutoff) {
                $(this).text(inWords(data.datetime));
            }
        }
        return this;
    }

    function prepareData(element) {
        element = $(element);
        if (!element.data("timeago")) {
            element.data("timeago", { datetime: $t.datetime(element) });
            var text = $.trim(element.text());
            if ($t.settings.localeTitle) {
                element.attr("title", element.data('timeago').datetime.toLocaleString());
            } else if (text.length > 0 && !($t.isTime(element) && element.attr("title"))) {
                element.attr("title", text);
            }
        }
        return element.data("timeago");
    }

    function inWords(date) {
        return $t.inWords(distance(date));
    }

    function distance(date) {
        return (new Date().getTime() - date.getTime());
    }

    // fix for IE6 suckage
    document.createElement("abbr");
    document.createElement("time");
}));

 
! function(e, t) {
    if ("function" == typeof define && define.amd) define(["exports", "module"], t);
    else if ("undefined" != typeof exports && "undefined" != typeof module) t(exports, module);
    else {
        var o = { exports: {} };
        t(o.exports, o), e.autosize = o.exports
    }
}(this, function(e, t) {
    "use strict";

    function o(e) {
        function t() { var t = window.getComputedStyle(e, null); "vertical" === t.resize ? e.style.resize = "none" : "both" === t.resize && (e.style.resize = "horizontal"), u = "content-box" === t.boxSizing ? -(parseFloat(t.paddingTop) + parseFloat(t.paddingBottom)) : parseFloat(t.borderTopWidth) + parseFloat(t.borderBottomWidth), i() }

        function o(t) {
            var o = e.style.width;
            e.style.width = "0px", e.offsetWidth, e.style.width = o, v = t, l && (e.style.overflowY = t), n()
        }

        function n() {
            var t = window.pageYOffset,
                o = document.body.scrollTop,
                n = e.style.height;
            e.style.height = "auto";
            var i = e.scrollHeight + u;
            return 0 === e.scrollHeight ? void(e.style.height = n) : (e.style.height = i + "px", document.documentElement.scrollTop = t, void(document.body.scrollTop = o))
        }

        function i() {
            var t = e.style.height;
            n();
            var i = window.getComputedStyle(e, null);
            if (i.height !== e.style.height ? "visible" !== v && o("visible") : "hidden" !== v && o("hidden"), t !== e.style.height) {
                var r = document.createEvent("Event");
                r.initEvent("autosize:resized", !0, !1), e.dispatchEvent(r)
            }
        }
        var r = void 0 === arguments[1] ? {} : arguments[1],
            d = r.setOverflowX,
            s = void 0 === d ? !0 : d,
            a = r.setOverflowY,
            l = void 0 === a ? !0 : a;
        if (e && e.nodeName && "TEXTAREA" === e.nodeName && !e.hasAttribute("data-autosize-on")) {
            var u = null,
                v = "hidden",
                f = function(t) { window.removeEventListener("resize", i), e.removeEventListener("input", i), e.removeEventListener("keyup", i), e.removeAttribute("data-autosize-on"), e.removeEventListener("autosize:destroy", f), Object.keys(t).forEach(function(o) { e.style[o] = t[o] }) }.bind(e, { height: e.style.height, resize: e.style.resize, overflowY: e.style.overflowY, overflowX: e.style.overflowX, wordWrap: e.style.wordWrap });
            e.addEventListener("autosize:destroy", f), "onpropertychange" in e && "oninput" in e && e.addEventListener("keyup", i), window.addEventListener("resize", i), e.addEventListener("input", i), e.addEventListener("autosize:update", i), e.setAttribute("data-autosize-on", !0), l && (e.style.overflowY = "hidden"), s && (e.style.overflowX = "hidden", e.style.wordWrap = "break-word"), t()
        }
    }

    function n(e) {
        if (e && e.nodeName && "TEXTAREA" === e.nodeName) {
            var t = document.createEvent("Event");
            t.initEvent("autosize:destroy", !0, !1), e.dispatchEvent(t)
        }
    }

    function i(e) {
        if (e && e.nodeName && "TEXTAREA" === e.nodeName) {
            var t = document.createEvent("Event");
            t.initEvent("autosize:update", !0, !1), e.dispatchEvent(t)
        }
    }
    var r = null;
    "undefined" == typeof window || "function" != typeof window.getComputedStyle ? (r = function(e) { return e }, r.destroy = function(e) { return e }, r.update = function(e) { return e }) : (r = function(e, t) { return e && Array.prototype.forEach.call(e.length ? e : [e], function(e) { return o(e, t) }), e }, r.destroy = function(e) { return e && Array.prototype.forEach.call(e.length ? e : [e], n), e }, r.update = function(e) { return e && Array.prototype.forEach.call(e.length ? e : [e], i), e }), t.exports = r
});

(function($) {
    'use strict'; 

    // Language
    var __ = function(msgid) {
        return window.i18n[msgid] || msgid;
    };
    /**
     * Create a new instance.
     *
     * @param {Object} element
     * @param {Object} options
     */
    window.Comments = function(element, options) {
        this.element = element;
        this.options = $.extend({}, Comments.defaults, options);

        this.initOptions();
        this.bindEvents();
    };

    /**
     * Default options.
     */
    Comments.defaults = {
        storageKey: 'comment_author',
        commentTemplateId: 'commentTemplate',
        paginationTemplateId: 'paginationTemplate',
        messages: {
            comment: '1 '+ __('Comment'),
            comments: '{num} '+ __('Comment'),
            nocomments: __('No comments yet'),
            error: 'Opps !',
        },
    };

    /**
     * Initialize options.
     */
    Comments.prototype.initOptions = function() {
        var o = this.options,
            el = this.element;

        o.list = el.find('.comments-list');
        o.form = el.find('form');
        o.sort = el.find('.comment-sorting');
        o.total = el.find('.comment-total');
        o.placeholder = el.find('.placeholder');
        o.pagination = el.find('.pagination-container');
        o.currentPage = this.getParam('page', 1);
        o.linkedComment = this.getParam('comment', 0);

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': this.options.csrfToken } });
    };

    /**
     * Bind events.
     */
    Comments.prototype.bindEvents = function() {
        var o = this.options;

        o.placeholder.on('click', this.showForm.bind(this));
        o.form.find('.cancel').on('click', this.hideForm.bind(this));
        this.element.on('keyup', 'textarea', this.characterCount.bind(this));
        this.element.on('click', '.captcha img', this.refreshCaptcha.bind(this));
        o.pagination.on('click', 'a', this.pageClick.bind(this));
        this.element.on('submit', '.post-form', this.formSubmit.bind(this));
        o.sort.on('click', 'a', this.sort.bind(this));

        // Comment events.
        o.list.on('click', '.reply', this.showReplyForm.bind(this));
        o.list.on('click', '.time, .parent', this.setLinkedComment.bind(this));
        o.list.on('click', '.collapse, .expand', this.toggleComment.bind(this));
        o.list.on('click', '.like, .dislike', this.vote.bind(this));
        o.list.on('click', '.quick-edit', this.showEditForm.bind(this));
        o.list.on('submit', '.edit-form', this.submitEditForm.bind(this));
        o.list.on('click', '.edit-form .cancel', this.hideEditForm.bind(this));
        o.list.on('click', '.comment-more', this.showComments.bind(this));
        o.list.on('click', '.spoiler-btn', this.showSpoiler.bind(this));

        this.selectSort();
        this.loadComments();
    };

    /**
     * Show form.
     */
    Comments.prototype.showForm = function(e) {
        this.getAuthor(this.options.form);
        this.options.placeholder.hide();
        this.options.form.show();

        autosize(this.options.form.find('textarea'));

    };

    /**
     * Hide form.
     */
    Comments.prototype.hideForm = function() {
        this.options.form.hide();
        this.clearForm(this.options.form);
        this.options.placeholder.show();
        autosize.destroy(this.options.form.find('textarea'));
    };

    /**
     * Textarea character count.
     */
    Comments.prototype.characterCount = function(e) {
        var textarea = $(e.target),
            form = textarea.closest('form'),
            value = textarea.val(),
            maxlength = parseInt(textarea.attr('maxlength')) || 0;

        if (!maxlength) return;

        if (value.length > maxlength) {
            textarea.val(value.substr(0, maxlength));
            form.find('.character-count').text(0);
        } else {
            form.find('.character-count').text(maxlength - value.length);
        }
    };

    /**
     * Refresh captcha.
     */
    Comments.prototype.refreshCaptcha = function() {
        var images = this.element.find('.captcha img');

        if (!images.length) return;

        this.element.find('input[name="captcha"]').val('');

        this.ajax('GET', 'captcha', {})
            .done(function(src) {
                images.attr('src', src);
            });
    };

    /**
     * Handle pagination page click.
     */
    Comments.prototype.pageClick = function(e) {
        e.preventDefault();

        var li = $(e.currentTarget).parent(),
            page = $(e.currentTarget).data('page');

        if (li.hasClass('disabled') || li.hasClass('active')) {
            e.preventDefault();
            return false;
        }

        window.location.hash = '#!page=' + page;

        $('body, html').animate({ scrollTop: this.options.list.offset().top - 20 }, 400);

        this.options.currentPage = page;
        this.options.linkedComment = 0;

        this.loadComments();
    }

    /**
     * Handle form submit.
     */
    Comments.prototype.formSubmit = function(e) {
        e.preventDefault();

        var self = this,
            form = $(e.target),
            data = form.serialize(),
            list = this.options.list,
            depth = form.parents('.comment-list').length + 1;

        if (form.find('input[name="parent_id"]').val().length) {
            list = form.parent().parent().parent().next('.comments-list').first();
        }

        form.find('.comment-alert').hide();

        this.disable(form);

        this.ajax('POST', data)
            .done(function(comment) {
                var $comment = self.renderComment(comment, null, depth);

                $comment.prependTo(list);

                self.highlight($comment);
                self.setTotal(self.options.total.data('total') + 1);

                if (!comment.author.id) {
                    self.setAuthor($.extend(comment.author, { name: name }));
                }

                form[0].reset();
                if (form.find('input[name="parent_id"]').val().length) {
                    form.find('.cancel').trigger('click');
                    form.hide();
                }


            })
            .fail(function(jqXHR) {
                self.alert(jqXHR.responseJSON || self.trans('error'), form);
            })
            .always(function() {
                self.enable(form);
            });
    };

    /**
     * Handle comment sorting.
     */
    Comments.prototype.sort = function(e) {
        e.preventDefault();

        this.options.currentPage = 1;
        this.options.linkedComment = 0;
        this.options.sortBy = $(e.currentTarget).attr('data-sort');

        this.selectSort();
        this.loadComments();
    };

    /**
     * Set select sort.
     */
    Comments.prototype.selectSort = function() {
        this.options.sort.find('a').removeClass('active');
        this.options.sort.find('[data-sort="' + this.options.sortBy + '"]').addClass('active');
    };

    /**
     * Load comments.
     */
    Comments.prototype.loadComments = function() {
        var self = this,
            data = {
                page: this.options.currentPage,
                post_id: this.options.content,
                type: this.options.type,
                linked: this.options.linkedComment,
                sort: this.options.sortBy,
            },
            toggleLoading = function() {
                self.element.find('.loader').toggle();
            };

        toggleLoading();

        this.ajax('POST', 'comments', data)
            .done(function(data) {
                self.options.list.fadeOut(0, function() {
                    self.options.list.html('');

                    self.renderComments(data.comments, self.options.list);
                    self.highlight(self.options.list);

                    self.options.list.find('.comments-list').show();

                    self.options.list.fadeIn(0, function() {
                        if (self.options.linkedComment) {
                            self.scrollToComment(self.options.linkedComment);
                        }
                    });
                });

                self.renderPagination(data);
            })
            .always(toggleLoading);
    };

    /**
     * Render comments.
     *
     * @param {Object} comments
     * @param {Object} list
     * @param {Object} parent
     */
    Comments.prototype.renderComments = function(comments, list, parent, depth) {
        var i, $comment;

        depth = depth || 1;

        for (i in comments) {
            $comment = this.renderComment(comments[i], parent, depth);

            $comment.appendTo(list);

            if (comments[i].id === this.options.linkedComment) {
                $comment.find('.linked').show();
            }

            if (comments[i].replies) {
                if (comments[i].replies.length > 2) {
                    $('<a href="javascript:;" class="comment-more" data-parent="' + comments[i].id + '">' + comments[i].replies.length + ' <span>yanıtı görüntüle</span> </a>').appendTo($comment.find('.comments-list'));
                }


                if (!parent) {
                    comments[i].replies = this.hierarchical(comments[i].replies, comments[i].id);
                }

                this.renderComments(comments[i].replies, $comment.find('.comments-list'), comments[i], depth + 1);
                $comment.find('.comments-list').children('li:gt(1)').addClass('comment-hide');
            }
        }

    };

    /**
     * @param  {Array}  comments
     * @param  {Number} parentId
     * @return {Object}
     */
    Comments.prototype.hierarchical = function(comments, parentId) {
        var i, comment, result = [];

        for (i in comments) {
            if (comments[i].parent_id === parentId) {
                comment = comments[i];
                comment.replies = this.hierarchical(comments, comment.id);
                result.push(comment);
            }
        }

        return result;
    };

    /**
     * Render comment.
     *
     * @param  {Object} comment
     * @param  {Object} parent
     * @return {Object}
     */
    Comments.prototype.renderComment = function(comment, parent, depth) {
        comment.parent = parent;
        comment.reply = this.options.replies;

        if (this.options.maxDepth && depth > this.options.maxDepth) {
            comment.reply = false;
        }

        var $comment = this.renderTemplate(comment, this.options.commentTemplateId);


        $comment.find('.timeago').timeago();

        return $comment;
    }

    /**
     * Render pagination.
     *
     * @param {Object} data
     */
    Comments.prototype.renderPagination = function(data) {
        this.setTotal(data.total ? data.total : 0);
        var pagination = data.pagination;

        if (!pagination || !pagination.per_page || pagination.total <= pagination.per_page) {
            return;
        }

        this.options.pagination.html(this.renderTemplate(pagination, this.options.paginationTemplateId));
    };

    /**
     * Set the total number of comments.
     *
     * @param {Number}
     */
    Comments.prototype.setTotal = function(value) {
        var total = value ? (value === 1 ? this.trans('comment') : this.trans('comments', { num: value })) : this.trans('nocomments');
        var o = this.options;
        if (value == 0) {
            $('.empty-total').text(total).data('total', value);
            o.sort.hide();
        } else {
            $('.empty-total').hide();
            o.sort.show();
        }
        this.options.total.text(total).data('total', value).show();
    };

    /**
     * Toggle comment.
     */
    Comments.prototype.toggleComment = function(e) {
        $(e.currentTarget).closest('.comment-list').toggleClass('collapsed');
    }

    /**
     * Vote comment.
     */
    Comments.prototype.vote = function(e) {
        e.preventDefault();

        var UP = 'up',
            DOWN = 'down',
            REMOVE_UP = '-up',
            REMOVE_DOWN = '-down',
            type,
            $el = $(e.currentTarget),
            $votes = $el.parent(),
            $responseBox = $(e.currentTarget).parent().parent().parent().find('.replybox'),
            $upvote = $votes.find('.like'),
            $downvote = $votes.find('.dislike'),
            $upvotes = $votes.find('.likes'),
            $downvotes = $votes.find('.dislikes'),
            upvotes = parseInt($upvotes.data('votes')),
            downvotes = parseInt($downvotes.data('votes')),
            setUpvotes = function(val) {
                $upvotes.data('votes', val).text(val || '');
            },
            setDownvotes = function(val) {
                $downvotes.data('votes', val).text(val || '');
            };
        if (this.options.form.length === 0) {
            $responseBox.html(this.renderTemplate({ message: '' }, 'alertTemplate')).slideDown(200);
            return false;
        }
        // Click on upvote.
        if ($el.hasClass('like')) {
            // Remove upvote.
            if ($el.hasClass('voted')) {
                $el.removeClass('voted');
                setUpvotes(upvotes - 1);
                type = REMOVE_UP;
            }
            // Upvote.
            else {
                type = UP;

                if ($downvote.hasClass('voted')) {
                    $downvote.removeClass('voted');
                    setDownvotes(downvotes - 1);
                }

                $el.addClass('voted');
                setUpvotes(upvotes + 1);
            }
        }
        // Click on downvote.
        else {
            // Remove downvote.
            if ($el.hasClass('voted')) {
                $el.removeClass('voted');
                setDownvotes(downvotes - 1);
                type = REMOVE_DOWN;
            }
            // Downvote.
            else {
                type = DOWN;

                if ($upvote.hasClass('voted')) {
                    $upvote.removeClass('voted');
                    setUpvotes(upvotes - 1);
                }

                $el.addClass('voted');
                setDownvotes(downvotes + 1);
            }
        }

        this.ajax('POST', 'vote', { id: $votes.closest('.comment-list').data('id'), type: type });
    };

    /**
     * Show reply form.
     */
    Comments.prototype.showReplyForm = function(e) {
        e.preventDefault();

        var replybox = $(e.currentTarget).parent().parent().parent().find('.replybox'),
            rootId = $(e.currentTarget).data('id'),
            parentId = $(e.currentTarget).data('parent');

        if (replybox.html().length) {
            return replybox.find('.cancel').trigger('click');
        } else if (this.options.form.length === 0) {
            replybox.html(this.renderTemplate({ message: '' }, 'alertTemplate')).slideDown(200);
        }


        var form = this.options.form.clone();

        form.find('.cancel').bind('click', this.hideReplyForm.bind(this));

        this.clearForm(form);
        form.appendTo(replybox);
        form.find('input[name="parent_id"]').val(parentId);
        form.find('input[name="spoiler"]').attr('id', parentId);
        form.find('.custom-control-label').attr('for', parentId);

        this.getAuthor(form);

        form.show();

        autosize(form.find('textarea'));
    }

    /**
     * Hide reply form.
     */
    Comments.prototype.hideReplyForm = function(e) {
        $(e.target).closest('form').remove();
    };

    /**
     * Show edit form.
     */
    Comments.prototype.showEditForm = function(e) {
        e.preventDefault();

        var body = $(e.currentTarget).closest('.comment-body'),
            form = body.find('.edit-form'),
            textarea = form.find('textarea');

        body.find('.comment-text').hide();
        textarea.val(textarea.data('content'));
        form.show();

        autosize(textarea);
    };
    /**
     * More Less
     */
    Comments.prototype.showComments = function(e) {
        e.preventDefault();
        var moreBtn = e.currentTarget;
        if ($(moreBtn).hasClass('less')) {
            $(moreBtn).removeClass('less');
            $(moreBtn).find('span').text('yanıtı göster');
            $('.comments-list[data-parent="' + $(moreBtn).attr('data-parent') + '"]').children('li:gt(1)').addClass('comment-hide');
        } else {
            $(moreBtn).addClass('less');
            $(moreBtn).find('span').text('yanıtı gizle');
            $('.comments-list[data-parent="' + $(moreBtn).attr('data-parent') + '"] li').removeClass('comment-hide');
        }

    };
    /**
     * Show spoiler
     */
    Comments.prototype.showSpoiler = function(e) {
        e.preventDefault();
        var target = $(e.currentTarget);
        var id = target.attr('data-id');
        target.hide();
        $('.comment-list[data-id="' + id + '"]').removeClass('spoiler');

    };

    /**
     * Hide edit form.
     */
    Comments.prototype.hideEditForm = function(e) {
        var body = $(e.currentTarget).closest('.comment-body');

        body.find('.edit-form').hide();
        body.find('.comment-text').show();
    }

    /**
     * Submit edit form.
     */
    Comments.prototype.submitEditForm = function(e) {
        e.preventDefault();

        var self = this,
            form = $(e.target),
            data = form.serialize(),
            body = form.closest('.comment-body'),
            text = body.find('.comment-text'),
            decode = function(str) {
                return $('<textarea/>').html(str).text();
            };

        form.find('.comment-alert').hide();
        this.disable(form);

        this.ajax('POST', data)
            .done(function(comment) {
                text.html(comment.comment);
                form.find('textarea').data('content', comment.comment);

                self.highlight(text);
                self.hideEditForm(e);

                if (comment.status !== '1') {
                    body.find('.on-hold').addClass('show');
                    body.find('.edit-menu').remove();
                }
            })
            .fail(function(jqXHR) {
                self.alert(jqXHR.responseJSON || self.trans('error'), form);
            })
            .always(function() {
                self.enable(form);
            });
    }

    /**
     * Clear form.
     *
     * @param {Object} form
     */
    Comments.prototype.clearForm = function(form) {
        form.find('.comment-alert').hide();
        form.find('input[type="text"], textarea').val('');
        form.find('.character-count').text(form.find('textarea').attr('maxlength'));
    };

    /**
     * Set linked comment.
     */
    Comments.prototype.setLinkedComment = function(e) {
        e.preventDefault();

        var target = $(e.currentTarget);

        if (target.data('parent')) {
            var comment = this.options.list.find('[data-id="' + target.data('parent') + '"]');
        } else {
            var comment = target.closest('.comment-list');
        }

        window.location.hash = '#!comment=' + comment.data('id');

        this.options.list.find('.linked').hide();

        comment.find('.linked').first().show();
    }

    /**
     * Scroll to linked comment.
     *
     * @param {Object} comment
     */
    Comments.prototype.scrollToComment = function(comment) {
        if (!(comment instanceof $)) {
            comment = this.options.list.find('[data-id="' + comment + '"]');
        }

        if (comment.length) {
            $('body, html').animate({ scrollTop: comment.offset().top - 20 }, 100);
        }
    };

    /**
     * Show alert.
     *
     * @param  {Array|String} message
     * @param  {Object}       form
     */
    Comments.prototype.alert = function(message, form) {
        form.find('.comment-alert')
            .html(this.renderTemplate({ message: message }, 'alertTemplate'))
            .fadeIn(0);
    };

    /**
     * Ajax helper.
     *
     * @param  {String} type
     * @param  {String} action
     * @param  {Object} data
     * @return {Object}
     */
    Comments.prototype.ajax = function(type, action, data) {
        if (data) {
            data._ACTION = action;
        } else {
            data = action;
        }

        return $.ajax({
            url: this.options.ajaxUrl,
            type: type,
            data: data,
            dataType: 'json',
        });
    }

    /**
     * Get param.
     *
     * @param  {String} name
     * @param  {Number} _default
     * @return {Number}
     */
    Comments.prototype.getParam = function(name, _default) {
        var val, fragment = this.extractParam('_escaped_fragment_', location.search);

        if (fragment) {
            val = this.extractParam(name, '#' + fragment, true);
        } else {
            val = this.extractParam(name, window.location.hash.replace('#!', '#'), true);
        }

        return parseInt(val) || _default;
    };

    /**
     * Extract param from query / hash.
     *
     * @param  {String}  name
     * @param  {String}  str
     * @param  {Boolean} hash
     * @return {String}
     */
    Comments.prototype.extractParam = function(name, str, hash) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');

        var regex = new RegExp((hash ? '[\\#]' : '[\\?&]') + name + '=([^&#]*)'),
            results = regex.exec(str);

        if (results) {
            return decodeURIComponent(results[1].replace(/\+/g, ' '));
        }

        return null;
    };

    /**
     * Remember author in the local storage.
     *
     * @param {Object} author
     */
    Comments.prototype.setAuthor = function(author) {
        author = { name: author.name, email: author.email, url: author.url };
        window.localStorage.setItem(this.options.storageKey, JSON.stringify(author));
    };

    /**
     * Get author from local storage and fill the form.
     *
     * @param {Object} $form
     */
    Comments.prototype.getAuthor = function($form) {
        var author = window.localStorage.getItem(this.options.storageKey);

        try {
            author = JSON.parse(author);
        } catch (error) {}

        if (author) {
            $form.find('input[name="author_name"]').val(author.name);
            $form.find('input[name="author_email"]').val(author.email);
            $form.find('input[name="author_url"]').val(author.url);
        }
    };

    /**
     * Render template.
     *
     * @param  {Object} data
     * @param  {String} templateId
     * @return {Object}
     */
    Comments.prototype.renderTemplate = function(data, templateId) {
        return $(tmpl(templateId, data));
    };

    /**
     * Translage message.
     *
     * @param  {String} message
     * @param  {Object} replace
     * @return {String}
     */
    Comments.prototype.trans = function(message, replace) {
        message = this.options.messages[message] || message.toString();

        if (replace) {
            $.each(replace, function(key, value) {
                message = message.replace('{' + key + '}', value);
            });
        }

        return message;
    };

    /**
     * Highlight code.
     *
     * @param {Object} $element
     */
    Comments.prototype.highlight = function($element) {
        if (window.Prism) {
            $('pre code').each(function(i, block) {
                Prism.highlightElement(block);
            });
        }
    }

    /**
     * Disable form inputs and buttons.
     *
     * @param {Object}  form
     * @param {Boolean} state
     */
    Comments.prototype.disable = function(form, state) {
        state = (state === undefined) ? true : state;

        form.find('button, input, textarea').prop('disabled', state);

        if ($.fn.button) {
            form.find('button[type="submit"]').button(state ? 'loading' : 'reset');
        }
    }

    /**
     * Enable form inputs and buttons.
     *
     * @param {Object} form
     */
    Comments.prototype.enable = function(form) {
        this.disable(form, false);
    }
})(jQuery);