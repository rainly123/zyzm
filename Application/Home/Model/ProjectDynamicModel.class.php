<?php 
namespace Home\Model;
use Think\Model;

Class ProjectDynamicModel extends Model {

	public function addDynamic($project_id, $describe, $type = 0) {
		$dynaminc = array('project_id' => $project_id, 
				'describe'=>$describe, 
				'type' => $type,
				'create_time'=>NOW_TIME, 
				'create_id' => is_login(),
				'update_time' => NOW_TIME,
				'update_id' => is_login());

		$this->add($dynaminc);
	}	
}
 ?>