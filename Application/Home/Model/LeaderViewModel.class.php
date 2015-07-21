<?php 
namespace Home\Model;
use Think\Model\ViewModel;

Class LeaderViewModel extends ViewModel {
	public $viewFields = array(
		'ProjectLeader' => array('id', 'project_id', 
			'leader_id', 'lead_type', 'vote_count', 
			'vote_fund', 'reason', 'project_comment', 
			'team_comment', 'report', '_as' =>'leader', "_type"=>"LEFT"),
		'ProjectInvestor' => array('fund', '_as'=>'investor', '_type' => "LEFT", 
			'_on' => 'leader.project_id = investor.project_id and leader.leader_id = investor.investor_id and investor.status >= 2'),
		'Users' => array('nickname', '_on' => 'leader.leader_id = Users.id', '_type'=>'LEFT'),
		'UsersDetail' => array('name', 'province', 'city', 'sex', 'resume', '_on'=> 'leader.leader_id = UsersDetail.id'),
		);
}
?>