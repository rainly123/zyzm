<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo ($project_name); ?>-<?php echo ($data["title"]); ?></title>
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
		<h2 class="text-center"><u><?php echo ($project_name); ?></u><?php echo ($data["title"]); ?></h2>
		<div style="position: relative;">
			<div style="padding-bottom:40px;font-size:14px"><?php echo ($data["content"]); ?></div>
			<div style="position:absolute; left:80px; bottom:10px;width:150px">
				<img src="<?php echo (get_cover($data["seal"],'path')); ?>" alt="">
			</div>
		</div>
		<?php if(empty($review1)): ?><hr>
		<div>
			<form action="<?php echo U('agree');?>" class="form-horizontal" method="post">
				<input type="hidden" name="iid" value="<?php echo ($id); ?>">
				<div class="control-group">
					<div class="text-center">
						<label style="line-height:30px;display:inline"><input type="checkbox" name="agree" value="1"> &nbsp;本人已认真阅读并充分理解<a href="<?php echo U('Info/show?key=agreement');?>" target="_blank">《注册服务协议》</a>和<a href="<?php echo U('Info/show?key=shenmingshu');?>" target="_blank">《投资风险申明书》</a>的条款与内容，<br>本人确认具有识别及承担相关风险的能力。</label>
					</div>
				</div>
				<p class="text-center"><button disabled class="btn_red btn-disable btn-agree" style="width:200px">确定</button></p>
			</form>
		</div><?php endif; ?>
	</div>
	<script>

    $(function(){
        var result=<?php echo ($result); ?>;
        if(result==true)
        {
            $('input[name="agree"]').hide();
            $(".btn-agree").hide();
        }


    })

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