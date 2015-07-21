<?php 
namespace Admin\Model;
use Think\Model\ViewModel;

class OutInvestorViewModel extends ViewModel {
	public $viewFields = array(
		'OutInvestor'=>array('id','uid' , 'pid', 'fund', 'real_name', 'phone', 'out_state', 'pay_flag', 'state', 'from_way', 'create_time', '_as'=>'oi', '_type'=>'left'), 
		'Project'=>array('project_name', '_as'=>'p', '_on'=>'oi.pid=p.id'));
}
?>