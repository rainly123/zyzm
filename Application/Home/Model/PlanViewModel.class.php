<?php 
namespace Home\Model;
use Think\Model\ViewModel;
class PlanViewModel extends ViewModel {
	public $viewFields = array(
		'Plan' => array('id', 'status', '_as'=>'p','_type' => 'left'),
		'PlanList' => array('shareid','sharename','price','purchasedate','releasedate','real_count','real_amount','rate', '_as'=>'pl', '_on'=>'p.id=pl.pid'),
	);

}
?>