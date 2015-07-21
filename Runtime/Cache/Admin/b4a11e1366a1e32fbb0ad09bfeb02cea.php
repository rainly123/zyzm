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
		<div>所属机构：
			<select name="oid" id="J_group">
	     		<option value="0">请选择项目阶段</option>
				<?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
		</div>
		<br/>
		<div>项目经理：
			<select name="mid" id="J_manager">
	     		<option value="0">请选择项目经理</option>
			</select>
		</div>		
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

	$('#J_group').change(function(){
		var pid_g=$(this).children('option:selected').val();
		$.post('<?php echo U("getManagerList");?>', {pid: pid_g}, function(result){
			$("#J_manager").html(result);
		});
	});
	
	
	
</script>