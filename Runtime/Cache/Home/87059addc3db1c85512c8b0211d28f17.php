<?php if (!defined('THINK_PATH')) exit();?><div class="clearfix">
<ul class="tzzlist cl">
<?php if(is_array($lists)): foreach($lists as $key=>$vo): ?><li><dl>
    <dd class="img"><a href="<?php echo U('MCenter/profile?id='.$vo['investor_id']);?>" target="_blank"><img src="<?php echo (get_memberface($vo["investor_id"])); ?>"></a></dd>
    <dd class="detail">
      <div class="from"><a href="<?php echo U('MCenter/profile?id='.$vo['investor_id']);?>" target="_blank"><b><?php echo (get_membername($vo["investor_id"])); ?></b></a><?php if(($vo["lead_type"]) == "9"): ?><small>领投人</small><?php endif; ?>
      <?php if(($vo["lead_type"]) == "2"): ?><small>候选领投人</small><?php endif; ?></div>
      <div class="d">投资金额：<?php echo (round($vo["fund"],2)); ?>元</div>
    </dd>
    <dd class="date">跟投时间：<?php echo (time_format($vo["create_time"],"Y-m-d")); ?></dd>
  </dl></li><?php endforeach; endif; ?>
</ul>
</div>
<div id="pagectrl" class="pagectrl">
	<?php echo ($Pages); ?>
</div>
<script>
	pageChange();
</script>