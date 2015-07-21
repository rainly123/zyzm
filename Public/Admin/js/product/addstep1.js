$(document).ready(function(){
	$("#frm").Validform({
		tiptype:3,
		datatype:{
			// "mmoney":/[0-9]*[.]{0,1}[0-9]{0,2}/,
			"mmoney":/[0-9]$/,
		},
	});

	//根据reviseStatus  切换input file的验证规则
	// var reviseStatus = $("#current-status").data('revisestatus');
	// if (reviseStatus== true) {
	// 	$(".fileupload").attr('datatype','');
	// };
	// $(".fileupload").change(function(){
	// 	$(this).attr('datatype','*');
	// });

	
});