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
<link href="/Public/Home/css/validform.css" rel="stylesheet" type="text/css">

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
	




<section id="jm_main">
  <div class="jm_login">
  <form method="post" class="form" action="<?php echo U();?>">
    <ul>
      <li>
          <div class="text">
              <i class="user"></i>
                <input type="text" name="mobile" id="phoneNo" datatype="n11-11" nullmsg="请输入手机号码" maxlength="11" errormsg="手机号码必须为11位数字" placeholder="请输入手机号">
            </div>
        </li>
      <li>
          <div class="text">
              <i class="mail"></i>
                <input name="code" placeholder="验证码" datatype="n" nullmsg="请输入验证码" maxlength="6" type="text" placeholder="短信验证码" >
                <input href="<?php echo U('sendsms');?>" type="button" value="获取验证码" class="getcode" id="cellcode_send">
            </div>
        </li>
      <li>
          <div class="text">
              <i class="lock"></i>
                <input name="password" type="password" placeholder="请输入新密码" datatype="*6-16" nullmsg="请输入新密码" errormsg="新密码至少6个字符，最多16个字符">
            </div>
        </li>
        <li>
          <div class="error-box"><span id="errormessage"></span></div>
        </li>
    </ul>
    <input name="" type="submit" class="btn" value="确定修改">
    </form>
  </div>
</section>

	<!-- /主体 -->

	<!-- 底部 -->
	</div>
<!-- 底部================================================== -->

<script type="text/javascript" src="/Public/static/Validform_v5.3.2.js"></script>
<script type="text/javascript">
$(function(){
  $("ul li input").each(function(){
      $(this).click(function(){
          $(this).parent().removeClass('text').addClass('text errorAnimate');
          $(this).parent().parent().siblings().children().removeClass('errorAnimate');
      })
  });

  $('form').Validform({
    tiptype: function(msg, o, cssctl) {
      var objtip = $("#errormessage");
      o.obj.parents("div").removeClass('errorAnimate');
      objtip.text('');
      if (o.type == 3) {
        o.obj.parents("div").addClass('errorAnimate');
        objtip.text(msg);
      }
    }, ajaxPost: true,
    beforeSubmit:showWaiting,
    callback: function(data) {
      if (data.status == 1) {
        window.location.href=data.url;
      }
    }});
});

  var longtime = 0;
  var id;
  $("#cellcode_send").click(function() {
    var phone = $('#phoneNo').val();
    if (longtime > 0) {return false;}
    showWaiting();
    $.post($(this).attr('href'), {'phone':phone, 'ischeck':1}, function(data) {
      if (data.status == 1) {
        longtime = 120;
        $('#cellcode_send').val('请稍等'+ longtime +'秒');
        // 倒计时
        id = setInterval(uptime, 1000);
      } else {
        alert(data.info);
      }
    });
    return false;
  });

  function uptime() {
    $('#cellcode_send').val('请稍等'+ longtime +'秒');
    longtime = longtime - 1;
    if (longtime <= 0) {
      clearInterval(id);
      $('#cellcode_send').val('获取验证码');
    }
  }

    $(function(){
      $(".login-form").Validform({tiptype:3, 
        ajaxPost:true,
        beforeSubmit:showWaiting,
        callback:function(data){
          if (data.status == '1') {
            alert(data.info);
            window.location.href = data.url;
          } else {
            $('.errormsg').html(data.info);
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