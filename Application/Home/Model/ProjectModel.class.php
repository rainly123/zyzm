<?php 
namespace Home\Model;
use Think\Model;
Class ProjectModel extends Model{
	
	const STAGE_NORMAL          =   1;      // 项目融资阶段-普通（预热）
	const STAGE_FUND           	=   2;      // 项目融资阶段-认投
	const STAGE_RAPID           =   4;      // 项目融资阶段-快速合投
	const STAGE_FINISH			=	9;						// 项目融资阶段-完成
	
	/* 用户模型自动完成 */
	protected $_auto = array(
			array('project_name','htmlspecialchars' ,self::MODEL_BOTH, 'function'),
			array('abstract','htmlspecialchars' ,self::MODEL_BOTH, 'function'),
			array('address','htmlspecialchars' ,self::MODEL_BOTH, 'function'),
			array('create_time', NOW_TIME , self::MODEL_INSERT),
			array('create_id', 'is_login', self::MODEL_INSERT, 'function'),
			array('update_time', NOW_TIME, self::MODEL_BOTH),
			array('update_id', 'is_login', self::MODEL_BOTH, 'function'),
			array('uid', 'is_login', self::MODEL_INSERT, 'function'),
		);

	protected $_validate = array(
			array('industry', 'require', '请选择所属行业', self::MUST_VALIDATE),
			array('project_name', 'require', '请填写项目名称', self::MUST_VALIDATE),
			array('project_name', '1,30','项目名称不能超过30个字', self::MUST_VALIDATE, 'length'),
			array('abstract', '1,100', '一句话描述不能超过100个字', self::VALUE_VALIDATE, 'length'),
			array('project_phase', 'require', '请选择项目阶段', self::MUST_VALIDATE),
			array('member_count', 'number', '团队人数只能填写数字', self::MUST_VALIDATE),
			array('member_count', 'number','团队人数不能超过1000000人', self::MUST_VALIDATE),
			array('province', 'require', '请选择所在省', self::MUST_VALIDATE),
			array('city', 'require', '请选择所在市', self::MUST_VALIDATE),	
			array('cover', 'require', '请上传项目封面', self::MUST_VALIDATE),
		);

    //获取项目的基本属性
    public function getProjectInfo($id)
    {
       return M('Project')->find($id);
    }

    public function getProjectFundInfo($id)
    {
        return M('ProjectFund')->where(array('project_id' => $id))->find();
    }
    public function getProjectScoresInfo($id)
    {//获取当前项目的综合评分
        $scores = M('projects_score')->where(array('project_id' => $id))->select();
        $averageScore = array();

        foreach($scores as $score){
            $averageScore['group'] = $averageScore['group']+ $score['group'];
            $averageScore['market'] = $averageScore['market']+ $score['market'];
            $averageScore['creative'] = $averageScore['creative']+ $score['creative'];
            $averageScore['profitablity'] = $averageScore['profitablity']+ $score['profitablity'];
            $averageScore['evaluation'] = $averageScore['evaluation']+ $score['evaluation'];
        }
        $averageScore['group']= round($averageScore['group']/count($scores));
        $averageScore['market']= round($averageScore['market']/count($scores));
        $averageScore['creative']= round($averageScore['creative']/count($scores));
        $averageScore['profitablity']= round($averageScore['profitablity']/count($scores));
        $averageScore['evaluation']= round($averageScore['evaluation']/count($scores));
        return $averageScore;
    }
    public function getUserScoresInfo($id)
    {//获取当前用户的历史评分
        $userID = is_login();
        if($userID>0){
            $scores = M('projects_score')->where(array('project_id' => $id,'user_id'=>$userID))->field('group,market,creative,profitablity,evaluation')->find();
            return $scores;
        }
        return null;
    }
    //This method must be used after get the project and get the investor
    //TODO:This method should be improved later
    public function getProjectLeaderInfo($id){
        $project['project'] = M('Project')->find($id);
        $project['investor'] = M('ProjectInvestor')->where(array('project_id'=>$id, 'status'=>array('egt',2)))->order('lead_type desc, create_time')->select();
        if ($project['project']['vote_leader'] < 2) {
            // 项目领投人（项目候选领投人）
            $project['leader'] = M('ProjectLeader')->where(array('project_id'=>$id))->order('lead_type desc, create_time')->select();
            foreach ($project['leader'] as $key => $v) {
                $investor_info = array();
                foreach ($project['investor'] as $k => $value) {

                    if ($value['investor_id'] == $v['leader_id']) {
                        $investor_info = $value;
                    }
                }
                $project['leader'][$key] = array_merge($v, $investor_info);
            }
        } else {
            $leader = M('ProjectLeader')->where(array('project_id'=>$id, 'lead_type'=>9))->find();
            $project['leader'] = $leader;
            foreach ($project['investor'] as $key => $v) {
                if ($v['investor_id'] == $leader['leader_id']) {
                    $project['leader'] = array_merge($project['leader'], $v);
                    break;
                }
            }
        }
        return $project['leader'];
    }
    public function getDetailComments($id,$firstRow,$listRows){

        return M('CommentReply')->order('create_time desc')->where(array('project_id'=>$id))->limit($firstRow.','.$listRows)->select();
    }
	// 取得项目详情
	public function getdetail($id) {
		$project = array();
		// 项目信息	
		$project['project'] = M('Project')->find($id);

		// 项目文件（幻灯片，视频）
		$project['temp'] = M('ProjectTemp')->field('info_key, temp_type')->
			where(array('project_id' => $id))->order('temp_type, sort')->select();
		// 项目基本信息
		$project['info'] = M('ProjectInfo')->where(array('project_id' => $id))->find();
		// 项目大事记
		$project['event'] = M('ProjectEvent')->
			where(array('project_id' => $id))->order('`when` desc')->select();
		// 项目团队
		$project['team'] = M('ProjectTeam')->
			where(array('project_id' => $id))->order('member_type')->order('sort')->select();
		// 项目融资信息
		$project['fund'] = M('ProjectFund')->where(array('project_id' => $id))->find();
        // 项目打分信息
        $scores = M('projects_score')->where(array('project_id' => $id))->select();
        $averageScore = array();

        foreach($scores as $score){
            $averageScore['group'] = $averageScore['group']+ $score['group'];
            $averageScore['market'] = $averageScore['market']+ $score['market'];
            $averageScore['creative'] = $averageScore['creative']+ $score['creative'];
            $averageScore['profitablity'] = $averageScore['profitablity']+ $score['profitablity'];
            $averageScore['evaluation'] = $averageScore['evaluation']+ $score['evaluation'];
        }
        $averageScore['group']= round($averageScore['group']/count($scores));
        $averageScore['market']= round($averageScore['market']/count($scores));
        $averageScore['creative']= round($averageScore['creative']/count($scores));
        $averageScore['profitablity']= round($averageScore['profitablity']/count($scores));
        $averageScore['evaluation']= round($averageScore['evaluation']/count($scores));
        $project['averageScores'] = $averageScore;

		if (isset($project['fund']['final_valuation']) && $project['fund']['final_valuation'] != 0){
					$project['fund']['rate_fund'] = round($project['fund']['need_fund'] / $project['fund']['final_valuation'] * 100,2);
				}
		// 项目投资人信息
		$project['investor'] = M('ProjectInvestor')->where(array('project_id'=>$id, 'status'=>array('egt',2)))->order('lead_type desc, create_time')->select();
		// 项目评论


		$attach = M('ProjectAttach')->where(array('project_id'=>$id, 'investor_id'=>is_login(), 'status'=>1))->find();
        $attachCount = M('ProjectAttach')->where(array('project_id'=>$id, 'status'=>1))->count();
		$project['project']['attach_status'] = $attach ? 0 : 1;
        $project['project']['attach_count'] = $attachCount;

        $project['fund']['scale'] = round($project['fund']['has_fund']/$project['fund']['need_fund'], 2) * 100;

		// 提取视频地址
		foreach ($project['temp'] as $key => $v) {
			if ($v['temp_type'] == 0) {
				$project["video"] = $v['info_key'];
				unset($project['temp'][$key]);
			}
		}

		$project['attach'] = M('ProjectAttach')->where(array('project_id'=>$id, 'status'=>1))->order('attach_time desc')->select();

		//项目动态
		//获取项目动态
		$project['dynamic'] = M('project_dynamic')->where(array('project_id'=>$id, 'status'=>0))->order('create_time desc')->select();
		$pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/";
		
		foreach ($project['dynamic'] as $k => $dynamic) {
			
			$content = trim(strip_tags($dynamic['content']));
			
			if (mb_strlen($content,"utf-8") <100){
				
				$project['dynamic'][$k]['content']=$content;
			}else{
				$project['dynamic'][$k]['content']= msubstr($content,0,100,"utf-8");
			}
				
			$ret = preg_match_all($pattern,$dynamic['content'],$match);

			if ($ret) {
				$project['dynamic'][$k]['img'] =$match[1][0];
			}

		}

		// 候选领投人
		if ($project['project']['vote_leader'] < 2) {
			// 项目领投人（项目候选领投人）
			$project['leader'] = M('ProjectLeader')->where(array('project_id'=>$id))->order('lead_type desc, create_time')->select();
			foreach ($project['leader'] as $key => $v) {
				$investor_info = array();
				foreach ($project['investor'] as $k => $value) {

					if ($value['investor_id'] == $v['leader_id']) {
						$investor_info = $value;
					}
				}
				$project['leader'][$key] = array_merge($v, $investor_info);
			}
		} else {
			$leader = M('ProjectLeader')->where(array('project_id'=>$id, 'lead_type'=>9))->find();
			$project['leader'] = $leader;
			foreach ($project['investor'] as $key => $v) {
				if ($v['investor_id'] == $leader['leader_id']) {
					$project['leader'] = array_merge($project['leader'], $v);
					break;
				}
			}
		}

		return $project;
	}
    public function getComments($id,$limit=null){

        return M('CommentReply')->order('create_time desc')->where(array('project_id'=>$id))->limit($limit)->select();
    }

    public function getDynamicCommentsCount($id,$dynamicid){

        return M('CommentReply')->where(array('project_id'=>$id,'dynamicid'=>$dynamicid))->count();
    }
	// 查询首页显示的，项目信息
	public function getProjectIndex() {
		$where = array('stage'=> 4);
		$project['rapid'] = M('ProjIndex')->where($where)->order('is_top desc, create_time desc')->limit(6)->select();
				
		$where['stage'] = self::STAGE_FUND;
		$project['fund'] = M('ProjIndex')->where($where)->order('is_top desc, create_time desc')->select();
		$where['stage'] = self::STAGE_NORMAL;
		$project['normal'] = M('ProjIndex')->where($where)->order('is_top desc, create_time desc')->select();
		$where['stage'] = self::STAGE_FINISH;
		$project['finish'] = M('ProjIndex')->where($where)->order('is_top desc, create_time desc')->limit(6)->select();
		//$where1 = array('stage' => array('lt', 8));
		//$project['hot_lists'] = M('ProjIndex')->where($where1)->order('like_record desc, read_record desc')->limit(6)->select();
		
		return $project;
	}

    public function addProjectStatis(&$project){
        $project['comment'] = M('CommentReply')->order('create_time desc')->where(array('project_id'=>$project['id']))->select();
        $project['com_count'] = count($project['comment']);
        $attach = M('ProjectAttach')->where(array('project_id'=>$project['id'], 'investor_id'=>is_login(), 'status'=>1))->find();
        $attachCount = M('ProjectAttach')->where(array('project_id'=>$project['id']))->count();
        $project['attach_status'] = $attach ? 0 : 1;
        $project['attach_count'] = $attachCount;
        $project['investor_count'] = M('ProjectInvestor')->where(array('project_id'=>$project['id'], 'status'=>array('egt',2)))->count();
    }

    public function getInvestorsInfo($id,$limit=null,$order='lead_type desc, create_time') {
        return M('ProjectInvestor')->where(array('project_id'=>$id, 'status'=>array('egt',2)))->order($order)->limit($limit)->select();
    }

    //为每个项目单独绑定 fund信息，优化数据，只用于首页列表显示
    public function addProjectsFundInfo(&$projects){
        foreach($projects as &$project){
            $project['fund'] = M('ProjectFund')->where(array('project_id' => $project['id']))->find();
        }
        return $projects;
    }

    //获取所有股权众筹项目列表
    public function getAllProvedProjectsInfo($stage=array('between',array('1','9')),$order='stage desc,create_time desc',$limit=null) {
        $where=array('status' => 9, 'stage'=> $stage );
        return array_merge($this->getAllFundingProjectsInfo(),$this->getAllWarmupProjectsInfo(),$this->getAllSuccessedProjectsInfo(),$this->getAllUnsucessedProjectsInfo());
        //return M('ProjIndex')->where($where)->order($order)->limit($limit)->select();
    }

    //获取首页显示的预热，合投阶段股权众筹项目
    public function getFundingProjects($numberOfProjects='6',$where=array('status' => 9, 'stage'=> array('between',array('1','4'))),$order='stage desc,is_top desc,create_time desc') {
        $data = M('ProjIndex')->where($where)->order($order)->limit($numberOfProjects)->select();
        if (!$data) {$data = array();}
        return $data;
    }

    //获取所有众筹中的股权众筹项目列表
    public function getAllFundingProjectsInfo($stage=4,$order='create_time desc',$limit=null) {
        $where=array('status' => 9, 'stage'=> $stage );
        $data = M('ProjIndex')->where($where)->order($order)->limit($limit)->select();
        if (!$data) {$data = array();}
        return $data;
    }

    //获取所有预热中的股权众筹项目列表
    public function getAllWarmupProjectsInfo($stage=1,$order='create_time desc',$limit=null) {
        $where=array('status' => 9, 'stage'=> $stage );
        $data = M('ProjIndex')->where($where)->order($order)->limit($limit)->select();
        if (!$data) {$data = array();}
        return $data;
    }

    //获取所有众筹成功的股权众筹项目列表
    public function getAllSuccessedProjectsInfo($stage=array('IN','8,9'),$order='create_time desc',$limit=null) {
        $where=array('status' => 9, 'stage'=> $stage );
        $data = M('ProjIndex')->where($where)->order($order)->limit($limit)->select();
        if (!$data) {$data = array();}
        return $data;
    }

    //获取所有众筹失败的股权众筹项目列表
    public function getAllUnsucessedProjectsInfo($stage=8,$order='create_time desc',$limit=null) {
        $where=array('status' => 9, 'stage'=> $stage );
        $data = M('ProjIndex')->where($where)->order($order)->limit($limit)->select();
        if (!$data) {$data = array();}
        return $data;
    }
    //获取审核过的项目的基本信息,为第三方服务
    public function getProvedProjectInfo($id)
    {
    	$where=array('status' => 9, 'stage'=> array('IN','1,4,9'),'id'=>$id);   
    	$project = M('ProjIndex')->where($where)->find($id);
    	$project['team'] = M('ProjectTeam')->where(array('project_id' => $id))->order('member_type')->order('sort')->field('name,postion,member_info,header_img')->select();
    	foreach($project['team']  as &$team){
    		$team['header_img']='http://'.$_SERVER['HTTP_HOST'].get_cover($team['header_img'],'path');
    	}
    	return $project;
    }
    //获取审核过的项目的统计信息,为第三方服务
    public function getProvedProjectStatis($id)
    {
    	$where=array('status' => 9, 'stage'=> array('IN','1,4,9'),'id'=>$id);
    	return M('ProjIndex')->where($where)->find($id);
    }
    
    public function checkAuth(){
    	if ($id == 2) {
    		$this->display('Tea/invest');
    		return;
    	}
    	$uid = is_login();
    	if (!$uid) {
    		$this->redirect('User/login');
    	}
    	$where = array('uid' => $uid, 'status' => 9, 'auth_id'=>1);
    	$auth = M('UserAuth')->where($where)->count();
    	$phone = M('UcenterMember')->find($uid);
    
    	if (!$auth) {
    		$data['success'] = false;
    		$data['info'] = '您还没有完成实名认证，完善后方可投资。';
    		return $data;
    	}elseif(empty($phone['mobile'])){
    		$data['success'] = false;
    		$data['info'] = '您还没有绑定手机，完善后方可投资。';
    		return $data;
    	}
    	$data['success'] = true;
    	$data['info'] = '已实名认证成功';
    	return $data;
    }
}
?>