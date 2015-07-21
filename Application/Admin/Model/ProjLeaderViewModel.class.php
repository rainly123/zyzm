<?php 
namespace Admin\Model;
use Think\Model\ViewModel;

class ProjLeaderViewModel extends ViewModel {
	public $viewFields = array(
		'ProjLeader'=>array('id', 'pid', 'uid', 'fund', 
			'message', 'status', 'create_time', '_as'=> 'pl', '_type'=>'left'),
		'Users'=>array('nickname', '_as'=>'u', '_on'=>'u.id=pl.uid'),
		'UsersDetail'=>array('name', 'phone', '_as'=>'d', '_on'=>'d.id=pl.uid')
	);
}

?>