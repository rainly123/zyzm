<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no" >
<meta name="keywords" content="创业,投资,理财,众筹,融资" />  
<meta name="description" content="中瀛智募（上海）文化传媒有限公司（简称“中瀛智募”）由蔡远游先生于2014年6月创立于上海市（2015年5月更名），系以股权众筹方式筹建的有限责任 公司，是为创业者和天使投资人提供快速对接的众筹服务平台，是一家开放的、以发起和支持创业梦想为主的股权众筹服务平台，是以创业、投资、传播交互发展的 互联网社区。
在“大众创业、万众创新”的新时代，我决定采取众筹的手段，在上海筹建、成立一家以经营众筹网站、天使茶馆为主，以为创业青年找资金、为投资人找项目为主要运营目的的新型互联网企业，她的名字叫“中瀛智募”。
只要您认同中瀛智募的理念、规则，诚挚邀请你加入我们的行列，共同成为中瀛智募的众筹股东！
只要您与我们、与创业者拥有相同的理念和价值认同，只要您愿意支持青年的创业。诚挚邀请您成为中瀛智募平台众筹项目的天使投资人。"/>

<link rel="stylesheet" href="/Public/Mobile/css/css.css">
<link href="/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">

    <link href="/Public/Mobile/css/header.css" rel="stylesheet">
    <link href="/Public/Mobile/css/photoswipe.css" rel="stylesheet">
    <link href="/Public/Mobile/css/photoswipe-default-skin.css" rel="stylesheet">
    <!--<link href="/Public/Mobile/css/touchTouch.css" rel="stylesheet">-->

<!--[if lt IE 9]>
<script src="js/html5.js"></script>
<![endif]-->
<script type="text/javascript" src="/Public/Mobile/js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="/Public/Mobile/js/jquery.mobile-1.0.1.min.js"></script>
<!--<script type="text/javascript" src="/Public/Mobile/js/jquery.placeholder.js"></script>-->
<script type="text/javascript" src="/Public/Mobile/js/ios.js"></script>
<script type="text/javascript" src="/Public/Mobile/js/addons.js"></script>
<script type="text/javascript" src="/Public/Mobile/js/layer.m/layer.m.js"></script>
<script type="text/javascript" src="/Public/Mobile/js/common.js"></script>
<title><?php if(empty($pageTitle)): ?>中瀛智募<?php else: echo ($pageTitle); endif; ?></title>
<script>
	var _hmt = _hmt || [];
	(function() {
	  var hm = document.createElement("script");
	  hm.src = "//hm.baidu.com/hm.js?c18b08cac9b94bf4628c0277d3a4d7de";
	  var s = document.getElementsByTagName("script")[0]; 
	  s.parentNode.insertBefore(hm, s);
	})();
    // 计算 rem
    !function(){var a=document.documentElement;var b=a.clientWidth/16;a.style.fontSize=(b>40?40:b)+"px"}();
</script>

<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->
<?php echo hook('pageHeader');?>

</head>
<body>
	<!-- 头部 -->
	<div class="wrapper">
    <!-- 头部导航栏 -->
    <header>
        <h2>
            <?php if(empty($pageTitle)): ?><a href="#" class="brand"></a>
                <?php else: ?>
                <?php echo ($pageTitle); endif; ?>
        </h2>
        <?php if(empty($pageTitle)): ?><div class="lft">
                <a href="#left-menu" class="btn-left-menu"></a>
            </div>
            <?php else: ?>
            <div class="lft">
                <?php if(empty($backurl)): ?><a href="javascript:if (history.length===1){location.href='/'} else {window.history.back()}"
                       class="back"></a>
                    <?php else: ?>
                    <a href="<?php echo ($backurl); ?>" class="back"></a><?php endif; ?>
            </div><?php endif; ?>
        <div class="rgt">
            <a href="<?php echo U('MCenter/index');?>" class="user"></a>
        </div>
    </header>
	<!-- /头部 -->
	
	<!-- 主体 -->
	



    <div class="wrapper">

        <div class="prodetail">
            <div class="item ppt-section">
                <div class="head">
                    <h2>项目介绍</h2>
                    <em></em>
                </div>
                <div class="body">
                    <div class="prodetail_txt">
                        <?php echo ($project["info"]["description"]); ?>
                    </div>
                    <div class="gallery-box">
                        <ul class="ppt-list">
                            <?php if(is_array($project["temp"])): foreach($project["temp"] as $key=>$v): if(($v["temp_type"]) == "1"): ?><li><img src="<?php echo (get_cover($v["info_key"],'path')); ?>"></li><?php endif; endforeach; endif; ?>
                        </ul>
                        <div class="img-count-bg"></div>
                        <div id="img-count" class="img-count"></div>
                    </div>
                    <div class="prodetail_txt">
                        <p><?php echo ($project["abstract"]); ?></p>
                    </div>
                </div>
            </div>
            <?php if(!empty($team)): ?><div class="item team-section">
                    <div class="head">
                        <h2>团队成员</h2>
                        <em></em></div>
                    <div class="body" style="display: block;">
                        <?php if(is_array($team)): $i = 0; $__LIST__ = $team;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 3 );++$i; if(($mod) == "0"): ?><ul class="team-list"><?php endif; ?>
                            <li class="team-member">
                                <a href="#" class="member-button">
                                    <img class="member-avatar no-fullscreen" src="<?php echo (get_cover($v["header_img"],'path')); ?>">

                                    <p class="member-name"><?php echo ($v["name"]); ?></p>
                                </a>
                                <input class="member-info" type="hidden" value="<?php echo ($v["member_info"]); ?>">
                                <input class="member-position" type="hidden" value="<?php echo ($v["postion"]); ?>">
                            </li>
                            <?php if(($mod) == "2"): ?></ul>
                                <div class="member-intro hidden">
                                    <div class="tri"></div>
                                    <p>职务：<span class="member-position"></span></p>
                                    <p>成员简介：<span class="member-info"></span></p>
                                </div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        <?php if(($mod) != "2"): ?></ul>
                            <div class="member-intro">
                                <div class="tri"></div>
                                <p>职务：<span class="member-position"></span></p>
                                <p>成员简介：<span class="member-info"></span></p>
                            </div><?php endif; ?>
                    </div>
                </div><?php endif; ?>
            <?php if(!empty($project["info"]["plan"])): ?><div class="item">
                    <div class="head">
                        <h2>未来规划</h2>
                        <em></em></div>
                    <div class="body" style="display: block;">
                        <div class="prodetail_txt">
                            <?php echo ($project["info"]["plan"]); ?>
                        </div>
                    </div>
                </div><?php endif; ?>
            <?php if(!empty($project["info"]["plan"])): ?><div class="item">
                    <div class="head">
                        <h2>目标客户</h2>
                        <em></em></div>
                    <div class="body" style="display: block;">
                        <div class="prodetail_txt">
                            <?php echo ($project["info"]["custom"]); ?>
                        </div>
                    </div>
                </div><?php endif; ?>
            <?php if(!empty($project["info"]["plan"])): ?><div class="item">
                    <div class="head">
                        <h2>竞争优势</h2>
                        <em></em></div>
                    <div class="body" style="display: block;">
                        <div class="prodetail_txt">
                            <?php echo ($project["info"]["avantages"]); ?>
                        </div>
                    </div>
                </div><?php endif; ?>
            <?php if(!empty($project["info"]["plan"])): ?><div class="item">
                    <div class="head">
                        <h2>盈利模式</h2>
                        <em></em></div>
                    <div class="body" style="display: block;">
                        <div class="prodetail_txt">
                            <?php echo ($project["info"]["yingli_mode"]); ?>
                        </div>
                    </div>
                </div><?php endif; ?>
        </div>

        <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

            <!-- Background of PhotoSwipe.
                 It's a separate element as animating opacity is faster than rgba(). -->
            <div class="pswp__bg"></div>

            <!-- Slides wrapper with overflow:hidden. -->
            <div class="pswp__scroll-wrap">

                <!-- Container that holds slides.
                    PhotoSwipe keeps only 3 of them in the DOM to save memory.
                    Don't modify these 3 pswp__item elements, data is added later on. -->
                <div class="pswp__container">
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                </div>

                <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                <div class="pswp__ui pswp__ui--hidden">

                    <div class="pswp__top-bar">

                        <!--  Controls are self-explanatory. Order can be changed. -->

                        <div class="pswp__counter"></div>

                        <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                        <button class="pswp__button pswp__button--share" title="Share"></button>

                        <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                        <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                        <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                        <!-- element will get class pswp__preloader--active when preloader is running -->
                        <div class="pswp__preloader">
                            <div class="pswp__preloader__icn">
                                <div class="pswp__preloader__cut">
                                    <div class="pswp__preloader__donut"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                        <div class="pswp__share-tooltip"></div>
                    </div>

                    <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                    </button>

                    <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                    </button>

                    <div class="pswp__caption">
                        <div class="pswp__caption__center"></div>
                    </div>

                </div>

            </div>

        </div>

        <div class="fixed-footer-proj">
            <a class="lnk lnk-index if icon-angle-left" href="<?php echo U('project/detail?id='.$project['project']['id']);?>">上一页</a>
            <a class="lnk lnk-comment if icon-comment-o"
               href="<?php echo U('project/postcomment/pid/'.$project['project']['id']);?>">评论</a>
            <?php if(($project['project']['stage'] == 1) AND ($project['project']['vote_leader'] == 0)): ?><a class="btn btn-find-leader if icon-leader" href="<?php echo U('project/leader_info?id='.$project['project']['id']);?>">领投人虚位以待</a>
                <?php else: ?>
                <a class="btn btn-follow if icon-coin-stack" id="btn-follow" href="<?php echo U('project/follow?id='.$project['project']['id']);?>">我要跟投</a><?php endif; ?>
        </div>

        <script src="/Public/Mobile/js/photoswipe.min.js"></script>
        <script src="/Public/Mobile/js/photoswipe-ui-default.min.js"></script>
        <!--<script src="/Public/Mobile/js/photoswipe.js"></script>--> <!--旧-->
        <!--<script src="/Public/Mobile/js/custom.js"></script>-->
        <script>

            $(function () {
                var $pptSection = $('.ppt-section');
                var $galleryImages = $('.gallery-box').find('img');
                $('#img-count').text($galleryImages.length || '');
                var items = [];
                var pswpElement = document.querySelector('.pswp');
                var options = {
                    shareEl: false,
                    fullscreenEl: false,
                    zoomEl: true,
                    index: 0,
                    tapToClose: true
                };
                var showPPT = function (i) {
                    options.index = i || 0;
                    var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
                    gallery.init();
                };
                var fullscreen = function () {
                    var $img = $(this);
                    var item = {
                        src: $img.attr('src'),
                        w: $img.data('w'),
                        h: $img.data('h')
                    };
                    options.index = 0;
                    var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, [item], options);
                    gallery.init();
                };
                $galleryImages.each(function (i) {
                    var $this = $(this);
                    var src = $this.attr('src');
                    items.push({
                        src: src,
                        w: 600,
                        h: 400
                    });
                    var dummyImg = new Image();
                    dummyImg.src = src;
                    if (dummyImg.complete) {
                        items[i].w = dummyImg.width;
                        items[i].h = dummyImg.height;
                        dummyImg = null;
                    } else {
                        dummyImg.onload = function () {
                            items[i].w = dummyImg.width;
                            items[i].h = dummyImg.height;
                            dummyImg = null
                        }
                    }
                });

                $pptSection.find('.gallery-box').click(showPPT);
                $('.item').not('.team-section').find('img').not($galleryImages).each(function () {
                    var $this = $(this);
                    var dummyImg = new Image();
                    dummyImg.src = $this.attr('src');
                    var saveSize = function () {
                        $this.data('w', dummyImg.width);
                        $this.data('h', dummyImg.height);
                        dummyImg = null;
                    };
                    if (dummyImg.complete) {
                        saveSize();
                    } else {
                        dummyImg.onload = saveSize;
                    }
                    $this.click(fullscreen);
                });

                var defaultMemberAvatar = function () {
                    $('.member-avatar').each(function () {
                        var $this = $(this);
                        if (!$this.attr('src')) {
                            $this.attr('src', '/Public/``Home``/images/icon_none.gif')
                        }
                    });
                };
                defaultMemberAvatar();

                var lastMemberIndex = -1;
                $('.member-button').click(function () {
                    var $this = $(this),
                            $member = $this.parent(),
                            idx = $member.index(),
                            $memberIntro = $member.parent().next();

                    $('.tri').css('left', $this.offset().left + $this.outerWidth() / 2 - 25);

                    $('.member-intro').not($memberIntro).slideUp();
                    $memberIntro.stop(true, false);
                    if (idx === lastMemberIndex) {
                        $memberIntro.slideToggle();
                        return false;
                    }

                    $memberIntro.slideUp(function () {
                        $memberIntro.find('.member-position').text($member.find('.member-position').val());
                        $memberIntro.find('.member-info').text($member.find('.member-info').val());
                        $memberIntro.slideDown();
                    });
                    lastMemberIndex = idx;


                    return false;
                });

            });
        </script>

	<!-- /主体 -->

	<!-- 底部 -->
	</div>
<!-- 底部================================================== -->
 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden" style="display:none;"><!-- 用于加载统计代码等隐藏元素 -->

</div>

	<!-- /底部 -->
</body>
</html>