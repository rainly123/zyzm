<?php
/**
 * Created by PhpStorm.
 * User: adaman58
 * Date: 4/10/15
 * Time: 4:07 PM
 */

namespace Home\Model;
use Think\Model;

Class FollowersModel extends Model {

    public function add($uid,$id){
        $follows = M('followers');
        if($uid==$id)return array('success'=>false, 'info'=> '不能关注自己!');
        $data = array('followers'=>$uid,'following'=>$id);
        if($follows->where($data)->find()==null){
            $result = $follows->add($data);
            if($result){
                D('userStatistics')->addBoth($uid,$id);//更新用户统计信息
                return array('success'=>true, 'info'=> '关注成功!');
            }
            return array('success'=>false, 'info'=> $result->getError());
        }
        return array('success'=>false, 'info'=> '已经关注!');
    }

    public function delete($uid,$id){
        $follows = M('followers');
        $data = array('followers'=>$uid,'following'=>$id);
        $delete = $follows->where($data)->delete();
        if($delete==1){
            D('userStatistics')->removeBoth($uid,$id);//更新用户统计信息
            return array('success'=>true, 'info'=> '删除成功!');
        }elseif($delete==0 ){
            return array('success'=>false, 'info'=> '未找到需要删除的数据!');
        }else{
            return array('success'=>false, 'info'=> '删除异常!');
        }
    }

    public function getFollowers($uid,$page='0',$number='50',$order='createtime desc'){
        $userStatis = M('user_statistics');
        $data = array('uid'=>$uid);
        $result = $userStatis->where($data)->find();
        if($result !=null){
            $data['success'] = true;
            $data['total'] = $result['followerscount'];
            $data['per_page'] = $number;
            $data['page'] = $page+1;
            $data['last_page'] = ceil($result['followerscount']/$number);
            if($page <= $data['last_page']){
                $data['users'] = M('followers')->where('following='.$uid)->page($page.','.$number)->order($order)->field('followers as id')->select();
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
                return $data;
            }
            return array('success'=>false, 'info'=> '没有更多粉丝信息!');
        }
        return array('success'=>true, 'info'=> '没有粉丝信息!');
    }

    public function getFollowing($uid,$page='0',$number='50',$order='createtime desc'){
        $userStatis = M('user_statistics');
        $data = array('uid'=>$uid);
        $result = $userStatis->where($data)->find();
        if($result !=null){
            $data['success'] = true;
            $data['total'] = $result['followingcount'];
            $data['per_page'] = $number;
            $data['page'] = $page+1;
            $data['last_page'] = ceil($result['followingcount']/$number);
            if($page <= $data['last_page']){
                $data['users'] = M('followers')->where('followers='.$uid)->page($page.','.$number)->order($order)->field('following as id')->select();
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
               return $data;
            }
            return array('success'=>false, 'info'=> '没有更多关注信息!');
        }
        return array('success'=>true, 'info'=> '没有关注信息!');
    }

    public function getRelation($sourceID,$targetID){
        $where = array('followers'=>$sourceID,'following'=>$targetID);
        return M('followers')->where($where)->getField('createtime');
    }
    public function getFollowsBoth($uid){
        $userStatis = M('user_statistics');
        $where = array('uid'=>$uid);
        $result = $userStatis->where($where)->field('followingcount,followerscount')->find();
        $data['success'] = true;
        if($result){
            $data['followingcount'] = $result['followingcount'];
            $data['followerscount'] = $result['followerscount'];
        }else{
            $data['followingcount'] = 0;
            $data['followerscount'] = 0;
        }
        return $data;
    }
}
?>