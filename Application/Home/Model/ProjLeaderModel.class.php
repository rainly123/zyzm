<?php
namespace Home\Model;
use Think\Model;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/8/5
 * Time: 17:09
 */
class ProjLeaderModel extends Model
{
    function getApplyLeaderInfo($pid)
    {
       $model=M('LeaderView');
       return $model->where(array('pid'=>$pid))->select();
    }
    /**
     * 查询出该项目竞选领头人的用户id
     */
//    function getUidByPid($pid)
//    {
//        $where=array('pid'=>$pid);
//        return   $this->where($where)->select(array('uid'));
//    }


}