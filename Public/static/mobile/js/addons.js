/*www.qietu.com*/

$(function(){
	 var wechat_developer_reload = function(){
		$('body').append('<input type="button" value="refresh" onclick="window.location.reload();"/>');	 
	} 
	//wechat_developer_reload();
	
	 
	
	//滚动监听(对象,偏移,改变的样式,非活动时隐藏对象)
	$(window).bind("scroll",function(){ 

		var top=$(window).scrollTop();
		
		$('.list .item').each(function(){
			if ($(this).offset().top -top< $(window).height() - 200){
				$('.list .item').removeClass('selected');
				$(this).addClass('selected');
			};							   
		})
		
		
		
	}); 
	
	/*jd*/
	function n() {
		var t = $(".animateNum");
		var n = {
			top: $(window).scrollTop(),
			bottom: $(window).scrollTop() + $(window).height()
		};
		t.each(function() {
			var t = $(this).attr("data-animateTarget");
			n.top <= $(this).offset().top + $(this).height() && n.bottom >= $(this).offset().top && !$(this).data("start") && ($(this).data("start", !0), new AnimateNum({
				obj: $(this),
				target: t,
				totalTime: 1e3
			}))
		})
	}
	
	function b(){
		var t = $(".animateBar");
		var n = {
					top: $(window).scrollTop(),
					bottom: $(window).scrollTop() + $(window).height()
				};
	
		t.each(function() {
			
			var t = $(this).attr("data-animateTarget");
			n.top <= $(this).offset().top + $(this).height() && n.bottom >= $(this).offset().top && !$(this).data("start") && ($(this).data("start", !0), new AnimateBar({
				obj: $(this),
				target: t,
				totalTime: 1e3
			}))
		})	
	}
	
	
	
	/*n(),
	b(),*/
	$(window).bind("scroll",
	function() {
		n();
		b();
	})
		
	function AnimateNum(t) {
		this.obj = t.obj,
		this.target = t.target.toString(),
		this.totalTime = t.totalTime || 1e3,
		this.init()
	}
	
	function AnimateBar(t) {
		this.obj = t.obj,
		this.target = t.target.toString(),
		this.totalTime = t.totalTime || 1e3,
		this.init()
	}
	
	AnimateNum.prototype = {
		init: function() {
			return this.target ? (this.animation(), void 0) : !1
		},
		animation: function() {
			var t = this,
			i = this.target.indexOf("."),
			e = 0;
			i >= 0 && (e = this.target.length - i - 1);
			var n = this.target.replace(".", ""),
			s = this.totalTime / 30 | 0,
			a = n / s | 0,
			r = 0,
			h = 0;
			t.timer = setInterval(function() {
				r++,
				h += a,
				t.obj.html(h / Math.pow(10, e)),
				r >= s && (clearInterval(t.timer), t.obj.html(t.target))
			},
			30)
		}
	}
	
	AnimateBar.prototype = {
		init: function() {
			return this.target ? (this.animation(), void 0) : !1
		},
		animation: function() {
			var t = this,
			i = this.target.indexOf("."),
			e = 0;
			i >= 0 && (e = this.target.length - i - 1);
			var n = this.target.replace(".", ""),
			s = this.totalTime / 30 | 0,
			a = n / s | 0,
			r = 0,
			h = 0;
			t.timer = setInterval(function() {
				r++,
				h += a,
				t.obj.css('width',h / Math.pow(10, e) + '%'),
				r >= s && (clearInterval(t.timer), t.obj.animate({'width':t.target + '%'}))
			},
			30)
		}
	}
	
	$('.wrapper').css('minHeight',$(window).height());
	
	$('.menu').click(function(){
		if($('.wrapper').hasClass('pageOpen')){
			$('.aside, .main').animate({'left':'-=500'});
			$('.wrapper').removeClass('pageOpen');
		}
		else{
			$('.aside, .main').animate({'left':'+=500'});
			$('.wrapper').addClass('pageOpen');	
		}
	})
	
	$('.text input').focus(function(){
		$(this).parent().addClass('selected');								
	})
	$('.text input').blur(function(){
		$(this).parent().removeClass('selected');								
	})
	
	/*验证码*/
	$('#getcode').live('click',function(event){
		if($(this).hasClass('disabled')){
				return false;	
			}

		$('.login-form').find('.errorAnimate').removeClass('errorAnimate');
		$(".c_red").text('');
		//手机号
		var mobile = $('#mobile').val();
		if(mobile==''){
			$(".c_red").text('手机号不能为空');
			$("#mobile").parent().addClass('errorAnimate');
			$("#mobile").focus();
			errorAnimate();
			return false;
		}else{
			var re = /^1\d{10}$/;
			if (re.test(mobile))
			{
				$("#mobile").parent().removeClass('errorAnimate');
		    }else 
		    {
				$(".c_red").text('手机号格式不正确');
				$("#mobile").parent().addClass('errorAnimate');
				$("#mobile").focus();
				errorAnimate();
				return false;
			}
		}
		
		
		$.post($(this).attr('href'), {'phone':mobile}, function(data) {
		
			if (data.status == 1) {

				$('#getcode').addClass('disabled');
		
				 var ths = $('#getcode');
				 var val = ths.val();
			
				 var time = 60;
		
				 ths.val(time+ '秒后可重发');		 
			
				 _timeRun = setInterval(function(){
					if(time==1){
						ths.css('cursor','pointer');
						
						ths.val(val);	
						clearInterval(_timeRun);
						ths.removeClass('disabled');
					}
				
					if(time>1){
						time--;
						//console.log(time);
						ths.css('cursor','default');
						
						 //alert($(event.target)[0].tagName);
						ths.val(time+ '秒后可重发');	
					}
					
					
				},1000);
			} else {
				$(".c_red").text(data.info);

				//alert(data.info);
			}
		});
		

								
		
		return false;											
	})
	

	
	errorAnimate();
	
	/*星星，赞*/
	$('.digg').find('.star , .plus').click(function(){
		if($(this).hasClass('disabled')){
			return false;	
		}				
		else{
			$(this).addClass('disabled');	
			$(this).html(parseInt($(this).html())+1);
		}
	})
	
	
			
})

	/*错误抖动*/
	function errorAnimate(){
		var num = 0;
		timer = setInterval(function(){
			num++;
			if(num<5){
				
				$('.errorAnimate').animate({'left':-10},100,function(){
					$(this).animate({'left':10},100);												 
				});		
			}
			else{
				clearInterval(timer);
				$('.errorAnimate').stop().animate({'left':0},'fast');
			}
			//console.log(num);							 
		},200);	
	}
