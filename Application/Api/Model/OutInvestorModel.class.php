<?php 
namespace Api\Model;
use Think\Model;
use Think\Log;

class OutInvestorModel extends Model {
	/**
	 * 添加外部投资人信息
	 */
	public function addinvestor($data) {
		$error;
		if (empty($data)) {
			$error = array('code'=>1, 'message'=>'参数为空');
		} else if (empty($data['real_name']) || empty($data['cardid'])) {
			$error = array('code'=>1, 'message'=>'实名信息不能为空。');
		} else if (empty($data['pid'])) {
			$error = array('code'=>1, 'message'=>'未指定投资项目。');
		} else if (empty($data['fund']) || (($data['fund'] % 1000) > 0)) {
			$error = array('code'=>1, 'message'=>'投资金额必须大于0并且为1000的倍数');
		}
		// 如果验证有错，结束处理
		if (!empty($error)) {
			$this->outlog($error, $data);
			return array('status'=>false, 'info'=>$error);
		}

		// 获取项目的基本信息
		$project = D('ProjectFundView')->getbaseinfo($data['pid']);
		// 项目是否处于合投阶段
		if ($project['stage'] != 4) {
			$error = array('code'=>2, 'message'=>'该项目已经结束合投。');
		} else if ($project['follow_fund'] > $data['fund']) {
			$error = array('code'=>3, 'message'=>'投资金额必须大于领投金额。', 'extra'=>$project['follow_fund']);
		} else if ($project['need_fund'] < $data['fund']) {
			$error = array('code' => 4, 'message'=>'投资金额不能大于融资额', 'extra'=>$project['need_fund']);
		}
		// 如果验证有错，结束处理
		if (!empty($error)) {
			$this->outlog($error, $data);
			return array('status'=>false, 'info'=>$error);
		}

		$outinvestor = $this->where(array('pid'=>$data['pid'], 
			'phone'=>$data['phone']))->find();

		if ($outinvestor) {
			$error = array('code'=>5, 'message'=>'用户已经投资了该项目，不能重复投资。');
			$this->outlog($error);
			return array('status'=>false, 'info'=>$error);
		}

		$outid = uniqid();
		$investor = array('pid'=>$data['pid'], 'fund'=>$data['fund'], 
			'real_name'=>$data['real_name'], 'cardid'=>$data['cardid'], 
			'phone'=>$data['phone'], 'outid'=>$outid, 'pay_flag'=>0, 'from_way'=>$data['from_way'], 
			'create_time'=>NOW_TIME, 'update_time'=>NOW_TIME);

		$id = $this->add($investor);

		if ($id) {
			return array('status'=>true, 
				'info'=>array('message'=>'投资处理成功。', 'outid'=>$outid));
		} else {
			$this->outlog('', $data, '登录处理');
			return array('status'=>false, 
				'info'=>array('code'=> 99, 'message'=>'未知错误'));
		}
	}

	/**
	 * 修改用户支付状态
	 */
	public function pay($outid) {
		if (empty($outid)) {
			$error = array('code'=>1, 'message'=>'参数为空');
			return array('status'=> false, 'info'=>$error);
		}

		$data = $this->where(array('outid'=>$outid))->find();

		if (!$data) {
			$error = array('code'=>11, 'message'=>'未找到关联的投资人信息。');
		} else if ($data['pay_flag'] == 1) {
			$error = array('code'=>12, 'message'=>'指定投资记录已经完成支付。');
		} else {
			$project = M('Project')->where(array('id'=>$data['pid']))->find();
			if ($project['stage'] != 4 && $project['stage'] != 5) {
				$error = array('code' => 15, 'message'=>'您投资的项目已经结束合投或打款。');
			}
		}
		if ($error) {
			return array('status'=> false, 'info'=>$error);
		}

		$ret = $this->where(array('outid'=>$outid))->save(
			array('pay_flag'=>1, 'update_time'=>NOW_TIME));

		if ($ret) {
			return array('status'=>true, 'info'=>array('message'=>'付款处理成功。'));
		}else {
			return array('status'=>false, 'info'=>array('code'=>99, 'message'=>'未知错误'));
		}
	}

	public function cancel($outid) {
		if (empty($outid)) {
			$error = array('code'=>1, 'message'=>'参数为空');
			return array('status'=> false, 'info'=>$error);
		}

		$data = $this->where(array('outid'=>$outid))->find();

		if (!$data) {
			$error = array('code'=>11, 'message'=>'未找到关联的投资人信息。');
		} else if ($data['out_state'] != 0) {
			$error = array('code'=>13, 'message'=>'指定投资记录已撤消。');
		} else {
			$project = M('Project')->where(array('id'=>$data['pid']))->find();
			if ($project['stage'] == 9) {
				$error = array('code' => 16, 'message'=>'您认投的项目已众筹成功，不允许撤消。');
			}
		}

		if ($error) {
			return array('status'=> false, 'info'=>$error);
		}

		if ($data['pay_flag'] == 1) { // 已支付订单取消
			$ret = $this->where(array('outid'=>$outid))->save(
				array('pay_flag'=>0, 'out_state'=> -1, 'update_time'=>NOW_TIME));
		} else {
			// 未支付订单取消
			$ret = $this->where(array('outid'=>$outid))->save(
				array('out_state'=> -2, 'update_time'=>NOW_TIME));
		}
		if ($ret) {
			return array('status'=>true, 'info'=>array('message'=>'撤消成功。'));
		}else {
			return array('status'=>false, 'info'=>array('code'=>99, 'message'=>'未知错误'));
		}
	}

	private function outlog($info, $data, $err_type='验证处理') {
		$log = '';
		if (is_array($info)) {
			$log .= json_encode($info);
		}
		if (is_array($data)) {
			$log .= json_encode($data);
		}
		$path = C('LOG_PATH') . 'outinvestor.txt';
			Log::write($log, $err_type, '', $path);
	}

}
?>