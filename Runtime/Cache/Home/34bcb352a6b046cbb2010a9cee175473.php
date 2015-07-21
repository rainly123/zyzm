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
	



    <script>
        !function () {
            var a = document.documentElement;
            var b = a.clientWidth / 20;
            a.style.fontSize = (b > 32 ? 32 : b) + "px"
        }();
    </script>

    <link href="/Public/Mobile/css/notice.css" rel="stylesheet">
    <div id="server-data" style="display:none;">
        <input type="hidden" name="noticelist" value="<?php echo ($noticelist); ?>">
        <input type="hidden" name="newslist" value="<?php echo ($newslist); ?>">
    </div>

    <div class="banner-box">
        <ul class="banner-list">
            <?php if(is_array($bannerList)): foreach($bannerList as $key=>$vo): ?><li>
                    <a href="<?php echo ($vo["extra"]); ?>"><img src="<?php echo (get_cover($vo["mobiel_img_id"],'path')); ?>" style="width:100%;"/></a>
                </li><?php endforeach; endif; ?>
        </ul>
        <ol class="indicator">
            <li class="on"></li>
        </ol>
    </div>


    <div class="magellan">
        <div class="tab-box">
            <ul class="tab-list">
                <li id="tab-title-news" class="tab-item <?php if($type != 1 ): ?>active<?php endif; ?>">
                    <a><span>干货</span></a>
                </li>
                <li id="tab-title-notice" class="tab-item <?php if($type == 1 ): ?>active<?php endif; ?>">
                    <a><span>公告</span></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="panel-box swipe <?php if($type == 1 ): ?>news<?php endif; ?>">

        <div class="panel-list swipe-wrap">
            <div class="panel news-panel">
                <ul class="news-list">
                    <?php if(is_array($news)): foreach($news as $key=>$v): ?><li class="<?php print (NOW_TIME - $v['create_time']) / 86400 < 7 ? 'new' : '' ?>">
                            <a href="<?php echo U('Info/infomation?id='.$v['id']);?>">
                                <div class="img" style="background-image: url(<?php echo (get_cover($v["cover"],'path')); ?>)"></div>
                                <span class="title"><?php echo ($v["title"]); ?></span>
                                <span class="date"><?php echo (time_format($v["create_time"],'Y-m-d')); ?></span>
                            </a>
                        </li><?php endforeach; endif; ?>
                </ul>
            </div>

            <div class="panel notice-panel">
                <ul class="notice-list">
                    <?php if(is_array($notice)): foreach($notice as $key=>$v): ?><li class="<?php print (NOW_TIME - $v['create_time']) / 86400 < 7 ? 'new' : '' ?>"><a
                                href="<?php echo U('Info/notice?id='.$v['id']);?>"><span class="title"><?php echo ($v["title"]); ?></span><span
                                class="date"><?php echo (time_format($v["create_time"],'m-d')); ?></span></a></li><?php endforeach; endif; ?>
                </ul>
            </div>
        </div>

    </div>
    <div class="fixed-footer">
        <div class="btn-list">
            <a class="btn home if icon-home-o" href="/">首页</a>
            <a class="btn news active if icon-newspapers" href="<?php echo U('info/infolist');?>"><span>干货</span></a>
            <!--<a class="btn user-center if icon-user-o" href="<?php echo U('MCenter/index');?>">我的</a>-->
        </div>
    </div>
    <script src="/Public/static/jquery-2.0.3.min.js"></script>
    <script src="/Public/static/swipe.min.js"></script>
    <script src="/Public/static/template.js"></script>
    <script src="/Public/Mobile/js/noticelist.js"></script>

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