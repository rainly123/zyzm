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
	
    <style>
        .item {
            background: #fff;
            clear: both;
            margin-top: 5px;
            border: #dddddd solid 1px;
            padding: 10px;
        }

        .comments li .img a img {
            width: 50px;
            border-radius: 50%;
        }

        .pros {
            height: auto;
            overflow: hidden;
            width: 100%;
        }

        .pros li {
            width: 50%;
            height: auto;
            overflow: hidden;
            float: left;
            display: inline;
            margin-bottom: 15px;
            font-size: 14px;
            border-bottom: #eaeaea dashed 1px;
            line-height: 30px;
            text-align: center;
        }

        .pros li .img1 {
            width: 90%;
            margin: 0 auto;
            height: 100px;
        }

        .pros li .img1 img {
            width: 100%;
            overflow: hidden;
        }

        .pros li a h2 {
            font: 14px/27px "微软雅黑";
            overflow: hidden;
            height: 27px;
        }

        /*comments */
        .item .comments {
            width: 100%;
        }

        .item .comments li {
            padding-bottom: 25px;
            margin-bottom: 20px;
            padding-left: 80px;
            position: relative;
        }

        .item .comments li .img {
            position: absolute;
            left: 10px;
            top: 10px;
            width: 16px;
            height: 16px;
        }

        .item .comments li .img img {
            width: 50px;
            height: 50px;
        }

        .item .comments li .text {
            padding-right: 10px;
        }

        .item .comments li .addpost a {
            position: absolute;
            color: #858585;
            right: 5px;
            top: 10px;
            border: #a8a8a8 solid 1px;
            width: 60px;
            height: 24px;
            font-size: 14px;
            text-align: center;
            line-height: 24px;
            border-radius: 4px;
        }

        .item .comments .comment-user-name {
            width: 73%;
        }

        .item .comments li h4 {
            font-size: 14px;
            color: #999999;
        }

        .item .comments li p {
            font: bold 16px/30px "微软雅黑";
        }

        .item .comments li .reply {
            background: #f2f2f2;
            padding: 10px;
            margin-top: 15px;
            color: #333;
            font: 14px/24px "微软雅黑";
        }

        .item .comments .more {
            padding: 10px 0;
            text-align: center;
        }

        .item .comments .more a {
            font: 18px/24px "微软雅黑";
        }

        .item .c-c {
            display: none;
            margin-top: 10px;
            padding-top: 10px;
            padding-right: 16px;
        }

        .item .c-c textarea {
            width: 100%;
            height: 5em;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .item .c-c .btn-c-c {
            color: #858585;
            border: #a8a8a8 solid 1px;
            width: 50px;
            height: 24px;
            text-align: center;
            background: #fff;
            border-radius: 2px;
        }
    </style>




    <script>
        !function () {
            var a = document.documentElement;
            var b = a.clientWidth / 20;
            a.style.fontSize = (b > 21 ? 21 : b) + "px"
        }();
    </script>
    <link href="/Public/Mobile/css/notice.css" rel="stylesheet">

    <!--<div class="fl w100 notice_top">
        <div class="content">
            <ul>

                <li><a href="<?php echo U('Info/noticelist');?>" class="cur">中瀛智募公告列表</a></li>
            </ul>
        </div>
        <div class="navbg"></div>
    </div>-->
    <div class="fl w100 mt25 infomation_main">
        <div class="content">
            <div class="rightmain">
                <!--<div class="title">项目公告</div>-->
                <div class="mainintro">
                    <div class="titleA"><?php echo ($info["title"]); ?></div>
                    <div class="titleB" style="font-size:12px;">发布时间：<?php echo (time_format($info["create_time"],'Y-m-d')); ?>&nbsp;&nbsp;&nbsp;来源：<?php echo ($info["info_from"]); ?>&nbsp;&nbsp;&nbsp;<?php echo ($info["view"]); ?>次阅读</div>
                    <p><?php echo ($info["content"]); ?></p>
                </div>

                <div class="comment">
                    <div class="font18_hm">
                        <span style="color:#f35d5d;">名家点评</span>
                    </div>

                    <div class="comment_mjdp">
                        <ul>
                            <?php if(is_array($comments)): foreach($comments as $key=>$vo): ?><li>
                                    <div class="Avatar">
                                        <?php if($vo['face'] == 0): ?><img src="/Uploads/Picture/Photo/photo_default.png" class="header">
                                            <?php else: ?>
                                            <img src="<?php echo (get_cover($vo["face"],'path')); ?>" class="header"><?php endif; ?>
                                        <div class="comment_name"><?php echo ($vo["comment_by"]); ?></div>
                                    </div>
                                    <div class="Recent_Right"><p class="Recent_content"><?php echo ($vo["content"]); ?></p></div>
                                    <div class="clear"></div>
                                </li><?php endforeach; endif; ?>
                        </ul>
                    </div>
                </div>

                <div class="item">
                    <div class="font18_hm">
                        <span style="color:#f35d5d;">评论留言</span>
                        <em></em>
                    </div>

                    <div class="comments close">
                        <ul>
                            <?php if(is_array($info["infocomments"])): foreach($info["infocomments"] as $key=>$v): ?><li id="comment<?php echo ($v['id']); ?>">
                                    <div class="img">
                                        <a href="<?php echo U('MCenter/profile?id='. $v['comment_user']);?>"><img
                                                src="<?php echo (get_memberface($v['comment_user'])); ?>"></a>
                                    </div>
                                    <div class="text">
                                        <div class="addpost">
                                            <a class="btn-slide"
                                               href="<?php echo U('info/makereply',array('project_id'=>$v['project_id'],'reply_id'=>$v['id']));?>">回复</a>
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
                        <?php if(!empty($info["infocomments"])): ?><div class="more">
                                <a href="<?php echo U('Info/morecomment/pid/'.$info['id']);?>">查看更多评论</a>
                            </div><?php endif; ?>
                    </div>

                </div>

                <div class="item rec-proj">
                    <div class="font18_hm">
                        <span style="color:#f35d5d;">推荐项目</span>
                        <em></em>
                    </div>
                    <div class="project close">
                        <ul class="pros">
                            <?php if(is_array($recomendList['project'])): foreach($recomendList['project'] as $key=>$v): ?><li>
                                    <a href="<?php echo U('project/detail?id='.$v['id']);?>" title="中瀛智募">
                                        <div class="img1">
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
                    <a href="<?php echo U('info/postcomment/pid/'.$info['id']);?>">评论留言</a>
                </div>
            </div>
        </div>
    </div>

    <script>

        var projectId = location.href.match(/id\/(\d+)\.html/);
        projectId = parseInt(projectId && projectId[1]) || 0;
        var config = {projectCommentAPI: '/info/comment/'};

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

        /*详情页展开*/
        $('.font18_hm em').click(function () {
            bd = $(this).parent().parent().find('.close');
            if (bd.is(':visible')) {
                bd.slideUp();
                bd.parent().addClass('closed');
            }
            else {
                bd.slideDown();
                bd.parent().removeClass('closed');
            }
        });
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