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

<link href="/Public/Home/css/validform.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/Public/Mobile/css/login.css" />

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
	



<section id="data_main">
  <form action="<?php echo U();?>" method="POST" class="form">
  <div class="user_datatt">
    <div class="user_data">
      <h2><b>昵&nbsp;&nbsp;称：</b>
      <input name="user[nickname]" type="text" placeholder="请输入你的昵称" datatype="s1-30" maxlength="30" 
       nullmsg="请输入您的昵称" value="<?php echo ($user["nickname"]); ?>" errormsg="昵称至少3个字符，最多30个字符" class="recharge_je"></h2>
    </div>
  </div>
  <div class="user_datatt">
    <div class="user_data">
      <h2>
      <b>性&nbsp;&nbsp;别：</b>
      <label class="dcwj1"><input type="radio" name="detail[sex]" <?php if(($detail["sex"]) == "1"): ?>checked<?php endif; ?> value="1" id="sex1">男</label>
        <label class="dcwj1"><input type="radio" name="detail[sex]" <?php if(($detail["sex"]) == "2"): ?>checked<?php endif; ?> value="2" id="sex2">女</label>
        <label class="dcwj1"><input type="radio" name="detail[sex]" <?php if(($detail["sex"]) == "0"): ?>checked<?php endif; ?> value="0" id="sex0">保密</label>
      </h2>
    </div>
  </div>
  <div class="user_datatt">
    <div class="user_data">
      <h2><b>出生日期：</b>
      <input name="detail[birthday]" type="text" placeholder="日期如1981-08-08" datatype="*" maxlength="10" 
       nullmsg="请输入生日" value="<?php echo ($detail["birthday"]); ?>" class="recharge_je" id="">
      </h2>
    </div>
    
  </div>
  <div class="user_datatt">
    <div class="user_data">
      <h2><b>邮&nbsp;&nbsp;箱：</b>
      <input name="detail[email]" maxlength="40" datatype="e" nullmsg="请输入电子邮箱" type="text" placeholder="请输入你的电子邮箱" value="<?php echo ($detail["email"]); ?>" class="recharge_je" id="mail"></h2>
    </div>
    
  </div>
  
  
  <div class="user_datatt">
    <div class="user_data">
      <h2><b>所在地：</b>
      <div class="select">
        <?php echo hook('J_China_City', array('province'=>$detail['province'], 'city'=>$detail['city']));?>
        </div>
      </h2>
    </div>
    
  </div>
  
  <div class="user_datatt">
    <div class="user_data">
      <h2><b>详细地址：</b>
      <input name="detail[address]" type="text" placeholder="请填写详细地址"  class="recharge_je" id="address" value="<?php echo ($detail["address"]); ?>"></h2>
    </div>
  </div>
  <div class="user_datatt">
    <div class="user_data">
      <h2><b>微博地址：</b>
      <input name="detail[weibo]" type="text" placeholder="请输入你的微博地址"  class="recharge_je" id="weibo" value="<?php echo ($detail["weibo"]); ?>"></h2>
    </div>
  </div>
    <div class="error-box">
      <span id="errormessage"></span>
    </div>
  <div class="recharge_qd1">
  <input name="" type="submit" class="recharge_qd" value="保&nbsp;&nbsp;存">
  </div>
    </form>
</section>

	<!-- /主体 -->

	<!-- 底部 -->
	</div>
<!-- 底部================================================== -->

<script type="text/javascript" src="/Public/Home/js/laydate/laydate.js"></script>
<script type="text/javascript" src="/Public/static/Validform_v5.3.2.js"></script>
<script>
$("select").addClass('data_sf');
$(function() {
  $(".form").Validform({
    tiptype: function(msg, o, cssctl) {
      var objtip = $("#errormessage");
      objtip.text('');
      if (o.type == 3) {
        objtip.text(msg);
      }
    }, ajaxPost: true,
    beforeSubmit:showWaiting,
    callback: function(data) {
      if (data.status == 1) {
        alert(data.info);
        window.location.href="<?php echo U('MCenter/index');?>"
      }
    }
  });
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