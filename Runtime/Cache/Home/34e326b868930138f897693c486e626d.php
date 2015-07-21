<?php if (!defined('THINK_PATH')) exit();?>
<!--         <ul class="cats">
        	<li><b>| 分类</b></li>
            <li><a href="#">全部</a></li>
            <li><a href="#" class="cur">按时间</a></li>
            <li><a href="#">按金额</a></li>
        </ul> -->
          <ul class="tzzlist cl">
          <?php if(is_array($lists)): foreach($lists as $key=>$vo): ?><li>
              <dl>
                <dd class="img">
                	<a href="<?php echo U('MCenter/profile?id='.$vo['uid']);?>" target="_blank" style="text-decoration:none;">
                		<img src="<?php echo (get_memberface($vo["uid"])); ?>">
                	</a>
                </dd>
                <dd class="detail">
                  <div class="from">
                  	<a href="<?php echo U('MCenter/profile?id='.$vo['uid']);?>" target="_blank" style="text-decoration:none;">
                  		<b><?php echo (get_membername($vo["uid"])); ?></b>
                  	</a>
                  	</div>
                  <div class="d">投资金额：<?php echo (round($vo["amount"],2)); ?>元</div>
                </dd>
                <dd class="date">支持时间：<?php echo (time_format($vo["create_time"],"Y-m-d")); ?></dd>
              </dl>
            </li><?php endforeach; endif; ?>
          
          </ul>
<div id="pagectrl" class="pagectrl">
	<?php echo ($Pages); ?>
</div>
     <script>
	pageChange();
</script>