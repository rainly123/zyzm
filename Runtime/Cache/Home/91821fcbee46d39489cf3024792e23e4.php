<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>页面跳转中...</title>
</head>
<body>
	<div style="font-size:16px;margin:80px auto; width:300px;height:40px">
		<div style="background:url(/Public/Home/images/colorbox/loading.gif) no-repeat; line-height:30px;padding-left:40px">页面跳转中，请等待...</div>
		<div style="display:none">
			<?php echo ($message); ?>
		</div>
	</div>
</body>
</html>