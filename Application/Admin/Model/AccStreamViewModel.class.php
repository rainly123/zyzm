<?php 
namespace Admin\Model;
use Think\Model\ViewModel;
class AccStreamViewModel extends ViewModel {
	public $viewFields = array(
			'AccStream'=>array('id', 'uid', 'type', 'amount', 'remarks', 
				'state', 'create_time', 'bank_id', '_as'=> 'acc', '_type'=>'left'),
			'UsersDetail'=>array('name', 'phone', '_as'=>'u', '_on'=>'u.id=acc.uid', '_type'=>'left'),
			'UserBank'=>array('bank_name', 'province', 'city', 'sub_bank', 'cardno' , '_as'=>'ub', '_on'=>'ub.id=acc.bank_id'),
		);
}
?>