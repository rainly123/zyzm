<?php 
namespace Home\Model;
use Think\Model\ViewModel;
class ProductPriceViewModel extends ViewModel {
	public $viewFields = array(
		'ProductPrice' => array('price_type', 'amount','is_share','share_limit', '_as'=>'pp','_type' => 'inner'),
		'Custom' => array('post_amount','id'=>'customId','status','luckno','shareno','uid','create_time', '_as'=>'c', '_on'=>'pp.id=c.price_id','_type' => 'inner'),
		'Product' => array('start_time','home_img','stage', 'name','id','finish_amount','amount'=>'required_amount','days',  '_as' =>'p', '_on'=>'pp.pid=p.id'),
	);

}
?>
