<?php
namespace Home\Model;
use Think\Model;

Class ManageModel extends Model {
	protected $autoCheckFields =false;
	public function getProjectStatis($pid){
		$stage = M('Project')->where('id='.$pid)->field('stage')->find();
		if($stage['stage']==9){
			$data['info'] =  M('project_statistics')->where('pid='.$pid)->field('estimatefund,actualinvestors,raisedfund')->find();
			if($data['info']['estimatefund']==null){
				$where['project_id']=$pid;
				$where['status']= 9;
				$update['estimatefund'] = M('ProjectFund')->where('project_id='.$pid)->getField('final_valuation');
				$update['actualinvestors'] = M('ProjectInvestor')->where($where)->count('project_id');
				$update['raisedfund'] = M('ProjectInvestor')->where($where)->sum('fund');
				$result = M('project_statistics')->where('pid='.$pid)->save($update);
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
    public function getInvestorlist($pid,$page='0',$number='8',$order='lead_type desc,create_time desc'){
    	$projectStatis = $this->getProjectStatis($pid);
    	if($projectStatis['success']==false){
    		return $projectStatis;
    	}
    	else{
            $data['total'] = $projectStatis['info']['actualinvestors'];
            $data['per_page'] = $number;
            $data['page'] = $page+1;
            $data['last_page'] = ceil($data['total']/$number);
            $data['estimatefund'] = $projectStatis['info']['estimatefund'];
            $data['raisedfund'] = $projectStatis['info']['raisedfund'];
            $data['fundpercentage'] = $data['raisedfund']/ $data['estimatefund'];
            if($page <= $data['last_page']){
            	$where['project_id']=$pid;
            	$where['status']= 9;
                $data['investors'] = M('ProjectInvestor')->where($where)->page($page.','.$number)->order($order)->field('investor_id as id,fund,lead_type')->select();
                foreach ($data['investors'] as &$investor){
                	switch ($investor['lead_type']){
                		case 9:
                			$investor['lead_type'] = 领投人;break;
                		case 3:
                			$investor['lead_type'] = 跟投人;break;
                	}
                	$investor['nickname'] = get_nickname($investor['id']);
                }
                
                
                return array('success'=>true, 'info'=> $data);
                /*
                foreach($data['users'] as &$user){
                    $getUserInfo['nickname'] = get_membername($user['id']);
                    $getUserInfo['photo_url'] = 'http://'.$_SERVER['HTTP_HOST'].get_memberface($user['id']);
                    $currentUser = is_login();
                    if($currentUser>0){
                        $getUserInfo['relation'] =D('Followers')->getRelation($currentUser,$user['id']);
                    }
                    else{
                        $getUserInfo['relation'] =null;
                    }
                    $user = array_merge($user,$getUserInfo);
                }
                return $data;*/
            }
            return array('success'=>false, 'info'=> '没有更多投资者信息!');
        }
        return array('success'=>true, 'info'=> '没有粉丝信息!');
    }

    
}
?>