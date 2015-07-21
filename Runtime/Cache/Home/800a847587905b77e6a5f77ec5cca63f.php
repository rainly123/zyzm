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
<style>
	.up_file {
		background-image: /Public/Home/images/btn_addattach.jpg;
		opacity: 0;
		width: 72px;
		height: 64px;
		position: absolute;
		margin-left: -82px;
		filter:alpha(opacity=0);
		-moz-opacity:0;
		top:0;
		cursor: pointer;
	}
	.fl {
		position: relative;
	}
.hidden {
	visibility: hidden
}
</style>



<div class="fl w100 mainwrap mt25">
	<div class="content">
		<div class="bread"><a href="#">首页</a>　>　发起梦想</div>
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
        <div class="main mt20">
        <form name="product_add" id="product_add" action="" method="POST">
        	<dl class="cl">
            <dd class="product">
            	<h2>填写项目信息</h2>
                <h4>项目及发起人信息</h4>

                <div class="form ml80">
					<ul>
						<li>
						  <label><em>*</em>项目分类</label>
							<span class="bq">
							<?php if(is_array($pj_type)): foreach($pj_type as $key=>$vo): ?><a href="#" id="<?php echo ($vo["id"]); ?>" <?php if(in_array(($vo["id"]), is_array($types)?$types:explode(',',$types))): ?>class='cur'<?php endif; ?> ><?php echo ($vo["type_name"]); ?></a><?php endforeach; endif; ?>
								<span class="Validform_checktip Validform_wrong pjtype hidden">项目分类不能为空</span>
							</span>
							<input type="hidden" name="types" id="hidtype" value="<?php echo ($types); ?>">
						</li>
						<li>
						  <label><em>*</em>项目标题</label>
						  <input type="text" class="c1" id="name" name="name" value="<?php echo ($name); ?>" placeholder="请输入你的项目标题（25个字内）" datatype="*1-25" nullmsg="项目标题不能为空" errormsg="项目标题不能超过25个字！">
						</li>

						<li>
						  <label><em>*</em>项目简介</label>
						  <input type="text" class="c1" id="abstract" name="abstract" value="<?php echo ($abstract); ?>" datatype="*1-150" placeholder="请用一句话描述项目内容（1-150个字）" nullmsg="项目简介不能为空" errormsg="项目简介1-150个字！">
						</li>
						<li>
						  <label><em>*</em>筹资金额</label>
						  <input type="text" class="c1" id="je" name="amount" value="<?php echo (round($amount,2)); ?>" placeholder="请输入筹资金额" datatype="n" nullmsg="请输入筹资金额" errormsg="筹资金额只能是数字">
						</li>
						<li>
						  <label><em>*</em>筹资上限</label>
						  <input type="text" class="c1" id="title" name="top_amount" value="<?php echo (round($top_amount,0)); ?>" placeholder="请输入筹资上限" datatype="n" nullmsg="请输入筹资上限" errormsg="筹资上限只能是数字">
						  <label style="padding-left:1px;">% 填0是无上限</label>
						</li>
						<li>
						  <label><em>*</em>筹资天数</label>
						  <input type="text" class="c1" id="title" name="days" value="<?php echo ($days); ?>" placeholder="请输入筹资天数" datatype="n" nullmsg="请输入筹资天数" errormsg="筹资天数只能是数字">
						  <label style="padding-left:1px;width:10px;">天</label>
						</li>
						<li class="addattach">
							<label><em>*</em>首屏图片</label>
							<span class="fl">
								<a href="#">
									<img src="/Public/Home/images/btn_addattach.jpg" class="fl" width="72" height="64" style="margin-right:10px;">
									<input type="file" class="up_file" name="home_img" id="home_img" onchange="upload_image('home_img');">
								</a>
								<input type="hidden" name="home_img" id="hidhome_img" value="<?php echo ($home_img); ?>" datatype="*" nullmsg="请上传首屏图片">
								
								<?php if(!empty($home_img)): ?><img id = "home_img_view" src="<?php echo (get_cover($home_img,'path')); ?>"  alt="" style="width:200px;height:150px;" />
								<?php else: ?>
									<img id = "home_img_view" src=""  alt="" style="" /><?php endif; ?>
								大小不超过2M，建议尺寸：400*220px
							</span>
							<span class="ri">
							<a onmouseover="ddd('aa', 'show');" onmouseout="ddd('aa', 'hide');" class="wenhao"><img src="/Public/Home/images/addattchintro.jpg"></a> 
							<div class="intro" style="display:none;" id="aa"><em></em>在此处上传图片，支持格式png、jpeg、jpg，尺寸400*220px</div>
							</span>
						</li>
						<li class="addattach">
							<label><em>*</em>项目图片</label>
							<span class="fl">
								<a href="#">
									<img src="/Public/Home/images/btn_addattach.jpg" class="fl" width="72" height="64" style="margin-right:10px;">
									<input type="file" class="up_file" name="project_img" id="project_img" onchange="upload_image('project_img');">
								</a>
								<input type="hidden" name="pro_img" id="hidproject_img" value="<?php echo ($aProductInfo["pro_img"]); ?>" datatype="*" nullmsg="请上传项目图片">
								<?php if(!empty($aProductInfo["pro_img"])): ?><img id = "project_img_view" src="<?php echo (get_cover($aProductInfo["pro_img"],'path')); ?>"  alt="" style="width:200px;height:150px;" />
								<?php else: ?>
									<img id = "project_img_view" src=""  alt="" style="" /><?php endif; ?>
								大小不超过2M，建议尺寸：650*420px
							</span>
							<span class="ri">
							<a onmouseover="ddd('bb', 'show');" onmouseout="ddd('bb', 'hide');" class="wenhao"><img src="/Public/Home/images/addattchintro.jpg"></a> 
							<div class="intro" style="display:none;" id="bb"><em></em>在此处上传图片，支持格式png、jpeg、jpg，尺寸650*420px</div>
							</span>
						</li>
						<li class="addattach">
							<label><em>*</em>移动端图片</label>
							<span class="fl">
								<a href="#">
									<img src="/Public/Home/images/btn_addattach.jpg" class="fl" width="72" height="64"  style="margin-right:10px;">
									<input type="file" class="up_file" name="mobile_img" id="mobile_img" onchange="upload_image('mobile_img');">
								</a>
								<input type="hidden" name="mobile_img" id="hidmobile_img" value="<?php echo ($mobile_img); ?>" datatype="*" nullmsg="请上传移动端图片">
								<?php if(!empty($mobile_img)): ?><img id = "mobile_img_view" src="<?php echo (get_cover($mobile_img,'path')); ?>"  alt="" style="width:200px;height:150px;" />
								<?php else: ?>
									<img id = "mobile_img_view" src=""  alt="" style="" /><?php endif; ?>
								大小不超过2M，建议尺寸：600*288px
							</span>
							<span class="ri">
							<a onmouseover="ddd('cc', 'show');" onmouseout="ddd('cc', 'hide');" class="wenhao"><img src="/Public/Home/images/addattchintro.jpg"></a> 
							<div class="intro" style="display:none;" id="cc"><em></em>在此处上传图片，支持格式png、jpeg、jpg，尺寸600*288px</div>
							</span>
						</li>
						<li>
						  <label>视频介绍</label>
						  <input type="text" class="c1" id="videoAddr" name="videoAddr" placeholder="请填写视频的flash地址" value="<?php echo ($aProductInfo["video_path"]); ?>">
						  <span style="float: left;padding-left:120px;">flash地址以.swf结尾，如 http://player.youku.com/player.php/sid/XODM1NjI3MzEy/v.swf</span>
						</li>
						<li>
						  <label><em>*</em>项目介绍</label>
						  <textarea id="projectSummary" name="projectSummary" cols="" rows="" class="c2" datatype="*10-200" placeholder="请输入你的项目介绍（10-200个字）" nullmsg="项目介绍不能为空" errormsg="项目介绍10-200个字！"><?php echo ($describe); ?></textarea>
						</li>
						<li>
						  <table><tbody><tr>
							<td><label><em>*</em>项目详情</label></td>
							<td>
								<link href="/Public/static/umeditor/themes/default/css/umeditor.min.css" type="text/css" rel="stylesheet">
				                <!-- 配置文件 -->
				                <script type="text/javascript" src="/Public/static/umeditor/umeditor.config.js"></script>
				                <!-- 编辑器源码文件 -->
				                <script type="text/javascript" src="/Public/static/umeditor/umeditor.min.js"></script>
								<!-- 加载编辑器的容器 -->
								<txtarear id="datail" name="datail"><?php echo ($aProductInfo["content"]); ?></txtarear>
				            </td>
							</tr><tr></tr></tbody></table>
						</li>
						<li>
							<label>项目标签</label>
							<input type="text" class="c1 tagname" id="title sp" name="tag" maxlength="5" onblur="show1(this.value)" onfocus="show2()" value="请输入您的项目标签（最多5个）">
							<div style="clear:both"></div>
							<span class="sp" style="">
								<?php if(!empty($arry_tag)): if(is_array($arry_tag)): foreach($arry_tag as $key=>$vo): ?><a class="tag" name="<?php echo ($vo); ?>" href="javascript:void(0)" onclick="del(this)"><?php echo ($vo); ?><em>×</em></a>
											<input type="hidden" id="<?php echo ($vo); ?>" name="tags[]" value="<?php echo ($vo); ?>"><?php endforeach; endif; endif; ?>
							
							</span>
						</li>

				</div>

            </dd>
            </dl>
			<div class="common_button">
				<input type="submit" class="btn_red" value="下一步">
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

	<script type="text/javascript">
		<!-- 实例化编辑器 -->
	    var um = UM.getEditor('datail', {
			initialFrameWidth :660,
			initialFrameHeight :250,
		});
    
		//隐藏类型
		var type_Arr = new Array();
		//项目分类选择		
		$(document).ready(function() {
			$("#product_add").Validform({
					tiptype:3,
					btnSubmit:"#confirm",
					ajaxPost:true,
					beforeCheck:function(curform){
						//在验证成功后，表单提交前执行的函数，curform参数是当前表单对象。
						//这里明确return false的话表单将不会提交;	
						if($("#hidtype").val() ==''){
							$(".pjtype").removeClass('hidden');
							$("#title").focus();
							return false;
						}
					},
					callback:function(data){
						if (data.status == 1) {
							window.location.href = data.url;
							return false;
						}else{
							alert(data.info);
							return false;
						}
					}
				});
			
		
			$(".bq a").click(function() {
				var my = $(this);
				var type_id = my.attr('id');
				
				if (my.hasClass('cur')) {
					my.removeClass('cur');
					deltype(type_id);
				} else {
					var count = $(".bq a.cur").length;
					if (count >= 3) {
						alert("项目分类不能超过3个");
					} else {
						$(".pjtype").addClass('hidden');
						my.addClass('cur');
						type_Arr[type_Arr.length] = type_id;
						sethidtype();
					}
				}
				return false;
			});
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
		            	$(viewImg).attr('style', 'width:200px;height:150px;');
		          		$(hidfileName).val(data.id);
		            } else {
		                alert(data.info);
		            }
		          }
			});
		}
		
		//删除	
		function deltype(id)
		{
			var hidtype = $('#hidtype').val();
			
			if(type_Arr.length==0){
				if(hidtype !='')
				{ 
					hidtype = hidtype + "";
					result = hidtype.split(",");
					
					for(var i in result){
						type_Arr[i]=result[i];
					}
				}
			}
			
			for (var i in type_Arr){
				if(type_Arr[i]==id){
					type_Arr.splice(i,1);
				}
			}
			
			sethidtype();
		};
		
		//保存变化的值
		function sethidtype(){

			var media_id='';
			for(var i in type_Arr){
				media_id +=',' + type_Arr[i];
			}
			
			media_id=media_id.substring(1)?media_id.substring(1):''; 
			
			$('#hidtype').val(media_id);
		};

		//添加项目标签
		function show1(_tagname){
			if(_tagname ==""){
				$('.tagname').val('请输入您的项目标签（最多5个字）');
			}else{
				var count = $(".tag").length;
				
				alert(count);
				if(count>4){
					alert('最多只能添加五个标签');
				}else{
					var html='<a class="tag" href="javascript:void(0)" onclick="del(this)">'+_tagname+'<em>×</em></a>';
					
					html= html + '<input type="hidden" name="tags[]" value="'+_tagname+'">';
					
					$('.sp').append(html);
					$('.tagname').val('请输入您的项目标签（最多5个字）');	
				}
			}
		}

		//焦点进入
		function show2(){
			$('.tagname').val('');
		}

		//删除标签
		function del(_this){
			//删除隐藏控件
			$('#'+_this.name).remove();
			//删除
			_this.remove();
		}

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