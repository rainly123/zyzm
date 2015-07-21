<?php 
namespace Admin\Model;
use Think\Model;

class AccStreamModel extends Model {
	public function cancel_pay($data) {
		$acc = $this->where(array('relation_id'=>$data['relation_id']))->find();

		if (!$acc) { // 非线上支付
			// $data1 = array('uid'=>$data['uid'], 'amount'=>$data['amount'], 'remarks'=>'关联投资（' . $data['relation_id'] . '）退款');
			// $ret = D('AccStream')->recharge($data1);
			return true;
		} else if ($acc['state'] != 1) {
			$this->error = '支付处理未成功';
			return false;
		} else {
			$temp = array('id'=>$acc['id'], 'update_time'=>NOW_TIME, 
				'remarks'=>$data['remarks'], 'state'=>2);
			$this->save($temp);

			// 用户个人账户资金调整
			$account = M('AccountUser')->where(array('uid'=>$data['uid']))->find();
			$temp = array('id'=>$account['id'], 'balance'=>$account['balance'] + $data['amount'], 
				'use_able'=>$account['use_able'] + $data['amount'], 'update_time'=>time());

			M('AccountUser')->save($temp);

		}

		return true;
	}

	// 线下充值
	public function recharge($data) {
		$tran_stream = "CZ".time_format(time(), 'YmdHis').rand(1000, 9999);
		$data['tran_stream'] = $tran_stream;
		$data['type'] = 0;
		$data['do_tag'] = 8; // 线下充值
		$data['state'] = 1;
		$data['create_time'] = time();
		$data['update_time'] = time();
		
		$this->add($data);

		$account = M('AccountUser')->where(array('uid'=>$data['uid']))->find();
		
		if (!$account) {
			D('AccountUser')->addAccount($data['uid']);
		}

		$use_able = $account['use_able'] + $data['amount'];
		M('AccountUser')->save(array('id'=>$account['id'], 
				'balance'=>($account['balance'] + $data['amount']),
				'use_able'=>$use_able, 'update_time'=>time()
			));
		return $use_able;
	}
}

?>