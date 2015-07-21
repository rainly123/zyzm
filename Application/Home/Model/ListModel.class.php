<?php
namespace Home\Model;
use Think\Model;
Class ListModel extends Model{
    Protected $autoCheckFields = false;//创建虚拟模型

    //获取所有股权众筹项目列表
    public function getAllProvedProjectsInfo($stage=array('between',array('1','9')),$order='create_time desc',$limit=null) {
        return D('Project')->getAllProvedProjectsInfo();//$stage,$order,$limit
    }

    public function getAllProvedProducts($stage=array('between',array('1','9')),$order='create_time desc',$limit=null) {
        return D('Product')->getAllProvedProducts();//$stage,$order,$limit
    }
    //获取各阶段实物众筹项目列表
    public function getFundingProducts($where=array('status' => 9, 'stage'=> array('between',array('1','2'))),$order='create_time desc,stage desc') {
        return M('Product')->where($where)->order($order)->select();
    }

    //获取各阶段实物众筹项目列表附加统计信息


}
?>