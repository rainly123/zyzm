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

<link href="/Public/Mobile/css/header.css" rel="stylesheet" type="text/css">
<style>
.btn_agree {background:#72C2E1; color:#FFF;font-size:2em;margin:15px; display:block;padding:13px 20px;text-align:center;border-radius:3px;-webkit-border-radius:3px;-moz-border-radius:3px;}
.agreement1 {font-size: 1em;color:#72C2E1;text-decoration:underline;}
</style>

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
	



<div class="agreement">
	<h1>领投说明</h1>
	<div class="agreement_txt" style="position: relative;">
		<div style="padding-bottom:20px;font-size:14px">
				<h3>关于领投</h3>
				<p>1.每个股权类众筹项目只有一个领投人。</p>
				<p>2.在中瀛智募网站上进行展示。</p>
				<p>2.领投人应积极参与项目的沟通，并协调跟投人和项目方的沟通。</p>
				<p>3.在投后管理中领投人需充当投资人和项目方的沟通桥梁。</p>
				<p>4.领投人作为投资人代表，需起到代表投资人发表意见、做好投后管理工作。</p>
			</div>
			<div style="font-size:16px">更多信息请点击 <a href="<?php echo U('Info/show?key=lead');?>" class="agreement1">领投规则</a></div>
	</div>
		<?php if($isread != true): ?><div>
			<form action="<?php echo U('agree');?>" class="form-horizontal" method="post">
				<input type="hidden" name="id" value="<?php echo ($id); ?>">
				<p class="text-center"><a href="<?php echo U('Project/leader?id='.$id);?>" class="btn_agree">继  续</a></p>
			</form>
		</div><?php endif; ?>
</div>

	<!-- /主体 -->

	<!-- 底部 -->
	</div>
<!-- 底部================================================== -->

<script type="text/javascript">
$('input[name="agree"]').change(function() {
		var count = $("input:checked").length;
		if (count <= 0 ) {
			$(".btn-agree").attr('disabled', 'disabled');
		} else {
			$(".btn-agree").removeAttr('disabled');
		}
	});
	$("form").submit(function() {
		var count = $("input:checked").length;
		if (count <= 0) {
			alert('您必须同意并接受投风险申明书', 1);
			return false;
		}
		var form = $(this);
		$.post(form.attr('action'), form.serialize(), function(data) {
			if (data.status == "1") {
				alert(data.info);
				window.location.href = data.url;
			} else {
				alert(data.info);
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