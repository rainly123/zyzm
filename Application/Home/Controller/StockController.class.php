<?php 
namespace Home\Controller;
use Think\Log;

class StockController extends HomeController {
	public function index() {
		$id = I('id', 1);
		$data = M('Stock')->find($id);
		
		if($data['status'] != 1){
			$this->error('该项目已下线！');
		}
		
		//$data['investor_count'] = M('StockInvestor')->where(array('pid'=>$id, 'status'=> 0))->count();
		$data['investor_count'] = M('StockAccount')->where(array('pid'=>$id, 'status'=> 0))->count();
		$this->data = $data;

		$uid = is_login();
		if ($uid) {
			//$investor = M('StockInvestor')->where(array('pid'=>$id, 'uid'=>$uid, 'status'=>0))->find();
			$investor = M('StockAccount')->where(array('pid'=>$id, 'uid'=>$uid, 'status'=>0))->find();
		}
		$projects = M('Project')->where(array('status'=>9, 'stage'=>array(array('elt', 4), array('gt', 0),'AND')))->
			order('stage desc, is_top desc, create_time desc')->limit(4)->select();

		$where = array('pid'=>$id, 'day' => $data['useday']);
		$suggest = M('StockSuggestion')->where($where)->select();
		$vote_count = 0;
		foreach ($suggest as $key => $v) {
			$vote_count += $v['count'];
		}

		$where = array('pid'=>$id, 'status' => 0);
		$individuallist = M('IndividualList')->where($where)->select();
		$voting_count = 0;
		foreach ($individuallist as $key => $v) {
			$voting_count += $v['count'];
		}
		
		$ratelist =M('IndividualList')->where(array('pid'=> $id,'status'=>array('egt', 1)))->order('create_time desc')->select();
		
		if (isMobile()) {
			$limitpage=5;
		}else{
			$limitpage=10;
		}
		
		//获取历史净值
		$assetslist = M('StockFlow')->where(array('sid'=> $id,'status'=>1))->order('operation_day desc')->limit($limitpage)->select();

		foreach ($assetslist as $key => $vo) {
			//油多多替换成美国时间
			if($vo['sid']==6){
				$operation_day =$vo['operation_day'] - 12*60*60;
			}else{
				$operation_day =$vo['operation_day'];
			}
			
			if($key==0){
				$day_arry= "'".time_format($operation_day, 'm-d')."'";
				$assets_arry= round($vo['assets'],4);
			}else{
				$day_arry = "'".time_format($operation_day, 'm-d')."'" .','.$day_arry;
				$assets_arry = round($vo['assets'],4) . ','.$assets_arry;
			}
		}

		//油多多替换成美国时间
		if($data['id']==6){
			$opration_day =$data['opration_day'] - 12*60*60;
		}else{
			$opration_day =$data['opration_day'];
		}
		
		$charts['operation_day']= $day_arry .','. "'".time_format($opration_day, 'm-d')."'";
		$charts['assets_arry']= $assets_arry.','. round($data['assets'],4);
		
		$where = array('p.status'=>1);
		$planlist = D('PlanView')->where($where)->select();

		M('Stock')->where(array('id'=>$id))->setInc('read_count', 1);
		//$this->waiting_fund = M('StockInvestor')->where(array('pid'=>$id))->sum('waiting_fund');
		$this->waiting_fund = M('StockAccount')->where(array('pid'=>$id))->sum('waiting_fund');
		$this->vote_count = $vote_count;
		$this->suggest = $suggest;
		$this->individuallist = $individuallist;
		$this->voting_count = $voting_count;
		$this->ratelist = $ratelist;
		$this->assign('charts',$charts);
		$this->planlist = $planlist;
		$this->receipts = D('PlanView')->where(array('p.status'=>2,'pl.status'=>array('egt', 1)))->order('pl.purchasedate desc')->select();
		$this->histroy = M('StockSuggestion')->where(array('pid'=> $id,'status'=>array('egt', 2)))->order('day desc')->select();
		$this->projects = $projects;
		$this->investor = $investor;
		$this->display($data['page_temp']);
	}

	// 投资按钮处理
	public function invest() {
		$uid = is_login();
		if (!$uid) {
			$this->error('亲，您还没有登录噢！快点<a href="'. 
				U('User/login'). '">登录</a>吧，等你噢〜'.showface('radio'));
		}

		$where = array('uid' => $uid, 'status' => 9, 'auth_id'=>1);
		$auth = M('UserAuth')->where($where)->count();
		if (!$auth) {
			$this->error('亲，为了方便您的投资，请先<a href="'. 
				U('User/savecenter') . '">完善您的个人资料</a>噢！'.showface('waiting'));
		}
		$this->success('验证通过。');

		$this->pid = $_GET['id'];
		$this->success($this->fetch('follow'));
	}

	public function vote() {
		if (IS_AJAX) {
			$uid = is_login();
			$sid = $_POST['sid'];

			if (!$sid) {$this->error('请选择你看好的股票。');}
			
			$sug = M('StockSuggestion')->find($sid);

			$stock = M('Stock')->find($sug['pid']);
			$day = $stock['useday'];
			$user_tag = cookie('user_vote_tag' . $sug['pid']);
			$data = M('SuggestionInfo')->where(array('day'=>$day, 
				'user_tag'=>$user_tag))->find();

			if ($data) {
				$sug1 = M('StockSuggestion')->find($data['sid']);
				if ($sug1['pid'] == $sug['pid']) {
					$this->error('您已经投过票了。');	
				}
			}
			
			$tag = md5(NOW_TIME);
			M('StockSuggestion')->where(array('id'=>$_POST['sid']))->setInc('count', 1);
			M('SuggestionInfo')->add(array('sid'=>$_POST['sid'], 'uid'=>$uid, 
				'day'=>$day, 'user_tag'=>$tag, 'create_time'=>NOW_TIME));
			cookie('user_vote_tag' . $sug['pid'] , $tag, 86400*7);
			$this->success('投票成功！');
		}
	}

	/* public function follow() {
		if (IS_GET) {
			$uid = is_login();
			if (!$uid) {
				$this->error('亲，您还没有登录噢！快点<a href="'. 
					U('User/login'). '">登录</a>吧，等你噢〜'.showface('radio'));
			}

			$this->pid = $_GET['id'];
			$this->stock = M('Stock')->find($this->pid);
			// 封闭期关闭投资
			if ($this->stock['closed'] == 1) {
				$this->error('感谢您的关注，该项目目前处于封闭期。');
			}
			$where = array('uid' => $uid, 'status' => 9, 'auth_id'=>1);
			$auth = M('UserAuth')->where($where)->count();
			if (!$auth) {
				$this->error('亲，为了方便您的投资，请先<a href="'. 
					U('User/savecenter') . '">完善您的个人资料</a>噢！'.showface('waiting'));
			}

			$data = M('StockInvestor')->where(array('pid'=>$this->pid, 
				'uid'=>$uid, 'status'=>0))->find();
			$data['can_fund'] = $this->stock['max_fund'] - $data['fund'];
			$this->data = $data;
			$this->success($this->fetch('follow'));
		} else {
			$amount = $_POST['amount'];
			if(!preg_match("/^\d*$/",$amount)) {
				$this->error('投资金额请输入数字。');
			}
			$amount = intval($amount);
			$pid = $_POST['pid'];

			$stock = M('Stock')->find($pid);
			// 封闭期关闭投资
			if ($stock['closed'] == 1) {
				$this->error('感谢您的关注，该项目目前处于封闭期。');
			}
			if ($amount <= 0) {
				$this->error('投资金额必须大于0');
			} else if($amount % $stock['min_fund'] > 0) {
				$this->error('投资金额必须是'.$stock['min_fund'].'的整数倍。');
			}

			$uid = is_login();
			$invest = M('StockInvestor')->where(array('pid'=>$pid, 'uid'=>$uid, 'status' => 0))->find();

			if ($stock['min_fund'] > ($invest['fund'] + $amount) || 
				($stock['max_fund'] != 0 && ($invest['fund'] + $amount) > $stock['max_fund'])) {
				$this->error('投资金额小于'.$stock['min_fund'].'，或投资总金额大于'.$stock['max_fund'].'。');
			}

			// 添加流水记录
			$data = array('uid'=>$uid, 'pid'=>$pid, 'type'=>'1', 
				'amount'=>$amount, 'status'=> 0, 
				'create_time'=>NOW_TIME, 'update_time' => NOW_TIME);
			$fid = M('StockInvestorFlow')->add($data);

			// 添加支付流水
			$payData['orderid'] = $fid;
			$payData['uid'] = $uid;
			$payData['pay_amount'] = $amount;
			$payData['type'] = 2;
			$payData['merorderid'] = buildMerorderid();
			$payData['amountsum'] = $amount;
			$payData['paytype'] = 0;
			$payData['state'] = 0;
			$payData['create_time'] = $payData['update_time'] = time();

			$resultPaySave = M('ProductPay')->add($payData);
			
			$this->success('', U('Pay/index', array('merorderid'=>$payData['merorderid'])));
		}
	} */

	//新的投资
	public function follow() {
		if (IS_GET) {
			$uid = is_login();
			if (!$uid) {
				$this->error('亲，您还没有登录噢！快点<a href="'.
						U('User/login'). '">登录</a>吧，等你噢〜'.showface('radio'));
			}
	
			$this->pid = $_GET['id'];
			$this->stock = M('Stock')->find($this->pid);
			// 封闭期关闭投资
			if ($this->stock['closed'] == 1) {
				$this->error('感谢您的关注，该项目目前处于封闭期。');
			}
			$where = array('uid' => $uid, 'status' => 9, 'auth_id'=>1);
			$auth = M('UserAuth')->where($where)->count();
			if (!$auth) {
				$this->error('亲，为了方便您的投资，请先<a href="'.
						U('User/savecenter') . '">完善您的个人资料</a>噢！'.showface('waiting'));
			}
	
			//获取投资记录信息
			$data = M('StockAccount')->where(array('pid'=>$this->pid,
					'uid'=>$uid, 'status'=>0))->find();
			//计算可投资金额
			$data['can_fund'] = $this->stock['max_fund'] - $data['fund'];
			$this->data = $data;
			$this->success($this->fetch('follow'));
		} else {
			$amount = $_POST['amount'];
			if(!preg_match("/^\d*$/",$amount)) {
				$this->error('投资金额请输入数字。');
			}
			$amount = intval($amount);
			$pid = $_POST['pid'];
	
			$stock = M('Stock')->find($pid);
			// 封闭期关闭投资
			if ($stock['closed'] == 1) {
				$this->error('感谢您的关注，该项目目前处于封闭期。');
			}
			
			//更新成1000的整数倍
			$min_fund = $stock['min_fund'];
			//$min_fund = 1000;
			if ($amount <= 0) {
				$this->error('投资金额必须大于0');
			} else if($amount % 1000 > 0) {
				$this->error('投资金额必须是1000的整数倍。');
			}
	
			$uid = is_login();

			//获取投资人记录
			$invest = M('StockAccount')->where(array('pid'=>$pid, 'uid'=>$uid, 'status' => 0))->find();
			//判断投资额范围
			if ($min_fund > ($invest['fund'] + $amount) ||
			($stock['max_fund'] != 0 && ($invest['fund'] + $amount) > $stock['max_fund'])) {
				$this->error('投资金额小于'.$min_fund.'，或投资总金额大于'.$stock['max_fund'].'。');
			}
	
			// 添加流水记录
			$data = array(
					'uid'=>$uid,
					'pid'=>$pid,
					'type'=>'1',
					'amount'=>$amount,
					'status'=> 0,
					'create_time'=>NOW_TIME,
					'update_time' => NOW_TIME);
			$fid = M('StockAccountFlow')->add($data);
				
			// 添加支付流水
			$payData['orderid'] = $fid;
			$payData['uid'] = $uid;
			$payData['pay_amount'] = $amount;
			$payData['type'] = 2;
			$payData['merorderid'] = buildMerorderid();
			$payData['amountsum'] = $amount;
			$payData['paytype'] = 0;
			$payData['state'] = 0;
			$payData['create_time'] = $payData['update_time'] = time();
	
			$resultPaySave = M('ProductPay')->add($payData);
				
			$this->success('', U('Pay/index', array('merorderid'=>$payData['merorderid'])));
		}
	}
	
	public function suggestion() {
		if (IS_GET) {
			$pid = $_GET['id'];
			$user_sug_tag = cookie("user_sug_tag" . $pid);
			$uid = is_login();
			
			$stock = M('Stock')->find($pid);
			$count = M('StockSuggestion')->where(array('pid'=>$pid, 
				'day'=>$stock['useday'], 'user_tag'=>$user_sug_tag))->count();
			if ($count > 0) {
				$this->error('您今天已经推荐了一只股票。');
			}
			$this->pid = $pid;
			$this->success($this->fetch('suggestion'));
		} else {
			$user_sug_tag = cookie("user_sug_tag" . $_POST['pid']);
			$stock = M('Stock')->find($_POST['pid']);

			$data = array('pid'=>$_POST['pid'], 
				'day' => $stock['useday'], 
				'user_tag'=>$user_sug_tag);
			$count = M('StockSuggestion')->where($data)->count();
			if ($count > 0) {
				$this->error('您今天已经推荐了一只股票。');
			}
			unset($data['user_tag']);
			$data['title'] = $_POST['title'];
			$count = M('StockSuggestion')->where($data)->count();
			if ($count > 0) {
				$this->error('您推荐的股票已经在投票列表中了。');
			}

			if (empty($data['title'])) {
				$this->error('请填写您要推荐的股票名称。');
			}
			$tag = MD5(NOW_TIME);
			$data['reason'] = $_POST['reason'];
			$data['create_time'] = NOW_TIME;
			$data['user_tag'] = $tag;
			$data['uid'] = is_login();
			M('StockSuggestion')->add($data);

			cookie('user_sug_tag' . $_POST['pid'], $tag, 86400*7);
			$this->success('感谢您的推荐。');
		}
	}

	//个股投票
	public function voting() {
		if (IS_GET) {
			$pid = $_GET['id'];
			$user_sug_tag = cookie("user_sug_tag" . $pid);
			$uid = is_login();
			
			//当天年月日
			$useday= strtotime(date('Y-m-d',time()));
			
			$count = M('IndividualList')->where(array('pid'=>$pid,
					'useday'=>$useday, 'user_tag'=>$user_sug_tag))->count();
			if ($count > 0) {
				$this->error('您今天已经推荐了一只股票。');
			}
			$this->pid = $pid;
			$this->success($this->fetch('voting'));
		} else {
			$user_sug_tag = cookie("user_sug_tag" . $_POST['pid']);
	
			//当天年月日
			$useday= strtotime(date('Y-m-d',time()));

			$where = array('pid'=>$_POST['pid'],
					'useday' => $useday,
					'user_tag'=>$user_sug_tag);
			$count = M('IndividualList')->where($where)->count();

			if ($count > 0) {
				$this->error('您今天已经推荐了一只股票。');
			}
			
			if (empty($_POST['title'])) {
				$this->error('请填写您要推荐的股票名称。');
			}
			
			$count = M('IndividualList')->where(array('pid'=>$_POST['pid'],'title'=>$_POST['title'],
					'status'=>array('like',array('0','1'),'OR')))->count();
			if ($count > 0) {
				$this->error('您推荐的股票已经在投票列表中了。');
			}
	
			$tag = MD5(NOW_TIME);
			
			$data['pid'] = $_POST['pid'];
			$data['useday'] = $useday;
			$data['title'] = $_POST['title'];
			$data['reason'] = $_POST['reason'];
			$data['create_time'] = NOW_TIME;
			$data['user_tag'] = $tag;
			$data['uid'] = is_login();
			M('IndividualList')->add($data);
	
			cookie('user_sug_tag' . $_POST['pid'], $tag, 86400*7);
			$this->success('感谢您的推荐。');
		}
	}
	
	public function votes() {
		if (IS_AJAX) {
			$uid = is_login();
			$sid = $_POST['sid'];
	
			if (!$sid) {$this->error('请选择你看好的股票。');}
				
			//推荐股票列表
			$sug = M('IndividualList')->find($sid);
	
			//获取项目信息
			$stock = M('Stock')->find($sug['pid']);
			//$day = $stock['useday'];
			//当天年月日
			$day= strtotime(date('Y-m-d',time()));
			$user_tag = cookie('user_vote_tag' . $sug['pid']);
			$data = M('SuggestionInfo')->where(array('day'=>$day,
					'user_tag'=>$user_tag))->find();
	
			if ($data) {
				$sug1 = M('IndividualList')->find($data['pid']);
				if ($sug1['pid'] == $sug['pid']) {
					$this->error('您已经投过票了。');
				}
			}
				
			$tag = md5(NOW_TIME);
			M('IndividualList')->where(array('id'=>$_POST['sid']))->setInc('count', 1);
			M('SuggestionInfo')->add(array('pid'=>$_POST['sid'], 'uid'=>$uid,
			'day'=>$day, 'user_tag'=>$tag, 'create_time'=>NOW_TIME));
			cookie('user_vote_tag' . $sug['pid'] , $tag, 86400*7);
			$this->success('投票成功！');
		}
	}
	
	//新的提现stockaccount
	public function cash_new(){
		$uid = is_login();
		$pid = I('id');
		//获取项目信息
		$stock = M('Stock')->find($pid);
		//获取项目的投资记录
		$invest = M('StockAccount')->where(array('pid'=>$pid, 'uid'=>$uid, 'status'=>0))->find();
		if (!$invest) {
			$this->error('未找到您的认购记录。' .$pid);
		}

		//获取提现记录
/* 		$where = array('pid' =>$pid, 'uid'=>$uid,'type'=>2, 'status'=>0);
		$cash = M('StockAccountFlow')->where($where)->select(); */
	/* 	if ($cash) {
			$this->error('您已申请提现，请耐心等待');
		} */
		
		if (IS_GET) {
			//$bankinfo = M('UserBank')->where(array('uid'=>$uid, 'status'=>0))->select();
			//获取最大可提份额
			if (!$stock['days']) {
				$days = NOW_TIME;
			} else {
				$days = strtotime(date('Y-m-d',strtotime('-'. $stock['days'] .' day')));
			}

			//,'create_time'=>array('lt',$days)
			$cashwhere= array('pid' =>$pid, 'uid'=>$uid,'type'=>1,'status'=>2,'create_time'=>array('lt',$days));
			//可以赎回的所有份额
			$maxoperation = M('StockAccountFlow')->where($cashwhere)->sum('operation_fund');
			
			//已赎回的份额
			$operation_no = M('StockAccountFlow')->where(array('pid' =>$pid, 'uid'=>$uid,'type'=>2,'status'=>2))->sum('operation_fund');
			if($maxoperation > 0){
				if($operation_no>0){
					$maxoperation = $maxoperation - $operation_no;
				}else{
					$maxoperation = $maxoperation;
				}
				if($maxoperation<1){
					$maxoperation =0;
				}
				
				
			}else{
				$maxoperation =0;
			}

			$this->maxoperation = $maxoperation;
			$this->data = $invest;
			$this->account = D('AccountUser')->getInfo($this->uid);
			//$this->banklist = $bankinfo;
			$this->success($this->fetch('cash'));
		}else{
			
			$operation = $_POST['operation'];
			$maxoperation = $_POST['maxoperation'];
	
			if (empty($operation)) {
				$this->error('赎回份额必须大于０。');
			}
			if ($maxoperation < $operation) {
				$this->error('超出最大可赎回份额');
			}

			//增加赎回的流水记录
			M('StockAccountFlow')->add(array('pid'=>$pid,
				'uid'=>$uid,
				'operation_fund'=>$operation,
				'type'=>2,
				'status'=>2,
				'create_time'=>NOW_TIME, 
				'update_time'=>NOW_TIME));
				
/* 			//排队金额
			$data['uid'] = $uid;
			$data['pid'] = $pid;
			$data['waiting_fund'] = $invest['waiting_fund'];
			$data['amount'] = $amount;
			$data['create_time'] = NOW_TIME;
			M('StockCash')->add($data); */
			$this->success('提现申请成功，请耐心等待。');
			
		}
	}	
	
	public function cash() {
		$uid = is_login();
		$pid = I('id');

		$stock = M('Stock')->find($pid);
		
		$invest = M('StockInvestor')->where(
				array('pid'=>$pid, 'uid'=>$uid, 'status'=>0))->find();
		if (!$invest) {
			$this->error('未找到您的认购记录。' .$pid);
		}
		$day = time_format(NOW_TIME, 'Y-m-d');
		$data = array('pid' =>$pid, 'uid'=>$uid, 'day'=>$day);
		$cash = M('StockCash')->where($data)->find();

		if($stock['is_freeze']==1){
			$invest['amount'] = $invest['waiting_fund'];
		}
		
		if($stock['type']==0){
			
			//获取当日12点前的数据
			$nowdate = strtotime(date('Y-m-d',NOW_TIME));
			//创建时间
			$createtime= strtotime(date('Y-m-d',$invest['create_time']));
			//时间差
			$cha =$nowdate - $createtime;
			
			//天数
			$days = intval($cha/86400);
			
			if($days<7){
				$this->error('申购时间不满一周，不允许赎回');
			}
		}
		
		if ($cash) {
			$this->error('您今天已经申请过提现。一天只能提现一次。');
		}
		if (IS_GET) {
			$this->info = M('UserBank')->where(array('uid'=>$uid))->count();
			$this->data = $invest;
			$this->type = $stock['type'];
			$this->success($this->fetch('cash'));
		} else {
			$amount = $_POST['amount2'];
			if (empty($amount)) {
				$this->error('提现金额必须大于0。');
			}
			if ($invest['amount'] < $amount) {
				$this->error('您账户的总金额小于，提现金额');
			}
			if (!$_POST['need_info']) {
				if (empty($_POST['bank_name'])) {
					$this->error('请填写您开户银行。');
				}
				if (empty($_POST['sub_bank'])) {
					$this->error('请填写支行。');
				}
				if (empty($_POST['cardno'])) {
					$this->error('请填写银行卡号。');
				}
				if (empty($_POST['cardno_confirm'])) {
					$this->error('请填写确认卡号');
				}
				if ($_POST['cardno_confirm'] != $_POST['cardno']) {
					$this->error('确认卡号和银行卡号不一致，请确认。');
				}

				M('UserBank')->add(array('uid'=>$uid, 'bank_name'=>$_POST['bank_name'], 
					'sub_bank'=>$_POST['sub_bank'], 'cardno'=>$_POST['cardno'], 
					'create_time'=>NOW_TIME));
			}

			//排队金额
			$data['waiting_fund'] = $invest['waiting_fund'];
			$data['amount'] = $amount;
			$data['create_time'] = NOW_TIME;
			M('StockCash')->add($data);
			$this->success('提现申请成功，我们会在下一个工作日处理。');
		}
	}

	public function ipocash() {
		$uid = is_login();
		$pid = I('id');
	
		$invest = M('StockInvestor')->where(
				array('pid'=>$pid, 'uid'=>$uid, 'status'=>0))->find();
		if (!$invest) {
			$this->error('未找到您的认购记录。' .$pid);
		}
		$day = time_format(NOW_TIME, 'Y-m-d');
		$data = array('pid' =>$pid, 'uid'=>$uid, 'day'=>$day);
		$cash = M('StockCash')->where($data)->find();
	
		if ($cash) {
			$this->error('您今天已经申请过提现。一天只能提现一次。');
		}
		if (IS_GET) {
			$this->info = M('UserBank')->where(array('uid'=>$uid))->count();
			$this->data = $invest;
			$this->success($this->fetch('ipocash'));
		} else {
			$amount = $_POST['amount2'];
			if (empty($amount)) {
				$this->error('提现金额必须大于0。');
			}
			if ($invest['amount'] < $amount) {
				$this->error('您账户的总金额小于，提现金额');
			}
			
			//提现金额大于可提金额
			if($invest['use_amount'] < $amount){
				$amount =$invest['use_amount'];
				//更新为预提金额
				$drawcash = $amount - $invest['use_amount'];
				M('StockInvestor')->save(array('id'=>$invest['id'], 'drawcash'=>$drawcash));
				
			}
			
			if (!$_POST['need_info']) {
				if (empty($_POST['bank_name'])) {
					$this->error('请填写您开户银行。');
				}
				if (empty($_POST['sub_bank'])) {
					$this->error('请填写支行。');
				}
				if (empty($_POST['cardno'])) {
					$this->error('请填写银行卡号。');
				}
				if (empty($_POST['cardno_confirm'])) {
					$this->error('请填写确认卡号');
				}
				if ($_POST['cardno_confirm'] != $_POST['cardno']) {
					$this->error('确认卡号和银行卡号不一致，请确认。');
				}
	
				M('UserBank')->add(array('uid'=>$uid, 'bank_name'=>$_POST['bank_name'],
				'sub_bank'=>$_POST['sub_bank'], 'cardno'=>$_POST['cardno'],
				'create_time'=>NOW_TIME));
			}
	
			$data['amount'] = $amount;
			$data['create_time'] = NOW_TIME;
			M('StockCash')->add($data);
			$this->success('提现申请成功，我们会在下一个工作日处理。');
		}
	}
	
	public function normalpay() {
		$pay = M('ProductPay')->where(array('merorderid'=>$_GET['merorderid']))->find();

		if (!$pay) {
			$this->error('支付订单号不存在。');
		}

		$detailURL = 'http://'. $_SERVER['HTTP_HOST'] . U('Stock/index?id='.$_GET['pid']);
		$payResults = A('BaoyiPayApi')->send($pay['amountsum'], 
				$_GET['merorderid'],$detailURL,'无', $_GET['bankname']);

		$message= '<script>window.location.href = "'. $payResults . '";</script>';
		
		$this->message = $message;
		$this->display('Account/loading');
	}

/* 	public function payback($orderid, $type = true) {
		$data = M('StockInvestorFlow')->find($orderid);
		$stock = M('Stock')->where(array('id'=>$data['pid']))->find();
		if ($data['status'] == 0) {
			//计算当前净值
			$operation_fund = round(($data['amount'] / $stock['assets']),2);
			$assets = $stock['assets'];
			
			M('StockInvestorFlow')->save(array('id'=>$data['id'],
				'status'=>2));

			$invest = M('StockInvestor')->where(
				array('pid'=>$data['pid'], 'uid'=>$data['uid'],'status' => 0))->find();

			$v = array('pid'=>$data['pid'], 'uid'=>$data['uid'], 
				'amount'=>$data['amount'],
				'fund'=>$data['amount'], 
				'assets' =>$stock['assets'],
				'waiting_fund'=>$data['amount'], 
				'update_time' => NOW_TIME);

			if (!$invest) {
				$v['create_time'] = NOW_TIME;
				M('StockInvestor')->add($v);
			} else {
				$v['id'] = $invest['id'];
				$v['waiting_fund'] = $v['waiting_fund'] + $invest['waiting_fund'];
				$v['amount'] = $v['amount'] + $invest['amount'];
				$v['fund'] = $invest['fund'] + $v['fund'];

				M('StockInvestor')->save($v);
			}
		}
		if ($type) {
			$this->success('投资处理成功。', U('Stock/index?id='.$stock['id']));	
		}
	} */

	//新的投资回调函数
	public function payback($orderid, $type = true) {
		//获取投资流水信息
		$data = M('StockAccountFlow')->find($orderid);
		//获取项目信息
		$stock = M('Stock')->where(array('id'=>$data['pid']))->find();
		//未处理的数据进行更新
		if ($data['status'] == 0) {
			//计算当前净值
			//$operation_fund = round(($data['amount'] / $stock['assets']),2);
			//$assets = $stock['assets'];

			//更新流水状态
			M('StockAccountFlow')->save(array('id'=>$data['id'],'status'=>2,'state'=>1,'update_time' => NOW_TIME));
			//获取投资记录
			$invest = M('StockAccount')->where(array('pid'=>$data['pid'], 'uid'=>$data['uid'],'status' => 0))->find();
	
			$v = array('pid'=>$data['pid'], 'uid'=>$data['uid'],
					'amount'=>$data['amount'],
					'fund'=>$data['amount'],
					'assets' =>$stock['assets'],
					'waiting_fund'=>$data['amount'],
					'update_time' => NOW_TIME);
	
			//判断是否已有投资记录
			if (!$invest) {
				$v['create_time'] = NOW_TIME;
				//如果记录不存在则新增
				M('StockAccount')->add($v);
			} else {
				//更新记录
				$v['id'] = $invest['id'];
				//累加排队金额
				$v['waiting_fund'] = $v['waiting_fund'] + $invest['waiting_fund'];
				//累加总资产
				$v['amount'] = $v['amount'] + $invest['amount'];
				//累积投资金额
				$v['fund'] = $invest['fund'] + $v['fund'];
	
				M('StockAccount')->save($v);
			}
		}
		if ($type) {
			$this->success('投资处理成功。', U('Stock/index?id='.$stock['id']));
		}
	}
	
	public function voteconfirm() {
		$stock = M('Stock')->where(array('status'=>1, 'type'=>1))->select();

		foreach ($stock as $i => $s) {
			// 设置日期大于等于当天，跳过处理
			if ($s['type'] == 0 || $s['useday'] == $s['setday']) {
				continue;
			}
			// 前一交易日推荐股变为待处理
			$ret = M('StockSuggestion')->where(array('status'=>2, 
				'pid'=>$s['id']))->save(array('status'=>3));

			// 当前交易日得票最高的股票
			$data = M('StockSuggestion')->where(array('status'=>0, 
				'pid'=>$s['id']))->order('count desc, create_time')->find();

			// 跟新得票状态
			M('StockSuggestion')->where(array('status'=>0, 'pid'=>$s['id']))->save(array('status' => 1));
			M('StockSuggestion')->where(array('id'=>$data['id']))->save(array('status' => 2));
			
			M('Stock')->where(array('id'=>$s['id']))->save(array('useday'=>$s['setday']));
		}

		echo true;
	}
	
	public function stock_update() {
		
		if($_POST){
			$pid = $_POST['pid'];
			//$pid = 1;
			
			$waiting = M('StockInvestor')->where(array('pid'=>$pid,'waiting_fund'=>array('gt', 0)))->select();
			
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
			
			$return = 1;
			$this->ajaxReturn($return,'json');
			
		}

	}

}
?>