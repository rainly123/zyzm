<?php 
namespace Admin\Model;
use Think\Model;

class ProjectInvestorModel extends Model {
	/**外部投资人**/
	public function invest($data) {
		$fund = M('ProjectFund')->where(array(
			'project_id'=>$data['project_id']))->find();

		$data['create_time'] = NOW_TIME;
		$data['update_time'] = NOW_TIME;
		$data['project_valuation'] = $fund['final_valuation'];

		$ret = $this->add($data);

		if ($ret) {
			$temp = array('has_fund'=>($fund['has_fund'] + $data['fund']), 
				'agree_fund'=>($fund['agree_fund'] + $data['fund']), 
				'update_time'=>NOW_TIME, 'id'=>$fund['id']);
			$ret = M('ProjectFund')->save($temp);
			if ($ret) {
				$this->error = M('ProjectFund')->getError();
			}
			D('AgreementInvest')->agreement($data['project_id'], $data['investor_id']);
		}

		return $ret;
	}

	/**撤消投资**/
	public function cancel($pid, $uid) {
		$fund = M('ProjectFund')->where(array('project_id'=>$pid))->find();

		$investor = $this->where(array(
			'project_id'=>$pid, 'investor_id'=>$uid, 'status' => 9))->find(); 

		$agreement = M('AgreementInvest')->where(array('pid'=>$pid, 'uid'=>$uid))->find();

		if (!$investor) {
			$this->error = '投资记录不存在';
			return false;
		}
		if ($agreement) {
			M('AgreementInvest')->delete($agreement['id']);
		}

		M('ProjectFund')->save(array('id'=>$fund['id'], 
			'has_fund'=>($fund['has_fund'] - $investor['fund']), 
			'agree_fund'=>($fund['agree_fund'] - $investor['fund'])));

		$this->save(array('id'=>$investor['id'], 'status'=> -1));

		return true;
	}
}
?>