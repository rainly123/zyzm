<?php 
namespace Home\Model;
use Think\Model\ViewModel;
class AccountInvestViewModel extends ViewModel {
	public $viewFields = array(
		'AccountInvest' => array('id', 'uid','pid', 'amount','bussflowno', '_as'=>'ai','_type' => 'left'),
		'AccountProject' => array('productid', '_as'=>'ap', '_on'=>'ai.pid=ap.pid','_type' => 'left'),
		'AccountUser' => array('outuserid',  '_as' =>'au', '_on'=>'au.uid=ai.uid'),
	);

}
?>