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
	
	<link href="/Public/Home/css/style.css" rel="stylesheet">




	<!-- <div class="">
    <div class="xmsteps">
        <div class="content">
            <div class="nav-steps clearfix">
                <ul>
                    <li class="step1 ">项目及发起人信息</li>
                    <li class="step2">回报设置</li>
                    <li class="step3">确认信息</li>
                    <li class="step4">完成</li>
                    <li style="display:none" id="get-nav-flage" data-navflage="<?php echo ($navFlage); ?>"></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        var navFlage = $("#get-nav-flage").data('navflage');
        var newNavFlage = '.'+navFlage;
        $(newNavFlage).attr('class','finish');
    });
</script> -->
<div class="fl w100 mainwrap mt25">
	<div class="content">
		<div class="bread"><a href="#">首页</a>　>　发起梦想</div>
        <div class="main mt20">
         <form id="product_add"  method="Post" class="redound-edith">
        	<dl class="cl">
            <dd class="product">
           
            	<h2>填写项目信息</h2>
                <h4>收款人信息</h4>
                <div class="form ml80">
					<ul>
						<li class="ckpre">
							<label></label>
	
							 
							<?php if(empty($type)): ?><a href="javascript:void(0)" id="one1" onclick="setTab('one',1,2)" class="choosecur">个人账户</a>
								<a href="javascript:void(0)" style="margin-left:10px;" id="one2" onclick="setTab('one',2,2)">公司账户</a>
							 	<input type="hidden" name="type" id="hidtype" value="0">
							 <?php else: ?>
							 	<?php if(($type) == "0"): ?><a href="javascript:void(0)" id="one1" onclick="setTab('one',1,2)" class="choosecur">个人账户</a>
									<a href="javascript:void(0)" style="margin-left:10px;" id="one2" onclick="setTab('one',2,2)">公司账户</a>
								 	<input type="hidden" name="type" id="hidtype" value="0">
							 	<?php else: ?>
									<a href="javascript:void(0)" id="one1" onclick="setTab('one',1,2)">个人账户</a>
									<a href="javascript:void(0)" style="margin-left:10px;" id="one2"  class="choosecur" onclick="setTab('one',2,2)">公司账户</a>
								 	<input type="hidden" name="type" id="hidtype" value="1"><?php endif; endif; ?>
					 
						</li>
						<li>
						  <label><em>*</em>收款人信息</label>
						  <input type="text" class="c1" id="holderName" value="<?php echo ($true_name); ?>" name="true_name" datatype="*" nullmsg="请输入收款人信息" placeholder="请输入收款人信息">
						</li>
						<li>
						  <label><em>*</em>开户行名称</label>
						  <div class="select">
							    <select class="c1" id="c"  name="bank_id" datatype="*" nullmsg="请选择开户银行">
							      <option value="">请选择开户银行</option>
									<?php if(is_array($bankinfo)): foreach($bankinfo as $key=>$v): if($v[id] == $bank_id): ?><option value="<?php echo ($v["id"]); ?>" selected><?php echo ($v["bank_name"]); ?></option>
										<?php else: ?>
											<option value="<?php echo ($v["id"]); ?>"><?php echo ($v["bank_name"]); ?></option><?php endif; endforeach; endif; ?>
							    </select>
						</div>
						</li>
						<li>
						  <label><em>*</em>开户支行名称</label>
						  <input type="text" class="c1" id="sub_branch" value="<?php echo ($sub_branch); ?>" name="sub_branch" datatype="*" nullmsg="请输入开户支行名称" placeholder="请输入开户支行名称">
						</li>
						<li>
						  <label><em>*</em>开户行所在省</label>
						  <input type="text" class="c1" id="bank_province" value="<?php echo ($bank_province); ?>" name="bank_province" datatype="*" nullmsg="请输入开户行所在省" placeholder="请输入开户行所在省">
						  <span style="padding-left:1px;">填写时不带省或自治区，如北京、广西</span>
						</li>
						<li>
						  <label><em>*</em>开户行所在市</label>
						  <input type="text" class="c1" id="bank_city" value="<?php echo ($bank_city); ?>" name="bank_city" datatype="*" nullmsg="请输入开户行所在市" placeholder="请输入开户行所在市">
						  <span style="padding-left:1px;">填写时不带市，如杭州</span>
						</li>
						
						<li>
						  <label><em>*</em>银行卡号</label>
						  <input type="text" class="c1" id="card_number" value="<?php echo ($card_number); ?>" name="card_number" datatype="*" nullmsg="请输入银行卡号" placeholder="请输入银行卡号">
						</li>
						<li>
						  <label><em>*</em>确认银行卡号</label>
						  <input type="text" class="c1" id="confirm_card_number" value="<?php echo ($card_number); ?>" name="confirm_card_number" recheck="card_number" datatype="*" nullmsg="请确认银行卡号" placeholder="请确认银行卡号">
						</li>
				</div>

            </dd>
            </dl>
			<div class="common_button">
				<div class="risk_tips">
					<b>温馨提示：</b>	
					<p>请确认本页信息，并填写完整的银行信息，确保项目成功后您能快速拿到款项。</p>
				</div>
				<input type="submit" class="btn_red" value="发布项目">
			</div>
			</form>
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

	<link href="/Public/Home/css/validform.css" rel="stylesheet">
	<script type="text/javascript" src="/Public/static/jquery.upload.js"></script>
	<script type="text/javascript" src="/Public/static/Validform_v5.3.2.js"></script>
	<script type="text/javascript" src="/Public/Home/js/jQselect.js"></script>
	<script type="text/javascript">
		$(function(){
			//下拉框初始化
			$("#c").selectbox();
			
			$("#product_add").Validform({
				tiptype:3,
				btnSubmit:"#confirm",
				ajaxPost:true,
				callback:function(data){
					if (data.status==1) {
						window.location.href = data.url;
					}else{
						alert(data.info);
					}
				}
			});
		})
	
		function setTab(name,cursel,n)
		{
			for(i=1;i<=n;i++){
				var menu=document.getElementById(name+i);
				menu.className=i==cursel?"choosecur":"";
			}
			
			if(cursel==2){
				$('#hidtype').val(1);
			}else{
				$('#hidtype').val(0);
			}
		}
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