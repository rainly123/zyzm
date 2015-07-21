<?php 
namespace Home\Model;
use Think\Model\ViewModel;

Class ProjLeaderViewModel extends ViewModel{
	public $viewFields = array(
		'ProjLeader' => array('id', 'pid','uid', 'fund', 'message', 'status', 'create_time', '_as' =>'leader'),
		'ProjectFund' => array( 'need_fund', 'status'=>'acc_status', '_as'=>'f', '_on'=>'leader.pid=f.project_id'),
		'Project' => array('project_name','cover','uid'=>'founder', 'stage', 'type',  '_as' =>'p', '_on'=>'p.id=leader.pid','_type' => 'left'),
		'UsersDetail' => array('name'=>'real_name', 'phone', '_as' =>'ud', '_on'=>'ud.id=leader.uid'),
	);
}
?>