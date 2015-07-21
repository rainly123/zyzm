/*www.qietu.com*/

$(function () {
    var wechat_developer_reload = function () {
        $('body').append('<input type="button" value="refresh" onclick="window.location.reload();"/>');
    };
    //wechat_developer_reload();


    //滚动监听(对象,偏移,改变的样式,非活动时隐藏对象)

    function scrollHandler () {
        var scrollTop = $(window).scrollTop(),
            maxOffset = $(window).height() - 300 + scrollTop;
        var focusCandidate = [];

        $('.list .item').each(function () {
            var $this = $(this);
            if ($this.offset().top < maxOffset) {
                focusCandidate.push($this);
            }
        });

        $('.item.selected').removeClass('selected');
        var $focus = focusCandidate[focusCandidate.length - 1];
        if ($focus) {
            $focus.addClass('selected');
            var $a = $focus.find('a');
            if ($a.length === 0) $a = $focus.parent(); // 首页与分类列表页结构不同
            var url = $a.attr('href');
            var $btnBuy = $('.btn-buy'),
                $fundFot = $('.fund_fot');

            if (url.length > 1) {
                $btnBuy.attr('href', url);
                $fundFot.show();
            } else {
                $btnBuy.attr('href', '#');
                $fundFot.parent().parent().hide();
            }
        }
        var $giftIcon = $('#giftIcon');
        if ($giftIcon.size() > 0 && $giftIcon.offset().top - scrollTop < $(window).height()) {
            $giftIcon.animate({'top': 0}, 1000, 'easeOutBounce');
        }
    }
    var suspendTimer = 0;
    $(window).bind("scroll", function () {
        clearTimeout(suspendTimer);
        suspendTimer = setTimeout(scrollHandler, 100);
    });

    /*jd*/
    function n() {
        var t = $(".animateNum");
        var n = {
            top: $(window).scrollTop(),
            bottom: $(window).scrollTop() + $(window).height()
        };
        t.each(function () {
            var $this = $(this),
                t = $this.attr("data-animateTarget");
            if (n.top <= $this.offset().top + $this.height() && n.bottom >= $this.offset().top && !$this.data("start")) {
                $this.data("start", true);
                new AnimateNum({
                    obj: $this,
                    target: t,
                    totalTime: 1e3
                })
            }
        })
    }

    function b() {
        var t = $(".animateBar");
        var n = {
            top: $(window).scrollTop(),
            bottom: $(window).scrollTop() + $(window).height()
        };

        t.each(function () {

            var t = $(this).attr("data-animateTarget");
            n.top <= $(this).offset().top + $(this).height() && n.bottom >= $(this).offset().top && !$(this).data("start") && ($(this).data("start", !0), new AnimateBar({
                obj: $(this),
                target: t,
                totalTime: 1e3
            }))
        })
    }

    function p() {
        var t = $(".animatePie");
        var n = {
            top: $(window).scrollTop(),
            bottom: $(window).scrollTop() + $(window).height()
        };

        t.each(function () {
            var t = $(this).attr("data-animateTarget");
            n.top <= $(this).offset().top + $(this).height() && n.bottom >= $(this).offset().top && !$(this).data("start") && ($(this).data("start", !0), new AnimatePie({
                obj: $(this),
                target: t,
                totalTime: 1e3
            }))
        })
    }


    /*n(),
     b(),*/
    $(window).bind("scroll",
        function () {
            n();
            b();
            p();
        });

    function AnimateNum(t) {
        this.obj = t.obj;
        this.target = t.target.toString();
        this.totalTime = t.totalTime || 1e3;
        this.init();
    }

    function AnimateBar(t) {
        this.obj = t.obj;
        this.target = t.target.toString();
        this.totalTime = t.totalTime || 1e3;
        this.init();
    }

    function AnimatePie(t) {
        this.obj = t.obj;
        this.target = t.target.toString();
        this.totalTime = t.totalTime || 1e3;
        this.init();
    }

    AnimateNum.prototype = {
        init: function () {
            if (this.target) this.animation();
        },
        animation: function () {
            var hasWan = false,
                target = this.target;
            if (target.indexOf('万') > -1) {
                hasWan = true;
                target = target.replace('万', '');
            }
            var that = this,
                i = target.indexOf("."),
                precision = 0,
                stepGap = 50 / 3;
            if (i >= 0) precision = target.length - i - 1;
            var integer = parseInt(target.replace(".", "")),
                stepCount = that.totalTime / stepGap,
                stepNum = integer / stepCount,
                step = 0,
                num = 0;
            that.timer = setInterval(function () {
                step++;
                num += stepNum;
                that.obj.html(Math.round(num) / Math.pow(10, precision) + (hasWan ? '万' : ''));
                if (step >= stepCount) {
                    clearInterval(that.timer);
                    that.obj.html(that.target)
                }
            }, stepGap)
        }
    };

    AnimateBar.prototype = {
        init: function () {
            return this.target ? (this.animation(), void 0) : !1
        },
        animation: function () {
            var t = this,
                i = this.target.indexOf("."),
                e = 0;
            i >= 0 && (e = this.target.length - i - 1);
            var n = this.target.replace(".", ""),
                s = this.totalTime / 30 | 0,
                a = n / s | 0,
                r = 0,
                h = 0;
            t.timer = setInterval(function () {
                    r++,
                        h += a,
                        t.obj.css('width', h / Math.pow(10, e) + '%'),
                    r >= s && (clearInterval(t.timer), t.obj.animate({'width': t.target + '%'}))
                },
                30)
        }
    };

    AnimatePie.prototype = {
        init: function () {
            return this.target ? (this.animation(), void 0) : !1
        },
        animation: function () {
            var t = this;
            /*i = this.target.indexOf("."),
             e = 0;
             i >= 0 && (e = this.target.length - i - 1);
             var n = this.target.replace(".", ""),
             s = this.totalTime / 30 | 0,
             a = n / s | 0,
             r = 0,
             h = 0;
             t.timer = setInterval(function() {
             r++,
             h += a,
             t.obj.find('.pieInner span').html(h / Math.pow(10, e)),
             r >= s && (clearInterval(t.timer), t.obj.find('.pieInner span').html(t.target))

             },
             30)*/

            s = this.totalTime / 60 | 0;
            r = 0;

            i = 0;
            count = 0;
            j = 0;

            num = t.target;

            function start1() {

                t.obj.find('.pieInner span').html(i + 1);
                if (num == 0) return false;
                i = i + 1;


                if (i == num) {
                    clearInterval(t1);
                }

                if (i == 50) {

                    clearInterval(t1);
                    num2 = num - 50;
                    t2 = setInterval(start2, 1);
                }
                ;

                t.obj.find(".pieLeftInner").css("-o-transform", "rotate(" + i * 3.6 + "deg)");
                t.obj.find(".pieLeftInner").css("-moz-transform", "rotate(" + i * 3.6 + "deg)");
                t.obj.find(".pieLeftInner").css("-webkit-transform", "rotate(" + i * 3.6 + "deg)");
            };
            function start2() {

                t.obj.find('.pieInner span').html(50 + j + 1);
                if (num2 == 0) return false;
                j = j + 1;


                if (j == num2) {
                    clearInterval(t2);
                }

                if (j == 50) {

                    clearInterval(t2);
                }
                ;
                t.obj.find(".pieRightInner").css("-o-transform", "rotate(" + j * 3.6 + "deg)");
                t.obj.find(".pieRightInner").css("-moz-transform", "rotate(" + j * 3.6 + "deg)");
                t.obj.find(".pieRightInner").css("-webkit-transform", "rotate(" + j * 3.6 + "deg)");
            };

            t1 = setInterval(function () {
                    r++;

                    //t.obj.css('width',h / Math.pow(10, e) + '%'),
                    r >= s && (clearInterval(t.timer), start1())
                },
                30);
            //t1 = setInterval(start1,1);


        }
    };

    $('.wrapper').css('minHeight', $(window).height());

    $('.menu').click(function () {
        if ($('.wrapper').hasClass('pageOpen')) {
            $('.aside, .main').animate({'left': '-=200'});
            $('.wrapper').removeClass('pageOpen');
        }
        else {
            $('.aside, .main').animate({'left': '+=200'});
            $('.wrapper').addClass('pageOpen');
        }
    });

    $('.text input').focus(function () {
        $(this).parent().addClass('selected');
    }).blur(function () {
        $(this).parent().removeClass('selected');
    });

    /*验证码*/
    $('#getcode').live('click', function (event) {
        if ($(this).hasClass('disabled')) {
            return false;
        }

        $(this).addClass('disabled');

        var ths = $(this);
        var val = ths.val();

        var time = 60;

        ths.val(time + '秒后可重发');

        _timeRun = setInterval(function () {
            if (time == 1) {
                ths.css('cursor', 'pointer');

                ths.val(val);
                clearInterval(_timeRun);
                ths.removeClass('disabled');
            }
            if (time > 1) {
                time--;
                //console.log(time);
                ths.css('cursor', 'default');

                //alert($(event.target)[0].tagName);
                ths.val(time + '秒后可重发');
            }


        }, 1000);


        return false;
    });

    /*错误抖动*/
    function errorAnimate() {
        var num = 0;
        timer = setInterval(function () {
            num++;
            if (num < 5) {

                $('.errorAnimate').animate({'left': -10}, 100, function () {
                    $(this).animate({'left': 10}, 100);
                });
            }
            else {
                clearInterval(timer);
                $('.errorAnimate').stop().animate({'left': 0}, 'fast');
            }
            //console.log(num);
        }, 200);
    }

    errorAnimate();

    /*星星，赞*/
    $('.digg').find('.star, .plus').click(function () {
        var $this = $(this);
        if ($this.hasClass('disabled')) {
            $this.removeClass('disabled');
            var oNum = parseInt($this.text()) || 0;
            if (oNum > 0) $this.text(oNum - 1)
        }
        else {
            $this.addClass('disabled');
            $this.text(parseInt($this.text()) + 1);
        }
        return false;
    });

    /*详情页展开*/
    $('.detail .item .head em, .prodetail .item .head em').click(function () {
        bd = $(this).parent().parent().find('.body');
        if (bd.is(':visible')) {
            bd.slideUp();
            bd.parent().addClass('closed');
        }
        else {
            bd.slideDown();
            bd.parent().removeClass('closed');
        }
    });

    /*详情页底部菜单*/
    $('.footnav .toggle em').click(function () {
        sn = $(this).parent().find('.dropdown');
        if (sn.is(':visible')) {
            sn.fadeOut();
            sn.parent().removeClass('open');
        }
        else {
            sn.fadeIn();
            sn.parent().addClass('open');
        }
    });

    /*评分教学*/
    //注销cookie
    //$.cookie("guideClosed", null);

    if ($('.rateguide').size() > 0) {
        if ($.cookie("guideClosed") == 'true') {
            $('.rateguide').remove();
        }
    }
    $('.rateguide').click(function () {
        $(this).animate({'opacity': 0}, 'slow', function () {
            $(this).remove();
            $.cookie("guideClosed", "true", {expires: 10});
        });
    })


});


