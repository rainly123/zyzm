<?php 
namespace Admin\Model;
use Think\Model\ViewModel;

class ProjectViewModel extends ViewModel {
		public $viewFields = array(
			'Project'=>array('id', 'industry', 'project_name', 'uid', 'cover','province','city', 'create_time', 'stage','is_appointed','status','oid','mid', '_as'=> 'p', '_type'=>'left'),
			'UcenterMember'=>array('username', 'mobile', '_as'=>'u', '_on'=>'u.id=p.uid', '_type'=>'left'),
			'UsersDetail'=>array('name', '_as'=>'d', '_on'=>'u.id=d.id'),
		);
}
?>