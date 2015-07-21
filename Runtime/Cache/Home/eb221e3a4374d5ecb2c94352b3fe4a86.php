<?php if (!defined('THINK_PATH')) exit();?><div class="addcards mt20 cl" id="addnewaddress" style="margin:20px; 20px 0 10px">
  <div class="top">
  <dt style="font-size:18px;">配送地址</dt>
  </div>
  <form id="form-modify-addr" method="POST" action="<?php echo U('User/modify_addr');?>">
    <input type="hidden" name="id" value="<?php echo ($detail["id"]); ?>">
    <ul class="list mt20">
      <li><dl><dt>收信人：</dt>
        <dd><input type="text" maxlength="15" class="c1" name="name" datatype="*1-10" nullmsg="请填写收件人" value="<?php echo ($detail["name"]); ?>" errormsg="收件人至少1个字符，最多10个字符"></dd>
      </dl></li>
      <li><dl><dt>所在地区：</dt>
        <dd><div class="select">
          <?php echo hook('J_China_City', array('province'=>$detail['province'], 'city'=>$detail['city']));?>
        </div></dd>
      </dl></li>
      <li><dl><dt>详细地址：</dt>
        <dd><input name="address" maxlength="40" datatype="*1-30" nullmsg="请输入详细地址" errormsg="详细地址至少1个字符，最多30个字符" type="text" value="<?php echo ($detail["address"]); ?>" class="c1"></dd>
      </dl></li>
      <li><dl><dt>手机号码：</dt>
        <dd><input name="phone" datatype="m" maxlength="13" nullmsg="请输入手机号码" errormsg="手机号码格式不正确" type="text" value="<?php echo ($detail["phone"]); ?>" class="c1" id="phone"></dd>
      </dl></li>
      <li><dl><dt>邮政编码：</dt>
        <dd><input name="postno" datatype="p" maxlength="6" nullmsg="请输入邮政编码" errormsg="邮政编码格式不正确" type="text" value="<?php echo ($detail["postno"]); ?>" class="c1" id="postno"></dd>
      </dl></li>
      <li><dl><dt></dt>
        <dd><div id="errormessage"></div></dd>
      </dl></li>
      <li class="mt25"><dl><dt>&nbsp;</dt>
        <dd><input type="submit" value="保存更新" class="c2"></dd>
      </dl></li>
    </ul>
  </form>
</div>
<script type="text/javascript">
$(function() {
  $("#form-modify-addr").Validform({
    tiptype: function(msg, o, cssctl) {
      var objtip = $("#errormessage");
      objtip.text("");
      if (o.type == 3) {
        cssctl(objtip, o.type);
        objtip.text(msg);
        objtip.show();
      } else {
        objtip.hide();
      }
    }, ajaxPost: true,
    callback: function(data) {
      if (data.status == 1) {
        layer.alert(data.info, 1, function(){window.location.reload();});
      }
    }
  });
});
</script>