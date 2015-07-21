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


    <link href="/Public/Home/css/detail.css" rel="stylesheet">
    <link href="/Public/Home/css/quicklogin.css" rel="stylesheet">


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
	



    <div id="server-data" style="display: none;">
        <input type="hidden" name="projectId" value="<?php echo ($project["project"]["id"]); ?>">
    </div>
    <div class="fl w100 mainwrap mt25">
        <div class="content" id="detail">
            <div class="bread"><a href="/">首页</a>　> <a href="<?php echo U('List/index',array('type'=>1,'status'=>0,'p'=>1));?>">股权项目</a>　>
                <?php echo ($project["project"]["project_name"]); ?>
            </div>
            <div class="topinfo mt15 cl">
                <div class="img fl">
                    <div class="noimg">
                        <img src="<?php echo (get_cover($project["project"]["cover"],'path')); ?>" alt="<?php echo ($project["project"]["project_name"]); ?>"
                             style="width:100%;height:100%;">
                    </div>
                </div>
                <div class="infos ri">
                    <h4><?php echo ($project["project"]["project_name"]); ?></h4>

                    <p class="sintro"> <?php echo ($project["project"]["abstract"]); ?> </p>
                    <dl class="rzxx cl">
                        <dd>
                            <span><?php echo (change_fund($project["fund"]["need_fund"])); ?></span>融资目标额
                            <i>
                                <a onmouseover="ddd('aa', 'show');" onmouseout="ddd('aa', 'hide');"><img
                                        src="/Public/Home/images/icon_i.jpg"></a>
                                <div class="intro2" style=" display:none;" id="aa">
                                    <em></em>
                                    <?php if($project[project][stage] >= 4): ?>项目估值：<?php echo (change_fund($project["fund"]["final_valuation"])); ?>元
                                        <?php else: ?>
                                        估值未确定<?php endif; ?>
                                </div>
                            </i>
                        </dd>
                        <dd><span><?php echo (change_fund($project["fund"]["follow_fund"])); ?>元</span>起投额</dd>
                        <dd><span><?php if(($project["project"]["stage"]) == "1"): ?>0
                            <?php else: ?>
                            <?php echo (change_fund($project["fund"]["has_fund"])); endif; ?>元</span>已投额
                        </dd>
                        <dd><span><?php if(($project["project"]["stage"]) == "1"): ?>0
                            <?php else: ?>
                            <?php echo ($project[fund][scale]); endif; ?>%</span>已完成
                        </dd>
                    </dl>
                    <div class="savestep_detail cl">
                        <?php if(($project["project"]["stage"]) == "1"): ?><i style="width:0;"></i>
                            <?php else: ?>
                            <i style="width:<?php echo ($project[fund][scale] > 100 ? 100 :$project[fund][scale]); ?>%;"></i><?php endif; ?>
                        <div class="bg"></div>
                    </div>
                    <div class="cz cl">
                        <div class="zan">
                            <a href="#" title="收藏"
                               class="c2 btn-heart <?php if(($project["project"]["attach_status"]) == "0"): ?>heart<?php endif; ?>"><?php echo ($project['project']['attach_count']); ?></a>
                            <a href="#" title="评论" class="c3 btn-comment"><?php echo ($project["project"]["com_count"]); ?></a>
                            <a href="#" title="浏览" class="btn-eye"><?php echo ($project["project"]["read_record"]); ?></a>
                        </div>
                        <?php if(($project[project][stage]) == "4"): ?><div class="wytz"><a id="btnFollow"
                                                 href="<?php echo U('project/follow?id='.$project['project']['id']);?>">我要投资</a>
                            </div><?php endif; ?>

                        <?php if(($project[project][stage] == 1) AND ($project[project][vote_leader] == 0)): ?><div class="leader"><i></i><a
                                    href="<?php echo U('project/leader_info?id='.$project['project']['id']);?>">领投人虚位以待</a></div><?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="tagsbar">
                <a class="city"><?php echo getDistrict($project['project']['province']);?>/<?php echo getDistrict($project['project']['city']);?></a>
            </div>
            <div class="intro_detail mt20">
                <div class="xm fl">
                    <div class="smenu cl">
                        <ul>
                            <li id="one1" onclick="setTab('one',1,5)" class="cur">项目主页</li>
                            <li id="one2" onclick="setTab('one',2,5)">商业模式</li>
                            <li id="one3" onclick="setTab('one',3,5)">
                                投资者
                                <em>(<span id="investor-count"></span>)</em>
                            </li>
                            <li id="one4" onclick="setTab('one',4,5)">项目动态</li>
                            <li id="one5" class="last" onclick="setTab('one',5,5)">
                                项目评论
                                <em>(<?php echo ($project["project"]["com_count"]); ?>)</em>
                            </li>
                        </ul>
                    </div>
                    <div class="" id="con_one_1" style="display: block;">
                        <div class="c11 borbm">
                            <table>
                                <tr>
                                    <td>公司名称：<?php echo ($project['project']['company_name']); ?></td>
                                    <td>所处阶段: <?php echo (get_code_name($project["project"]["project_phase"])); ?></td>
                                </tr>
                                <tr>
                                    <td>公司地址：<span><?php echo getDistrict($project['project']['province']);?></span><span><?php echo getDistrict($project['project']['city']);?></span>
                                    </td>
                                    <td>团队人数：<?php echo ($project['project']['member_count']); ?>人</td>
                                </tr>
                                <tr>
                                    <td>项目网址：<?php echo ($project['project']['project_url']); ?></td>
                                    <td>所属行业：<?php echo (get_code_name($project["project"]["industry"])); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="c11 borbm crbl">
                            <?php if($project[project][stage] >= 4): ?><table>
                                    <tr>
                                        <td><img src="/Public/Home/images/icon_xmdetail_01.png">出让股权比例：<?php echo (change_fund($project["fund"]["rate_fund"])); ?>%
                                        </td>
                                        <td><img src="/Public/Home/images/icon_xmdetail_02.png">项目估值：<?php echo (change_fund($project["fund"]["final_valuation"])); ?>
                                        </td>
                                    </tr>
                                </table><?php endif; ?>
                        </div>
                        <div class="c11 mintro">
                            <p><?php echo ($project["info"]["description"]); ?></p>
                            <?php if(!empty($project["temp"])): ?><div id="DB_gallery">
                                    <div class="DB_imgSet">
                                        <div class="DB_imgWin">
                                            <img style="background:#fff;"
                                                 src="<?php echo get_cover($project['temp'][0]['info_key'], 'path');?>" alt=""
                                                 style="display: inline;width:100%"></div>
                                        <div class="DB_page" style="display:none"><span
                                                class="DB_current">0</span>-<span class="DB_total">0</span></div>
                                        <div class="DB_prevBtn" style="display: none;"><img
                                                src="/Public/Home/images/img/prev_off.png" alt=""></div>
                                        <div class="DB_nextBtn"><img src="/Public/Home/images/img/next_off.png" alt="图片相册"></div>
                                    </div>
                                    <div class="DB_thumSet">
                                        <ul class="DB_thumMove">
                                            <?php if(is_array($project["temp"])): $i = 0; $__LIST__ = $project["temp"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li><a href="<?php echo (get_cover($v["info_key"],'path')); ?>"><img
                                                        src="<?php echo (get_cover($v["info_key"],'path')); ?>" alt="图片相册"></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </ul>
                                        <div class="DB_thumLine" style="left: 0;"></div>
                                        <div class="DB_prevPageBtn" style="display: none;"><img
                                                src="/Public/Home/images/img/prev_page.png" alt="上一页"></div>
                                        <div class="DB_nextPageBtn"><img src="/Public/Home/images/img/next_page.png" alt="下一页">
                                        </div>
                                        <div class="DB_prevPageBtn2"><img src="/Public/Home/images/img/prev_page.png" alt="上一页">
                                        </div>
                                        <div class="DB_nextPageBtn2"><img src="/Public/Home/images/img/next_page.png" alt="下一页">
                                        </div>
                                    </div>
                                </div><?php endif; ?>
                        </div>
                        <div class="c11 mintro">
                            <h4 class="c2"><i></i>团队介绍</h4>
                        </div>
                        <!--团队成员介绍-->
                        <?php if(is_array($team)): foreach($team as $key=>$v): ?><div class="xmms">
                                <?php if(!empty($v["header_img"])): ?><div class="fl2"><img src="<?php echo (get_cover($v["header_img"],'path')); ?>"></div><?php endif; ?>
                                <ul class="fr2">
                                    <li>姓名：<?php echo ($v["name"]); ?></li>
                                    <li>职务：<?php echo ($v["postion"]); ?></li>
                                    <?php if(!empty($v["member_info"])): ?><li>成员简介：<?php echo ($v["member_info"]); ?></li><?php endif; ?>
                                </ul>
                                <div style="clear:both"></div>
                            </div><?php endforeach; endif; ?>
                        <!--团队成员介绍-->
                    </div>
                    <div class="c11 mintro xmjs" id="con_one_2" style="display: none;">
                        <?php if(!empty($project["info"]["plan"])): ?><h4 class="c2"><i></i>公司未来规划</h4>

                            <div><?php echo ($project["info"]["plan"]); ?></div><?php endif; ?>

                        <?php if(!empty($project["info"]["custom"])): ?><h4 class="c2"><i></i>目标客户</h4>

                            <div> <?php echo ($project["info"]["custom"]); ?></div><?php endif; ?>

                        <?php if(!empty($project["info"]["avantages"])): ?><h4 class="c2"><i></i>竞争优势</h4>

                            <div><?php echo ($project["info"]["avantages"]); ?></div><?php endif; ?>

                        <?php if(!empty($project["info"]["yingli_mode"])): ?><h4 class="c2"><i></i>盈利模式</h4>

                            <div><?php echo ($project["info"]["yingli_mode"]); ?></div><?php endif; ?>
                    </div>
                    <div class="c11 mintro tzz" id="con_one_3" style="display: none;">
                        <div id="investlist"></div>
                    </div>
                    <div class="c11 mintro xmdt" id="con_one_4" style="display: none;">
                        <h4 class="c2"><i></i>项目动态</h4>

                        <?php if(($uid == $project['project']['uid']) ): ?><div name="test" class="link-dynamic">
                                <a href="<?php echo U('project/dynamiclist?id='.$project['project']['id']);?>">编辑</a>
                            </div><?php endif; ?>

                        <ul>
                            <?php if(is_array($dynamicInfo)): foreach($dynamicInfo as $key=>$vo): ?><ul>
                                    <li><em><?php echo (time_format($vo["create_time"],'Y-m-d')); ?></em>
                                        <a href="<?php echo U('projectdynamicdetail?id='.$vo['id']);?>">
                                            <div class="dynamic-title"><?php echo ($vo["title"]); ?></div>
                                        </a>

                                        <div class="dynamicInfoID" style="display: none"><?php echo ($vo["id"]); ?></div>
                                    </li>
                                </ul><?php endforeach; endif; ?>
                        </ul>

                    </div>
                    <div class="c11 mintro xmpl" id="con_one_5" style="display: none;">

                        <h4 class="c2"><i></i>项目评论</h4>

                        <div class="attitudes-wrapper">
                            <button id="btn-pos" class="btn btn-pos"></button>
                            <div class="bar">
                                <div class="score-bar"></div>
                                <div class="ball-wrapper">
                                    <div class="ball"></div>
                                </div>
                            </div>
                            <button id="btn-neg" class="btn btn-neg"></button>
                            <br>

                            <div class="score"><span id="pos-count">0</span>:<span id="neg-count">0</span></div>

                            <label class="label" for="btn-pos">支持</label>

                            <div class="count">已有<span id="attitude-count">6</span>位用户参与</div>
                            <label class="label" for="btn-neg">反对</label>
                            <br>

                            <div class="plus-wrapper">
                                <div class="plus plus-positive">+1</div>
                                <div class="placeholder"></div>
                                <div class="plus plus-negative">+1</div>
                            </div>

                        </div>


                        <header class="input-limit-tip">
                            <span class="safe">还可以输入</span>
                            <span class="exceed" style="display: none;">已超出</span>
                            <span id="content-count">140</span>
                            字
                        </header>
                        <!--注意：增加项-->
                        <ul class="mes">
                            <li>
                                <div id="replyw" class="reply" style="margin-top:10px;">
                                    <textarea id="project-comment" maxlength="140" name=""
                                              class="border1 comment-comment"
                                              style="width:100%;"></textarea>
                                    <button class="dm-btn" id="btn-project-comment">评论</button>
                                </div>
                            </li>
                        </ul>
                        <div id="comment-box">

                        </div>

                    </div>
                    <div class="c11 mintro">
                        <h4 class="c2"><i></i>推荐项目</h4>

                        <div class="tjxm_body">
                            <div class="bx_wrap">
                                <div class="bx_container">
                                    <ul id="tjxm">
                                        <?php if(is_array($recomendList['project'])): foreach($recomendList['project'] as $key=>$v): ?><li><a href="<?php echo U('project/detail?id='.$v['id']);?>" title="中瀛智募"><img
                                                    src="<?php echo (get_cover($v['cover'],'path')); ?>"><?php echo ($v["project_name"]); ?></a></li><?php endforeach; endif; ?>
                                        <?php if(is_array($recomendList['product'])): foreach($recomendList['product'] as $key=>$v): ?><li><a href="<?php echo U('product/viewdetail/pid/'.$v['id']);?>" title="中瀛智募"><img
                                                    src="<?php echo (get_cover($v['home_img'],'path')); ?>"><?php echo ($v["name"]); ?></a></li><?php endforeach; endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="other ri">
                    <div class="df">
                        <div class="maps">
                            <div id="container" style="min-width:198px;height:198px"></div>
                        </div>
                        <div class="gotodf"><a href="<?php echo U('ProjectScores/index?id='. $project['project']['id']);?>"
                                               rel="popup2" class="poplight">我来打分</a></div>
                        <div id="popup2" class="popup_block">
                            <!-- <iframe src="打分页.html" width="880" height="600" frameborder="0" scrolling="no"></iframe> -->
                        </div>
                        <div class="fqr cl"><a href="<?php echo U('MCenter/profile?id='. $project['project']['uid']);?>"><img
                                src="<?php echo (get_memberface($project["project"]["uid"])); ?>" class="header"><b style="overflow:hidden;"><?php echo (get_membername($project["project"]["uid"])); ?></b></a>发起人
                        </div>

                        <?php if(($project["project"]["vote_leader"]) == "2"): ?><div class="fqr cl"><a
                                    href="<?php echo U('MCenter/profile?id='. $project['leader']['leader_id']);?>"><img
                                    src="<?php echo (get_memberface($project['leader']['leader_id'])); ?>" class="header"><b><?php echo (get_membername($project['leader']['leader_id'])); ?></b></a>领投人
                            </div><?php endif; ?>

                    </div>
                    <?php if(!empty($project["project"]["barcode"])): ?><div class="ew">
                            <h4>扫码进入项目讨论群</h4>
                            <img src="<?php echo ($project["project"]["barcode"]); ?>"></div><?php endif; ?>
                    <div class="ew">
                        <h4>股东回报</h4>

                        <p><?php echo ($project["fund"]["extra"]); ?></p>
                    </div>
                    <div class="ew">
                        <h4>其他要求</h4>

                        <p><?php echo ($project["fund"]["add_source"]); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="average-score-values" style="display: none;">
        <?php echo ($project["averageScores"]["group"]); ?>,<?php echo ($project["averageScores"]["market"]); ?>,<?php echo ($project["averageScores"]["creative"]); ?>,<?php echo ($project["averageScores"]["profitablity"]); ?>,<?php echo ($project["averageScores"]["evaluation"]); ?>
    </div>
    <div id="my-score-values" style="display: none;">
        <?php echo ($userScores["group"]); ?>,<?php echo ($userScores["market"]); ?>,<?php echo ($userScores["creative"]); ?>,<?php echo ($userScores["profitablity"]); ?>,<?php echo ($userScores["evaluation"]); ?>
    </div>
    <div id="quicklogin" class="quicklogin">
        <div class="header clearfix">
            <a href="#" class="tab-title login active" data-target="login-box">会员登录</a>
            <a href="#" class="tab-title reg" data-target="reg-box">快速注册</a>
            <!--<a href="#" class="tab-title password" data-target="change-password-box">输入密码</a>-->
        </div>
        <div class="step-box clearfix">
            <div class="step login-box" data-index="0">

                <div class="message"></div>
                <input name="username" class="input-text username" placeholder="用户名/手机号码">
                <input type="password" name="password" class="input-text password" placeholder="密码">

                <div class="options-box">
                    <input type="checkbox" name="remember-user" id="remember" checked="checked">
                    <label for="remember">记住用户名</label>
                    <a href="<?php echo U('User/forget');?>" title="忘记密码" class="link-forget" style="">忘记密码?</a></div>
                <button class="btn btn-login">登 录</button>
                <div class="social-login-box">
                <!--    <a href="#" title="微信二维码登陆" class="btn-wx-login">微信二维码登陆</a> -->
                </div>

            </div>
            <div class="step reg-box" data-index="1">
                <div class="message"></div>
                <input name="username" class="input-text username" placeholder="手机号码">
                <div class="sms hidden clearfix">
                    <input type="text" name="verify" class="input-text input-sms" placeholder="短信验证码" datatype="n"
                           nullmsg="请输入短信验证码">
                    <button title="发送验证码" href="/User/sendsms.html" class="btn btn-send-sms">发送验证码</button>
                    <input type="password" name="password" class="input-text password" placeholder="密码">
                    <input type="password" name="re-password" class="input-text password re-password"
                           placeholder="重复密码">

                </div>

                <button class="btn btn-next disabled" disabled="disabled">注 册</button>
                <div class="social-login-box">
              <!--      <a href="#" title="微信二维码登陆" class="btn-wx-login">微信二维码登陆</a>		-->
                </div>

            </div>
        </div>
    </div>
    <!-- 二维码 DOM -->
    <div id="login_container"></div>
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
                <p class="phone">0571-86858285</p>
            </div>
        </li>
        <li class="qr">
            <a href="javascript:void(0)">
                <i></i>
                <span>官方微信</span>
            </a>
            <div class="float-panel">
                <img class="qr-img" alt="中瀛智募】</span></p>
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

    <script src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
    <script type="text/javascript" src="/Public/Home/js/addons.js"></script>
    <script type="text/javascript" src="/Public/Home/js/highcharts.js"></script>
    <script type="text/javascript" src="/Public/Home/js/exporting.js"></script>
    <script type="text/javascript" src="/Public/Home/js/highcharts-more.js"></script>
    <script type="text/javascript" src="/Public/Home/js/detail.js"></script>
    <script type="text/javascript" src="/Public/Home/js/jquery.DB_gallery.js"></script>
    <script type="text/javascript" src="/Public/Home/js/jquery.animate-colors-min.js"></script>
    <script src="/Public/static/template.js"></script>

    <script id="reply-template" type="text/html">
        <li class="fresh-comment">
            <dl>
                <dd class="img"><img src="{{user_face}}" alt="{{user_name}}"></dd>
                <dd class="detail">
                    <div class="from"><b>{{user_name}}</b>{{date}}</div>
                    <div class="d">{{content}}</div>

                    <div class="panel" style="display:none;">
                        <input type="hidden" class="comment_id" value="{{data}}">
                        <textarea class="border1" style="width:100%;" maxlength="140"></textarea>
                        <a href="#" class="btn-comment-comment">评论</a></div>
                </dd>
                <dd class="cz"><a href="#" class="btn-slide">回复</a></dd>
                <dd></dd>
            </dl>
        </li>
    </script>

    <script type="text/javascript">
        var serverData = {};
        $('#server-data').children().each(function () {
            var $this = $(this);
            serverData[$this.attr('name')] = $this.val()
        });
        var config = {
            projectCommentAPI: '/project/comment/',
            positiveAPI: '/attitude/positive',
            negativeAPI: '/attitude/negative',
            getAttitudesCountAPI: '/attitude/getNumberOfAttitudes'
        };

        // 项目图片轮播
        $('#DB_gallery').DB_gallery({
            thumWidth: 110, thumGap: 8, thumMoveStep: 4, moveSpeed: 300, fadeSpeed: 500
        });
        // 评分显示用数据
        var averageScore = [],
                myScore = [];
        $.each($.trim($('#average-score-values').text()).split(','), function (i, v) {
            averageScore.push(parseInt(v))
        });
        $.each($.trim($('#my-score-values').text()).split(','), function (i, v) {
            myScore.push(parseInt(v))
        });

        var fetchInvestors = function () {
            $.get('<?php echo U("Pages/investor?pid=".$project["project"]["id"]);?>', function (data) {
                $("#investlist").html(data.html);
                $("#investor-count").html(data.count);
            }, 'json');
        };
        var fetchComments = function () {
            $.get('<?php echo U("Pages/comments?id=".$project["project"]["id"]);?>', function (data) {
                $("#comment-box").html(data.html);
                bindCommentBtnEvent();
                bindReplyTextareaEvent();
            }, 'json');
        };
        fetchInvestors();
        fetchComments();


        // 分页按钮处理
        function pageChange() {
            $('#pagectrl .first,#pagectrl .num,#pagectrl .next,#pagectrl .end,#pagectrl .prev').click(function () {
                $.get($(this).attr('href'), function (data) {
                    $("#investlist").html(data.html);
                    $("#investor-count").html(data.count);
                }, 'json');
                return false;
            });
        }

        function pageChangeComment() {
            $('#pagectrl-comment .first,#pagectrl-comment .num,#pagectrl-comment .next,#pagectrl-comment .end,#pagectrl-comment .prev').click(function () {
                $.get($(this).attr('href'), function (data) {
                    $("#comment-box").html(data.html);
                    //$("#investor-count").html(data.count);
                    location.hash = '';
                    location.hash = '#comments';
                    bindCommentBtnEvent();
                    bindReplyTextareaEvent();
                }, 'json');
                return false;
            });
        }


        // 回复(显示回复输入框)
        var bindCommentBtnEvent = function () {
            $(".btn-slide").unbind().click(function () {

                var $panel = $(this).parent().parent().find('.panel');
                if ($panel.css('display') === 'none') {
                    $panel.slideDown().find('textarea').focus();
                    $('html,body').stop(true, false).animate({
                        scrollTop: $panel.offset().top - 300
                    });
                }
                else
                    $panel.slideUp();

                return false;
            });
            $('.btn-comment-comment').unbind().click(function () {
                var $detail = $(this).parents('.detail'),
                        $textarea = $detail.find('textarea'),
                        commentId = $detail.find('.comment_id').val(),
                        user = $detail.find('.from').children('b').text(),
                        content = $detail.find('.d').text();

                var data = {
                    project_id: serverData.projectId,
                    content: $textarea.val(),
                    reply_id: commentId
                };
                if ($textarea.val() == '') {
                    layer.alert('评论内容不能为空');
                    return false;
                }
                $.post(config.projectCommentAPI, data, function (data) {
                    if (data.status == 1) {
                        fetchComments();
                        /*showCommentComment(data, user, content);
                        $textarea.val('');*/
                    } else {
                        layer.alert(data.info, 8);
                    }
                });
                return false;
            });
        };
        var bindReplyTextareaEvent = function () {
            $('#comment-box').find('textarea').on('keyup change cut paste drop', function () {
                var $this = $(this);
                var maxLen = $this.attr('maxlength');
                var valueLen = $this.val().length;
                if (valueLen > maxLen) {
                    $this.val($this.val().slice(0, maxLen));
                }
            })
        };

        // 发表评论
        $("#btnSend, #btnSend1").click(function () {
            var comment;
            if ($(this).attr('id') == 'btnSend') {
                comment = $("#comment1");
            } else {
                comment = $("#comment2");
            }
            if (comment.val() == '') {
                alert('请先填写评论内容。');
                return false;
            }
            var data = {
                project_id: serverData.projectId,
                content: comment.val(),
                reply_id: 0
            };
            $.post($(this).attr('href'), data, function (data) {
                addNew(data);
                comment.val("");
                alert('评论发表成功。');
            });
            return false;
        });
        //项目评论
        $('#btn-project-comment').click(function () {
            var $textarea = $('#project-comment');
            var data = {
                project_id: serverData.projectId,
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

        //呈现刚发表的评论
        function showTheComment(data) {
            var html = template('reply-template', data);
            $('#comments').prepend(html);
            $('.fresh-comment').css('backgroundColor', '#FFFFCC').animate({
                backgroundColor: '#FFFFFF'
            }, 2000, function () {
                $(this).css('backgroundColor', 'transparent').removeClass('fresh-comment')
            });
            bindCommentBtnEvent();
            bindReplyTextareaEvent();
        }

        $(".btn-heart").click(function () {
            var $this = $(this);
            $.get('<?php echo U("project/attach?id=". $project["project"]["id"]);?>', function (data) {
                if (data.status == 1) {
                    if (data.attach_status == 0) {
                        $this.removeClass('heart');
                        var oFavNum = parseInt($this.text());
                        if (oFavNum > 0) $this.text(oFavNum - 1);
                    } else {
                        $this.addClass('heart');
                        $this.text(parseInt($this.text()) + 1);
                    }
                } else {
                    layer.alert(data.info, 8, function () {
                        window.location = data.url
                    });
                }
            });
            return false;
        });
        $('.btn-comment').click(function () {
            setTab('one', 5, 5);
            return false;
        });

        bindCommentBtnEvent();
        bindReplyTextareaEvent();
        $('.poplight').click(function () {
            var offsetTop = ($(window).height() - 650) / 2;
            if (offsetTop < 0) offsetTop = 0;
            $.layer({
                type: 2,
                title: '我来打分',
                maxmin: true,
                shadeClose: true, //开启点击遮罩关闭层
                area: ['1000px', '650px'],
                offset: [offsetTop + 'px', ''],
                iframe: {src: '/ProjectScores/index/id/' + serverData.projectId + '.html'}
            });
            return false;
        });
        // 剩余字数
        var checkCharacterLimit = function ($textarea, $counter, $safe, $exceed, $button) {
            var maxLen = $textarea.attr('maxlength');
            var checkLen = function () {
                var valueLen = this.value.length;

                if (valueLen > maxLen) {
                    $safe.hide();
                    $exceed.show();
                    $counter.html(valueLen - maxLen);
                    $button.addClass('disabled').attr('disabled', '')
                } else {
                    $safe.show();
                    $exceed.hide();
                    $counter.html(maxLen - valueLen);
                    $button.removeClass('disabled').removeAttr('disabled')
                }
            };
            $textarea.off().on('keyup change cut paste drop', checkLen)
        };
        var $count = $('#content-count');
        checkCharacterLimit(
                $('#project-comment'),
                $count,
                $count.siblings('.safe'),
                $count.siblings('.exceed'),
                $('#btn-project-comment')
        );


        // 支持反对
        var getAttitudeCount = function () {
            $.getJSON(config.getAttitudesCountAPI, {pid: serverData.projectId}).then(function (json) {
                if (json.success) {
                    updateAttitudeCount(json.info);
                }
            });
        };
        var updateAttitudeCount = function (json) {
            var negCount = parseInt(json.negative),
                    posCount = parseInt(json.positive),
                    attitudeCount = negCount + posCount;
            $('#pos-count').text(posCount);
            $('#neg-count').text(negCount);
            $('#attitude-count').text(attitudeCount);
            var percent = posCount / attitudeCount * 100;
            if (attitudeCount === 0) {
                percent = 50;
            }
            $('.score-bar').css('width', percent + '%');
            $('.ball').css('left', percent + '%');
        };
        getAttitudeCount();
        var changeVoteStatus = function () {
            localStorage.setItem('attitudeToProj' + serverData.projectId, true);
            $('.attitudes-wrapper .btn').addClass('disabled').unbind().click(function () {
                return false;
            });
        };
        var showPlusAnimation = function (isPositive) {
            $('.plus-wrapper').addClass('show');
            var $plusElm = null;
            if (isPositive) {
                $plusElm = $('.plus-positive');
            } else {
                $plusElm = $('.plus-negative');
            }
            $plusElm.addClass('show').width();
            $plusElm.addClass('go');
        };
        !function () {
            var voted = localStorage.getItem('attitudeToProj' + serverData.projectId);
            if (voted) {
                $('.attitudes-wrapper .btn').addClass('disabled').click(function () {
                    return false;
                });
            } else {
                $('#btn-pos').click(function () {
                    $.post(config.positiveAPI, {pid: serverData.projectId}, 'json').then(function (json) {
                        if (json.success) {
                            getAttitudeCount();
                            showPlusAnimation(true);
                        } else {
                            layer.msg(json.info, 2, -1)
                        }
                        changeVoteStatus();
                    });
                });
                $('#btn-neg').click(function () {
                    $.post(config.negativeAPI, {pid: serverData.projectId}, 'json').then(function (json) {
                        if (json.success) {
                            getAttitudeCount();
                            showPlusAnimation(false);
                        } else {
                            layer.msg(json.info, 2, -1)
                        }
                        changeVoteStatus();
                    });
                })
            }
        }();
        backTop = (function () {
            var $fixedTools, $window, show, tryShowBackTop;
            show = -1;
            $fixedTools = $('#fixed-tools');
            $window = $(window);
            tryShowBackTop = function () {
                var a, b;
                a = $window.scrollTop();
                b = $window.height();
                if (a > b * 0.38) {
                    if (show !== 1) {
                        show = 1;
                        return $fixedTools.fadeIn('slow');
                    }
                } else {
                    if (show !== 0) {
                        show = 0;
                        return $fixedTools.fadeOut('slow');
                    }
                }
            };
            return {
                init: function () {
                    $window.on('scroll', tryShowBackTop);
                    return $('.back-top').click(function () {
                        $('html,body').animate({
                            scrollTop: 0
                        }, 400);
                        return false;
                    });
                }
            };
        })();
        backTop.init();
    </script>
    <script src="/Public/Home/js/quicklogin.js"></script>
 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden" style="display:none;"><!-- 用于加载统计代码等隐藏元素 -->
    <script src="http://s6.cnzz.com/z_stat.php?id=1253481980&web_id=1253481980" language="JavaScript"></script>
    
</div>

	<!-- /底部 -->
</body>
</html>