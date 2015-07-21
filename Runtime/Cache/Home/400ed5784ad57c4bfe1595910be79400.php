<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
  <meta name="keywords" content="创业,投资,理财,众筹,融资" />  
  <meta name="description" content="中瀛智募（上海）文化传媒有限公司（简称“中瀛智募”）由蔡远游先生于2014年6月创立于上海市（2015年5月更名），系以股权众筹方式筹建的有限责任 公司，是为创业者和天使投资人提供快速对接的众筹服务平台，是一家开放的、以发起和支持创业梦想为主的股权众筹服务平台，是以创业、投资、传播交互发展的 互联网社区。
在“大众创业、万众创新”的新时代，我决定采取众筹的手段，在上海筹建、成立一家以经营众筹网站、天使茶馆为主，以为创业青年找资金、为投资人找项目为主要运营目的的新型互联网企业，她的名字叫“中瀛智募”。
只要您认同中瀛智募的理念、规则，诚挚邀请你加入我们的行列，共同成为中瀛智募的众筹股东！
只要您与我们、与创业者拥有相同的理念和价值认同，只要您愿意支持青年的创业。诚挚邀请您成为中瀛智募平台众筹项目的天使投资人。"/>   


<link href="/Public/Home/css/common.css" rel="stylesheet">
<link href="/Public/top.png" type="image/png" rel="shortcut icon">

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="/Public/static/bootstrap/js/html5shiv.js"></script>
<![endif]-->


    <link rel="stylesheet" type="text/css" href="/Public/Home/css/pay.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/validform.css"/>
    <style>
        .offline-tips {
            background-color: #f06230;
            color: #fff;
            font-size: 16px;
            line-height: 28px;
            border-radius: 15px;
            -webkit-border-radius: 15px;
            -moz-border-radius: 15px;
            padding: 0 20px;
            display: table;
        }

        .offline-tips-info {
            font-size: 14px;
            color: #f06230;
        }

        .offline-payway {
            border-bottom: 1px solid #ccc;
            padding-bottom: 20px;
        }

        .payway-title {
            color: #81c0e3;
            font-size: 16px;
            line-height: 40px;
            font-weight: bolder;
        }

        .payway-title .num {
            border: 1px solid #81c0e3;
            display: inline-block;
            line-height: 40px;
            border-radius: 50%;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            width: 40px;
            text-align: center;
            font-size: 20px
        }

        .payway-title .title {
            display: inline-block;
            margin: 0 10px;
        }

        .offline-content p {
            margin: 5px;
            font-size: 14px;
            line-height: 18px
        }

        .offline-content p span {
            color: #f06230;
        }

        .bank-pay-tip {
            color: #666;
            font-size: 14px;
            margin-top: 15px;
        }
        .bank-pay-tip i {
            color: #81c0e3;
            font-style: normal;
        }
    </style>

<!--[if lt IE 9]>
<script type="text/javascript" src="/Public/static/jquery-1.10.2.min.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
<title><?php echo ($pageTitle); ?>—<?php echo C('WEB_SITE_TITLE');?></title>
<!--<![endif]-->
<script type="text/javascript" src="/Public/Home/js/common.js"></script>
<script type="text/javascript" src="/Public/static/layer/layer.min.js"></script>
<script>
	var _hmt = _hmt || [];
	(function() {
	  var hm = document.createElement("script");
	  hm.src = "//hm.baidu.com/hm.js?c18b08cac9b94bf4628c0277d3a4d7de";
	  var s = document.getElementsByTagName("script")[0]; 
	  s.parentNode.insertBefore(hm, s);
	})();
</script>

<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->
<?php echo hook('pageHeader');?>

</head>
<body>
	<!-- 头部 -->
	<!--[if lte IE 7]>
<div id="update-browser"
     style="background:#8E8E8E;color:white;width:960px;line-height:42px;position:absolute;left:50%;margin-left:-480px;z-index:9999;text-align:center;bottom:auto;:top:expression(eval(document.documentElement.scrollTop+document.documentElement.clientHeight-this.offsetHeight-(parseInt(this.currentStyle.marginTop,10)||0)-(parseInt(this.currentStyle.marginBottom,10)||0)));">
    <span>
        您的浏览器版本过低。为保证最佳投资体验，您可以<a href="http://rj.baidu.com/soft/detail/14744.html" style="color:white">点击下载</a>
        <a href="http://rj.baidu.com/soft/detail/14744.html"
           style="color:white;text-decoration:underline;background:url('/Public/Home/images/chrome.png') 5px -2px no-repeat;padding-left:25px;">
            谷歌浏览器
        </a>
    </span>
    <a href="#" style="position:absolute;right:15px;top:0;color:white"
       onclick="document.getElementById('update-browser').style.display='none';return false;">以后再说 <span
            style="font-weight:bold">×</span></a>
</div>
<![endif]-->
<!-- 头部导航栏 -->
<div class="topbar">
    <div class="contentw">
        <div class="content">
            <h1 class="logo"><a href="<?php echo U('Index/index');?>">中瀛智募</a></h1>
            <ul class="nav" style="left:350px">
                <li><a href="<?php echo U('Index/index');?>">首页</a></li>
                <li><a href="<?php echo U('List/index',array('type'=>1,'status'=>0,'p'=>1));?>">股权众筹</a></li>
                <li><a href="<?php echo U('Pubwelfare/index');?>">公益众筹</a></li>
                <li><a href="<?php echo U('List/index',array('type'=>2,'status'=>0,'p'=>1));?>">实物众筹</a></li>
            </ul>
            <div class="top_login">
                <?php if(is_login()): ?><a href="<?php echo U('MCenter/index');?>" class="hover-link">
                        <img class="avatar" src="<?php echo get_memberface();?>" alt=""><!--<?php echo get_username();?>-->
                        <span class="tri"></span>
                    </a>

                    <div id="user-menu-box" class="user-menu-box">
                        <ul>
                            <li>
                                <a class="menu-item" href="<?php echo U('MCenter/index');?>">用户中心</a>
                            </li>
                            <li>
                                <a class="menu-item" href="<?php echo U('MCenter/pj_support');?>">股权众筹</a>
                                <a class="menu-item" href="<?php echo U('MCenter/pr_support');?>">实物众筹</a>
                                <a class="menu-item" href="<?php echo U('MCenter/stock');?>">股票基金</a>
                            </li>
                            <li class="last">
                                <!--<a class="menu-item" href="<?php echo U('User/detail');?>">个人资料</a>-->
                                <a class="menu-item" href="<?php echo U('Account/index');?>">账户管理</a>
                                <a class="menu-item" href="<?php echo U('User/logout');?>">安全退出</a>
                            </li>
                        </ul>
                        <div class="tri-box">
                            <div class="tri tri0"></div>
                            <div class="tri tri1"></div>
                            <div class="tri tri2"></div>
                        </div>
                    </div>
                    <!--<a href="<?php echo U('User/logout');?>" class="reg2">退出</a>-->
                    <?php else: ?>
                    <a href="<?php echo U('User/login');?>" class="reg">登录</a>
                    <a href="<?php echo U('User/register');?>" class="reg2">注册</a><?php endif; ?>
            </div>
        </div>

    </div>
    <div class="topbarbg"></div>
</div>
<script>
    var userDropdownMenu = function () {
        var $userMenuBox = $('#user-menu-box');
        $('.top_login').hover(function () {
                    $userMenuBox.fadeIn('fast');
                }, function () {
                    $userMenuBox.fadeOut();
                }
        );
    };
    userDropdownMenu();

</script>
	<!-- /头部 -->
	
	<!-- 主体 -->
	


    <div class="fl w100 mt25 order">
        <div class="content border1">
            <div class="con">
                <div class="p1 clearfix">
                    <p class="le pay-cash">
                        <?php if($data[type] != 9): ?>支付
                            <?php else: ?>
                            充值<?php endif; ?>
                        金额<b><?php echo ($data["pay_amount"]); ?></b>元
                    </p>
                    <p class="rt pay-flow">交易流水：<span><?php echo ($data["merorderid"]); ?></span></p>
                </div>
                <?php if(($data["type"] != 9) AND ($account["use_able"] > 0)): ?><div class="balance p1" id="balance">
                        <p class="pay-cash">可用余额<b><?php echo ($account["use_able"]); ?></b>元</p>
                        <img class="selected" src="/Public/Home/images/banklist/selected.png" alt="">
                        <input type="hidden" name="use_able" value="<?php echo ($account["use_able"]); ?>">
                        <input type="hidden" name="pay_amount" value="<?php echo ($data["pay_amount"]); ?>">
                        <input type="hidden" name="need_amount" value="<?php echo ($data["pay_amount"]); ?>">
                    </div><?php endif; ?>
                <hr style="margin:20px 0 10px">
                <?php if(($data["type"] != 9) AND ($account["use_able"] > 0)): ?><div class="p1" id="other1">
                        <p class="pay-cash">充值金额<b id="need_amount"><?php echo ($data["pay_amount"]); ?></b>元</p>
                    </div><?php endif; ?>
                <!--<div class="pay-way">-->
                    <!--<?php if(!empty($mycards)): ?>-->
                        <!--<div class="p2">-->
                            <!--<p>我的银行卡（共 <span><?php echo (count($mycards)); ?></span> 张）</p>-->
                            <!--<ul class="cardlist clearfix quick-list">-->
                                <!--<?php if(is_array($mycards)): $i = 0; $__LIST__ = $mycards;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>-->
                                    <!--<li data-id="<?php echo ($vo["id"]); ?>"><a>-->
                                        <!--<?php if(!empty($vo["normal_logo"])): ?><img src="<?php echo ($vo["normal_logo"]); ?>"><?php endif; ?>-->
                                        <!--<span>尾号 <?php echo (substr($vo["cardno"],"-4")); ?> | <?php if(($vo["cardtype"]) == "1"): ?>借记卡-->
                                            <!--<?php else: ?>-->
                                            <!--信用卡-->
                                        <!--<?php endif; ?></span>-->
                                        <!--<img class="selected" src="/Public/Home/images/banklist/selected.png" alt=""></a></li>-->
                                <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
                            <!--</ul>-->
                        <!--</div>-->
                    <!--<?php endif; ?>-->
                    <!--<div class="bank-select">-->
                        <!--<div class="tab">-->
                            <!--<ul class="clearfix">-->
                            <!--<li class="active"><a id="tab-normal" href="#tab-content1">网银支付</a></li>-->
                                <!--<li><a id="tab-quick" href="#tab-content2">快捷支付</a></li>-->
                                <!--<li class="active"><a id="tab-offline" href="#tab-content3">线下支付</a></li>-->
                            <!--</ul>-->
                        <!--</div>-->
                        <!--<div class="tab-list">-->
                            <!--<div id="tab-content1" class="tab-content active">-->
                                <!--<ul class="banklist clearfix" id="normal-list">-->
                                    <!--<?php if(is_array($normal)): $i = 0; $__LIST__ = $normal;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>-->
                                        <!--<li data-code="<?php echo ($vo["normal_code"]); ?>"><a>-->
                                            <!--<?php if(!empty($vo["normal_logo"])): ?><img src="<?php echo ($vo["normal_logo"]); ?>"-->
                                                                                 <!--alt="<?php echo ($vo["bank_name"]); ?>"><?php endif; ?>-->
                                            <!--<img class="selected" src="/Public/Home/images/banklist/selected.png"></a></li>-->
                                    <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
                                <!--</ul>-->
                                <!--<div class="btn-list"><a href="<?php echo U('Pay/normalpay?merorderid='.$data['merorderid']);?>"-->
                                                         <!--class="btn_red2" id="btn-pay1"><span>支 付</span></a></div>-->
                            <!--</div>-->
                            <!--<div id="tab-content2" class="tab-content">-->
                                <!--<div id="step1" class="pay-step active">-->
                                    <!--<ul class="banklist clearfix quick-list">-->
                                        <!--<?php if(is_array($quickpay)): $i = 0; $__LIST__ = $quickpay;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>-->
                                            <!--<li><a>-->
                                                <!--<?php if(!empty($vo["normal_logo"])): ?><img src="<?php echo ($vo["normal_logo"]); ?>"-->
                                                                                     <!--alt="<?php echo ($vo["bank_name"]); ?>">-->
                                                    <!--<?php else: ?>-->
                                                    <!--<?php echo ($vo["bank_name"]); ?>-->
                                                <!--<?php endif; ?>-->
                                                <!--<img class="selected" src="/Public/Home/images/banklist/selected.png"></a></li>-->
                                        <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
                                        <!--<?php if(($data["allow_creditcard"]) == "1"): ?>-->
                                            <!--<li class="pay-other">信用卡支付<img class="selected"-->
                                                                            <!--src="/Public/Home/images/banklist/selected.png"></li>-->
                                        <!--<?php endif; ?>-->
                                    <!--</ul>-->
                                    <!--<div class="btn-list"><a-->
                                            <!--href="<?php echo U('Pay/quickpay1?merorderid='.$data['merorderid']);?>"-->
                                            <!--class="btn_red2 pay-next" id="btn-quickpay"><span>下一步</span></a></div>-->
                                <!--</div>-->
                                <!--<div id="next-content"></div>-->
                            <!--</div>-->
                            <!--<div id="tab-content3" class="tab-content active">-->
                                <!--<div class="clearfix">-->
                                    <!--<div class="le">-->
                                        <!--<p class="offline-tips">特别提示</p>-->
                                        <!--<p class="offline-tips-info">为了您的投资权益，请使用本人银行卡或支付宝账户进行线下支付。<br>-->

                                            <!--线下支付前后可添加中瀛智募微信客服号咨询支付问题。中瀛智募客服微信号：jumu86858285</p>-->
                                    <!--</div>-->
                                    <!--<div class="rt">-->
                                        <!--<img src="/Public/Home/images/service_barcode.jpg" alt="" class="barcode">-->
                                    <!--</div>-->
                                <!--</div>-->
                                <!--<div class="offline-payinfo">-->
                                    <!--<div class="offline-payway">-->
                                        <!--<p class="payway-title"><span class="num">1</span><span-->
                                                <!--class="title">微信账户</span></p>-->
                                        <!--<div class="offline-content">-->
                                            <!--<p>账户名称：杭州聚道投资管理有限公司</p>-->
                                            <!--<p>支付宝账户：jdtz2015@sina.com <span>（转账备注“项目名称+手机号码”）</span></p>-->
                                        <!--</div>-->
                                    <!--</div>-->
                                    <!--<div class="offline-payway">-->
                                        <!--<p class="payway-title"><span class="num">2</span><span-->
                                                <!--class="title">银行账户</span></p>-->
                                        <!--<div class="offline-content">-->
                                            <!--<p>开户名称：杭州聚道投资管理有限公司</p>-->
                                            <!--<p>开户账户：3301 0401 6000 2243 627-->
                                                <!--<span>（打款后请联系客服微信或拨打 0571 - 86858285 确认打款状态）</span></p>-->
                                            <!--<p>开户银行： 杭州银行南山支行</p>-->
                                        <!--</div>-->
                                    <!--</div>-->
                                    <!--<div class="bank-pay-tip">-->
                                        <!--在收到您的投资款后，我们会在1~2个工作日内，修改您的投资状态为<i>【已支付】</i>。 再次感谢您的支持。-->
                                    <!--</div>-->
                                <!--</div>-->
                            <!--</div>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
                <!--<?php if($data["type"] != 9): ?>-->
                    <!--<div class="balance-pay">-->
                        <!--<div class="btn-list"><a href="<?php echo U('Pay/usebalance?merorderid='.$data['merorderid']);?>"-->
                                                 <!--class="btn_red2" id="btn-balance"><span>支 付</span></a></div>-->
                    <!--</div>-->
                <!--<?php endif; ?>-->
                <div class="pay-warning">
                    <p class="pay-title">温馨提醒：</p>
                    <p>1. 请使用您本人的银行卡进行充值。</p>
                    <p>2. 您的账户资金将由第三方平台托管。 </p>
                    <p>3. 为了您的资金安全，请您在充值前完成手机绑定及身份认证。 </p>
                    <!--<p>4. 充值过程遇到问题，请联系客服，0571 - 86858285</p>-->
                </div>
            </div>
        </div>
    </div>

	<!-- /主体 -->

	<!-- 底部 -->
	<!-- 底部================================================== -->

<!-- 新加 -->
<div class="fl w100 foot">
    <div class="foot_warp">
        <!--<div class="foot_top"><img src="/Public/Home/images/foot_smile.png"></div>-->
        <!--<h1>智汇于众，募瀛天下</h1>-->
        <ul class="foot_text">
            <li><a target="_blank" href="<?php echo U('Info/show?key=about');?>">关于我们</a> 丨</li>
            <li><a target="_blank" href="<?php echo U('Info/show?key=xinshouzhiyin');?>">新手指引</a> 丨</li>
            <li><a target="_blank" href="<?php echo U('Info/show?key=agreement');?>">用户协议</a> 丨</li>
            <li><a target="_blank" href="<?php echo U('Info/show?key=shenmingshu');?>">风险提示</a> 丨</li>
            <li><a target="_blank" href="<?php echo U('Info/show?key=fenpei');?>">利益分配</a></li>
   <!--         <li><a target="_blank" href="http://bbs.dreammove.cn">聚慧社区</a></li>	-->
        </ul>
        <div style="clear:both;"></div>
        <div class="foot_bottom">
            <ul class="foot_tg">
                <li class="wx">
                    <a target="_blank" class="footer-weixin">微信</a>
                    <span class="weixin-qrcode"><img src="/Public/Home/images/weixin.jpg" alt=""></span>
                </li>
    <!--            <li class="wb"><a href="http://weibo.com/jumuzhongchou" target="_blank">新浪微博</a></li>	-->
                <li class="dh">021-65800910</li>
                <li class="yx"><a target="_blank" href="mailto:service@e5656.cn">service@e5656.cn</a></li>
            </ul>
        </div>
        <div class="foot_tag">Copyright (c) 2015 中瀛智募（上海）文化传媒有限公司 沪ICP备15008911号</div>
    </div>
</div>
<!-- 新加 -->
<script type="text/javascript">
(function(){
	var ThinkPHP = window.Think = {
		"ROOT"   : "", //当前网站地址
		"APP"    : "", //当前项目地址
		"PUBLIC" : "/Public", //项目公共目录地址
		"DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
		"MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
		"VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
	}
})();
</script>

    <script type="text/javascript" src="/Public/static/Validform_v5.3.2.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#balance").click(function () {
                var _this = $(this);
                if (_this.hasClass('select')) {
                    _this.removeClass('select');
                } else {
                    _this.addClass('select');
                }
                checkBalance();
                $("#tab-normal").click();
            });

            function checkBalance() {
                var use_able = parseFloat($('input[name="use_able"]').val());
                var pay_amount = parseFloat($('input[name="pay_amount"]').val());
                if (!$("#balance").hasClass('select')) {
                    use_able = 0;
                }
                if (use_able >= pay_amount) {
                    $('input[name="need_amount"]').val(0);
                    $('.balance-pay').show();
                    $('.pay-way').hide();
                    $("#other1").hide();
                } else {
                    var need_amount = pay_amount - use_able;
                    $('input[name="need_amount"]').val(need_amount);
                    $('.balance-pay').hide();
                    $("#need_amount").html(need_amount);
                    $("#other1").show();
                    $('.pay-way').show();
                }
            }

            $("#btn-balance").click(function () {
                var url = $(this).attr('href');
                $.post(url, function (data) {
                    if (data.status == 1) {
                        layer.alert(data.info, 9, function () {
                            window.location.href = data.url;
                        });
                    } else {
                        layer.alert(data.info, 8, function () {
                            window.location.reload();
                        });
                    }
                });

                return false;
            });
            $("#btn-pay1").click(function () {
                // 网银支付
                var active = $('#normal-list li.active');
                if (active.length == 0) {
                    layer.alert("请选择您要用于支付的银行。");
                    return false;
                }
                var code = $(active).attr('data-code');
                var _this = $(this);
                var use_able = $('input[name="use_able"]').val();
                if (!$("#balance").hasClass('select')) {
                    use_able = '0';
                }
                var url = _this.attr('href') + '?bankcode=' + code + '&balance=' + use_able;
                _this.attr('href', url);
            });

            $('#btn-quickpay').click(function () {
                // 快捷支付
                var active = $('.quick-list li.active');
                if (active.length == 0) {
                    layer.alert("请选择您要用于支付的银行。");
                    return false;
                }
                var _this = $(this);
                var id = active.attr("data-id");
                var url = _this.attr('href');

                var use_able = $('input[name="use_able"]').val();
                if (!$("#balance").hasClass('select')) {
                    use_able = '0';
                }

                $.get(url, {id: id, balance: use_able}, function (data) {
                    if (data.status == 1) {
                        $('#step1').hide();
                        $("#next-content").load(data.url);
                    } else {
                        layer.alert(data.info);
                    }
                }, 'json');
                return false;
            });

            $(".cardlist li a").click(function () {
                $('#tab-quick').click();
            });

            // tab选择处理
            $(".tab ul li a").click(function () {
                var ul = $(this).parents('ul');
                var parent = $(this).parent('li');

                ul.children('li').removeClass('active');
                parent.addClass('active');

                var id = $(this).attr('href');
                $('.tab-content').removeClass('active');
                if (id == "#tab-content2") {
                    $('#step1').show();
                    $("#next-content").html("");
                } else {
                    $(".cardlist li").removeClass('active');
                }
                $(id).addClass('active');
                return false;
            });

            // 银行列表处理
            $(".banklist li,.cardlist li").click(function () {
                $(".banklist li,.cardlist li").removeClass('active');
                $(this).addClass('active');
            });
        });
    </script>
 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden" style="display:none;"><!-- 用于加载统计代码等隐藏元素 -->
    <script src="http://s6.cnzz.com/z_stat.php?id=1253481980&web_id=1253481980" language="JavaScript"></script>
    
</div>

	<!-- /底部 -->
</body>
</html>