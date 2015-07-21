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
    <link href="/Public/Mobile/css/pay.css" rel="stylesheet" type="text/css">
    <link href="/Public/Mobile/css/layer.m/need/layer.css" rel="stylesheet" type="text/css">

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
    <div class="body">
        <div class="section amount-section">
            <div class="amount">支付金额：<strong>￥<?php echo round($amount,2);?></strong>元</div>
        </div>
        <div class="section special-tip-section">
            <div class="header"><em>特别提示</em></div>
            <div class="tip">
                <p>为了您的投资权益，请使用本人银行卡或微信账户进行线下支付。</p>
                <!--<p>线下支付前后可添加聚募微信客服号咨询支付问题。</p>-->
                <!--<p>聚募客服微信号：jumu86858285 </p>-->
                <p class="qr-box"><a id="show-serv-qr" href="#"> 查看二维码</a></p>
            </div>
        </div>
        <!--<div class="section account-section">-->
            <!--<div class="alipay-box">-->
                <!--<div class="title"><em>1</em>支付宝账户</div>-->
                <!--<div class="account">-->
                    <!--<p>账户名称：杭州聚道投资管理有限公司</p>-->
                    <!--<p>支付宝账号：jdtz2015@sina.com</p>-->
                <!--</div>-->
                <!--<div class="pay-tip">（转账备注“项目名称+手机号码”）</div>-->
            <!--</div>-->
            <!--<div class="bank-box">-->
                <!--<div class="title"><em>2</em>银行卡账户</div>-->
                <!--<div class="account">-->
                    <!--<p>开户名称：杭州聚道投资管理有限公司</p>-->
                    <!--<p>开户账号：3301 0401 6000 2243 627</p>-->
                    <!--<p>开户行：杭州银行南山支行</p>-->
                <!--</div>-->
                <!--<div class="pay-tip">（打款后请联系客服微信或拨打 0571-86858285 确认打款状态）</div>-->
            <!--</div>-->
        <!--</div>-->
        <!--<div class="section footer-tip-section">-->
            <!--在收到您的投资款后，我们会在1~2个工作日内，修改您的投资状态为<i>【已支付】</i>。 再次感谢您的支持。-->
        <!--</div>-->
        <div class="section btn-section">
            <a class="btn" href="javascript:history.back()">返 回</a>
        </div>
    </div>

	<!-- /主体 -->

	<!-- 底部 -->
	</div>
<!-- 底部================================================== -->

    <script src="/Public/Mobile/js/layer.m/layer.m.js"></script>
    <script type="text/javascript">
        $(function () {
            $('#show-serv-qr').click(function () {
                layer.open({
                    type: 1, //1代表页面层
                    content: '<img src="/Public/Mobile/images/Q640PX.jpg" style="width: 100%">',
                    style: 'width: 80%'
                    /*success: function(olayer){
                     var cla = 'getElementsByClassName';
                     olayer[cla]('closediy')[0].onclick = function(){
                     layer.close(pagei)
                     }
                     }*/
                });
                return false;
            });
            /*$("#btn-pay").click(function () {
             var _this = $(this);
             var url = _this.attr('href');
             $.get(url, $('form').serialize(), function (data) {
             if (data.status == 1) {
             if (data.info != '') {
             alert(data.info);
             }
             window.location.href = data.url;
             } else {
             alert(data.info);
             window.location.reload();
             }
             });
             });*/
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