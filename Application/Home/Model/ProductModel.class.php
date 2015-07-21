<?php
namespace Home\Model;
use Think\Model;
Class ProductModel extends Model{

    public function getAllProvedProducts($stage=array('between',array('1','9')),$order='stage desc,create_time desc',$limit=null) {
        $where=array('status' => 9, 'stage'=> $stage );
        //return $this->addProductsInvestorCount(M('Product')->where($where)->order($order)->limit($limit)->select());
        $result=$this->getAllShowProducts();
        return $result;
        //   return array_merge($this->getAllFundingProducts(),$this->getAllSuccessedProducts());
    }

    public function getAllFundingProducts($stage=2,$order='create_time desc',$limit=null) {
        $where=array('status' => 9, 'stage'=> $stage );
//        $result=$this->addProductsInvestorCount(M('Product')->where($where)->order($order)->limit($limit)->select());
        return $this->addProductsInvestorCount(M('Product')->where($where)->order($order)->limit($limit)->select());
    }

    public function getAllSuccessedProducts($stage=9,$order='create_time desc',$limit=null) {
        $where=array('status' => 9, 'stage'=> $stage );
        return $this->addProductsInvestorCount(M('Product')->where($where)->order($order)->limit($limit)->select());

    }

    /**
     * 获得可以显示到前台网站的实物众筹项目
     */
    public function getAllShowProducts($order='create_time desc',$limit=null)
    {
        $where='status=9 and stage in (2,9)' ;
//        $result=$this->addProductsInvestorCount(M('Product')->where($where)->order($order)->limit($limit)->select());
         return $this->addProductsInvestorCount(M('Product')->where($where)->order($order)->limit($limit)->select());
    }



    //获取各阶段实物众筹项目列表
    public function getFundingProducts($numberOfProjects='6',$where=array('status' => 9, 'stage'=> array('between',array('1','2'))),$order='stage desc,create_time desc') {
        
    	$proinfo = M('Product')->where($where)->order($order)->limit($numberOfProjects)->select();

    	foreach($proinfo as $k=>$v){
    		
    		$comment_count = M('ProductComment')->where(array('project_id'=>$v['id']))->count();
    		
    		$proinfo[$k]['comment_count'] =$comment_count;

    	}
    	
    	return $proinfo;
    }

    //获取各阶段实物众筹项目列表附加统计信息
    public function getFundingProductsInfo($numberOfProjects='6',$where=array('status' => 9, 'stage'=> array('between',array('1','2'))),$order='stage desc,create_time desc') {
        $products = M('Product')->where($where)->order($order)->limit($numberOfProjects)->select();
        foreach($products as &$product){
            $product['supportCount'] = M('product_price')->where(array('pid'=>$product['id']))->sum('sell_count');
            $product['finish_rate'] = round(($product['finish_amount']/$product['amount'])*100);
        }
        return $products;
    }
    //获取为实物众筹项目列表附加统计信息
    public function addProductsFundInfo(&$products){
        foreach($products as &$product){
            $product['supportCount'] = M('product_price')->where(array('pid'=>$product['id']))->sum('sell_count');
            $product['finish_rate'] = round(($product['finish_amount']/$product['amount'])*100);

        }
    }

    //增加每个实物众筹参与者的总数的统计信息
    public function addProductsInvestorCount(&$products){
        foreach($products as &$product){
            $product['supportCount'] = M('product_price')->where(array('pid'=>$product['id']))->sum('sell_count');
        }
        return $products;
    }
    
    //获取所有的评价内容
    public function getDetailComments($id,$firstRow,$listRows){
    
    	return M('ProductComments')->order('create_time desc')->where(array('project_id'=>$id))->limit($firstRow.','.$listRows)->select();
    }
}
?>