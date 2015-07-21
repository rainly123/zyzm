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
	





    <link href="/Public/Mobile/css/project.css" rel="stylesheet">
    <script type="swaqQ " src="/Public/Mobile/js/jquery.easing.1.3.js"></script>
    <div class="wrapper" style="padding-bottom:60px;">


        <div class="dbanner">
            <div class="digg">
                <b class="if icon-star"><?php echo ($like_record); ?></b>
                <b class="if icon-eye"><?php echo ($read_record); ?></b>
            </div>

            <div class="bg"><img src="<?php echo (get_cover($mobile_img,'path')); ?>"/></div>
        </div>
        <div class="detail">
            <div class="item">
                <div class="head">
                    <h2><?php echo ($name); ?></h2>
                </div>
                <div class="body">
                    <?php echo ($abstract); ?>
                    <div class="tag">
                        <?php echo ($tags); ?>
                    </div>
                    <table class="prod-data-table">
                        <tr class="strong">
                            <td>￥<?php echo (change_fund($amount)); ?></td>
                            <td>￥<?php echo (change_fund($finish_amount)); ?></td>
                            <td class="animateNum" data-animatetarget="">
                                <?php
 if ($days - floor((time()-$start_time)/86400) >0) { print $days - floor((time()-$start_time)/86400) ;} else { print 0;} ?>天
                            </td>
                        </tr>
                        <tr>
                            <td>目标额</td>
                            <td>已筹金额</td>
                            <td>剩余天数</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="xiangmu">
                <a href="<?php echo U('Product/detailImg?pid='.$pid);?>"><span class="xmjs">项目介绍</span></a>

            </div>
            <div class="peoples">
                <ul>
                    <li>
                        <a href="<?php echo U('MCenter/profile?id='.$uid);?>">
                            <div class="img">
                                <img src="<?php if($uid > 0): echo (get_memberface($uid)); else: ?>/Public/Mobile/images/img9.jpg<?php endif; ?>">
                            </div>
                            <h2><?php echo (get_membername($uid)); ?></h2>
                            <span>发起人</span>
                        </a>
                    </li>

                </ul>
            </div>

            <div class="results">
                <div class="text">
                    <big><?php echo ($resultSupport); ?></big>人参与支持
                </div>

                <div class="imgs">
                    <?php if(!empty($supportlist)): ?><a href="<?php echo U('Product/invester_list?pid='.$pid);?>" class="more"></a><?php endif; ?>
                    <ul>
                        <?php if(is_array($supportlist)): foreach($supportlist as $key=>$vo): ?><li>
                                <a href="<?php echo U('MCenter/profile?id='.$vo['uid']);?>"><img
                                        src="<?php if($vo["uid"] > 0): echo (get_memberface($vo["uid"])); else: ?>/Public/Mobile/images/img9.jpg<?php endif; ?>"></a>
                            </li><?php endforeach; endif; ?>
                    </ul>

                </div>
            </div>


            <?php if(is_array($resultPrice)): foreach($resultPrice as $key=>$vo): ?><div class="item">
                    <div class="head">
                        <h2 class="hb1">￥<?php echo ($vo["amount"]); ?></h2>
                        <h3 class="hb1">
                            <?php if($vo[count] == 0): ?><span style="color:red"><?php echo ($vo["sell_count"]); ?>人支持</span>(不限)
                                <?php else: ?>
                                <span style="color:red"><?php echo ($vo["sell_count"]); ?>人支持</span>(限购<?php echo ($vo['count']); ?>人)<?php endif; ?>
                        </h3>
                        <em></em>
                    </div>
                    <div class="body">
                        <?php echo (nl2br($vo["content"])); ?><br>
                        <?php if($vo[post_amount] == 0): ?>包邮<br>
                            <?php else: ?>
                            配送费用：<?php echo ($vo["post_amount"]); ?><br><?php endif; ?>

                        预计发放时间：项目成功结束后<?php echo ($vo["afterday"]); ?>天内
                        <?php if(($status == 9) and ($stage == 2)): if($vo[count] == 0): ?><a href="<?php echo U('productOrder/info?priceId='.$vo['id'].'&customid='.$customid);?>"
                                   class="wom_zc"> 支持￥<?php echo ($vo["amount"]); ?></a>
                                <?php else: ?>
                                <?php if(($vo['count']-$vo['sell_count']) < 1):?>
                                <button type="button" class="wom_zc" disabled="true" style="background: #BAC0C3;">已售罄
                                </button>
                                <?php else:?>
                                <a href="<?php echo U('productOrder/info?priceId='.$vo['id'].'&customid='.$customid);?>"
                                   class="wom_zc"> 支持￥<?php echo ($vo["amount"]); ?></a>
                                <?php endif; endif; endif; ?>
                        <?php if($vo['pid'] == 1): if($vo['id'] == 1): ?><div style="text-align: center;">
                                    <img src="/Public/Home/images/barcode/jn1535.png" class="header">
                                </div>
                                <?php else: ?>
                                <div style="text-align: center;">
                                    <img src="/Public/Home/images/barcode/jn535.png" class="header">
                                </div><?php endif; endif; ?>
                    </div>
                </div><?php endforeach; endif; ?>

            <div class="item">
                <div class="head">
                    <h2 class="pl">项目评论</h2>
                    <em></em></div>
                <div class="body">
                    <div class="comments">
                        <ul>
                            <?php if(is_array($comments)): foreach($comments as $key=>$v): ?><li id="comment<?php echo ($v['id']); ?>">
                                    <div class="img">
                                        <a href="<?php echo U('MCenter/profile?id='. $v['comment_user']);?>"><img
                                                src="<?php echo (get_memberface($v['comment_user'])); ?>"></a>
                                    </div>
                                    <div class="text">
                                        <div class="addpost">
                                            <a class="btn-slide"
                                               href="<?php echo U('product/makereply',array('project_id'=>$v['project_id'],'reply_id'=>$v['id']));?>">回复</a>
                                        </div>
                                        <h2 class="comment-user-name"><?php echo (get_membername($v['comment_user'])); ?></h2>

                                        <?php if(!empty($v["parent"])): if(is_array($v["parent"])): $i = 0; $__LIST__ = $v["parent"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="pllist clearfix reply">
                                                    <?php echo (get_membername($vo["comment_user"])); ?>说：<?php echo ($vo["content"]); ?>
                                                </div><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                                        <p><?php echo ($v["content"]); ?></p>
                                    </div>
                                    <div class="c-c"><input type="hidden" class="comment_id"
                                                            value="<?php echo ($v["id"]); ?>"><textarea></textarea><br>
                                        <button class="btn-c-c">回复</button>
                                    </div>
                                </li><?php endforeach; endif; ?>

                        </ul>
                        <?php if(!empty($comments)): ?><div class="more">
                                <a href="<?php echo U('product/morecomment/pid/'.$id);?>">查看更多评论</a>
                            </div><?php endif; ?>

                    </div>
                </div>
            </div>

            <div class="item">
                <div class="head">
                    <h2 class="tj">推荐项目</h2>
                    <em></em>
                </div>
                <div class="body">
                    <ul class="pros">
                        <?php if(is_array($recomendList['project'])): foreach($recomendList['project'] as $key=>$v): ?><li>
                                <a href="<?php echo U('project/detail?id='.$v['id']);?>" title="中瀛智募">
                                    <div class="img">
                                        <img src="<?php echo (get_cover($v['cover'],'path')); ?>" alt="<?php echo ($v["project_name"]); ?>股权众筹">
                                    </div>
                                    <h2><?php echo ($v["project_name"]); ?></h2>
                                </a>
                            </li><?php endforeach; endif; ?>

                    </ul>
                </div>
            </div>

        </div>
        <div class="footnav">
            <div class="f">
                <a href="<?php echo U('product/postcomment/pid/'.$id);?>">评论留言</a>
            </div>
        </div>


    </div>
    <script src="/Public/Mobile/js/Chart.js"></script>
    <link href="/Public/Mobile/css/project.css" rel="stylesheet">
    <script type="swaqQ " src="/Public/Mobile/js/jquery.easing.1.3.js"></script>

    <script>
        var projectId = location.href.match(/id\/(\d+)\.html/);
        projectId = parseInt(projectId && projectId[1]) || 0;
        var config = {projectCommentAPI: '/product/comment/'};
        var radarChartData = {
            labels: ["团队", "市场", "竞争环境", "盈利能力", "创新"],
            datasets: [
                {
                    fillColor: "#fff0de",
                    strokeColor: "#fab14b",
                    pointColor: "#fab14b",
                    pointStrokeColor: "#fff",
                    data: [65, 59, 90, 81, 56]
                },
                {
                    fillColor: "#dcf2f0",
                    strokeColor: "#4fbdbc",
                    pointColor: "#4fbdbc",
                    pointStrokeColor: "#fff",
                    data: [28, 48, 40, 19, 46]
                },
                {
                    fillColor: "#fbe3df",
                    strokeColor: "#ed674c",
                    pointColor: "#ed674c",
                    pointStrokeColor: "#fff",
                    data: [33, 33, 44, 30, 96]
                }
            ]

        };

        $('.btn-slide').click(function () {
            location.hash = $(this).parents('.text').parent().attr('id');
            $(this).parents('.text').next().slideToggle().find('textarea').focus();
            return false;
        });


        $('.btn-c-c').click(function () {
            var $textarea = $(this).parent().find('textarea'),
                    commentId = $textarea.prev().val();

            var data = {
                project_id: projectId,
                content: $textarea.val(),
                reply_id: commentId
            };
            if (data.content.trim()) {
                $.post(config.projectCommentAPI, data, function (data) {
                    showCommentComment(data);
                    $textarea.val('');
                });
            } else {
                layer.open({
                    content: '请输入评论内容',
                    style: 'text-align:center; border:none;',
                    time: 2
                });
                $textarea.focus();
            }
            return false;
        });

        function showCommentComment(data) {
            location.reload();
        }

        /*var myRadar = new Chart(document.getElementById("canvas").getContext("2d")).Radar(radarChartData,{scaleShowLabels : false, pointLabelFontSize : 20});*/

        $('.wom_zc').click(function () {
            sessionStorage.setItem('loginRedirect', $(this).attr('href'));
        })

    </script>


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