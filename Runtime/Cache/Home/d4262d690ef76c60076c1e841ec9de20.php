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
	
<link rel="stylesheet" type="text/css" href="/Public/Home/css/user.css" />
<link href="/Public/Home/css/style.css" rel="stylesheet">
	<style>
		.up_file {
			background-image: /Public/Home/images/btn_addattach.jpg;
			opacity: 0;
			width: 72px;
			height: 64px;
			position: absolute;
			margin-left: -82px;
		}
	</style>



<!-- 	<div class="">
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
        	<dl class="cl">
            <dd class="product">
				<h2>填写项目信息</h2>
				<h4>回报设置</h4>
                <div class="form" style="margin:0 40px;">
		                <div class="tabList">
                            <table cellpadding="1" border="1">
		                        <tbody><tr>
		                            <th width="60">序号</th>
		                            <th width="100">支付金额</th>
		                            <th width="80">名额</th>
		                            <th width="320">回报内容</th>
		                            <th width="120">回报时间</th>
									<th width="110">运费</th>
									<th width="100">抽奖</th>
									<th width="100">单笔限购</th>
		                            <th width="160">操作</th>
		                        </tr>
		                   		<?php if(is_array($resultPrice)): foreach($resultPrice as $key=>$vo): ?><tr>
		                                <td><?php echo ($vo["id"]); ?></td>
		                                <td><span class="red">￥<?php echo ($vo["amount"]); ?></span></td>
		                                <td>
	                                        <?php if($vo['count'] == 0): ?>无限制
		                                    <?php else: ?>
			                                    <?php echo ($vo["count"]); endif; ?>
	                                    </td>
		                                <td style="text-align: center;">
		                                    <?php echo ($vo["content"]); ?>
		                                </td>
		                                <td><?php echo ($vo["afterday"]); ?></td>
		                                <td><span class="red">￥<?php echo ($vo["post_amount"]); ?>元</span></td>
		                         		<td width="100"><?php if($vo['is_luck'] == 0): ?>不参加<?php else: ?>参加<?php endif; ?></td>
										<td width="100"><?php echo ($vo["single_limit"]); ?>件</td>
		                                <td>
		                                    <a href="#" data-pricedata="<?php echo U('Product/getPriceUsedRevise?id='.$vo[id]);?>" class="revise-price">编辑</a>
		                                    <a data-href="<?php echo U('Product/deleteProductPrice?id='.$vo[id]);?>" class="delect-price" href="#">删除</a>
		                                </td>
		                            </tr><?php endforeach; endif; ?>
								
                            </tbody></table>
	                    </div>

						<div class="w_adda hide" style="padding-left:120px;">
		                    <!-- 添加回报 -->
		                    <button class="btn_red" id="addBack">添加回报</button>
		                </div>

		                <div class="w_addInfo" style="display: none;">
	                    	<form id="product_add"  method="Post" class="redound-edith">
								<h4>添加回报选项:</h4>
								<ul>
									<li class="ckpre">
									  <label><em>*</em>查回报类别</label>
									  <a href="javascript:void(0)" id="one1" onclick="setTab('one',1,2)" class="choosecur">实物回报</a>
									  <a href="javascript:void(0)" style="margin-left:10px;" id="one2" onclick="setTab('one',2,2)">虚拟回报 </a>
										 <input type="hidden" name="price_type" id="hidprice_type" value="0">
									</li>
									<li>
									  <label><em>*</em>支持金额</label>
									  <input type="text" class="c1" id="je" name="amount" value="0" placeholder="请输入支持金额" datatype="n" nullmsg="请输入支持金额" errormsg="支持金额只能是数字">
									</li>
									<li>
									  <label><em>*</em>回报内容</label>
									  <textarea id="content" name="content" datatype="*" nullmsg="请输入回报内容" placeholder="最多不超过200个字" class="c2"></textarea>
									</li>
									<li class="addattach">
										<label><em>*</em>回报说明图片</label>
										<span class="fl"><em class="fl">*</em>
											<a href="#">
												<img src="/Public/Home/images/btn_addattach.jpg" class="fl" width="72" height="64"  style="margin-right:10px;">
												<input type="file" class="up_file" name="up_image" id="up_image" onchange="upload_image('up_image');">
												
											</a>
											<input type="hidden" name="image" id="hidup_image" value="" datatype="*" nullmsg="请上传回报说明图片">
											<img id = "up_image_view" src=""  alt="" style="" />
											大小不超过2M，建议尺寸：78*78px
										</span>
										<span class="ri">
										<a onmouseover="ddd('aa', 'show');" onmouseout="ddd('aa', 'hide');" class="wenhao"><img src="/Public/Home/images/addattchintro.jpg"></a> 
										<div class="intro" style="display:none;" id="aa"><em></em>在此处上传图片，支持格式png、jpeg、jpg，尺寸78*78px</div>
										</span>
									</li>

									<li>
									  <label><em>*</em>限定名额</label>
									  <input type="text" class="c1" datatype="n" placeholder="请输入限定名额" nullmsg="请输入限定名额" id="count" name="count" value="0">
									 
									  <span style="padding-left:1px;">0表示不限名额</span>
									</li>
									<li>
									  <label><em>*</em>运费</label>
									  <input type="text" class="c1" id="post_amount" name="post_amount" value="0" datatype="n"  nullmsg="请输入运费金额" placeholder="请输入运费">
									  <span style="padding-left:1px;">元 0表示包邮</span>
									</li>
									<li>
									  <label><em>*</em>回报时间</label>
									  <span>项目结束后</span>
									  <input type="text" datatype="n" class="c80" id="afterday" name="afterday" placeholder="请输入天数" nullmsg="请输入回报时间">
									  <span style="padding-left:1px;width:200px;">天，会向支持者发送回报</span>
									</li>
									<li>
									  <label>单笔限购数量</label>
									  <input type="text" datatype="n" class="c1" id="single_limit" value="1" name="single_limit" placeholder="请输入单笔限购数量" nullmsg="请输入单笔限购数量">
									  <span style="padding-left:1px;">件，默认为1</span>
									</li>
									<li class="ckpre">
									  <label>抽奖设置</label>
									  <a href="javascript:void(0)" id="luck" onclick="select('luck')" class="">是否参加抽奖</a>
									  <input type="hidden" name="is_luck" id="hidluck" value="0">
									</li>
									<li class="ckpre">
									  <label>是否需要验证码</label>
									<!--   <a href="javascript:void(0)" id="share" onclick="select('share')" class="">是否需要验证码</a> -->
										<a href="javascript:void(0)" id="share1" onclick="setshare('share',1,3)" class="choosecur">不使用</a>
									  	<a href="javascript:void(0)" style="margin-left:10px;" id="share2" onclick="setshare('share',2,3)">生成验证码</a>
										<a href="javascript:void(0)" style="margin-left:10px;" id="share3" onclick="setshare('share',3,3)">使用验证码</a>
									  	<input type="hidden" name="is_share" id="hidshare" value="1">
									</li>
									<li>
									  <label>验证码数量限制</label>
									  <input type="text" class="c1" id="share_limit" value="0" name="share_limit">
									  <span style="padding-left:1px;">0表示不限</span>
									</li>
									<li class="ckpre">
									  <label>限购范围</label>
										<a href="<?php echo U('Product/modify_rule');?>" id="addrule" style="font-size:14px">添加限购范围</a>
										<span id="buy_rule" class="Validform_checktip">不限</span>
									  <input type="hidden" name="province" id="hidprovince" value="0">
									  <input type="hidden" name="city" id="hidcity" value="0">
									  <input type="hidden" name="invest_type" id="hidtype" value="0">
									  <input type="hidden" name="invest_select" id="hidselect" value="0">
									</li>
									<li>
									
									</li>
								</ul>
								</br>
								<div class="ui-edith-button">
									<input type="hidden" name="order_number" value="" id="price_id">
				                    <!-- 确定 取消 -->
				                    <input type="submit" class="btn_red" value="确定">
				                    <input type="button" class="btn_red" id="cancle" value="取消">
			                    </div>
	                    	</form>
		                </div> <!-- w_addInfo end -->
				</div>
            </dd>
            </dl>

			<div class="common_button">
				<div class="risk_tips">
					<b>风险说明：</b>	<p>3个以上的回报：多些选择能提高项目的支持率。几十、几百、上千元的支持：3个不同档次的回报，能让你的项目更快成功。回报最好是项目的衍生品：与项目内容有关的回报更能吸引到大家的支持。</p>
				</div>
				<a href="<?php echo U('Product/addstep1?pid='.$pid);?>"><input type="button" class="btn_red" value="上一步"></a>
				<a href="<?php echo U('Product/addstep3?pid='.$pid);?>"><input type="button" class="btn_red" value="下一步"></a>
			</div>
        </div>
    </div>
</div>
<div id="dialog" style="display:none"></div>


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
    <script type="text/javascript" >
    	var index;
    	$("#addrule, .modify_addr").on('click', function() {
    	
    	  $("#dialog").html("");
    	  $("#dialog").load($(this).attr('href'));
    	   index = $.layer({type:1, title:false,area : ['553px','400px'], page:{dom:"#dialog"}, fadeIn:300});
    	  return false;
    	});
    
		//上传缩略图
		function upload_image(upfile_name){
			var viewImg = '#' + upfile_name + '_view';
			var hidfileName = '#hid' + upfile_name;
	        $.upload({
		          url: '<?php echo U("File/uploadProduct");?>', 
		          fileName: upfile_name, 
		          dataType: 'json',
		          accept: '.jpg,.jpeg,.png,.gif',
		          // 上传之前回调,return true表    示可继续上传
		          onSend: function() {
		              return true;
		          },
		          // 上传之后回调
		          onComplate: function(data) {
		            if(data.status == 1) {
		            	$(viewImg).attr('src', data.path);
		            	$(viewImg).attr('style', 'width:78px;height:78px;');
		          		$(hidfileName).val(data.id);
		            } else {
		                alert(data.info);
		            }
		          }
			});
		}
	    $(function(){
			$("#product_add").Validform({
				tiptype:3,
				btnSubmit:"#confirm",
				ajaxPost:true,
				callback:function(data){
					if (data.status) {
						window.location.reload();
					}else{
						alert(data.info);
					}
				}
			});
			
			//添加回报
			$("#addBack").click(function(){
				$(".w_adda").hide(function(){
					$(".w_addInfo").fadeIn();
				});
			});
			
			//取消
			$("#cancle").click(function(){
				$(".w_addInfo").fadeOut(function(){
					$(".w_adda").show();
				});
			});

			// 编辑。。。。
			$(".revise-price").click(function(){
				$.get($(this).data('pricedata'),function(data){
					if (data.status) {
				
						$("#hidprice_type").attr('value',data.info.price_type);
						$("#hidshare").attr('value',data.info.is_share);
						$("#je").attr('value',data.info.amount);
						$("#content").html(data.info.content);
						$("#upload").attr('datatype','');
						$("#hidup_image").attr('value',data.info.image);
						$("#up_image_view").attr('src',data.info.image_url);
						$("#up_image_view").attr('style', 'width:78px;height:78px;');
						$("#count").attr('value',data.info.count);
						$("#post_amount").attr('value',data.info.post_amount);
						$("#afterday").attr('value',data.info.afterday);
						$("#single_limit").attr('value',data.info.single_limit);
						$("#price_id").attr('value',data.info.id);
						$("#hidluck").attr('value',data.info.is_luck);
						$("#hidprovince").attr('value',data.info.province);
						$("#hidcity").attr('value',data.info.city);
						$("#hidtype").attr('value',data.info.invest_type);
						$("#hidselect").attr('value',data.info.invest_select);
						$("#share_limit").attr('value',data.info.share_limit);
						$("#hidshare").attr('value',data.info.is_share);
						
						var showmsg='';

						if(data.info.province ==0){
							var province_txt = '';
						}else{
							var province_txt = $("#J_province").find("option:selected").text();
						}
						
						if(data.info.city ==0){
							var city_txt = '';
						}else{
							var city_txt = $("#J_city").find("option:selected").text();
						}
						
						if(data.info.invest_type =='1'){
							var touzi_txt = '投资类别:股权投资';
						}else if(data.info.invest_type =='2'){
							var touzi_txt = '投资类别:实物投资';
						}else{
							var touzi_txt='';
						}
						if(data.info.invest_select ==0){
							var cc1_txt='';
						}else{
							var cc1_txt = '投资金额：'+ $("#cc1").find("option:selected").text();
						}

						//限制条件
						if(province_txt =='' && city_txt=='' && touzi_txt=='' && cc1_txt==''){
							showmsg='不限';
							document.getElementById('addrule').className="";
						}else{
							showmsg = '(限购范围：' + province_txt + ' ' + city_txt + ' '+ touzi_txt +' '+ cc1_txt +')';
							document.getElementById('addrule').className="choosecur";
						}
						
						document.getElementById('buy_rule').innerText=showmsg;
						//是否抽奖选择状态
						var menu=document.getElementById('luck');
						if(data.info.is_luck ==1){
							menu.className="choosecur";
							
						}else{
							menu.className="";
						}
						
						//是否验证码
						var share=document.getElementById('share');
						if(data.info.is_share ==1){
							share.className="choosecur";
							
						}else{
							share.className="";
						}
						
						//回报类型
						if(data.info.price_type ==0){
							setTab('one',1,2)
						}else{
							setTab('one',2,2)
						}
						
						//回报类型
						if(data.info.is_share ==1){
							setTab('share',1,3)
						}else if(data.info.is_share ==2){
							setTab('share',2,3)
						}else{
							setTab('share',3,3)
						}
						
					}else{
						alert(data.info);
						return false;
					};
				},'json');
		
				$(".w_adda").hide(function(){
					$(".w_addInfo").fadeIn();
				});
			});
		})

		//选择实物或虚拟回报
	function setTab(name,cursel,n)
	{
		for(i=1;i<=n;i++){
			var menu=document.getElementById(name+i);
			menu.className=i==cursel?"choosecur":"";
		}
		
		if(cursel==2){
			$('#hidprice_type').val(1);
		}else{
			$('#hidprice_type').val(0);
		}
	}
	    
		//选择验证码使用
		function setshare(name,cursel,n)
		{
			for(i=1;i<=n;i++){
				var menu=document.getElementById(name+i);
				menu.className=i==cursel?"choosecur":"";
			}
			
			$('#hidshare').val(cursel);
		}

	    //是否抽奖
	function select(name)
	{
		var hidfileName = '#hid' + name;
		var menu=document.getElementById(name);
		menu.className=menu.className==""?"choosecur":"";
		var checked = menu.className=="choosecur"?"1":"0";
		$(hidfileName).val(checked);
		
	}

	    //提示信息显示
	function ddd(obj, sType) { 
		var oDiv = document.getElementById(obj); 
		if (sType == 'show') { oDiv.style.display = 'block';} 
		if (sType == 'hide') { oDiv.style.display = 'none';} 
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