function ddd(obj, sType) { 
var oDiv = document.getElementById(obj); 
if (sType == 'show') { oDiv.style.display = 'block';} 
if (sType == 'hide') { oDiv.style.display = 'none';} 
} 
function setTab(name,cursel,n)
{
	for(i=1;i<=n;i++){
		var menu=document.getElementById(name+i);
		var con=document.getElementById("con_"+name+"_"+i);
		menu.className=i==cursel?"cur":"";
		con.style.display=i==cursel?"block":"none";
	}
}

	
	
$(function() {
	jQuery('#tjxm').bxCarousel({
    display_num: 3,
    move: 1,
    margin: 20
  });

	$('#container').highcharts({
		chart: {
			polar: true,
			type: 'line'
		},
		colors: ['#7cb5ec', '#f7a35c', '#8085e9',
			'#f15c80', '#e4d354', '#8085e8', '#8d4653', '#91e8e1'],
		plotOptions: {
			area: {
				fillOpacity: 0.3
			}
		},
		credits: {enabled:false},
		exporting: {enabled:false},
		title: {text: '', x: -80},
		pane: {size: '80%'},
		xAxis: {
			categories: ['团队', '市场', '竞争', '盈利','创意'],
			tickmarkPlacement: 'on',
			lineWidth: 0
		},
		yAxis: {
			max:100,
			gridLineInterpolation: 'polygon',
			lineWidth: 0,
			min: 0
		},
		series: [{
			type: 'area',
			name: '综合评分',
			data: averageScore,
			pointPlacement: 'on'
		}, {
			name: '用户评分',
			data: myScore,
			pointPlacement: 'on'
		}]
	});
});

(function($){$.fn.bxCarousel=function(options){var defaults={move:3,display_num:3,speed:300,margin:0,auto:false,auto_interval:2000,auto_dir:'next',auto_hover:false,next_text:'下一个',next_image:'',prev_text:'上一个',prev_image:'',controls:true};var options=$.extend(defaults,options);return this.each(function(){var $this=$(this);var li=$this.find('li');var first=0;var fe=0;var last=options.display_num-1;var le=options.display_num-1;var is_working=false;var j='';var clicked=false;li.css({'float':'left','listStyle':'none','marginRight':options.margin});var ow=li.outerWidth(true);wrap_width=(ow*options.display_num)-options.margin;var seg=ow*options.move;$this.wrap('<div class="bx_container"></div>').width(999999);if(options.controls){if(options.next_image!=''||options.prev_image!=''){var controls='<a href="/" class="prev"><img src="'+options.prev_image+'"/></a><a href="/" class="next"><img src="'+options.next_image+'"/></a>';}
else{var controls='<a href="/" class="prev">'+options.prev_text+'</a><a href="/" class="next">'+options.next_text+'</a>';}}
$this.parent('.bx_container').wrap('<div class="bx_wrap"></div>').css({'position':'relative','width':630,'overflow':'hidden'}).before(controls);var w=li.slice(0,options.display_num).clone();var last_appended=(options.display_num+options.move)-1;$this.empty().append(w);get_p();get_a();$this.css({'position':'relative','left':-198});$this.parent().siblings('.next').click(function(){slide_next();clearInterval(j);clicked=true;return false;});$this.parent().siblings('.prev').click(function(){slide_prev();clearInterval(j);clicked=true;return false;});if(options.auto){start_slide();if(options.auto_hover&&clicked!=true){$this.find('li').live('mouseenter',function(){if(!clicked){clearInterval(j);}});$this.find('li').live('mouseleave',function(){if(!clicked){start_slide();}});}}
function start_slide(){if(options.auto_dir=='next'){j=setInterval(function(){slide_next()},options.auto_interval);}else{j=setInterval(function(){slide_prev()},options.auto_interval);}}
function slide_next(){if(!is_working){is_working=true;set_pos('next');$this.animate({left:'-='+198},options.speed,function(){$this.find('li').slice(0,options.move).remove();$this.css('left',-198);get_a();is_working=false;});}}
function slide_prev(){if(!is_working){is_working=true;set_pos('prev');$this.animate({left:'+='+198},options.speed,function(){$this.find('li').slice(-options.move).remove();$this.css('left',-198);get_p();is_working=false;});}}
function get_a(){var str=new Array();var lix=li.clone();le=last;for(i=0;i<options.move;i++){le++
if(lix[le]!=undefined){str[i]=$(lix[le]);}else{le=0;str[i]=$(lix[le]);}}
$.each(str,function(index){$this.append(str[index][0]);});}
function get_p(){var str=new Array();var lix=li.clone();fe=first;for(i=0;i<options.move;i++){fe--
if(lix[fe]!=undefined){str[i]=$(lix[fe]);}else{fe=li.length-1;str[i]=$(lix[fe]);}}
$.each(str,function(index){$this.prepend(str[index][0]);});}
function set_pos(dir){if(dir=='next'){first+=options.move;if(first>=li.length){first=first%li.length;}
last+=options.move;if(last>=li.length){last=last%li.length;}}else if(dir=='prev'){first-=options.move;if(first<0){first=li.length+first;}
last-=options.move;if(last<0){last=li.length+last;}}}});}})(jQuery);