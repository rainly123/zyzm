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
	
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/home.css">
    <link rel="stylesheet" href="/Public/Home/css/index.css">
    <link rel="stylesheet" href="/Public/Home/css/nanoscroller.css">
    <link rel="stylesheet" href="/Public/static/slick/slick.css">



    <div id="server-data" style="display:none;">
        <input type="hidden" name="noticelist" value="<?php echo ($noticelist); ?>">
        <input type="hidden" name="newslist" value="<?php echo ($newslist); ?>">
    </div>

    <div class="banner-section">
        <div class="banner-container">
            <?php if(is_array($bannerList)): foreach($bannerList as $key=>$vo): ?><div style="height: 575px; background: url('<?php echo (get_cover($vo["img_id"],'path')); ?>') no-repeat center;">
                    <a href="<?php echo ($vo["extra"]); ?>" style="display: block;width: 100%;height: 100%;" target="_blank" alt="众筹推荐">
                        <!--<img src="<?php echo (get_cover($vo["img_id"],'path')); ?>" alt="<?php echo ($vo["name"]); ?>-中瀛智募 推荐"/>--></a>
                </div><?php endforeach; endif; ?>
        </div>
        <div class="prev"></div>
        <div class="next"></div>
    </div>


 <!-- 成就条	-->
    <div class="achievement-box">
        <div class="mid01 cl">
            <dl>
                <dd class="c1">
                    <em class="animate-num"><?php echo ($suminfo["sum_count"]); ?></em>项目
                </dd>
                <dd class="c2">
                    <em class="animate-num"><?php echo ($suminfo['sum_fund']); ?></em>融资额
                </dd>
                <dd class="c3">
                    <em class="animate-num"><?php echo ($suminfo["sum_member"]); ?></em>认证投资人
                </dd>
            </dl>
        </div>
    </div>

 <!--成就条位置 -->
    <script>
        !function () {
            var getW = function () {
                return document.documentElement.clientWidth || document.body.clientWidth;
            };
            var elm = document.querySelector('.achievement-box');
            var reCalc = function () {
                var w = getW();
                if (w < 1440) {
                    elm.style.left = '0';
                    elm.style.right = '0';
                } else {
                    elm.style.left = (w - 1440) * 0.5 + 'px';
                    elm.style.right = (w - 1440) * 0.5 + 'px';
                }
            };
            reCalc();
            $(window).resize(reCalc);
        }();
    </script>
    <!-- 网站公告 -->
    <div class="fl w100 mt20">
        <div class="content">
            <div class="notice-box">
                <div class="header">
                    <div class="tab-title-list clearfix">
                        <a href="javascript:" id="tab-title-news" class="tab-title active"
                           data-panel="news-panel">项目公告</a>
                        <a href="javascript:" id="tab-title-notice" class="tab-title" data-panel="notice-panel">创业新闻<i
                                class="hidden" id="new-notice-count"></i></a>
                    </div>
                </div>
                <div class="panel-win">
                    <div class="panel-list clearfix">
                        <div class="news-panel panel nano" data-type="1">
                            <div class="nano-content">
                                <?php if(is_array($news)): foreach($news as $a=>$v): ?><div class="notice-item clearfix" data-id="<?php echo ($v["id"]); ?>">
                                        <div class="date">
                                            <div class="day"><?php echo (time_format($v["create_time"],'d')); ?></div>
                                            <div class="ym"><?php echo (time_format($v["create_time"],'Y-m')); ?></div>
                                        </div>
                                        <div class="title-box">
                                            <a class="title-link"
                                               data-href="<?php echo U('Info/infomation?id='.$v['id']);?>"><span><?php echo ($v["title"]); ?></span></a>
                                        </div>
                                    </div><?php endforeach; endif; ?>
                                <div class="more"><a href="<?php echo U('Info/infomationlist');?>">查看更多</a></div>
                            </div>
                        </div>
                        <div class="notice-panel panel nano" data-type="0">
                            <div class="nano-content">
                                <?php if(is_array($notice)): foreach($notice as $a=>$v): ?><div class="notice-item clearfix" data-id="<?php echo ($v["id"]); ?>">
                                        <div class="date">
                                            <div class="day"><?php echo (time_format($v["create_time"],'d')); ?></div>
                                            <div class="ym"><?php echo (time_format($v["create_time"],'Y-m')); ?></div>
                                        </div>
                                        <div class="title-box">
                                            <a class="title-link" data-href="<?php echo U('Info/notice?id='.$v['id']);?>"><span><?php echo ($v["title"]); ?></span></a>
                                        </div>
                                    </div><?php endforeach; endif; ?>
                                <div class="more"><a href="<?php echo U('info/noticelist');?>">查看更多</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="notice-content-box">
                    <a target="_blank" class="title"></a>
                    <div class="content loading"></div>
                    <a target="_blank" class="more">查看详细 ></a>
                </div>
            </div>
        </div>
    </div>

    <!-- 合投项目 -->
    <div class="proj-section now">
        <div class="header">
            <a class="more" href="<?php echo U('List/index',array('type'=>0,'status'=>1,'p'=>1));?>">MORE</a>
        </div>
        <div class="sub-header">嗯，开投了，没下架就能投投投！</div>
        <div class="proj-container">
            <?php if(is_array($project["rapid"])): $i = 0; $__LIST__ = $project["rapid"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="proj-box clearfix">
                    <div class="img-box"><a href="<?php echo U('project/detail?id='.$vo['id']);?>"><img class="img"
                                                                                             src="<?php echo (get_cover($vo["cover"],'path')); ?>"></a>
                    </div>
                    <div class="detail-box">
                        <div class="title"><a href="<?php echo U('project/detail?id='.$vo['id']);?>"><?php echo ($vo["project_name"]); ?></a></div>
                        <div class="intro"><?php echo ($vo["abstract"]); ?></div>
                        <div class="statistics-box clearfix">
                            <div class="box mbe">
                                <div class="num animate-num"><?php echo round($vo['need_fund']/10000, 2);?>万</div>
                                <div class="label">目标额</div>
                            </div>
                            <div class="box qte">
                                <div class="num animate-num"><?php echo round($vo['follow_fund']);?></div>
                                <div class="label">起投额</div>
                            </div>
                            <div class="box yte">
                                <div class="num animate-num"><?php echo round($vo['has_fund']/10000, 2);?>万</div>
                                <div class="label">已投额</div>
                            </div>
                            <div class="box ywc">
                                <div class="num animate-num"><?php echo round($vo['finish_rate'], 2);?>%</div>
                                <div class="label">已完成</div>
                            </div>
                            <div class="box tzr last">
                                <div class="num animate-num"><?php echo ($vo['investor_count']); ?></div>
                                <div class="label">投资人</div>
                            </div>
                        </div>
                        <div class="progress-box animate-bar" data-target="<?php echo round($vo['finish_rate'], 2);?>">
                            <div class="rail"></div>
                            <div class="thumb"></div>
                        </div>
                        <div class="icon-box clearfix">
                            <div class="city"><?php echo (getdistrict($vo["city"])); ?></div>
                            <div class="comment"><?php echo ($vo['comment_count']); ?></div>
                            <div class="hit" title="浏览量"><?php echo ($vo['read_record']); ?></div>
                        </div>
                    </div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>

        </div>
    </div>

    <!-- 预热项目 -->
    <div class="proj-section preheat">
        <div class="header">
            <a class="more" href="<?php echo U('List/index',array('type'=>0,'status'=>3,'p'=>1));?>">MORE</a>
        </div>
        <div class="sub-header">咦，要投了，我来晒意见秀态度~</div>
        <div class="proj-container">
            <?php if(is_array($project["normal"])): $i = 0; $__LIST__ = $project["normal"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="proj-box clearfix">
                    <div class="img-box"><a href="<?php echo U('project/detail?id='.$vo['id']);?>">
                        <img class="img" src="<?php echo (get_cover($vo["cover"],'path')); ?>"></a>
                        <?php if($vo["leader_id"] == 0): ?><div class="leader"><a href="<?php echo U('project/leader_info?id='.$vo['id']);?>">寻找领投人</a></div><?php endif; ?>
                    </div>
                    <div class="detail-box">
                        <div class="title"><a href="<?php echo U('project/detail?id='.$vo['id']);?>"><?php echo ($vo["project_name"]); ?></a></div>
                        <div class="intro"><a href="<?php echo U('project/detail?id='.$vo['id']);?>"><?php echo ($vo["abstract"]); ?></a></div>
                        <div class="statistics-box clearfix">
                            <div class="box mbe">
                                <span class="label">目标额</span>
                                <span class="num animate-num"><?php echo round($vo['need_fund']/10000, 2);?></span>
                                <span class="unit">万</span>
                            </div>
                            <div class="box qte last">
                                <span class="label">起投额</span>
                                <span class="num animate-num"><?php echo round($vo['follow_fund']);?></span>
                                <span class="unit">元</span>
                            </div>
                        </div>
                        <div class="icon-box clearfix">
                            <div class="city"><?php echo (getdistrict($vo["city"])); ?></div>
                            <div class="comment"><?php echo ($vo['comment_count']); ?></div>
                            <div class="hit"><?php echo ($vo['read_record']); ?></div>
                        </div>
                    </div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>

    </div>

    <?php if (false): ?>
    <!-- 实物众筹按钮, 股票基金按钮 -->
    <div class="link-section clearfix">
        <div class="link-box">
            <a href="<?php echo U('List/index',array('type'=>2,'status'=>0,'p'=>1));?>">
                <div class="link-btn">实物众筹</div>
                <br>

                <div class="link-label">用优惠的价格成为第一批“尝鲜者”！</div>
            </a>
        </div>
        <div class="link-box second">
            <a href="<?php echo U('List/index',array('type'=>3,'status'=>0,'p'=>1));?>">
                <div class="link-btn">股票基金</div>
                <div>赚钱也可以很好玩，散户也可以不落单！</div>
            </a>
        </div>
    </div>
    <?php endif ?>

    <!-- 成功项目 -->
    <div class="proj-section succeed clearfix">
        <div class="header">
            <a class="more" href="<?php echo U('List/index',array('type'=>0,'status'=>2,'p'=>1));?>">MORE</a>
        </div>
        <div class="sub-header">喔。投完了，关注最新发展动态。</div>
        <div class="proj-container">
            <?php if(is_array($project["finish"])): $i = 0; $__LIST__ = $project["finish"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="proj-box clearfix">
                    <a href="<?php echo U('project/detail?id='.$vo['id']);?>">
                        <div class="img-box"><img class="img" src="<?php echo (get_cover($vo["cover"],'path')); ?>"></div>
                        <div class="detail-box">
                            <div class="title"><?php echo ($vo["project_name"]); ?></div>
                            <div class="intro"><?php echo ($vo["abstract"]); ?></div>
                            <div class="statistics-box clearfix">
                        <span class="box yte">
                            <span class="label">已投额</span>
                            <span class="num"><?php echo round($vo['has_fund']/10000, 2);?>万元</span>
                        </span>
                        <span class="box tzr last">
                            <span class="label">投资人</span>
                            <span class="num"><?php echo ($vo['investor_count']); ?></span>
                        </span>
                            </div>
                        </div>
                    </a>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>

    <!-- 友情链接 -->
    <div class="friendly-link-section">
        <div class="header">
            <div class="line"></div>
            <div class="title">友情链接</div>
        </div>
        <ul class="links-list">
            <?php if(is_array($links)): $i = 0; $__LIST__ = $links;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="link" style="background-image: url(<?php echo (get_cover($vo["logo"],'path')); ?>)">
                    <a href="<?php echo ($vo["url"]); ?>" target="_blank" title="<?php echo ($vo["name"]); ?>"></a>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>

    <ul id="fixed-tools" class="hidden">



        <li class="contact">
            <a href="javascript:void(0)">
                <i></i>
                <span>咨询热线</span>
            </a>
            <div class="float-panel">
                <i></i>
                <div class="tri"></div>
                <p>咨询热线</p>
                <p>周一至周五 9:00~18:00</p>
                <p class="phone">021-65800910</p>
            </div>
        </li>
        <li class="qr">
            <a href="javascript:void(0)">
                <i></i>
                <span>官方微信</span>
            </a>
          <div class="float-panel">
                <img class="qr-img" alt="中瀛智募微信号" width="148" height="157" src="/Public/Home/images/weixin.jpg">
                <div class="tri"></div>
                <p>微信关注<span style="color: #72C2E5;">【中瀛智募】</span></p>
                <p style="margin-bottom: 10px;">了解最新股权众筹资讯</p>
            </div>
        </li>
        <li id="back-top" class="back-top hidden">
            <a class="back-top" href="#" title="回顶部">
                <i></i>
                <span>回到顶部</span>
            </a>
        </li>


    </ul>

    <?php if(false){?>
    <div class="fl w100">
        <div class="mid03 cl">
            <b>天使投资人喊你来创业</b>手里有闲钱不知道怎么花？支持这些有趣的项目，选择你所喜欢的回报
        </div>

        <div class="list3 content cl">
            <div class="flexslider">
                <ul class="slides">
                    <li>
                        <dl>
                            <dt><a href="个人主页－投资项目.html"><img src="/Public/Home/images/111.jpg"></a><b>zjjsjcy</b></dt>
                            <dd>一个菜鸟投资人<br>关注行业：文娱,旅游,TMT<br>投资项目：4个</dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt><a href="#"><img src="/Public/Home/images/111.jpg"></a><b>zjjsjcy</b></dt>
                            <dd>一个菜鸟投资人<br>关注行业：文娱,旅游,TMT<br>投资项目：4个</dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt><a href="#"><img src="/Public/Home/images/111.jpg"></a><b>zjjsjcy</b></dt>
                            <dd>一个菜鸟投资人<br>关注行业：文娱,旅游,TMT<br>投资项目：4个</dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt><a href="#"><img src="/Public/Home/images/111.jpg"></a><b>zjjsjcy</b></dt>
                            <dd>一个菜鸟投资人<br>关注行业：文娱,旅游,TMT<br>投资项目：4个</dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt><a href="#"><img src="/Public/Home/images/111.jpg"></a><b>zjjsjcy</b></dt>
                            <dd>一个菜鸟投资人<br>关注行业：文娱,旅游,TMT<br>投资项目：4个</dd>
                        </dl>
                    </li>
                </ul>
            </div>
            <span id="responsiveFlag"></span></div>
    </div>
    <?php }?>

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

    <script src="/Public/static/slick/slick.min.js"></script>
    <script type="text/javascript" src="/Public/Home/js/jquery.nanoscroller.min.js"></script>
    <!--<script src="/Public/Home/js/jquery.superslide.2.1.1.js" type="text/javascript"></script>-->
    <!--<script type="text/javascript" src="/Public/Home/js/kwiks.js"></script>-->
    <!--<script type="text/javascript" src="/Public/Home/js/addons.js"></script>-->
    <script src="/Public/Home/js/index.js"></script>
 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden" style="display:none;"><!-- 用于加载统计代码等隐藏元素 -->
    <script src="http://s6.cnzz.com/z_stat.php?id=1253481980&web_id=1253481980" language="JavaScript"></script>
    
</div>

	<!-- /底部 -->
</body>
</html>