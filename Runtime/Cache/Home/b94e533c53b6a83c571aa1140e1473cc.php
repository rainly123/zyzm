<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no" >
<meta name="keywords" content="创业,投资,理财,众筹,融资" />  
<meta name="description" content="中瀛智募（上海）文化传媒有限公司（简称“中瀛智募”）由蔡远游先生于2014年6月创立于上海市（2015年5月更名），系以股权众筹方式筹建的有限责任 公司，是为创业者和天使投资人提供快速对接的众筹服务平台，是一家开放的、以发起和支持创业梦想为主的股权众筹服务平台，是以创业、投资、传播交互发展的 互联网社区。
在“大众创业、万众创新”的新时代，我决定采取众筹的手段，在上海筹建、成立一家以经营众筹网站、天使茶馆为主，以为创业青年找资金、为投资人找项目为主要运营目的的新型互联网企业，她的名字叫“中瀛智募”。
只要您认同中瀛智募的理念、规则，诚挚邀请你加入我们的行列，共同成为中瀛智募的众筹股东！
只要您与我们、与创业者拥有相同的理念和价值认同，只要您愿意支持青年的创业。诚挚邀请您成为中瀛智募平台众筹项目的天使投资人。"/>

<link rel="stylesheet" href="/Public/Mobile/css/css.css">
<link href="/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">

<!--[if lt IE 9]>
<script src="js/html5.js"></script>
<![endif]-->
<script type="text/javascript" src="/Public/Mobile/js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="/Public/Mobile/js/jquery.mobile-1.0.1.min.js"></script>
<!--<script type="text/javascript" src="/Public/Mobile/js/jquery.placeholder.js"></script>-->
<script type="text/javascript" src="/Public/Mobile/js/ios.js"></script>
<script type="text/javascript" src="/Public/Mobile/js/addons.js"></script>
<script type="text/javascript" src="/Public/Mobile/js/layer.m/layer.m.js"></script>
<script type="text/javascript" src="/Public/Mobile/js/common.js"></script>
<title><?php if(empty($pageTitle)): ?>中瀛智募<?php else: echo ($pageTitle); endif; ?></title>
<script>
	var _hmt = _hmt || [];
	(function() {
	  var hm = document.createElement("script");
	  hm.src = "//hm.baidu.com/hm.js?c18b08cac9b94bf4628c0277d3a4d7de";
	  var s = document.getElementsByTagName("script")[0]; 
	  s.parentNode.insertBefore(hm, s);
	})();
    // 计算 rem
    !function(){var a=document.documentElement;var b=a.clientWidth/16;a.style.fontSize=(b>40?40:b)+"px"}();
</script>

<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->
<?php echo hook('pageHeader');?>

</head>
<body>
	<!-- 头部 -->
	<div class="wrapper">
    <!-- 头部导航栏 -->
    <header>
        <h2>
            <?php if(empty($pageTitle)): ?><a href="#" class="brand"></a>
                <?php else: ?>
                <?php echo ($pageTitle); endif; ?>
        </h2>
        <?php if(empty($pageTitle)): ?><div class="lft">
                <a href="#left-menu" class="btn-left-menu"></a>
            </div>
            <?php else: ?>
            <div class="lft">
                <?php if(empty($backurl)): ?><a href="javascript:if (history.length===1){location.href='/'} else {window.history.back()}"
                       class="back"></a>
                    <?php else: ?>
                    <a href="<?php echo ($backurl); ?>" class="back"></a><?php endif; ?>
            </div><?php endif; ?>
        <div class="rgt">
            <a href="<?php echo U('MCenter/index');?>" class="user"></a>
        </div>
    </header>
	<!-- /头部 -->
	
	<!-- 主体 -->
	
	<link rel="stylesheet" href="/Public/Mobile/css/index.css">
	<link rel="stylesheet" href="/Public/Mobile/css/header.css">
	<link rel="stylesheet" href="/Public/Mobile/css/obj_project.css">




	<div class="wrapper">
		<div class="main">
		<form id="product_add"  method="Post" class="redound-edith" action="<?php echo U();?>">
			<div class="form_dd">
				<div class="form_dd1">
					<h1><?php echo ($productList["name"]); ?></h1>
					<h2>发起人：<?php echo (get_membername($productList["uid"])); ?></h2>
					<h3>支持金额: <b> ￥<?php echo ($productPriceList["amount"]); ?>元</b></h3>
					<h3>配送费用: 
                       <?php if($productPriceList["post_amount"] == 0): ?>包邮
                        <?php else: ?>
                            <?php echo ($productPriceList["post_amount"]); endif; ?>
               		</h3>
				</div>
				<div class="docast">
				    <div class="item">
				    	<div class="body">
				            <div class="addon">
								<div class="center">		
									<h3>购买数量</h3>
									<div id="d" class="Spinner">
										<a class="DisDe" href="javascript:void(0)" onclick="opera('count', false);"><i>-</i></a>
										<input class="Amount" id="count" name ="count" value="1" autocomplete="off" maxlength="5">
										<a class="Increase" href="javascript:void(0)" onclick="opera('count', true);"><i>+</i></a>
									</div>	
								</div>
				           	</div>
				        </div>
				    </div>
				</div>
			
			   	<div class="form_dd1">
					<h3><a href="<?php echo U('ProductOrder/addressList?pid='.$productPriceList['id']);?>">增加一个新地址</a></h3>
				</div>	
			<?php if(!empty($addressList)): if(is_array($addressList)): foreach($addressList as $key=>$vo): if(($vo["status"]) == "1"): ?><div class="form_dd1">
							<h4>收货人<a href="<?php echo U('ProductOrder/addressList?pid='.$productPriceList['id']);?>">修改</a></h4>
							<h3>用户名    <?php echo ($vo["name"]); ?></h3>
							<h5><?php echo getProvinceCity($vo['province'],$vo['city']); echo ($vo["address"]); ?></h5>
						</div>
						<input type="hidden" name="address_id" id="address_id" value="<?php echo ($vo["id"]); ?>"><?php endif; endforeach; endif; ?>
	    	<?php else: endif; ?>

                    
			
			<div class="form_dd1">
				<h4>回报详情<i><?php echo ($productPriceList['sell_count']); ?>人支持( <?php if($productPriceList[count] == 0): ?>不限
			                <?php else: ?>
			                	限购<?php echo ($productPriceList['count']); ?>人<?php endif; ?>)</i></h4>
				<h3>感谢您的支持！</h3>
				<h5><?php echo ($productPriceList["content"]); ?></h5>
				<h5><?php if($productPriceList["post_amount"] == 0): ?>包邮
                        <?php else: ?>
                            <?php echo ($productPriceList["post_amount"]); endif; ?></h5>
				<h5>预计发放时间：项目成功结束后<?php echo ($productPriceList["afterday"]); ?>天内</h5>
			</div>
			
			<div class="form_dd2">
				<h1>备注</h1>
				<div class="form_dd3">
            	<textarea name="remarks" id="remarks" cols="" rows=""></textarea>
				</div>
			</div>
<!-- 			<?php if($productPriceList["is_share"] == 3): ?><div class="form_dd1">
					<h1>验证码</h1>
					<div class="form_dd3">
	            	<input type="text" style=" width:98%; border:0px;" id="shareno" name="shareno" autocomplete="off">
	       
					</div>
				</div><?php endif; ?> -->
                
		</div>
       
        
		<div class="form_dd4">
			<input type="hidden" name="customid" id="customid" value="<?php echo ($customid); ?>">
			<input type="hidden" name="is_share" id="is_share" value="<?php echo ($productPriceList['is_share']); ?>">
			<a href="#" id="btn_next">立即支付</a>
		</div>
		</form>
		</div>
	</div>


	<!-- /主体 -->

	<!-- 底部 -->
	</div>
<!-- 底部================================================== -->

<script type="text/javascript" src="/Public/static/Validform_v5.3.2.js"></script>
	<script type="text/javascript" src="/Public/Home/js/jQselect.js"></script>
	<script src="/Public/static/layer/layer.min.js" type="text/javascript"></script>

	<script type="text/javascript">

		$("#addnew, .modify_addr").on('click', function() {
			  $("#dialog").html("");
			  $("#dialog").load($(this).attr('href'));
			  $.layer({type:1, title:false,area : ['553px','455px'], page:{dom:"#dialog"}, fadeIn:300});
			  return false;
		});
		
		$(".delete_addr").click(function() {
			  if (!confirm('您确定要删除该条记录吗？')) {return false;}
			  $.get($(this).attr('href'), function(data) {
			    if (data.status == 1) {
			      layer.alert(data.info, 1, function() {window.location.reload();});
			    } else {
			      layer.alert(data.info, 5);
			    }
			  });
			  return false;
		});

		$(".adresslist li").click(function() {
			$(".adresslist li").removeClass('cur');
			
			$(this).addClass('cur');
			$('#address_id').val($(this).attr("id"));
			
		});
	
		//下一步
		$("#btn_next").click(function(){
			var address_id = $('#address_id').val();
			var count = $('#count').val();
			var remarks = $('#remarks').val();
			var is_share = $('#is_share').val();
			var shareno ='';
			var customid ='';
		
			if (isNaN(count) || count==0) {
				alert('请填写购买数量，数量需要大于零。');
				return false;
			};
			
			if(address_id==''){
				alert('请添加一个收货地址');
				return false;
			}
			
/* 			if(is_share=='3'){
				if($('#shareno').val()==''){
					alert('请输入验证码');
					return false;
				}else{
					shareno = $('#shareno').val();
				}
			} */
			if(is_share=='3'){
				if($('#customid').val()==''){
					alert('参数不对');
					return false;
				}else{
					customid = $('#customid').val();
				}
			}
				
	        $.ajax({
	             type: "post",
	             dataType: "json",
	             data: {address_id:address_id, count:count,remarks:remarks,is_share:is_share,customid:customid},
	             success: function(data){
	 				if (data.status == "1") {
						window.location.href = data.url;	
						return false;
					}else{
						alert(data.info);
						return false;
					};
	        	}
	         });
		});
		
		function opera(x, y) {
			var rs = new Number(document.getElementById(x).value);
			var r   = /^\+?[1-9][0-9]*$/;　　//正整数   
  
			if(!r.test(rs)){  
				alert('请输入整数');
				document.getElementById(x).focus();
				return false;
			}	
					
			if (y) {
				document.getElementById(x).value = rs + 1;
			} else {
				if(rs<2){
					alert('购买数量必须大于1');
					document.getElementById(x).focus();
					return false;
				}
				
				document.getElementById(x).value = rs - 1;
			}
		}
		
	</script>
 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden" style="display:none;"><!-- 用于加载统计代码等隐藏元素 -->

</div>

	<!-- /底部 -->
</body>
</html>