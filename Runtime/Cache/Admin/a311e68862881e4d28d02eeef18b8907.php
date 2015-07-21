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
            

            
	<!-- 标题栏 -->
	<div class="main-title">
		<h2>股票项目</h2>
	</div>
		<div class="cf">
			<div class="fl">
          <a class="btn" href="<?php echo U('add');?>">新 增</a>
    	</div>
    </div>
	<!-- 数据列表 -->
	<div class="data-table">
	<div class="data-table table-striped">
<table class="">
    <thead>
    <tr>
		<th class="">编号</th>
		<th class="">项目名称</th>
		<th class="">创建时间</th>
		<th class="">净资产</th>
		<th class="">投资额</th>
		<th class="">份额</th>
		<th class="">净值</th>
		<th class="">操作</th>
		</tr>
    </thead>
    <tbody>
	<?php if(!empty($_list)): if(is_array($_list)): $i = 0; $__LIST__ = $_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
			<td><?php echo ($i); ?></td>
			<td><?php echo ($vo["name"]); ?></td>
			<td><span><?php echo (time_format($vo["create_time"],"Y-m-d")); ?></span></td>
			<td><?php echo ($vo["amount"]); ?> 元</td>
			<td><?php echo ($vo["fund"]); ?> 元</td>
			<td><?php echo ($vo["operation_fund"]); ?> 元</td>
			<td><?php echo (round($vo["assets"],2)); ?></td>
			<td>
				<a href="<?php echo U('Stock/edit?id='.$vo['id']);?>">编辑</a> |
				<?php if(($vo["status"]) == "0"): ?><a class="ajax-get confirm" href="<?php echo U('changestatus?status=1&id='.$vo['id']);?>">发布</a> |
				<?php else: ?>
					<a class="ajax-get confirm" href="<?php echo U('changestatus?status=0&id='.$vo['id']);?>">撤消</a> |<?php endif; ?>
				<a href="<?php echo U('investorlist?id='.$vo['id']);?>">投资人</a> |
				<?php if($vo["type"] == 1): ?><a href="<?php echo U('Sm/manage?id='.$vo['id']);?>" class="manage" alt="分派收益">收益</a> |
					<a href="<?php echo U('Sm/cash?id='.$vo['id']);?>" alt='提现用户列表'>提现用户</a>|
					<a href="<?php echo U('update?id='.$vo['id']);?>" class="ajax-get confirm" alt='排队资金归入总账'>合计</a> |
				 <?php elseif($vo["type"] == 2): ?>
				 	<a href="<?php echo U('Sm/cash?id='.$vo['id']);?>" alt='提现用户列表'>提现用户</a>|
				 	<a href="<?php echo U('Stock/plan?id='.$vo['id']);?>" alt='申购列表'>申购列表</a>
				<?php elseif($vo["type"] == 3): ?>
				 	<a href="<?php echo U('Sm/cash?id='.$vo['id']);?>" alt='提现用户列表'>提现用户</a>|
				 	<a href="<?php echo U('Stock/individuallist?id='.$vo['id']);?>" alt='申购列表'>购买列表</a>|
				 	
					<?php if(($vo["is_freeze"]) == "0"): ?><a href="<?php echo U('updatefreeze?status=0&id='.$vo['id']);?>" class="ajax-get confirm" alt='排队资金归入总账'>冻结</a> |
					<?php else: ?>
						<a class="ajax-get confirm" href="<?php echo U('updateunfreeze?status=0&id='.$vo['id']);?>">解冻</a> |<?php endif; ?>
				
				 <?php else: ?>
					<a href="<?php echo U('manage?id='.$vo['id']);?>" class="manage" alt="分派收益">收益</a> |
					<!-- <a href="<?php echo U('update?id='.$vo['id']);?>" class="ajax-get confirm" alt='排队资金归入总账'>合计</a> | -->
					<a href="<?php echo U('update_new?id='.$vo['id']);?>" class="manage" alt='排队资金归入总账'>合计</a> |
					<a href="<?php echo U('Sm/cash?type=0&id='.$vo['id']);?>" alt='提现用户列表'>提现用户</a> |<?php endif; ?>
				<a href="<?php echo U('Sm/cashlist?id='.$vo['id']);?>" alt='提现记录'>记录</a> 
				<?php if($vo["publish"] == 1): ?>|<a class="ajax-get confirm" href="<?php echo U('Stock/publish?id='.$vo['id']);?>" alt='确认公布'>公布</a><?php endif; ?>
			</td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		<?php else: ?>
		<td colspan="7" class="text-center"> aOh! 暂时还没有内容! </td><?php endif; ?>
	</tbody>
    </table>
        </div>
    </div>
    <div class="page">
        <?php echo ($_page); ?>
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
    
    <script src="/Public/static/thinkbox/jquery.thinkbox.js"></script>
<script src="/Public/Admin/js/jquery.colorbox-min.js"></script>
<link rel="stylesheet" href="/Public/Admin/css/colorbox.css">
<script type="text/javascript">
$(".manage").colorbox();
</script>

</body>
</html>