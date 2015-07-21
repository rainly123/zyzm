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

    <link href="/Public/Mobile/css/header.css" rel="stylesheet">
    <link href="/Public/Mobile/css/project.css" rel="stylesheet">
    <script src="/Public/Mobile/js/jquery.easing.1.3.js"></script>


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
	



    <div class="detail">
        <div class="item">
            <div class="body">

                <div class="comments">
                    <ul>
                        <?php if(is_array($comments)): $i = 0; $__LIST__ = $comments;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li>
                                <div class="img">
                                    <a href="<?php echo U('MCenter/profile?id='. $v['comment_user']);?>"><img
                                            src="<?php echo (get_memberface($v['comment_user'])); ?>" alt="众筹用户"></a>
                                </div>
                                <div class="text">
                                    <div class="addpost"><a class="btn-slide"
                                                            href="<?php echo U('project/makereply',array('project_id'=>$v['project_id'],'reply_id'=>$v['id']));?>">回复</a>
                                    </div>
                                    <h2><?php echo (get_membername($v['comment_user'])); ?></h2>
                                    <?php if(!empty($v["parent"])): if(is_array($v["parent"])): $i = 0; $__LIST__ = $v["parent"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="pllist clearfix reply">
                                                <?php echo (get_membername($vo["comment_user"])); ?>说：<?php echo ($vo["content"]); ?>
                                            </div><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                                    <p><?php echo ($v["content"]); ?></p>
                                </div>
                                <div class="c-c"><input type="hidden" class="comment_id"
                                                        value="<?php echo ($v["id"]); ?>"><textarea maxlength="140"></textarea><br>
                                    <button class="btn-c-c">回复</button>
                                </div>
                                <dd>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script>
        var projectId = location.href.match(/id\/(\d+)\.html/);
        projectId = parseInt(projectId && projectId[1]) || 0;
        var config = {
            projectCommentAPI: '/project/comment/'
        };

        $('.btn-slide').click(function () {
            var $this = $(this),
                    $cc = $(this).parents('.text').next();
            /*location.hash = $(this).parents('.text').parent().attr('id');*/
            if ($cc.css('display') === 'none') {
                $this.text('取消');
                $cc.slideDown().find('textarea').focus();
            } else {
                $cc.slideUp();
                $this.text('回复')
            }

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
            $.post(config.projectCommentAPI, data, function (data) {
                showCommentComment(data);
                $textarea.val('');
            });
            return false;
        });

        function showCommentComment(data) {
            location.reload();
        }
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