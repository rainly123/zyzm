<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/Public/Home/css/common.css" rel="stylesheet">
    <link href="/Public/Home/css/jquery.range.css" rel="stylesheet">

    <style>
        .canvas{ width:400px !important; height:400px !important;}
        .maps{ float:left;}
        h2{ margin:20px 0 0 0; padding:0; font-family:"微软雅黑", "黑体", "宋体"; font-size:16px;}
        .ranges{float:right; width:362px;}
        .ranges li{
            margin-bottom:10px;
        }
        .ranges .input{
            position:relative; margin-top:10px;
        }
        .ranges .input label{
            position:absolute; right:0px; top:-30px; color:#000; font-weight:bold; font-size:14px;
        }
        .ranges input{
            width:100%; background:#f1f1f1; border-radius:5px;
        }
        .ranges input[type=range].slider{
            background:red;
        }
        input[type="range"] {
            -webkit-appearance: none;
            margin-top: 2px;
            height:10px;
            background-color: #f1f1f1;
            border-radius: 3px;
            width: 350px;
        }
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            cursor: pointer;
            top: 1px;
            height: 30px;
            width: 30px;
            background:url(images/range_hand.png) no-repeat 0 0;
            border:none;
        }
        .dorate .addmsg{
            margin-top:40px;
        }
        .dorate .addpost{
            border:#dddddd solid 1px; padding:20px; margin-top:20px; border-radius:5px;
        }
        .dorate .addpost textarea{
            width:100%; border:none;
        }
        textarea.c2{border-radius:3px; border:1px solid #dddddd; width:330px; margin-left:10px;height:80px; resize:none; padding:10px; margin-top:20px;}
        input.sub{ background:#53b2e3; width:100px;
            border: medium none;
            color: #fff;
            cursor: pointer;
            float: none;
            font-size: 16px;
            padding:10px 30px;
            border-radius:3px;font-family:"微软雅黑", "黑体", "宋体";}

    </style>

    <script type="text/javascript" src="/Public/Home/js/jquery-1.7.2.min.js"></script>
    <!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->

    <script type="text/javascript" src="/Public/Home/js/jquery.range.js"></script>
</head>

<body>
<div style="width:800px; margin:20px auto;">
    <form method="post" action="/ProjectScores/saveScores">
        <!--打分开始--><div class="df">
        <div class="maps">
            <div id="container" style="width:350px;height:350px"></div>
        </div>
        <div class="ranges">
            <ul>
                <input type="hidden" name="project_id" value=<?php echo ($projectID); ?> />
                <li>
                    <h2>团队</h2>
                    <div class="input">
                        <div class="demo-output">
                            <input class="single-slider" name="group" type="hidden" value="<?php if(empty($user_score["group"])): ?>51<?php else: echo ($user_score["group"]); endif; ?>"/>
                        </div>
                        <label><span id="n1"><?php if(empty($user_score["group"])): ?>51<?php else: echo ($user_score["group"]); endif; ?></span>分</label>
                    </div>
                </li>
                <li>
                    <h2>市场</h2>
                    <div class="input">
                        <div class="demo-output">
                            <input class="single-slider" name="market" type="hidden" value="<?php if(empty($user_score["market"])): ?>51<?php else: echo ($user_score["market"]); endif; ?>"/>
                        </div>
                        <label><span id="n2"><?php if(empty($user_score["market"])): ?>51<?php else: echo ($user_score["market"]); endif; ?></span>分</label>
                    </div>
                </li>
                <li>
                    <h2>竞争</h2>
                    <div class="input">
                        <div class="demo-output">
                            <input class="single-slider" name="creative" type="hidden" value="<?php if(empty($user_score["creative"])): ?>51<?php else: echo ($user_score["creative"]); endif; ?>"/>
                        </div>
                        <label><span id="n3"><?php if(empty($user_score["creative"])): ?>51<?php else: echo ($user_score["creative"]); endif; ?></span>分</label>
                    </div>
                </li>
                <li>
                    <h2>盈利</h2>
                    <div class="input">
                        <div class="demo-output">
                            <input class="single-slider" name="profitablity" type="hidden" value="<?php if(empty($user_score["profitablity"])): ?>51<?php else: echo ($user_score["profitablity"]); endif; ?>"/>
                        </div>
                        <label><span id="n4"><?php if(empty($user_score["profitablity"])): ?>51<?php else: echo ($user_score["profitablity"]); endif; ?></span>分</label>
                    </div>
                </li>
                <li>
                    <h2>创意</h2>
                    <div class="input">
                        <div class="demo-output">
                            <input class="single-slider" name="evaluation" type="hidden" value="<?php if(empty($user_score["evaluation"])): ?>51<?php else: echo ($user_score["evaluation"]); endif; ?>"/>
                        </div>
                        <label><span id="n5"><?php if(empty($user_score["evaluation"])): ?>51<?php else: echo ($user_score["evaluation"]); endif; ?></span>分</label>
                    </div>
                </li>

                <li class="mt20">
                    <h2>项目留言</h2>
                    <textarea name="comments" cols="" rows="" class="c2" ><?php echo ($user_score["comments"]); ?></textarea>
                </li>
                <li class="mt20" style="text-align:right; padding-right:0px;"><input id="submit" name="" type="submit" value="提交" class="sub"></li>

            </ul>
        </div>
    </div>
    </form>
    <script type="text/javascript" src="/Public/Home/js/highcharts.js"></script>
    <script type="text/javascript" src="/Public/Home/js/exporting.js"></script>
    <script type="text/javascript" src="/Public/Home/js/highcharts-more.js"></script>
    <script type="text/javascript" src="/Public/static/layer/layer.min.js"></script>

    <script>
        var chart;

        $(function () {
            <?php if(($status) == "0"): ?>parent.layer.alert('<?php echo ($info); ?>', 9);
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);<?php endif; ?>
            chart = new Highcharts.Chart({
                chart: {
                    renderTo : 'container',
                    polar: true,
                    type: 'line',
                    events: {
                        load:function(){

                        }
                    }
                },
                credits: {enabled:false},
                exporting: {enabled:false},
                title: {
                    text: '',
                    x: -80
                },

                pane: {
                    size: '80%'
                },

                xAxis: {
                    categories: ['团队', '市场', '竞争', '盈利','创意'],
                    tickmarkPlacement: 'on',
                    lineWidth: 0
                },

                yAxis: {
                    gridLineInterpolation: 'polygon',
                    lineWidth: 0,
                    min: 0,
                    max:100
                },
                series: [{
                    name: '综合评分',
                    data: [<?php echo ($scores["group"]); ?>, <?php echo ($scores["market"]); ?>, <?php echo ($scores["creative"]); ?>, <?php echo ($scores["profitablity"]); ?>, <?php echo ($scores["evaluation"]); ?>],
                    pointPlacement: 'on'
                }]

            });
            function drawChart(){
                var n1 = parseInt($('#n1').html());
                var n2 = parseInt($('#n2').html());
                var n3 = parseInt($('#n3').html());
                var n4 = parseInt($('#n4').html());
                var n5 = parseInt($('#n5').html());
                var data = [n1,n2,n3,n4,n5];
                chart.series[0].setData(data,true,true,true);
            }
            $('.single-slider').jRange({
                from: 0,
                to: 100,
                step: 1,
                scale: [0,100],
                format: '%s',
                width: 362,
                showLabels: false,
                onstatechange:function() {/*初始化*/
                    $('.single-slider').each(function(){
                        $(this).parent().next().find('span').html($(this).val());
                    });
                    drawChart();
                }
            });
            drawChart();
            $('form').submit(function(){
                $.post($(this).attr('action'), $(this).serialize(), function(data){
                    if (data.status == 1) {
                        top.location.reload();
                    } else {
                        layer.alert(data.info, 8, function (){
                            top.location.reload();
                        });
                    }

                }, 'json');
                return false;
            });
        });</script>





    <!--打分结束-->
</body>
</html>