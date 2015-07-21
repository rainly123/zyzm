<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ($meta_title); ?>|OneThink管理平台</title>
    <link href="/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
    
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/module.css">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="/Public/Admin/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">
     <!--[if lt IE 9]>
    <script type="text/javascript" src="/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/jquery.mousewheel.js"></script>
    <!--<![endif]-->
    
</head>
<body>
    <!-- 头部 -->
    <div class="header">
        <!-- Logo -->
        <span class="logo"></span>
        <!-- /Logo -->

        <!-- 主导航 -->
        <ul class="main-nav">
            <?php if(is_array($__MENU__["main"])): $i = 0; $__LIST__ = $__MENU__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li class="<?php echo ((isset($menu["class"]) && ($menu["class"] !== ""))?($menu["class"]):''); ?>"><a href="<?php echo (u($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <!-- /主导航 -->

        <!-- 用户栏 -->
        <div class="user-bar">
            <a href="javascript:;" class="user-entrance"><i class="icon-user"></i></a>
            <ul class="nav-list user-menu hidden">
                <li class="manager">你好，<em title="<?php echo session('user_auth.username');?>"><?php echo session('user_auth.username');?></em></li>
                <li><a href="<?php echo U('User/updatePassword');?>">修改密码</a></li>
                <li><a href="<?php echo U('User/updateNickname');?>">修改昵称</a></li>
                <li><a href="<?php echo U('Public/logout');?>">退出</a></li>
            </ul>
        </div>
    </div>
    <!-- /头部 -->

    <!-- 边栏 -->
    <div class="sidebar">
        <!-- 子导航 -->
        
            <div id="subnav" class="subnav">
                <?php if(!empty($_extra_menu)): ?>
                    <?php echo extra_menu($_extra_menu,$__MENU__); endif; ?>
                <?php if(is_array($__MENU__["child"])): $i = 0; $__LIST__ = $__MENU__["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i;?><!-- 子导航 -->
                    <?php if(!empty($sub_menu)): if(!empty($key)): ?><h3><i class="icon icon-unfold"></i><?php echo ($key); ?></h3><?php endif; ?>
                        <ul class="side-sub-menu">
                            <?php if(is_array($sub_menu)): $i = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li>
                                    <a class="item" href="<?php echo (u($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul><?php endif; ?>
                    <!-- /子导航 --><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        
        <!-- /子导航 -->
    </div>
    <!-- /边栏 -->

    <!-- 内容区 -->
    <div id="main-content">
        <div id="top-alert" class="fixed alert alert-error" style="display: none;">
            <button class="close fixed" style="margin-top: 4px;">&times;</button>
            <div class="alert-content">这是内容</div>
        </div>
        <div id="main" class="main">
            
            <!-- nav -->
            <?php if(!empty($_show_nav)): ?><div class="breadcrumb">
                <span>您的位置:</span>
                <?php $i = '1'; ?>
                <?php if(is_array($_nav)): foreach($_nav as $k=>$v): if($i == count($_nav)): ?><span><?php echo ($v); ?></span>
                    <?php else: ?>
                    <span><a href="<?php echo ($k); ?>"><?php echo ($v); ?></a>&gt;</span><?php endif; ?>
                    <?php $i = $i+1; endforeach; endif; ?>
            </div><?php endif; ?>
            <!-- nav -->
            

            
    <script type="text/javascript" src="/Public/static/uploadify/jquery.uploadify.min.js"></script>

	<div class="main-title">
		<h2>
			<?php echo ($info['id']?'编辑':'新增'); ?>导航
			<?php if(!empty($pid)): ?>[&nbsp;父导航：<a href="<?php echo U('index','pid='.$pid);?>"><?php echo ($parent["title"]); ?></a>&nbsp;]<?php endif; ?>
		</h2>
	</div>
	<form action="<?php echo U();?>" method="post" class="form-horizontal">
		<input type="hidden" name="pid" value="<?php echo ($pid); ?>">
		<div class="form-item">
			<label class="item-label">名称<span class="check-tips">（用于显示的文字）</span></label>
			<div class="controls">
				<input type="text" class="text input-large" name="name" value="<?php echo ((isset($info["name"]) && ($info["name"] !== ""))?($info["name"]):''); ?>">
			</div>
		</div>
		<div class="form-item">
			<label class="item-label">链接<span class="check-tips">（只能填http://开头的链接，填之前需要确保链接有效）</span></label>
			<div class="controls">
				<input type="text" class="text input-large" name="extra" value="<?php echo ((isset($info["extra"]) && ($info["extra"] !== ""))?($info["extra"]):''); ?>">
			</div>
		</div>
		<div class="form-item">
			<label class="item-label">备注<span class="check-tips"></span></label>
			<div class="controls">
				<input type="text" class="text input-large" name="remark" value="<?php echo ((isset($info["remark"]) && ($info["remark"] !== ""))?($info["remark"]):''); ?>">
			</div>
		</div>
		<div class="form-item">
			<label class="item-label">图片<span class="check-tips"></span></label>
		<div class="controls">
                <input type="file" id="upload_picture_logo">
                <input type="hidden" name="img_id" id="cover_id_logo" value="<?php echo ($info["img_id"]); ?>"/>
                <div class="upload-img-box">
                <?php if(!empty($info['img_id'])): ?><div class="upload-pre-item"><img src="<?php echo (get_cover($info['img_id'],'path')); ?>"/></div><?php endif; ?>
                </div>
            </div>
            <script type="text/javascript">
            //上传图片
            /* 初始化上传插件 */
            $("#upload_picture_logo").uploadify({
                "height"          : 30,
                "swf"             : "/Public/static/uploadify/uploadify.swf",
                "fileObjName"     : "download",
                "buttonText"      : "上传图片",
                "uploader"        : "<?php echo U('File/uploadPicture',array('session_id'=>session_id()));?>",
                "width"           : 120,
                'removeTimeout'   : 1,
                'fileTypeExts'    : '*.jpg; *.png; *.gif;',
                "onUploadSuccess" : uploadPicture,
                'onFallback' : function() {
                    alert('未检测到兼容版本的Flash.');
                }
            });
            function uploadPicture(file, data){
                var data = $.parseJSON(data);
                var src = '';
                if(data.status){
                    $("#cover_id_logo").val(data.id);
                    src = data.url || '' + data.path
                    $("#cover_id_logo").parent().find('.upload-img-box').html(
                        '<div class="upload-pre-item"><img src="' + src + '"/></div>'
                    );
                } else {
                    updateAlert(data.info);
                    setTimeout(function(){
                        $('#top-alert').find('button').click();
                        $(that).removeClass('disabled').prop('disabled',false);
                    },1500);
                }
            }
            </script>
		</div> <!-- form-item end -->

		<div class="form-item">
			<label class="item-label">手机图片<span class="check-tips"></span></label>
			<div class="controls">
                <input type="file" id="upload_mobile_logo">
                <input type="hidden" name="mobiel_img_id" id="mobiel_img_id" value="<?php echo ($info["mobiel_img_id"]); ?>"/>
                <div class="upload-img-box">
                <?php if(!empty($info['mobiel_img_id'])): ?><div class="upload-pre-item"><img src="<?php echo (get_cover($info['mobiel_img_id'],'path')); ?>"/></div><?php endif; ?>
                </div>
            </div>
            <script type="text/javascript">
            //上传图片
            /* 初始化上传插件 */
            $("#upload_mobile_logo").uploadify({
                "height"          : 30,
                "swf"             : "/Public/static/uploadify/uploadify.swf",
                "fileObjName"     : "download",
                "buttonText"      : "上传图片",
                "uploader"        : "<?php echo U('File/uploadPicture',array('session_id'=>session_id()));?>",
                "width"           : 120,
                'removeTimeout'   : 1,
                'fileTypeExts'    : '*.jpg; *.png; *.gif;',
                "onUploadSuccess" : uploadPicture,
                'onFallback' : function() {
                    alert('未检测到兼容版本的Flash.');
                }
            });
            function uploadPicture(file, data){
                var data = $.parseJSON(data);
                var src = '';
                if(data.status){
                    $("#mobiel_img_id").val(data.id);
                    src = data.url || '' + data.path
                    $("#mobiel_img_id").parent().find('.upload-img-box').html(
                        '<div class="upload-pre-item"><img src="' + src + '"/></div>'
                    );
                } else {
                    updateAlert(data.info);
                    setTimeout(function(){
                        $('#top-alert').find('button').click();
                        $(that).removeClass('disabled').prop('disabled',false);
                    },1500);
                }
            }
            </script>
		</div> <!-- form-item end -->
		
		<div class="form-item">
			<label class="item-label">优先级<span class="check-tips"></span></label>
			<div class="controls">
				<input type="text" class="text input-small" name="sort" value="<?php echo ((isset($info["sort"]) && ($info["sort"] !== ""))?($info["sort"]):'0'); ?>">
			</div>
		</div>
		<div class="form-item">
			<input type="hidden" name="id" value="<?php echo ((isset($info["id"]) && ($info["id"] !== ""))?($info["id"]):''); ?>">
			<button class="btn submit-btn ajax-post" id="submit" type="submit" target-form="form-horizontal">确 定</button>
			<button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
		</div>
	</form>

        </div>
        <div class="cont-ft">
            <div class="copyright">
                <div class="fl">感谢使用<a href="http://www.onethink.cn" target="_blank">OneThink</a>管理平台</div>
                <div class="fr">V<?php echo (ONETHINK_VERSION); ?></div>
            </div>
        </div>
    </div>
    <!-- /内容区 -->
    <script type="text/javascript">
    (function(){
        var ThinkPHP = window.Think = {
            "ROOT"   : "", //当前网站地址
            "APP"    : "/admin.php?s=", //当前项目地址
            "PUBLIC" : "/Public", //项目公共目录地址
            "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
            "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
            "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
        }
    })();
    </script>
    <script type="text/javascript" src="/Public/static/think.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/common.js"></script>
    <script type="text/javascript">
        +function(){
            var $window = $(window), $subnav = $("#subnav"), url;
            $window.resize(function(){
                $("#main").css("min-height", $window.height() - 130);
            }).resize();

            /* 左边菜单高亮 */
            url = window.location.pathname + window.location.search;
            url = url.replace(/(\/(p)\/\d+)|(&p=\d+)|(\/(id)\/\d+)|(&id=\d+)|(\/(group)\/\d+)|(&group=\d+)/, "");
            $subnav.find("a[href='" + url + "']").parent().addClass("current");

            /* 左边菜单显示收起 */
            $("#subnav").on("click", "h3", function(){
                var $this = $(this);
                $this.find(".icon").toggleClass("icon-fold");
                $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
                      prev("h3").find("i").addClass("icon-fold").end().end().hide();
            });

            $("#subnav h3 a").click(function(e){e.stopPropagation()});

            /* 头部管理员菜单 */
            $(".user-bar").mouseenter(function(){
                var userMenu = $(this).children(".user-menu ");
                userMenu.removeClass("hidden");
                clearTimeout(userMenu.data("timeout"));
            }).mouseleave(function(){
                var userMenu = $(this).children(".user-menu");
                userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
                userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));
            });

	        /* 表单获取焦点变色 */
	        $("form").on("focus", "input", function(){
		        $(this).addClass('focus');
	        }).on("blur","input",function(){
				        $(this).removeClass('focus');
			        });
		    $("form").on("focus", "textarea", function(){
			    $(this).closest('label').addClass('focus');
		    }).on("blur","textarea",function(){
			    $(this).closest('label').removeClass('focus');
		    });

            // 导航栏超出窗口高度后的模拟滚动条
            var sHeight = $(".sidebar").height();
            var subHeight  = $(".subnav").height();
            var diff = subHeight - sHeight; //250
            var sub = $(".subnav");
            if(diff > 0){
                $(window).mousewheel(function(event, delta){
                    if(delta>0){
                        if(parseInt(sub.css('marginTop'))>-10){
                            sub.css('marginTop','0px');
                        }else{
                            sub.css('marginTop','+='+10);
                        }
                    }else{
                        if(parseInt(sub.css('marginTop'))<'-'+(diff-10)){
                            sub.css('marginTop','-'+(diff-10));
                        }else{
                            sub.css('marginTop','-='+10);
                        }
                    }
                });
            }
        }();
    </script>
    

<script type="text/javascript" src="/Public/static/Validform_v5.3.2.js"></script>
<script type="text/javascript" charset="utf-8">
	//导航高亮
	highlight_subnav('<?php echo U('Banner/edit');?>');
		highlight_subnav('<?php echo U('banner/add');?>');

	$("a:contains(Banner管理)").parent("li").addClass("current");
</script>

</body>
</html>