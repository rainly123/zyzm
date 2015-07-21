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


<link rel="stylesheet" type="text/css" href="/Public/Home/css/user.css" />

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
	<div class="fl w100 usertopbar">
    <div class="content cl">
        <div class="fl">
        <span class="avatar">
            <img id="avatar-img" src="<?php echo get_memberface();?>">
            <span class="avatar-change">修改头像</span>
        </span>
            <b><?php echo get_membername(is_login());?></b>
        </div>
        <div class="ri">
            <a href="<?php echo U('Message/index');?>" class="xx">消息</a>
        </div>
    </div>
</div>
<div class="fl w100 usermain mt15">
    <div class="content">
        <div class="tabs cl">
            
    <ul>
        <li><a href="<?php echo U('MCenter/pj_support');?>">支持的项目</a></li>
        <li class="cur"><a href="<?php echo U('MCenter/pj_create');?>">发起的项目</a></li>
        <li><a href="<?php echo U('MCenter/pj_attach');?>">收藏的项目</a></li>
    </ul>
 <span class="rtlink"><a href="<?php echo U('Project/create');?>" class="fq">+ 发起项目</a></span>

        </div>
        <div class="maincontent cl">
            <div class="userleft fl">
                <ul>
                    <li><em id="c1"></em><a href="<?php echo U('MCenter/pj_support');?>">股权众筹</a></li>
                    <li><em id="c2"></em><a href="<?php echo U('MCenter/pr_support');?>">实物众筹</a></li>
                     <li><em id="c6"></em><a href="<?php echo U('MCenter/stock');?>">基金管理</a></li>
                    <li><em id="c3"></em><a href="<?php echo U('Account/index');?>">账户管理</a></li>
                    <li class="cur"><em id="c4"></em><a href="<?php echo U('User/detail');?>">个人中心</a></li>
                    <li><em id="c5"></em><a href="<?php echo U('Message/index');?>">消息管理</a></li>
                </ul>
            </div>
            
<div class="userright2 ri">
<div class="bs-docs-example" style="border: none;">
			<div class="rctj_box">
				<table class="table table-bordered">
				<tr>
					<td colspan ="3" >
						<h3>项目名称：
							<a href="<?php echo U('Project/detail?id='.$fund['id']);?>"><?php echo ($fund["project_name"]); ?></a>
							<input type="hidden" class="ids" name="pid" value="<?php echo ($fund["id"]); ?>" id="pid">
						</h3>
					</td>
				</tr>
					<tr>
						<td width="33%">
							<div class="project-fund-bottom"><h4>融资金额</h4></div>
							<div class="project-fund-top"><h3><span class="money_num"><?php echo (change_fund($fund["need_fund"])); ?> </span>元</h3></div>
						</td>
						<td width="33%">
							<div class="project-fund-bottom"><h4>已融金额</h4></div>
							<div class="project-fund-top"><h3><span class="money_num"><?php echo (change_fund($fund["has_fund"])); ?> </span>元</h3></div>
						</td>
						<td width="33%">
							<div class="project-fund-bottom"><h4>已支付金额</h4></div>
							<div class="project-fund-top"><h3><span class="money_num"><?php echo (change_fund($fund["pay_fund"])); ?> </span>元</h3>
							<input type="hidden" id="agreefund" value="<?php echo ($fund["pay_fund"]); ?>"></div>
						</td>
					</tr>
				</table>
			</div>
			<!-- 数据列表 -->
			<div class="data-table">
				<table class="tt">
				    <thead>
				        <tr>
						<th class="">序号</th>
						<th class="">投资人</th>
						<?php if($fund["stage"] == 2): ?><th class="">他的估值</th>
						<?php else: ?>
						<th class="">投资人身份</th><?php endif; ?>
						<th class="">金额</th>
						<th class="">项目状态</th>
						<th class="">操作</th>
						</tr>
				    </thead>
				    <tbody>
						<?php if(is_array($investor)): $i = 0; $__LIST__ = $investor;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($i); ?> </td>
								<td><?php echo (get_membername($vo["investor_id"])); ?></td>
								<?php if($fund["stage"] == 2): ?><td><?php echo (change_fund($vo["project_valuation"])); ?></td>
								<?php else: ?>
									<td><?php echo ($vo["lead_type_text"]); ?></td><?php endif; ?>
								<td><span><?php echo (change_fund($vo["fund"])); ?>元</span>
								<input type="hidden" name="fund" value="<?php echo ($vo["fund"]); ?>"></td>
								<td><?php echo ($vo["status_text"]); ?>
								</td>
								<td>
								<?php if(!empty($vo["others"])): ?><a href="javascript:void(0);" data-toggle="popover" class="see-button" data-placement="left" data-content="<?php echo ((isset($vo["others"]) && ($vo["others"] !== ""))?($vo["others"]):'无'); ?>" data-original-title="附加帮助">其他资源</a><?php endif; ?>
								<?php if($fund["stage"] >= 4): if(($vo["status"]) == "2"): ?><a href="<?php echo U('Manage/agree?id='.$vo['investorid']);?>" class="agree" data-user="<?php echo (get_membername($vo["investor_id"])); ?>">接受</a><?php endif; ?>
									<?php if(($vo["status"]) == "3"): ?><a href="<?php echo U('Manage/agreecancel?id='.$vo['investorid']);?>" class="agreecancel" data-user="<?php echo (get_membername($vo["investor_id"])); ?>">撤消</a><?php endif; endif; ?>
				        </td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
				</table>
			</div>
			<!-- 分页 -->
			<div class="page"><?php echo ($_page); ?></div>
			<!-- /分页 -->
		</div>
</div>

        </div>
    </div>
</div>
<link rel="stylesheet" href="/Public/static/Jcrop/css/jquery.Jcrop.min.css">


<div class="up-pic-box" id="up-pic-box" style="">
    <input type="file" id="download" class="up-avatar" name="download">
    <label class="up-pic-label" for="download">上传图片</label>
    <div id="crop-box">
        <img id="crop-img" src="/Public/Home/images/tiny.png">
    </div>
    <div class="up-box-footer">
        <button id="up-avatar-submit">确定</button>
        <button id="up-avatar-cancel">取消</button>
    </div>
    <form id="change-photo-form" action="<?php echo U('User/changePhoto');?>" method="post">
        <input type="hidden" id="avatar-id" name="photo" value="">
        <input type="hidden" id="x" name="x" value="">
        <input type="hidden" id="y" name="y" value="">
        <input type="hidden" id="w" name="w" value="">
        <input type="hidden" id="h" name="h" value="">
        <!--<input type="hidden" id="sw" name="sw">
        <input type="hidden" id="sh" name="sh">-->
        <input type="hidden" name="flag" value="1">
        <input type="hidden" id="basepath" name="basepath" value="/Uploads/Picture/Photo/552521d06b169.jpg">
    </form>
</div>
<script src="/Public/static/Jcrop/js/jquery.Jcrop.min.js"></script>
<script type="text/javascript" src="/Public/static/jquery.upload.js"></script>
<script>
    var upAvatarLayerId = 0;
    $('.usertopbar .avatar').click(function () {
        var offsetTop = Math.round(($(window).height() - 470) / 2);
        if (offsetTop < 0) offsetTop = 0;
        upAvatarLayerId = $.layer({
            type: 1,
            title: "上传头像",
            offset: [offsetTop + 'px', ''],
            area: ['562px', '470px'],
            page: {dom: '#up-pic-box'}
        });
    });
    var clearCoords = function (c) {
        $('#x').val("");
        $('#y').val("");
        $('#w').val("");
        $('#h').val("");
    };
    var updateCoords = function (c) {
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#w').val(c.w);
        $('#h').val(c.h);
    };
    var jcrop_api;
    $('.up-avatar').change(function () {
        $.upload({
            url: '<?php echo U("File/uploadPhoto");?>',
            fileName: 'download',
            dataType: 'json',
            accept: '.jpg,.jpeg,.png,.gif',
            // 上传之前回调,return true表示可继续上传
            onSend: function () {
                return true;
            },
            // 上传之后回调
            onComplate: function (json) {
                jcrop_api && jcrop_api.destroy();
                var $img = $('#crop-img');
                $img.css({
                    'width': 'auto',
                    'height': 'auto'
                });
                $img.attr('src', json.path);
                $img.on('load', function () {
                    $img.Jcrop({
                        aspectRatio: 1,
                        bgColor: '#eee',
                        boxWidth: 542,
                        boxHeight: 328,
                        setSelect: [0, 0, 100, 100],
                        onSelect: updateCoords,
                        onRelease: clearCoords
                    }, function () {
                        jcrop_api = this;
                    });
                });
                $('#avatar-id').val(json.id);
                $('#basepath').val(json.path);
            }
        });
    });
    $('#up-avatar-submit').click(function () {
        if (!$('#avatar-id').val()) {
            layer.tips('请上传照片', $('#download').get(0), {
                guide: 2,
                style: ['background-color:#0FA6D8; color:#fff; font-size:14px;', '#0FA6D8'],
                time: 2
            });
            return false;
        }
        var $form = $("#change-photo-form");
        var success = function (json) {
            if (json.status) {
                layer.close(upAvatarLayerId);
                $('#avatar-img').attr('src', json.photo_url);
                layer.msg(json.info, 2, 9);
            } else {
                alert(json);
            }
        };
        $.ajax({
            type: 'POST',
            url: $form.attr('action'),
            data: $form.serialize(),
            success: success,
            error: function () {
                //console.log(arguments)
            }
        });
    });
    $('#up-avatar-cancel').click(function () {
        layer.close(upAvatarLayerId);
    })
</script>
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
  // 指定左侧选中菜单
  var submenu = "<?php echo U('MCenter/pj_support');?>";
  
	$(".see-button").click(function(){
		alert($(this).attr("data-content"));
	});
  
</script>
 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden" style="display:none;"><!-- 用于加载统计代码等隐藏元素 -->
    <script src="http://s6.cnzz.com/z_stat.php?id=1253481980&web_id=1253481980" language="JavaScript"></script>
    
</div>

	<!-- /底部 -->
<!-- 右侧当前菜单选中状态修改 -->
<script type="text/javascript">
$(document).ready(function() {
	// 左侧菜单选中
	if (typeof(submenu) !== 'undefined') {
		$(".userleft li").removeClass('cur');
		$(".userleft a").each(function(index, el) {
			var href = $(el).attr('href');
		
			if (href == submenu) {
				$(el).parents('li').addClass('cur');
			}
		});	
	}
});
</script>
</body>
</html>