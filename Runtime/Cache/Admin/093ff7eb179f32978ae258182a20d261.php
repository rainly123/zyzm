<?php if (!defined('THINK_PATH')) exit();?><style>
	.pay-info {font-size: 16px; margin: 20px 40px;}
	.pay-info table tr {line-height: 35px;}
	.pay-info input {padding:5px; }
</style>
<div class="pay-info">
	<form action="<?php echo U('Manage/cancel_pay');?>" method="post">
		<input type="hidden" name="id" value="<?php echo ($data["id"]); ?>">
		<table>
			<tr><td>真实姓名：</td><td><?php echo ($data["name"]); ?></td></tr>
			<tr><td>返回到状态</td><td>
				<select name="status">
					<option value="">请选择...</option>
					<option value="4">重新确认协议</option>
					<option value="8">未支付</option>
					<option value="-1">撤消投资</option>
				</select>
			</td></tr>
			<tr><td>撤消原因</td><td><input type="text" name="remarks" value="" style="width:300px"></td></tr>
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
			} else {
				alert(data.info);
			}
		});
		return false;
	});
</script>