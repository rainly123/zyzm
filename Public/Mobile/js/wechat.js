$(function(){
	 var wechat_developer_reload = function(){
		$('body').append('<input type="button" value="refresh" onclick="window.location.reload();"/>');	 
	} 
	wechat_developer_reload();
	
	
	var is_wechat = function(){
		var ua = navigator.userAgent.toLowerCase();
		if(ua.match(/MicroMessenger/i)=="micromessenger") {
			//alert(1);
			//return true;
	 
			if($('meta[name=viewport]').size()>0){
				$('meta[name=viewport]').attr('content','width=320');
			}
			else{
					//add a new meta node of viewport in head node
				head = document.getElementsByTagName('head');
				viewport = document.createElement('meta');
				viewport.name = 'viewport';
				viewport.content = 'width=320';  
				head.length > 0 && head[head.length - 1].appendChild(viewport);    
			}
			//w = $(window).width();
			$('.container').css({'zoom':320/640, '-moz-transform':'scale(0.5)', '-moz-transform-origin':'top left'}).fadeIn();  
	
	 	} else {
	 	
		}
	} 
	is_wechat();

 
})