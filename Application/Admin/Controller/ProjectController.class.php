<?php 
namespace Admin\Controller;
class ProjectController extends AdminController {
	// 项目列表
	public function index() {
		$status = isset($_GET['status']) ? intval($_GET['status']) : 0;
		//用户ID
		$uid = is_login();
		//添加机构ID
		$oid = session('user_auth.oid');
		//项目列表
		if($status==0){
			$where=array('p.status' => array('gt', 0),'p.oid'=>$oid);
			$order = 'p.status, p.is_top desc';
			$p_title ='项目列表';
		}elseif($status==1){
			//未审核的项目
			$where=array('p.status' => array('eq', 1),'p.oid'=>$oid);
			$order = 'p.status, p.is_top desc';
			$p_title ='未审核的项目';
		}elseif($status==2){
			//已审核的项目
			$where=array('p.status' => array('eq', 9),'p.oid'=>$oid,'stage'=>array('eq',0));
			$order = 'p.status, p.is_top desc';
			$p_title ='已审核的项目';
		}elseif($status==3){
			//预热的项目
			$where=array('p.status' => array('eq', 9),'p.oid'=>$oid,'stage'=>array('eq',1));
			$order = 'p.status, p.is_top desc';
			$p_title ='预热的项目';
		}else{
			$where=array('p.status' => array('eq', -1),'p.oid'=>$oid);
			$order = 'p.status desc, p.is_top desc';
			$p_title ='审核不通过的项目';
			//$where=array('status' => array('gt', 0),'status' => array('lt', 9));
			//$where='status > 0 and status < 9';
		}
		
		//职位
		$position = session('user_auth.position');
		//1.员工
		if($position==1){
			$where = array_merge( array('p.mid' => $uid) ,(array)$where);
		}

		$list = D('ProjectView')->where($where)->order($order)->select();
		int_to_string($list, 
			array('status'=>array(-1=>'已删除',0=>'未提交',1=>'未审核',2=>'未通过',9=>'审核通过')));

		$this->_list = $list;
		$this->p_title = $p_title;
		$this->status = $status;
		$this->display();
	}
	
	//未指派项目列表
	public function appointed() {
		//获取未指派的项目
		$where=array('is_appointed'=>0,'status'=>array('egt',1));
		$order = 'create_time desc';
		
	
		$list = D('ProjectView')->where($where)->order($order)->select();
	
		$this->_list = $list;
		$this->display();
	}
	
	//指派项目负责人
	public function setmanager() {
		if(IS_GET) {

			$id = $_GET['id'];
			$project = M('Project')->where(array('id'=>$id))->
			field('id, project_name')->find();
			//获取所有机构
			$groupinfo = M('Group')->where(array('status'=>1))->select();
		
			$this->assign('info',$groupinfo);
			$this->project = $project;
			$this->display();
		} else {
			//项目ID
			$id = $_POST['id'];
			//机构ID
			$oid = $_POST['oid'];
			//项目经理
			$mid = $_POST['mid'];
			
			if(empty($oid)){
				$this->error('请指定所属机构');
			}
			if(empty($mid)){
				$this->error('请指定项目经理');
			}

			$user = M('Member')->find($mid);
			if (!$user) {
				$this->error('指定用户不存在。');
			}
	
			//更新
			$data = array('oid'=>$oid, 'mid'=>$mid,'is_appointed'=>1, 'update_time'=>NOW_TIME);
			
			M('Project')->where(array('id'=>$id))->save($data);
			

			$this->success('操作成功');
		}
	}
	
	//获取当前机构的管理员列表
	public function getManagerList(){
		if (IS_AJAX){
			//机构ID
			$pid = I('pid');
	
			//获取员工列表
			$list = M('Member')->where(array('oid'=>$pid,'status'=>1,'real_name'=>array('neq','')))->select();

			$data = "<option value =''>请选择项目经理</option>";
			foreach ($list as $k => $vo) {
				$data .= "<option ";
				$data .= " value ='" . $vo['uid'] . "'>" . $vo['real_name'] . "</option>";
			}
			$this->ajaxReturn($data);
		}
	}
	
	
	// 项目审核页
	public function preview($id,$step=1) {
		if (empty($id)) {
			$this->error('此项目不存在');
		}
		$projectBase = M('Project')->where(array('id'=>$id))->find();
		$projectBase['industry'] = get_code_name($projectBase['industry']);

		if (empty($projectBase)) {
			$this->error('此项目不存在');
		}
		switch ($step) {
			case 1:
				$userinfo = M('UcenterMember')->find($projectBase['uid']);
				$projectBase['link_man'] = $userinfo['mobile'];
				$this->assign($projectBase);
				$this->display('preview_step1');
				break;
			case 2:
				$projectInfo = M('ProjectInfo')->where(array('project_id'=>$id))->find();
				$projectEvent = M('ProjectEvent')->where(array('project_id'=>$id))->select();
				$this->assign($projectInfo);
				$this->assign('projectEvent',$projectEvent);
				$this->display('preview_step2');
				break;
			case 3:
				$projectTeam = M('ProjectTeam')->where(array('project_id'=>$id))->order('sort')->select();
				$this->assign('projectTeam',$projectTeam);
				$this->display('preview_step3');
				break;
			case 4:
				$projectTemp = M('ProjectTemp')->where(array('project_id'=>$id))->select();
				$this->assign('projectTemp',$projectTemp);
				$this->display('preview_step4');
				break;
			case 5:
				$projectFund = M('ProjectFund')->where(array('project_id'=>$id))->find();
			// print_r($projectFund);exit();
				$this->assign($projectFund);
				$this->display('preview_step5');
				break;
		}

	}

	public function setleader() {
		if(IS_GET) {
			$id = $_GET['id'];
			$project = M('Project')->where(array('id'=>$id))->
				field('id, project_name')->find();
			$this->project = $project;
			$this->display();
		} else {
			$id = $_POST['id'];
			$user = M('Users')->where(array('nickname'=>$_POST['username']))->find();
			if (!$user) {
				$this->error('指定用户不存在。');
			}

			// 候选领投人->投资人
			M('ProjectInvestor')->where(array('project_id'=>$id, 'status'=>array('gt', 0),
				'investor_id'=>array('neq', $user['id']), 'lead_type'=>2))->save(
				array('lead_type'=>3));
			// 候选领投人->领投人
			M('ProjectInvestor')->where(array('project_id'=>$id, 'lead_type'=>2,
				'investor_id'=>$user['id'], 'status'=>array('gt', 0), 'lead_type'=>2))->save(
				array('lead_type'=>9));
			// 候选领投人->领投人
			M('ProjLeader')->where(array('pid'=>$id, 'uid'=>$user['id'], 
				'status'=>0, 'del_flag'=>0))->save(array('status'=>1));
			// 候选领投人->拒绝
			M('ProjLeader')->where(array('pid'=>$id, 'uid'=>$user['id'], 
				'status'=>0, 'del_flag'=>0))->save(array('status'=>2));

			M('ProjectFund')->where(array('project_id'=>$id))->
				save(array('leader_id'=>$user['id'], 'update_time'=>NOW_TIME));
			M('ProjectLeader')->add(array('project_id'=>$id, 'leader_id'=>$user['id'], 
				'lead_type'=>9, 'create_time'=>NOW_TIME, 'update_time'=>NOW_TIME));
			M('Project')->save(array('id'=>$id, 'vote_leader'=>2));

			$this->success('领投人指定成功。');
		}
	}

	// 领投人状态调整
	public function vote() {
		$id = $_GET["id"];
		$vote_leader = $_GET["status"];

		M("Project")->where(array('id'=>$id))->save(array('vote_leader'=>$vote_leader));

		if($vote_leader == '1') {
			$message="项目开始推选领投人。";
		} else {
			$leader = M('ProjectLeader')->where(array('project_id'=>$id))->order('vote_fund desc,vote_count desc, create_time')-> find();
			if ($leader) {
				M('ProjectLeader')->where('id='.$leader['id'])->save(array('lead_type'=>9));
				M('ProjectFund')->where(array('project_id'=>$id))->save(array('leader_id'=>$leader['leader_id']));
			}
			$message="项目确定领投人。";
		}
		$this->success($message);
	}

	// 审核通过
	public function istop() {
		if (IS_AJAX) {
			$id = $_GET['id'];
			$status = $_GET['status'];
			if (!isset($id)) {
				$this->error('没有指定项目');
			}

			$project = M('Project')->find($id);
			if (!$project) {$this->error('指定项目不存在。');}
			
			if($status==1){
				$message='项目(' . $project['project_name'] . ')置顶成功';
			}else{
				$message='项目(' . $project['project_name'] . ')取消置顶成功';
			}
			
			M('Project')->save(array('is_top'=>$status, 'id'=> $id));
			$this->success($message);
		}
	}
	
	// 审核通过
	public function review() {
		if (IS_AJAX) {
			$id = $_GET['id'];
			$status = $_GET['status'];
			if (!isset($id)) {
				$this->error('没有指定项目');
			}
			if (!isset($status) || ($status != 2 && $status != 9)) {
				$this->error('未指定审核结果');
			}
			$project = M('Project')->find($id);
			if (!$project) {$this->error('指定项目不存在。');}
			M('Project')->save(array('status'=>$status, 'id'=> $id));
			$this->success('项目(' . $project['project_name'] . ')审核处理完成。');
		}
	}

	// 审核不通过
	public function fail() {

	}
	
	//项目阶段
	public function stage(){
		//获取状态
		$stage = isset($_GET['stage']) ? intval($_GET['stage']) : 0;
		//用户ID
		$uid = is_login();

		if($stage==0){
			//预热的项目
			$where = array('status' => array('eq', '9'),'stage'=>array('eq',1));
			$order = array('update_time desc');
			$p_stage ='预热的项目';
		}elseif($stage==2){
			//合投的项目
			$where = array('status' => array('eq', '9'),'stage'=>array('eq',2));
			$order = array('update_time desc');
			$p_stage ='认投的项目';
		}elseif($stage==4){
			//合投的项目
			$where = array('status' => array('eq', '9'),'stage'=>array('eq',4));
			$order = array('update_time desc');
			$p_stage ='合投的项目';
		}elseif($stage==5){
			//待结算的项目
			$where = array('status' => array('eq', '9'),'stage'=>array('eq',5));
			$order = array('update_time desc');
			$p_stage ='待结算的项目';
		}elseif($stage==8){
			//众筹失败的项目
			$where = array('status' => array('eq', '9'),'stage'=>array('eq',8));
			$order = array('update_time desc');
			$p_stage ='众筹失败的项目';
		}elseif($stage==9){
			//众筹成功的项目
			$where = array('status' => array('eq', '9'),'stage'=>array('eq',9));
			$order = array('update_time desc');
			$p_stage ='众筹成功的项目';
		}
        elseif($stage==-1)
        {
            $id=$_GET['id'];
            M('Project')->save(array('status'=>-1,'id'=>$id));
        }
		//职位
		$position = session('user_auth.position');
		//1.员工
		if($position==1){
			$where = array_merge( array('mid' => $uid) ,(array)$where);
		}
		$list = M('Project')->where($where)->order($order)->select();
		int_to_string($list,
		array('stage'=>array(0=>'审核已通过',1=>'预热阶段',2=>'认投阶段',3=>'推选领投人阶段',4=>'合投阶段', 5=>'等待付款', 9=>'完成')));
		

		foreach ($list as $key=>$info)
		{
			$fund_info = M('project_fund')->where("project_id = ". $info['id'])->find();
		
			//获取关注度
			$attachqty = M('project_attach')->where(array('project_id' => $info['id'],'attend_type' => 1))->count();

			$fundday=round((NOW_TIME-$info['create_time'])/3600/24) ;
			
			$list[$key]['needfund']=$fund_info['need_fund'];
			$list[$key]['hasfund']=$fund_info['has_fund'];
			$list[$key]['attachqty']=$attachqty;
			$list[$key]['fundday']=$fundday;
			$list[$key]['leader_id'] = $fund_info['leader_id'];
		}
		
		$this->p_stage = $p_stage;
		$this->_list = $list;
		$this->display();
	}
	
	//指派项目负责人
	public function setstage() {
		if(IS_GET) {
			$id = $_GET['id'];
			$project = M('Project')->where(array('id'=>$id))->
			field('id, project_name')->find();

			$this->project = $project;
			$this->display();
		} else {
			//项目ID
			$id = $_POST['id'];
			//机构ID
			$oid = $_POST['oid'];
			//项目经理
			$mid = $_POST['mid'];
				
			if(empty($oid)){
				$this->error('请指定所属机构');
			}
			if(empty($mid)){
				$this->error('请指定项目经理');
			}
	
			$user = M('Member')->find($mid);
			if (!$user) {
				$this->error('指定用户不存在。');
			}
	
			//更新
			$data = array('oid'=>$oid, 'mid'=>$mid,'is_appointed'=>1, 'update_time'=>NOW_TIME);
				
			M('Project')->where(array('id'=>$id))->save($data);
				
	
			$this->success('操作成功');
		}
	}
	
	// 审核通过
	public function stagechange() {
		if (IS_AJAX) {
			$id = $_GET['id'];
			$status = $_GET['status'];
			if (!isset($id)) {
				$this->error('没有指定项目');
			}
			$project = M('Project')->find($id);
			if (!$project) {$this->error('指定项目不存在。');}
			if($status==-1){
				$message='【' . $project['project_name'] . '】项目撤消成功';
                $url = U('stage', array('stage'=>-1,'id'=>$id));
			} elseif($status==1) {
				$message='【' . $project['project_name'] . '】项目阶段调整为预热';
				$url = U('stage', array('stage'=>0));
			} elseif($status==2) {
				$message='【' . $project['project_name'] . '】项目阶段调整为认投';
				$url = U('stage', array('stage'=>2));
			}elseif($status==4) {
				// if ($project['type'] == 0 && $project['vote_leader'] != 2) {
				// 	$this->error('项目的领投人还没有确定, 不能进行快速合投');
				// }
				
				$this->hetou($project);
				$message='【' . $project['project_name'] . '】项目阶段调整为合投';
				$url = U('stage', array('stage'=>4));
			}elseif($status==5) { 
				$message='【' . $project['project_name'] . '】项目阶段调整为等待付款';
				$url = U('stage', array('stage'=>5));
			}elseif($status==8) {
				$message='【' . $project['project_name'] . '】项目阶段调整为募资失败';
				$url = U('stage', array('stage'=>8));
			}elseif($status==9) { 
				$message='【' . $project['project_name'] . '】项目阶段调整为募资成功';
				$url = U('stage', array('stage'=>9));
			}
			// $data = M('ProjectFund')->where(array('project_id'=>$id))->find();
		
			// if ($data['final_valuation'] == 0) {
			// 	M('ProjectFund')->save(array('id'=>$data['id'], 'final_valuation'=>$data['project_valuation']));	
			// }
			
			M('Project')->save(array('stage'=>$status, 'id'=> $id));
			
			$this->changelog('项目阶段调整',$id,$message);
			$this->success($message,$url);
		}
	}

	public function hetou($project) {
		if ($project['type'] == 1) {
			return true;
		}

		$fund = M('ProjectFund')->field('id,need_fund, project_valuation')->where(array('project_id'=>$project['id']))->find();
		$invest = M('ProjectInvestor')->field('id, project_valuation, fund')->where(array('project_id' => $project['id'], 'status' => array('egt', 2)))->order('project_valuation desc, fund')->select();

		$hasfund = 0;
		$allowfund = 0;
		$valuation = $fund['project_valuation'];
		foreach ($invest as $key => $v) {
			$allowfund += $v['fund'];
			if ($allowfund <= $fund['need_fund']) {
				// $valuation = $v['project_valuation'];
				M('ProjectInvestor')->where(array('id'=>$v['id']))->save(array('project_valuation' =>$valuation));
				$hasfund = $allowfund;
			} else {
				$data = array('id'=>$v['id'], 'status'=>0, 
					'refuse_reason'=>'项目已超募, 由于您的估计偏低, 被系统拒绝');
				M('ProjectInvestor')->save($data);
			}
		}

		// 确定最终估值
		M('ProjectFund')->save(array('id'=>$fund['id'], 'has_fund' =>$allowfund, 
			'agree_fund' =>$allowfund, 'final_valuation' => $valuation));

		// 进入快速合投前,未被接受的询价默认拒绝
		M('ProjectInvestor')->where(array('project_id' => $project['id'], 
			'status' => '1'))->save(array('status' => 0));
	}

	public function changelog($type,$projectid=0,$content) {
		//添加机构ID
		$oid = session('user_auth.oid');
		
		$date= array(
			'project_id'=>$projectid,
			'type'=>$type,
			'content'=>$content,
			'oid'=>$oid,
			'create_time'=>NOW_TIME,
			'create_id'=>is_login(),
			'create_ip'=>ip2long(get_client_ip()),
		);
		
		M('Project_log')->add($date);
		
	}
	
	public function projectlog() {
	
		//添加机构ID
		$oid = session('user_auth.oid');
		
		$project_log = M('Project_log')->where(array('status' => array('eq', '0'),'oid'=>$oid))->select();
		
	
		foreach ($project_log as $key=>$info)
		{
			$project = M('project')->where("id = ". $info['project_id'])->find();
			
			$project_log[$key]['projectname']=$project['project_name'];
		}
		
		$this->projectlogs = $project_log;
		$this->display();
	
	}

	public function edit($id,$step){
		if (empty($id)) {
			$this->error('此项目不存在');
		}
		$projectBase = M('Project')->where(array('id'=>$id))->find();
		$projectBase['industryName'] = get_code_name($projectBase['industry']);
			// var_dump($projectBase);exit();

		if (empty($projectBase)) {
			$this->error('此项目不存在');
		}
		$this->projectid = $id;

		switch ($step) {
			case 1://editBaseInfo
				$projectBase['stepname'] = $projectBase['step'];
				$this->assign($projectBase);
				$this->industry = get_code('industry');
				$this->project_phase_list = get_code('project_phase');
				$this->step = get_code('step');
				$this->display('edit_step1');
				break;
			case 2:// editIntroduce
				$projectInfo = M('ProjectInfo')->where(array('project_id'=>$id))->find();
				$event = M('ProjectEvent')->where(array('project_id'=>$id))->select();
			
				$this->assign($projectInfo);
				$this->assign('event',$event);
				$this->display('edit_step2');
				break;
			case 3: // editTeam
				$projectTeam = M('ProjectTeam')->where(array('project_id'=>$id,'status'=>array('egt',0)))->order('sort asc,create_time')->select();
				$this->assign('team',$projectTeam);
				$this->display('edit_step3');
				break;
			case 4:// editDatum
				$temp = M('ProjectTemp')->where(array('project_id'=>$id))->order('temp_type, sort')->select();
				$temp_move = null;
				foreach ($temp as $key => $v) {
					if ($v['temp_type'] == 0) {
						$temp_move = $v['describe'];
						unset($temp[$key]);
						break;
					}
				}
				$this->temp = $temp;
				$this->temp_move = $temp_move;
				$this->display('edit_step4');
				break;
			case 5:
				$this->fund = M('ProjectFund')->where(array('project_id'=>$id))->find();
				$to_way = get_code('to_way');

				$this->to_way = get_code('to_way');
				$this->display('edit_step5');
				break;
		}

		// $this->display();
	}

	public function editBaseInfo() {
		$uid = is_login();

		if (IS_POST) {
			$project = $_POST['project'];  							// 项目信息
			$project['province'] = $_POST['province']; 	// 所在省
			$project['city'] = $_POST['city']; 					// 所在市
			$project['update_time'] = time();
			$project['update_id'] = $uid;

			$model = D('Project');

			$project = $model->create($project);  			// 根据输入数据创建项目模型

			if(!$project) {		// 模型创建失败、返回错误内容
				$this->error($model->getError());
				return;
			}

			$id = $model->where(array('id'=>$_POST['id']))->save($project);
			
			$this->success('处理成功！', U('edit', array('id'=>$_POST['id'],'step'=>2)));
		}
	}

	public function editIntroduce() {
		$uid = is_login();

		if (IS_POST) {
			$id = $_POST['id'];
			// 项目信息
			$project_info = array('project_id'=>$id, 
					'description'=>$_POST['description'], 			// 项目描述
					'avantages'=>$_POST['avantages'], 					// 项目优势
					'custom'=>$_POST['custom'],	
					'yingli_mode'=>$_POST['yingli_mode'],
					'jingzheng'=>$_POST['jingzheng'],	
					'plan'=>$_POST['plan'],	
					'update_time' => NOW_TIME, 
					'update_id' => $uid);

			$where = array('project_id' => $id);
			$info = M('ProjectInfo')->where($where)->find();
			if ($info) {
				M('ProjectInfo')->where($where)->save($project_info);
			} else {
				$project_info['create_time'] = NOW_TIME;
				$project_info['create_id'] = $uid;
				// 项目信息登录数据库
				M('ProjectInfo')->add($project_info);
			}
			
			// 项目大事记
			$event = $_POST['event'];
			M('ProjectEvent')->where($where)->delete();
			if (isset($event)) {
				// 取得输入的项目大事记信息
				for ($i=0; $i < count($event['when']) ; $i++) { 
					$when = $event['when'][$i];
					$content = $event['content'][$i];

					$project_event = array('project_id' => $id, 
						'when' => strtotime($when), 
						'content' => $content, 
						// 'create_time' => NOW_TIME,
						// 'create_id' => $uid,
						'update_time' => NOW_TIME, 
						'update_id' => $uid,);
					M('ProjectEvent')->add($project_event);
				}
			}
			$this->success('处理成功！', U('edit', array('id'=>$_POST['id'],'step'=>3)));
		}
	}

	private function can_edit($id) {
		if (!$id) {
			$this->error("页面不存在。");
		}
		$project = M('Project')->find($id);
		$uid = is_login();

		if (!$project) {
			$this->error('项目不存在，或者您没有编辑权限。');
		}
		return $project;
	}

	//添加修改团队信息
	public function addteam(){
	
		if (IS_POST) {
			//项目ID
			$id = $_POST['id'];
			//团队ID
			$tid = $_POST['tid'];
			$project = $this->can_edit($id);
			$where = array('project_id'=>$id);
	
			//名称
			if(empty($_POST['name'])){
				$this->error("请输入名称");
			}
			//职位
			if(empty($_POST['postion'])){
				$this->error("请输入职位");
			}
			//请上传头像
			if(empty($_POST['header_img'])){
				$this->error("请上传头像");
			}
			//个人简介
			if(empty($_POST['member_info'])){
				$this->error("请输入个人简介");
			}
			
			//编辑信息
			$key = array(
					'project_id' => $id,
					'member_type' => '0',
					'name' => $_POST['name'],
					'postion' => $_POST['postion'],
					'full_job' => '1',
					'header_img'=> $_POST['header_img'],
					'member_info' => $_POST['member_info'],
					'sort' => $_POST['sort'],
					'update_time' => NOW_TIME,
					'update_id' => is_login(),);
				

			if($tid>0){
				$key['id']=$tid;
				M('ProjectTeam')->save($key);
			}else{
				$key['create_time']=NOW_TIME;
				$key['create_id']=is_login();
				M('ProjectTeam')->add($key);
			}

			$this->success('处理成功！', U('edit', array('id'=>$_POST['id'],'step'=>3)));
		}else{
			$id = $_GET['id'];
			$tid = $_GET['tid'];
			if(!empty($tid)){
				$teaminfo = M('ProjectTeam')->find($tid);
				if($teaminfo){
					$id = $teaminfo['project_id'];
					$this->assign('teaminfo',$teaminfo);
				}else{
					$this->error('团队信息不存在');
				}
			}

			$this->tid = $tid;
			$this->pid = $id;
			$this->display();
		}
	}
	
	//删除团队成员
	public function delmember($id){
		if (empty($id)) {
			$this->error('关键参数未获得');
		}
		$modelteam = M('ProjectTeam');
		$result = $modelteam->where(array('id'=>$id))->save(array('status'=>-1));
		if ($result ==false) {
			$this->error('处理失败，请联系管理员:service@dreammove.cn');
		}else{
			$this->success('删除成功');
		}
	}
	
	
	public function editDatum(){
		$uid = is_login();
		if (IS_POST) {
			$id = $_POST['id'];
			$project = $this->can_edit($id);
			// 如果指定了宣传图片，录入数据库
			$project_temp = $_POST['temp'];

			if (!isset($project_temp)) {
				$this->error('请至少添加一张宣传图片。');
			}
			
			$where=array('project_id'=>$id);
			M('ProjectTemp')->where($where)->delete();
			if (isset($project_temp)) {
				foreach ($project_temp as $key => $value) {
					$temp = array('project_id' => $id, 
						'temp_type' => '1', 
						'info_key' => $value, 
						'sort' => $key, 
						'update_time' => NOW_TIME, 
						'update_id' => $uid,);

					M('ProjectTemp')->add($temp);
				}
			}

			// 如果指定了视频的URL，视频数据录入数据库
			$temp_move = $_POST['temp-move'];
			if (isset($temp_move) && !empty($temp_move)) {
				$temp = array('project_id' => $id, 
						'temp_type' => '0', 
						'info_key' => getswf($temp_move), 
						'sort' => 0, 
						'describe' =>$temp_move,
						'update_time' => NOW_TIME, 
						'update_id' => $uid,);

					M('ProjectTemp')->add($temp);
			}
			$this->success('处理成功！', U('edit', array('id'=>$_POST['id'],'step'=>5)));
		}
	}

	public function editFinancingInfo(){
		$uid = is_login();
		if (IS_POST) {
			$id = $_POST['id'];

			$project = $this->can_edit($id);
			// 融资信息
			$fund = $_POST['fund'];
			$model = D('ProjectFund');
			$fund = D('ProjectFund')->create($fund);

			$fund['project_id'] = $id;
			$fund['update_time'] = NOW_TIME;
			$fund['update_id'] = $uid;

			$where = array('project_id'=>$id);
			$f = M('ProjectFund')->where($where)->find();

			if ($f) {
				$fund['id'] = $f['id'];
				M('ProjectFund')->save($fund);
			} else {
				$fund['create_time'] = NOW_TIME;
				$fund['create_id'] = $uid;
				M('ProjectFund')->add($fund);
			}

			if (!$id) {
				$this->error('项目添加失败。');
			} else {
				$url = U('Project/index');
				// 成功返回项目id
				$this->success('恭喜您修改成功！', $url);
			}			
		}
	}

	// 项目二维码上传
	public function barcode() {
		if (IS_AJAX) {
			$id = $_POST['id'];

			if (!$id) {
				$this->error('参数错误');
			}

			$data = array('id'=>$id, 'barcode'=>$_POST['barcode']);

			$ret = M('Project')->save($data);

			if ($ret) {$this->success('项目讨论组二维码更新成功。');}
			else {$this->error(M('Project')->getError());}
		} else {
			$id = $_GET['id'];
			$this->project = M('Project')->find($id);

			$this->display('barcode');
		}

	}
}
?>