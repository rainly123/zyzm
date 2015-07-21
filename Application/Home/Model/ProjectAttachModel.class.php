<?php 
namespace Home\Model;
use Think\Model;

class ProjectAttachModel extends Model {

	// 项目关注处理
	public function attach($id) {

		$uid = is_login();

		$where = array('project_id'=>$id, 'investor_id'=>$uid);
		$data = $this->field('status')->where($where)->find();
 		$status = 1;
		if ($data) {
			$status = $data['status'] ? 0 : 1;
			if ($status) {
				M('Project')->where(array('id'=>$id))->setInc('like_record');
			} else {
				M('Project')->where(array('id'=>$id))->setDec('like_record');
			}
			$save = array('status' => $status, 
					'attach_time' => NOW_TIME,
					'update_time' => NOW_TIME,
					'update_id' => $id,);
			$this->where($where)->save($save);
		} else {
			$save = array('project_id'=>$id, 
					'attach_time' => NOW_TIME,
					'investor_id'=>$uid, 
					'status'=>1, 
					'create_time' => NOW_TIME,
					'create_id' => $id,
					'update_time' => NOW_TIME,
					'update_id' => $id,);

			$this->add($save);
		}
		$proj = M('Project')->where('id=' . $id)->field('uid,project_name')->find();
		$link = '<a href="'.U('Project/detail?id='.$id).'">《'.$proj['project_name'].'》</a>';
		$ulink = '<a href="'.U('MCenter/profile?id='.$uid).'">'.get_membername($uid).'</a>';
		if ($status) {
			D('ProjectDynamic')->addDynamic($id, '收藏了'.$link.'项目。', 1);
			//用户（关注）动态
			// 项目方（收藏提示）消息
			D('Message')->send(0,$proj['uid'],'', $ulink.'收藏了您的'.$link.'项目。',3);
		} else {
			M('ProjectDynamic')->where(
				array('project_id'=>$id, 'create_id'=>$uid, 'type' => 1))->delete();
			// 项目方（收藏提示）消息
			D('Message')->send(0,$proj['uid'],'', $ulink.'取消收藏了您的'.$link.'项目。',3);
		}

		return $status;
	}
}
?>