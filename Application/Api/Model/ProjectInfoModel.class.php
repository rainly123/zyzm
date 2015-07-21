<?php 
namespace Api\Model;
use Think\Model;
Class ProjectInfoModel extends Model{
	Protected $autoCheckFields = false;
	public function checkscope($path,$scope){
		$rulenumber = M('AuthRule')->where(array('name' =>$path,'module'=>'api'))->getField('id');//rule number
	    $rules = M('AuthGroup')->where(array('id' =>$scope))->getField('rules');//rule number
		$ruleArray = explode(",", $rules);
		return in_array($rulenumber,$ruleArray);
	}
	public function getprojectstatis(){
		$pid=$_GET['id'];
		$projectModel = new  \Home\Model\ProjectModel();
		if(!$pid){
			return null;
		}
		$project = $projectModel->getProvedProjectStatis($pid);
		return $this->reformatStatisData($project);
	}
	public function getproject() {
		$pid=$_GET['id'];
		$projectModel = new  \Home\Model\ProjectModel();
		if(!$pid){
			return null;
		}
		$project = $projectModel->getProvedProjectInfo($pid);
		return $this->reformatData($project);
	}
	public function getlist(){
		$stage=$_GET['stage'];
		$projectModel = new  \Home\Model\ProjectModel();
		if($stage==null){
			$allProjects =  array_merge($projectModel->getFundingProjects(),$projectModel->getAllSuccessedProjectsInfo());
		}else{
			switch($stage){//项目阶段[1:预热、2:合投、3:成功]
				case 1:
					$allProjects = $projectModel->getAllWarmupProjectsInfo();break;
				case 2:
					$allProjects = $projectModel->getAllFundingProjectsInfo();break;
				case 3:
					$allProjects = $projectModel->getAllSuccessedProjectsInfo();break;
			}
			
		}
		$index =0;
		foreach($allProjects as $project){
		    $data[$index]= $this->reformatData($project);
			$index++;
		}
		return $data;
	}

	function reformatData($project){
		$data['project_index'] = $project['id'];//项目编号
		$data['project_name'] = $project['project_name'];//项目名称
		$data['project_stage'] = $this->stageConvertor($project['stage']);//项目阶段
		$data['project_type'] = get_code_name($project['industry']);//项目类型
		$data['project_abstract'] = $project['abstract'];//项目简介
		$data['project_cover'] = 'http://'.$_SERVER['HTTP_HOST'].get_cover( $project['cover'],'path');;//封面url
		$data['project_province'] = getDistrict($project['province']);//省
		$data['project_city'] = getDistrict($project['city']);//市
		$data['project_companyname'] = $project['company_name'];//公司名称
		$data['project_leader'] = get_membername($project['leader_id']);//项目发起人
		$data['project_financinglimit'] = $project['need_fund'];//目标融资额
		if($data['project_stage']==1){
			$data['project_valuation'] =0;//项目最终估值
		}else{
			$data['project_valuation'] = M('ProjectFund')->where(array('project_id' =>  $project['id']))->getField('final_valuation');//项目最终估值
		}
			
		$data['project_mininvestment'] = $project['follow_fund'];//起投额
		$data['project_raisedfund'] = $project['has_fund'];//完成金额
		$data['project_investornumber'] = $project['investor_count'];//投资人数
		$data['project_detailurl'] = 'http://'.$_SERVER['HTTP_HOST'].'/project/detail/id/'.$project['id'];//项目url
		$data['project_details'] = M('ProjectInfo')->where(array('project_id' =>  $project['id']))->getField('description');//项目详细详情
		$data['project_details'] = str_replace('"/Uploads','"http://'.$_SERVER['HTTP_HOST']."/Uploads/",$data['project_details']);
		if($project['team']){$data['project_team'] = $project['team'];}
		return $data;
		
	}
	
	function reformatStatisData($project){
		$data['project_index'] = $project['id'];//项目编号
		$data['project_investornumber'] = $project['investor_count'];//投资人数
		$data['project_raisedfund'] = $project['has_fund'];//完成金额
		$data['project_stage'] = $this->stageConvertor($project['stage']);//项目阶段
		return $data;
	}
	
	function stageConvertor($stage){
		switch((int)$stage){
			case 1:
				return 1;
			case 4:
				return 2;
			case 9:
				return 3;
			default:
				return 0;
		}
	}
}