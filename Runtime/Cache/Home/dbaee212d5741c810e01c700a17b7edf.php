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


    <link href="/Public/Home/css/usercenter.css" rel="stylesheet">

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
	


    <div class="fl w100 mainwrap usercenter">
        <input type="hidden" id="myid" name="myid" value="<?php echo is_login();?>">
        <input type="hidden" id="user-profile-url" value="<?php echo U('MCenter/profile?id='._id_);?>">
        <header>
            <div class="content">
                <img src="<?php echo ($userphoto); ?>" class="userhead">
                <b id="user-name"><?php echo (get_membername($userinfo["user"]["id"])); ?></b>
                <!--<a href="<?php echo U('Message/sendmsg?id='.$userinfo['user']['id']);?>" class="pm poplight">发送私信</a>-->
                <dd id="addBankBtn" class="user-drawings-add-bank">

                </dd>

                <p><?php echo ($userinfo["users_detail"]["describe"]); ?></p>

                <div class="links">
                    <ul>
                        <?php if(($userinfo['is_investor'] == 3)): endif; ?>
                        <!--<li><a href="#" id="one0" class="cur">首页</a></li>-->
                        <li><a href="#" id="one1" class="cur">投资项目</a></li>
                        <li><a href="#" id="one2" class="">收藏项目</a></li>
                        <li><a href="#" id="one3" class="">项目评论</a></li>
                        <li data-name="friend"><a href="#" id="one4" class="">投资人关注</a></li>
                    </ul>
                </div>
                <div class="friend-toolbox">
                    <div class="fans-num">
                        <p class="fans-num-text">0</p>
                        <span>粉丝</span>
                    </div>
                    <div class="follow-num">
                        <p class="follow-num-text">0</p>
                        <span>关注</span>
                    </div>
                    <br>
                    <button class="btn btn-msg">私信</button>
                    <div class="btn-follow-box">
                        <button class="btn btn-follow">关注</button>
                        <button class="btn btn-followed">已关注</button>
                        <button class="btn btn-no-follow">取消关注</button>
                    </div>
                </div>
            </div>
        </header>
        <article class="mt100 tab-content-wrapper">
            <div class="content">
                <div class="hover" id="con_one_1">
                    <ul class="usercenter_xmlist">
                        <?php if(is_array($userinfo["investor"])): foreach($userinfo["investor"] as $key=>$investor): ?><li>
                                <dl>
                                    <dt><img src="<?php echo ($investor["path"]); ?>" width="146" height="110"></dt>
                                    <dd>
                                        <p>
                                            认投了项目【 <a href="<?php echo U('Project/detail?id='.$investor['project_id']);?>"><?php echo ($investor["project_name"]); ?></a>】,投资金额<?php echo ($investor["fund"]); ?>元。
                                            <em><?php echo (time_format($investor["create_time"])); ?></em>
                                        </p>
                                    </dd>
                                </dl>
                            </li><?php endforeach; endif; ?>
                    </ul>
                </div>
                <div class="hover" id="con_one_2" style="display:none;">
                    <ul class="usercenter_xmlist">
                        <?php if(is_array($userinfo["attach"])): foreach($userinfo["attach"] as $key=>$attach): ?><li>
                                <dl>
                                    <dt><?php echo (time_format($v["create_time"])); ?></dt>
                                    <dd><p><?php echo (get_membername($userinfo["user"]["id"])); ?> 关注收藏了项目【 <a
                                            href="<?php echo U('Project/detail?id='.$attach['project_id']);?>"><?php echo ($attach["project_name"]); ?></a>
                                        】</p></dd>
                                </dl>
                            </li><?php endforeach; endif; ?>
                    </ul>
                </div>
                <div class="hover" id="con_one_3" style="display:none;">
                    <ul class="usercenter_xmlist">
                        <?php if(is_array($userinfo["comment"])): foreach($userinfo["comment"] as $key=>$v): ?><li>
                                <dl>
                                    <dt><img src="<?php echo ($v["path"]); ?>" width="146" height="110"></dt>
                                    <dd>
                                        <p class="comment-header">
                                            评论了项目【 <a href="<?php echo U('Project/detail?id='.$v['project_id']);?>"><?php echo ($v["project_name"]); ?></a>】。
                                            <em><?php echo (time_format($investor["create_time"])); ?></em>
                                        </p>

                                        <p class="comment-quote">
                                            <?php echo ($v["content"]); ?>
                                        </p>
                                    </dd>

                                    <!--<div class="comment"  data-user="<?php echo ($v["user_name"]); ?>" id="<?php echo ($v["user_name"]); ?>"> 

                                        <div class="row-fluid" id="base-comment"> 
                                            <div class="span1"> 
                                                <img class="thumbnail" src="<?php echo ($v["path"]); ?>" alt=""> 
                                                &lt;!&ndash; todo 用户头像获取 &ndash;&gt; 
                                            </div> 
                                            <div class="span11"> 
                                                <div class="row-fluid"> 
                                                    <div class="message-writer pull-left"  id="username"><?php echo ($userinfo["user"]["nickname"]); ?></div>                                             <div class="pull-left muted" id="when"> 
                                                        <?php echo (get_membername($v["user_id"])); ?>评论了项目【 <a href="<?php echo U('Project/detail?id='.$v['project_id']);?>"><?php echo ($v["project_name"]); ?></a> 】
                                                    </div> 									 
                                                    <div class="pull-left muted"  id="when"><?php echo (time_format($v["create_time"])); ?></div> 
                                                </div> 
                                                <div> 
                                                    <div id="comment_info"><?php echo ($v["content"]); ?></div> 
                                                </div> 


                                            <div class="clear"></div>
                                        </div> 
                                    </div>
                                    </div>-->
                                </dl>
                            </li><?php endforeach; endif; ?>
                    </ul>
                </div>
                <div class="hover friend-view" id="con_one_4" style="display:none;">
                    <ul class="tab-title-list">
                        <li class="tab-title curr-tab" data-name="favs">关注好友（<span class="follow-num-text">0</span>）
                        </li>
                        <li class="tab-title" data-name="fans">粉丝（<span class="fans-num-text">0</span>）</li>
                    </ul>
                    <ul class="friend-list"></ul>
                    <div class="page-box">

                    </div>
                </div>
            </div>
        </article>
    </div>
    <div id="dialog" style="display:none">
        <div style="padding:20px 40px;">
            <form action="<?php echo U('Message/sendmsg?id=_id_');?>" method="post" id="message-form">
                <div class="control-group">
                    <label class="control-label">发送给</label>

                    <div class="controls pageusername"><span class="help-block"><b id="msg-target-name"></b></span>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="control-group">
                    <textarea name="content" class="srk_box" rows="5"></textarea>
                </div>
                <div class="control-group">
                    <button class="btn btn-primary" type="submit">发送</button>
                </div>
            </form>
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
    <script src="/Public/static/jquery.simplePagination.js"></script>
    <script type="text/javascript">
        $(function () {
            // 指定左侧选中菜单
            var submenu = "<?php echo U('Account/index');?>";
            var $tabTitles = $('.links a'),
                    $tabContents = $('.content .hover');
            $tabTitles.click(function () {
                var $this = $(this),
                        tabName = $this.parent().data('name');
                $tabTitles.removeClass('cur');
                $this.addClass('cur');
                $tabContents.hide();
                $tabContents.eq($this.parent().index()).show();
                if (tabName === 'friend') {
                    getFollows($('.friend-view .curr-tab').data('name'));
                }
                return false;
            });

            var userId = location.href.match(/id\/(\d+)/);
            userId = parseInt(userId && userId[1]) || 0;

            // 获取关注与粉丝数量
            var updateFriendCount = function () {
                $.getJSON('/follows/getFollowsBoth', {uid: userId}).then(function (json) {
                    if (json.success) {
                        $('.follow-num-text').text(json.followingcount);
                        $('.fans-num-text').text(json.followerscount);
                    }
                });
            };
            updateFriendCount();
            $.getJSON('/follows/getRelation', {uid: userId}).then(function (json) {
                if (json.success) {
                    $('.friend-toolbox .btn-follow-box').addClass('followed');
                }
            });
            // 删除自己 profile 的私信与关注按钮
            !function () {
                var myId = $('#myid').val();
                if (userId == myId) {
                    $('.friend-toolbox').find('.btn').remove();
                }
            }();

            // 关注与私信按钮
            var follow = function (uid, $button) {
                var postAPI = '/follows/add';
                if ($button.hasClass('followed')) {
                    postAPI = postAPI = '/follows/delete'
                }
                $.post(postAPI, {
                    id: uid
                }, 'json').then(function (json) {
                    layer.msg(json.info, 1, -1);
                    if (json.success) {
                        $button.toggleClass('followed');
                        updateFriendCount();
                    }
                })
            };
            var openSendMsgForm = function (uid, targetName) {
                var $form = $('#dialog').find('form'),
                        sendMsgAPI = $form.attr('action');
                $form.attr('action', sendMsgAPI.replace('_id_', uid));
                $('#msg-target-name').html(targetName);
                $.layer({
                    type: 1,
                    title: false,
                    area: ['600px', '360px'],
                    page: {dom: "#dialog"},
                    fadeIn: 300
                });
            };
            $('.friend-toolbox .btn-follow-box').click(function () {
                follow(userId, $(this))
            });
            $('.friend-toolbox .btn-msg').click(function () {
                openSendMsgForm(userId, $('#user-name').text())
            });
            var bindButtonsEvent = function () {
                $('.friend-list .btn-follow-box').unbind().click(function () {
                    var $this = $(this);
                    var uid = $this.parents('.friend-item').data('uid');
                    follow(uid, $this);
                });
                $('.friend-list .btn-msg').unbind().click(function () {
                    var $this = $(this),
                            $item = $this.parents('.friend-item');
                    var uid = $item.data('uid'),
                            userName = $item.find('.username').text();
                    openSendMsgForm(uid, userName);
                });
            };
            bindButtonsEvent();


            // 获取列表
            var itemsOnPage = 4;
            var getFollows = function (type, page) {
                var _api = '/follows/getFollowing';
                if (type === 'fans') _api = '/follows/getFollowers';
                $.getJSON(_api, {uid: userId, number: itemsOnPage, page: page}).then(function (json) {
                    if (json.success) {
                        buildDOM(json, page);
                    } else {
                        layer.msg(json.info, 2, -1)
                    }
                })
            };
            var buildPageDOM = function (items, currentPage) {
                if (currentPage == null) {
                    currentPage = 1
                }
                $('.page-box').pagination({
                    items: items,
                    itemsOnPage: itemsOnPage,
                    currentPage: currentPage,
                    prevText: '<<',
                    nextText: '>>',
                    onPageClick: function (pageNumber, event) {
                        getFollows($('.friend-view .curr-tab').data('name'), pageNumber);
                    }
                });
            };
            var buildDOM = function (json, currentPage) {
                var myId = $('#myid').val(),
                        html = '',
                        userProfileUrl = $('#user-profile-url').val();
                if (!json.users) json.users = [];
                for (var i = 0, len = json.users.length; i < len; i++) {
                    var userInfo = json.users[i],
                            _href = userProfileUrl.replace('_id_', userInfo.id);
                    html += '<li class="friend-item" data-uid="' + userInfo.id + '"><div class="avatar"><a href="' + _href + '"><img src="' + userInfo.photo_url +
                    '"></a></div><div class="user-box"><div class="username"><a href="' + _href + '">' + userInfo.nickname +
                    '</a></div><div class="signature"><a href="' + _href + '"></a></div></div><div class="toolbox">';
                    if (myId != userInfo.id) {
                        html += '<div class="btn-follow-box' + (userInfo.relation ? ' followed' : '') + '"><button class="btn btn-follow">关注</button><button class="btn btn-followed">已关注</button><button class="btn btn-no-follow">取消关注</button></div>';
                        html += '<button class="btn btn-msg">私信</button>'
                    }
                    html += '</div></li>';

                }
                $('.friend-list').html(html);
                bindButtonsEvent();
                if (json.total > 1) {
                    buildPageDOM(json.total, currentPage)
                } else {
                    $('.page-box').empty();
                }
            };

            var $friendTabTitle = $('.friend-view .tab-title').click(function () {
                $friendTabTitle.removeClass('curr-tab');
                var $this = $(this);
                $this.addClass('curr-tab');
                getFollows($this.data('name'));
            });

            $("#message-form").submit(function () {
                var self = $(this);
                var content = $('[name="content"]').val();
                if (content == '') {
                    layer.alert('消息内容不能为空。', 8);
                    return false;
                }
                $.post(self.attr("action"), self.serialize(), "json").then(function (json) {
                    if (json.status == 1) {
                        layer.alert(json.info, 9, function () {
                            window.location.reload();
                        });
                    } else {
                        layer.alert(json.info, 8);
                    }
                });
                return false;
            });
        })
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