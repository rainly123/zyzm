<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,user-scalable=no,maximum-scale=1,initial-scale=1">
    <title>中瀛智募 - 个人中心</title>
    <link href="/Public/Mobile/css/login.css" rel="stylesheet" type="text/css">
    <link href="/Public/Mobile/css/css.css" rel="stylesheet" type="text/css">
    <link href="/Public/Mobile/css/header.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#f3f3f3">
<div class="wrapper">
    <div class="user_yhzx">
        <div class="user_yhzx1">
            <h1><a href="<?php echo U('/');?>"></a></h1>
            <h2><a href="<?php echo U('Message/index');?>"></a></h2>
            <?php if(!empty($hasnew)): ?><h3></h3><?php endif; ?>
        </div>

        <div class="user_yhzx2">
            <div class="avatar-box">
                <a href="<?php echo U('User/changePhoto');?>">
                    <img class="avatar-img" src="<?php echo get_memberface();?>" height="80" width="80">
                    <div class="avatar-mask"></div>
                </a>
            </div>

            <h2><?php echo ($user["nickname"]); ?></h2>
            <a href="<?php echo U('User/detail');?>">
                <button class="btn-user-info">个人资料</button>
            </a>
        </div>

        <!-- <div class="user_yhzx3">
           <a href="#">认证投资人</a>
        </div>	 -->
    </div>
    <div class="user_yhzx4">
        <ul>
            <!-- <li><a class="user_physical_aa">您已支持：<b>45353</b>元 </a></li> -->
            <li><a href="<?php echo U('MCenter/pj_support');?>">您已拥有：<b><?php echo ($pj_count); ?></b>家公司股权 </a></li>
            <li><a href="<?php echo U('MCenter/pr_support');?>">您已支持：<b><?php echo ($pr_count); ?></b>产品梦想 </a></li>
        </ul>
    </div>
    <div class="user_bj">
        <ul>
            <li class="tbl-cell" style="position: relative;">
                <a href="<?php echo U('MCenter/pj_support');?>">
                    <h1><img src="/Public/Mobile/images/ico1.png"></h1>
                    <?php if($dolist["pj_qty"] > 0): ?><span class="dolist"><?php echo ($dolist['pj_qty']); ?></span><?php endif; ?>
                    <span>股权</span>
                </a>
            </li>

            <li class="tbl-cell" style="position: relative;">
                <a href="<?php echo U('MCenter/pr_support');?>">
                    <h1><img src="/Public/Mobile/images/ico2.png"></h1>
                    <?php if($dolist["pr_qty"] > 0): ?><span class="dolist"><?php echo ($dolist['pr_qty']); ?></span><?php endif; ?>
                    <span>实物</span>
                </a>
            </li>

            <li class="tbl-cell bfzs">
                <a href="<?php echo U('Account/index');?>" class="tal_user">
                    <h1><img src="/Public/Mobile/images/ico3.png"></h1>
                    <span>钱包</span>
                </a>
            </li>
        </ul>


        <ul>
            <li class="tbl-cell">
                <a href="<?php echo U('MCenter/stock');?>">
                    <h1><img src="/Public/Mobile/images/ico4.png"></h1>
                    <span>基金</span>
                </a>
            </li>

            <li class="tbl-cell">
                <a href="<?php echo U('User/savecenter');?>">
                    <h1><img src="/Public/Mobile/images/ico5.png"></h1>
                    <span>安全</span>
                </a>
            </li>

            <li class="tbl-cell bfzs">
                <a href="<?php echo U('User/logout');?>">
                    <h1><img src="/Public/Mobile/images/ico_out.png"></h1>
                    <span>退出</span>
                </a>
            </li>


        </ul>
    </div>
</div>
<script type="text/javascript" src="/Public/Mobile/js/jquery-1.7.2.js"></script>
<script>
    setTimeout(function () {
        $('.avatar-mask').addClass('hidden');
    }, 0);
</script>
</body>
</html>