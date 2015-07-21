<?php 
namespace Admin\Model;
use Think\Model;

class AgreementInvestModel extends Model {
	public function agreement($pid, $uid) {
		$project = D('ProjectFundView')->where(array('p.id'=>$id, 'p.status'=>9))->find();

		$leader = M('ProjectLeader')->where(array('project_id' => $pid, 'lead_type'=>9))->find();
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
		$agreementInvest = M('AgreementInvest')->where(array('pid'=>$pid, 'uid'=>$uid))->find();
		if (!$agreementInvest) {
			$agreementInvest = array('content'=>$detail['content'], 'agreement_id'=>$detail['id'], 
				'pid'=> $pid, 'uid'=>$uid, 'create_time'=>NOW_TIME, 
				'create_id'=>$uid, 'update_time'=>NOW_TIME, 'update_id'=>$uid,
				'status'=>1, 'client_ip'=>get_client_ip(0));
			M('AgreementInvest')->add($agreementInvest);
		} else {
			if ($agreementInvest['status'] == 0) {
			M('AgreementInvest')->save(array('id'=>$agreementInvest['id'], 'content'=>$detail['content'],
				'update_time'=>NOW_TIME, 'update_id'=>$uid, 'status'=>1, 'client_ip'=>get_client_ip(0)));
			}
		}
	}
}

?>