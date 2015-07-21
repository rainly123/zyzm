<?php 
namespace Home\Model;
use Think\Model;
use User\Api\UserApi;

Class MessageModel extends Model{
	
	/**
	 * 发送短消息
	 *
	 * @author Hyber
	 * @param int $from_id
	 * @param mixed $to_id  发送给哪些user_id  可以是逗号分割 可以是数组
	 * @param string $title 短信标题
	 * @param string $content 短信内容
	 * @param int $parent_id 如果是回复则需要主题msg_id
	 * @return mixed
	 */
	function send($from_id, $to_id, $title='', $content, $msg_type=0, $parent_id=0)
	{

		$to_ids = is_array($to_id) ? $to_id : explode(',', $to_id);
		foreach ($to_ids as $k => $to_id)
		{
			$data[$k] = array(
					'from_id'   => $from_id,
					'to_id'     => $to_id,
					'title'     => $title,
					'msg_type'     => $msg_type,
					'content'   => $content,
					'parent_id' => $parent_id,
					'add_time'  => NOW_TIME,
					'new' => 1,
					'status' => 3,
					'last_update' => NOW_TIME
			);
			
			if ($parent_id>0) //回复
			{
				if ($k==0)//只执行一次
				{
					//$message = $this->get_info($parent_id);
					$message = M('Message')->where(" id = ". $parent_id)->find();
					
					$edit_data =array(
							'last_update'   => NOW_TIME, //修改主题更新时间
							'status'        => 3, //主题双方未删除
					);
					$edit_data['new'] = $from_id == $message['from_id'] ? 1 : 2; //如果回复自己发送的主题时
					//unset($this->_autov['title']['required']); //允许标题为空
				}
			}
		}
		
		$msg_ids = $this->addAll($data);
		$edit_data && $msg_ids && $this->save($parent_id, $edit_data);
		return $msg_ids;
	}
	
	/**
	 * 删除短消息
	 *
	 * @author Hyber
	 * @param mix $msg_id 可以是逗号分割 可以是数组
	 * @param integer $user_id 当前用户
	 * @return integer
	 */
	function msg_drop($msg_id, $user_id)
	{
		$msg_ids = is_array($msg_id) ? $msg_id : explode(',', $msg_id);
		if (!$msg_ids)
		{
			$this->error('no_such_message');
			return false;
		}
		if (!$user_id)
		{
			$this->error('no_such_user');
			return false;
		}
		foreach ($msg_ids as $msg_id)
		{
			$message = $this->get_info($msg_id);
			if ($message['from_id'] == MSG_SYSTEM && $message['to_id'] == $user_id)
			{
				$drop_ids[] = $msg_id; // 删除系统发给自己的消息
			}
			elseif ($user_id==$message['to_id']) //收件箱
			{
				if ($message['status']==2 || $message['status']==3)
				{
					$this->edit($msg_id, array('status' => 2));
				}else
				{
					$drop_ids[] = $msg_id; //记录需要删除记录的msg_id
				}
			}
			elseif ($user_id==$message['from_id']) //发件箱
			{
				if ($message['status']==1 || $message['status']==3)
				{
					$this->edit($msg_id, array('status' => 1));
				}else
				{
					$drop_ids[] = $msg_id; //记录需要删除记录的msg_id
				}
			}
			else
			{
				$this->error('no_drop_permission');
				return false;//没有删除权限
			}
		}
		if ($drop_ids)
		{
			return $this->drop($drop_ids);
		}
		else
		{
			return count($msg_ids);
		}
	}
}
?>