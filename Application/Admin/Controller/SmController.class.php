<?php 
namespace Admin\Controller;
class SmController extends AdminController {
	public function manage() {
		if(IS_GET) {
			$id = $_GET['id'];
			$this->id = $id;
			$this->display();
		} else {

			$id = $_POST['id'];
			$amount = $_POST['amount'];
			if (empty($amount) || $amount <= 0) {
				$this->error('金额输入不正确！');
			}
			if (!isset($_POST['rate'])) {
				$this->error('收益率不能为空。');
			}
			if (empty($_POST['setday'])) {
				$this->error('下一个投票日期不能为空。');
			}

			$stock = M('Stock')->find($id);
			
			if ($stock['useday'] >= $_POST['setday']) {
				$this->error('下一个投票日期必须大于当前投票日期。');
			}

			$full = $_POST['full'] == 1 ? 0.2 : 0.05;

			$day = $stock['useday'];
			// 获取待结算的股票
			$sug = M('StockSuggestion')->where(array('pid'=>$id, 'status' => 3))->
				order('count desc')->find();

			$bonus = 0; 	// 推荐奖
			$over = $amount - $stock['amount']; // 今日收益

			if ($sug['uid'] != 0 && $over > 0) {
				$u = M('StockInvestor')->where(array('pid'=>$id, 'uid' => $sug['uid'], 'status'=>0))->find();
				// 推荐人为投资人 提出奖金;
				if ($u) {
					$bonus = round($over * $full);	
				}
			}
			$profit = $over - $bonus; 		// 分配用今日收益
			
			M('StockSuggestion')->where(array('id'=>$sug['id'],
				 'status' => 3))->save(array('status'=> 9, 'rate'=>$_POST['rate']));

			M('StockFlow')->add(array('sid'=>$id, 'operation_day'=>NOW_TIME, 
				'amount'=>$stock['amount'], 'fund'=>$stock['fund'], 
				'operation_fund'=>$stock['operation_fund'],
				'over'=>$amount - $stock['amount'],
				'create_time'=>NOW_TIME, 'update_time'=>NOW_TIME));

			M('Stock')->save(array('id'=>$id, 'over'=> $stock['over'] + $over, 
				'amount'=>$amount, 'setday'=>$_POST['setday'], 'update_time'=>NOW_TIME));

			$assets = $profit / $stock['amount']; // 每一元钱比例
			$invest = M('StockInvestor')->where(array('pid'=>$id, 'status'=>0))->select();
			foreach ($invest as $k => $v) {
				$myover = $assets * ($v['amount'] - $v['waiting_fund']);  // 个人今日收益
				M('StockInvestorFlow')->add(array('pid'=>$id, 'uid'=>$v['uid'], 'type'=>0,
					'fund'=>$v['fund'], 'operation_fund'=>$v['operation_fund'], 'over'=>$myover,
					'status'=>2, 'create_time'=>NOW_TIME, 'update_time'=>NOW_TIME));

				if ($sug['uid'] == $v['uid'] && $bonus > 0) {
					// 推荐人奖励
					M('StockInvestorFlow')->add(array('pid'=>$id, 'uid'=>$v['uid'], 
						'type'=>3, 'over'=> $bonus,
						'status'=>2, 'create_time'=>NOW_TIME, 'update_time'=>NOW_TIME));
					$myover += $bonus;
				}
				
				// 收益计算
				M('StockInvestor')->save(array('id'=>$v['id'], 
					'amount'=>$v['amount'] + $myover, 
					'over'=>($v['over'] + $myover), 'update_time'=>NOW_TIME));
			}
			$this->success('分配处理成功。');
		}
	}

/* 	public function cash() {
		if (IS_GET) {
			//提现记录
			$list = M('StockCash')->where(array('pid'=>$_GET['id'], 'status' => 0))->select();
			//获取基金信息
			$stock = M('Stock')->where(array('id'=>$_GET['id'], 'status' => 1))->find();

			//交易时间
			$setday = date('Y-m-d');
			if(!empty($stock['into_time'])){
				$settime = strtotime($setday . ' '. $stock['into_time']);
			}else{
				$settime = strtotime($setday);
			}
			
			foreach ($list as $k => $v) {
				$user = M('UsersDetail')->where(array('id'=>$v['uid']))->find();
				
				//银行
				$userbank = M('UserBank')->where(array('id'=>$v['bank_id']))->find();
				
				$list[$k]['name'] = $user['name'];
				$list[$k]['phone'] = $user['phone'];
				//提现卡信息
				$list[$k]['bank_name'] = $userbank['bank_name'];
				$list[$k]['sub_bank'] = $userbank['sub_bank'];
				$list[$k]['cardno'] = $userbank['cardno'];
				
				//申请赎回时间大于交易时间
				if($v['create_time'] > $settime){
					//不在本次提现之内
					$list[$k]['is_docash'] =0;
				}else{
					//允许提现
					$list[$k]['is_docash'] =1;
				}
			}
			
			$this->_list = $list;
			$this->type = $_GET['type'];
			$this->display();
		}
	} */

	//新的提现数据
	public function cash() {
		if (IS_GET) {
			//提现记录
			$list = M('StockAccountFlow')->where(array('pid'=>$_GET['id'],'type'=>2, 'status' => 2, 'state' => 0))->select();
			//获取基金信息
			$stock = M('Stock')->where(array('id'=>$_GET['id'], 'status' => 1))->find();
	
			//交易时间
			$setday = date('Y-m-d');
			if(!empty($stock['into_time'])){
				$settime = strtotime($setday . ' '. $stock['into_time']);
			}else{
				$settime = strtotime($setday);
			}
				
			foreach ($list as $k => $v) {
				$user = M('UsersDetail')->where(array('id'=>$v['uid']))->find();
				$stock = M('Stock')->where(array('id'=>$_GET['id']))->find();
				
				$list[$k]['amount'] = round($v['operation_fund'] * $stock['assets'],2);
				$list[$k]['name'] = $user['name'];
				$list[$k]['phone'] = $user['phone'];
	
				//申请赎回时间大于交易时间
				if($v['create_time'] > $settime){
					//不在本次提现之内
					$list[$k]['is_docash'] =0;
				}else{
					//允许提现
					$list[$k]['is_docash'] =1;
				}
			}
				
			$this->_list = $list;
			$this->type = $_GET['type'];
			$this->display();
		}
	}
	
	//提现记录
	public function cashlist(){
		
		if (IS_GET) {
			//提现记录
			$list = M('StockAccountFlow')->where(array('pid'=>$_GET['id'],'type'=>2, 'status' => 2, 'state' => 1))->order('create_time desc')->select();

			foreach ($list as $k => $v) {
				$user = M('UsersDetail')->where(array('id'=>$v['uid']))->find();
		
				$list[$k]['name'] = $user['name'];
				$list[$k]['phone'] = $user['phone'];
			}
		
			$this->_list = $list;
			$this->type = $_GET['type'];
			$this->display();
		}
	}
	
	
/* 	public function docash() {
			$id = $_GET['id'];
			$type = $_GET['type'];
			if($type==0){
				//获取提现记录
				$cash = M('StockCash')->find($id);
				//获取个人自己账户
				$data = M('StockInvestor')->where(array('pid'=>$cash['pid'],'uid'=>$cash['uid'], 'status'=>0))->find();
				//计算金额
				$assets = $data['assets'];

				$amount = $data['operation_fund'] * $assets;
				//增加投资流水记录
				M('StockInvestorFlow')->add(array('pid'=>$data['pid'], 'uid'=>$data['uid'],
					'operation_fund'=>$data['operation_fund'], 'assets'=>$assets,
					'type'=>2, 'amount'=> $amount,'status'=>2,
					'create_time'=>NOW_TIME, 'update_time'=>NOW_TIME));
				//获取当前项目的详细
				$stock = M('Stock')->find($data['pid']);
				//更新项目信息
				$s = array('operation_fund' =>$stock['operation_fund'] - $data['operation_fund'],
						'id' =>$stock['id'],
						'amount' => $stock['amount'] - $amount , 'update_time'=>NOW_TIME);
				M('Stock')->save($s);
				//更新用户的投资信息
				M('StockInvestor')->save(array('id'=>$data['id'], 'amount'=> 0,
				'fund'=> 0, 'operation_fund'=> 0, 'waiting_fund'=> 0,'assets'=> 0, 'status' => -1));
				
				//更新提现状态
				M('StockInvestorFlow')->where(array('pid'=>$data['pid'], 'uid'=>$data['uid'],
				'status'=>2, 'type'=>1, 'state'=>0))->save(array('state'=>1));
				
				//更新提现记录
				$cash = M('StockCash')->save(array('id'=>$id, 'status'=>2));
				
				//更新账户信息
				//获取用户的账户信息
				$accountuser = M('AccountUser')->where(array('uid'=>$data['uid']))->find();
				$account = array('balance' =>$accountuser['balance'] + $amount + $data['waiting_fund'],
						'id' =>$accountuser['id'],
						'use_able' => $accountuser['use_able'] + $amount + $data['waiting_fund'], 
						'update_time'=>NOW_TIME);
				M('AccountUser')->save($account);
				
			}else{
				$cash = M('StockCash')->find($id);
				$invest = M('StockInvestor')->where(array('pid'=>$cash['pid'],
						'uid'=>$cash['uid'], 'status'=>0))->find();
				$waiting = $invest['waiting_fund'] > $cash['amount'] ? $cash['amount'] : $invest['waiting_fund'];
				$bank = $cash['amount'] - $waiting;
				
				M('StockInvestorFlow')->add(array('pid'=>$cash['pid'], 'uid'=>$cash['uid'],
				'amount'=>$cash['amount'], 'type'=>2, 'create_time'=>NOW_TIME));
				M('StockInvestor')->save(array('id'=>$invest['id'],
				'waiting_fund' => $invest['waiting_fund']-$waiting,
				'amount'=>$invest['amount']-$cash['amount'],
				'fund'=>$invest['fund']-$cash['amount'], 'upate_time'=>NOW_TIME));
				if ($bank > 0) {
					$stock = M('Stock')->find($cash['pid']);
					M('Stock')->save(array('id'=>$stock['id'],
					'amount'=>$stock['amount'] - $bank,
					'fund' => $stock['fund'] - $bank,
					'update_time'=>NOW_TIME));
				}
				$cash = M('StockCash')->save(array('id'=>$id, 'status'=>2));
			}

			$this->success('操作成功');
	} */
	
	//新的提现操作
	public function docash() {
		$id = $_GET['id'];
		$type = $_GET['type'];
		if($type==0){
			//获取提现记录
			$cash = M('StockAccountFlow')->find($id);
			//获取个人自己账户
			$data = M('StockAccount')->where(array('pid'=>$cash['pid'],'uid'=>$cash['uid'], 'status'=>0))->find();
			//计算金额
			$assets = $data['assets'];
	
			//赎回金额
			$amount = $cash['operation_fund'] * $assets;

			//获取当前项目的详细
			$stock = M('Stock')->find($data['pid']);
			//更新项目信息
			$s = array('operation_fund' =>$stock['operation_fund'] - $data['operation_fund'],
					'id' =>$stock['id'],
					'amount' => $stock['amount'] - $amount , 
					'update_time'=>NOW_TIME);
			M('Stock')->save($s);
			
			//更新用户的投资信息
			M('StockAccount')->save(array('id'=>$data['id'], 
				'amount'=> $data['amount'] - $amount,
				'operation_fund'=> $data['operation_fund'] - $cash['operation_fund']));
	
			//更新提现状态
			M('StockAccountFlow')->save(array('id'=>$id,
				'state'=>1,
				'amount'=>$amount,
				'assets'=>$assets,
				'update_time'=>NOW_TIME));
	
			//更新提现记录
			//$cash = M('StockCash')->save(array('id'=>$id, 'status'=>2));
	
			//更新账户信息
			//获取用户的账户信息
			// $accountuser = M('AccountUser')->where(array('uid'=>$data['uid']))->find();
			// $account = array('balance' =>$accountuser['balance'] + $amount,
			// 		'id' =>$accountuser['id'],
			// 		'use_able' => $accountuser['use_able'] + $amount,
			// 		'update_time'=>NOW_TIME);
			// M('AccountUser')->save($account);
	
		}else{
			$cash = M('StockCash')->find($id);
			$invest = M('StockInvestor')->where(array('pid'=>$cash['pid'],
					'uid'=>$cash['uid'], 'status'=>0))->find();
			$waiting = $invest['waiting_fund'] > $cash['amount'] ? $cash['amount'] : $invest['waiting_fund'];
			$bank = $cash['amount'] - $waiting;
	
			M('StockInvestorFlow')->add(array('pid'=>$cash['pid'], 'uid'=>$cash['uid'],
			'amount'=>$cash['amount'], 'type'=>2, 'create_time'=>NOW_TIME));
			M('StockInvestor')->save(array('id'=>$invest['id'],
			'waiting_fund' => $invest['waiting_fund']-$waiting,
			'amount'=>$invest['amount']-$cash['amount'],
			'fund'=>$invest['fund']-$cash['amount'], 'upate_time'=>NOW_TIME));
			if ($bank > 0) {
				$stock = M('Stock')->find($cash['pid']);
				M('Stock')->save(array('id'=>$stock['id'],
				'amount'=>$stock['amount'] - $bank,
				'fund' => $stock['fund'] - $bank,
				'update_time'=>NOW_TIME));
			}
			$cash = M('StockCash')->save(array('id'=>$id, 'status'=>2));
		}
	
		$this->success('操作成功');
	}
}
?>