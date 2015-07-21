<?php 
namespace Home\Controller;

class AccountController extends HomeController {
	
	/*用户必须登录后方可查看*/
  function __construct(){
    parent::__construct();
    $this->uid = is_login();
    $this->pageTitle = "我的钱包";
  }

  public function payback($payinfo='', $type = true) {
  	$data = M('ProjectInvestor')->where(array('id'=>$payinfo['orderid'], 'status'=>array('egt', '0')))->find();
  	if ($data['status'] == 8) {
			M('ProjectInvestor')->save(
				array('status'=>9, 'pay_way'=>1, 'id'=>$payinfo['orderid'], 'update_time'=>NOW_TIME));
  		//更新待办事件
  		update_pj_dolist($data['investor_id'],2);
  	}

  	if ($type == true) {
  		$this->success('投资处理成功。', U('MCenter/pj_support'));
  	}
  }

	public function index() {
    if (!$this->uid) {
      $this->redirect('User/login');
    }
		$this->data = D('AccountUser')->getInfo($this->uid);
		$this->list = M('AccStream')->
			where(array('uid'=>$this->uid, 'status'=>0))->order('update_time desc')->select();
		$this->display('index');
	}

	/* 使用余额支付 */
	public function pay() {
    if (!$this->uid) {
      $this->redirect('User/login');
    }
		$type = $_GET['type'];
		$orderid = $_GET['id'];

    $this->pageTitle = "支付";
		if (empty($type) || empty($orderid)) {
			$this->error('非法操作。');
		}
		// 股权投资支付
		if ($type == 1) {
			$data = M('ProjectInvestor')->where(array('id'=>$orderid, 'status'=>array('egt', '0')))->find();
			if (!$data) {
				$this->error('指定投资记录不存在。');
			} else if ($data['status'] == 9) {
				$this->error('指定投资记录已完成支付');
			}
			$pay_amount = $data['fund'];
		}

		$payData['orderid'] = $orderid;
		$payData['uid'] = $this->uid;
		$payData['type'] = $type;
		$payData['merorderid'] = buildMerorderid();
		$payData['amountsum'] = $pay_amount;
		$payData['pay_amount'] = $pay_amount;
		$payData['paytype'] = 0;
		$payData['return_url'] = $return_url;
		$payData['state'] = 0;
		$payData['create_time'] = $payData['update_time'] = time();

		$resultPaySave = M('ProductPay')->add($payData);
		
		$this->redirect('Pay/index?merorderid='. $payData['merorderid']);
	}

	public function addcards() {
    if (!$this->uid) {
      $this->redirect('User/login');
    }
    $this->pageTitle = "添加提现卡";
		if (IS_POST) {
			$data = $_POST;
			if ($data['cardno'] != $data['recardno']) {
				$this->error('两次输入的卡号不一致。');
			}
			$data['uid'] = $this->uid;
			$card = M('UserBank')->where(array('uid'=>$data['uid'], 'status'=>0))->find();
			if ($card) {
				$this->error('您已经绑定了一张银行卡。一个账号只能绑定一张提现卡。');
			}
			$data['create_time'] = NOW_TIME;
			$data['update_time'] = NOW_TIME;
			M('UserBank')->add($data);
			$this->success('提现卡添加成功。');
		} else{
			$auth = M('UserAuth')->where(array('uid'=>$this->uid, 'auth_id'=>1, 'status'=>9))->find();
			if (!$auth) {
				
			}
			$this->display('addcards');
		}
	}

	public function cash() {
    if (!$this->uid) {
      $this->redirect('User/login');
    }
		$this->phone = M('UsersDetail')->where(array('id'=>$this->uid))->getField('phone');
		
		if (IS_GET) {
			$this->account = D('AccountUser')->getInfo($this->uid);
			$this->banklist = M('UserBank')->where(array('uid'=>$this->uid, 'status'=>0))->select();
			$this->display('cash');
		} else {
			$code = session($this->phone);
			$data = $_POST;
			if (empty($data['code']) || $data['code'] != $code) {
				$this->error('您输入的验证码不正确');
			}
			$pattern = "/^[0-9]+(\.[0-9]{0,2}){0,1}$/";
			if (!preg_match( $pattern, $data['amount']) || $data['amount'] <= 0) {
				$this->error('请输入正确的提现金额');
			}
			$data['uid'] = $this->uid;
			$ret = D('AccStream')->cash($data);
			session($this->phone,null);

			if (!$ret) {
				$this->error(D('AccStream')->getError());
			}

			$this->success('提现处理成功，请等待审核。');
		}
	}

	/*交易流水*/
	public function stream_list() {
    if (!$this->uid) {
      $this->redirect('User/login');
    }
    $this->pageTitle = "交易明细";
		$this->type = I('type', -1);
		$maps = array('uid'=>$this->uid, 'state'=> 1, 'status'=>0);
		if ($this->type >= 0) {
			$maps['type'] = $this->type;
		}
		$this->data = M('AccStream')->where($maps)->order('create_time desc')->select();
		$this->display('stream_list');
	}

	public function delcard() {
    if (!$this->uid) {
      $this->redirect('User/login');
    }
    $this->pageTitle = "删除绑定卡";
		if (IS_AJAX) {
			$id = $_GET['id'];
			$type=$_GET['type'];
			if (empty($id) || empty($type)) {
				$this->error("非法操作。");
			}

			$maps = array('uid'=>$this->uid, 'id'=>$id);
			if ($type == 1) {
				$table = "UserBank";
			} else {
				$table ="QuickcardList";
			}

			$data = M($table)->where($maps)->find();
			if (!$data) {
				$this->error('非法操作。');
			}

			M($table)->save(array('id'=>$id, 'status'=>-1, 'update_time'=>NOW_TIME));
			$this->success('指定银行卡删除成功。');
		}
	}

	public function cardlist() {
    if (!$this->uid) {
      $this->redirect('User/login');
    }
    $this->pageTitle = "银行卡列表";

		$maps = array('uid'=>$this->uid, 'status'=>0);
		$this->cards = M('UserBank')->where($maps)->select();

		$maps = array('uid'=>$this->uid, 'status'=>1);
		$this->quickcards = D('MycardView')->where($maps)->select();
		$this->display('cardlist');
	}

	/*账户充值*/
	public function recharge() {
    if (!$this->uid) {
      $this->redirect('User/login');
    }
    $this->pageTitle = "账户充值";
		if (IS_POST) {
			$amount = I('amount', '0', 'intval');

			if ($amount < 10) {
				$this->error('单笔充值金额必须大于等于10');
			}
			$type = I('type', 0);
			if (empty($type) || $type == 0) {
				$return_url = U('Account/index');
			} else {
				$return_url = U('Account/pay', array('type'=>$type, 'id'=>$_POST['id']));
			}

			$payData['orderid'] = '';
			$payData['uid'] = $this->uid;
			$payData['type'] = 9;
			$payData['merorderid'] = buildMerorderid();
			$payData['amountsum'] = $amount;
			$payData['pay_amount'] = $amount;
			$payData['paytype'] = 0;
			$payData['return_url'] = $return_url;
			$payData['state'] = 0;
			$payData['create_time'] = $payData['update_time'] = time();

			$resultPaySave = M('ProductPay')->add($payData);
			
			$this->success('', U('Pay/index?merorderid='. $payData['merorderid']));
		} else {
			$account = D('AccountUser')->getInfo($this->uid);
			$this->type = $_GET['type'];
			$this->id = $_GET['id'];
			$this->amount = $account['use_able'];
			$this->display('recharge');
		}
	}

	/*删除操作记录*/
	public function stream_delete() {
    if (!$this->uid) {
      $this->redirect('User/login');
    }
    $this->pageTitle = "删除流水";
		$id = $_GET['id'];

		if (!$id) {
			$this->error('参数不正确');
		}

		$data = M('AccStream')->where(array('id'=>$id, 'status'=>0))->find($id);
		$uid = is_login();
		if (empty($data) || $data['uid'] != $uid) {
			$this->error('非法操作。');
		}
		M('AccStream')->save(array('id'=>$id, 'status'=>-1, 'update_time'=>NOW_TIME));

		$this->success('记录操作删除成功。');
	}
}
?>