<?php
namespace Home\Model;
use Think\Model;
Class ProjectAfterInfoModel extends Model{

    protected $_auto = array(
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );
    protected $_validate = array(
        array('project_id','require','项目ID必须！',0,"",1), //默认情况下用正则进行验证
        array('title','require','标题必须！',0,"",1), //默认情况下用正则进行验证
        array('title', '1,40','项目名称不能超过40个字', 0, 'length'),
        array('content','require','内容必须！'), //默认情况下用正则进行验证
        array('status',array(0,1),'动态状态值的范围不正确！',2,'in'), // 当值不为空的时候判断是否在一个范围内
    );

    //根据项目ID来判断当前用户是否有权限浏览
    public function validateUserByPID($pid){
        $investor = M('project_investor')->where('project_id='.$pid)->field('investor_id')->select();
        $user['investor_id'] = is_login();      
        return in_array($user,$investor);
    }
	public function validateUserAllByPID($pid){
		if($this->validateUserByPID($pid) | $this->validateEditorByPID($pid)) return true;
		return false;
	}
    //根据投后项目ID来判断当前用户是否有权限修改
    public function validateEditorByPID($pid){
       return (is_login()==M('project')->where('id='.$pid)->getField('uid'))?true:false;
    }
    
    public function validateByID($id){
    	$pid = M('project_after_info')->where('id='.$id)->getField('project_id');
    	return $this->validateUserAllByPID($pid);
    }
    
    //获取项目投后管理为发布状态列表信息
    public function getPublishedListByPID($id){
    	$where=array('project_id' => $id, 'status'=> 1 );
    	$list = M('project_after_info')->where($where)->order('create_time desc')->field('project_id,id,title,create_time,attachment')->select();
    	return $this->reformatAfterList($list);
    }
    
    //获取项目投后管理的详情
    public function getProjectAfterInfodetail($id){
    	$where=array('id' => $id);
    	$info = M('project_after_info')->where($where)->order('create_time desc')->field('id,title,create_time,attachment,status,content,filename')->find();
    	$data['publishdate'] = date('Y-m-d H:i:s', $info['create_time']);
    	$data['title'] = $info['title'];
    	$data['attachment'] = $info['attachment'];
    	$data['detailurl'] =  'http://'.$_SERVER['HTTP_HOST'].'/projectAfterInfo/fundeddetail/id/'.$info['id'].'/pid/'.$info['project_id'];
    	$data['content'] = $info['content'];
    	$data['filename'] = $info['filename'];
    	if(isset($info['status']))$data['status'] = $info['status'];
    	$final['success']=true;
    	$final['info']=$data;
    	return $final;
    }
    
    //获取项目投后管理为草稿或者发布状态列表信息
    public function getAllListByPID($id){
    	$where=array('project_id' => $id, 'status'=> array('in', '0,1') );
    	$list = M('project_after_info')->where($where)->order('create_time desc')->field('project_id,id,title,create_time,attachment,status')->select();
    	return $this->reformatAfterList($list);
    }
    
    public function reformatAfterList($list){
    	foreach($list as $info){
    		$temp['id'] = $info['id'];
    		$temp['publishdate'] = date('Y-m-d', $info['create_time']);
    		$temp['title'] = $info['title'];
    		$temp['attachment'] = $info['attachment'];
    		$temp['detailurl'] =  'http://'.$_SERVER['HTTP_HOST'].'/projectAfterInfo/fundeddetail/id/'.$info['id'].'/pid/'.$info['project_id'];
    		if(isset($info['status']))$temp['status'] = $info['status'];
    		$data[] = $temp;
    	}
    	return $data;
    }
    public function getProjectStatis($pid){
    	$stage = M('Project')->where('id='.$pid)->field('stage')->find();
    	if($stage['stage']==9){
    		$data['info'] =  M('project_statistics')->where('pid='.$pid)->field('estimatefund,actualinvestors,raisedfund')->find();
    		if($data['info']['actualinvestors']==null | $data['info']['actualinvestors']==0){
    			$where['project_id']=$pid;
    			$where['status']= 9;
    			$update['estimatefund'] = M('ProjectFund')->where('project_id='.$pid)->getField('final_valuation');
    			$update['actualinvestors'] = M('ProjectInvestor')->where($where)->count('project_id');
    			$update['raisedfund'] = M('ProjectInvestor')->where($where)->sum('fund');
    			$result = M('project_statistics')->where('pid='.$pid)->save($update);
    			$leader_id = M('ProjectLeader')->where(array('project_id'=>$pid))->getField('leader_id');
    			$leaderdata = array(
    					'lead_type' => 9,
    			);
    			if($leader_id>0)$updateleader = M('ProjectInvestor')->where('investor_id='.$leader_id)->save($leaderdata);
    			if(!result){
    				$data['success'] = false;
    				$data['errmsg'] = 'Project statistics update failed!';
    			}
    			$data['success'] = true;
    			$data['info'] = $update;
    			return $data;
    		}
    		$data['success'] = true;
    		return $data;
    	}
    	else{
    		$data['success'] = false;
    		$data['errmsg'] = 'Project is not ended!';
    		return $data;
    	}
    }
    public function getInvestorlist($pid,$page=1,$number=20,$order='lead_type desc,create_time desc'){
    	$projectStatis = $this->getProjectStatis($pid);
    	if($projectStatis['success']==false){
    		return $projectStatis;
    	}
    	else{
    		$data['total'] = (int)$projectStatis['info']['actualinvestors'];
    		$data['per_page'] = $number;
    		$data['page'] = (int)$page;
    		$data['last_page'] = ceil($data['total']/$number);
    		$data['estimatefund'] = $projectStatis['info']['estimatefund'];
    		$data['raisedfund'] = $projectStatis['info']['raisedfund'];
    		$data['fundpercentage'] = $data['raisedfund']/ $data['estimatefund'];
    		if($page <= $data['last_page']){
    			$where['project_id']=$pid;
    			$where['status']= 9;
    			$data['investors'] = M('ProjectInvestor')->where($where)->page($page.','.$number)->order($order)->field('investor_id as id,fund,lead_type')->select();
    			foreach ($data['investors'] as &$investor){
    				switch ($investor['lead_type']){
    					case 9:
    						$investor['lead_type'] = "领投人";break;
    					case 3:
    						$investor['lead_type'] = "跟投人";break;
    				}
    				$investor['nickname'] = get_membername($investor['id']);
    			}
    			return array('success'=>true, 'info'=> $data);
    		}
    		return array('success'=>false, 'info'=> '没有更多投资者信息!');
    	}
    	return array('success'=>true, 'info'=> '没有更多投资者信息!');
    }
    
    public function getCommentList($id){
    	$result = M('projectafter_comment')->where('project_after_id='.$id)->order('create_time desc')->select();
    	if ($result ==false) {
    		return array('success'=>false, 'info'=> '获取列表失败！');
    	}else{	
    		$data['success'] = true;
    		foreach($result as $info){
    			$temp['nickname'] = get_membername($info['comment_user']);
    			$temp['memberface'] = 'http://'.$_SERVER['HTTP_HOST'].get_memberface($info['comment_user']);
    			$temp['content'] = $info['content'];
    			$temp['create_time'] = date('Y-m-d H:i:s', $info['create_time']);
    			$data['info'][] = $temp;
    		}
    		return $data;
    	}
    }
    
    function removeatttachment($id){
    	//$projectAfterInfo = D('ProjectAfterInfo');
    	if(!$this->validateEditorByPID(M('project_after_info')->where('id='.$id)->getField('project_id'))){
    		return array('success'=>false, 'info'=> '没有权限删除');
    	}
    	$attahcment = M('project_after_info')->where('id='.$id)->getField('attachment');
    	if($attahcment==null | $attahcment=='' )return array('success'=>true, 'info'=> '删除成功');;
    	$data = array(
    			'filename' => '',
    			'attachment' => '',
    	);
    	$result = M('project_after_info')->where('id='.$id)->save($data);
    	if ($result==0) {
    		return array('success'=>false, 'info'=> '删除项目投后管理附件失败，请联系管理员:service@dreammove.cn');
    	}else {
    		if(!$this->removefile($attahcment))return array('success'=>false, 'info'=> $attahcment.'删除项目投后管理附件失败，请联系管理员:service@dreammove.cn');
    		return array('success'=>true, 'info'=> '删除成功');;
    	}
    }
    function removefile($filepath){
    	$prefix = 'http://'.$_SERVER['HTTP_HOST'].'/';
   		return unlink(substr($filepath,strlen($prefix)));
    }

}

?>