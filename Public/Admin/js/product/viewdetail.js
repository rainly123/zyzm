$(document).ready(function(){
	// $.post($(this).data('url'),{focus:true},function(data){
	// 		// cosole.log(data);
	// 		layer.close(loading);
	// 	},'json');

	//关注
	$("#a_focus").click(function(){

		$.post($(this).data('url'),{focus:true},function(data){
			// cosole.log(data);
		},'json')
		.success(function(data){
			if (data.status) {
				var fouceAmount = 0;
				if (data.info <= 1000) {
					fouceAmount = '('+data.info+')';
				}else{
					fouceAmount = '(1千)';
				};
				alert('关注成功');
				$(".focusAmount").text(fouceAmount);
			}else{
				alert(data.info);
			};
		})
		.error(function(data){
			alert("网络连接出错");
		});
	});

	//send  message
	$(".send-message").colorbox();

	$('#myTab a').click(function (e) {
	  e.preventDefault();
	  $(this).tab('show');
	  $(this).parent('li').addClass('active');
	})
});