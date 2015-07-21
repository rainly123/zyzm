<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no" >
<meta name="keywords" content="创业,投资,理财,众筹,融资" />  
<meta name="description" content="中瀛智募（上海）文化传媒有限公司（简称“中瀛智募”）由蔡远游先生于2014年6月创立于上海市（2015年5月更名），系以股权众筹方式筹建的有限责任 公司，是为创业者和天使投资人提供快速对接的众筹服务平台，是一家开放的、以发起和支持创业梦想为主的股权众筹服务平台，是以创业、投资、传播交互发展的 互联网社区。
在“大众创业、万众创新”的新时代，我决定采取众筹的手段，在上海筹建、成立一家以经营众筹网站、天使茶馆为主，以为创业青年找资金、为投资人找项目为主要运营目的的新型互联网企业，她的名字叫“中瀛智募”。
只要您认同中瀛智募的理念、规则，诚挚邀请你加入我们的行列，共同成为中瀛智募的众筹股东！
只要您与我们、与创业者拥有相同的理念和价值认同，只要您愿意支持青年的创业。诚挚邀请您成为中瀛智募平台众筹项目的天使投资人。"/>

<link rel="stylesheet" href="/Public/Mobile/css/css.css">
<link href="/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">

    <link href="/Public/Mobile/css/project.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="js/html5.js"></script>
<![endif]-->
<script type="text/javascript" src="/Public/Mobile/js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="/Public/Mobile/js/jquery.mobile-1.0.1.min.js"></script>
<!--<script type="text/javascript" src="/Public/Mobile/js/jquery.placeholder.js"></script>-->
<script type="text/javascript" src="/Public/Mobile/js/ios.js"></script>
<script type="text/javascript" src="/Public/Mobile/js/addons.js"></script>
<script type="text/javascript" src="/Public/Mobile/js/layer.m/layer.m.js"></script>
<script type="text/javascript" src="/Public/Mobile/js/common.js"></script>
<title><?php if(empty($pageTitle)): ?>中瀛智募<?php else: echo ($pageTitle); endif; ?></title>
<script>
	var _hmt = _hmt || [];
	(function() {
	  var hm = document.createElement("script");
	  hm.src = "//hm.baidu.com/hm.js?c18b08cac9b94bf4628c0277d3a4d7de";
	  var s = document.getElementsByTagName("script")[0]; 
	  s.parentNode.insertBefore(hm, s);
	})();
    // 计算 rem
    !function(){var a=document.documentElement;var b=a.clientWidth/16;a.style.fontSize=(b>40?40:b)+"px"}();
</script>

<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->
<?php echo hook('pageHeader');?>

</head>
<body>
	<!-- 头部 -->
	<div class="wrapper">
    <!-- 头部导航栏 -->
    <header>
        <h2>
            <?php if(empty($pageTitle)): ?><a href="#" class="brand"></a>
                <?php else: ?>
                <?php echo ($pageTitle); endif; ?>
        </h2>
        <?php if(empty($pageTitle)): ?><div class="lft">
                <a href="#left-menu" class="btn-left-menu"></a>
            </div>
            <?php else: ?>
            <div class="lft">
                <?php if(empty($backurl)): ?><a href="javascript:if (history.length===1){location.href='/'} else {window.history.back()}"
                       class="back"></a>
                    <?php else: ?>
                    <a href="<?php echo ($backurl); ?>" class="back"></a><?php endif; ?>
            </div><?php endif; ?>
        <div class="rgt">
            <a href="<?php echo U('MCenter/index');?>" class="user"></a>
        </div>
    </header>
	<!-- /头部 -->
	
	<!-- 主体 -->
	



    <div id="server-data" style="display: none;">
        <input type="hidden" name="projectId" value="<?php echo ($project['id']); ?>">
        <input type="hidden" name="favAPI" value="<?php echo U('project/attach');?>">
    </div>
    <script>
        var serverData = {};
        var inputs = document.querySelector('#server-data').children;
        Array.prototype.slice.call(inputs).forEach(function (input, idx) {
            serverData[input.name] = input.value;
        });
    </script>

    <div class="wrapper" style="padding-bottom:60px;">
        <div class="dbanner">
            <!--  <div class="share"><a href="#"></a></div>-->
            <div class="digg">
                <b class="if if-p--1 icon-star fav"><?php echo ($project["attach_count"]); ?></b>
                <b class="if if-p--1 icon-comment"><?php echo ($project["com_count"]); ?></b>
                <b class="if if-p--1 icon-eye"><?php echo ($project["read_record"]); ?></b>
            </div>
            <div class="bg"><img src="<?php echo (get_cover($project["cover"],'path')); ?>"/></div>
        </div>
        <div class="detail">
            <div class="item">
                <div class="head">
                    <h2> <?php echo ($project["project_name"]); ?></h2>
                    <a href="<?php echo U('project/mobiledynamic/pid/'.$project['id']);?>" class="df">动态</a>
                </div>
                <div class="body">
                    <?php echo ($project["abstract"]); ?>
                    <div class="tag">
                        <span><?php echo getDistrict($project['province']);?></span>
                        <span><?php echo getDistrict($project['city']);?></span>
                    </div>
                    <div class="info">
                        <div class="nums">
                            <div class="num">
                                <ul>
                                    <li>
                                        <h3><big><?php echo (change_fund($project["fund"]["need_fund"])); ?></big></h3>
                                        <h4>目标额</h4>
                                    </li>
                                    <li>
                                        <h3><big><?php echo (change_fund($project["fund"]["follow_fund"])); ?></big>元</h3>
                                        <h4>起投额</h4>
                                    </li>
                                    <li>
                                        <h3><big class="animateNum"
                                                 data-animatetarget="<?php echo ($project["fund"]["has_fund/$project"]["fund"]["need_fund"]); ?>">
                                            <?php if(($project["stage"]) == "1"): ?>0
                                                <?php else: ?>
                                                <?php echo (change_fund($project["fund"]["has_fund"])); endif; ?>
                                        </big>
                                        </h3>
                                        <h4>认投额</h4>
                                    </li>
                                </ul>
                            </div>
                            <?php if($project['stage'] >= 4): ?><div class="tips">
                                    <dl>
                                        <dt><img src="/Public/Mobile/images/img47.png"/></dt>
                                        <dd>出让股权比例：<?php echo round($project['fund']['need_fund'] / $project['fund']['final_valuation'] * 100,2);;?>%
                                        </dd>

                                    </dl>
                                    <dl>
                                        <dt><img src="/Public/Mobile/images/img48.png"/></dt>
                                        <dd>项目估值：<?php echo (change_fund($project["fund"]["final_valuation"])); ?></dd>
                                    </dl>
                                </div><?php endif; ?>
                        </div>
                        <div class="circle-progress">
                            <?php if(($project["stage"]) == "1"): ?><input type="hidden" id="finish_progress"
                                       value="0">
                                <?php else: ?>
                                <input type="hidden" id="finish_progress"
                                       value="<?php echo round($project['fund']['has_fund'] / $project['fund']['need_fund'] * 100);;?>"><?php endif; ?>
                            <div id="circle-progress" class="percent">
                                <p><span>0</span>%</p>
                            </div>
                            <svg viewBox="0,0,70,70">
                                <circle class="circle-bg" cx="35" cy="35" r="29"></circle>
                                <circle class="circle-animate" cx="35" cy="35" r="29"></circle>
                            </svg>
                        </div>
                        <script src="/Public/Mobile/js/circle.js"></script>
                        <!--<div class="canvas">
                            <canvas id="myCanvas" width="100" height="100"></canvas>
                        </div>-->

                    </div>
                </div>
            </div>
            <div class="nav">
                <ul>
                    <!-- <li class="lft">
                        <a href="#"><span class="dp">我的梦想</span></a>
                    </li> -->
                    <li class="rgt" style="width:99%">
                        <a href="<?php echo U('Project/intro?id='. $project['id']);?>">
                            <i class="icon dtl"></i>
                            <span class="zz">查看项目详情</span>
                            <i class="icon rit"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="item">
                <div class="head">
                    <h2 class="pf">项目评分</h2>
                    <a href="<?php echo U('ProjectScores/index?id='. $project['id']);?>" class="df">打分</a>
                </div>
                <div class="body propf">
                    <div class="canvas">
                        <div id="canvas" height="260px" width="260px"></div>
                    </div>

                </div>
            </div>
            <div class="peoples">
                <ul>
                    <li>
                        <a href="<?php echo U('MCenter/profile?id='. $project['uid']);?>">
                            <div class="img">
                                <img src="<?php echo (get_memberface($project["uid"])); ?>">
                            </div>
                            <h2><?php echo (get_membername($project["uid"])); ?></h2>
                            <span>发起人</span>
                        </a>
                    </li>
                    <?php if(($project["vote_leader"]) == "2"): ?><li>
                            <a href="<?php echo U('MCenter/profile?id='. $project['leader']['leader_id']);?>">
                                <div class="img">
                                    <img src="<?php echo (get_memberface($project['leader']['leader_id'])); ?>">
                                </div>
                                <h2><?php echo (get_membername($project['leader']['leader_id'])); ?></h2>
                                <span>领投人</span>
                            </a>


                        </li><?php endif; ?>

                </ul>
            </div>
            <div class="results">
                <div class="text">
                    <big><?php echo ($project['investor_count']); ?></big>
                    人参与投资
                </div>
                <div class="imgs">
                    <ul>

                        <?php if(is_array($project["investors"])): foreach($project["investors"] as $key=>$investor): ?><li>
                                <a href="<?php echo U('MCenter/profile?id='. $investor['investor_id']);?>"> <img
                                        src="<?php echo (get_memberface($investor['investor_id'])); ?>"></a>
                            </li><?php endforeach; endif; ?>

                    </ul>
                    <a href="<?php echo U('Project/mbMoreInvestors?pid='. $project['id']);?>" class="more"></a>
                </div>
            </div>
            <div class="item">
                <div class="head">
                    <h2 class="hb"><i id="giftIcon">&nbsp;</i>股东回报</h2>
                    <em></em></div>
                <div class="body">
                    <?php echo ($project["fund"]["extra"]); ?>
                </div>
            </div>
            <div class="item">
                <div class="head">
                    <h2 class="qun">项目讨论群(按二维码添加)</h2>
                    <em></em></div>
                <div class="body">
                    <div class="qrcode">
                        <img src="<?php echo ($project["barcode"]); ?>">
                    </div>
                </div>
            </div>

            <div class="item">
                <div class="body">
                    <div class="attitudes-wrapper">
                        <div class="smile-bar">
                            <button id="btn-pos" class="btn btn-pos"></button>
                            <div class="bar">
                                <div class="score-bar"></div>
                                <div class="ball-wrapper">
                                    <div class="ball"></div>
                                </div>
                            </div>
                            <button id="btn-neg" class="btn btn-neg"></button>
                        </div>

                        <div class="score"><span id="pos-count">0</span>:<span id="neg-count">0</span></div>

                        <div class="label-bar">
                            <label class="label" for="btn-pos">支持</label>

                            <div class="count">已有<span id="attitude-count">6</span>位用户参与</div>
                            <label class="label" for="btn-neg">反对</label>
                        </div>

                        <div class="plus-wrapper">
                            <div class="plus plus-positive">+1</div>
                            <div class="placeholder"></div>
                            <div class="plus plus-negative">+1</div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="item">
                <div class="head">
                    <h2 class="pl">项目评论</h2>
                    <em></em></div>
                <div class="body">
                    <div class="comments">
                        <ul>
                            <?php if(is_array($project["comments"])): foreach($project["comments"] as $key=>$v): ?><li id="comment<?php echo ($v['id']); ?>">
                                    <div class="img">
                                        <a href="<?php echo U('MCenter/profile?id='. $v['comment_user']);?>"><img
                                                src="<?php echo (get_memberface($v['comment_user'])); ?>"></a>
                                    </div>
                                    <div class="text">
                                        <div class="addpost"><a class="btn-slide"
                                                                href="<?php echo U('project/makereply',array('project_id'=>$v['project_id'],'reply_id'=>$v['id']));?>">回复</a>
                                        </div>
                                        <h2 class="comment-user-name"><?php echo (get_membername($v['comment_user'])); ?></h2>

                                        <?php if(!empty($v["parent"])): if(is_array($v["parent"])): $i = 0; $__LIST__ = $v["parent"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="pllist clearfix reply">
                                                    <?php echo (get_membername($vo["comment_user"])); ?>说：<?php echo ($vo["content"]); ?>
                                                </div><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                                        <p><?php echo ($v["content"]); ?></p>
                                    </div>
                                    <div class="c-c"><input type="hidden" class="comment_id"
                                                            value="<?php echo ($v["id"]); ?>"><textarea maxlength="140"></textarea><br>
                                        <button class="btn-c-c">回复</button>
                                    </div>
                                </li><?php endforeach; endif; ?>

                        </ul>
                        <div class="more">
                            <a href="<?php echo U('project/morecomment/pid/'.$project['id']);?>">查看更多评论</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="head">
                    <h2 class="tj">推荐项目</h2>
                    <em></em></div>
                <div class="body">
                    <ul class="pros">
                        <?php if(is_array($recomendList['project'])): foreach($recomendList['project'] as $key=>$v): ?><li>
                                <a href="<?php echo U('project/detail?id='.$v['id']);?>" title="中瀛智募">
                                    <div class="img">
                                        <img src="<?php echo (get_cover($v['cover'],'path')); ?>">
                                    </div>
                                    <h2><?php echo ($v["project_name"]); ?></h2>
                                </a>
                            </li><?php endforeach; endif; ?>
                        <?php if(is_array($recomendList['product'])): foreach($recomendList['product'] as $key=>$v): ?><li>
                                <a href="<?php echo U('product/viewdetail/pid/'.$v['id']);?>" title="中瀛智募">
                                    <img class="img" src="<?php echo (get_cover($v['home_img'],'path')); ?>">

                                    <h2><?php echo ($v["name"]); ?></h2>
                                </a>
                            </li><?php endforeach; endif; ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <div class="fixed-footer-proj">
        <a class="lnk lnk-index if icon-home-o" href="<?php echo U('/');?>">首页</a>
        <a class="lnk lnk-comment if icon-comment-o" href="<?php echo U('project/postcomment/pid/'.$project['id']);?>">评论</a>
        <?php if(($project['stage'] == 1) AND ($project['vote_leader'] == 0)): ?><a class="btn btn-find-leader if icon-leader"
               href="<?php echo U('project/leader_info?id='.$project['id']);?>">领投人虚位以待</a>
            <?php else: ?>
            <a class="btn btn-follow if icon-coin-stack" id="btn-follow"
               href="<?php echo U('project/follow?id='.$project['id']);?>">我要跟投</a><?php endif; ?>
    </div>
    <div id="average-score-values" style="display: none;">
        <?php echo ($project["averageScores"]["group"]); ?>,<?php echo ($project["averageScores"]["market"]); ?>,<?php echo ($project["averageScores"]["creative"]); ?>,<?php echo ($project["averageScores"]["profitablity"]); ?>,<?php echo ($project["averageScores"]["evaluation"]); ?>
    </div>
    <div id="my-score-values" style="display: none;">
        <?php echo ($userScores["group"]); ?>,<?php echo ($userScores["market"]); ?>,<?php echo ($userScores["creative"]); ?>,<?php echo ($userScores["profitablity"]); ?>,<?php echo ($userScores["evaluation"]); ?>
    </div>
    <script src="/Public/Mobile/js/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="/Public/Mobile/js/highcharts.js"></script>
    <script type="text/javascript" src="/Public/Mobile/js/exporting.js"></script>
    <script type="text/javascript" src="/Public/Mobile/js/highcharts-more.js"></script>
    <script>
        var projectId = location.href.match(/id\/(\d+)\.html/);
        projectId = parseInt(projectId && projectId[1]) || 0;
        var config = {
            projectCommentAPI: '/project/comment/',
            positiveAPI: '/attitude/positive',
            negativeAPI: '/attitude/negative',
            getAttitudesCountAPI: '/attitude/getNumberOfAttitudes'
        };
        var averageScore = [],
                myScore = [];
        $.each($.trim($('#average-score-values').text()).split(','), function (i, v) {
            averageScore.push(parseInt(v))
        });
        $.each($.trim($('#my-score-values').text()).split(','), function (i, v) {
            myScore.push(parseInt(v))
        });

        // 支持反对
        var getAttitudeCount = function () {
            $.getJSON(config.getAttitudesCountAPI, {pid: projectId}).then(function (json) {
                if (json.success) {
                    updateAttitudeCount(json.info);
                }
            });
        };
        var updateAttitudeCount = function (json) {
            var negCount = parseInt(json.negative),
                    posCount = parseInt(json.positive),
                    attitudeCount = negCount + posCount;
            $('#pos-count').text(posCount);
            $('#neg-count').text(negCount);
            $('#attitude-count').text(attitudeCount);
            var percent = posCount / attitudeCount * 100;
            if (attitudeCount === 0) {
                percent = 50;
            }
            $('.score-bar').css('width', percent + '%');
            $('.ball').css('left', percent + '%');
        };
        getAttitudeCount();
        var changeVoteStatus = function () {
            localStorage.setItem('attitudeToProj' + projectId, true);
            $('.attitudes-wrapper .btn').addClass('disabled').unbind().click(function () {
                return false;
            });
        };
        var showPlusAnimation = function (isPositive) {
            $('.plus-wrapper').addClass('show');
            var $elm = null;
            if (isPositive) {
                $elm = $('.plus-positive');
            } else {
                $elm = $('.plus-negative');
            }
            $elm.addClass('show').width();
            $elm.addClass('go');
        };
        !function () {
            var voted = localStorage.getItem('attitudeToProj' + projectId);
            if (voted) {
                $('.attitudes-wrapper .btn').addClass('disabled').click(function () {
                    return false;
                });
            } else {
                $('#btn-pos').click(function () {
                    $.post(config.positiveAPI, {pid: projectId}, 'json').then(function (json) {
                        if (json.success) {
                            getAttitudeCount();
                            showPlusAnimation(true);
                        } else {
                            layer.open({
                                content: json.info,
                                style: 'text-align:center;',
                                time: 2
                            });
                        }
                        changeVoteStatus();
                    });
                });
                $('#btn-neg').click(function () {
                    $.post(config.negativeAPI, {pid: projectId}, 'json').then(function (json) {
                        if (json.success) {
                            getAttitudeCount();
                            showPlusAnimation(false);
                        } else {
                            layer.open({
                                content: json.info,
                                style: 'text-align:center;',
                                time: 2
                            });
                        }
                        changeVoteStatus();
                    });
                })
            }
        }();
        $('#canvas').highcharts({
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
            credits: {enabled: false},
            exporting: {enabled: false},
            title: {text: '', x: -80},
            pane: {size: '80%'},
            xAxis: {
                categories: ['团队', '市场', '竞争', '盈利', '创意'],
                tickmarkPlacement: 'on',
                lineWidth: 0
            },
            yAxis: {
                max: 100,
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


        $('.btn-slide').click(function () {
            var $this = $(this),
                    $cc = $(this).parents('.text').next();
            /*location.hash = $(this).parents('.text').parent().attr('id');*/
            if ($cc.css('display') === 'none') {
                $this.text('取消');
                $cc.slideDown().find('textarea').focus();
            } else {
                $cc.slideUp();
                $this.text('回复')
            }

            return false;
        });

        $('.btn-c-c').click(function () {
            var $textarea = $(this).parent().find('textarea'),
                    commentId = $textarea.prev().val();

            var data = {
                project_id: projectId,
                content: $textarea.val(),
                reply_id: commentId
            };
            if (data.content.trim()) {
                $.post(config.projectCommentAPI, data, function (data) {
                    showCommentComment(data);
                    $textarea.val('');
                });
            } else {
                layer.open({
                    content: '请输入评论内容',
                    style: 'text-align:center; border:none;',
                    time: 2
                });
                $textarea.focus();
            }
            return false;
        });

        function showCommentComment(data) {
            location.reload();
        }
        $('#btn-follow').click(function () {
            sessionStorage.setItem('loginRedirect', $(this).attr('href'))
        });

        $('.digg .fav').click(function () {
            var $this = $(this);
            $.get(serverData.favAPI, {id: serverData.projectId}, function (data) {
                if (data.status == 1) {
                    if (data.attach_status == 0) {
                        $this.removeClass('c-blue');
                        var oFavNum = parseInt($this.text());
                        if (oFavNum > 0) $this.text(oFavNum - 1);
                    } else {
                        $this.addClass('c-blue');
                        $this.text(parseInt($this.text()) + 1);
                    }
                } else {
                    layer.alert(data.info, 8, function () {
                        window.location = data.url
                    });
                }
            });
            return false;
        });
    </script>


	<!-- /主体 -->

	<!-- 底部 -->
	</div>
<!-- 底部================================================== -->
 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden" style="display:none;"><!-- 用于加载统计代码等隐藏元素 -->

</div>

	<!-- /底部 -->
</body>
</html>