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
        <div id="jm_logo">
            <img width="100%" src="/Public/Mobile/images/jm-logo.png">
        </div>

        <div class="jm_login login-form-container">
            <form method="post" action="<?php echo U();?>">
                <ul>
                    <li>
                        <div class="bind-header">
                            <div class="h1">你的微信还未绑定聚募帐号</div>
                            <div class="h2">请输入帐号密码，完成绑定</div>
                        </div>
                    </li>
                    <li>
                        <div class="text" style="left: 0px;">
                            <i class="user"></i>
                            <input name="username" type="text" placeholder="用户名/手机号" maxlength="15" datatype="*"
                                   nullmsg="请输入用户名或手机号码" errormsg="用户名或密码输入不正确">
                        </div>
                    </li>
                    <li>
                        <div class="text">
                            <i class="lock"></i>
                            <input name="password" datatype="*" nullmsg="请输入密码" errormsg="密码输入不正确" type="password"
                                   placeholder="密码">
                        </div>
                    </li>
                    <li>
                        <div class="error-box" style="clear:both;">
                            <span id="errormessage"></span>
                        </div>
                    </li>
                    <li>
                        <div class="social-login-box">
                            <a href="#" title="微信登陆" class="wx-login-button">微信登陆</a>
                        </div>
                    </li>

                    <input type="submit" class="btn login-submit-btn" value="登录">
                    <li class="zcdl_ys">
                        <div class="lft">
                            <a href="forget.html">忘记密码</a>
                        </div>
                        <div class="rgt">
                            <a href="register.html">立即注册</a>
                        </div>
                    </li>
                </ul>
            </form>
        </div>

    </section>

	<!-- /主体 -->

	<!-- 底部 -->
	</div>
<!-- 底部================================================== -->

    <script type="text/javascript" src="/Public/static/Validform_v5.3.2.js"></script>
    <script type="text/javascript">
        $(function () {
            $("ul li input").each(function () {
                $(this).click(function () {
                    $(this).parent().removeClass('text').addClass('text errorAnimate');
                    $(this).parent().parent().siblings().children().removeClass('errorAnimate');
                })
            });

            $('form').Validform({
                tiptype: function (msg, o, cssctl) {
                    var objtip = $("#errormessage");
                    o.obj.parents("div").removeClass('errorAnimate');
                    objtip.text('');
                    if (o.type == 3) {
                        o.obj.parents("div").addClass('errorAnimate');
                        objtip.text(msg);
                    }
                }, ajaxPost: true,
                beforeSubmit: showWaiting,
                callback: function (data) {
                    if (data.status == 1) {
                        window.location.href = sessionStorage.getItem('loginRedirect') || data.url || '/';
                        sessionStorage.removeItem('loginRedirect')
                    }
                }
            });
            var isWeixin = navigator.userAgent.toLowerCase().indexOf('micromessenger') != -1;

            if (isWeixin) {
                var $loginFormContainer = $('.login-form-container').addClass('weixin');
                var getQS = function (key) {
                    var value = location.pathname.match(new RegExp('/' + key + '/([^/\.]+)'));
                    return value && value[1];
                };
                var type = getQS('type');
                if (type === 'bind') {
                    $loginFormContainer.addClass('bind');

                    var data = {
                        openid: getQS('openid')
                    };

                    $('.login-submit-btn').val('绑定').click(function () {
                        data.username = $('input[name=username]').val();
                        data.password = $('input[name=password]').val();
                        if (!data.username) {return}
                        if (!data.password) {return}
                        var $button = $(this);
                        $button.attr('disabled', 'true').addClass('disabled').text('正在绑定');
                        $.getJSON('/weixin/bindAccount', data).then(function (json) {
                            console.log(json);
                            if (json.success) {
                                $button.text('绑定成功 √');
                                location.href = json.url || '/MCenter/';
                                return 'success';
                            } else {
                                layer.open({
                                    content: json.info,
                                    style: 'text-align:center;',
                                    time: 1
                                });
                                return json.info
                            }
                        }, function () {
                            return 'fail';
                        }).then(function (result) {
                            if (result === 'success') {

                            } else {
                                $button.removeAttr('disabled').removeClass('disabled').text('绑定')
                            }
                        });
                        return false;
                    });
                    $('form').submit(function () {
                        return false;
                    })
                } else {
                    $('.wx-login-button').click(function () {
                        $.getJSON('/weixin/loginWxLink').then(function (json) {
                            if (json.success) {
                                location.href = json.url+'&response_type=code';
                            }
                        });

                    });
                }

            } else {
                $('.social-login-box').addClass('hidden');
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