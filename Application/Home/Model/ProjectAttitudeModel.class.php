<?php
/**
 * Created by PhpStorm.
 * User: adaman58
 * Date: 4/13/15
 * Time: 4:17 PM
 */

namespace Home\Model;
use Think\Model;

Class ProjectAttitudeModel extends Model
{
    public function positive($pid){
        $data['status'] = M('Project')->where('id='.$pid)->getField('status');
        $attitude = M('Project_attitude');
        if($data['status']){
            $uid = is_login();
            $where = array('project_status'=>$data['status'],'uid'=>$uid,'pid'=>$pid);
            if($attitude->where($where)->find()==null){
                $where['ip']= get_client_ip();
                $where['attitude']= 1;//0表示反对；1表示支持
                $result = $attitude->add($where);
                if($result){
                    D('ProjectStatistics')->addPositive($pid);//更新用户统计信息
                    return array('success'=>true, 'info'=> '投票成功!');
                }
                return array('success'=>false, 'info'=> $result->getError());

            }
            if($uid==0){
            	$where['ip']= get_client_ip();
            	$counter = $attitude->where($where)->count();
            	if($counter<20){
            		$where['attitude']= 1;//0表示反对；1表示支持
            		$result = $attitude->add($where);
            		if($result){
            			D('ProjectStatistics')->addPositive($pid);//更新用户统计信息
            			return array('success'=>true, 'info'=> '投票成功!');
            		}
            		return array('success'=>false, 'info'=> $result->getError());
            	}else{
            		return array('success'=>false, 'info'=> '您已经投票20次,请勿重复投票!');
            	}
            }
            return array('success'=>false, 'info'=> '您已经投票,请勿重复投票!');
        }else{
            return array('success'=>false, 'info'=> '未找到该项目!');
        }
    }

    public function negative($pid){
        $data['status'] = M('Project')->where('id='.$pid)->getField('status');
        $attitude = M('Project_attitude');
        if($data['status']){
            $uid = is_login();
            $where = array('project_status'=>$data['status'],'uid'=>$uid,'pid'=>$pid);
            if($attitude->where($where)->find()==null){
                $where['ip']= get_client_ip();
                $where['attitude']= 0;//0表示反对；1表示支持
                $result = $attitude->add($where);
                if($result){
                    D('ProjectStatistics')->addNegative($pid);//更新用户统计信息
                    return array('success'=>true, 'info'=> '投票成功!');
                }
                return array('success'=>false, 'info'=> $result->getError());

            }
            if($uid==0){
            	$where['ip']= get_client_ip();
            	$counter = $attitude->where($where)->count();
            	if($counter<20){
            		$where['attitude']= 0;//0表示反对；1表示支持
            		$result = $attitude->add($where);
            		if($result){
            			D('ProjectStatistics')->addNegative($pid);//更新用户统计信息
            			return array('success'=>true, 'info'=> '投票成功!');
            		}
            		return array('success'=>false, 'info'=> $result->getError());
            	}else{
            		return array('success'=>false, 'info'=> '您已经投票20次,请勿重复投票!');
            	}
            }
            return array('success'=>false, 'info'=> '您已经投票,请勿重复投票!');
        }else{
            return array('success'=>false, 'info'=> '未找到该项目!');
        }
    }

    public function numberOfNegative($pid){
        $disLikeNumber = M('Project_statistics')->where('pid='.$pid)->getField('udislike');
        if(!$disLikeNumber){
            $disLikeNumber = 0;
        }
        return array('success'=>true, 'info'=> $disLikeNumber);
    }

    public function numberOfPositive($pid){
        $likeNumber = M('Project_statistics')->where('pid='.$pid)->getField('ulike');
        if(!$likeNumber){
            $likeNumber = 0;
        }
        return array('success'=>true, 'info'=> $likeNumber);
    }
}
?>