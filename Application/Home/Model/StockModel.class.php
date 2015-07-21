<?php
namespace Home\Model;
use Think\Model;
Class StockModel extends Model{

    public function getAllProvedStocksInfo($where=array('status' => 1),$order='create_time desc',$limit=null) {
        $stocks = M('Stock')->where($where)->order($order)->limit($limit)->select();
        foreach($stocks as &$stock){
            $stock['investor_count'] = M('StockAccount')->where(array('pid'=>$stock['id'], 'status'=> 0))->count();
        }
        return $stocks;
    }

    //获取股票基金项目列表
    public function getFundingStcokInfo($numberOfProjects='6',$where=array('status' => 1),$order='create_time desc') {
        $stocks = M('Stock')->where($where)->order($order)->limit($numberOfProjects)->select();
        foreach($stocks as &$stock){
            $stock['investor_count'] = M('StockAccount')->where(array('pid'=>$stock['id'], 'status'=> 0))->count();
        }
        return $stocks;
    }

}
?>