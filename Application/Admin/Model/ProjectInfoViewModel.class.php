<?php 
namespace Admin\Model;
use Think\Model\ViewModel;

class ProjectInfoViewModel extends ViewModel {
		public $viewFields = array(
			'Project'=>array('id', 'industry', 'project_name', 'uid', 'cover', 'create_time', 'stage', '_as'=> 'p', '_type'=>'left'),
			'ProjectFund'=>array('follow_fund', 'need_fund', 'has_fund', '_as'=>'pf', '_on'=>'pf.project_id=p.id', '_type'=>'left'),
			'ProjectInfo'=>array('description', '_as'=>'pi', '_on'=>'pi.project_id=p.id', '_type'=>'left'),
			'ProjectInvestor'=>array('count(investor_id)'=>'follow', '_as'=>'pu' , '_on'=>'pu.project_id = p.id and pu.status >= 4'),
		);
}
?>