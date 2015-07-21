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
	
    <style>
        textarea.comment-comment {
            font-size: 14px;
            color: #5c5c5c;
        }

        .border1 {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            resize: none;
            background: #fff;
            box-sizing: border-box;
        }

        .btn-comment-comment {
            background: #72c2e5;
            color: #fff;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
        }

        .xmpl ul.mes {
            padding-top: 0;
        }

        .xmpl ul.mes li {
            float: left;
            width: 100%;
            border-bottom: 2px dotted #f5f5f5;
            padding-bottom: 20px;
        }

        .xmpl ul.mes li dl, .xmpl ul.mes li dl dt, .xmpl ul.mes li dl dd {
            margin: 0;
            padding: 0;
        }

        .xmpl ul.mes li dl dd.img {
            float: left;
            width: 90px;
            text-align: center;
        }

        .xmpl ul.mes li dl dd.img img {
            border: 2px solid #e1e6ea;
            width: 55px;
            height: 55px;
            border-radius: 50%;
        }

        .xmpl ul.mes li dl dd.detail {
            float: left;
            width: 74%;
            font-size: 12px;
            color: #666;
        }

        .xmpl ul.mes li dl dd.icon {
            float: left;
            width: 30px;
        }

        .xmpl ul.mes li dl dd.icon img {
            position: relative;
            top: 3px;
        }

        .xmpl ul.mes li dl dd.detail b {
            font-size: 14px;
            font-weight: normal;
            display: block;
            color: #333;
        }

        .xmpl ul.mes li dl dd.cz {
            float: right;
            width: 80px;
            text-align: right;
            margin-right: 10px;
        }

        .xmpl ul.mes li dl dd.cz a {
            color: #858585;
            border: 1px solid #ddd;
            border-radius: 3px;
            text-decoration: none;
            font-size: 12px;
            width: 50px;
            height: 26px;
            line-height: 26px;
            display: inline-block;
            text-align: center;
        }

        .xmpl ul.mes li .reply {
            background: #fff;
            margin-top: 20px;
            text-align: right;
            width: 600px;
            margin-left: 50px;
        }

        .xmpl ul.mes li .reply .border1 {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            resize: none;
            background: #fff;
            box-sizing: border-box;
        }

        #btn-project-comment {
            color: #fff;
            position: relative;
            height: 40px;
            line-height: 40px;
            text-align: center;
            text-decoration: none;
            background: url(../images/icon_pl.png) no-repeat 18px 8px #72c2e5;
            display: inline-block;
            font-family: "微软雅黑", "黑体", sans-serif;
            font-size: 18px;
            padding-left: 50px;
            padding-right: 30px;
            border-radius: 4px;
        }

        #btn-project-comment:hover {
            background-color: #6bb5d6;
        }

        .xmpl ul.mes li .moreinfo {
            background: #fff;
            width: 680px;
            margin-top: 20px;
            color: #999999;
        }

        .xmpl ul.mes li .d {
            color: #999999;
            font-size: 14px;
        }

        .xmpl ul.mes li .pllist li {
            padding: 10px;
            background: #f2f2f2;
            border-radius: 5px;
            margin-top: 5px;
            margin-bottom: 0;
            box-sizing: border-box;
        }
    </style>




    <link href="/Public/Home/css/style.css" rel="stylesheet">
    <script type="text/javascript" src="/Public/Home/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/Public/Home/js/addons.js"></script>
    <script type="text/javascript" src="/Public/Home/js/jquery.animate-colors-min.js"></script>

    <div class="fl w100 infomation_main">
        <div class="content">
            <div class="mt25 leftmain">
                <div class="title"><?php echo ($info["title"]); ?></div>
                <div class="f_gray">
                    <div style="float:left;padding-top: 15px;">发布时间：<?php echo (time_format($info["create_time"],'Y-m-d')); ?>&nbsp;&nbsp;&nbsp;来源：<?php echo ($info["info_from"]); ?>&nbsp;&nbsp;&nbsp;<?php echo ($info["view"]); ?>次阅读</div>

                    <div style="float:right;">
                        <div class="share">
                            <!-- JiaThis Button BEGIN -->
                            <div class="jiathis_style_24x24 pull-right hidden-phone" style="margin-top:15px">
                                <a class="jiathis_button_tsina"></a>
                                <a class="jiathis_button_tqq"></a>
                                <a class="jiathis_button_weixin"></a>
                                <a class="jiathis_button_cqq"></a>
                                <a class="jiathis_counter_style"></a>
                            </div>

                            <script type="text/javascript">
                                var jiathis_config = {
                                    data_track_clickback: true,
                                    summary: "",
                                    shortUrl: true,
                                    hideMore: false
                                }
                            </script>
                            <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1993185"
                                    charset="utf-8"></script>
                            <!-- JiaThis Button END -->
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="mainintro">
                    <p><?php echo ($info["content"]); ?></p>
                </div>

                <div class="comment">
                    <div class="mjdp">
                        <span class="comments">名家点评</span>
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
                                    <div class="Recent_Right">
                                        <div class="Recent_content"><?php echo ($vo["content"]); ?></div>
                                    </div>
                                    <div class="clear"></div>
                                </li><?php endforeach; endif; ?>
                        </ul>
                    </div>
                </div>

                <div class="message xmpl">
                    <div class="mjdp">
                        <span class="messages">评论留言</span>
                    </div>

                    <div class="comment_info">
                        <ul class="mes">
                            <li>
                                <div id="replyw" class="reply"><textarea
                                        id="project-comment" name="" cols="" rows=""
                                        class="border1 comment-comment"
                                        style="width:100%; height:150px;"></textarea><a href="#"
                                                                                        id="btn-project-comment">发表</a>
                                </div>
                            </li>
                        </ul>
                        <div id="comment-box">

                        </div>
                    </div>
                </div>
            </div>

            <div class="mt25 rightmain">
                <div class="notice">
                    <div class="mt15 font18_hm">
                        <span style="color:#f35d5d;">热门文章</span>
                    </div>
                    <ul>
                        <?php if(is_array($hotinfo)): foreach($hotinfo as $key=>$v): ?><li>
                                <a href="<?php echo U('info/infomation?id='.$v['id']);?>" title="资讯"><?php echo ($v["title"]); ?></a>
                            </li><?php endforeach; endif; ?>

                    </ul>
                </div>
                <div class="hotproject">
                    <div class="mt15 font18_hm">
                        <span style="color:#f35d5d;">推荐项目</span>
                    </div>
                    <ul style="text-align: center;">
                        <?php if(is_array($recomendList['project'])): foreach($recomendList['project'] as $key=>$v): ?><li>
                                <a href="<?php echo U('project/detail?id='.$v['id']);?>" title="中瀛智募">
                                    <img src="<?php echo (get_cover($v['cover'],'path')); ?>">
                                </a>
                                <p class="text-center">
                                    <a href="<?php echo U('project/detail?id='.$v['id']);?>"><?php echo ($v["project_name"]); ?></a>
                                </p>
                            </li><?php endforeach; endif; ?>
                        <?php if(is_array($recomendList['product'])): foreach($recomendList['product'] as $key=>$v): ?><li>
                                <a href="<?php echo U('product/viewdetail/pid/'.$v['id']);?>" title="中瀛智募">
                                    <img src="<?php echo (get_cover($v['home_img'],'path')); ?>">
                                </a>
                                <p class="text-center">
                                    <a href="<?php echo U('product/viewdetail/pid/'.$v['id']);?>"><?php echo ($v["name"]); ?></a>
                                </p>
                            </li><?php endforeach; endif; ?>
                    </ul>
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

    <script type="text/javascript">
        var projectId = location.href.match(/id\/(\d+)\.html/);
        projectId = parseInt(projectId && projectId[1]) || 0;
        var config = {projectCommentAPI: '/info/comment/'};

        $.get('<?php echo U("Pages/infoComments?id=". $info["id"]);?>', function (data) {
            $("#comment-box").html(data.html);
            bindCommentBtnEvent();
            //$("#investor-count").html(data.count);
        }, 'json');


        function pageChangeComment() {
            $('#pagectrl-comment .first,#pagectrl-comment .num,#pagectrl-comment .next,#pagectrl-comment .end,#pagectrl-comment .prev').click(function () {
                $.get($(this).attr('href'), function (data) {
                    $("#comment-box").html(data.html);
                    //$("#investor-count").html(data.count);
                    location.hash = '';
                    location.hash = '#comments';
                    bindCommentBtnEvent();
                }, 'json');
                return false;
            });
        }

        // 回复(显示恢复输入框)
        var bindCommentBtnEvent = function () {
            $(".btn-slide").unbind().click(function () {
                $(this).parent().parent().find('.panel').slideToggle();
                return false;
            });
            $('.btn-comment-comment').unbind().click(function () {
                var $detail = $(this).parents('.detail'),
                        $textarea = $detail.find('textarea'),
                        commentId = $detail.find('.comment_id').val(),
                        user = $detail.find('.from').children('b').text(),
                        content = $detail.find('.d').text();

                var data = {
                    project_id: projectId,
                    content: $textarea.val(),
                    reply_id: commentId
                };
                if ($textarea.val() == '') {
                    layer.alert('评论内容不能为空');
                    return false;
                }
                $.post(config.projectCommentAPI, data, function (data) {
                    if (data.status == 1) {
                        showCommentComment(data, user, content);
                        $textarea.val('');
                    } else {
                        layer.alert(data.info, 8);
                    }
                });
                return false;
            });
        };

        //项目评论 - 戴
        $('#btn-project-comment').click(function () {
            var $textarea = $('#project-comment');
            var data = {
                type: 1,
                project_id: projectId,
                content: $textarea.val(),
                reply_id: 0
            };

            if ($textarea.val() == '') {
                layer.alert('评论内容不能为空');
                return false;
            }
            $.post(config.projectCommentAPI, data, function (data) {
                if (data.status == 1) {
                    showTheComment(data);
                    $textarea.val('');
                } else {
                    layer.alert(data.info, 8);
                }
            });
            return false;
        });

        //呈现刚发表的评论 - 戴
        function showTheComment(data) {
            var html = '<li class="fresh-comment"><dl><dd class="img"><img src="' + (data.user_face || '') + '" alt="' + (data.user_name || '') + '"></dd><dd class="detail"><div class="from"><b>' + (data.user_name || '') + '</b>' + data.date + '</div><div class="d">' + (data.content || '') + '</div><div class="panel" class="reply" style="display:none;"><input type="hidden" class="comment_id" value="' + (data.id || 0) + '"><textarea name="" cols="" rows="" class="border1" style="width:100%;"></textarea><a href="#" class="btn-comment-comment">评论</a></div></dd><dd class="cz"><a href="#" class="btn-slide">回复</a></dd><dd></dd></dl></li>';
            $('#comments').prepend(html);
            $('.fresh-comment').css('backgroundColor', '#FFFFCC').animate({
                backgroundColor: '#FFFFFF'
            }, 2000, function () {
                $(this).css('backgroundColor', '#FFFFFF').removeClass('fresh-comment')
            });
            bindCommentBtnEvent();
        }

        function showCommentComment(data, user, content) {
            var html = '<li class="fresh-comment" id="fresh-comment"><dl><dd class="img"><img src="' + data.user_face + '" alt="众筹用户"></dd>' +
                    '<dd class="detail"><div class="from"><b>' + data.user_name + '</b>' + data.date + '</div>' +
                    '<div class="d">' + data.content + '</div><div class="pllist clearfix"><ul>' +
                    '<li>' + user + '说：' + content + '</li></ul></div>' +
                    '<div class="panel" style="display:none;"><input type="hidden" class="comment_id" value="' + data.id + '">' +
                    '<textarea name="" cols="" rows="" class="border1" style="width:100%;"></textarea>' +
                    '<a href="#" class="btn-comment-comment">评论</a></div></dd><dd class="cz"><a href="#" class="btn-slide">回复</a></dd><dd></dd></dl>\n</li>';

            $('#comments').prepend(html);
            var $freshComment = $('.fresh-comment');
            $freshComment.css('backgroundColor', '#FFFFCC').animate({
                backgroundColor: '#FFFFFF'
            }, 2000, function () {
                $(this).removeClass('fresh-comment')
            });
            var freshCommentTop = $freshComment.offset().top,
                    $body = $('body');
            $body.animate({scrollTop: freshCommentTop}, 500);
            bindCommentBtnEvent();
            $('.panel').slideUp();
        }
        // 回复信息
        $("#btn_reply").click(function () {
            var cell = $(this).parents(".msg-cell");
            if ($(cell).find("#user_comment").val() == '') {
                alert('请填写回复内容。');
                return false;
            }
            var data = {
                project_id: projectId,
                content: $(cell).find("#user_comment").val(),
                reply_id: $(cell).find('#comment_id').val(),
                old_user: $(cell).find('header span:first').html(),
                old_content: $(cell).find('#cont').html()
            };

            $.post("<?php echo U('project/comment');?>", data, function (data) {
                var reply = $('.com-reply');
                $(reply).parents('.msg-cell').find('.msg-action').show();
                $(reply).hide(400);
                addNew(data);
            });
            return false;
        });

        // 回复(显示恢复输入框)
        var bindCommentBtnEvent = function () {
            $(".btn-slide").unbind().click(function () {
                $(this).parent().parent().find('.panel').slideToggle();
                return false;
            });
            $('.btn-comment-comment').unbind().click(function () {
                var $detail = $(this).parents('.detail'),
                        $textarea = $detail.find('textarea'),
                        commentId = $detail.find('.comment_id').val(),
                        user = $detail.find('.from').children('b').text(),
                        content = $detail.find('.d').text();

                var data = {
                    project_id: projectId,
                    content: $textarea.val(),
                    reply_id: commentId
                };
                if ($textarea.val() == '') {
                    layer.alert('评论内容不能为空');
                    return false;
                }
                $.post(config.projectCommentAPI, data, function (data) {
                    if (data.status == 1) {
                        showCommentComment(data, user, content);
                        $textarea.val('');
                    } else {
                        layer.alert(data.info, 8);
                    }
                });
                return false;
            });
        };

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