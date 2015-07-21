<?php 
namespace Home\Model;
use Think\Model;
Class AccStreamModel extends Model {

	public function recharge($data) {
		$count = $this->where(array('relation_id'=>$data['relation_id']))->count();

		if ($count > 0) {
			return true;
		}

		$tran_stream = "CZ".time_format(time(), 'YmdHis').rand(1000, 9999);
		$data['tran_stream'] = $tran_stream;
		$data['type'] = 0;
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

	public function pay($data) {

		$count = $this->where(array('relation_id'=>$data['relation_id'], 
			'do_tag'=>$data['do_tag'], 'state'=>1))->count();
		if ($count > 0) {
			return true;
		}

		$account = M('AccountUser')->where(array('uid'=>$data['uid']))->find();

		$use_able = $account['use_able'] - $data['amount'];
		if ($use_able < 0) {
			return false;
		}
		M('AccountUser')->save(array('id'=>$account['id'], 
				'balance'=>($account['balance'] - $data['amount']),
				'use_able'=>($account['use_able'] - $data['amount']), 
				'update_time'=>time()
			));

		$tran_stream = "ZF".time_format(time(), 'YmdHis').rand(1000, 9999);
		$data['tran_stream'] = $tran_stream;
		$data['type'] = 1;
		$data['state'] = 1;
		$data['create_time'] = time();
		$data['update_time'] = time();
		// 处理类型（0：充值、1：支付、2：赎回、3：提现）
		$this->add($data);

		return true;
	}

	public function cash($data) {
		$account = M('AccountUser')->where(array('uid'=>$data['uid']))->find();
		$use_able = $account['use_able'] - $data['amount'];
	
		$count = $this->where(array('uid'=>$data['uid'], 'operation_day'=>time_format(NOW_TIME, 'Ymd')))->count();
		if ($count) {
			$this->error = '您今天已经有一次提现记录了，一天只能申请一次提现。';
			return false;
		}
		
		if ($use_able < 0) {
			$this->error = '您账号的可用余额小于提现金额。';
			return false;
		}
		M('AccountUser')->save(array('id'=>$account['id'], 
				'use_able'=>($account['use_able'] - $data['amount']),
				'update_time'=>time()
			));

		$tran_stream = "TX".time_format(time(), 'YmdHis').rand(1000, 9999);
		$data['tran_stream'] = $tran_stream;
		$data['type'] = 3;
		$data['state'] = 0;
		$data['create_time'] = time();
		$data['update_time'] = time();
		$data['operation_day']=time_format(NOW_TIME, 'Ymd');

		$this->add($data);

		return true;
	}

}
?>