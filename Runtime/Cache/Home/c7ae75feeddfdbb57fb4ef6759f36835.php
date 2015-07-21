<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no" >
<meta name="keywords" content="创业,投资,理财,众筹,融资" />  
<meta name="description" content="中瀛智募：
	生于西子湖畔，长于苏堤之间，骨子里透着岳飞的气概，形而间又有着苏轼的豪放。
	
	他，活跃在商道，相信天道酬勤、人道酬善、商道酬信、业道酬精。
	
	他，经营的是信念, 汇聚大众之力，助力大众。
	
	他，带给你互联网社交驱动下的好玩，让你体会项目方和投资人之间的紧密相连。
	
	这是一个因梦而舞，为梦而动的平台；
	
	这是一个让梦想者靠近梦想，坚持梦想，实现梦想的平台；
	
	这是一个让支持者品味梦想，见证梦想，助力梦想的平台。"/>

<link rel="stylesheet" href="/Public/Mobile/css/css.css">
<link href="/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">

<link href="/Public/Mobile/css/login.css" rel="stylesheet" type="text/css">
<link href="/Public/Mobile/css/index.css" rel="stylesheet" type="text/css">

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
	



<section id="news_nav">
  <a href="<?php echo U('MCenter/pr_support');?>">已支持</a>
  <a class="physical_nav1">已发布</a>
<!--   <a href="<?php echo U('MCenter/pr_attach');?>">已收藏</a> -->
</section>
<section id="physical_main">
  <div class="list_cp1">
		<!--item-->
		
		<?php if(is_array($myProductList)): foreach($myProductList as $key=>$vo): ?><div class="item selected">
                <div class="list_zu">
					<div class="physical_kuang">
						<div class="list_zu11"> 
							<a href="<?php echo U('Product/viewdetail?pid='.$vo['id']);?>"><img width="100%" height="100%" src="<?php echo (get_cover($vo["home_img"],'path')); ?>"></a>
						</div>
						
						<div class="list_zu21">
							<ul>
								<li><h3><?php echo ($vo["name"]); ?></h3></li>
								<li><b>目标金额：¥<?php echo ($vo['amount']); ?></b><h2>状态：<!-- 状态（0：普通、1：申请发布、2：不通过、9：审核通过） -->
									<?php if($vo['status'] == 0): ?>未提交
										<?php elseif($vo['status'] == 1): ?>审核中
										<?php elseif($vo['status'] == 2): ?>不通过
										<?php elseif($vo['status'] == 9): ?>
											<?php if($vo['stage'] == 0): ?>审核通过
												<?php elseif($vo['stage'] == 1): ?>预热中
												<?php elseif($vo['stage'] == 2): ?>众筹中
												<?php elseif($vo['stage'] == 8): ?>众筹失败
												<?php elseif($vo['stage'] == 9): ?>众筹成功<?php endif; endif; ?></h2>
								</li>
							</ul>
						</div>
					</div>
					
					<div class="physical_rtje1">
						<p><a class="" href="<?php echo U('Product/viewdetail?pid='.$vo['id']);?>">预览</a></p>
					</div>
				</div>
			</div><?php endforeach; endif; ?>
	</div>
<!--   <div class="list_gd">
    <a href="#">查看更多（每次加载5条显示）</a>
  </div> -->
</section>

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