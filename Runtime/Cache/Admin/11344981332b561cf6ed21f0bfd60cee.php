<?php if (!defined('THINK_PATH')) exit();?><style>
	.leader{margin:20px 40px;}
	.pj-title{font-size:20px; margin-bottom: 20px}
	.pj-title span{font-weight: bold; color:#666;}
	.leader input[type='text'] {padding: 5px;margin-left: 10px; width: 200px}
	.leader .btn-parent {margin: 30px 70px;}
</style>
<div class="leader">
	<p class="pj-title">项目名称：<span><?php echo ($project["project_name"]); ?></span></p>
	<form action="<?php echo U();?>" method="post">
		<input type="hidden" name="id" value="<?php echo ($project["id"]); ?>">
		<div>领投人昵称：<input type="text" name="username" maxlength="20"></div>
		<div class="btn-parent"><input type="submit" value="确定" class="btn" id="leader-conform"></div>
	</form>
</div>
<script>
	$("#leader-conform").click(function() {
		var form = $(this).parents('form');
		$.post(form.attr('action'), form.serialize(), function(data) {
			alert(data.info);
			if (data.status == 1) {
				$.colorbox.close();
				window.location.reload();
			}
		});
		return false;
	});
</script>