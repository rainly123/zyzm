$(document).ready(function(){
	$("#frm").Validform({tiptype:3});

	
	//post 数据
/*	$(".button-submit").click(function(){
		var formData = $(".holder-edith").serialize();
		//添加pid
		// formData = formData+'&pid='+;
		$.post($(this).data('urlaction'),formData,function(data){
			
		})
		.success(function(data){
			if (data.status) {
				window.location.href = data.url;
			}else{
				alert(data.info);
			};
		})
		.error(function(data){
			alert("网络连接问题");
		});
	});*/
});