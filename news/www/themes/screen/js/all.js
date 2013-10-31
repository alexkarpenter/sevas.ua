/* news_func.js  */

/* lightbox.js */
/*
 * 
 LightboxOptions

 Lightbox
 - constructor
 - init
 - enable
 - build
 - start
 - supportFullScreen
 - changeImage
 - sizeContainer
 - getImageSize
 - showImage
 - fullScreen
 - setFullScreen
 - updateNav
 - updateDetails
 - preloadNeigbhoringImages
 - enableKeyboardNav
 - disableKeyboardNav
 - keyboardAction
 - print
 - end

 options = new LightboxOptions
 lightbox = new Lightbox options
 */
(function () {
    var $ = jQuery, Lightbox, LightboxOptions, $lightbox, $image, _t;
    var winW = 800,	winH = 600, imgW, imgH, imgoW, imgoH, isfull = false;
    var pfx = ["webkit", "moz", "ms", "o", ""];
    LightboxOptions = (function () {
        function LightboxOptions() {
            this.fileCommentsImage = '/images/comments.png';
            this.fileLoadingImage = '/images/loading.gif';
            this.fileCloseImage = '/images/close.png';
            this.fileSaveImage = '/images/btn_download.png';
            this.resizeDuration = 4;
            this.fadeDuration = 1;
            this.labelImage = "";
            this.labelOf = "из";
            if ( navigator.userAgent.toLowerCase().indexOf('safari') == -1) {
                this.fulls = false;
            } else {
                this.fulls = true;
            }

            this.print = false;
        }
        return LightboxOptions;
    })();
    Lightbox = (function () {
        function Lightbox(options) {
            this.options = options;
            this.album = [];
            this.currentImageIndex = void 0;
            this.init();
        };
        Lightbox.prototype.init = function () {
            this.enable();

            return this.build();
        };
        Lightbox.prototype.enable = function () {
            return $('body').on('click', 'a[rel^=lightbox], area[rel^=lightbox], a[data-lightbox]', function (e) {
                _t.start($(e.currentTarget));
                return false;
            });
        };
        Lightbox.prototype.build = function () {
            _t = this;
            $("<div id='lightboxOverlay'></div><div id='lightbox'><div class='form_comments'><form id='form_comments'><div class='window-close'><a href='#'>Закрыть</a></div><textarea name='comment_text' class='comment_text'></textarea><div class='clean'></div><div class='comment_was_added'>Ваш комментарий был добавлен</div><input type='submit' name='submit_comment_text' class='submit_comment_text'><span>Чтобы добавить комментарий, авторизируйтесь!</span></form></div><div class='lb-nav'><a class='lb-prev'></a><a class='lb-next'></a></div><div class='lb-outerContainer'><div class='lb-container'><span class='lb-number'></span><a class='lb-close'>Нажмите Esc для выхода</a><img class='lb-image'/><div class='lb-loader'><a class='lb-cancel'><img src='"+this.options.fileLoadingImage+"' /></a></div></div><div class='lb-dataContainer'><div class='lb-data'><div class='lb-details'><span class='lb-caption'></span></div><!-div class='share42initSLIDE share42style'><span class='share42SLIDE'></span></div--><div class='lb-closeContainer'><a class='lb-save'><div class='save_image'></div></a><div class='comment_div'><a class='add_comment'>Оставить комментарий</a><img src='"+this.options.fileCommentsImage+"'/></div></div></div></div></div></div>").appendTo($('body'));

            $lightbox = $('#lightbox');
            $image = $lightbox.find('.lb-image');

            $save = $lightbox.find('.lb-save');

            $(".window-close a").click(function() {
                $(".form_comments").hide();
            });


            $('#lightbox').click(function(e){

                var elem = $(".lb-image");
                var elem2 = $(".form_comments");
                if(e.target!=elem[0]&&!elem.has(e.target).length&&e.target!=elem2[0]&&!elem2.has(e.target).length){
                    $(".comment_was_added").css("display", "none");
                    $(".form_comments").css("display", "none");
                    $("textarea.comment_text").val('');
                    //_t.end();
                    return false;
                }
            });

            $(".form_comments").css("display", "none");
            $(".comment_was_added").css("display", "none");
            $(".add_comment").click(function() {
                data = $.cookie('sevas_user_id');
                if(data && data !=0)
                {
                    $(".form_comments").css("display", "block");
                    $(".submit_comment_text").show();
                    $(".form_comments span").hide();
                    $(".comment_was_added").hide();
                }
                else
                {
                    $(".form_comments").css("display", "block");
                    $(".comment_was_added").hide();
                    $(".form_comments span").show();
                    $(".comment_text").hide();
                    $(".submit_comment_text").hide();

                }
            });


            if (this.options.print)
            {
                $('<div/>', {'class': 'lb-print'}).appendTo('.lb-closeContainer');
                $lightbox.find('.lb-print').on('click', _t.print);
            }
            $lightbox.hide().on('click', function (e) {
                if ($(e.target).attr('id') === 'lightbox') _t.end();
                return false;
            });
            $lightbox.find('.lb-outerContainer').on('click', function (e) {
                if ($(e.target).attr('id') === 'lightbox') _t.end();
                return false;
            });
            $lightbox.find('.lb-prev').on('click', function (e) {
                if(_t.currentImageIndex!==0)
                {
                    _t.changeImage(_t.currentImageIndex - 1);
                }
                else if(_t.currentImageIndex==0)
                {
                    _t.changeImage(_t.album.length-1);
                }
                return false;
            });
            $lightbox.find('.lb-next').on('click', function (e) {

                if(_t.currentImageIndex !== _t.album.length - 1){
                    _t.changeImage(_t.currentImageIndex + 1);
                }
                else if(_t.currentImageIndex == _t.album.length - 1){
                    _t.changeImage(0);
                }
                return false;
            });
            $lightbox.find('.lb-loader, .lb-close').on('click', function (e) {
                _t.end();
                return false;
            });
            $lightbox.find('.lb-save').on('click', function (e) {
                window.open(this.href, '_blank');
                return false;
            });

            $(".submit_comment_text").click(function() {
                var text = $("textarea.comment_text").val();
                $.post('/javascript/include_files/obr_comment_image.php', { text: text, link_image : $('.lb-save').attr('href') }, function(data) {
                    $("textarea.comment_text").val('');
                    $(".submit_comment_text").hide();
                    //$('#comments-answers-box').html(data);

                    if (data) $(".comment_was_added").css("display", "block");
                    //$(".form_comments").css("display", "none");

                });
            });


        };

        Lightbox.prototype.start = function ($link) {
            var a, i, imageNumber, _len, _ref;
            this.supportFullScreen();
            this.sizeOverlay();
            $(window).on("resize", this.sizeOverlay);
            $('select, object, embed').css('visibility', 'hidden');
            $('#lightboxOverlay').fadeIn(this.options.fadeDuration);
            this.album = [];
            imageNumber = 0;
            if ($link.attr('rel') === 'lightbox') {
                this.album.push({
                    link: $link.attr('href'),
                    title: $link.attr('title')
                });
            } else {
                _ref = $($link.prop("tagName") + '[rel="' + $link.attr('rel') + '"]');
                for (i = 0, _len = _ref.length; i < _len; i++) {
                    a = _ref[i];
                    this.album.push({
                        link: $(a).attr('href'),
                        title: $(a).attr('title')
                    });
                    if ($(a).attr('href') === $link.attr('href')) imageNumber = i;
                }
            }
            $lightbox.fadeIn(this.options.fadeDuration);
            this.changeImage(imageNumber);
        };



        Lightbox.prototype.supportFullScreen = function() {
            if (pfx.length != 5) return false;
            var pfx0 = ["IsFullScreen", "FullScreen"];
            var pfx1 = ["CancelFullScreen", "RequestFullScreen"];
            var p = 0, k, m, t = "undefined";
            while (p < pfx.length && !document[m]) {
                k = 0;
                while (k < pfx0.length) {
                    m = pfx0[k];
                    if (pfx[p] == "") {
                        m = m.substr(0, 1).toLowerCase() + m.substr(1);
                        pfx1[0] = pfx1[0].substr(0, 1).toLowerCase() + pfx1[0].substr(1);
                        pfx1[1] = pfx1[1].substr(0, 1).toLowerCase() + pfx1[1].substr(1);
                    }
                    m = pfx[p] + m;
                    t = typeof document[m];
                    if (t != "undefined") {
                        pfx = [pfx[p]+pfx1[0], pfx[p]+pfx1[1]];
                        isfull = (t == "function" ? document[m]() : document[m]);
                        return true;
                    }
                    k++;
                }
                p++;
            }
            pfx = false;
            return t;
        };
        Lightbox.prototype.changeImage = function (imageNumber) {
            this.disableKeyboardNav();
            $('#lightboxOverlay').fadeIn(this.options.fadeDuration);
            $('.loader').fadeIn('slow');
            $lightbox.find('.lb-image, .lb-nav, .lb-prev, .lb-next, .lb-dataContainer, .lb-numbers, .lb-caption').hide();
            $lightbox.find('.lb-outerContainer').addClass('animating');
            var preloader = new Image;
            preloader.onload = function () {
                var save_link;
                save_link=_t.album[imageNumber].link;
                save_link=save_link.replace('http://spravka.sevas.ru/', '/action/process_image.php?download=');
                $image.attr('src', _t.album[imageNumber].link);
                $save.attr('href', save_link);
                imgoW = preloader.width;
                imgoH = preloader.height;
                return _t.getImageSize();
            };
            preloader.src = this.album[imageNumber].link;
            this.currentImageIndex = imageNumber;
        };
        Lightbox.prototype.sizeOverlay = function () {
            if (!isfull || pfx == false) {
                if (window.innerWidth && window.innerHeight) {
                    winW = window.innerWidth;
                    winH = window.innerHeight;
                } else if (document.compatMode == 'CSS1Compat' && document.documentElement && document.documentElement.offsetWidth) {
                    winW = document.documentElement.offsetWidth;
                    winH = document.documentElement.offsetHeight;
                } else if (document.body && document.body.offsetWidth) {
                    winW = document.body.offsetWidth;
                    winH = document.body.offsetHeight;
                }
            }
            return $('#lightboxOverlay').width(winW).height(winH);
        };
        Lightbox.prototype.getImageSize = function () {
            var wW = winW, wH = winH;
            if (isfull) {
                if (pfx != false) {
                    wW = screen.width;
                    wH = screen.height;
                }
            }
            else {
                wW *= 0.9;
                wH *= 0.8;
            }
            imgW = imgoW;
            imgH = imgoH;
            if (imgW > wW) {
                imgH = (wW * imgH) / imgW;
                imgW = wW;
            }
            if (imgH > wH) {
                imgW = (wH * imgW) / imgH;
                imgH = wH;
            }
            if (isfull) {
                var imgM = (wH - imgH) / 2;
                if (imgM < 0) imgM = 0;
                $lightbox.find('.lb-image').css('margin', imgM + 'px auto');
            }
            this.sizeContainer(imgW, imgH);
        }
        Lightbox.prototype.sizeContainer = function (imageWidth, imageHeight) {
            var $container, $outerContainer, containerBottomPadding, containerLeftPadding, containerRightPadding, containerTopPadding, newHeight, newWidth, oldHeight, oldWidth;
            $outerContainer = $lightbox.find('.lb-outerContainer');
            if (isfull) {  _t.disableKeyboardNav(); return _t.showImage();};
            $image.css('margin', '0');
            oldWidth = $outerContainer.outerWidth();
            oldHeight = $outerContainer.outerHeight();
            $container = $lightbox.find('.lb-container');
            containerTopPadding = parseInt($container.css('padding-top'), 10);
            containerRightPadding = parseInt($container.css('padding-right'), 10);
            containerBottomPadding = parseInt($container.css('padding-bottom'), 10);
            containerLeftPadding = parseInt($container.css('padding-left'), 10);
            newWidth = imageWidth + containerLeftPadding + containerRightPadding;
            newHeight = imageHeight + containerTopPadding + containerBottomPadding;
            if (newWidth !== oldWidth && newHeight !== oldHeight) {
                $outerContainer.animate({
                    width: newWidth,
                    height: newHeight
                }, this.options.resizeDuration, 'swing');
            } else if (newWidth !== oldWidth) {
                $outerContainer.animate({
                    width: newWidth
                }, this.options.resizeDuration, 'swing');
            } else if (newHeight !== oldHeight) {
                $outerContainer.animate({
                    height: newHeight
                }, this.options.resizeDuration, 'swing');
            }
            setTimeout(function () {
                $lightbox.find('.lb-dataContainer').width(newWidth);
                $lightbox.find('.lb-prevLink').height(newHeight);
                $lightbox.find('.lb-nextLink').height(newHeight);
                _t.showImage();
            }, this.options.resizeDuration);
        };
        Lightbox.prototype.showImage = function () {
            $lightbox.find('.lb-loader').hide();
            $image.fadeIn('fast');
            this.updateNav();
            this.updateDetails();
            this.preloadNeighboringImages();
            this.disableKeyboardNav();
            this.enableKeyboardNav();
        };
        Lightbox.prototype.fullScreen = function () {
            if (isfull) {
                $image.hide();
                $lightbox.find('.lb-dataContainer').hide();
                _t.setFullScreen(document, false);
                $lightbox.find('.lb-outerContainer').attr('style', '');
            } else {
                _t.setFullScreen(document.getElementById("lightbox"), true);
                $lightbox.find('.lb-outerContainer').attr('style', 'height: 100%;');
                $lightbox.find('.lb-dataContainer').attr('style', 'width: 100%');
            }
            _t.getImageSize();
        };
        Lightbox.prototype.setFullScreen = function(obj, id) {
            isfull = id;
            if (id) {
                $('#lightbox').attr("class", "full-screen");
                $('.lb-number').css({"top": "10px", "left": "10px"});
                if (pfx != false) obj[pfx[1]]();
            } else {
                $('#lightbox').attr("class", "");
                $('.lb-number').css({"top": "-10px", "left": "0px"});
                if (pfx != false) obj[pfx[0]]();
            }
        };
        Lightbox.prototype.updateNav = function () {
            $lightbox.find('.lb-nav').show();
            //if (this.currentImageIndex > 0)
            $lightbox.find('.lb-prev').show();
            //if (this.currentImageIndex < this.album.length - 1)
            $lightbox.find('.lb-next').show();
        };
        Lightbox.prototype.updateDetails = function () {
            if (typeof this.album[this.currentImageIndex].title !== 'undefined' && this.album[this.currentImageIndex].title !== "")
                $lightbox.find('.lb-caption').html(this.album[this.currentImageIndex].title).fadeIn('fast');
            if (this.album.length > 1){
                $lightbox.find('.lb-number').html(this.options.labelImage + ' ' + (this.currentImageIndex + 1) + ' ' + this.options.labelOf + '  ' + this.album.length).fadeIn('fast');
            }
            else
                $lightbox.find('.lb-number').hide();
            $lightbox.find('.lb-outerContainer').removeClass('animating');
            $lightbox.find('.lb-dataContainer').fadeIn(this.resizeDuration, function () {
                return _t.sizeOverlay();
            });
        };

        Lightbox.prototype.preloadNeighboringImages = function () {
            var preloadNext, preloadPrev;
            if (this.album.length > this.currentImageIndex + 1) {
                preloadNext = new Image;
                preloadNext.src = this.album[this.currentImageIndex + 1].link;
            }
            if (this.currentImageIndex > 0) {
                preloadPrev = new Image;
                preloadPrev.src = this.album[this.currentImageIndex - 1].link;
            }
        };
        Lightbox.prototype.enableKeyboardNav = function () {
            $(document).on('keyup.keyboard', $.proxy(this.keyboardAction, this));
        };
        Lightbox.prototype.disableKeyboardNav = function () {
            $(document).off('.keyboard');
        };
        Lightbox.prototype.keyboardAction = function (event) {
            var KEYCODE_ESC, KEYCODE_LEFTARROW, KEYCODE_RIGHTARROW, key, keycode;
            KEYCODE_ESC = 27;
            KEYCODE_LEFTARROW = 37;
            KEYCODE_RIGHTARROW = 39;
            keycode = event.keyCode;
            key = String.fromCharCode(keycode).toLowerCase();
            if (keycode === KEYCODE_ESC) {
                this.end();
            } else if (keycode === KEYCODE_LEFTARROW) {
                if (this.currentImageIndex !== 0)
                    this.changeImage(this.currentImageIndex - 1);
                else if(this.currentImageIndex == 0)
                {
                    this.changeImage(this.album.length-1);
                }
            } else if (keycode === KEYCODE_RIGHTARROW) {
                if (this.currentImageIndex !== this.album.length - 1)
                    this.changeImage(this.currentImageIndex + 1);
                else if(this.currentImageIndex == this.album.length - 1)
                {
                    this.changeImage(0);
                }
            }
        };
        Lightbox.prototype.print = function () {
            win = window.open();
            self.focus();
            win.document.open();
            win.document.write('<html><body stlye="margin:0 auto; padding:0;">');
            win.document.write('<div align="center" style="margin: 0 auto;"><img src="' + $image.attr("src") + '" style="max-width: 100%; max-height: 90%;"/><br>' + $lightbox.find('.lb-caption').html() + '</div>');
            win.document.write('</body></html>');
            win.document.close();
            win.print();
            win.close();
        };
        Lightbox.prototype.end = function () {
            if (isfull) this.fullScreen();
            this.disableKeyboardNav();
            $(window).off("resize", this.sizeOverlay);
            $lightbox.fadeOut(this.options.fadeDuration);
            $('#lightboxOverlay').fadeOut(this.options.fadeDuration);
            $('#lightboxOverlay').css('visibility', 'hide');
            return $('select, object, embed').css('visibility', 'visible');
        };
        return Lightbox;
    })();
    $(function () {
        var lightbox, options;
        options = new LightboxOptions;
        return lightbox = new Lightbox(options);
    });
}).call(this);

function lighboxstart(rel,href)
{
    $("[href = \'"+href+"\'][rel = \'"+rel+"\']").click();
}

$(document).ready(function(){
    $(window).scroll(function () {
        var st=$(window).scrollTop();
        if(st>$("#header").height()) {
            $("#test").html("<div class='test'><span>наверх</span></div>");
        }
        else{
            $("#test").html("");
        }
    });
    setInterval( function(){
        var hours = new Date().getHours();
        var mins = new Date().getMinutes();
        mins = ''+mins+'';
        if(mins.length < 2)
        {
            mins = '0' + new Date().getMinutes();
        }
        else  mins = new Date().getMinutes();
        $("#head_time").html(hours+ '<span>:</span>' + mins);
    }, 1000 );

    $("#test").click(function() {
        jQuery("html,body").animate({scrollTop: 0}, 500);
    });

    (function initTabs(){
        if($('.login-popup').size()){
            $('.login-popup .tab-set li a').click(function(e){
                if (!$(this).parents('.tab-set li').hasClass('active')) {
                    $(this).parents('.login-popup')
                        .find('.tab-body > .tab').hide()
                        .eq($(this).parents('li').siblings('li.active').removeClass('active')
                            .end().addClass('active').index())
                        .show();
                    //$(window).trigger('resize');
                }
                e.preventDefault();
            });
        }
    })();

    (function scrollToTop() {
        $('.up-btn').click(function(e) {
            $('body,html').stop().animate({'scrollTop': 0}, 700);
            e.preventDefault();
        });
    })();

    (function showGalleryThumbs() {
        $(".opener-img-wrap").hide();
        $(".hide-img-wrap").hide();
        $(".img-listing li").hide();
        $(".img-listing").css("display", "none");
        $(".opener-list-img").click(function(e) {
            $(".img-listing").css("display", "block");
            var count_elem = $(".img-listing li");
            var start = $(".img-listing li:lt(16)");
            start.slideDown(500);
            $(this).fadeTo(400, 0)
            if (count_elem['length'] > 16)
            {
                $(".opener-img-wrap").show();
            }
            $(".hide-img-wrap").show();
            e.preventDefault();
        });
        $('.hide-img-listing').click(function(e) {
            $('.img-listing').slideUp(400, function() {
                $(this).find('li:gt(17)').hide();
            });
            $('.opener-img-listing').fadeTo(400, 1);
            $('.opener-list-img').fadeTo(400, 1);
            $(".opener-img-wrap").hide();
            $(".hide-img-wrap").hide();
            e.preventDefault();
        });
        $('.opener-img-listing').click(function(e) {
            var hidden = $(this).parent().prev().find('li:hidden');
            if (hidden.size()) {
                var items = hidden.filter(':lt(16)').show(),
                    h = items.parent().height();
                items.hide();
                items.parent().animate({'height': h}, 500);
                items.fadeTo(500, 1, function() {
                    items.parent().removeAttr('style');
                });
            }
            if (!hidden.siblings(':hidden').size()) {
                $(this).fadeTo(400, 0);
                $('.opener-img-listing').hide();
            }
            e.preventDefault();
        });
    })();
    (function popup(){
        if($(".reg-tab").html()=='Регистрация'){
            $('body').popup({
                'opener': '.top-panel .opener-popup:not(.reg-tab)'
            }).popup({
                    'opener': '.login-row .opener-popup',
                    offset: -35
                });

            $('.top-panel .reg-tab').click(function(e) {
                $(this).prev().trigger('click');
                $('#login-popup-wrap .tab-set li:last a').trigger('click');
                e.preventDefault();
            });

            $('.top-panel .opener-popup:not(.reg-tab)').click(function(e) {
                $('#login-popup-wrap .tab-set li:first a').trigger('click');
                $('#succes_msg').css('display', 'none');
                $('#reg_aria').css('display', 'block');
            });
            $('.login-row .opener-popup:last').click(function(e) {
                $('#login-popup-wrap .tab-set li:last a').trigger('click');
            });
            $('.login-row .opener-popup:first').click(function(e) {
                $('#login-popup-wrap .tab-set li:first a').trigger('click');
            });
        }
    })();

    (function lightbox() {
        //$('.lightbox-wrapper').popupGallery();
        $('.img-listing li').click(function(e) {
            $(this).addClass('active').siblings().removeClass('active')
        });
    })();
})
function outNews(count){
    $.ajax({
        url: "/news/index",
        type: "GET",
        data: {count:count},
        async: true,
        success: function(data){
            $('div.article-list').html(data);
        }
    });
}


$.fn.popupGallery = function(o) {
    var o = $.extend({
        "popup": ".lightbox",
        "close_btn": ".close",
        "photo_list": '.img-listing li a',
        "gallery_list": ".visual-holder",
        "nextBtn": ".next",
        "prevBtn": ".prev",
        "itemHTML": "<div></div>",
        "desc": ".paste",
        "close": function() {
        },
        "beforeOpen": function() {
        }
    }, o);
    return this.each(function() {
        var popup_holder = $(this),
            opener = $(o.opener),
            itemHTML = $(o.itemHTML),
            nextBtn = $(o.nextBtn, popup_holder),
            prevBtn = $(o.prevBtn, popup_holder),
            gallery_list = $(o.gallery_list, popup_holder),
            desc = $(o.desc, popup_holder),
            popup = $(o.popup, popup_holder),
            photo_list = $(o.photo_list),
            close = $(o.close_btn, popup),
            group = photo_list.attr('rel') ? $("a[rel=" + photo_list.attr('rel') + "]") : photo_list,
            newImg = 0,
            activeLink = 0,
            bg = $('.bg', popup_holder);
        popup.css('margin', 0);
        gallery_list.find('>*').remove();
        photo_list.click(function(e) {
            group = $(this).attr('rel') ? $("a[rel=" + $(this).attr('rel') + "]") : photo_list.not('a[rel]');
            setNewImg.apply(this);
            activeLink = $(this);
            ifImgExists(function executeThis() {
                loadImg(newImg, function h() {
                    popup_holder.fadeIn(400);
                    $(this).parent().show();
                    gallery_list.height($(this).height());
                    $(this).css('left', (gallery_list.width() - $(this).width()) / 2);
                    $(this).off('load', h);
                    alignPopup();
                    bgResize();
                    setNum();
                });
                //setArrowImg();
            });
            o.beforeOpen.apply(this, [popup_holder]);
            setDesc();
            hideArrowIfImgEnd();
            e.preventDefault();
        });
        nextBtn.add(prevBtn).click(function(e) {
            if (!gallery_list.find(':animated').size()) {
                var nextLink = 0, _this = $(this);
                ifBtnIs(this, function next() {
                    setNewImg.apply(nextLink = getNext(1));
                }, function prev() {
                    setNewImg.apply(nextLink = getNext(-1));
                });
                ifImgExists(function executeThis() {
                    loadImg(newImg, function h() {
                        popup_holder.show();
                        gallery_list.height(this.height);
                        $(this).css('left', (gallery_list.width() - this.width) / 2);
                        fadeImg(_this.get(0));
                        $(this).off('load', h);
                    });
                    activeLink = nextLink;
                    setNum();
                    //setArrowImg();
                });
                hideArrowIfImgEnd(this);
                setDesc();
            }
            e.preventDefault();
        });
        function getNext(num) {
            var index = group.index(activeLink) + num;
            if (index < 0) {
                index = 0;
            }
            if (index > group.size() - 1) {
                index = group.size() - 1;
            }
            return group.eq(index);
        }
        function setNum() {
            popup.find('.num').html('<span class="index">' + (activeLink.parent().index() + 1) + '</span> РёР· <span class="last">' + group.size() + '</span>');
        }
        function ifImgExists(f) {
            if (newImg)
                f();
        }
        function setArrowImg() {
            var nextArrowImg = 0,
                prevArrowImg = 0;
            nextArrowImg = getNext(1).find('img.min').attr('src');
            prevArrowImg = getNext(-1).find('img.min').attr('src');
            nextBtn.find('img').attr('src', nextArrowImg);
            prevBtn.find('img').attr('src', prevArrowImg);
        }
        function setDesc() {
            desc.html(activeLink.find('img').attr('title'));
        }
        function hideArrowIfImgEnd(btn) {
            nextBtn.add(prevBtn).removeClass('disable');
            if (btn) {
                ifBtnIs(btn, function next() {
                        if (activeLink.get(0) === group.last().get(0))
                            nextBtn.addClass('disable');
                    },
                    function prev() {
                        if (activeLink.get(0) === group.first().get(0))
                            prevBtn.addClass('disable');
                    });
            } else {
                if (activeLink.get(0) === group.last().get(0))
                    nextBtn.addClass('disable');
                if (activeLink.get(0) === group.first().get(0))
                    prevBtn.addClass('disable');
            }
        }
        function ifBtnIs(btn, next, prev) {
            if (btn === nextBtn.get(0)) {
                next();
            } else {
                prev();
            }
        }
        function fadeImg(btn) {
            ifBtnIs(btn, function next() {
                    gallery_list.find(itemHTML.get(0).tagName.toLowerCase()).last().fadeIn(400, function() {
                        $(this).siblings().stop().remove();
                    });
                },
                function prev() {
                    gallery_list.find(itemHTML.get(0).tagName.toLowerCase()).last().fadeIn(400, function() {
                        $(this).siblings().stop().remove();
                    });
                });
        }
        function setNewImg() {
            newImg = $(this).attr('href');
        }
        function loadImg(src, complete) {
            var img = new Image();
            img.src = src;
            insertImage(false, img);
            if (img.complete) {
                //alert("img cached");
                complete.apply(img);
            } else {
                //alert("img not cached");
                $(img).load(function() {
                    complete.apply(img);
                });
            }
        }
        function insertImage(fast, img) {
            if (fast) {
                gallery_list.html(itemHTML.clone().html(img));
            } else {
                gallery_list.append(itemHTML.clone().html(img).hide());
            }
        }
        function alignPopup() {
            if ((($(window).height() / 2) - (popup.outerHeight() / 2)) + $(window).scrollTop() < 0) {
                popup.css({'top': 0, 'left': (($(window).width() - popup.outerWidth()) / 2) + $(window).scrollLeft()});
                return false;
            }
            popup.css({
                'top': (($(window).height() - popup.outerHeight()) / 2) + $(window).scrollTop(),
                'left': (($(window).width() - popup.outerWidth()) / 2) + $(window).scrollLeft()
            });
        }
        function bgResize() {
            var _w = $(window).width(),
                _h = $(document).height();
            bg.css({"height": _h, "width": _w + $(window).scrollLeft()});
        }
        $(window).resize(function() {
            if (popup_holder.is(":visible")) {
                alignPopup();
            }
        });
        if (popup_holder.is(":visible")) {
            alignPopup();
        }
        close.add(bg).click(function(e) {
            var closeEl = this;
            popup_holder.fadeOut(400, function() {
                o.close.apply(closeEl, [popup_holder]);
            });
            e.preventDefault();
        });
        $('body').keydown(function(e) {
            if (e.keyCode == '27') {
                popup_holder.fadeOut(400);
            }
        })
    });
}
$.fn.popup = function(o) {
    var o = $.extend({
        "opener": ".opener-popup:not(.reg-tab)",
        "popup_holder": "#login-popup-wrap",
        "popup": ".login-popup",
        "close_btn": ".close",
        "close": function() {
        },
        "beforeOpen": function() {
        }
    }, o);
    return this.each(function() {
        var container = $(this),
            opener = $(o.opener, container),
            popup_holder = $(o.popup_holder, container),
            popup = $(o.popup, popup_holder),
            close = $(o.close_btn, popup),
            bg = $('.bg', popup_holder);
        popup.css('margin', 0);
        opener.click(function(e) {
            o.beforeOpen.apply(this, [popup_holder]);
            popup_holder.fadeIn(400);
            alignPopup();
            bgResize();
            e.preventDefault();
        });
        function alignPopup() {
            /*
             if((($(window).height() / 2) - (popup.outerHeight() / 2))+ $(window).scrollTop()<0){
             popup.css({'top':0,'left': (($(window).width() - popup.outerWidth())/2) + $(window).scrollLeft()});
             return false;
             }
             popup.css({
             'top': (($(window).height()-popup.outerHeight())/2) + $(window).scrollTop(),
             'left': (($(window).width() - popup.outerWidth())/2) + $(window).scrollLeft()
             });
             */
            popup.css({
                'top': opener.offset().top + 10,
                'left': opener.offset().left - 7
            });
        }
        function bgResize() {
            var _w = $(window).width(),
                _h = $(document).height();
            bg.css({"height": _h, "width": _w + $(window).scrollLeft()});
        }
        $(window).resize(function() {
            if (popup_holder.is(":visible")) {
                bgResize();
                alignPopup();
            }
        });
        if (popup_holder.is(":visible")) {
            bgResize();
            alignPopup();
        }
        close.add(bg).click(function(e) {
            var closeEl = this;
            popup_holder.fadeOut(400, function() {
                o.close.apply(closeEl, [popup_holder]);
            });
            e.preventDefault();
        });
        $('body').keydown(function(e) {
            if (e.keyCode == '27') {
                popup_holder.fadeOut(400);
            }
        })
    });
}
jQuery.fn.galleryScroll = function(_options){
    var _options = jQuery.extend({
        btPrev: 'a.prev',
        btNext: 'a.next',
        holderList: '.holder',
        scrollElParent: 'ul',
        scrollEl: 'li',
        slideNum: '.switcher',
        duration : 1000,
        step: false,
        circleSlide: true,
        disableClass: 'disable',
        funcOnclick: null,
        autoSlide:false,
        innerMargin:0,
        stepWidth:false
    },_options);
    return this.each(function(){
        var _this = jQuery(this);
        var _holderBlock = jQuery(_options.holderList,_this);
        var _gWidth = _holderBlock.width();
        var _animatedBlock = jQuery(_options.scrollElParent,_holderBlock);
        var _liWidth = jQuery(_options.scrollEl,_animatedBlock).outerWidth(true);
        var _liSum = jQuery(_options.scrollEl,_animatedBlock).length * _liWidth;
        _liSum-=parseInt(jQuery(_options.scrollEl,_animatedBlock).css('margin-right'));
        var _margin = -_options.innerMargin;
        var f = 0;
        var _step = 0;
        var _autoSlide = _options.autoSlide;
        var _timerSlide = null;
        if (!_options.step) _step = _gWidth; else _step = _options.step*_liWidth;
        if (_options.stepWidth) _step = _options.stepWidth;

        if (!_options.circleSlide) {
            if (_options.innerMargin == _margin)
                jQuery(_options.btPrev,_this).addClass('prev-'+_options.disableClass);
        }
        if (_options.slideNum && !_options.step) {
            var _lastSection = 0;
            var _sectionWidth = 0;
            while(_sectionWidth < _liSum)
            {
                _sectionWidth = _sectionWidth + _gWidth;
                if(_sectionWidth > _liSum) {
                    _lastSection = _sectionWidth - _liSum;
                }
            }
        }
        if (_autoSlide) {
            _timerSlide = setTimeout(function(){
                autoSlide(_autoSlide);
            }, _autoSlide);
            _animatedBlock.hover(function(){
                clearTimeout(_timerSlide);
            }, function(){
                _timerSlide = setTimeout(function(){
                    autoSlide(_autoSlide)
                }, _autoSlide);
            });
        }
        jQuery(_options.btNext,_this).unbind('click');
        jQuery(_options.btPrev,_this).unbind('click');
        jQuery(_options.btNext,_this).bind('click',function(e){
            jQuery(_options.btPrev,_this).removeClass('prev-'+_options.disableClass);
            if (!_options.circleSlide) {
                if (_margin + _step  > _liSum - _gWidth - _options.innerMargin) {
                    if (_margin != _liSum - _gWidth - _options.innerMargin) {
                        _margin = _liSum - _gWidth  + _options.innerMargin;
                        jQuery(_options.btNext,_this).addClass('next-'+_options.disableClass);
                        _f2 = 0;
                    }
                } else {
                    _margin = _margin + _step;
                    if (_margin == _liSum - _gWidth - _options.innerMargin) {
                        jQuery(_options.btNext,_this).addClass('next-'+_options.disableClass);_f2 = 0;
                    }
                }
            } else {
                if (_margin + _step  > _liSum - _gWidth + _options.innerMargin) {
                    if (_margin != _liSum - _gWidth + _options.innerMargin) {

                        _margin = _liSum - _gWidth  + _options.innerMargin;
                    } else {
                        _f2 = 1;
                        _margin = -_options.innerMargin;

                    }
                } else {
                    _margin = _margin + _step;
                    _f2 = 0;
                }
            }

            _animatedBlock.animate({marginLeft: -_margin+"px"}, {queue:false,duration: _options.duration });

            if (_timerSlide) {
                clearTimeout(_timerSlide);
                _timerSlide = setTimeout(function(){
                    autoSlide(_options.autoSlide)
                }, _options.autoSlide);
            }

            if (_options.slideNum && !_options.step) jQuery.fn.galleryScroll.numListActive(_margin,jQuery(_options.slideNum, _this),_gWidth,_lastSection);
            if (jQuery.isFunction(_options.funcOnclick)) {
                _options.funcOnclick.apply(_this);
            }
            e.preventDefault();
        });
        var _f2 = 1;
        jQuery(_options.btPrev, _this).bind('click',function(e){
            jQuery(_options.btNext,_this).removeClass('next-'+_options.disableClass);
            if (_margin - _step >= -_step - _options.innerMargin && _margin - _step <= -_options.innerMargin) {
                if (_f2 != 1) {
                    _margin = -_options.innerMargin;
                    _f2 = 1;
                } else {
                    if (_options.circleSlide) {
                        _margin = _liSum - _gWidth  + _options.innerMargin;
                        f=1;_f2=0;
                    } else {
                        _margin = -_options.innerMargin
                    }
                }
            } else if (_margin - _step < -_step + _options.innerMargin) {
                _margin = _margin - _step;
                f=0;
            }
            else {_margin = _margin - _step;f=0;};

            if (!_options.circleSlide && _margin == _options.innerMargin) {
                jQuery(this).addClass('prev-'+_options.disableClass);
                _f2=0;
            }

            if (!_options.circleSlide && _margin == -_options.innerMargin) jQuery(this).addClass('prev-'+_options.disableClass);
            _animatedBlock.animate({marginLeft: -_margin + "px"}, {queue:false, duration: _options.duration});

            if (_options.slideNum && !_options.step) jQuery.fn.galleryScroll.numListActive(_margin,jQuery(_options.slideNum, _this),_gWidth,_lastSection);

            if (_timerSlide) {
                clearTimeout(_timerSlide);
                _timerSlide = setTimeout(function(){
                    autoSlide(_options.autoSlide)
                }, _options.autoSlide);
            }

            if (jQuery.isFunction(_options.funcOnclick)) {
                _options.funcOnclick.apply(_this);
            }
            e.preventDefault();
        });

        if (_liSum <= _gWidth) {
            jQuery(_options.btPrev,_this).addClass('prev-'+_options.disableClass).unbind('click');
            jQuery(_options.btNext,_this).addClass('next-'+_options.disableClass).unbind('click');
        }
        // auto slide
        function autoSlide(autoSlideDuration){
            //if (_options.circleSlide) {
            jQuery(_options.btNext,_this).trigger('click');
            //}
        };
        // Number list
        jQuery.fn.galleryScroll.numListCreate = function(_elNumList, _liSumWidth, _width, _section){
            var _numListElC = '';
            var _num = 1;
            var _difference = _liSumWidth + _section;
            while(_difference > 0)
            {
                _numListElC += '<li><a href="">'+_num+'</a></li>';
                _num++;
                _difference = _difference - _width;
            }
            jQuery(_elNumList).html('<ul class="control">'+_numListElC+'</ul>');
        };
        jQuery.fn.galleryScroll.numListActive = function(_marginEl, _slideNum, _width, _section){
            if (_slideNum) {
                jQuery('a',_slideNum).removeClass('active');
                var _activeRange = _width - _section-1;
                var _n = 0;
                if (_marginEl != 0) {
                    while (_marginEl > _activeRange) {
                        _activeRange = (_n * _width) -_section-1 + _options.innerMargin;
                        _n++;
                    }
                }
                var _a  = (_activeRange+_section+1 + _options.innerMargin)/_width - 1;
                jQuery('a',_slideNum).eq(_a).addClass('active');
            }
        };
        if (_options.slideNum && !_options.step) {

            jQuery.fn.galleryScroll.numListCreate(jQuery(_options.slideNum, _this), _liSum, _gWidth,_lastSection);
            jQuery.fn.galleryScroll.numListActive(_margin, jQuery(_options.slideNum, _this),_gWidth,_lastSection);
            numClick();
        };
        function numClick() {
            jQuery(_options.slideNum, _this).find('a').click(function(e){
                jQuery(_options.btPrev,_this).removeClass('prev-'+_options.disableClass);
                jQuery(_options.btNext,_this).removeClass('next-'+_options.disableClass);

                var _indexNum = jQuery(_options.slideNum, _this).find('a').index(jQuery(this));
                _margin = (_step*_indexNum) - _options.innerMargin;
                f=0; _f2=0;
                if (_indexNum == 0) _f2=1;
                if (_margin + _step > _liSum) {
                    _margin = _margin - (_margin - _liSum) - _step + _options.innerMargin;
                    if (!_options.circleSlide) jQuery(_options.btNext, _this).addClass('next-'+_options.disableClass);
                }
                _animatedBlock.animate({marginLeft: -_margin + "px"}, {queue:false, duration: _options.duration});

                if (!_options.circleSlide && _margin==0) jQuery(_options.btPrev,_this).addClass('prev-'+_options.disableClass);
                jQuery.fn.galleryScroll.numListActive(_margin, jQuery(_options.slideNum, _this),_gWidth,_lastSection);

                if (_timerSlide) {
                    clearTimeout(_timerSlide);
                    _timerSlide = setTimeout(function(){
                        autoSlide(_options.autoSlide)
                    }, _options.autoSlide);
                }
                e.preventDefault();
            });
        };
    });
}
/* end news_func.js */


/* ui checkbox, radio */
$(document).ready(function(){
    if($('.reg-tab').html() == 'Регистрация'){
        $('.checkbox, .radio').checkBox();
    }
});
(function($){

    var supportsValidity;
    (function(){
        if(!$.prop || supportsValidity){return;}
        var supportTest = function(){
            supportsValidity = !!$('<input />').prop('validity');
        };
        supportTest();
        $(supportTest);
    })();

    $.widget('ui.checkBox', {
        options: {
            hideInput: true,
            addVisualElement: true,
            addLabel: true
        },
        _create: function(){
            var that = this,
                opts = this.options
                ;

            if(!this.element.is(':radio,:checkbox')){
                if(this.element[0].elements && $.nodeName(this.element[0], 'form')){
                    $(this.element[0].elements).filter(':radio,:checkbox').checkBox(opts);
                }
                return false;
            }

            this._proxiedReflectUI = $.proxy(this, 'reflectUI');

            this.labels = $([]);

            this.checkedStatus = false;
            this.disabledStatus = false;
            this.hoverStatus = false;

            this.inputType = this.element[0].type;
            this.radio = this.inputType == 'radio';

            this.visualElement = $([]);
            if (opts.hideInput) {
                this.element.addClass('ui-helper-hidden-accessible');
                if(opts.addVisualElement){
                    this.visualElement = $('<span />')
                        .addClass('ui-'+this.inputType)
                    ;
                    this.element.after(this.visualElement[0]);
                }
            }

            if(opts.addLabel){
                var id = this.element[0].id;
                if(id){
                    this.labels = $('label[for="' + id + '"]', this.element[0].form || this.element[0].ownerDocument).add(this.element.parent('label'));
                }
                if(!this.labels[0]){
                    this.labels = this.element.closest('label', this.element[0].form);
                }
                this.labels.addClass(this.radio ? 'ui-radio' : 'ui-checkbox');
            }

            if($.webshims && $.webshims.addShadowDom){
                $.webshims.addShadowDom(this.element, opts.addVisualElement ? this.visualElement[0] : this.labels[0], {
                    shadowFocusElement: this.element[0]
                });
            }

            this.visualGroup = this.visualElement.add(this.labels);

            this._addEvents();

            this.initialized = true;
            this.reflectUI({type: 'initialreflect'});
            return undefined;
        },
        _addEvents: function(){
            var that 		= this,

                opts 		= this.options,

                toggleHover = function(e){
                    if(that.disabledStatus){
                        return false;
                    }
                    that.hover = (e.type == 'focus' || e.type == 'mouseenter');
                    if(e.type == 'focus'){
                        that.visualGroup.addClass(that.inputType +'-focused');
                    } else if(e.type == 'blur'){
                        that.visualGroup.removeClass(that.inputType +'-focused');
                    }
                    that._changeStateClassChain();
                    return undefined;
                }
                ;

            this.element
                .bind('click.checkBox invalid.checkBox', this._proxiedReflectUI)
                .bind('focus.checkBox blur.checkBox', toggleHover)
            ;
            if (opts.hideInput){
                this.element
                    .bind('usermode', function(e){
                        (e.enabled &&
                            that.destroy.call(that, true));
                    })
                ;
            }
            if(opts.addVisualElement){
                this.visualElement
                    .bind('click.checkBox', function(e){
                        that.element[0].click();
                        return false;
                    })
                ;
            }

            this.visualGroup.bind('mouseenter.checkBox mouseleave.checkBox', toggleHover);

        },
        _changeStateClassChain: function(){
            var allElements = this.labels.add(this.visualElement),
                stateClass 	= '',
                baseClass 	= 'ui-'+ this.inputType
                ;

            if(this.checkedStatus){
                stateClass += '-checked';
                allElements.addClass(baseClass+'-checked');
            } else {
                allElements.removeClass(baseClass+'-checked');
            }

            if(this.disabledStatus){
                stateClass += '-disabled';
                allElements.addClass(baseClass+'-disabled');
            } else {
                allElements.removeClass(baseClass+'-disabled');
            }
            if(this.hover){
                stateClass += '-hover';
                allElements.addClass(baseClass+'-hover');
            } else {
                allElements.removeClass(baseClass+'-hover');
            }

            baseClass += '-state';
            if(stateClass){
                stateClass = baseClass + stateClass;
            }

            function switchStateClass(){
                var classes = this.className.split(' '),
                    found = false;
                $.each(classes, function(i, classN){
                    if(classN.indexOf(baseClass) === 0){
                        found = true;
                        classes[i] = stateClass;
                        return false;
                    }
                    return undefined;
                });
                if(!found){
                    classes.push(stateClass);
                }
                this.className = classes.join(' ');
            }

            this.visualGroup.each(switchStateClass);
        },
        destroy: function(onlyCss){
            this.element.removeClass('ui-helper-hidden-accessible');
            this.visualElement.addClass('ui-helper-hidden');
            if (!onlyCss) {
                var o = this.options;
                this.element.unbind('.checkBox');
                this.visualElement.remove();
                this.labels
                    .unbind('.checkBox')
                    .removeClass('ui-state-hover ui-state-checked ui-state-disabled')
                ;
            }
        },

        disable: function(status){
            if(status === undefined){
                status = true;
            }
            this.element[0].disabled = status;
            this.reflectUI({type: 'manuallydisabled'});
        },

        enable: function(){
            this.element[0].disabled = false;
            this.reflectUI({type: 'manuallyenabled'});
        },

        toggle: function(e){
            this.changeCheckStatus(!(this.element.is(':checked')), e);
        },

        changeCheckStatus: function(status, e){
            if(e && e.type == 'click' && this.element[0].disabled){
                return false;
            }
            this.element[0].checked = !!status;
            this.reflectUI(e || {
                type: 'changecheckstatus'
            });
            return undefined;
        },
        propagate: function(n, e, _noGroupReflect){
            if(!e || e.type != 'initialreflect'){
                if (this.radio && !_noGroupReflect) {
                    var elem = this.element[0];
                    //dynamic
                    $('[name="'+ elem.name +'"]', elem.form || elem.ownerDocument).checkBox('reflectUI', e, true);

                }
                return this._trigger(n, e, {
                    options: this.options,
                    checked: this.checkedStatus,
                    labels: this.labels,
                    disabled: this.disabledStatus
                });
            }
            return undefined;
        },
        changeValidityState: function(){
            if(supportsValidity){
                this.visualGroup[ !this.element.prop('willValidate') || (this.element.prop('validity') || {valid: true}).valid ? 'removeClass' : 'addClass' ](this.inputType +'-invalid');
            }
        },
        reflectUI: function(e){

            var oldChecked 			= this.checkedStatus,
                oldDisabledStatus 	= this.disabledStatus
                ;

            this.disabledStatus = this.element.is(':disabled');
            this.checkedStatus = this.element.is(':checked');
            if(!e || e.type !== 'initialreflect'){
                this.changeValidityState();
            }

            if (this.disabledStatus != oldDisabledStatus || this.checkedStatus !== oldChecked) {
                this._changeStateClassChain();

                (this.disabledStatus != oldDisabledStatus &&
                    this.propagate('disabledchange', e));

                (this.checkedStatus !== oldChecked &&
                    this.propagate('change', e));
            }

        }
    });

    if($.propHooks){
        $.each({checked: 'changeCheckStatus', disabled: 'disable'}, function(name, fn){
            //be hook friendly
            if(!$.propHooks[name]){
                $.propHooks[name] = {};
            }
            var oldSetHook = $.propHooks[name].set;

            $.propHooks[name].set = function(elem, value){
                var widget = $.data(elem, 'checkBox');
                if(widget){
                    widget[fn](!!value);
                }
                return oldSetHook && oldSetHook(elem, value) ;
            };

        });
    }
    ;})(jQuery);
/* end checkbox, radio */

/* Checkbox category */
var catalogNews;

function getCatTree()
{
    $.ajax({
        url: "/news/setcat",
        type: "GET",
        //data: {state:state, id:id},
        async: true,
        success: function(data){
            catalogNews = JSON.parse(data);
        }
    });
}

$(document).ready(function(){

    $('#check_cat input').change(function(){
        id = $(this).val();
        state = $(this).is(':checked');
        if(!state) {
            if( catalogNews[id]['chlds'].length > 0 )
            {
                for(var i in catalogNews[id]['chlds'])
                {
                    $("#Category_id_"+catalogNews[id]['chlds'][i]).prop("checked", false);
                }
            }
            else return;
        }
        if(state) {
            if( catalogNews[id]['prnts'].length > 0 )
            {
                for(var i in catalogNews[id]['prnts'])
                {
                    $("#Category_id_"+catalogNews[id]['prnts'][i]).prop("checked", true);
                }
            }
            else return;
        }
    })

})
/*END Checkbox category */

/*Ajax add news*/
var countNews=0;

$(document).ready(function(){
    $('button').click(function(){
        countNews +=1;
        outNews(countNews);
        //Sconsole.log(countNews);
    });
})

function outNews(count){
    $.ajax({
        url: "/news/index",
        type: "GET",
        data: {count:count},
        async: true,
        success: function(data){
            $('div.article-list').html(data);
        }
    });
}
/*END Ajax add news*/

/*Login*/
$(document).ready(function(){
    $('#login-form-submit').click(function(){
        var email = $('#modelLogin_email').val();
        var pass = $('#modelLogin_password').val();
        $.ajax({
            url: "/user/login",
            type: "POST",
            data: {email:email, pass:pass},
            async: true,
            success: function(data){
                var obj = JSON.parse(data);
                if(obj.hasError == 1)
                {
                    $('.user_error').text('Искомая комбинация неправильная');
                }else if(obj.hasError == 0)
                {
                    $('.user_error').text('');
                    $('.login-popup').hide();
                    $('#login-popup-wrap').css('display', 'none');
                    $('#inpt_pus').replaceWith("<div class='user_icon'></div><a id='profile-login' href='/user/profile'>"+obj.username+"</a>");
                    $('#reg_link').replaceWith("<a id='head-user-menu-profile-exit' href='/user/logout'>Выход</a></div>");
                }
            }
        });
    });
})
/*END Login*/

/*Registration form*/

//validation data
$(document).ready(function(){
    $('#registration-data-submit-button').click(function(){
        var nickname = ($('#User_nickname').val() != 'Желаемый ник')? $.trim($('#User_nickname').val()) : '';
        var email = ($('#User_email').val() != 'Email')? $.trim($('#User_email').val()) : '';
        var password = ($('#User_password').val() != 'Пароль')? $.trim($('#User_password').val()) : '';
        var password_repeat = ($('#User_password_repeat').val() != 'Пароль еще раз')? $.trim($('#User_password_repeat').val()) : '';


        if(nickname == '') $('.user_reg_error').text('Поле Ник не заполнено')
        else if(isBusyItemName('nickname', nickname) == false) $('.user_reg_error').text('Такой Ник уже используется')
        else if(isCorrectNick(nickname) == false) $('.user_reg_error').text('Ник 3-100 симв., латинскими буквами')
        else if(email == '') $('.user_reg_error').text('Поле Mail не заполнено')
        else if(isValidEmail(email) == false) $('.user_reg_error').text('E-mail введен не корректно ')
        else if(isBusyItemName('email', email) == false) $('.user_reg_error').text('Такой E-mail уже зарегистрирован ')
        else if(password == '' || password_repeat == '') $('.user_reg_error').text('Поле пароль не заполнено')
        else if(password != password_repeat) $('.user_reg_error').text('Пароли должны совпадать')
        else
        {
            sendRegForm(nickname, email, password, password_repeat);

            $('#RegForm_login').val('Желаемый ник');
            $('#RegForm_email').val('Email');
            $('#RegForm_password').attr('type', 'text').val('Пароль');
            $('#RegForm_password_repeat').attr('type', 'text').val('Пароль еще раз');
        }


    });

    $('#close-registration-data-submit-button').click(function(){
        $('#login-popup-wrap').css('display', 'none');
    });
})

//send to registration action
function sendRegForm(nickname, email, password, password_repeat){
    $.ajax({
        url: "/user/reg",
        type: "POST",
        data: {
            nickname:nickname,
            email:email,
            password:password,
            password_repeat:password_repeat},
        async: false,
        success: function(data){
            var result = JSON.parse(data);
            if(result.hasError != null)
            {
                if( Object.keys(result.hasError).length > 0 )
                {
                    for (var i in result.hasError)
                    {
                        var txt = result.hasError[i];
                        break;
                    }
                    $('.user_reg_error').text(txt);
                }
            }

            if (result.success_send == 0)
            {
                $('#reg_aria').css('display', 'none');
                $('#succes_msg').css('display', 'block');
                $('#succes_msg #block').text('Ошибка при отправке');
                $('.user_reg_error').text('');
            }else if(result.success_send == 1)
            {
                $('.user_reg_error').text('');
                $('#reg_aria').css('display', 'none');
                $('#succes_msg').css('display', 'block');
            }
        }
    });
}

function isValidEmail(email) {
    var pattern = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
    return pattern.test(email);
}

//check correct login
function isCorrectNick(nickname){
    $.ajax({
        url: "/user/correctnickname",
        type: "POST",
        data: {
            nickname:nickname
        },
        async: false,
        success: function(data){
            window.obj = JSON.parse(data);
        }
    });

    if(obj.isCorrectNickName == 1)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function isBusyItemName(fieldName, fieldContent){
    $.ajax({
        url: "/user/busyitemname",
        type: "POST",
        data: {
            fieldName:fieldName,
            fieldContent:fieldContent
        },
        async: false,
        success: function(data){
            window.obj = JSON.parse(data);
        }
    });
    if(obj.isbusy == 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}

/*END Registration form*/

/*Change State radiobutton on user list*/
//:not(:checked)
$(document).ready(function(){
    $('.state_radiobtn').change(function(){
        var state = $(this).val();
        var user_id = $(this).attr('id');
        $.ajax({
            url: "/user/switchstate",
            type: "POST",
            data: {
                user_id:user_id,
                state:state
            },
            async: false,
            success: function(data){
                var obj = JSON.parse(data);
                if (obj.switch_succ == 1){
                    if(state == 1)
                    {
                        $('.msg_succ_'+user_id).text('Активен').css('color', 'green');
                    }else if(state == 0)
                    {
                        $('.msg_succ_'+user_id).text('Заблокирован').css('color', 'red');
                    }
                }
            }
        });
    });
})

/*END change State radiobutton on user list*/