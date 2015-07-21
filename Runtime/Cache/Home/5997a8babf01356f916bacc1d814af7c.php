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
	




    <link href="/Public/Home/css/home.css" rel="stylesheet">

    <script type="text/javascript" src="/Public/Home/js/addons.js"></script>

    <div class="bannerlist"></div>
    <div class="fl w100 mt20">
        <div class="content">
            <!--分类搜索栏-->
            <div class="selectPanel">
                <div class="nav-title">分类</div>
                <ul class="nav">
                    <li><a class='active' href="<?php echo U('List/index',array('type'=>0,'status'=>$_GET['status'],'p'=>1));?>">全部</a></li>
                    <li><a href="<?php echo U('List/index',array('type'=>1,'status'=>$_GET['status'],'p'=>1));?>">股权众筹</a></li>
                    <li><a href="<?php echo U('List/index',array('type'=>2,'status'=>$_GET['status'],'p'=>1));?>">实物众筹</a></li>
                    <li><a href="<?php echo U('List/index',array('type'=>3,'status'=>$_GET['status'],'p'=>1));?>">股票基金</a></li>
                </ul>
                <div style="clear:both"></div>
                <div class="nav-title">分类</div>
                <ul class="nav">
                    <li><a class="active"  href="<?php echo U('List/index',array('type'=>$_GET['type'],'status'=>0,'p'=>1));?>">全部</a></li>
                    <li><a href="<?php echo U('List/index',array('type'=>$_GET['type'],'status'=>1,'p'=>1));?>">筹资中</a></li>
                    <li><a href="<?php echo U('List/index',array('type'=>$_GET['type'],'status'=>2,'p'=>1));?>">筹资成功</a></li>
                </ul>
            </div>
            <!--分类搜索栏-->

            <div class="page-list">




            </div>
            <ul class="list2 content cl">
                <?php if(is_array($listOfProjects)): foreach($listOfProjects as $key=>$v): ?><li>
                        <span id="yrz"><?php echo (get_proj_stage($v["stage"])); ?></span>
                        <?php if($v["finish_rate"] >= 100): ?><span id="cm">众筹超募</span><?php endif; ?>
                        <div class="img"><a href="<?php echo U('project/detail?id='.$v['id']);?>"><img src="<?php echo (get_cover($v['cover'],'path')); ?>" alt="<?php echo ($v["project_name"]); ?>股权众筹"></a></div>
                        <div class="name"><span>股权</span><a href="<?php echo U('project/detail?id='.$v['id']);?>" title="中瀛智募"><?php echo ($v["project_name"]); ?></a></div>
                        <div class="detail"><dl class="cl"><dd><span><?php echo round($v['need_fund']/10000,2);?>万元</span>目标额</dd><dd><span><?php echo ($v['finish_rate'] > 100 ? 100 :$v['finish_rate']); ?>%</span>已完成</dd><dd><span><?php echo ($v["investor_count"]); ?></span>投资人</dd></dl></div>
                        <div class="prograss">
                            <div class="bar animateBar" data-animatetarget="<?php echo ($v['finish_rate'] > 100 ? 100 :$v['finish_rate']); ?>" style="width:<?php echo ($v['finish_rate'] > 100 ? 100 :$v['finish_rate']); ?>%;">
                            </div>
                            <div class="tag">
                                合投
                            </div>
                        </div>
                        <div class="city"><span><?php echo getDistrict($v['province']);?></span><span><?php echo getDistrict($v['city']);?></span></div>
                        <div class="action"><a href="<?php echo U('project/follow?id='.$v['id']);?>">我要投资</a></div>
                    </li><?php endforeach; endif; ?>

                <?php if(is_array($listOfProducts)): foreach($listOfProducts as $key=>$v): ?><li>
                        <div class="img"><a href="<?php echo U('product/viewdetail/pid/'.$v['id']);?>"  title="中瀛智募"><img src="<?php echo (get_cover($v['home_img'],'path')); ?>" alt="<?php echo ($v["name"]); ?>实物众筹"></a></div>
                        <div class="name"><a href="<?php echo U('product/viewdetail/pid/'.$v['id']);?>"  title="中瀛智募"><?php echo ($v["name"]); ?></a></div>
                        <div class="detail"><dl class="cl"><dd><span><?php echo round($v['amount'],1);?>元</span>目标额</dd><dd><span><?php echo ($v['finish_amount']/$v['amount']>100?100:round(($v['finish_amount']/$v['amount'])*100)); ?>%</span>已完成</dd><dd><span><?php echo ($v["supportCount"]); ?></span>购买人</dd></dl></div>

                    </li><?php endforeach; endif; ?>

                <?php if(is_array($listOfStocks)): foreach($listOfStocks as $key=>$v): ?><li>
                        <div class="img"><a href="<?php echo U('stock/index/id/'.$v['id']);?>" title="中瀛智募"><img src="<?php echo (get_cover($v['logo'],'path')); ?>" alt="<?php echo ($v["name"]); ?>股票基金众筹"></a></div>
                        <div class="name"><a href="<?php echo U('stock/index/id/'.$v['id']);?>"><?php echo ($v["name"]); ?></a></div>
                        <div class="detail"><dl class="cl"><dd><span><?php echo round($v['amount']/10000,2);?>万元</span>总资产</dd><dd><span><?php echo ($v["investor_count"]); ?>人</span>已加入</dd><dd><span><?php echo ($v['over']/10000); ?>万元</span>累计收益</dd></dl></div>
                    </li><?php endforeach; endif; ?>



            </ul>
            <div> <?php echo ($page); ?></div>
        </div>
    </div>



	<!-- /主体 -->

	<!-- 底部 -->
	</div>
<!-- 底部================================================== -->

    <script type="text/javascript">
        setTimeout(function () {
            $('.bs-docs-sidenav').affix({
                offset: {
                    top: 68,
                    bottom: 270
                }
            })
        }, 100);
    </script>
 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden" style="display:none;"><!-- 用于加载统计代码等隐藏元素 -->

</div>

	<!-- /底部 -->
</body>
</html>