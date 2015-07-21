<?php 
namespace Home\Controller;

class AgreementController extends HomeController {
	/*用户必须登录后方可查看*/
  function __construct(){
    parent::__construct();
    $this->uid = is_login();
    if (!$this->uid) {
      $this->redirect('User/login');
    }
  }
	public function touzi() {
		$uid = is_login();
		if (!$uid) {
			$this->redirect('User/login');
		}

		$id = $_GET['id'];
		if (!$id) {
			$this->error('未指定相关项目.');
		}

		$project = D('ProjectFundView')->where(array('p.id'=>$id, 'p.status'=>9))->find();
		if (!$project) {$this->error('指定项目不存在.');}

		if ($project['id'] == 2) {
			$iid = M('ProjectInvestor')->where(array('project_id'=>$id, 
				'investor_id'=>$uid, 'status'=>4))->getField('id');

			$this->redirect('Account/pay?id='.$iid);
			return;
		}

		$user = M('UsersDetail')->where(array('id'=>$uid))->find();
		$invest = M('ProjectInvestor')->
			where(array('project_id'=>$id, 'investor_id'=>$uid, 'status'=>4))->find();
		if (!$invest) {$this->error('没有找到和您相关的投资信息');}

		$leader = M('ProjectLeader')->where(array('project_id' => $id, 'lead_type'=>9))->find();
		if ($leader) {
			$leader_name = M('UsersDetail')->where(array('id'=>$leader['leader_id']))->find();
			if (strstr($leader_name['name'],'公司') || strstr($leader_name['name'],'企业')) {
				$leaderinfo = $leader_name['name'];
			} else {
				$leaderinfo = $leader_name['name'] . '(' . $leader_name['card_id'] .')';
			}
		}
		if ($project['id'] == 151) {
			$rate = floor($invest['fund'] / 5000) * 0.05;
		} else {
			$rate = round($invest['fund'] / $project['final_valuation'] * 100,4);	
		}
		
		$data = array('姓名'=>$user['name'], '身份证号'=>$user['card_id'], 
			'领投人'=> $leaderinfo,
			'投资金额'=>number_format($invest['fund'],2), '投资占比'=>$rate, 
			'公司名称'=>$project['company_name'], '大写金额'=>cny($invest['fund']), 
			'联系电话'=>$user['phone'], '签约日期'=>time_format(NOW_TIME, 'Y年m月d日'));

		if (!empty($project['agreement'])) {
			$detail = M('Agreement')->where(array('key'=>$project['agreement']))->find();	
		} else {
			if ($project['id'] == 33 || $project['id'] == 48) {
				$detail = M('Agreement')->where(array('key'=>'weituochiguo'))->find();	
			} else {
				$detail = M('Agreement')->where(array('key'=>'judaodaichi'))->find();	
			}
		}
		$agreement = $detail['content'];
		foreach ($data as $key => $value) {
			$detail['content'] = str_replace("[$key]", $value, $detail['content']);
		}
		$agreementInvest = M('AgreementInvest')->where(array('pid'=>$id, 'uid'=>$uid))->find();
		if (!$agreementInvest) {
			$agreementInvest = array('content'=>$detail['content'], 'agreement_id'=>$detail['id'], 
				'pid'=> $id, 'uid'=>$uid, 'create_time'=>NOW_TIME, 
				'create_id'=>$uid, 'update_time'=>NOW_TIME, 'update_id'=>$uid);
			M('AgreementInvest')->add($agreementInvest);
		} else {
			if ($agreementInvest['status'] == 0) {
			M('AgreementInvest')->save(array('id'=>$agreementInvest['id'], 'content'=>$detail['content'],
				'update_time'=>NOW_TIME, 'update_id'=>$uid));
			}
		}
		$this->project_name = $project['project_name'];
		$this->project_id = $project['id'];
		$this->id = $invest['id'];
		$this->data = $detail;

        $this->pageTitle = $project['project_name'];
        $this->assign('result','false');
		$this->display('touzi');
	}

	public function review_touzi() {
		$uid = is_login();
		if (!$uid) {
			$this->redirect('User/login');
		}
		$id = $_GET['id'];
		if (!$id) {
			$this->error('未指定相关项目.');
		}

		$project = D('ProjectFundView')->where(array('p.id'=>$id, 'p.status'=>9))->find();
		$agreementInvest = M('AgreementInvest')->where(array('pid'=>$id, 'uid'=>$uid))->find();

		$detail = M('Agreement')->where(array('id'=>$agreementInvest['agreement_id']))->find();
		$detail['content'] = $agreementInvest['content'];
		$this->project_name = $project['project_name'];
		$this->review = 1;
		$this->data = $detail;

        $this->pageTitle = $project['project_name'];
        $this->assign("result",'true');
		$this->display('touzi');
	}

	public function agree() {
		$uid = is_login();
		if (!$uid) {
			$this->redirect('User/login');
		}

		if ($_POST['agree'] != 1) {
			$this->error('您必须同意聚募网的《投资风险申明书》.');
		}
		$iid = $_POST['iid'];

		$data = M('ProjectInvestor')->where(
			array('id'=>$iid, 'status'=>4))->find();

		M('AgreementInvest')->where(
			array('pid'=>$data['project_id'], 'uid'=>$data['investor_id']))
			->save(array('status'=>1, 'update_time'=>NOW_TIME, 'update_id'=> $uid, 'client_ip'=>get_client_ip(0)));

		if ($data) {
			$pi = array('id'=> $data['id'], 'status' => 8, 'update_time'=>NOW_TIME, 'update_id'=>$uid);
			M('ProjectInvestor')->save($pi);
		}
		
		$this->success('立即前往支付.', U('Account/pay?type=1&id='.$iid));
	}
}
?>