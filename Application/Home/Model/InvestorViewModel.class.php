<?php 
namespace Home\Model;
use Think\Model\ViewModel;

Class InvestorViewModel extends ViewModel{
	public $viewFields = array(
		'ProjectInvestor' => array('id', 'project_id','refuse_reason',
			'investor_id', 'fund', 'project_valuation', 'create_time','lead_type','status',  '_as' =>'investor'),
		'ProjectFund' => array('final_valuation', 'has_fund', 'need_fund', 'status'=>'acc_status', '_as'=>'f', '_on'=>'investor.project_id=f.project_id'),
		'Project' => array('project_name','cover','uid', 'stage', 'type',  '_as' =>'p', '_on'=>'p.id=investor.project_id','_type' => 'left'),
		'Picture' => array('path', '_as' =>'picture', '_on'=>'picture.id=p.cover'),
	);
}
?>