<?php if (!defined('THINK_PATH')) exit();?><ul id="comments" class="mes">
    <?php if(is_array($lists)): foreach($lists as $key=>$v): ?><li>
            <dl>
                <dd class="img"><a href="<?php echo U('MCenter/profile?id='.$v['comment_user']);?>"><img src="<?php echo (get_memberface($v["comment_user"])); ?>" alt=""></a></dd>
                <dd class="detail">
                    <div class="from"><a href="<?php echo U('MCenter/profile?id='.$v['comment_user']);?>"><b><?php echo (get_membername($v["comment_user"])); ?></b></a><?php echo (change_date($v["create_time"])); ?></div>
                    <?php if(!empty($v["dynamicid"])): ?><div style="display: none" class="getDynamic">{v.dynamicid}</div><?php endif; ?>
                    <?php if(!empty($v["parent"])): ?><div class="pllist clearfix">
                            <ul>
                                <?php if(is_array($v["parent"])): $i = 0; $__LIST__ = $v["parent"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><?php echo (get_membername($vo["comment_user"])); ?> 说：
                                <p style="line-height:22px;margin:0;text-indent:1.5em"><?php echo ($vo["content"]); ?></p></li><?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                        </div><?php endif; ?>
                    <div class="d"><?php echo ($v["content"]); ?></div>
                    <div class="panel" class="reply" style="display:none;">
                        <input type="hidden" class="comment_id" value="<?php echo ($v["id"]); ?>">
                        <textarea class="border1" maxlength="140" style="width:100%;"></textarea>
                        <a href="#" class="btn-comment-comment">评论</a>
                    </div>
                </dd>
                <dd class="cz"><a href="#" class="btn-slide">回复</a></dd>
                <!--注意：增加删除-->
                <dd>
            </dl>
        </li><?php endforeach; endif; ?>
</ul>

<div id="pagectrl-comment" class="pagectrl pagectrl-comment">
    <?php echo ($Pages); ?>
</div>
<script>
    pageChangeComment();
</script>