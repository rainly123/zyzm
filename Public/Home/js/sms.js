
var wait = "请等待$time秒";
var time;
$(document).ready(function() {
	$('.getsmscode').click(function() {
		if (time > 0) {return false;}
		var my = $(this);
		$.post($(this).attr('href'), {'phone':$('#phoneNo').val(), 'ischeck':1}, function(data) {
			if (data.status == 1) {
				$("#errormessage").hide();
        $("#errormessage").html();
				time = 120;
				settime(my);
			} else {
				$("#errormessage").show();
        $("#errormessage").html(data.info);
			}
		}, 'json');
		
		return false;
	});
});

function settime(my) {
	time -= 1;

	if (time > 0) {
		var info = wait.replace('$time',time);
		my.html(info);
		setTimeout(function() {settime(my)},1000);
	} else {
		my.html('发送验证码');
	}
}