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
    
<link rel="stylesheet" href="/Public/static/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/project/preview.css">

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
            

            
<div class="xmsteps" style="background:none">
    <div class="content">
        <div class="nav-steps clearfix" >
            <ul>
                <li class="<?php $_GET['step']==1?print 'active':''; ?>"><a href="<?php echo U('Project/preview?id=' . $_GET['id'].'&step=1');?>">基本信息</a></li>
                <li class="<?php $_GET['step']==2?print 'active':''; ?>"><a href="<?php echo U('Project/preview?id=' . $_GET['id'].'&step=2');?>">项目介绍</a></li>
                <li class="<?php $_GET['step']==3?print 'active':''; ?>"><a href="<?php echo U('Project/preview?id=' . $_GET['id'].'&step=3');?>">团队介绍</a></li>
                <li class="<?php $_GET['step']==4?print 'active':''; ?>"><a href="<?php echo U('Project/preview?id=' . $_GET['id'].'&step=4');?>">项目资料</a></li>
                <li class="<?php $_GET['step']==5?print 'active':''; ?>"><a href="<?php echo U('Project/preview?id=' . $_GET['id'].'&step=5');?>">融资信息</a></li>
            </ul>
        </div>
    </div>
</div>
	<div class="main bg-white">
		<div class="content clearfix">
			<div class="pull-left">
			<div class="form-horizontal">
				<div class="under-line">
				<div class="control-group">
					<label for="" class="control-label">项目名称</label>
					<div class="controls">
						<?php echo ($project_name); ?>						
					</div>
				</div>
				<div class="control-group">
					<label for="" class="control-label">联系电话</label>
					<div class="controls">
						<?php echo ($link_man); ?>						
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">项目类型</label>
					<div class="controls">
						<?php if($type == 0): ?>股权投资
						<?php else: ?>
							兴趣合营<?php endif; ?>	
					</div>
				</div>
				<div class="control-group">
					<label for="" class="control-label">所属行业</label>
					<div class="controls">
						<?php echo ($industry); ?>
					</div>
				</div>
				<div class="control-group">
					<label for="" class="control-label">项目描述</label>
					<div class="controls">
						<?php echo ($abstract); ?>
					</div>
				</div>
				<div class="control-group">
					<label for="" class="control-label">查看权限</label>
					<div class="controls">
						<?php if($open_flag == 1): ?>所有投资人
						<?php else: ?>
							审核通过的投资人<?php endif; ?>	
					</div>
				</div>
				<div class="control-group">
					<label for="" class="control-label">项目图片</label>
					<div class="controls">
						<div style="display:inline;border:1px solid #eee;">
							<img src="<?php echo (get_cover($cover,'path')); ?>" alt="" style="width:300px">
						</div>
					</div>
				</div>
				<div class="control-group">
					<label for="" class="control-label">所处阶段</label>
					<div class="controls">
						<?php echo ($project_phase); ?>
					</div>
				</div>
				<div class="control-group">
					<label for="" class="control-label">团队人数</label>
					<div class="controls">
						<?php echo ($member_count); ?>
					</div>
				</div>
				<div class="control-group">
					<label for="" class="control-label">所在城市</label>
					<div class="controls">
						<?php echo getProvinceCity($province,$city);?>
					</div>
				</div>
				<div class="control-group">
					<label for="" class="control-label">公司地址</label>
					<div class="controls">
						<?php echo ($address); ?>
					</div>
				</div>
				<div class="control-group">
					<label for="" class="control-label">项目网址</label>
					<div class="controls">
						<?php echo ($project_url); ?>
					</div>
				</div>
				</div> <!-- under-line end -->
				</div>
			</div>

		</div>
	</div>
<?php
 $prePageNum = $_GET['step'] -1; $nextPageNum = $_GET['step'] +1; ?>
<div style="display:block">
    <?php if($_GET['step'] == 1): ?><a type="button" href="#" class="btn btn-primary pre-page disabled">上一页</a>
	<?php else: ?>
	    <a type="button" href="<?php echo U('Project/preview?id=' . $_GET['id'].'&step='.$prePageNum);?>" class="btn btn-primary pre-page">上一页</a><?php endif; ?>

    <?php if($_GET['step'] == 5): ?><a type="button" href="#" class="btn btn-primary next-page disabled">下一页</a>
	    <?php else: ?>
	    <a type="button" href="<?php echo U('Project/preview?id=' . $_GET['id'].'&step='.$nextPageNum);?>" class="btn btn-primary next-page">下一页</a><?php endif; ?>
    <div style="clear:both"></div>
</div>


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
    
<script>
	highlight_subnav('<?php echo U('Project/index');?>');
</script>

</body>
</html>