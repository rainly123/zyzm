<?php 
namespace Home\Model;
use Think\Model\ViewModel;

Class ProjectInvestorViewModel extends ViewModel {

	public $viewFields = array(
			'project' => array('id', 'project_name','cover','stage',  '_as' =>'p','_type' => 'inner'),
			'project_investor' => array('id'=>'investorid', 'others', 'project_valuation','refuse_reason','investor_id','fund','create_time','lead_type','status',  '_as' =>'investor', '_on'=>'p.id=investor.project_id', '_type' => 'left'),
			'project_fund' => array('need_fund', 'has_fund','_on'=>'p.id=project_fund.project_id', '_type' => 'left'),
			'users' => array('nickname', '_as' =>'u','_type' => 'left', '_on'=>'investor.investor_id=u.id'),
			'picture' => array('path', '_as' =>'picture', '_on'=>'picture.id=p.cover'),
	);
}
?>