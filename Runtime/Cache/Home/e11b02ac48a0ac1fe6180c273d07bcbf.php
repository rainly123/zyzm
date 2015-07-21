<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>领投说明</title>
<link href="/Public/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/Public/static/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/Public/Home/css/common.css" />
<link rel="stylesheet" type="text/css" href="/Public/Home/css/user.css" />
<link href="/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="/Public/static/bootstrap/js/html5shiv.js"></script>
<![endif]-->
<!--[if lt IE 9]>
<script type="text/javascript" src="/Public/static/jquery-1.10.2.min.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
<!--<![endif]-->
<script type="text/javascript" src="/Public/static/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/Public/static/layer/layer.min.js"></script>
<style>
	p{line-height: 25px; margin-bottom: 5px}
	.btn_red.btn-disable {background-color: #999;}
</style>
</head>
<body>
	<div class="container">
		<h2 class="text-center">领投说明</h2>
		<div style="position: relative;text-align:center">
			<div style="padding-bottom:20px;font-size:14px">
				<h3>关于领投</h3>
				<p>1.每个股权类众筹项目只有一个领投人。</p>
				<p>2.在中瀛智募网站上进行展示。</p>
				<p>2.领投人应积极参与项目的沟通，并协调跟投人和项目方的沟通。</p>
				<p>3.在投后管理中领投人需充当投资人和项目方的沟通桥梁。</p>
				<p>4.领投人作为投资人代表，需起到代表投资人发表意见、做好投后管理工作。</p>
			</div>
			<div style="font-size:16px">更多信息请点击 <a href="<?php echo U('Info/show?key=lead');?>" target="_blank">领投规则</a></div>
		</div>
		<hr>
		<?php if($isread != true): ?><div>
			<form action="<?php echo U('agree');?>" class="form-horizontal" method="post">
				<input type="hidden" name="id" value="<?php echo ($id); ?>">
				<p class="text-center"><a href="<?php echo U('Project/leader?id='.$id);?>" class="btn_red btn-agree" style="width:200px">继续</a></p>
			</form>
		</div><?php endif; ?>
	</div>
	<script>
	$('input[name="agree"]').change(function() {
		var count = $("input:checked").length;
		if (count <= 0 ) {
			$(".btn-agree").addClass('btn-disable');
			$(".btn-agree").attr('disabled', 'disabled');
		} else {
			$(".btn-agree").removeClass('btn-disable');
			$(".btn-agree").removeAttr('disabled');
		}
	});
	$("form").submit(function() {
		var count = $("input:checked").length;
		if (count <= 0) {
			layer.alert('您必须同意并接受投风险申明书', 1);
			return false;
		}
		var form = $(this);
		$.post(form.attr('action'), form.serialize(), function(data) {
			if (data.status == "1") {
				layer.alert(data.info, 9, function(){window.location.href = data.url;});
			} else {
				layer.alert(data.info, 1, function(){
					if (data.url != '') {
						window.location.href = data.url;
					}
				});
			}
		});
		return false;
	});
	</script>
</body>
</html>