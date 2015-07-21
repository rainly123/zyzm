<?php 
namespace Admin\Model;
use Think\Model\ViewModel;
class StockAccountFlowViewModel extends ViewModel {
	public $viewFields = array(
			'StockAccountFlow'=>array('id', 'uid', 'type', 'amount', 'assets', 'remarks',
				'pid', 'operation_fund', 'create_time', 'update_time', '_as'=> 'f', '_type'=>'left'),
			'UsersDetail'=>array('name'=>'username', 'phone', '_as'=>'u', '_on'=>'u.id=f.uid'),
		);
}
?>