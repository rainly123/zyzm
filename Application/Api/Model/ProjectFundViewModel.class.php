<?php 
namespace Api\Model;
use Think\Model\ViewModel;

Class ProjectFundViewModel extends ViewModel {

	public $viewFields = array(
			'project' => array('id', 'project_name','cover', 'stage', 'province', 'city', 
				'company_name', 'uid','abstract','type', 'vote_leader', 'agreement', 'status', 
				'update_time', '_as' =>'p','_type' => 'left'),
			'project_fund' => array('need_fund', 'has_fund','extra', 'leader_id', 
				'agree_fund', 'project_valuation', 'final_valuation', 
				'follow_fund',  '_as' =>'fund', 
				'_on'=>'p.id=fund.project_id','_type' => 'left'),
			'project_info'=> array('description', 'plan', 'custom', 'yingli_mode', 
				'avantages', '_as'=>'pi', '_on'=>'pi.project_id=p.id', '_type'=>'left'),
			'picture' => array('path' => 'project_cover', '_as' =>'picture', '_on'=>'picture.id=p.cover', '_type'=>'left'),
			// 'district' => array('name'=>'province_name', '_as'=>'dp', '_on'=>'dp.id=p.province', '_type'=>'left'),
			// 'district' => array('name'=>'city_name', '_as'=>'dc', '_on'=>'dc.id=p.city', '_type'=>'left'),
	);


	public function getbaseinfo($pid) {
		$data = $this->where(array('p.id'=>$pid))->field(
			array('id', 'project_name', 'stage', 'need_fund', 'agree_fund'))->find();
		return $data;
	}

	/**
	 * 获取项目列表信息
	 */
	public function getbaselist($page, $roll = 10) {
		$total = $this->where(array('p.stage'=>4, 'p.status'=>9))->count();
		if (!empty($page)) {
			$start = ($page - 1) * $roll;

			$data = $this->where(array('p.stage'=>4, 'p.status'=>9))->field(
			array('id', 'project_name', 'province', 'city', 'project_cover', 
				'need_fund', 'agree_fund', 'abstract', 'extra', 'follow_fund'))->limit($start, $roll)->order('update_time')->select();
		} else {
			$data = $this->where(array('stage'=>4, 'status'=>9))->field(
			array('id', 'project_name', 'province', 'city', 'project_cover', 
				'need_fund', 'agree_fund'))->order('update_time')->select();
		}

		foreach ($data as $k => &$v) {
			$v['province_name'] = getDistrict($v['province']);
			$v['city_name'] = getDistrict($v['city']);
			$v['rate']= round($v['agree_fund'] / $v['need_fund'] * 100);
			$v['project_cover'] = empty($v['project_cover']) ? '': 'http://www.dreammove.cn' . $v['project_cover'];
			unset($v['province']);
			unset($v['city']);
		}

		$ret = array('total'=>intval($total), 'data'=>$data);

		return $ret;
	}


	/**
	 * 获取项目详细信息
	 * @param 	$id 		项目编号
	 * @return 	false 未找到相关项目
	 * 					项目详细信息
	 */
	public function getdetail($id) {
		$project = $this->where(array('id'=>$id, 'status'=>9))->find();
		if (empty($project)) {return false;}
		$team = M('ProjectTeam')->join('jm_picture on jm_picture.id = jm_project_team.header_img', 'left')->where(
			array('project_id'=>$id, 'jm_project_team.status'=>0))->field(
			array('name', 'postion', 'about', 'path'=>'header_img'))->order('sort')->select();

		$pics = M('ProjectTemp')->join('jm_picture on jm_picture.id = jm_project_temp.info_key', 'left')->field(array('path'=>'image_path'))->where(array('project_id'=>$id, 'temp_type'=>1))->select();
		
		// 项目信息图片完善
		$project['project_cover'] = 'http://www.dreammove.cn'.$project['project_cover'];
		$project['description'] = str_replace('"/Uploads/', '"http://www.dreammove.cn/Uploads/', $project['description']);
		$project['plan'] = str_replace('"/Uploads/', '"http://www.dreammove.cn/Uploads/', $project['plan']);
		$project['custom'] = str_replace('"/Uploads/', '"http://www.dreammove.cn/Uploads/', $project['custom']);
		$project['yingli_mode'] = str_replace('"/Uploads/', '"http://www.dreammove.cn/Uploads/', $project['yingli_mode']);
		$project['avantages'] = str_replace('"/Uploads/', '"http://www.dreammove.cn/Uploads/', $project['avantages']);
		$project['province_name'] = getDistrict($project['province']);
		$project['city_name'] = getDistrict($project['city']);
		$project['founder_name'] = get_membername($project['uid']);
		$project['leader_name'] = get_membername($project['leader_id']);
		$data['project'] = $project;

		unset($data['project']['province']);
		unset($data['project']['city']);
		unset($data['project']['status']);
		unset($data['project']['cover']);
		unset($data['project']['vote_leader']);
		unset($data['project']['agreement']);
		unset($data['project']['project_valuation']);
		unset($data['project']['update_time']);
		unset($data['project']['agree_fund']);
		unset($data['project']['uid']);
		unset($data['project']['leader_id']);
		unset($data['project']['type']);

		// 团队成员头像完善
		foreach ($team as $k => $v) {
			if (!empty($v['header_img'])) {
				$v['header_img'] = 'http://www.dreammove.cn' . $v['header_img'];
			}
			$v['position'] = $v['postion'];
			$data['team'][] = $v;
		}
		foreach ($pics as $k => $v) {
			if (!empty($v['image_path'])) {
				$v['image_path'] = 'http://www.dreammove.cn' . $v['image_path'];
			}
			$data['pics'][] = $v;
		}

		return $data;
	}
}
?>