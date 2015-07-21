<?php 
namespace Home\Model;
use Think\Model\ViewModel;

Class FounderViewModel extends ViewModel {

	public $viewFields = array(
			'project' => array('id', 'project_name','cover','uid', 'type',  '_as' =>'p','_type' => 'left'),
			'project_investor' => array('id'=>'investorid','fund','refuse_reason', 'others','investor_id','project_valuation','create_time','lead_type','status',  '_as' =>'investor', '_on'=>'p.id=investor.project_id', '_type' => 'left'),
			'picture' => array('path', '_as' =>'picture', '_on'=>'picture.id=p.cover'),
	);
}
?>