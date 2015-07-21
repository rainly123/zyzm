<?php
/**
 * Created by PhpStorm.
 * User: adaman58
 * Date: 4/10/15
 * Time: 10:41 AM
 */

namespace Home\Controller;

class FollowsController extends HomeController
{
    public function index(){
    }

    //新增关注对象
    public function add(){
        $uid =is_login();
        if($uid>0){
            $id = I('id',0);
            if($id==0){
                $this->ajaxReturn(array('success'=>false, 'info'=> '缺少参数!'));
            }
            $this->ajaxReturn(D('Followers')->add($uid,$id));
        }else{
            $this->ajaxReturn(array('success'=>false, 'info'=> '用户未登陆!'));
        }
        return;
    }

    //删除关注对象
    public function delete(){
        $uid =is_login();
        if($uid>0){
            $id = I('id',0);
            if($id==0){
                $this->ajaxReturn(array('success'=>false, 'info'=> '缺少参数!'));
            }
            $this->ajaxReturn(D('Followers')->delete($uid,$id));
        }else{
            $this->ajaxReturn(array('success'=>false, 'info'=> '用户未登陆!'));
        }
        return;
    }

    //获取关注
    public function getFollowing(){
        $uid = $_GET['uid'];
        $page = I('page',0);
        $number = I('number',20);
        $order = I('order','createtime desc');
        if($uid>0){
            $this->ajaxReturn(D('Followers')->getFollowing($uid,$page,$number,$order));
        }
        $this->ajaxReturn(array('success'=>false, 'info'=> '用户未登陆!'));
    }

    //获取粉丝
    public function getFollowers(){
        $uid = $_GET['uid'];
        $page = I('page',0);
        $number = I('number',20);
        $order = I('order','createtime desc');
        if($uid>0){
            $this->ajaxReturn(D('Followers')->getFollowers($uid,$page,$number,$order));
        }
        $this->ajaxReturn(array('success'=>false, 'info'=> '用户未登陆!'));
    }
    //仅获取关注和粉丝数量
    public function getFollowsBoth(){
        $uid = $_GET['uid'];
        if($uid>0){
            $this->ajaxReturn(D('Followers')->getFollowsBoth($uid));
        }
        $this->ajaxReturn(array('success'=>false, 'info'=> '用户未登陆!'));
    }
    //获取关注
    public function getRelation(){
        $id = $_GET['uid'];
        $uid = is_login();
        if($uid == 0)$this->ajaxReturn(array('success'=>false, 'info'=> '用户未登录!'));
        if($id>0){
            $createtime = D('Followers')->getRelation($uid,$id);
            if(!$createtime){
                $this->ajaxReturn(array('success'=>false, 'info'=> '未关注!'));
            }else{
                $this->ajaxReturn(array('success'=>true, 'info'=> $createtime));
            }
        }
        else{
            $this->ajaxReturn(array('success'=>false, 'info'=> '参数有误!'));
        }
    }
}

?>