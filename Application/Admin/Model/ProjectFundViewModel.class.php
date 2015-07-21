<?php 
namespace Admin\Model;
use Think\Model\ViewModel;

Class ProjectFundViewModel extends ViewModel {

	public $viewFields = array(
			'project' => array('id', 'project_name','cover', 'stage', 'company_name', 'uid','type', 'vote_leader', 'agreement', '_as' =>'p','_type' => 'left'),
			'project_fund' => array('need_fund', 'has_fund','extra', 'leader_id', 'agree_fund', 'project_valuation', 'final_valuation', 'follow_fund','status'=>'acc_status',  '_as' =>'fund','_on'=>'p.id=fund.project_id','_type' => 'left'),
			'picture' => array('path', '_as' =>'picture', '_on'=>'picture.id=p.cover'),
	);
}
?>