<?php 
namespace Home\Controller;
class ProjectController extends HomeController {

	// 项目列表
	public function index() {
		$this->redirect('List/index');
		return;
		$where =array('status' => 9);
		if (isset($_GET['stage'])) {
			$where['stage'] = $_GET['stage'];
		} else {
			$where['stage'] = array('gt', 0);
		}

		if ($where['stage'] == 'finish') {
			$where['stage'] = array('egt', 8);
		}
		// 审核已经通过的项目
		$project = M('ProjIndex')->where($where)
			->order('stage_order, create_time desc')->select();

		$this->project = $project;
		$this->pageTitle = $project['project']['project_name'];
		$this->display();
	}

	// 创建项目
	public function create() {
		$this->pageTitle = "创建项目";
		$this->display();
	}

    public function intro() {
        $id = $_GET['id'];
        $project['info'] = M('ProjectInfo')->where(array('project_id' => $id))->find();
        $project['temp'] = M('ProjectTemp')->field('info_key, temp_type')->where(array('project_id' => $id, 'type'=>1))->order('temp_type, sort')->select();
        $project['project'] = M('Project')->find($id);
        $team = M('ProjectTeam')->where(array('project_id'=>$id,'status'=>0))->order('member_type,sort')->select();
        
        //返回跳转
        $this->assign("backurl",U('Project/detail?id='.$id));
        $this->assign("team",$team);
        $this->assign("project",$project);
        $this->display();
    }

	private function can_edit($id) {
		if (!$id) {
			$this->error("页面不存在。");
		}
		$project = M('Project')->find($id);
		$uid = is_login();

		if (!$project || $project['uid'] != $uid || 
			($project['stage'] > 3)) {
			$this->error('项目不存在，或者您没有编辑权限。');
		}
		return $project;
	}

	//项目基本信息
	public function addstep1() {
		
		$this->login();
		$id = $_GET['id'];

		if (IS_POST) {
			$project = $_POST['project'];
			
			$project['province'] = $_POST['province']; 	// 所在省
			$project['city'] = $_POST['city']; 			// 所在市
			$project['create_time'] = NOW_TIME;
			$model = D('Project');
			
			$project = $model->create($project);
			
			if(!$project) {		// 模型创建失败、返回错误内容
				$this->error($model->getError());
				return;
			} 
			
			if($id>0){
				$project['id'] = $id;
				$model->save($project);
			}else{
				$id = $model->add($project);
			}
			
			$this->success('处理成功！', U('addstep2', array('id'=>$id)));
			
			
		} else {
			$uid = is_login();
			$auth = M('UserAuth')->where(array('uid'=>$uid, 'auth_id'=>'0'))->count();
			// 未填写创业者信息
			if (!$auth) {
				$this->display('investor');
				return;
			}
			
			if($id>0){
				$project = M('Project')->find($id);
			}

			$this->project_id = $id;
			$this->project = $project;
			$this->industry = get_code('industry');
			$this->project_phase = get_code('project_phase');
			$this->step = get_code('step');

			$this->display();
		}

	}
	public function addstep2() {

		$id = $_GET['id'];
		$project = $this->can_edit($id);

		if (IS_POST) {
			$uid = is_login();
			// 项目信息
			$project_info = array('project_id'=>$id, 
					'description'=>$_POST['description'], 			// 项目描述
					'avantages'=>$_POST['avantages'], 					// 项目优势
					'custom'=>$_POST['custom'],	
					'yingli_mode'=>$_POST['yingli_mode'],	
					'jingzheng'=>$_POST['jingzheng'],	
					'plan'=>$_POST['plan'],	
					'update_time' => NOW_TIME, 
					'update_id' => $uid,);

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
						'create_time' => NOW_TIME,
						'create_id' => $uid,
						'update_time' => NOW_TIME, 
						'update_id' => $uid,);
					M('ProjectEvent')->add($project_event);
				}
			}
			$this->success('处理成功！', U('addstep3', array('id'=>$id)));
		} else {
			$where = array('project_id'=> $id);
			$info = M('ProjectInfo')->where($where)->find();
			$event = M('ProjectEvent')->where($where)->select();
			$this->assign('info', $info);
			$this->assign('event',$event);
			$this->project_id = $id;
			$this->display('addstep2');
		}
	}
	//团队介绍
	public function addstep3() {
		$id = $_GET['id'];
		$project = $this->can_edit($id);

		$where = array('project_id'=>$id,'status'=>0);
		
		if (IS_POST) {
			$uid = is_login();
			$key = array(
				'project_id' => $id,
				'member_type' => '0',
				'name' => $_POST['name'],
				'postion' => $_POST['postion'],
				'full_job' => '1',
				'header_img'=> $_POST['header_img'],
				'member_info' => $_POST['member_info'],
				'sort' => $_POST['sort'],
				'create_time' => NOW_TIME,
				'create_id' => $uid,
				'update_time' => NOW_TIME,
				'update_id' => $uid,);
			
			if($_POST['team_id']>0){
				$key['id']=$_POST['team_id'];
				M('ProjectTeam')->save($key);
			}else{
				M('ProjectTeam')->add($key);
			}

			$this->success('处理成功!', U('addstep4', array('id'=>$id)));
		} else {

			$this->project_id = $id;
			$this->team = M("ProjectTeam")->where($where)->order('member_type,sort')->select();
			$this->display();
		}
	}
	
	public function delmember($id){
		if (empty($id)) {
			$this->error('关键参数未获得');
		}
		$modelteam = M('ProjectTeam');
		//$result = $modelCustomAddress->where(array('id'=>$addId))->delete();
	
		$result = $modelteam->where(array('id'=>$id))->save(array('status'=>-1));
		if ($result ==false) {
			$this->error('处理失败，请联系管理员:service@dreammove.cn');
		}else{
			$this->success('删除成功');
		}
	}
	
	public function getmemberinfo($id){
		if (empty($id)) {
			$this->error('关键参数未获得');
		}
		//获取团队信息
		$team = M('ProjectTeam')->where(array('id'=>$id,'status'=>0))->order('member_type, id')->find();
	
		if (empty($team)) {
			$this->error('获取信息失败');
		}else{
				$team['image_url'] = get_cover($team['header_img'],'path');

				if (empty($team['image_url'])) {
					$team['image_url'] = null;
				}
				$this->success($team);
		}
	}
	
	//项目资料
	public function addstep4() {
		$id = $_GET['id'];
		$project = $this->can_edit($id);

		$where=array('project_id'=>$id);
		if (IS_POST) {
			$uid = is_login();
			// 如果指定了宣传图片，录入数据库
			$project_temp = $_POST['temp'];

			if (!isset($project_temp)) {
				$this->error('请至少添加一张宣传图片。');
			}

			M('ProjectTemp')->where($where)->delete();
			if (isset($project_temp)) {
				foreach ($project_temp as $key => $value) {
					$temp = array('project_id' => $id, 
						'temp_type' => '1', 
						'info_key' => $value, 
						'sort' => $key, 
						'create_time' => NOW_TIME,
						'create_id' => $uid, 
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
						'create_time' => NOW_TIME,
						'create_id' => $uid, 
						'update_time' => NOW_TIME, 
						'update_id' => $uid,);

					M('ProjectTemp')->add($temp);
			}
			$this->success('处理成功', U('addstep5', array('id'=>$id)));
		} else {
			$temp = M('ProjectTemp')->where($where)->order('temp_type, sort')->select();
			$temp_move = null;
			foreach ($temp as $key => $v) {
				if ($v['temp_type'] == 0) {
					$temp_move = $v['describe'];
					unset($temp[$key]);
					break;
				}
			}
			$this->project_id = $id;
			$this->temp = $temp;
			$this->temp_move = $temp_move;
			$this->display();
		}
	}

	//融资信息
	public function addstep5() {
		$id = $_GET['id'];
		$project = $this->can_edit($id);

		$where = array('project_id'=>$id);
		if (IS_POST) {
			$uid = is_login();
			// 融资信息
			$fund = $_POST['fund'];
			$model = D('ProjectFund');
			$fund = D('ProjectFund')->create($fund);

			if (!$fund) {
				$this->error($model->getError());
			}
			if (!$model->checkFund($fund, $project['type'])) {
				$this->error($model->getError());
			}	

			$fund['project_id'] = $id;
			$fund['update_time'] = NOW_TIME;
			$fund['update_id'] = $uid;

			$f = M('ProjectFund')->where($where)->find();
			if ($f) {
				$fund['id'] = $f['id'];
				M('ProjectFund')->save($fund);
			} else {
				$fund['create_time'] = NOW_TIME;
				$fund['create_id'] = $uid;
				M('ProjectFund')->add($fund);
			}

			if (!$id) { // 操作失败 显示错误信息
				$this->error('项目添加失败。');
			} else {
				//$url = U('Manage/foundlist', array('id'=>$id));
				// 成功返回项目id
				//$this->success('恭喜您项目！', $url);
				$this->success('处理成功', U('addstep6', array('id'=>$id)));
			}			
		} else {
			$this->fund = M('ProjectFund')->where($where)->find();
			$this->to_way = get_code('to_way');
			$this->project_id = $id;
			$this->display();
		}
	}

	public function addstep6() {
		$id = $_GET['id'];
		$project = $this->can_edit($id);
		
		$where = array('project_id'=>$id);
		if (IS_POST) {
			
		}else{
			$this->project = M('Project')->find($id);
			$this->project_id = $id;
			$this->display();
		}
	}
	// 项目申请上线
	public function online() {
		if (!IS_AJAX) {return;}
		$id = $_GET['id'];
		if (!$id) {
			$this->error("页面不存在。");
		}
		$project = M('Project')->find($id);
		$uid = is_login();

		if ($project['status'] != 0 && $project['status'] != 2) {
			$this->error("该项目不能提交审核");
		}

		if (!$project || $project['uid'] != $uid) {
			$this->error('项目不存在，或者您没有编辑权限。');
		}

		M('Project')->save(array('id'=>$id, 'status'=>1));

		$this->success('申请成功!', U('MCenter/pj_create'));
	}
	
	public function detail() {
		$id = $_GET['id'];
	    $model = D('Project');
	   	$userScores = $model->getUserScoresInfo($id);
		if (isMobile()) {

	      $project = $model->getProjectInfo($id);
	
				if ($project == false) {
		        $this->error($model->getError());
		    }else if ($project['uid'] != is_login()) {
	        if ($project['status'] != 9) {
	            $this->error('指定项目不存在');
	        }else if ($project['stage'] < 0) {
	            $this->error('该页面不存在。');
	        }
		    }
	      $model->where(array('id'=>$id))->setInc('read_record');
	
	      $dynamicInfo = D('ProjectDynamicInfo')->getPublishedDynamicInfoByPID($id);
	      $project['fund'] = $model->getProjectFundInfo($id);
	      $project['averageScores'] = $model->getProjectScoresInfo($id);
	      $project['leader'] = $model->getProjectLeaderInfo($id);
	      $project['investors'] = $model->getInvestorsInfo($id,3);
	      $model->addProjectStatis($project);//pass by reference
	      $cmt = M('ProjectComment')->order('create_time desc')->where(array('project_id'=>$id))->select();
	      $project['comments'] = get_format_comment($cmt, 5); //$model->getComments($id,5);
	      $recomendList = recommendMBDetailFundings();
	
	      $this->project = $project;
	      $this->pageTitle = $project['project_name'];
	      $this->assign('pageTitle',$project['project_name']);
	      $this->assign('recomendList',$recomendList);
		} else {

			$project = $model->getdetail($id);
            $commentCount =M('CommentReply')->where(array('project_id'=>$id))->count();
            $commentpage = new \Think\Page($commentCount,10);
            $commentshow = $commentpage->show();

            $project['comment'] = $model->getDetailComments($id,$commentpage->firstRow,$commentpage->listRows);
            $project['project']['com_count'] = $commentCount;
			if ($project == false) {
				$this->error($model->getError());
			}else if ($project['project']['uid'] != is_login()) {
				if ($project['project']['status'] != 9) {
					$this->error('指定项目不存在');
				}else if ($project['project']['stage'] < 0) {
					$this->error('该页面不存在。');
				}
			}
			//获取团队信息
			$team = M('ProjectTeam')->where(array('project_id'=>$id,'status'=>0))->order('member_type,sort')->select();
		
			$model->where(array('id'=>$id))->setInc('read_record');
            $recomendFundingProjectList = D('Project')->getFundingProjects('6',array('status' => 9, 'stage'=> array('between',array('1','4'))),$order='create_time desc,stage desc');
            $dynamicInfo = D('ProjectDynamicInfo')->getPublishedDynamicInfoByPID($id);

            $recomendList = recommendFoundings();

            $this->project = $project;
			$this->pageTitle = $project['project']['project_name'];
            $this->assign('recomendFundingProjectList',$recomendFundingProjectList);
            $this->assign('recomendList',$recomendList);
            $this->assign('dynamicInfo',$dynamicInfo);
                 $this->assign('commentshow',$commentshow);
            $this->assign('uid',is_login());
            $this->assign('team',$team);
		}
		
		$this->assign('backurl',U('Index/index'));
        $this->assign('userScores',$userScores);
        $this->display('detail');
	}

  public function mobiledynamic(){
      $id = $_GET['pid'];
      $dynamicInfo =  D('ProjectDynamicInfo')->getPublishedDynamicInfoByPID($id);

      $this->assign('dynamic',$dynamicInfo);
      $this->assign('pageTitle',"项目动态");
      $this->assign('puid',M('Project')->where('id='.$id)->field('uid')->find());
      $this->assign('uid',is_login());
      $this->display();
  }

    public function projectdynamicdetail(){
        $id = $_GET['id'];
        $dynamicInfo =  M('project_dynamic_info')->where(array('id' => $id))->find();

        $dynamicComment =  M('project_comment')->order('create_time desc')->where(array('dynamicid'=>$id))->select();
        foreach($dynamicComment as &$comment){
            if($comment['reply_id']>0){
                $data = M('project_comment')->where(array('id'=>$comment['reply_id']))->find();
                $comment['old_content']= $data['content'];
                $comment['old_user']= $data['create_id'];

            }
        }
        $projectInfo = D('Project')->getProjectInfo($dynamicInfo['project_id']);
        $this->assign('project',$projectInfo);
        $this->assign('dynamic',$dynamicInfo);
        $this->assign('dynamicComment',$dynamicComment);

        $this->display();
    }

  public function mbmoreinvestors(){
      $id = $_GET['pid'];
      $this->assign('investors',D('Project')->getInvestorsInfo($id));
      //返回跳转
      $this->assign("backurl",U('Project/detail?id='.$id));
      $this->assign('pageTitle',"项目动态");

      $this->display('mbMoreInvestors');
  }
	// 发表评论
	public function comment() {
        if(!isMobile()){
            if (IS_POST) {
            	if (empty($_POST['content'])) {
            		$this->error('请输入评论内容。');
            	}
                $project_id = $_POST['project_id'];
                $user_id = is_login();
                $reply_id = $_POST['reply_id'];

                $comment = array('project_id' => $project_id,
                    'comment_user' => $user_id,
                    'content' => $_POST['content'],
                    'reply_id' =>$reply_id,
                    'create_time' => NOW_TIME,
                    'create_id' => $user_id,
                    'update_time' => NOW_TIME,
                    'update_id' => $user_id,
                    'dynamicid'=>I('dynamicid'),);
                $id = M('ProjectComment')->add($comment);

                $proj=M('Project')->where('id ='.$project_id)->field('project_name, uid')->find();

                $ulink = '<a href="'.U('MCenter/profile?id='.$user_id).'">'.
                    get_membername($user_id).'</a>';
                $plink = '<a href="'.U('Project/detail?id='.$project_id).'">《'.
                    $proj['project_name'].'》</a>';
                if ($user_id != $proj['uid']) {
                    $content = $ulink . '评论了您的'. $plink . '项目';
                    D('Message')->send(0,$proj['uid'],'', $content, 3);
                }

                if ($reply_id) {
                    $rep = M('ProjectComment')->where('id='.$reply_id)->getField('comment_user');
                    if ($rep != $user_id && $rep != $proj['uid'] && !$rep) {
                        $content = $ulink . '回复了您对'. $plink . '项目的评论';
                        D('Message')->send(0,$rep,'', $content, 3);
                    }
                }

                $comment['id'] = $id;
                $comment['comment_user'] = $user_id;
                $comment['user_face'] = get_memberface($user_id);
                $comment['date'] = change_date($comment['create_time']);
                $comment['status'] = 1;
                $comment['user_name'] = get_membername($user_id);
                $comment['old_user'] = $_POST['old_user'];
                $comment['old_content'] = $_POST['old_content'];
								$comment['status'] = 1;
                
                $this->ajaxReturn($comment);
            }
        }else{
			$project_id = $_POST['project_id'];
            $user_id = is_login();
                            $reply_id = $_POST['reply_id'];
                            $comment = array('project_id' => $project_id,
                                'comment_user' => $user_id,
                                'content' => $_POST['content'],
                                'reply_id' =>$reply_id,
                                'create_time' => NOW_TIME,
                                'create_id' => $user_id,
                                'update_time' => NOW_TIME,
                                'update_id' => $user_id,
                                'dynamicid'=>I('dynamicid'),);
                            $id = M('ProjectComment')->add($comment);

                            $proj=M('Project')->where('id ='.$project_id)->field('project_name, uid')->find();

                            $ulink = '<a href="'.U('MCenter/profile?id='.$user_id).'">'.
                                get_membername($user_id).'</a>';
                            $plink = '<a href="'.U('Project/detail?id='.$project_id).'">《'.
                                $proj['project_name'].'》</a>';
                            if ($user_id != $proj['uid']) {
                                $content = $ulink . '评论了您的'. $plink . '项目';
                                D('Message')->send(0,$proj['uid'],'', $content, 3);
                            }

                            if ($reply_id) {
                                $rep = M('ProjectComment')->where('id='.$reply_id)->getField('comment_user');
                                if ($rep != $user_id && $rep != $proj['uid'] && !$rep) {
                                    $content = $ulink . '回复了您对'. $plink . '项目的评论';
                                    D('Message')->send(0,$rep,'', $content, 3);
                                }
                            }
                            $comment['id'] = $id;
                                            $comment['comment_user'] = $user_id;
                                            $comment['user_face'] = get_memberface($user_id);
                                            $comment['date'] = change_date($comment['create_time']);
                                            $comment['status'] = 1;
                                            $comment['user_name'] = get_membername($user_id);
                                            $comment['old_user'] = $_POST['old_user'];
                                            $comment['old_content'] = $_POST['old_content'];

                                            $this->ajaxReturn($comment);

        }

	}

	// 询价处理
	public function inquiry() {
		$id = I('id');
		$uid = is_login();
		if (!$uid) {
			$this->display_error('亲，您还没有登录噢！登录吧，等你噢〜'.showface('radio'));
		}
		$where = array('uid' => $uid, 'status' => 9, 'auth_id'=>1);
		$auth = M('UserAuth')->where($where)->count();
		if (!$auth) {
			$this->display_error('亲，为了方便您的投资完善您的个人资料噢！'.showface('waiting'));
		}

		$project = D('ProjectFundView')->where(array('p.id'=>$id))->find();

		if (!$project) {
			$this->display_error('项目不存在！');
		} else if ($project['stage'] >= 2) { //非询价认投期
			$this->display_error('该项目已过了询价认投期，不能进行询价认投。');
		} else if ($project['uid'] == $uid) {
			$this->display_error('不允许项目发起人，对自己的项目进行投资。');
		}
		$inve = M('ProjectInvestor')->where(array('project_id'=>$id, 'investor_id'=>$uid))->select();

		$count = 0;
		foreach ($inve as $k => $v) {
			if ($v['status'] >= 2) {
				$message = "您的询价认投已经被项目方接受，不能重复投资。";
				break;
			}
			if ($v['status'] <= 0) {
				$count++;
				if ($count >= 2) {
					$message = '您已有2次询价未成功记录，不能再进行询价认投。<br>
						如果您对该项目感兴趣，可以在快速合投阶段，进行跟投。';
					break;
				}
			}
			if ($v['status'] == 1) {
				$message = '您的询价认投已经提交，请耐心等待项目方的确认。';
				break;
			}
		}
		if (isset($message)) {
			$this->display_error($message);
		}

		if (IS_POST) {
			$investor =  array('project_id'=>$id, 'fund'=>$_POST['fund']
					, 'project_valuation'=>$_POST['project_valuation'], 'others'=>$_POST['others']);

			if ($project['need_fund'] < $investor['fund']) {
				$this->error('投资额必须小于' . round($project['need_fund'],2) . '元。');
			}

			$investor['step'] = $project['stage'];
			$investor['lead_type'] = 1;
			$investor['project_id'] = $id;
			$investor['investor_id'] = $uid;
			$investor['create_time'] = NOW_TIME;
			$investor['create_id'] = $uid;
			$investor['update_time'] = NOW_TIME;
			$investor['update_id'] = $uid;
			$investor['status'] = 1;

			M('ProjectInvestor')->add($investor);

			// 发送系统消息(通知项目方有人询价)
			$ulink = '<a href="'.U('MCenter/profile?id='.$uid).'">'.
				get_membername($uid).'</a>';
			$plink = '<a href="'.U('Manage/foundinquiry').'">《'.
				$project['project_name'].'》</a>';

			$content = $ulink . '对您的'. $plink . '项目的进行了询价，请及时处理';
			D('Message')->send(0,$project['uid'],'', $content, 3);

			$this->success('您的询价认投提交成功，请耐心等待项目方的确认。');

		} else {
			$project['rate_fund'] = $project['need_fund'] * 100 / $project['project_valuation'];
			$project['rate'] = $project['follow_fund'] * 100 / $project['project_valuation'];
			$this->project = $project;
			$this->display();
		}
	}

	private function display_error($message) {
		if (IS_POST) {
			$this->error($message);
		} else {
			$this->message = $message;
			$this->display('error');
			exit();
		}
	}

	public function checkAuth(){
		$thisProject = D('Project');
		$validateUser = $thisProject->checkAuth();
		$this->ajaxReturn($validateUser);
	}
	

	
	// 跟投处理
	public function follow() {
		$id = I('id');
		if ($id == 2) {
			$this->display('Tea/invest');
			return;
		}
		$uid = is_login();
		if (!$uid) {
			$this->redirect('User/login');
		}
		/*
		$where = array('uid' => $uid, 'status' => 9, 'auth_id'=>1);
		$auth = M('UserAuth')->where($where)->count();
		$phone = M('UcenterMember')->find($uid);
		
		if (!$auth || empty($phone['mobile'])) {
			$this->error('您还没有完成实名认证或绑定手机，完善后方可投资。'.showface('waiting'),
			 U('User/savecenter'));
		}*/

		$project = D('ProjectFundView')->where(array('p.id'=>$id))->find();
		if (!$project) {
			$this->error('项目不存在！');
		} else if ($project['stage'] != 4) { //非询价认投期
			$this->error('该项目不处于快速合投期间，不能进行该操作。');
		} else if ($project['uid'] == $uid) {
			$this->error('不允许项目发起人，对自己的项目进行投资。');
		}
		$inve = M('ProjectInvestor')->where(array('project_id'=>$id, 'investor_id'=>$uid))->select();

		$count = 0;
		foreach ($inve as $k => $v) {
			if ($v['status'] >= 2) {
				$message = "您的投资已经被项目方接受，不能重复投资。如需更改投资金额，请先前往用户中心撤消投资。";
				$this->error($message,U('./MCenter'));
				break;
			}
			if ($v['status'] == -1) {
				$count++;
				if ($count >= 5) {
					$message = '您不能对该项目进行投资(该项目您有五次撤消投资记录)。';
					break;
				}
			}
		}

		if (isset($message)) {
			$this->error($message);
		}

		if (IS_POST) {
			
			$thisProject = D('Project');
			$validateUser = $thisProject->checkAuth();
			if(!$validateUser['success']){
				$this->error('没有实名认证');
			};
			
			$investor =  array('project_id'=>$id, 'fund'=>$_POST['fund'],
				'others' => $_POST['others'], 'lead_type'=>3);

			if ($project['need_fund'] < $investor['fund']) {
				$this->error('跟投额必须小于' . round($project['need_fund'],2) . '元。');
			} else if ($project['follow_fund'] > $investor['fund']) {
				$this->error('跟投额必须大于或者等于' . round($project['follow_fund'],2) . '元。');
			}

//			if ($project['type'] == 0 && ($investor['fund'] % 1000) > 0) {
//				$this->error('投资金额必须是1000的倍数。');
//			}

			if ($_POST['leader_type'] == 1) {
				if (!empty($project['leader_id'])) {
					$this->error('该项目已经指定了领投人，不能申请领投。');
				}
				if (empty($investor['others'])) {
					$this->error('如果您想申请成为领投人，请填写投资理由。以方便项目方确认。');
				}
				$investor['lead_type'] = 2;

				$count = M('ProjLeader')->where(array('pid'=>$id, 'uid'=>$uid, 
					'status'=>array('egt', 0), 'del_flag'=>0))->count();

				if ($count > 0) {
					$this->error('您已经申请了该项目的领投，请不要重复申请。');
				}

				$temp = array('pid'=>$id, 'uid'=>$uid, 'fund'=>$investor['fund'], 'step'=>4,
					'message'=>$investor['others'], 'create_time'=>NOW_TIME);

				M('ProjLeader')->add($temp);
			}

			// $leader = M('ProjectLeader')->where(array('leader_id'=>$uid, 'project_id'=>$id))->find();
			// if ($leader  && $leader['status'] == 0) {
			// 	M('ProjectLeader')->save(array('id'=>$leader['id'], 
			// 		'status'=>1, 'update_time'=>NOW_TIME));
			// }

			$investor['step'] = $project['stage'];
			$investor['project_valuation'] = $project['final_valuation'];
			$investor['project_id'] = $id;
			$investor['investor_id'] = $uid;
			$investor['create_time'] = NOW_TIME;
			$investor['create_id'] = $uid;
			$investor['update_time'] = NOW_TIME;
			$investor['update_id'] = $uid;
			$investor['status'] = 4;

			M('ProjectInvestor')->add($investor);
			M('ProjectFund')->where('project_id='.$id)->setInc('has_fund',$investor['fund']);
			M('ProjectFund')->where('project_id='.$id)->setInc('agree_fund',$investor['fund']);
			// 发送系统消息(通知项目方有人跟投)
			$ulink = '<a href="'.U('MCenter/profile?id='.$uid).'">'.
				get_membername($uid).'</a>';
			$plink = '<a href="'.U('Manage/foundfollow').'">《'.
				$project['project_name'].'》</a>';

			$content = $ulink . '跟投了您的'. $plink . '项目';
			D('Message')->send(0,$project['uid'],'', $content, 3);

			//增加一个待办事件
			update_pj_dolist($uid,0);
			
			$this->success('恭喜您，跟投成功！现在，去签署一下代持协议吧！'.showface('hand'), U('Agreement/touzi?id='.$id));

		} else {
			if ($project['type'] == 1) {
				$project['final_valuation'] = $project['need_fund'];
			}
			$project['rate_fund'] = $project['need_fund'] * 100 / $project['final_valuation'];
			$project['rate'] = $project['follow_fund'] * 100 / $project['final_valuation'];
			$this->project = $project;

			//返回跳转
			$this->assign("backurl",U('Project/detail?id='.$id));
			$this->display();
		}
	}

	// 领投人申请处理
	public function lead() {
		$id = I('id');
		$uid = is_login();

		// 验证是否登录
		if (!$uid) {
			$this->display_error('亲，您还没有登录噢！快点吧，等你噢〜'.showface('radio'));
		}
		$where = array('uid' => $uid, 'status' => 9, 'auth_id'=>1);
		$auth = M('UserAuth')->where($where)->count();
		if (!$auth) {
			$this->display_error('亲，为了方便您的投资，请先完善您的个人资料噢！'.showface('waiting'));
		}

		// 验证领投人身份
		$where = array('uid' => $uid, 'status' => 9, 'auth_id'=>3);
		$auth = M('UserAuth')->where($where)->count();
		if (!$auth) {
			$this->display_error('您还不是认证领投人。马上补充信息申请领投人。');
		}

		// 验证项目相关信息
		$project = D('ProjectFundView')->where(array('p.id'=>$id))->find();
		if (!$project) {
			$this->display_error('项目不存在！');
		} else if ($project['vote_leader'] != 0) {
			$this->display_error('该项目已经关闭领投人申请。');
		} else if ($project['uid'] == $uid) {
			$this->display_error('您是该项目的发起人，不能申请领投人。');
		}

		$leader = M('ProjectLeader')->field('leader_id')->where('project_id =' .$id)->select();
		if ($leader) {
			foreach ($leader as $key => $v) {
				if ($v['leader_id'] == $uid) {
					$this->display_error('您已经是该项目的候选领投人。请不要重复申请。');
				}
			}
		}

		if (IS_POST) {
			$inve = M('ProjectInvestor')->where(array('project_id'=>$id, 
				'investor_id'=>$uid, 'status'=>'2'))->select();
 			$lead_type = $inve && $inve['status'] >= 2 ? 1 : 0;
 			$leader = array('project_id'=> $id, 'leader_id'=>$uid, 
 				'reason'=>$_POST['reason'], 'create_time'=>NOW_TIME, 'lead_type'=>$lead_type,
 				'create_id'=>$uid, 'update_time'=>NOW_TIME, 'update_id'=>$uid);
 			M('ProjectLeader')->add($leader);

			// 发送系统消息(通知项目方有人询价)
			$ulink = '<a href="'.U('MCenter/profile?id='.$uid).'">'.
				get_membername($uid).'</a>';
			$plink = '<a href="'.U('Manage/foundlead').'">《'.
				$project['project_name'].'》</a>';

			$content = $ulink . '成为了您'. $plink . '项目的候选领头人';
			D('Message')->send(0,$project['uid'],'', $content, 3);


 			$this->success('恭喜您已成为'.$project['project_name'].'项目的候选领投人！<br>聚募网会尽快与您取得联系，助您完成项的尽调等工作。');
		} else {
			$this->project = $project;
			$this->display('lead');
		}
	}

	// 关注项目
	public function attach() {
		if (IS_AJAX) {
			if (!is_login()) {
				$this->error('您还没有登录。', U('User/login'));
			}
			$id = $_GET['id'];
			$status = D('ProjectAttach')->attach($id);
			// todo 发送系统信息
			$this->success('','', array('attach_status'=>$status));
		}
	}
	
	/**
	 *   项目动态添加
	 *
	 *    @author    Hyber
	 *    @return    void
	 */
	function dynamicInfoAdd()
	{


            $projectid = $_POST['project_id'];
            $content = $_POST['project_dynamic_content'];
            $access = $_POST['project_dynamic_access'];
			$uid = is_login();

            $project=M('Project')->where('id='.$projectid)->find();
            if ($project['create_id'] != is_login()) {//auther is the current user



                $data=array(
                    'project_id'=>$projectid,
                    'content' => $content,
                    'create_time'=>NOW_TIME,
                    'access'=>$access,
                );
            }


        $project_id = $_POST['project_id'];
        $user_id = is_login();
        $reply_id = 0;
        $comment = array('project_id' => $project_id,
            'comment_user' => $user_id,
            'content' => "项目动态".$content,
            'reply_id' =>$reply_id,
            'create_time' => NOW_TIME,
            'create_id' => $user_id,
            'update_time' => NOW_TIME,
            'update_id' => $user_id,);
        $id = M('ProjectComment')->add($comment);

        $proj=M('Project')->where('id ='.$project_id)->field('project_name, uid')->find();

        $ulink = '<a href="'.U('MCenter/profile?id='.$user_id).'">'.
            get_membername($user_id).'</a>';
        $plink = '<a href="'.U('Project/detail?id='.$project_id).'">《'.
            $proj['project_name'].'》</a>';
        if ($user_id != $proj['uid']) {
            $content = $ulink . '评论了您的'. $plink . '项目';
            D('Message')->send(0,$proj['uid'],'', $content, 3);
        }

        if ($reply_id) {
            $rep = M('ProjectComment')->where('id='.$reply_id)->getField('comment_user');
            if ($rep != $user_id && $rep != $proj['uid'] && !$rep) {
                $content = $ulink . '回复了您对'. $plink . '项目的评论';
                D('Message')->send(0,$rep,'', $content, 3);
            }
        }

			
			M('project_dynamic_info')->add($data);
			$this->success('处理成功。',U('project/detail?id='.$projectid));

	}

    /**
     *    新增或者更新项目动态信息
     *    @author    adam
     */
    function addProjectDynamicInfo()
    {
        if(!I('id')){//新增项目动态信息
            $data=array(
                'project_id'=>I('project_id'),
                'title' => I('title'),
                'content' => I('content'),
                'create_time'=>NOW_TIME,
                'update_time'=>NOW_TIME,
                'open_flag'=>I('open_flag'),
                'status'=>I('status'),
            );
            $projectDynamicInfo= D("project_dynamic_info");
            if (!$projectDynamicInfo->create($data)){
                $this->error($projectDynamicInfo->getError());
            }elseif(!$projectDynamicInfo->validateUserByPID(I('project_id'))){
                $this->error('不是项目创建者无权修改或增加项目动态');
            }else{
                $result = M('project_dynamic_info')->add($data);
                if ($result ==false) {
                    $this->error('新增动态失败，请联系管理员:service@dreammove.cn');
                }else{
                    $this->success('新增动态成功。',U('project/dynamiclist?id='.I('project_id')));
                }
            }
        }else {//更新项目动态信息
            $data = array(
                'id' => I('id'),
                'title' => I('title'),
                'content' => I('content'),
                'update_time' => NOW_TIME,
                'open_flag' => I('open_flag'),
                'status' => I('status'),
            );
            $projectDynamicInfo = D("project_dynamic_info");

            if (!$projectDynamicInfo->create($data)) {
                $this->error($projectDynamicInfo->getError());
            }elseif(!$projectDynamicInfo->validateUserByPID(I('project_id'))){
                $this->error('不是项目创建者无权修改或增加项目动态');
            }else {
                $result = M('project_dynamic_info')->save($data);
                if ($result == false) {
                    $this->error('更新动态失败，请联系管理员:service@dreammove.cn');
                } else {
                    $this->success('更新动态成功。', U('project/dynamiclist?id=' . I('project_id')));
                }
            }
        }

    }
    function uploadpdf(){
    	
    	$upload = new \Think\Upload();// 实例化上传类
    	$upload->maxSize   =     3145728 ;// 设置附件上传大小
    	$upload->exts      =     array('pdf');// 设置附件上传类型
    	$upload->rootPath  =      './Uploads/'; // 设置附件上传根目录
    	$upload->savePath  =      ''; // 设置附件上传（子）目录
    	$upload->autoSub  = true;
    	$upload->subName  = array('date','Ymd');
    	$upload->saveName  = I('name');
    	$info   =   $upload->upload();
    	if(!$info) {// 上传错误提示错误信息
    		$data['success'] = false;
    		$data['info'] = $this->error($upload->getError());
    	}else{// 上传成功 获取上传文件信息
    		$data['success'] = true;
    		foreach($info as $file){
    			$data['info'][]= 'http://'.$_SERVER['HTTP_HOST'].'/Uploads/'.$file['savepath'].$file['savename'];
    		}
    	}
    	return $data;
    }
    /**
     *    新增或者更新项目动态信息
     *    @author    adam
     */
    function addProjectAfterInfo()
    {
    	if(!I('id')){//新增项目投后管理
			$savefile =$this->uploadpdf();
    		if($savefile['success']==false){print_r($savefile);
    			return $savefile;
    		}else{
    			$uploadfilesurls = implode($savefile['info'], ';');
    		}
    		$data=array(
    				'project_id'=>I('project_id'),
    				'title' => I('title'),
    				'content' => I('content'),
    				'create_time'=>NOW_TIME,
    				'update_time'=>NOW_TIME,
    				'attachment'=>$uploadfilesurls,
    				'status'=>I('status'),
    		);
    		$projectAfterInfo= D("project_after_info");
    		if (!$projectAfterInfo->create($data)){
    			$this->error($projectAfterInfo->getError());
    		}elseif(!$projectAfterInfo->validateUserByPID(I('project_id'))){
    			$this->error('不是项目创建者无权增加项目投后管理');
    		}else{
    			$result = M('project_after_info')->add($data);
    			if ($result ==false) {
    				$this->error('新增项目投后管理失败，请联系管理员:service@dreammove.cn');
    			}else{
    				$this->success('新增项目投后管理成功。',U('project/fundedmanagelist?id='.I('project_id')));
    			}
    		}
    	}else {//更新项目投后管理
    			$savefile =$this->uploadpdf();
    		if($savefile['success']==false){
    			return $savefile;
    		}else{
    			$uploadfilesurls = implode($savefile['info'], ';');
    		}
    		$data = array(
    				'id' => I('id'),
    				'title' => I('title'),
    				'content' => I('content'),
    				'update_time' => NOW_TIME,
    				'attachment'=>$uploadfilesurls,
    				'status' => I('status'),
    		);
    		$projectAfterInfo = D("project_after_info");
    		if (!$projectAfterInfo->create($data)) {
    			$this->error($projectAfterInfo->getError());
    		}elseif(!$projectAfterInfo->validateUserByPID(I('project_id'))){
    			$this->error('不是项目创建者无权修改项目投后管理');
    		}else {
    			$result = M('project_after_info')->save($data);
    			if ($result == false) {
    				$this->error('更新项目投后管理失败，请联系管理员:service@dreammove.cn');
    			} else {
    				$this->success('更新项目投后管理成功。', U('project/fundedmanagelist?id=' . I('project_id')));
    			}
    		}
    	}
    }

    /**
     *    新增或者更新项目动态信息
     *    @author    adam
     */
    function updateProjectDynamicStatus()
    {
        if(!I('id') | !I('status')){//新增项目动态信息
            $this->error('发布动态失败，缺少关键数据');
        }else {//更新项目动态信息
            $data = array(
                'status' => I('status'),
            );
            $projectDynamicInfo = D("project_dynamic_info");

            if (!$projectDynamicInfo->create($data)) {
                exit($projectDynamicInfo->getError());
            }elseif(!$projectDynamicInfo->validateUserByPID(I('project_id'))){
                $this->error('不是项目创建者无权修改或增加项目动态');
            } else {
                $result = M('project_dynamic_info')->where('id='.I('id'))->save($data);
                if ($result == false) {
                    $this->error('更新动态失败，请联系管理员:service@dreammove.cn');
                } else {
                    $this->success('更新动态成功。', U('project/dynamiclist?id=' . I('project_id')));
                }
            }
        }

    }



    public function isAuthor(){
        $pid = I('pid');
       if(is_login() == M('Project')->where('id ='.$pid)->field('uid')->find()){return true;}
        else{return false;}
    }
	/**
	 *   项目动态查看
	 *
	 *    @author    Hyber
	 *    @return    void
	 */
	function dynamicview()
	{
		if (!IS_POST)
		{	
			$project_id = I('id');

			$project_dynamic=M('project_dynamic')->where('id='.$project_id)->find();
			
		
			$project=M('project')->where('id='.$project_dynamic['project_id'])->find();
			
			$project_dynamic['projectname'] = $project['project_name'];
			
			$count = $project_dynamic['read_count'] +1;
			$readcount=array('id'=>$project_dynamic['id'],'read_count'=>$count);
			
			M('project_dynamic')->save($readcount);
			
			$this->project=$project_dynamic;
			$this->display();
		}
	}

	function payinfo() {
		if ($_GET['id'] == 33 || $_GET['id'] == 48) {
			$this->display('payinfo');	
		} else {
			$this->display('payinfo1');
		}
	}
    function postcomment() {
        $this->display('postcomment');
    }
	/**
	 *   项目动态删除
	 *
	 *    @author    Hyber
	 *    @return    void
	 */
	function dynamicdel()
	{
		if (!IS_POST)
		{
			$id = I('id');
			$projectid = I('projectid');

			$p = M('ProjectDynamic')->find($id);

			if ( $p == false || $p['create_id'] != is_login()) {
				$this->error('您没有权限操作。', U('project/detail?id='.$projectid));
			}

			$date['id'] = $id;
			$date['status'] = 1;
			
			M('project_dynamic')->save($date);
				
			$this->success('删除成功。',U('project/detail?id='.$projectid));
		}
	}
	
	/**
	 *   项目动态编辑
	 *
	 *    @author    Hyber
	 *    @return    void
	 */
	function dynamicedit()
	{
		if (IS_POST)
		{
			$id = $_POST['id'];
			$title = $_POST['title'];
			$description = $_POST['description'];
			
			$uid = is_login();
	
			$data=array(
					'id'=>$id,
					'title'=>$title,
					'content'=>$description,
					'update_time'=>NOW_TIME,
					'update_id'=>$uid,
			);
	
			M('project_dynamic')->save($data);
			$this->success('处理成功。',U('project/dynamicview?id='.$id));
	
		} else {
			$id = I('id');
			$dynamic=M('project_dynamic')->where('id='.$id)->find();
			
			if ($dynamic['create_id'] != is_login()) {
				$this->error('您不是创建者，不能进行编辑。');
			}
			$project=M('project')->where('id='.$dynamic['project_id'])->find();
			
			$dynamic['projectname']=$project['project_name'];
			
			$this->dynamic=$dynamic;
			$this->display();
		}
	}

    function makereply(){
        $this->assign('reply_id',I('reply_id'));
        $this->assign('project_id',I('project_id'));
        $this->display();
    }

    function morecomment(){
    	$pid=I('pid');
        //$comments = M('CommentReply')->order('create_time desc')->where(array('project_id'=>I('pid')))->select();
        $cmt = M('ProjectComment')->order('create_time desc')->where(array('project_id'=>$pid))->select();
      	$comments = get_format_comment($cmt, count($cmt)); //$model->getComments($id,5);
      
	      //返回跳转
	      $this->assign("backurl",U('Project/detail?id='.$pid));
        $this->assign('pageTitle','更多回复');
        $this->assign('comments',$comments);
        $this->display();
    }
	function dynamiclist(){
        $id = I('id');

        $projectInfo = D('Project')->getProjectInfo($id);
        $dynamicInfo = D('ProjectDynamicInfo')->getDynamicInfoByPID($id);

        $this->assign('dynamicInfo',$dynamicInfo);
        $this->assign('projectInfo',$projectInfo);
        $this->display();
    }

    function dynamiclistadd(){ 
    		$this->detail = array('project_id'=>$_GET['id']);
        $this->display();
    }

    function updateProjectDynamicInfo()
    {
        $dynamicInfoID = I('id');
        if ($dynamicInfoID) {
            $detail = $this->getDynamicInfoByID($dynamicInfoID);
            $this->assign('detail', $detail);
        }

        $this->display('dynamiclistadd');
    }
    public function dynamiclistdelete(){
        $dynamicInfoID = I('id');
        if (empty($dynamicInfoID)) {
            $this->error('关键参数未获得');
        }
        //M('project_dynamic_info')->delete($id);
        $data['status'] = -1;
        if(M('project_dynamic_info')->where('id='.$dynamicInfoID)->save($data) == false){
            $this->error('处理失败，请联系管理员:service@dreammove.cn');
        }else{
            $this->success('删除成功');
        }
        //D('Project')->deleteProjectDynamic($id);
    }
    function getDynamicInfoByID($id){
        return M('project_dynamic_info')->where('id='.$id)->find();
    }

	public function leader_info() {
		$this->pageTitle = '领投人协议';
  	$uid = is_login();
  	if (!$uid) {
  		$this->redirect('User/login');
  	}
		if ($_GET['isread']) {
			$this->isread = true;	
		}
		$this->id = $_GET['id'];
		$this->display('leader_info');
	}
  public function leader() {
  	$this->pageTitle = '申请领投人';
  	$uid = is_login();
  	if (!$uid) {
  		$this->redirect('User/login');
  	}
  	$where = array('uid' => $uid, 'status' => 9, 'auth_id'=>1);
		$auth = M('UserAuth')->where($where)->count();
		$phone = M('UcenterMember')->find($uid);
		if (!$auth || empty($phone['mobile'])) {
			$this->error('您还没有完成实名认证或绑定手机，完善后方可投资。'.showface('waiting'),
			 U('User/savecenter'));
		}
		/** 领投人资格验证(暂时不做领投人认证) **/
//		$where['auth_id'] = 3;
//		unset($where['status']);
//		$auth = M('UserAuth')->where($where)->count();
//		$phone = M('UcenterMember')->find($uid);
//		if (!$auth || empty($phone['mobile'])) {
//			$this->error('您还没有获取领投人资格，立即前往申请领投人。'.showface('waiting'),
//			 U('User/applylead'));
//		}
		$pid = I('id');
		$project = D('ProjectFundView')->where(array('p.id'=>$pid))->find();
		if (!$project) {
			$this->error('项目不存在！');
		} else if ($project['stage'] != 1) { //非询价认投期
			$this->error('该项目不处于预热期，不能申请领投人。');
		} else if ($project['uid'] == $uid) {
			$this->error('不允许项目发起人，领投自己项目。');
		} else if (!empty($project['leader_id'])) {
			$this->error('该项目已经指定了领投人，领投人申请已经关闭.');
		}

		$count = M('ProjLeader')->where(array('pid'=>$pid, 'uid'=>$uid, 
			'status'=>array('egt', 0), 'del_flag'=>0))->count();
		if ($count > 0) {
			$this->error('您已经是该项目的候选领投人。请不要重复申请。');
		}

  	if (IS_GET) {
  		$this->project = $project;
  		$this->display('leader');
  	} else {
  		$data =  array('pid'=>$pid, 'uid'=>$uid, 'fund'=>$_POST['fund'],'message' => $_POST['message']);

			if ($project['need_fund'] < $data['fund']) {
				$this->error('投资金额必须小于融资金额' . round($project['need_fund'],2) . '元。');
			} else if ($project['follow_fund'] > $data['fund']) {
				$this->error('跟投额必须大于或者等于起投额' . round($project['follow_fund'],2) . '元。');
			}

			if ($project['type'] == 0 && ($data['fund'] % 1000) > 0) {
				$this->error('投资金额必须是1000的倍数。');
			}

			if(empty($data['message'])) {
				$this->error('请填写您的投资理由。');
			}

			$data['status'] = 0;
			$data['create_time'] = NOW_TIME;
			M('ProjLeader')->add($data);

			$investor['step'] = $project['stage'];
			$investor['project_valuation'] = $project['project_valuation'];
			$investor['project_id'] = $pid;
			$investor['investor_id'] = $uid;
			$investor['lead_type'] = 2; // 候选领投人
			$investor['fund'] = $_POST['fund'];
			$investor['others'] = $_POST['message'];
			$investor['create_time'] = NOW_TIME;
			$investor['create_id'] = $uid;
			$investor['update_time'] = NOW_TIME;
			$investor['update_id'] = $uid;
			$investor['status'] = 4;

			M('ProjectInvestor')->add($investor);
			M('ProjectFund')->where('project_id='.$pid)->setInc('has_fund',$investor['fund']);
			M('ProjectFund')->where('project_id='.$pid)->setInc('agree_fund',$investor['fund']);

			// 发送系统消息(通知项目方有人跟投)
			$ulink = '<a href="'.U('MCenter/profile?id='.$uid).'">'.
				get_membername($uid).'</a>';
			$plink = '<a href="'.U('Manage/foundfollow').'">《'.
				$project['project_name'].'》</a>';

			$content = $ulink . '申请领投了您的'. $plink . '项目';
			D('Message')->send(0,$project['uid'],'', $content, 3);

			$this->success('领投申请已经成功，请等待项目方同意。'.showface('hand'), U('MCenter/pj_support'));
  	}
  }

}
?>