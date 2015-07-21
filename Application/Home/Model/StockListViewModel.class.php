<?php 
namespace Home\Model;
use Think\Model\ViewModel;

class StockListViewModel extends ViewModel {
	public $viewFields = array(
		'stock_account_flow'=> array('id','uid', 'type', 'amount', 'state','status','create_time','remarks','operation_fund','assets', '_as'=> 'i', '_type'=>'left'),
		'stock' => array('id'=>'sid','name', '_as'=>'s', '_on'=> 'i.pid = s.id')
	);
}
?>