<?php 
namespace Admin\Controller;
use User\Api\UserApi;

class StockController extends AdminController {
	// 列表
	public function index() {

		$list = M('Stock')->where(array('status'=>array('egt', 0)))->select();
		
		foreach ($list as $k => $v) 
		{
			$stocktemp = M('StockTemp')->where(array('sid'=>$v['id']))->Field('amount, assets, status')->find();
			if ($stocktemp && $stocktemp['status'] == 0) {
				$list[$k]['amount'] = $stocktemp['amount'];
				$list[$k]['assets'] = $stocktemp['assets'];
				$list[$k]['publish'] = 1;
			} else {
				$list[$k]['publish'] = 0;
			}
		}
		
		$this->_list = $list;
		$this->display('index');
	}

	// 添加
	public function add() {

		if(IS_GET) {
			$this->display();
		} else {
			$data = array('name'=>$_POST['name'], 'logo'=>$_POST['logo'], 
				'mobile_logo'=>$_POST['mobile_logo'], 'max_fund'=>$_POST['max_fund'],
				'type'=>$_POST['type'], 'min_fund'=>$_POST['min_fund'],
				'describe' => $_POST['describe'], 'content'=>$_POST['content'],'into_time'=>$_POST['into_time'], 
				'create_time'=>NOW_TIME, 'update_time'=>NOW_TIME);

			M('Stock')->add($data);

			$this->success('项目添加成功', U('index'));
		}

	}

	// 修改
	public function edit() {
		if(IS_GET) {
			$this->data = M('Stock')->where(array('id'=>$_GET['id']))->find();
			$this->display('add');
		} else {
			$data = array('id'=>$_POST['id'], 'name'=>$_POST['name'], 
				'logo'=>$_POST['logo'], 'max_fund'=>$_POST['max_fund'],
				'type'=>$_POST['type'], 'min_fund'=>$_POST['min_fund'],
				'mobile_logo'=>$_POST['mobile_logo'],
				'describe' => $_POST['describe'], 'content'=>$_POST['content'], 'into_time'=>$_POST['into_time'],
				'update_time'=>NOW_TIME);

			M('Stock')->save($data);

			$this->success('项目添加成功', U('index'));
		}
	}

	//投资人信息改成stockaccount表
	public function investorlist() {
		$id = $_GET['id'];
		$list = M('StockAccount')->where(array('pid'=>$id, 'status'=> 0,'amount'=>array('gt',0)))->select();	

		foreach ($list as $k => $v) {
			$user = M('UsersDetail')->where(array('id'=>$v['uid']))->Field('name, phone')->find();
			$list[$k]['username'] = $user['name'];
			$list[$k]['phone'] = $user['phone'];
		}
		$this->pid = $id;
		$this->_list = $list;
		$this->display();
	}

	public function cash() {
		$id = $_GET['id'];
		$data = M('StockInvestor')->find($id);
		$amount = $data['operation_fund'] * $data['assets'];
		M('StockInvestorFlow')->add(array('pid'=>$data['pid'], 'uid'=>$data['uid'], 
			'operation_fund'=>$data['operation_fund'], 'assets'=>$data['assets'],
			'type'=>2, 'amount'=> $amount,'status'=>2, 
			'create_time'=>NOW_TIME, 'update_time'=>NOW_TIME));
		$stock = M('Stock')->find($data['pid']);
		$s = array('operation_fund' =>$stock['operation_fund'] - $data['operation_fund'],
			'id' =>$stock['id'], 
			'amount' => $stock['amount'] - $amount , 'update_time'=>NOW_TIME);
		M('Stock')->save($s);
		M('StockInvestor')->save(array('id'=>$data['id'], 'amount'=> 0, 
			'fund'=> 0, 'operation_fund'=> 0, 'assets'=> 0, 'status' => -1));
		M('StockInvestorFlow')->where(array('pid'=>$data['pid'], 'uid'=>$data['uid'],
			'status'=>2, 'type'=>1, 'state'=>0))->save(array('state'=>1));
		
		//更新提现记录
		$cash = M('StockCash')->where(array('pid'=>$data['pid'],'uid'=>$data['uid'], 'status'=>0))->find();
		
		if($cash){
			//如果有提现记录则更新提现状态
			M('StockCash')->save(array('id'=>$cash['id'], 'status'=>2));
		}
		
		//更新账户信息
		//获取用户的账户信息
		$accountuser = M('AccountUser')->where(array('uid'=>$data['uid']))->find();
		$account = array('balance' =>$accountuser['balance'] + $amount  + $data['waiting_fund'],
				'id' =>$accountuser['id'],
				'use_able' => $accountuser['use_able'] + $amount  + $data['waiting_fund'],
				'update_time'=>NOW_TIME);
		
		M('AccountUser')->save($account);
		
		$this->success('提现申请成功.');
	}

	//新的提现功能
	public function cash_new() {
		$id = $_GET['id'];
		//获取个人投资信息
		$data = M('StockAccount')->find($id);
		//计算出当前金额=当前所有份额*当前净值
		$amount = $data['amount'];
		
		//增加赎回的流水记录
		M('StockAccountFlow')->add(array('pid'=>$data['pid'],
			'uid'=>$data['uid'],
			'operation_fund'=>$data['operation_fund'],
			'assets'=>$data['assets'],
			'amount'=> $amount,
			'over' => $data['over'],
			'type'=>2,
			'state'=>1,
			'status'=>2,
			'remarks'=>'后台提现',
			'create_time'=>NOW_TIME,
			'update_time'=>NOW_TIME));
		
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
			'amount'=> 0,
			'fund'=> 0,
			'assets'=> 0,
			'operation_fund'=> 0,
			'final_operation'=>0,
			'over'=>0,
			'rate_money' => $data['rate_money'] + $data['over'],
			'waiting_fund'=>0));
		
		//更新账户信息
		//获取用户的账户信息
		// $accountuser = M('AccountUser')->where(array('uid'=>$data['uid']))->find();
		// $account = array('balance' =>$accountuser['balance'] + $amount  + $data['waiting_fund'],
		// 		'id' =>$accountuser['id'],
		// 		'use_able' => $accountuser['use_able'] + $amount  + $data['waiting_fund'],
		// 		'update_time'=>NOW_TIME);
	
		// M('AccountUser')->save($account);
	
		$this->success('提现申请成功.');
	}
	
	public function changestatus() {
		if (IS_AJAX) {
			$status = $_GET['status'];
			$id = $_GET['id'];

			M('Stock')->save(array('id'=>$id, 'status'=>$status, 'update_time'=>NOW_TIME));

			$this->success('项目状态修改成功。');
		}
	}

	public function updatetatus() {
		if (IS_GET) {
			$id = $_GET['id'];
	
			$info = M('IndividualList')->find($id);
			if(!$info){
				$this->error('记录不存在');
			}
			M('IndividualList')->save(array('id'=>$id, 'status'=>-1));
	
			$this->success('撤销成功。', U('individuallist?id='.$info['pid']));
		}
	}
	
	public function investor_add() {
		if (IS_GET) {
			$this->data = array('pid'=>$_GET['pid']);
			$this->display('investor_add');
		} else {
			$stock = M('Stock')->where(array('id'=>$_POST['pid']))->find();
			if ($_POST['original'] == '1') {
				$operation_fund = $_POST['amount'];
				$assets = 1;
			} else {
				$operation_fund = round(($_POST['amount'] / $stock['assets']),2);
				$assets = $stock['assets'];
			}
			
			$data = array('uid'=>$_POST['uid'], 'pid'=>$_POST['pid'], 'type'=>'1', 
				'operation_fund'=> $operation_fund, 'assets'=>$assets,'state'=>1,
				'amount'=>$_POST['amount'], 'remarks'=>$_POST['remarks'],
				'status'=>2, 'create_time'=>NOW_TIME, 'update_time' => NOW_TIME);

			M('StockAccountFlow')->add($data);

			$invest = M('StockAccount')->where(
				array('pid'=>$data['pid'], 'uid'=>$data['uid'], 'status' => 0))->find();

			
			$v = array('pid'=>$data['pid'], 'uid'=>$data['uid'], 'assets' =>$stock['assets'],
					'operation_fund'=> $operation_fund,
					'fund'=>$data['amount'], 'update_time' => NOW_TIME);
			
			if (!$invest) {
				$v['create_time'] = NOW_TIME;
				$v['amount'] = $operation_fund * $stock['assets'];
				$v['over'] = ($operation_fund * $stock['assets']) - $data['amount'];
				M('StockAccount')->add($v);
			} else {
				$v['id'] = $invest['id'];
				$v['amount'] = $invest['amount'] + $data['amount'];
				$v['fund'] = $invest['fund'] + $data['amount'];
				$v['operation_fund'] =$invest['operation_fund']+$v['operation_fund'];

				M('StockAccount')->save($v);
			}
			$stock['amount'] += ($operation_fund * $stock['assets']);
			$stock['fund'] += $data['amount'];
			$stock['operation_fund'] += $operation_fund;
			
			M('Stock')->save(array('id'=>$stock['id'], 'amount'=> $stock['amount'], 
				'fund'=>$stock['fund'], 'operation_fund' => $stock['operation_fund'], 
				'over'=>($stock['over'] + $v['over']), 'update_time'=>NOW_TIME));
			$this->success('投资信息添加成功。', U('investorlist?id='.$data['pid']));
		}
	}

	public function update() {
		$pid = $_GET['id'];
		
		//获取当日12点前的数据
		$waiting = M('StockInvestor')->where(array('pid'=>$pid,
			'waiting_fund'=>array('gt', 0)))->select();

		$operation_fund = 0;
		$amount = 0;
		$stock = M('Stock')->find($pid);
		foreach ($waiting as $k => $v) {
			$flow = M('StockInvestorFlow')->where(
				array('pid'=>$v['pid'], 
					'uid'=>$v['uid'],
					'type'=>1, 'status'=>2, 
					'assets'=>0))->select();

			foreach ($flow as $k1 => $v1) {
				M('StockInvestorFlow')->save(array(
					'assets'=>$stock['assets'], 
					'operation_fund'=> ($v1['amount'] / $stock['assets']),
					'id' => $v1['id']));
			}

			$of = $v['waiting_fund'] / $stock['assets'];

			M('StockInvestor')->save(array('id'=>$v['id'], 
				'assets'=>$stock['assets'], 'waiting_fund' => 0,
				'operation_fund' => $v['operation_fund'] + $of, ));
			$operation_fund += $of;
			$amount += $v['waiting_fund'];
		}

		M('Stock')->save(array('id'=>$pid, 'amount'=>($stock['amount'] + $amount),
			'operation_fund' => $stock['operation_fund'] + $operation_fund, 
			'fund'=>$stock['fund'] + $amount));
		
		$this->success('处理成功！');
	}
	
//添加指定合计时间3.5
	public function update_new() {
		if(IS_GET) {
			$id = $_GET['id'];
			$this->id = $id;
			$this->display();
		} else {
			$pid = $_POST['id'];
			$setday = $_POST['setday'];

			//获取临时表信息
			$stocktemp = M('StockTemp')->where(array('sid'=>$pid,'status'=>0))->find();
			if($stocktemp){
				$this->error('请先公布当日净值！');
			}
			
			//获取项目信息
			$stock = M('Stock')->where(array('id'=>$pid))->find();
			

			//空军的时间+15：30
			if(!empty($stock['into_time'])){
				$settime = strtotime($setday . ' '. $stock['into_time']);
			}else{
				$settime = strtotime($setday);
			}

			//获取有等待金额的记录
			$waiting = M('StockAccount')->where(array('pid'=>$pid,'waiting_fund'=>array('gt', 0)))->select();
			
			//累加的份额
			$operation_fund = 0;
			//累加的金额
			$amount = 0;
			foreach ($waiting as $k => $v) {
				$waiting_amount =0;
				$flow = M('StockAccountFlow')->where(
						array('pid'=>$v['pid'],
								'uid'=>$v['uid'],
								'type'=>1, 
								'status'=>2, 
								'state' => 1,
								'assets'=>0,'create_time'=>array('lt', $settime)))->select();
			
				if($flow){
					foreach ($flow as $k1 => $v1) {
						M('StockAccountFlow')->save(array(
							'assets'=>$stock['assets'],
							'operation_fund'=> ($v1['amount'] / $stock['assets']),
							'id' => $v1['id'],
							'state'=>1, 'update_time' => NOW_TIME));
							
						//累加在当前时间范围内的等待金额
						$waiting_amount += $v1['amount'];
					}
		
					//$of = $v['waiting_fund'] / $stock['assets'];
					$of = $waiting_amount / $stock['assets'];

					//增加成本计算
					$total_operation = $v['operation_fund'] + $of;
					//计算成本
					$final_assets = ($waiting_amount *$stock['assets'] + $v['operation_fund'] * $v['assets'])/$total_operation;
					
					
					
					M('StockAccount')->save(array('id'=>$v['id'],
						'assets'=>$stock['assets'], 
						'final_assets'=>$final_assets,
						'waiting_fund' => $v['waiting_fund'] - $waiting_amount,
						'operation_fund' => $v['operation_fund'] + $of, ));
					
					$operation_fund += $of;
					//$amount += $v['waiting_fund'];
					$amount +=	$waiting_amount;
					
				}
			}
			
			//更新基金基本信息
			M('Stock')->save(array('id'=>$pid, 
				'amount'=>($stock['amount'] + $amount),
				'operation_fund' => $stock['operation_fund'] + $operation_fund,
				'fund'=>$stock['fund'] + $amount));
			
			$this->success('处理成功！');
		}
		
	}
	
	//冻结个股资金
	public function updatefreeze() {
		$pid = $_GET['id'];
		$waiting = M('StockInvestor')->where(array('pid'=>$pid,
				'waiting_fund'=>array('gt', 0)))->select();
	
		$operation_fund = 0;
		$amount = 0;
		$stock = M('Stock')->find($pid);
		
		if($stock['is_freeze'] ==1){
			$this->error('请不要重复冻结');
		}
		
		//获取计划明细数据
		$planlist = M('IndividualList')->where(array('pid'=>$pid,'status'=>0))->select();
		
		if(!$planlist){
			$this->error('没有需要购买的股票');
		}
		foreach ($waiting as $k => $v) {
			$of = round($v['waiting_fund'] / $stock['assets'],6);
	
			M('StockInvestor')->save(array('id'=>$v['id'],
			'assets'=>$stock['assets'], 'waiting_fund' => 0,
			'operation_fund' => $v['operation_fund'] + $of, ));
			$operation_fund += $of;
			$amount += $v['waiting_fund'];
		}
	
		if($stock['amount'] < 1 && $amount < 1){
			$this->error('资金不足，不允许冻结');
		}
		
		M('Stock')->save(array('id'=>$pid, 'amount'=>($stock['amount'] + $amount),
		'operation_fund' => $stock['operation_fund'] + $operation_fund,
		'fund'=>$stock['fund'] + $amount,'is_freeze'=>1));
	
		//个股
		$stocknew = M('Stock')->find($pid);
		
		//更新个股的总份额
		$data = array('status'=>1,'amount'=>$stocknew['amount'],'fund'=>$stocknew['operation_fund']);
		
		M('IndividualList')->where(array('status'=>0,'pid'=>$pid))->save($data);
	
		$this->success('处理成功！');
	}
	
	public function finduid() {
		$uid = M('UsersDetail')->
			where(array('name'=>$_POST['name'], 'phone'=>$_POST['phone']))->getField('id');
		if (!$uid) {
			$User = new UserApi;
			$phone = $_POST['phone'];
			$name = $_POST['name'];
			$pwd = substr($phone, strlen($phone) - 6);
			$uid = $User->register($name, $pwd, ($phone . '@guzhi.com'));
			if ($uid > 0) {
				$user = array('id'=> $uid, 'nickname'=>$name, 'photo'=>0, 'status'=>1, 'reg_ip'=> 2130706433, 'create_time'=>NOW_TIME, 'update_time'=>NOW_TIME);
				M('Users')->add($user);
				$detail = array('id'=>$uid, 'name'=>$name, 'card_id'=>'', 'province'=>'', 'city'=>'', 'phone'=>$phone);
				M('UsersDetail')->add($detail);
				$this->ajaxReturn(array('status'=>1, 'uid'=>$uid, 'newuser'=>1));	
			} else {
				$this->error($uid);
			}
		} else {
			$this->ajaxReturn(array('status'=>1, 'uid'=>$uid));
		}
	}

	// 结算换成stockaccount表
	public function manage() {
		if(IS_GET) {
			$id = $_GET['id'];
			$this->id = $id;
			$this->display();
		} else {
			$id = $_POST['id'];
			$amount = $_POST['amount'];
			$setday = $_POST['setday'];

			if($amount==''){
				$this->error('请输入当日净值');
				return;
			}
			if($setday==''){
				$this->error('请选择日期');
				return;
			}
			
			//获取项目信息
			$stock = M('Stock')->find($id);
			$amount = $amount + $stock['amount']; 	// 填写实际盈亏
			//净值=总金额/总份额
			$assets = round($amount / $stock['operation_fund'], 6);
/* 			//保存历史净值
			M('StockFlow')->add(array('sid'=>$id, 
				'operation_day'=>NOW_TIME, 
				'amount'=>$stock['amount'], 
				'fund'=>$stock['fund'], 
				'operation_fund'=>$stock['operation_fund'], 
				'assets'=>$stock['assets'],
				'over'=>$amount - $stock['amount'],
				'create_time'=>NOW_TIME, 
				'update_time'=>NOW_TIME)); */

			//收益
			$over = $stock['over'] + $amount - $stock['amount'];
/* 		//更新项目信息
			M('Stock')->save(array('id'=>$id, 
				'over'=>$over, 
				'amount'=>$amount, 
				'assets'=>$assets, 
				'opration_day'=>NOW_TIME,
				'update_time'=>NOW_TIME)); */
			
			//获取项目信息
			$stocktemp = M('StockTemp')->where(array('sid'=>$id))->find();

			if($stocktemp){
				//净值保存到临时表
				M('StockTemp')->save(array('id'=>$stocktemp['id'],
				'amount'=>$amount,
				'assets'=>$assets,
				'over'=>$over,
				'status'=>0,
				'opration_day'=>strtotime($setday),
				'update_time'=>NOW_TIME));
			}else{
				//净值保存到临时表
				M('StockTemp')->add(array('sid'=>$id,
				'amount'=>$amount,
				'assets'=>$assets,
				'over'=>$over,
				'opration_day'=>strtotime($setday),
				'create_time'=>NOW_TIME,
				'update_time'=>NOW_TIME));
			}


			//获取所有投资记录
			//$invest = M('StockAccount')->where(array('pid'=>$id, 'status'=>0))->select();
			//foreach ($invest as $k => $v) {
				//$over = $v['operation_fund'] * ($assets-$v['assets']);
/* 				M('StockInvestorFlow')->add(array('pid'=>$id, 'uid'=>$v['uid'], 'type'=>0,
					'fund'=>$v['fund'], 'operation_fund'=>$v['operation_fund'], 
					'over'=>$over, 'assets'=>$v['assets'],
					'status'=>2, 'create_time'=>NOW_TIME, 'update_time'=>NOW_TIME)); */
				
			/* 	M('StockInvestor')->save(array('id'=>$v['id'], 
					'amount'=>$v['amount'] + $over, 
					'assets'=>$assets, 
					'over'=>($v['over'] + $over), 
					'update_time'=>NOW_TIME)); */
			//}
			$this->success('结算成功。');
		}
	}

	// 申购金额
	public function purchase() {
		if(IS_GET) {
			$id = $_GET['id'];
			$pid = $_GET['pid'];
			$info = M('Plan' )->find($pid);
			
			$this->total_money = $info['total_amount'] - $info['freeze_amount'];
			$this->id = $id;
			$this->pid = $pid;
			$this->display();
		} else {
			$id = $_POST['id'];
			$pid = $_POST['pid'];
			$purchase_amount = $_POST['amount'];
			$purchase_count = $_POST['count'];
	
			$info = M('Plan' )->find($pid);
			
			$ipolist = M('IpoList')->where(array('pid'=>$id))->select();
			
			foreach ($ipolist as $k => $v) {
				M('IpoList')->save(array('id'=>$v['id'],
					'real_amount'=> round($v['share'] * $purchase_amount,2),
					'update_time'=>NOW_TIME));
			}
			
			M('Plan')->save(array('id'=>$pid,
				'freeze_amount'=> $info['freeze_amount'] + $purchase_amount,
				'update_time'=>NOW_TIME));
			
			M('PlanList')->save(array('id'=>$id,
				'purchase_amount'=>$purchase_amount,
				'purchase_count'=>$purchase_count,
				'status'=>1, 
				'update_time'=>NOW_TIME));

			$this->success('申购成功。');
		}
	}

	// 中签结果金额
	public function real() {
		if(IS_GET) {
			$id = $_GET['id'];
			$pid = $_GET['pid'];
			$this->id = $id;
			$this->pid = $pid;
			$this->display();
		} else {
			$id = $_POST['id'];
			$pid = $_POST['pid'];
			$real_amount = $_POST['amount'];
			$real_count = $_POST['count'];
			
			//修改plan冻结金额
			$plan = M('Plan' )->find($pid);
			$planlist = M('PlanList' )->find($id);
			
			//更新中签
			M('PlanList')->save(array('id'=>$id,
				'real_amount'=>$real_amount,
				'real_count'=>$real_count,
				'status'=>2,
				'update_time'=>NOW_TIME));
			
		
			
			//退回的金额
			$use = $planlist['purchase_amount'] - $real_amount;
			
			if($use >0){
				M('Plan')->save(array('id'=>$pid,
					'freeze_amount'=> $plan['freeze_amount'] - $use,
					'over_amount'=> $plan['over_amount'] + $use,
					'update_time'=>NOW_TIME));
				
				//获取计划明细数据
				$ipolist = M('IpoList')->where(array('planid'=>$planlist['pid'],'pid'=>$planlist['id']))->select();
					
				//更新投资账户数据
				foreach ($ipolist as $k => $v) {
					$use_amount = $use * $v['share'];
					$info = M('StockInvestor')->where(array('pid'=>$plan['pid'],'uid'=>$v['uid']))->find();
					M('StockInvestor')->save(
						array('id'=>$info['id'],
						'use_amount'=> $info['use_amount'] + $use_amount,
						'freeze_money'=> $info['freeze_money'] - $use_amount,
						));
					
					M('IpoList')->save(array('id'=>$v['id'],
						'real_amount'=> $v['share'] * $real_amount,
						'update_time'=>NOW_TIME));
				
				}
			}
			$this->success('中签结果输入成功。');
		}
	}
	
	// 收益
	public function share() {
		if(IS_GET) {
			$id = $_GET['id'];
			$pid = $_GET['pid'];
			$this->id = $id;
			$this->pid = $pid;
			$this->display();
		}else{
			$id = $_POST['id'];
			$pid = $_POST['pid'];
			$amount = $_POST['amount'];
			$count = $_POST['count'];
			
			//获取计划信息
			$plan = M('Plan')->find($pid);
			
			//更新收益率
			M('Plan')->save(array('id'=>$pid,
				'rate_amount'=> $plan['rate_amount'] + $amount,
				'update_time'=>NOW_TIME));
			
			//记录收益
			M('PlanList')->save(array('id'=>$id,
				'net_value'=>$amount,
				'rate'=> $count,
				'status'=>3,
				'rate_date'=>NOW_TIME,
				'update_time'=>NOW_TIME));
			
			$ipolist = M('IpoList')->where(array('pid'=>$id))->select();
				
			foreach ($ipolist as $k => $v) {
				//投资人收益记录
				M('IpoList')->save(array('id'=>$v['id'],
					'rate'=> $v['share'] * $amount,
					'update_time'=>NOW_TIME));
				
				$all_amount = $v['real_amount'] + $v['share'] * $amount;
				if($all_amount > 0){
					$info = M('StockInvestor')->where(array('pid'=>$plan['pid'],'uid'=>$v['uid']))->find();
					
					//预提金额-收益
					$drawcash = $info['drawcash'] - $v['share'] * $amount;
					
					if($drawcash < 0){
						$drawcash = 0;	
					}
					
					M('StockInvestor')->save(
						array('id'=>$info['id'],
						'use_amount'=> $info['use_amount'] + $all_amount,
						'freeze_money'=> $info['freeze_money'] - $all_amount,
						'rate_money'=> $info['rate_money'] + $v['share'] * $amount,
						'amount'=> $info['amount'] + $v['share'] * $amount,
						'drawcash'=> $drawcash,
						));
				}
			}
			
			$this->success('利益发放成功。');
		}
	}
	// 投资人管理
	public function investors() {

	}
	
	
	// 个股购买列表
	public function individuallist() {
		$pid = $_GET['id'];
		$list = M('IndividualList')->where(array('pid'=>$pid))->select();
		int_to_string($list,array('status'=>array('-1'=>'已撤销','0'=>'众筹中','1'=>'等待买入','2'=>'已买入','3'=>'已卖出','4'=>'已完成')));
		$this->_list = $list;
		$this->pid = $pid;
		$this->display();
	}
	
	// 个股买入
	public function buy() {
		if(IS_GET) {
			$id = $_GET['id'];
			$pid = $_GET['pid'];
			$info = M('stock' )->find($pid);
			
			$fund = M('IndividualList')->where(array('pid'=>$pid,'status'=>2))->sum('buy_amount');
				
			$this->total_money = $info['amount'] - $fund;
			$this->id = $id;
			$this->pid = $pid;
			$this->display();
		} else {
			$id = $_POST['id'];
			$pid = $_POST['pid'];
			$buy_price = $_POST['price'];
			$buy_amount = $_POST['amount'];
			$buy_count = $_POST['count'];	
				
			M('IndividualList')->save(array('id'=>$id,
				'buy_price'=>$buy_price,
				'buy_amount'=>$buy_amount,
				'buy_count'=>$buy_count,
				'status'=>2,
				'buy_time'=>NOW_TIME));
	
			$this->success('购买成功。');
		}
	}
	
	// 卖出
	public function sell() {
		if(IS_GET) {
			$id = $_GET['id'];
			$pid = $_GET['pid'];

			$this->id = $id;
			$this->pid = $pid;
			$this->display();
		}else{
			$id = $_POST['id'];
			$pid = $_POST['pid'];
			$amount = $_POST['amount'];
			$price = $_POST['price'];
			$rate = $_POST['rate'];
		
			//获取当前记录
			$individuallist = M('IndividualList')->find($id);
			
			//总份额
			$fund =$individuallist['fund'];
			//利润
			$rate_amount = $amount - $individuallist['buy_amount'];
			//收益率
			//$rate = round($rate_amount / $individuallist['buy_amount'], 4);

			//更新卖出价格和金额
			M('IndividualList')->save(array('id'=>$id,
				'sell_price'=>$price,
				'sell_amount'=>$amount,
				'status'=>3,
				'rate_amount'=>$rate_amount,
				'rate'=>$rate,
				'sell_time'=>NOW_TIME));

			//利益分配
			$list = M('StockInvestor')->where(array('pid'=>$pid))->select();
			
			//查看推荐人是否在投资人里面
			$hasinvestor = M('StockInvestor')->where(array('pid'=>$pid,'uid'=>$individuallist['uid']))->find();
			
			if($hasinvestor){
				//推荐人的提成=总收益*10%
				$recommend_amount = $rate_amount * 0.1;
				
				//实际收益= 总收益-提成
				$rate_amount = $rate_amount - $recommend_amount;
			}else{
				$recommend_amount = 0;
			}
			foreach ($list as $k => $v) {
				//当前份额
				$of = $v['operation_fund'] / $fund;
				
				//如果是推荐人，增加10%的收益
				if($individuallist['uid'] ==$v['uid']){

					$user_amount= $of * $rate_amount +$recommend_amount;
				}else{
					//个人收益
					$user_amount = $of * $rate_amount;
				}
				

				M('StockInvestor')->save(
					array('id'=>$v['id'],
						'amount'=> $v['amount'] + $user_amount,
						'over'=> $v['over'] + $user_amount,
				));		
			}
			
			
			
			$this->success('卖出成功。');
		}
	}
	
	
	// 申购计划
	public function plan() {
		$id = $_GET['id'];
		$list = M('Plan')->select();
		int_to_string($list,array('status'=>array('0'=>'众筹中','1'=>'资金冻结','2'=>'已申购','3'=>'持有','4'=>'收益已发放')));
		$this->_list = $list;
		$this->pid = $id;
		$this->display();
	}
	
	
	// 申购计划
	public function planlist() {
		$id = $_GET['id'];
		$list = M('PlanList')->where(array('pid'=>$id))->select();
		int_to_string($list,array('status'=>array('0'=>'未申购','1'=>'已申购','2'=>'持有','3'=>'收益已发放')));
		$this->_list = $list;
		$this->pid = $id;
		$this->display();
	}
	

	
	//添加计划
	public function addplan() {
		if (IS_GET) {
			if($_GET['id']){
				$plan = M('Plan')->find($_GET['id']);
				$this->data = $plan;
			}else{
				$this->data = array('pid'=>$_GET['pid']);
			}
			
			$this->display();
		} else {
			$data = array(
					'pid'=>$_POST['pid'],
					'name'=>$_POST['name'],
					'purchasedate'=> strtotime($_POST['purchasedate']) ,
					'create_time'=>NOW_TIME, 
					'update_time' => NOW_TIME);
				
			if($_POST['id']){
				M('plan')->where(array('id'=>$_POST['id'],))->save($data);
			}else{
				M('plan')->add($data);
			}
				
	
			$this->success('投资信息添加成功。',U('stock/plan',array('id'=>$_POST['pid'])));
		}
	}
	
	//添加计划
	public function addplanlist() {
		if (IS_GET) {
			if($_GET['id']){
				$plan = M('PlanList')->find($_GET['id']);
				$this->data = $plan;
			}else{
				$this->data = array('pid'=>$_GET['pid']);
			}
			
			$this->display();
		} else {
			$data = array(
					'pid'=>$_POST['pid'],
					'shareid'=>$_POST['shareid'],
					'sharename'=>$_POST['sharename'],
					'price'=>$_POST['price'],
					'purchasedate'=> strtotime($_POST['purchasedate']) ,
					'releasedate'=>strtotime($_POST['releasedate']),
					'create_time'=>NOW_TIME, 'update_time' => NOW_TIME);
	
			if($_POST['id']){
	
				M('PlanList')->where(array('id'=>$_POST['id'],))->save($data);
			}else{
				M('PlanList')->add($data);
			}
	
	
			$this->success('投资信息添加成功。',U('stock/planlist',array('id'=>$_POST['pid'])));
		}
	}
	
	//冻结资金
	public function freeze() {
		//项目ID
		$pid = $_GET['pid'];
		//planID
		$id = $_GET['id'];
		$waiting = M('StockInvestor')->where(array('pid'=>$pid,'waiting_fund'=>array('gt', 0)))->select();
	
		$operation_fund = 0;
		$amount = 0;
		$stock = M('Stock')->find($pid);
		foreach ($waiting as $k => $v) {
			$of = $v['waiting_fund'] / $stock['assets'];
	
			M('StockInvestor')->save(array('id'=>$v['id'],
			'assets'=>$stock['assets'],
			'waiting_fund' => 0,
			'operation_fund' => $v['operation_fund'] + $of,
			'use_amount' => $v['operation_fund'] + $of, ));
			$operation_fund += $of;
			$amount += $v['waiting_fund'];
		}
	
		M('Stock')->save(array(
			'id'=>$pid,
			'amount'=>($stock['amount'] + $amount),
			'operation_fund' => $stock['operation_fund'] + $operation_fund,
			'fund'=>$stock['fund'] + $amount));
	
	
		//ipolist
		//获取计划信息
		$plan = M('Plan')->find($id);
		//获取计划明细数据
		$planlist = M('PlanList')->where(array('pid'=>$id))->select();
	
		//获取当前可用金额
		$where = array('pid'=>$pid,'use_amount'=>array('gt', 0));
		$freezefund = M('StockInvestor')->where($where)->select();
		//所有可用金额
		$all_amount = M('StockInvestor')->where($where)->sum('use_amount');
		//预提金额
		$drawcash = M('StockInvestor')->where($where)->sum('drawcash');
		//实际可用金额
		$all_amount = $all_amount -$drawcash;
	
		//更新计划总额
		M('Plan')->save(array(
			'id'=>$id,
			'total_amount'=>$all_amount,
	/* 		'freeze_amount'=>$use_amount, */
			'is_freeze'=>1));
	

		//增加投资记录ipolist
		foreach ($freezefund as $k => $vo) {
			$use_amount = $vo['use_amount'] - $vo['drawcash'];
			$of = $use_amount / $all_amount;

			foreach ($planlist as $k => $v) {
				M('IpoList')->add(array(
					'planid'=>  $v['pid'],
					'pid'=>  $v['id'],
					'uid' => $vo['uid'],
					'amount' => $use_amount,
					'real_amount' => $use_amount,
					'share' => $of,));
			}
		
			//投资记录资金冻结
			M('StockInvestor')->save(array('id'=>$vo['id'],
				'use_amount'=> 0,
				'freeze_money' => $use_amount));
			
		}
			
		$this->success('处理成功！');
	}
	
	//资金解冻
	public function unfreeze() {
		//项目ID
		$pid = $_GET['pid'];
		//planID
		$id = $_GET['id'];
		//获取计划明细数据
		$planlist = M('PlanList')->where(array('pid'=>$id,'purchase_count'=>array('gt', 0)))->select();
		
		foreach ($planlist as $k => $v) {
			if($k==0){
				$planid = $v['pid'];
				$ipo_pid = $v['id'];
			}
			if($v['status']==0){
				$this->error('解冻失败');
			}
		}
		
		//获取计划明细数据
		$plan = M('Plan')->find($id);
		
		$use = $plan['total_amount'] -$plan['freeze_amount'];
		
		if($use >0){
			M('Plan')->save(array('id'=>$plan['id'],'over_amount'=> $use,'is_freeze'=>2));
			//获取计划明细数据
			$ipolist = M('IpoList')->where(array('planid'=>$planid,'pid'=>$ipo_pid))->select();
			
			foreach ($ipolist as $k => $v) {
				$use_amount = $use * $v['share'];
				$info = M('StockInvestor')->where(array('pid'=>$plan['pid'],'uid'=>$v['uid']))->find();
				
				$freeze = $info['freeze_money'] - $use_amount;
				
				if($freeze < 0 ){
					$freeze = 0;
				}
				M('StockInvestor')->save(
					array(
					'id'=>$info['id'],
					'use_amount'=> $info['use_amount'] + $use_amount,
					'freeze_money'=> $freeze,
					));
				
			}
		}
		
		$this->success('解冻成功');

	}
	
	//资金解冻
	public function updateunfreeze() {
		//状态
		$status = 0;
		//planID
		$id = $_GET['id'];

		//获取计划明细数据
		$planlist = M('IndividualList')->where(array('pid'=>$id,'status'=>array(array('gt', 0),array('lt', 3),'AND')))->select();
	
		if($planlist){
			$this->error('解冻失败,存在未结算的股票');
		}
		//当前期所有的利润
		$rate_amount = M('IndividualList')->where(array('pid'=>$id,'status'=>3))->sum('rate_amount');
		
		//获取总的项目信息
		$stock = M('Stock')->find($id);
			
		//保存前一天的数据备份
		M('StockFlow')->add(array('sid'=>$id, 'operation_day'=>NOW_TIME,
			'amount'=>$stock['amount'], 'fund'=>$stock['fund'],
			'operation_fund'=>$stock['operation_fund'], 'assets'=>$stock['assets'],
			'over'=>$stock['over'],
			'create_time'=>NOW_TIME, 'update_time'=>NOW_TIME));
			
		//更新完成数据
		
		//累积收益
		$over = $stock['over'] + $rate_amount;
		//总金额
		$allamount = $stock['amount'] + $rate_amount;
		//跟新stock数据
		M('Stock')->save(array('id'=>$id, 'over'=>$over, 'amount'=>$allamount,'is_freeze'=>$status, 'update_time'=>NOW_TIME));
		
		//更新当前期的交易状态
		M('IndividualList')->where(array('pid'=>$id,'status'=>3))->save(array('status'=>4));
		
		$this->success('解冻成功');
	
	}
	
	//投资人信息
	public function ipolist() {
		$id = $_GET['id'];
		$list = M('IpoList')->where(array('pid'=>$id))->select();
	
		foreach ($list as $k => $v) {
			$user = M('UsersDetail')->where(array('id'=>$v['uid']))->Field('name, phone')->find();
			$list[$k]['username'] = $user['name'];
			$list[$k]['phone'] = $user['phone'];
		}
		$this->pid = $id;
		$this->_list = $list;
		$this->display();
	}
	
	public function changeplan() {
		if (IS_AJAX) {
			$status = $_GET['status'];
			$id = $_GET['id'];
	
			M('Plan')->save(array('id'=>$id, 'status'=>$status, 'update_time'=>NOW_TIME));
	
			$this->success('计划状态修改成功。');
		}
	}
	
	//确认发布
	public function publish(){
		if (IS_AJAX) {

			$id = $_GET['id'];
		
			//获取项目信息
			$stock = M('Stock')->find($id);
			
			//获取临时表信息
			$stocktemp = M('StockTemp')->where(array('sid'=>$id,'status'=>0))->find();
			
			if(!$stocktemp){
				$this->error('请先结算当日收益');
			}
			//当前净值
			$assets = $stocktemp['assets'];
			
			//保存历史净值
			M('StockFlow')->add(array('sid'=>$id,
				'operation_day'=>$stock['opration_day'],
				'amount'=>$stock['amount'],
				'fund'=>$stock['fund'],
				'operation_fund'=>$stock['operation_fund'],
				'assets'=>$stock['assets'],
				'over'=>$stock['over'],
				'create_time'=>NOW_TIME,
				'update_time'=>NOW_TIME,
				'status'=>1));
			
			//更新项目信息
			M('Stock')->save(array('id'=>$id,
				'over'=>$stocktemp['over'],
				'amount'=>$stocktemp['amount'],
				'assets'=>$stocktemp['assets'],
				'opration_day'=>$stocktemp['opration_day'],
				'update_time'=>NOW_TIME));
			
			//获取所有投资记录
			$invest = M('StockAccount')->where(array('pid'=>$id, 'status'=>0))->select();
			foreach ($invest as $k => $v) {
				$over = $v['operation_fund'] * ($assets-$v['assets']);
				/* 				M('StockInvestorFlow')->add(array('pid'=>$id, 'uid'=>$v['uid'], 'type'=>0,
				 'fund'=>$v['fund'], 'operation_fund'=>$v['operation_fund'],
						'over'=>$over, 'assets'=>$v['assets'],
						'status'=>2, 'create_time'=>NOW_TIME, 'update_time'=>NOW_TIME)); */
			
				M('StockAccount')->save(array('id'=>$v['id'],
					'amount'=>$v['amount'] + $over,
					'assets'=>$assets,
					'over'=>($v['over'] + $over),
					'update_time'=>NOW_TIME));
			}
			
			//更新临时表内容
			M('StockTemp')->save(array('id'=>$stocktemp['id'],
				'status'=>1,
				'update_time'=>NOW_TIME));
			
			$this->success('结算成功。');
		}
	}

	public function buylist() {
		$this->_list = D('StockAccountFlowView')->
			where(array('f.status'=>2, 'f.type'=>1, 'f.pid'=>$_GET['pid'], 
				'f.uid'=>$_GET['uid']))->order('f.create_time desc')->select();
		$this->display('buylist');
	}
}
?>