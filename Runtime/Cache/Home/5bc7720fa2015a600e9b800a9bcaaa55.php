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

    <link href="/Public/Mobile/css/index.css" rel="stylesheet">

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
	



    <div style="display: none;" id="server-data">
        <input type="hidden" name="qsStatus" value="<?php echo ($_GET['status']); ?>">
    </div>
    <script>
        var serverData = {};
        $('#server-data').children().each(function () {
            var $this = $(this);
            serverData[$this.attr('name')] = $this.val()
        });
    </script>
    <div class="wrapper">
        <div class="main">
            <section>
                <div id="tab" class="tab">
                    <a href="<?php echo U('list/mobileproject/status/0');?>" data-status="0">全部项目</a>
                    <a href="<?php echo U('list/mobileproject/status/1');?>" data-status="1">众筹中</a>
                    <a href="<?php echo U('list/mobileproject/status/2');?>" data-status="2">预热中</a>
                    <a href="<?php echo U('list/mobileproject/status/3');?>" data-status="3">已成功</a>
                    <script>
                        !function () {
                            $('#tab').find('[data-status=' + serverData.qsStatus + ']').addClass('selected')
                        }()
                    </script>
                </div>
                <div class="list">

                    <?php if(is_array($projectsList)): foreach($projectsList as $key=>$project): ?><a href=" <?php echo U('Project/detail',array('id'=>$project['id']));?>">
                            <div class="item">
                                <?php if($project["stage"] == 4): ?><input type="hidden" class="detail_url"
                                           value="<?php echo U('Project/detail?id=' . $project['id']);?>"><?php endif; ?>
                                <div class="img">
                                    <img src="<?php echo (get_cover($project['cover'],'path')); ?>">

                                    <div class="stamp">
                                    </div>
                                    <?php if($project['finish_rate'] > 100): ?><div class="tag">
                                        </div><?php endif; ?>

                                    <div class="digg">
                                        <b class="if icon-star"><?php echo ($project["attach_count"]); ?></b>
                                        <b class="if icon-comment"><?php echo ($project["comment_count"]); ?></b>
                                        <b class="if icon-eye"><?php echo ($project["read_record"]); ?></b>
                                    </div>

                                    <?php if(($project["stage"] == 1) and ($project["leader_id"] == 0)): ?><div class="leader-magnifier"><a
                                                href="<?php echo U('project/leader_info?id='.$project['id']);?>">寻找领投人</a></div><?php endif; ?>
                                </div>
                                <div class="text">
                                    <div class="title">
                                        <i class="gq">&nbsp;</i>
                                        <?php echo ($project["project_name"]); ?>
                                    </div>
                                    <div class="prograss">
                                        <?php if(($project["stage"]) == "1"): ?><div class="bar animateBar" data-animatetarget="0" style="width:0%;"></div>
                                            <?php else: ?>
                                            <div class="bar animateBar"
                                                 data-animatetarget="<?php echo ($project['finish_rate'] > 100 ? 100 :$project['finish_rate']); ?>"
                                                 style="width:<?php echo ($project['finish_rate'] > 100 ? 100 :$project['finish_rate']); ?>%;"></div><?php endif; ?>

                                    </div>
                                    <div class="attr">
                                        <dl>
                                            <dd class="d1">
                                                <h4>目标额</h4>
                                                <h3><span class="animateNum"
                                                          data-animatetarget="<?php echo round($project['need_fund']/10000,2);?>"><?php echo round($project['need_fund']/10000,2);?></span>万
                                                </h3>
                                            </dd>
                                            <dd class="d2">
                                                <h4>已完成</h4>
                                                <h3>
                                                    <?php if(($project["stage"]) == "1"): ?><span class="animateNum" data-animatetarget="0"> 0</span>
                                                        <?php else: ?>
                                                        <span class="animateNum"
                                                              data-animatetarget="<?php echo (round($project['finish_rate'],2)); ?>"> <?php echo (round($project["finish_rate"],2)); ?></span><?php endif; ?>
                                                    %
                                                </h3>
                                            </dd>
                                            <dd class="d3">
                                                <h4>已认投</h4>
                                                <h3>
                                                    <?php if(($project["stage"]) == "1"): ?><span class="animateNum" data-animatetarget="0">0</span>
                                                        <?php else: ?>
                                                        <span class="animateNum"
                                                              data-animatetarget="<?php echo round($project['has_fund']/10000,2);?>"><?php echo round($project['has_fund']/10000,2);?></span><?php endif; ?>
                                                    万
                                                </h3>
                                            </dd>
                                        </dl>
                                    </div>
                                    <div class="tags">
                                        <span><?php echo getDistrict($project['province']);?></span>
                                        <span><?php echo getDistrict($project['city']);?></span>
                                    </div>
                                </div>
                            </div>
                        </a><?php endforeach; endif; ?>
                    <!--//item-->

                </div>
            </section>

            <?php if($_GET['status'] == 1): ?><div class="fund_fot" style="display:none">
                    <div class="fund">
                        <a class="btn-buy" href="#">我要投资</a>
                    </div>
                </div><?php endif; ?>
        </div>
    </div>


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