<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
  <meta name="keywords" content="创业,投资,理财,众筹,融资" />  
  <meta name="description" content="中瀛智募：
	生于西子湖畔，长于苏堤之间，骨子里透着岳飞的气概，形而间又有着苏轼的豪放。
	
	他，活跃在商道，相信天道酬勤、人道酬善、商道酬信、业道酬精。
	
	他，经营的是信念, 汇聚大众之力，助力大众。
	
	他，带给你互联网社交驱动下的好玩，让你体会项目方和投资人之间的紧密相连。
	
	这是一个因梦而舞，为梦而动的平台；
	
	这是一个让梦想者靠近梦想，坚持梦想，实现梦想的平台；
	
	这是一个让支持者品味梦想，见证梦想，助力梦想的平台。"/>   


<link href="/Public/Home/css/common.css" rel="stylesheet">
<link href="/Public/top.png" type="image/png" rel="shortcut icon">

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="/Public/static/bootstrap/js/html5shiv.js"></script>
<![endif]-->


    <link rel="stylesheet" type="text/css" href="/Public/Home/css/th.css">

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
        <input name="projectId" value="<?php echo ($pid); ?>">
        <input name="editUrl" value="<?php echo U('ProjectAfterInfo/editfundeddetail?pid='.$pid.'&id=_id_');?>">
    </div>
    <div class="body-bg">
        <div class="body">
            <div class="breadcrumbs">
                <a href="/">首页</a> >
                <a href="<?php echo U('MCenter/index');?>">用户中心</a> >
                <a href="<?php echo U('MCenter/pj_support');?>">股权众筹</a> >
                <a href="<?php echo U('ProjectAfterInfo/fundedmanagelist?pid='.$pid);?>">投后管理</a>
            </div>
            <div class="panel">
                <div class="header">
                    <span class="title-label">投后管理</span>
                    <span class="title"><a href="<?php echo U('Project/detail?id='.$pid);?>"><?php echo ($projecttitle); ?></a></span>
                    <button class="btn btn-back">返回</button>
                    <button class="btn btn-new hidden" data-href="<?php echo U('ProjectAfterInfo/editfundeddetail?pid='.$pid);?>">
                        发布项目进度
                    </button>
                </div>
                <div class="tab-title-box">
                    <div class="tab-title-list">
                        <div class="tab-title active"><a
                                href="<?php echo U('ProjectAfterInfo/fundedmanagelist?pid='.$pid);?>">项目进度</a>
                        </div>
                        <div class="tab-title"><a href="<?php echo U('ProjectAfterInfo/investormanagelist?pid='.$pid);?>">股东列表</a>
                        </div>
                    </div>
                </div>
                <div class="tab-content-box">
                    <ul id="stone-list"></ul>
                    <div class="page-box">

                    </div>
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

    <script src="/Public/static/template.js"></script>
    <script id="stone" type="text/html">
        {{each stones as st idx}}
        <li data-id="{{st.id}}">
            <a href="{{st.detailurl}}">
                <span class="date">{{st.publishdate}}</span>
                <span class="title">{{st.title}}</span>
            </a>
            <span class="btn-list">
                {{if st.status === '0'}}
                <a class="publish" href="#">发布</a>
                {{/if}}
                <a class="edit" href="#">编辑</a>
                <a class="delete last" href="#">删除</a>
            </span>
        </li>
        {{/each}}
    </script>
    <script id="stone-not-owner" type="text/html">
        {{each stones as st idx}}
        <li data-id="{{st.id}}">
            <a href="{{st.detailurl}}">
                <span class="date">{{st.publishdate}}</span>
                <span class="title">{{st.title}}</span>
            </a>
            <span class="btn-list">
                {{if st.attachment}}
                <a class="attachment" href={{st.attachment}} target="_blank">附件</a>
                {{/if}}
            </span>
        </li>
        {{/each}}
    </script>
    <script>
        var serverData = {};
        $('#server-data').children().each(function () {
            var $this = $(this);
            serverData[$this.attr('name')] = $this.val()
        });
        !function () {
            var bindEvent = function () {
                $('.btn-back').click(function () {
                    history.back();
                    return false;
                });
                $('.btn-new').click(function () {
                    var href = $(this).data('href');
                    if (href) location.href = href
                });
            };
            var bindStoneEvent = function () {
                var $list = $('#stone-list');
                $list.find('.publish').click(function () {
                    var $li = $(this).parent().parent();
                    var confirmId = layer.confirm('确定发布动态 <span style="color:red;">' + $li.find('.title').text() + '</span> 吗?', function () {
                        var id = $li.data('id');
                        layer.close(confirmId);
                        $.post('/projectAfterInfo/projectAfterPublish', {id: id}, function (json) {
                            layer.msg(json.info, 2, -1);
                            fetchStoneList();
                        });
                    });
                    return false;
                });
                $list.find('.edit').click(function () {
                    var id = $(this).parent().parent().data('id');
                    location.href = serverData.editUrl.replace('_id_', id);
                    return false;
                });
                $list.find('.delete').click(function () {
                    var $li = $(this).parent().parent();
                    var confirmId = layer.confirm('你确实要删除动态 <span style="color:red;">' + $li.find('.title').text() + '</span> 吗?', function () {
                        var id = $li.data('id');
                        layer.close(confirmId);
                        $.post('/projectAfterInfo/removeProjectAfterInfo', {id: id}, function (json) {
                            layer.msg(json.info, 2, -1);
                            fetchStoneList();
                        });
                    });
                    return false;
                });
            };
            var fetchStoneList = function () {
                $.getJSON('/projectAfterInfo/projectAfterInfolist', {pid: serverData.projectId}).then(function (json) {
                    var html = '';
                    if (json.owner) {
                        $('.btn-new').removeClass('hidden');
                    }
                    if (Object.prototype.toString.call(json.info) === "[object Array]") {
                        html = template(json.owner ? 'stone' : 'stone-not-owner', {
                            stones: json.info
                        });
                    } else {
                        html = '<li>' + (json.info || '暂无进度') + '</li>'
                    }

                    $('#stone-list').html(html);
                    bindStoneEvent();
                }, function () {

                })
            };
            $(function () {
                fetchStoneList();
                bindEvent()
            })

        }()
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