<?php
/**
 * Created by PhpStorm.
 * User: adaman58
 * Date: 4/11/15
 * Time: 4:07 PM
 */

namespace Home\Model;
use Think\Model;

Class UserStatisticsModel extends Model {

    public function addBoth($uid,$id){
        $this->addFollower($id);
        $this->addFollowering($uid);
    }

    public function removeBoth($uid,$id){//precondition: $uid,$id 必须之前存在关注状态
        $this->removeFollower($id);
        $this->removeFollowering($uid);
    }

    public function addFollower($id){//增加被关注者的粉丝数量
        $userstatis = M('user_statistics');
        $incFollower = $userstatis->where('uid='.$id)->setInc('followerscount',1);
        if($incFollower==null){
            $data['uid']=$id;
            $data['followerscount']=1;
            $incFollower = $userstatis->add($data);
        }
        return $incFollower;
    }

    public function removeFollower($id){//减少被关注者的粉丝数量
        $userstatis = M('user_statistics');
        return $userstatis->where('uid='.$id)->setDec('followerscount',1);
    }

    public function addFollowering($uid){//增加用户的关注者数量
        $userstatis = M('user_statistics');
        $incFollowering = $userstatis->where('uid='.$uid)->setInc('followingcount',1);
        if($incFollowering==null){
            $data['uid']=$uid;
            $data['followingcount']=1;
            $incFollowering = $userstatis->add($data);
        }
        return $incFollowering;
    }

    public function removeFollowering($uid){//减少用户的关注者数量
        $userstatis = M('user_statistics');
        return $userstatis->where('uid='.$uid)->setDec('followingcount',1);
    }
}
?>