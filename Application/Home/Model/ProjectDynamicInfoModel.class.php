<?php
/**
 * Created by PhpStorm.
 * User: adaman58
 * Date: 4/2/15
 * Time: 10:48 AM
 */

namespace Home\Model;
use Think\Model;
Class ProjectDynamicInfoModel extends Model{

    protected $_auto = array(
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );
    protected $_validate = array(
        array('project_id','require','项目ID必须！',0,"",1), //默认情况下用正则进行验证
        array('title','require','标题必须！',0,"",1), //默认情况下用正则进行验证
        array('title', '1,30','项目名称不能超过30个字', 0, 'length'),
        array('content','require','内容必须！'), //默认情况下用正则进行验证
        array('open_flag',array(0,1),'阅读权限值的范围不正确！',2,'in'), // 当值不为空的时候判断是否在一个范围内
        array('status',array(0,1),'动态状态值的范围不正确！',2,'in'), // 当值不为空的时候判断是否在一个范围内
    );

    //获取该项目的所有动态信息
    public function getDynamicInfoByPID($pid){
        $where=array('project_id' => $pid,'status'=> array('egt',0));
        return M('project_dynamic_info')->where($where)->order('status asc,update_time desc')->select();
    }

    //获取该项目的所有发布状态的动态信息
    public function getPublishedDynamicInfoByPID($pid){
        $usertype = M(users)->where('id='.is_login())->getField('is_investor');
        $where=array('project_id' => $pid,'status'=> '1');
        if($usertype==1){
            $where=array('project_id' => $pid,'status'=> '1','open_flag'=>'1');
        }
        $dynamicArray = M('project_dynamic_info')->where($where)->order('update_time desc')->select();

        $this->formatDynamicInfo($dynamicArray);
        return $dynamicArray;
    }

    public function formatDynamicInfo(&$dynamicArray){
        foreach($dynamicArray as &$item){
            $item['content'] =  mb_substr(strip_tags($item['content']),0,100,'utf-8');
        }
    }

    //根据动态信息ID来判断当前用户是否有权限
    public function validateUserByDID($id){
        $pid = M('project_dynamic_info')->where('id='.$id)->order('update_time desc')->getField('project_id');
        return validateUserByPID($pid);
    }

    //根据项目ID来判断当前用户是否有权限
    public function validateUserByPID($pid){
        return (is_login()==M('project')->where('id='.$pid)->getField('uid'))?true:false;
    }


}

?>