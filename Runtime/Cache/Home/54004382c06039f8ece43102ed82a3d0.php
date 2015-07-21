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
  <a class="physical_nav1">已支持</a>
  <a href="<?php echo U('MCenter/pr_create');?>">已发布</a>
<!--   <a href="<?php echo U('MCenter/pr_attach');?>">已收藏</a> -->
</section>
<section id="physical_main">
  <div class="list_cp1">
	<?php if(is_array($supportList)): foreach($supportList as $key=>$vo): ?><div class="item selected">
                <div class="list_zu">
					<div class="physical_kuang">
						<div class="list_zu1"> 
							<a href="<?php echo U('Product/viewdetail?pid='.$vo['id']);?>">
								<img width="100%" height="100%" src="<?php echo (get_cover($vo["home_img"],'path')); ?>">
							</a>
						</div>
					
						<div class="list_zu2">
							<ul>
								<li><h3><?php echo ($vo["name"]); ?></h3></li>
								<li>订单：<?php echo ($vo["customid"]); ?></li>
								<li><b>时间：<?php echo (time_format($vo["create_time"],"Y-m-d")); ?></b><h2>状态：<?php if($vo['status'] == 0): ?>购买成功
								<?php elseif($vo['status'] == 1): ?>支付成功
								<?php elseif($vo['status'] == -1): ?>已撤销
								<?php elseif($vo['status'] == -2): ?>无购买名额<?php endif; ?></h2></li>
								<?php if(!empty($vo["luckno"])): ?><li><b>幸运号：<?php echo ($vo["luckno"]); ?></b></li><?php endif; ?>
								<?php if(!empty($vo["shareno"])): ?><li><b>邀请码：<?php echo ($vo["shareno"]); ?></b></li><?php endif; ?>
							</ul>
						</div>
					</div>
					<div class="physical_rtje">
						<dd>￥:<span><?php echo ($vo["amount"]); ?></span><b>元</b>（邮费：￥<?php echo ($vo["post_amount"]); ?>）</dd>
						<p>
							<?php if($vo['status'] == 0): ?><a href="<?php echo U('ProductOrder/confirm?customId='.$vo['customid']);?>"  id="btnpay" class="btnpay">支付</a>
								<a href="<?php echo U('ProductOrder/revocation?customId='.$vo['customid']);?>" id="btnattach" class="btnattach">撤销</a>
							<?php elseif($vo['status'] == 1): ?>
								<!-- <a href="#">交易详情</a> -->
								<!-- <a href="<?php echo U('Product/viewdetail?pid='.$vo['id'].'&shareid='.$vo['shareid']);?>">分享</a> -->
								<?php if(($vo["is_share"]) == "2"): ?><a href="<?php echo U('ProductOrder/share?id='.$vo['customid']);?>">分享</a><?php endif; endif; ?>
						</p>
					</div>
				</div>
			</div><?php endforeach; endif; ?>
  
            <!--item-->
	</div>
<!--   <div class="list_gd">
    <a href="#">查看更多（每次加载5条显示）</a>
  </div> -->
</section>

	<!-- /主体 -->

	<!-- 底部 -->
	</div>
<!-- 底部================================================== -->

	<script type="text/javascript">
		$(".btnattach").click(function() {
			  var _this = $(this);
			  if (confirm('您确定要撤销吗？')) {
			    $.post(_this.attr('href'), function(data) {
			      if (data.status == 1) {
			        alert('指定订单已撤销');
			        window.location.reload();
			      }
			    });
			  }
			  return false;
			});
	
		$(".btnpay").click(function() {
			  var _this = $(this);
			    $.post(_this.attr('href'), function(data) {
				      if (data.status == 1) {
				       
				        window.location.href = data.url;
				      }
				    });
			  return false;
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