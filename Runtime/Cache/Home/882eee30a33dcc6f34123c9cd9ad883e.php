<?php if (!defined('THINK_PATH')) exit();?><!-- span2 -->
<select class="data_sf" name="province" id="J_province" nullmsg="请选择所在省" datatype="*"></select>
<select class="data_sf" name="city" id="J_city" style="display:none;" nullmsg="请选择所在市" datatype="*"></select>
<!-- <select name="district" id="J_district" style="display:none;"></select>
<select name="community" id="J_community" style="display:none;"></select> -->
<script type="text/javascript">
$(function(){
	
	var pid=<?php if($param["province"] != ''): echo ($param["province"]); else: ?>0<?php endif; ?>;  //默认省份id
	var cid=<?php if($param["city"] != ''): echo ($param["city"]); else: ?>0<?php endif; ?>;  //默认城市id
	//var did=<?php if($param["district"] != ''): echo ($param["district"]); else: ?>0<?php endif; ?>;  //默认区县市id
	//var coid=<?php if($param["community"] != ''): echo ($param["community"]); else: ?>0<?php endif; ?>;  //默认乡镇id

	
	$.post("<?php echo addons_url('ChinaCity://ChinaCity/getProvince');?>", {pid: pid}, function(result){
		$("#J_province").html(result);
	});

	$.post('<?php echo addons_url("ChinaCity://ChinaCity/getCity");?>', {pid: pid, cid: cid}, function(result){
		$("#J_city").show().html(result);
	});

	// $.post('<?php echo addons_url("ChinaCity://ChinaCity/getDistrict");?>', {cid: cid, did: did}, function(result){
	// 	if (cid == 0) {return true;}
	// 	$("#J_district").show().html(result);
	// });

	// $.post('<?php echo addons_url("ChinaCity://ChinaCity/getCommunity");?>', {did: did, coid: coid}, function(result){
	// 	if (coid == 0) {return true;}
	// 	$("#J_community").show().html(result);
	// });

	$('#J_province').change(function(){
		var pid_g=$(this).children('option:selected').val();
		$.post('<?php echo addons_url("ChinaCity://ChinaCity/getCity");?>', {pid: pid_g}, function(result){
			$("#J_city").show().html(result);
		});
	});
	
	// $('#J_city').change(function(){
	// 	var cid_g=$(this).children('option:selected').val();
	// 	$.post('<?php echo addons_url("ChinaCity://ChinaCity/getDistrict");?>', {cid: cid_g}, function(result){
	// 		$("#J_district").show().html(result);
	// 	});
	// });

	// $('#J_district').change(function(){
	// 	var did_g=$(this).children('option:selected').val();
	// 	$.post('<?php echo addons_url("ChinaCity://ChinaCity/getCommunity");?>', {did: did_g}, function(result){
	// 		$("#J_community").show().html(result);
	// 	});
	// });
	
});
</script>