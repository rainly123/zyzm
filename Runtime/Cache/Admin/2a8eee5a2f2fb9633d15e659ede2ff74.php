<?php if (!defined('THINK_PATH')) exit();?><style>
	.pay-info {font-size: 16px; margin: 20px 40px;}
	.pay-info table tr {line-height: 35px;}
</style>
<div class="pay-info">
	<form action="<?php echo U('Manage/payinfo');?>" method="post">
		<input type="hidden" name="id" value="<?php echo ($data["id"]); ?>">
		<table>
			<tr><td>真实姓名：</td><td><?php echo ($data["name"]); ?></td></tr>
			<tr><td>投资金额：</td><td><?php echo ($data["fund"]); ?></td></tr>
			<tr><td>到账金额：</td><td><input type="text" name="amount" value="<?php echo ($data["amount"]); ?>"></td></tr>
			<tr><td colspan="2" style="height:10px"></td></tr>
			<tr><td><button type="submit" class="btn" id="pay-confirm">确定</button></td></tr>
		</table>
	</form>
</div>
<script>
	$("#pay-confirm").click(function() {
		var form = $(this).parents('form');
		$.post(form.attr('action'), form.serialize(), function(data) {
			if (data.status == '1') {
				alert(data.info);
				window.location.reload();
			} 
		});
		return false;
	});
</script>