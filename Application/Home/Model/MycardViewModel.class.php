<?php 
namespace Home\Model;
use Think\Model\ViewModel;

Class MycardViewModel extends ViewModel {

	public $viewFields = array(
		'QuickcardList' => array('id','cardno', 'bankno','banknm', 'cardtype', 
			'storablecardno', '_as' =>'q','_type' => 'left'),
		'BankInfo' => array('normal_logo', 'normal_code', 'logo', 
			'quick_remark' ,  '_as' =>'b','_on'=>'q.bankno=b.bank_code'),
	);
}
?>