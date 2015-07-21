<?php 
namespace Admin\Model;
use Think\Model\ViewModel;
class AccountViewModel extends ViewModel {
	public $viewFields = array(
			'AccountUser'=>array('id', 'uid', 'balance', 'use_able', 
				'create_time', '_as'=> 'au', '_type'=>'left'),
			'UsersDetail'=>array('name', 'phone', '_as'=>'u', '_on'=>'u.id=au.uid')
		);
}
?>