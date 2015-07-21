<?php 
namespace Home\Model;
use Think\Model\ViewModel;

class StockViewModel extends ViewModel {
	public $viewFields = array(
		'stock_account'=> array('id', 'pid', 'uid', 'amount','operation_fund','fund','over','waiting_fund','create_time', '_as'=> 'i', '_type'=>'left'),
		'stock' => array('id'=>'sid','type', 'name','logo','mobile_logo','assets','status', '_as'=>'s', '_on'=> 'i.pid = s.id')
	);
}
?>