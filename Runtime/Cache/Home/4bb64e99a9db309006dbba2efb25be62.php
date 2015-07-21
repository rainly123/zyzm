<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,user-scalable=no,maximum-scale=1,initial-scale=1">
    <title>更改头像</title>
    <link rel="stylesheet" href="/Public/static/Jcrop/css/jquery.Jcrop.min.css"/>
    <link href="/Public/Mobile/css/login.css" rel="stylesheet" type="text/css">
    <link href="/Public/Mobile/css/css.css" rel="stylesheet" type="text/css">
    <link href="/Public/Mobile/css/header.css" rel="stylesheet" type="text/css">
    <style>
        html, body {
            height: 100%;
        }
        #crop-box {
            position: absolute;
            top: 130px;
            width: 100%;
            text-align: center;
        }

        .header {
            width: 100%;
            text-align: center;
        }

        .header button {
            background: #72c2e5;
            width: 44%;
            margin: 1%;
            height: 40px;
            display: inline-block;
            color: #fff;
            font-size: 20px;
            text-align: center;
            line-height: 40px;
            border-radius: 3px;
            border: none;
        }

        #up-avatar-cancel {
            background: #686868;
            color: #cfcfcf;
        }
        .jcrop-holder {
            margin: 0 auto;
        }

        #button-box {
            display: inline-block;
            width: 50%;
            text-align: center;
            padding: 10px 0;
            position: relative;
        }

        #button-box button {
            width: 90%;
        }

        #download {
            position: absolute;
            top: 10px;
            left: 0;
            width: 100%;
            height: 50px;
            opacity: 0;
        }
        #up-avatar-submit:disabled {
            background: #ccc;
        }
        #crop-img {
            max-width: 90%;
            max-height: 70%;
        }
    </style>
</head>
<body>
<header>
    <h2>更改头像</h2>
    <div class="lft">
        <a href="javascript:window.history.go(-1);" class="back"></a>
    </div>
</header>
<div class="up-pic-box" id="up-pic-box" style="">
    <!--<div class="user_yhzx">
        <div class="user_yhzx2">

            <h2><?php echo ($user["nickname"]); ?></h2>
        </div>
    </div>-->
    <div class="header">
        <label id="button-box" for="download">
            <!--<img class="avatar-img" src="/Public/Mobile/images/img9.jpg" height="80" width="80">
            <div class="avatar-mask"></div>-->
            <button>点击上传照片</button>
            <input type="file" id="download" class="up-avatar" name="download">
        </label>
        <button id="up-avatar-submit" data-href="<?php echo U('MCenter/index');?>" disabled>确定</button>
    </div>

    <div id="crop-box">
        <img id="crop-img" src="<?php echo get_memberface();?>">
    </div>
    <!--<div class="up-box-footer">

        <button id="up-avatar-cancel">取消</button>
    </div>-->
    <form id="change-photo-form" action="<?php echo U('User/changePhoto');?>" method="post">
        <input type="hidden" id="avatar-id" name="photo" value="">
        <input type="hidden" id="x" name="x" value="">
        <input type="hidden" id="y" name="y" value="">
        <input type="hidden" id="w" name="w" value="">
        <input type="hidden" id="h" name="h" value="">
        <!--<input type="hidden" id="sw" name="sw">
        <input type="hidden" id="sh" name="sh">-->
        <input type="hidden" name="flag" value="1">
        <input type="hidden" id="basepath" name="basepath" value="/Uploads/Picture/Photo/552521d06b169.jpg">
    </form>
</div>
<script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="/Public/static/jquery.upload.js"></script>
<script type="text/javascript" src="/Public/static/Jcrop/js/jquery.Jcrop.min.js"></script>
<script type="text/javascript" src="/Public/Mobile/js/layer.m/layer.m.js"></script>
<script type="text/javascript">
    var clearCoords = function (c) {
        $('#x').val("");
        $('#y').val("");
        $('#w').val("");
        $('#h').val("");
    };
    var updateCoords = function (c) {
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#w').val(c.w);
        $('#h').val(c.h);
    };
    var jcrop_api;
    $('.up-avatar').change(function () {
        $.upload({
            url: '<?php echo U("File/uploadPhoto");?>',
            fileName: 'download',
            dataType: 'json',
            accept: '.jpg,.jpeg,.png,.gif',
            // 上传之前回调,return true表示可继续上传
            onSend: function () {
                return true;
            },
            // 上传之后回调
            onComplate: function (json) {
                jcrop_api && jcrop_api.destroy();
                var $img = $('#crop-img');
                $img.css({
                    'width': 'auto',
                    'height': 'auto'
                });
                $img.attr('src', json.path);
                $img.on('load', function () {
                    $img.Jcrop({
                        aspectRatio: 1,
                        bgColor: '#eee',
                        boxWidth: innerWidth - 20,
                        boxHeight: innerHeight - 150,
                        setSelect: [0, 0, 100, 100],
                        onSelect: updateCoords,
                        onRelease: clearCoords
                    }, function () {
                        jcrop_api = this;
                    });
                });
                $('#avatar-id').val(json.id);
                $('#basepath').val(json.path);
                $('#up-avatar-submit').removeAttr('disabled');
            }
        });
    });
    $('#up-avatar-submit').click(function () {
        var $this = $(this);
        if (!$('#avatar-id').val()) {
            layer.open({
                content: '请上传照片',
                style: 'text-align:center; border:none;',
                time: 2
            });
            return false;
        }
        var $form = $("#change-photo-form");
        var success = function (json) {
            if (json.status) {
                $('#avatar-img').attr('src', json.photo_url);
                layer.open({
                    content: json.info,
                    style: 'text-align:center; border:none;',
                    time: 2
                });
                setTimeout(function () {
                    location.href = $this.data('href');
                }, 1000);
            } else {

            }
        };
        $.ajax({
            type: 'POST',
            url: $form.attr('action'),
            data: $form.serialize(),
            success: success,
            error: function () {

            }
        });
    });
    $('#up-avatar-cancel').click(function () {
        location.href = $('#up-avatar-submit').data('href');
    })
</script>
</body>
</html>