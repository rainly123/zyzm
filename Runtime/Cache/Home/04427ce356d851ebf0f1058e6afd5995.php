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
	
    <link rel="stylesheet" type="text/css" href="/Public/Mobile/css/index.css"/>
    <script type="text/javascript" src="/Public/Mobile/js/swipe.js"></script>
    <script type="text/javascript" src="/Public/Mobile/js/zepto.js"></script>





    <div id="server-data" style="display:none;">
        <input type="hidden" name="noticelist" value="<?php echo ($noticelist); ?>">
        <input type="hidden" name="newslist" value="<?php echo ($newslist); ?>">
    </div>
    <div id="ad">
        <div style="-webkit-transform:translate3d(0,0,0);">
            <div id="banner_box" class="box_swipe">
                <ul style="cursor:-webkit-grab;">
                    <?php if(is_array($bannerList)): foreach($bannerList as $key=>$vo): ?><li>
                            <a href="<?php echo ($vo["extra"]); ?>"><img src="<?php echo (get_cover($vo["mobiel_img_id"],'path')); ?>" style="width:100%;"/></a>
                        </li><?php endforeach; endif; ?>
                </ul>
                <ol>
                    <li class="on"></li>
                </ol>
            </div>
        </div>
    </div>
    <script>
        !function () {
            var $t = $('#banner_box').children();
            var bannerNum = $t.eq(0).children().length;
            var html = '';
            for (var i = 1; i < bannerNum; i++) {
                html += '<li></li>'
            }
            $t.eq(1).append(html)
        }();
    </script>
    <section>
        <div class="tab tab2">
            <a class="selected" href="/">首页推荐</a>
            <a href="<?php echo U('List/mobileproject');?>">股权众筹</a>
            <!--<a href="<?php echo U('Project/create');?>">公益众筹</a>-->
            <a href="<?php echo U('List/mobileproduct');?>">实物众筹</a>
        </div>
        <div class="list">
            <?php if(is_array($mobileList["project"])): foreach($mobileList["project"] as $key=>$v): ?><div class="item" data-href="<?php echo U('Project/detail?id='.$v['id']);?>">
                    <div class="img">
                        <a href="<?php echo U('Project/detail?id='.$v['id']);?>"><img src="<?php echo (get_cover($v['cover'],'path')); ?>"
                                                                           style="width:100%;"></a>
                        <?php if($v["stage"] == '1'): ?><div class="stamp">
                                <span id="yrz"><?php echo (get_proj_stage($v["stage"])); ?></span>
                            </div>
                            <?php elseif($v["stage"] == 4): ?>
                            <input type="hidden" class="detail_url" value="<?php echo U('Project/detail?id='. $v[id]);?>"><?php endif; ?>
                        <?php if($v["finish_rate"] > 100): ?><div class="tag">
                            </div><?php endif; ?>
                        <?php if(($v["stage"] == 1) and ($v["vote_leader"] == 0)): ?><div class="leader-magnifier"><a href="<?php echo U('project/leader_info?id='.$v['id']);?>">寻找领投人</a>
                            </div><?php endif; ?>
                        <div class="digg">
                            <b class="if icon-star"><?php echo ($v["attach_count"]); ?></b>
                            <b class="if icon-comment"><?php echo ($v["comment_count"]); ?></b>
                            <b class="if icon-eye"><?php echo ($v["read_record"]); ?></b>
                        </div>
                    </div>
                    <div class="text">
                        <div class="title">
                            <i class="gq">&nbsp;</i>
                            <?php echo ($v["project_name"]); ?>
                        </div>
                        <div class="prograss">
                            <?php if($v["stage"] == '1'): ?><div class="bar animateBar"
                                     data-animatetarget="0"
                                     style="width:0%;">
                                </div>
                                <?php else: ?>
                                <div class="bar animateBar"
                                     data-animatetarget="<?php echo ($v['finish_rate'] > 100 ? 100 :round($v['finish_rate'])); ?>"
                                     style="width:<?php echo ($v['finish_rate'] > 100 ? 100 :round($v['finish_rate'])); ?>%;">
                                </div><?php endif; ?>
                        </div>
                        <div class="attr">
                            <dl>
                                <dd class="d1">
                                    <h4>目标额</h4>

                                    <h3><span class="animateNum" data-animatetarget="<?php echo (change_fund($v["fund"]["need_fund"])); ?>"><?php echo (change_fund($v["fund"]["need_fund"])); ?></span>
                                    </h3>
                                </dd>
                                <dd class="d2">
                                    <h4>已完成</h4>

                                    <h3>
                                        <?php if($v["stage"] == '1'): ?><span class="animateNum" data-animatetarget="0">0</span>
                                            <?php else: ?>
                                            <span class="animateNum" data-animatetarget="<?php echo round($v['finish_rate']);?>"><?php echo round($v['finish_rate']);?></span><?php endif; ?>
                                        %
                                    </h3>
                                </dd>
                                <dd class="d3">
                                    <h4>已认投</h4>

                                    <h3>
                                        <?php if($v["stage"] == '1'): ?><span class="animateNum" data-animatetarget="0">0</span>
                                            <?php else: ?>
                                            <span class="animateNum"
                                                  data-animatetarget="<?php echo (change_fund($v["fund"]["has_fund"])); ?>"><?php echo (change_fund($v["fund"]["has_fund"])); ?></span><?php endif; ?>
                                    </h3>
                                </dd>
                            </dl>
                        </div>
                        <div class="tags">
                            <span><?php echo getDistrict($v['province']);?></span>
                            <span><?php echo getDistrict($v['city']);?></span>
                        </div>
                    </div>
                </div><?php endforeach; endif; ?>

            <?php if(is_array($mobileList["product"])): foreach($mobileList["product"] as $key=>$v): ?><div class="item">
                    <div class="img">
                        <input type="hidden" class="detail_url" value="<?php echo U('product/viewdetail/pid/'.$v['id']);?>">
                        <a href="<?php echo U('product/viewdetail/pid/'.$v['id']);?>">
                            <img src="<?php echo (get_cover($v['home_img'],'path')); ?>" style="width:100%;">
                        </a>
                        <?php if($v["finish_rate"] > 100): ?><div class="tag">
                            </div><?php endif; ?>
                        <div class="digg">
                            <b class="if icon-star"><?php echo ($v["like_record"]); ?></b>
                            <b class="if icon-comment"><?php echo ($v["comment_count"]); ?></b>
                            <b class="if icon-eye"><?php echo ($v["read_record"]); ?></b>
                        </div>
                    </div>
                    <div class="text" style="position:relative;">
                        <div class="title">
                            <i class="sw">&nbsp;</i>
                            <?php echo ($v["name"]); ?>
                        </div>
                        <div class="prograss">
                            <div class="bar animateBar"
                                 data-animatetarget="<?php echo ($v['finish_rate'] > 100 ? 100 :$v['finish_rate']); ?>"
                                 style="width:<?php echo ($v['finish_rate'] > 100 ? 100 :$v['finish_rate']); ?>%;">
                            </div>
                        </div>
                        <div class="attr">
                            <dl>
                                <dd class="d1">
                                    <h4>目标额</h4>

                                    <h3><span class="animateNum" data-animatetarget="<?php echo (change_fund($v["amount"])); ?>"><?php echo (change_fund($v["amount"])); ?></span>
                                    </h3>
                                </dd>
                                <dd class="d2">
                                    <h4>已完成</h4>

                                    <h3><span class="animateNum" data-animatetarget="<?php echo round($v['finish_rate']);?>"><?php echo round($v['finish_rate']);?></span>%
                                    </h3>
                                </dd>
                                <dd class="d3">
                                    <h4>已认投</h4>

                                    <h3><span class="animateNum" data-animatetarget="<?php echo (change_fund($v["finish_amount"])); ?>"><?php echo (change_fund($v["finish_amount"])); ?></span>
                                    </h3>
                                </dd>
                            </dl>
                        </div>
                        <?php if(!empty($string)): ?><div class="tags">
                                <?php
 foreach(explode(",",$string) as $arr){ echo "<span>".$arr."</span>"; } ?>
                            </div><?php endif; ?>
                    </div>
                </div><?php endforeach; endif; ?>

            <?php if(is_array($mobileList["stock"])): foreach($mobileList["stock"] as $key=>$v): ?><div class="item">
                    <input type="hidden" class="detail_url" value="<?php echo U('stock/index/id/'.$v['id']);?>">

                    <div class="img">
                        <a href="<?php echo U('stock/index/id/'.$v['id']);?>"><img src="<?php echo (get_cover($v['logo'],'path')); ?>"></a>

                        <div class="tip">
                            <?php echo ($v["describe"]); ?>
                        </div>
                    </div>
                    <div class="text">
                        <div class="title title_bordered">
                            <?php echo ($v["name"]); ?>
                        </div>
                        <div class="attr">
                            <dl>
                                <dd class="d1">
                                    <h4>总资产</h4>

                                    <h3><span class="animateNum" data-animatetarget="<?php echo round($v['amount']/10000,2);?>"><?php echo round($v['amount']/10000,2);?></span>万
                                    </h3>
                                </dd>
                                <dd class="d2">
                                    <h4>已经加入</h4>

                                    <h3><span class="animateNum" data-animatetarget="<?php echo ($v['investor_count']); ?>"><?php echo ($v["investor_count"]); ?></span>人
                                    </h3>
                                </dd>
                                <dd class="d3">
                                    <h4>累计收益</h4>

                                    <h3><span class="animateNum" data-animatetarget="<?php echo round($v['over']/10000,2);?>"><?php echo round($v['over']/10000,2);?></span>万
                                    </h3>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div><?php endforeach; endif; ?>

        </div>
    </section>
    <footer style="margin-bottom:40px">
    </footer>
    <!--<div class="fund_fot" style="display:none">
        <div class="fund" style="color:#fff">
            <a class="btn-buy" href="#">我要投资</a></div>
    </div>-->
    <div class="fixed-footer">
        <div class="btn-list">
            <a class="btn home active if icon-home-o" href="/" >首页</a>
            <a class="btn news if icon-newspapers" href="<?php echo U('info/infolist');?>"><span>干货</span></a>
            <!--<a class="btn user-center if icon-user-o" href="<?php echo U('MCenter/index');?>">我的</a>-->
        </div>
    </div>
    <div class="left-menu-box">
        <ul>
            <li class="active"><a href="">首页</a></li>
            <li>
                <a href="<?php echo U('List/mobileproject');?>">股权众筹</a>
                <ul>
                    <li><a href="<?php echo U('List/mobileproject/status/1');?>">合投中</a></li>
                    <li><a href="<?php echo U('List/mobileproject/status/2');?>">预热中</a></li>
                    <li><a href="<?php echo U('List/mobileproject/status/3');?>">已成功</a></li>
                </ul>
            </li>
            <li><a href="<?php echo U('List/mobileproduct');?>">实物众筹</a></li>
            <li><a href="<?php echo U('info/about');?>">关于我们</a></li>
            <li><a href="<?php echo U('info/contact');?>">联系我们</a></li>
        </ul>
    </div>

	<!-- /主体 -->

	<!-- 底部 -->
	</div>
<!-- 底部================================================== -->

    <script type="text/javascript">
        var serverData = {};
        $('#server-data').children('input').each(function () {
            var $this = $(this);
            serverData[$this.attr('name')] = $this.val()
        });

        // 新资讯红点
        !function () {
            var newsList = serverData.newslist;
            var noticeList = serverData.noticelist;
            newsList = newsList ? newsList.split(',') : [];
            noticeList = noticeList ? noticeList.split(',') : [];
            var recentReadNews = localStorage.getItem('recentReadNews');
            var recentReadNotice = localStorage.getItem('recentReadNotice');
            recentReadNews = recentReadNews ? recentReadNews.split(',') : [];
            recentReadNotice = recentReadNotice ? recentReadNotice.split(',') : [];
            var hasNew = false;
            for (var i = 0, len = newsList.length; i < len; i++) {
                if (recentReadNews.indexOf(newsList[i]) === -1) {
                    hasNew = true;
                    break;
                }
            }
            for (i = 0, len = noticeList.length; i < len; i++) {
                if (recentReadNotice.indexOf(noticeList[i]) === -1) {
                    hasNew = true;
                    break;
                }
            }
            if (hasNew) {
                $('.fixed-footer .news span').addClass('red-dot');
            }
        }();

        $(function () {
            new Swipe(document.getElementById('banner_box'), {
                speed: 500,
                auto: 4000,
                callback: function () {
                    var lis = $(this.element).next("ol").children();
                    lis.removeClass("on").eq(this.index).addClass("on");
                }
            });
        });
        $('.list .item').click(function () {
            var href = $(this).data('href');
            if (href) location.href = href;
        });
        $('.btn-left-menu').click(function () {
            $('.wrapper').toggleClass('view-left-menu')
        });
        var $menuItems = $('.left-menu-box').find('li').click(function (e) {
            $menuItems.removeClass('active');
            $(this).addClass('active');
            e.stopPropagation();
        });
        $(window).on('hashchange', function () {
            var hash = location.hash;
            if (hash === '#left-menu') {
                $('.wrapper').addClass('view-left-menu');
            } else {
                $('.wrapper').removeClass('view-left-menu');
            }
        });

    </script>
 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden" style="display:none;"><!-- 用于加载统计代码等隐藏元素 -->

</div>

	<!-- /底部 -->
</body>
</html>