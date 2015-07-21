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


<link rel="stylesheet" type="text/css" href="/Public/Home/css/user.css" />
<link rel="stylesheet" type="text/css" href="/Public/Home/css/validform.css" />

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
        <li><a href="<?php echo U('User/detail');?>">个人资料</a></li>
        <!-- <li><a href="<?php echo U('User/profile');?>">修改密码</a></li> -->
        <li class="cur"><a href="<?php echo U('User/applylead');?>">申请领投</a></li>
        <li><a href="<?php echo U('User/addrlist');?>">配送地址</a></li>
        <li><a href="<?php echo U('User/savecenter');?>">安全中心</a></li>
    </ul>

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
            
    <div class="userright ri">
      <form action="<?php echo U();?>" method="POST" class="form">
        <ul class="list">
            <li>
                <h4>申请领投人</h4>
                <?php if(empty($userauth)): elseif($userauth["status"] == 0): ?>
                  <small>申请已提交， 请等待审核。</small>
                <?php elseif($userauth["status"] == 1): ?>
                  <small>申请被拒绝(<span><?php echo ($describe); ?></span>)。</small><?php endif; ?>
                <div class="border1 f14">“领投人机制”是将每一个众筹项目的投资人划分为一个领投人与若干个跟投人，项目领投人是由具备领投资格的投资人提出申请，并由投资人共同选举产生。项目领投人代表全体投资人承担项目的管理职责，包括不限于项目尽职调查、投资条款谈判、签订投资协议、投后管理等事宜，项目领投人在履行上述管理事宜后，可按照协议获得项目超额收益分成。</div>
            </li>
            <li>
              <h4>请选择领投行业</h4>
                <div class="hy">
                <?php if(is_array($industry)): foreach($industry as $key=>$v): ?><label class="checkbox inline">
                  <input datatype="max3" nullmsg="请选择领投行业" type="checkbox" name="focus[]" value="<?php echo ($v["id"]); ?>" <?php if(in_array(($v["id"]), is_array($userdetail['focus'])?$userdetail['focus']:explode(',',$userdetail['focus']))): ?>checked="checked"<?php endif; ?>><?php echo ($v["name"]); ?></label><?php endforeach; endif; ?>
                </div>
            </li>
            <li>
                <h4>个人简介</h4>
                <div><textarea name="resume" class="border1" style="width:735px; resize:none; height:150px; font-size:14px"><?php echo ($userdetail["resume"]); ?></textarea></div>
                <p style="width:500px; color:#999;">要求写明个人求学、工作、创业、投资简历。请具体到起止年月、学校专业学历、公司名称部门职务、投资过企业名称等等，便于我们做真实性背景调查，否则将不予以受理。</p>
            </li>
            <li><div id="errormessage"></div></li>
            <li><input name="" type="submit" value="保存更新" class="c2">
            </li>
        </ul>
      </form>

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

<script type="text/javascript" src="/Public/static/Validform_v5.3.2.js"></script>
<script type="text/javascript">
$("#aaa").on('click',function(event) {
  layer.alert('处理成功！', 1 , 
  function(){window.location.reload();});
});
  $(function() {
    $(".form").Validform({
      datatype:{"max3":function(gets,obj,curform,regxp){
        var atmax=3,
          numselected=curform.find("input[name='"+obj.attr("name")+"']:checked").length;
          
        if(numselected==0){
          return false;
        }else if(numselected>atmax){
          return "最多只能选择"+atmax+"项！";
        }
        return  true;
      }},
    tiptype: function(msg, o, cssctl) {
      var objtip = $("#errormessage");
      objtip.text("");
      if (o.type == 3) {
        cssctl(objtip, o.type);
        objtip.text(msg);
        objtip.show();
      } else {
        objtip.hide();
      }
    }, ajaxPost: true,
    callback: function(data) {
      if (data.status == 1) {
        layer.alert(data.info, 9, function(){window.location.reload();});
      } else {
        var index = layer.alert(data.info, 8, function() {
          if (data.url != '') {
            window.location.href=data.url;
          } else {
            layer.close(index);
          }
        });
      }
    }
  });
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