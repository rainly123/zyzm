<?php
namespace Home\Controller;
use Home\Model\ProjLeader;
use Home\Model\ProjLeaderModel;
use Think\Model;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/8/5
 * Time: 14:13
 */
class VoteController extends HomeController
{
    function index()
    {
        $id=I('get.id');
        $model=D('ProjLeader');
        $LeaderInfo=$model->getApplyLeaderInfo($id);
        $this->assign('pid',$id);
        $this->assign('leaderInfo',$LeaderInfo);
        $this->display();
    }

    /**
     * 用户投票
     */
    function vote()
    {
        //如果该用户没投这个项目，那么他不能投票
        $pid=I('pid');
        $leader_id=I('leader_id');
        $uid=is_login();
        $countP=M('ProjLeader')->where(array('pid'=>$pid,'uid'=>$uid))->count();
        if(!$countP)
        {
            $retData['message']= "你还没有投资该项目，因此你不能投票！";
            $retData['status']=false;
        }
        //如果已经对该项目投过票了则不能再投了
        $countV=M('ProjectVote')->where(array('project_id'=>$pid,'investor_id'=>$uid,'marks'=>0))->count();
        if($countV)
        {
            $retData['message'] ="你已投过票了，不能再投了哦！";
            $retData['status']=false;
        }
        //没投过，就要在jm_project_vote中写入数据
        else
        {
            $touziCount=$this->touziCount($pid,$uid);
            $data['project_id']=$pid;
            $data['investor_id']=$uid;
            $data['vote_count']=$touziCount;
            $data['leader_id']=$leader_id;
            $data['create_time']=$this->getCurrentTime();
            $data['update_time']=$this->getCurrentTime();
            $insert=M('ProjectVote')->add($data);
            if($insert)
            {
                 $sqlstr="UPDATE jm_proj_leader SET voit_count=voit_count+".$touziCount." WHERE pid=".$pid." AND uid=".$leader_id." ";
                 $model=new Model();
                 $update=$model->execute($sqlstr);
                 if($update)
                 {
                     $retData['message']="点赞成功！";
                     $retData['status']=true;
                 }
            }
        }
        $jsonstr=json_encode($retData);
        echo $jsonstr;
//        print_r($this->touziCount($pid,$uid));
//        die();
    }

    /**
     * 查看该用户投资额
     */
    function touziCount($pid,$uid)
    {
        $result=M('ProjectInvestor')->where(array('project_id'=>$pid,'investor_id'=>$uid))->select();
        return $result[0]['fund'];
    }

    /**
     * 显示取消赞
     */
    function cancleZan()
    {
        $pid=I('pid');
        $uid=is_login();
        $result=M('ProjectVote')->where(array('project_id'=>$pid,'investor_id'=>$uid,'marks'=>0))->select();
        $leaderId=$result[0]['leader_id'];
        if($leaderId)
        {
            echo $leaderId;
        }
        else
        {
            echo 0;
        }
    }

    function docancle()
    {

        //如果该用户没投这个项目，那么他不能投票
        $pid=I('pid');
        $leader_id=I('leader_id');
        $uid=is_login();
        $countP=M('ProjLeader')->where(array('pid'=>$pid,'uid'=>$uid))->count();
        if(!$countP)
        {
            $retData['message']= "你还没有投资该项目，因此你不能取消！";
            $retData['status']=false;
        }
        //如果已经对该项目投过票了则不能再投了
        $uid=is_login();
        $touziCount=$this->touziCount($pid,$uid);
        $Projectvote=M('ProjectVote');
        $deleteVote=$Projectvote->where(array('project_id'=>$pid,'investor_id'=>$uid))->save(array('marks'=>1));
        $sqlstr="UPDATE jm_proj_leader SET voit_count=voit_count-".$touziCount." WHERE pid=".$pid." AND uid=".$leader_id." ";
        $model=new Model();
        $update=$model->execute($sqlstr);
        if($update)
        {
            $retData['message']= "取消成功！";
            $retData['status']=true;
        }
        $jsonstr=json_encode($retData);
        echo $jsonstr;

    }


}