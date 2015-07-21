<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="keywords" content="创业,投资,理财,众筹,融资"/>
    <meta name="description" content="中瀛智募（上海）文化传媒有限公司（简称“中瀛智募”）由蔡远游先生于2014年6月创立于上海市（2015年5月更名），系以股权众筹方式筹建的有限责任 公司，是为创业者和天使投资人提供快速对接的众筹服务平台，是一家开放的、以发起和支持创业梦想为主的股权众筹服务平台，是以创业、投资、传播交互发展的 互联网社区。
在“大众创业、万众创新”的新时代，我决定采取众筹的手段，在上海筹建、成立一家以经营众筹网站、天使茶馆为主，以为创业青年找资金、为投资人找项目为主要运营目的的新型互联网企业，她的名字叫“中瀛智募”。
只要您认同中瀛智募的理念、规则，诚挚邀请你加入我们的行列，共同成为中瀛智募的众筹股东！
只要您与我们、与创业者拥有相同的理念和价值认同，只要您愿意支持青年的创业。诚挚邀请您成为中瀛智募平台众筹项目的天使投资人。"/>
    <title><?php echo ($pageTitle); ?></title>
    <link rel="stylesheet" href="/Public/Mobile/css/dm.css">
</head>
<body class="grey">
<div id="server-data" style="display: none;">
    <input type="hidden" name="about" value="<?php echo ($about); ?>">
</div>
<script>
    var serverData = {};
    var inputs = document.querySelector('#server-data').children;
    Array.prototype.slice.call(inputs).forEach(function (input, idx) {
        serverData[input.name] = input.value;
    });
</script>
<header class="top-header">
    <a href="javascript:if (history.length===1){location.href='/'} else {window.history.back()}" class="back"></a>
    <a class="user" href="<?php echo U('/MCenter/');?>"></a>
    <div class="title"><?php echo ($pageTitle); ?></div>
</header>
<?php if(empty($about)): ?><ul class="item-list fz-18">
        <li><a href="<?php echo U('info/show?key=about');?>">认识中瀛智募相关</a></li>
        <li><a href="<?php echo U('info/show?key=joinus');?>">加入我们</a></li>
        <!-- <li><a href="<?php echo U('info/show?key=contactus');?>">联系我们</a></li> -->
    </ul>
    <?php elseif($about == zc): ?>
    <ul class="item-list fz-18">
        <li><a href="<?php echo U('info/show?key=xinshouzhiyin');?>">新手指引</a></li>
        <li><a href="<?php echo U('info/show?key=process');?>">投资流程</a></li>
        <li><a href="<?php echo U('info/show?key=agreement');?>">注册服务协议</a></li>
        <li><a href="<?php echo U('info/show?key=shiwuzhongchou');?>">实物众筹项目发起人协议</a></li>
        <li><a href="<?php echo U('info/show?key=shengmingshu');?>">投资风险协议书</a></li>
        <li><a href="<?php echo U('info/show?key=invest');?>">询价认投规则</a></li>
        <li><a href="<?php echo U('info/show?key=lead');?>">领投规则</a></li>
        <li><a href="<?php echo U('info/show?key=follow');?>">跟投规则</a></li>
        <li><a href="<?php echo U('info/show?key=after');?>">投后管理规则</a></li>
        <li><a href="<?php echo U('info/show?key=fenpei');?>">投资利益分配规则</a></li>
    </ul><?php endif; ?>

<div class="c-c tac fze-8 mt-10 mb-10">
    Copyright (c) 2014 杭州募聚网络科技有限公司
</div>
</body>
</html>