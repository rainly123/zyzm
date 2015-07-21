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

    <link rel="stylesheet" href="/Public/Mobile/css/login.css">
    <link rel="stylesheet" href="/Public/Mobile/css/header.css">
    <link rel="stylesheet" href="/Public/Mobile/css/obj_project.css">
    <style>
        .low, .up {
            display: inline-block;
            width: 30px;
            height: 30px;
            margin: 0 5px;
            border: none;
            background: #eee;
        }

        .c3 {
            display: inline-block;
            width: 100px;
            height: 30px;
            border: none;
            background: #eee;
        }

        .center {
            width: 170px
        }

        .leader1 {
            font-size: 14px;
            margin: 10px;
        }

        .leader1 a {
            color: #72c2e5;
            text-decoration: underline;
        }

        .apply_leader {
            padding: 0 40px;
            border: 2px solid #999;
            cursor: pointer;
            display: inline-table;
            font-size: 16px;
            position: relative;
            line-height: 36px;
            border-radius: 4px;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            overflow: hidden;
        }

        .agreement1 {
            margin-left: 20px;
        }

        .apply_leader.active {
            border-color: #ed655a;
        }

        .apply_leader .selected {
            display: none;
            position: absolute;
            bottom: 0;
            right: 0;
        }

        .apply_leader.active .selected {
            display: block;
        }

        .agreement1 {
            display: inline-table;
        }
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
	



    <div id="server-data" style="display: none;">
        <input name="realNameAuthUrl" value="<?php echo U('User/realname');?>">
        <input name="bindMobileUrl" value="<?php echo U('User/changephone');?>">
    </div>
    <form action="<?php echo U('project/follow');?>" id="form-inquiry" method="post" class="form-horizontal">
        <input type="hidden" name="id" value="<?php echo ($project["id"]); ?>">
        <div class="docast">
            <div class="item">
                <div class="head">
                    <span>起投额: <big><?php echo (round($project["follow_fund"])); ?></big></span>
                </div>
                <div class="body">
                    <div class="title">
                        <span class="t1">融资信息</span>
                    </div>
                    <div class="infos">
                        <ul>
                            <li>
                                <h4>目标金额</h4>
                                <h2><?php echo (change_fund($project["need_fund"])); ?>元</h2>
                            </li>
                            <li>
                                <h4>出让比例</h4>
                                <h2><?php echo (round($project["rate_fund"],4)); ?>%</h2>
                            </li>
                            <li>
                                <h4>最终估值</h4>
                                <h2><?php echo (change_fund($project["final_valuation"])); ?>元</h2>
                            </li>
                        </ul>
                        <input type="hidden" id="follow_fund" value="<?php echo ($project["follow_fund"]); ?>">
                        <input type="hidden" id="need_fund" value="<?php echo ($project["need_fund"]); ?>">
                        <input type="hidden" id="valuation" value="<?php echo ($project["final_valuation"]); ?>">
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="body">
                    <div class="title">
                        <span class="t2">您的跟投金额</span>
                    </div>
                    <div class="addon">
                        <div class="center">
                            <div id="d" class="Spinner">
                                <a class="Decrease" onclick="opera('#myfund', false);"
                                   href="javascript:void(0)"><i>-</i></a>
                                <input class="Amount" id="myfund" value="<?php echo (round($project["follow_fund"],0)); ?>" datatype="n"
                                       maxlength="7" nullmsg="请输入投资金额" errormsg="投资金额必须为数字" name="fund"
                                       autocomplete="off" maxlength="7">
                                <a class="Increase" onclick="opera('#myfund', true);" href="javascript:void(0)"><i>+</i></a>
                            </div>
                        </div>
                        <div class="tips"><span id="hasrate"><?php echo (round($project["rate"],4)); ?></span>%</div>
                    </div>
                </div>
            </div>
            <?php if($project["vote_leader"] != 2): ?><div class="leader1">
                    <input type="hidden" name="leader_type" id="leader_type" value="0">
                    <p class="apply_leader">我要领投 <img class="selected" src="/Public/Home/images/banklist/selected.png" alt=""></p>
                    <p class="agreement1"><a href="<?php echo U('Project/leader_info?isread=1');?>">领投规则</a></p>
                </div><?php endif; ?>
            <div class="item">
                <div class="body">
                    <div class="title">
                        <span class="t3">投资理由</span>
                    </div>
                    <div class="addpost">
                        <textarea name="others" cols="" rows="4" style="font-size:14px;padding:3px;"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="castbtn">
            <a href="#" id="btn-invest">确认跟投</a>
        </div>
    </form>

	<!-- /主体 -->

	<!-- 底部 -->
	</div>
<!-- 底部================================================== -->

    <script type="text/javascript" src="/Public/static/Validform_v5.3.2.js"></script>
    <script type="text/javascript">
        var serverData = {};
        $('#server-data').children().each(function () {
            var $this = $(this);
            serverData[$this.attr('name')] = $this.val()
        });
        var api = {
            checkAuth: '/project/checkAuth'
        };
        $('#btn-invest').click(function () {
            $.getJSON(api.checkAuth).then(function (json) {
                if (!json.success) {
                    sessionStorage.setItem('authRedirect', location.href);
                    if (json.info.indexOf('实名认证') > -1) location.href = serverData.realNameAuthUrl;
                    else if (json.info.indexOf('手机') > -1) location.href = serverData.bindMobileUrl;
                } else {
                    $('#form-inquiry').submit();
                }
            });
            return false;
        });
        function opera(x, y) {
            var rs = new Number($(x).val());
            if (isNaN(rs)) {
                rs = 0;
            }
            if (y) {
                rs = rs + 1000;
            } else {
                rs = rs - 1000;
            }
            $(x).val(checkFund(rs));
        }
        $(".apply_leader").click(function () {
            var _this = $(this);
            if (_this.hasClass('active')) {
                $('#leader_type').val(0);
                _this.removeClass('active');
            } else {
                _this.addClass('active');
                $('#leader_type').val(1);
            }
        });
        function checkFund(v) {
            var min_follow = new Number($('#follow_fund').val());
            var max_follow = new Number($('#need_fund').val());
            var valuation = new Number($('#valuation').val());

            // 投资金额处理为1000的倍数
            v = Math.ceil(v / 1000) * 1000;
            if (v > max_follow) {
                v = max_follow;
            } else if (v < min_follow) {
                v = min_follow;
            }
            // 计算股份占比
            var rate = (Math.round(v * 1000000 / valuation) / 10000);
            $("#hasrate").html(rate);
            return v;
        }
        $('#myfund').blur(function () {
            var rs = new Number($("#myfund").val());
            if (isNaN(rs)) {
                rs = 0;
            }
            $("#myfund").val(checkFund(rs));
        });

        $('#form-inquiry').Validform({
            tipSweep: true,
            tiptype: function (msg, o, cssctl) {
                if (o.type == 3) {
                    alert(msg, 1);
                }
            }, ajaxPost: true,
            callback: function (data) {
                if (data.status == 1) {
                    alert(data.info);
                    window.location.href = data.url;
                }
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