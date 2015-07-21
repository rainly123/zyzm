var is_waiting = false;

$(function() {
	var loading;
	$(document).ajaxStart(function() {
			if (is_waiting) {loading = layer.open({type:2, anim:false, content:''});}   
		}).ajaxStop(function() {
			if(is_waiting){layer.close(loading);is_waiting=false;}
    });

    $(".btn_cancel").click(function() {
    	window.history.go(-1);
    	return false;
    });

    if ("undefined" == typeof titleInfo) {
    	$("#titleName").html("聚募众筹");
    } else {
    	$("#titleName").html(titleInfo);
    }
});

function showWaiting() {
	is_waiting = true;
	return true;
}