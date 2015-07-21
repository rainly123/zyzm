<?php
namespace Home\Controller;

class LeaderController extends HomeController {
	
	// 候选人投票
	public function vote() {
		if (IS_POST) {

			$project_id = $_GET['id'];
			$leader_id = $_POST['leader_id'];
			$investor_id = is_login();

			$where = array('project_id'=>$project_id, 
				'investor_id'=>$investor_id, 'status'=>array('egt',2));

			// 验证该投资人是否已投票
			$ret = M('ProjectVote')->where($where)->find();
			if ($ret) {
				$this->error('您已经投票，感谢您的参与。');
			}

			// 验证投票人是否该项目的投资人
			$ret = M('ProjectInvestor')->where($where)->find();
			if (!$ret) {
				$this->error('您不是该项目的投资人，不能参与投票。');
			}

			$vote = array(
				'project_id' =>$project_id, 
				'investor_id' => $investor_id,
				'leader_id' => $leader_id, 
				'resson' => $_POST['resson'],
				'is_hidden' => I('is_hidden', 0),
				'create_time' => NOW_TIME,
				'create_id' => is_login(), 
				'update_time' => NOW_TIME,
				'update_id' => is_login(),);

			// 投票人，投票记录
			M('ProjectVote')->add($vote);

			// 更新领投人获得票数信息
			$where = array(
				'project_id'=>$project_id, 
				'leader_id' => $leader_id);
			M('ProjectLeader')->where($where)->setInc('vote_fund', $ret['fund']);
			M('ProjectLeader')->where($where)->setInc('vote_count');

			$this->success('投票成功！');
		} else {
			if (!isset($_GET['id'])) {
				$this->error('您未指定推选的项目.');
			}
			$id = $_GET['id'];

			$data = D('LeaderView')->where(
				array('project_id'=>$id))->select();

			if(!$data) {
				$this->error('指定的项目不存在.');
			}

			$Model = M('ProjectInvestor');
			$vote = $Model->table('jm_project_investor i, jm_project_vote v')
				->where('i.project_id = v.project_id and i.investor_id = v.investor_id and i.status >= 2 and i.project_id = "' . $id . '"')->
				field('i.investor_id, i.fund, v.leader_id, v.resson, v.is_hidden, v.create_time')->select();

			$proj = M('Project')->table('jm_project p, jm_project_fund f')
				->field('p.id,p.vote_leader, p.project_name,f.has_fund')->where('p.id= f.project_id and p.id = '. $id)->find();
			
			$proj['inve_count'] = M('ProjectInvestor')->where(array('project_id'=>$id, 'status'=>array('egt',2)))->count();
			foreach ($data as $key => $value) {
				$proj['vote_fund'] += $value['vote_fund'];
			}
			$proj['vote_count'] = count($vote);
			foreach ($data as $k => $v) {
				$data[$k]['hidden'] = 0;
				$data[$k]['hidden_fund'] = 0;
				foreach ($vote as $key => $v1) {
					if ($v['leader_id'] == $v1['leader_id']) {
						if ($v1['is_hidden'] == 1) {
							$data[$k]['hidden'] = ++$hidden;
							$data[$k]['hidden_fund'] += $v1['fund'];
						} else {
							$data[$k]['vote'][] = $v1;
						}
					}
				}
				$data[$k]['fund_rate'] = round($v['vote_fund'] * 100 / $proj['has_fund'],0);
				$data[$k]['vote_rate'] = round($v['vote_count'] * 100 / $proj['inve_count'],0);
			}
			$this->leader = $data;
			$this->project = $proj;
			$this->display();
		}
	}

	public function report() {
		$this->login();

		$id = $_GET['id'];
		$uid = is_login();

		$info = M('ProjectLeader')->where(array('project_id'=>$id, 'leader_id'=>$uid))->find();

		if (!$info) {
			$this->error('您不是该项目的领投人。');
		}

		if (IS_POST) {
			$info = array('project_comment' => $_POST['project_comment'], 
				'team_comment' => $_POST['team_comment'],
				'report' => $_POST['report'], 'id'=>$info['id'], 
				'update_time'=>NOW_TIME, 'update_id'=> $uid);

			M('ProjectLeader')->save($info);

			$this->success('领投报告提交成功。', U('Manage/investlead'));
		} else {
			$this->project = M('Project')->field('project_name')->where(array('id'=>$id))->find();
			$this->info = $info;
			$this->display();
		}
	}
}
?>