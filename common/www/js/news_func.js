var countNews=0;

 function lighboxstart(rel,href)
 {
      $("[href = \'"+href+"\'][rel = \'"+rel+"\']").click();
 }
 
$(document).ready(function(){
	$('button').click(function(){
		countNews +=1;
		outNews(countNews);
		//Sconsole.log(countNews);
	});
        
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