$(document).ready(function(){
	
	//表单验证
	$("#redound-edith").Validform(
			{
				tiptype:3,
				ajaxPost:true,
				btnSubmit:"#confirm",
				beforeSubmit:function(curform){
				
				},
				callback:function(data) {

						if (data.status) {
							alert('添加成功');
							window.location.reload();
						}else{
							alert(data.info);
							return false;
						};
				}
				});

	//删除 一条回报
	$(".delect-price").click(function(){
		if (!confirm("确定删除这条消息吗？")) {
			return false;
		};
		var delectUrl = $(this).data("href");
		$.post(delectUrl,function(data){
			if (data.status) {
				alert('删除成功');
				window.location.reload();
			}else{
				alert(data.info);
			};
		});
	});

	$("#addBack").click(function(){
		$(".w_adda").hide(function(){
			$(".w_addInfo").fadeIn();
		});
	});
	$("#cancle").click(function(){
		$(".w_addInfo").fadeOut(function(){
			$(".w_adda").show();
		});
	});
	
	//上传图片
	$(".fileupload").change(function() {
        var fileuploadUrl = $(this).data("fileurl");
        $.upload({
          url: fileuploadUrl, 
          fileName: 'upload',
          dataType: 'json',
          accept: '.jpg,.jpeg,.png,.gif',
          // 上传之前回调,return true表    示可继续上传
          onSend: function() {
              return true;
          },
          // 上传之后回调
          onComplate: function(data) {
            if(data.status == 1) {
                $(".redound img").attr('src', data.path);
                $(".redound input[type='hidden']").val(data.id);
            } else {
                alert(data.info);
            }
          }
        });
	});

	// // 编辑。。。。
	$(".revise-price").click(function(){
		$.get($(this).data('pricedata'),function(data){
			if (data.status) {
		
				var chioceType = '.borno[value='+data.info.price_type+']';
				$(chioceType).attr('checked','checked');
				$("#amount").attr('value',data.info.amount);
				$("#content").html(data.info.content);
				$("#upload").attr('datatype','');
				$("#image").attr('value',data.info.image);
				$("#redoundImage").attr('src',data.info.image_url);

				$("#count").attr('value',data.info.count);
				$("#post_amount").attr('value',data.info.post_amount);
				$("#afterday").attr('value',data.info.afterday);
				$("#price_id").attr('value',data.info.id);
			}else{
				alert(data.info);
				return false;
			};
		},'json');

		$(".w_adda").hide(function(){
			$(".w_addInfo").fadeIn();
		});
	});

	//点下一步 前查看是否有回报
	$(".ui-next-button").click(function(){
		var jumpUrl = $(this).data('href');
		$.get($(this).data("ispriceurl"),function(data){
			if (data.status == false) {
				alert('请填写至少一个回报');
				return false;
			}else{
				window.location.href=jumpUrl;
			};
		});
	});

	$("#Validform_msg").hide();
});