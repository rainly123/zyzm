var is_waiting = false;

$(function() {
	var loading;
	$(document).ajaxStart(function() {
			if (is_waiting) {loading = layer.load('正在处理中，请稍候...');}   
		}).ajaxStop(function() {
			if(is_waiting){layer.close(loading);is_waiting=false;}
    });
});
function showWaiting() {is_waiting = true;}