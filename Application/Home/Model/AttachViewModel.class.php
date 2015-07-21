<?php 
namespace Home\Model;
use Think\Model\ViewModel;

class AttachViewModel extends ViewModel {
	public $viewFields = array(
		'project'=> array('id', 'project_name', 'cover', 'uid','create_time', '_as'=> 'p', '_type'=>'left'),
		'project_fund' => array('need_fund', 'has_fund','_on'=>'p.id=project_fund.project_id', '_type'=>'left'),
		'project_attach' => array('investor_id', 'attach_time', '_as'=>'a', '_on'=> 'p.id = a.project_id and a.status = 1')
	);
}
?>