<?php 
namespace Home\Controller;

class QuickpayController extends HomeController {

	private $message_head = array('version'=>'01', 'msgType'=>'0001', 
		'chanId'=>'99', 'merchantNo'=>'', 'clientDate'=>'', 
		 'tranFlow'=>'', 'tranCode'=>'');

  /*用户必须登录后方可查看*/
  function __construct(){
    parent::__construct();
    $this->uid = is_login();
    if (!$this->uid && ACTION_NAME != 'callback') {
      $this->redirect('User/login');
    }
    $this->pageTitle="快捷支付";
  }
	
	private function inithead($trancode) {
		$this->config = C('QUICK_PAY');
		$time = NOW_TIME;
		$this->message_head['tranCode'] = $trancode;
		$this->message_head['merchantNo']= $this->config['MERCHANTNO'];
		$this->message_head['tranFlow'] = $this->message_head['merchantNo'] . 
			floor(microtime($time) * 1000) . rand(1000,9999);

		$this->message_head['clientDate'] = date('YmdHis', $time);

		return $this->message_head;
	}

	function pkcs5Pad($data) {
    	$size = mcrypt_get_block_size(MCRYPT_DES, MCRYPT_MODE_CBC);
    	$padlen = $size - (strlen ( $data ) % $size);
    	return $data . str_repeat ( chr ( $padlen ), $padlen );
    }
     
    function encrypt($time, $string) {
    	if (empty($string)) {
    		return '';
    	}
        $iv = $this->config['SECRETKEY'];   # 提供的测试key abcdefgh
        $string = $time . $string;

        $string = $this->pkcs5Pad($string);
        $enc=mcrypt_cbc(MCRYPT_DES, $iv, $string, MCRYPT_ENCRYPT, $iv);
    
    	return base64_encode($enc);
    }

  // 验证用户 QP0004
  public function queryuser() {
  	$uid = is_login();
   	$head = $this->inithead('QP0004');
   	$merorderid = $_GET['merorderid'];

		$account = D('AccountUser')->getInfo($uid);

		if (!$account) {
			$outuserid = $this->config['USER_PREFIX'] . sprintf("%014d", $uid);
			$account = array('outuserid' => $outuserid,'uid' => $uid,
				'username' => '', 'certno' => '', 'mobile' => '',
				'isverify' => '0', 'create_time'=>NOW_TIME, 'update_time'=>NOW_TIME);
			M('AccountUser')->add($account);
		} else {
			$outuserid = $account['outuserid'];
		}

		$custId = $this->encrypt($head['clientDate'], $outuserid);

    	$body = array('custId'=>$custId, 'cardType'=>'', 'storableCardNo' =>'', 'bankNo'=>'');
    	$message = array('head'=>$head, 'body'=>$body);

    	include_once(APP_PATH . '/BaoyiPay/BaoyiPay.php');
		$xml = to_xmlstring($message);

		$mac = md5($xml . $this->config['KEY']);
		D('AccountLog')->record($head, $xml, $mac, 0);
	
		$para = array('xml'=>$xml, 'mac'=>$mac);
		$text = getHttpResponsePost($this->config['PAY_URL'], $para);

		$para = md5Response($text, $this->config['KEY']);
		if (!$para) {
			$this->ajaxReturn(array('status'=>0, 'info'=>'信息错误'));
		}
		$data = xml2arr($para['xml']);
		D('AccountLog')->record($data['head'], $para['xml'], $para['mac'], 1);

	
		if ($data['head']['respCode'] == 'EMB0000022') {
			$this->redirect('banklist', array('merorderid'=>$merorderid));
		} else if ($data['head']['respCode'] == 'C000000000') {
			$payinfo = M('ProductPay')->where(array('merorderid'=>$merorderid))->find();
			$where = array('uid'=>$uid, 'status'=>1);
			if ($payinfo['allow_creditcard'] == '0') {
				$where['cardType'] = 1;
			}

			$banklist =M('QuickcardList')->where($where)->select();
			foreach ($banklist as $k=>$v)
			{
				$bankinfo = M('BankInfo')->where(array('is_quick'=>1, 'bank_code'=>$v['bankno']))->find();
				$banklist[$k]['logo'] = $bankinfo['logo'];
			}
			
			$this->banklist = $banklist;
			$this->merorderid = $merorderid;
			$this->display('banklist');
		} else {
			$this->error($data['head']['respMsg']);
		}
    }

    public function banklist() {
    	$this->merorderid = $_GET['merorderid'];
    	$banklist = M('BankInfo')->where(array('is_quick'=>1))->select();

    	$this->payinfo = M('ProductPay')->where(
    		array('merorderid'=>$_GET['merorderid']))->find();
    	$this->banklist = $banklist;
    	$this->display('banklist1');
    }

	// 获取卡号信息
    public function addstep1() {
    	$this->merOrderId = $_GET['merorderid'];
    	$this->display('addstep1');
    }

    public function addstep2() {
			$this->config = C('QUICK_PAY');
    	if (IS_GET) {
    		$card = M('QuickcardList')->find($_GET['id']);
    		$payinfo = M('ProductPay')->where(
    			array('merorderid'=>$_GET['merorderid']))->find();
    		if ($payinfo['allow_creditcard'] != 1 && $card['cardtype'] == 0) {
    			$this->redirect('queryuser?merorderid='.$_GET['merorderid']);
    		}

    		$this->amount = $payinfo['amountsum'];    
    		$this->merOrderId = $_GET['merorderid'];
    		$this->card = $card;
    		$this->display('addstep2');
    	} else {
    		$id = $_POST['id'];
    		$this->dopay();
    	}
    }

	// 根据信息支付(QP0001)
  public function dopay() {
		$uid = is_login();
		$head = $this->inithead('QP0001');
		$body = $_POST;
		$account = D('AccountUser')->getInfo($uid);
		$body['custId'] =$this->encrypt($head['clientDate'], $account['outuserid']);
		$body['cardNo'] =$this->encrypt($head['clientDate'], $body['cardNo']);
		$expiredDate = $body['expiredMonth'] . $body['expiredYear'];
		if (empty($expiredDate)) {$expiredDate = "";}
		$body['expiredDate'] = $expiredDate;
		if (empty($body['cvv2'])) {$body['cvv2'] = "";}
		$body['subject'] = $this->config['SUBJECT'];
		$body['saveCustFlag'] = 1;
		$body['backUrl'] = 'http://'. $_SERVER['HTTP_HOST'] .U('Quickpay/callback');
		$body['msgExt'] = '';
		unset($body['id']);

		$message = array('head'=>$head, 'body'=>$body);

		include_once(APP_PATH . '/BaoyiPay/BaoyiPay.php');
		$xml = to_xmlstring($message);

		$mac = md5($xml . $this->config['KEY']);
		$para = array('xml'=>$xml, 'mac'=>$mac);
		D('AccountLog')->record($head, $xml, $mac, 0);

		$text = getHttpResponsePost($this->config['PAY_URL'], $para);

		$para = md5Response($text, $this->config['KEY']);

		if (!$para) {
			$this->ajaxReturn(array('status'=>0, 'info'=>'信息错误'));
			exit();
		}

		$this->pay_finish($para);
  }

  /*支付完成后处理(支付后、回调时调用)*/
  private function pay_finish($payinfo, $flag=true) {
  	$data = xml2arr($payinfo['xml']);
		$head = $data['head'];
		D('AccountLog')->record($head, $payinfo['xml'], $payinfo['mac'], $flag ? 1 : 2);
		if ($head['respCode'] == 'C000000000') {

			// 支付完成流程[卡片状态更改为已绑定]
			$card = M('QuickcardList')->where(array('id'=>$_POST['id']))->find();
			if ($card['status'] != 1) {
				M('QuickcardList')->save(array('id'=>$_POST['id'], 
					'status'=>1, 'phoneNo'=>$_POST['phoneNo']));
			}
			$body = $data['body'];
			$pay = M('ProductPay')->where(array('merorderid'=>$body['merOrderId']))->find();
			// 更改支付信息
			$pay = M('ProductPay')->where(
				array('merorderid'=>$body['merOrderId']))->find();

			if ($pay['state'] == 0) {
				$data = array('id'=>$pay['id'], 'state'=>1, 'paytype'=>1, 'update_time'=>time());
				$ret = M('ProductPay')->save($data);

				// 充值处理
				$data=array('uid'=>$pay['uid'], 'amount'=>$pay['amountsum'], 
					'do_tag'=>$pay['type'], 'relation_id'=>$pay['merorderid']);
				$ret = D('AccStream')->recharge($data);

				// 充值失败
				if (!$ret && $flag) {
					$this->error("充值记录重复处理，请查看用户中心是否到账，如有疑问，请联系聚募客服。", U('Account/index'));
				} elseif (!$ret) {
					exit();
				}
			}
			if ($pay['type'] == 0) {
				// 支付处理
				$data=array('uid'=>$pay['uid'], 'amount'=>$pay['pay_amount'], 
				'do_tag'=>$pay['type'], 'relation_id'=>$pay['orderid']);
				$ret = D('AccStream')->pay($data);

				if (!$ret && $flag) {
					$this->error("充值成功，但账户可用余额不足，未完成支付。");
				} elseif (!$ret) {
					exit();
				}

				// 实物订单更新
				A('ProductOrder')->payresult($pay, $flag);
			} elseif ($pay['type'] == 1) {
		   	// 支付处理
				$data=array('uid'=>$pay['uid'], 'amount'=>$pay['pay_amount'], 
					'do_tag'=>$pay['type'], 'relation_id'=>$pay['orderid']);
				$ret = D('AccStream')->pay($data);
					if (!$ret && $flag) {
					$this->error("充值成功，但账户可用余额不足，未完成支付。");
				} elseif (!$ret) {
					exit();
				}
				// 股权支付处理
	   		A('Account')->payback($pay, $flag);
			} else if($pay['type'] == 2) {
				// 支付处理
				$data=array('uid'=>$pay['uid'], 'amount'=>$pay['pay_amount'], 
				'do_tag'=>$pay['type'], 'relation_id'=>$pay['orderid']);
				$ret = D('AccStream')->pay($data);

				if (!$ret && $flag) {
					$this->error("充值成功，但账户可用余额不足，未完成支付。");
				} elseif (!$ret) {
					exit();
				}
				// 股票基金支付处理
				A('Stock')->payback($pay['orderid'], $flag);

			} else if ($pay['type'] == 9) {
				if ($flag) {
					$return_url = $pay['return_url'];
					if (empty($return_url)) {$return_url = U('Account/index');}
					$this->success('支付处理成功。', $return_url);	
				}
			}
			
		} else {
			$this->error($head['respMsg']);
		}
  }

  public function quickpay() {
  	$this->config = C('QUICK_PAY');
  	if (IS_GET) {
  		$card = M('QuickcardList')->find($_GET['id']);
  		$this->card = $card;
  		$this->bank = M('BankInfo')->where(array('bank_code'=>$card['bankno']))->find();
  		$this->amount = M('ProductPay')->where(array('merorderid'=>$_GET['merorderid']))->getField('amountsum');
  		$this->merOrderId = $_GET['merorderid'];
  		$this->display('quickpay');
  	} else {
  		$this->dopay();
  	}
  }

	// 获取手机验证码(QP0002)
  public function getcode() {
		$uid = is_login();
		$head = $this->inithead('QP0002');
		$body = $_POST;
		$account = D('AccountUser')->getInfo($uid);
		$body['custId'] =$this->encrypt($head['clientDate'], $account['outuserid']);
		$body['cardNo'] =$this->encrypt($head['clientDate'], $body['cardNo']);
		$expiredDate = $body['expiredMonth'] . $body['expiredYear'];
		
		if (empty($expiredDate)) {$expiredDate = "";}
			$body['expiredDate'] = $expiredDate;
		if (empty($body['cvv2'])) {$body['cvv2'] = "";}

		unset($body['phoneToken']);
		unset($body['phoneVerCode']);

		$message = array('head'=>$head, 'body'=>$body);

		include_once(APP_PATH . '/BaoyiPay/BaoyiPay.php');
		$xml = to_xmlstring($message);

		$mac = md5($xml . $this->config['KEY']);
		$para = array('xml'=>$xml, 'mac'=>$mac);
		D('AccountLog')->record($head, $xml, $mac, 0);

		$text = getHttpResponsePost($this->config['PAY_URL'], $para);

		$para = md5Response($text, $this->config['KEY']);

		if (!$para) {
			$this->ajaxReturn(array('status'=>0, 'info'=>'信息错误'));
			exit();
		}

		$data = xml2arr($para['xml']);
		$head = $data['head'];
		D('AccountLog')->record($head, $para['xml'], $para['mac'], 1);

		if ($head['respCode'] == 'C000000000') {
			$body = $data['body'];
			$this->ajaxReturn(array('status'=>1, 'phoneToken'=>$body['phoneToken']));
			exit();
		} else {
			if (!$head['respMsg']) {
				$this->error('未知错误，请联系管理员。');
			} else {
				$this->error($head['respMsg']);
			}
		}
  }

  // 卡号查询(QP0007)
	public function querycard() {
		if (IS_POST) {
			$uid = is_login();

			$head = $this->inithead('QP0007');
			//6228480328608732074
			$cardNo = $_POST['cardNo'];
			$merorderid = $_POST['merOrderId'];
			$card_id = $this->encrypt($head['clientDate'], $cardNo);
			$body = array('cardNo'=>$card_id);
			$message = array('head'=>$head, 'body'=>$body);

			include_once(APP_PATH . '/BaoyiPay/BaoyiPay.php');
			$xml = to_xmlstring($message);

			$mac = md5($xml .$this->config['KEY']);
			$para = array('xml'=>$xml, 'mac'=>$mac);
			D('AccountLog')->record($head, $xml, $mac, 0);
			$text = getHttpResponsePost($this->config['PAY_URL'], $para);

			$para = md5Response($text, $this->config['KEY']);
			
			if (!$para) {
				$this->ajaxReturn(array('status'=>0, 'info'=>'信息错误'));
				exit();
			}

			$data = xml2arr($para['xml']);
			$head = $data['head'];
			$body = $data['body'];
			D('AccountLog')->record($head, $para['xml'], $para['mac'], 1);

			if ($head['respCode'] == 'C000000000') {

				$info = M('ProductPay')->where(array('merorderid'=>$merorderid))->find();	
				// 验证订单是否允许使用信用卡
				if ($info['allow_creditcard'] == 0) {
					if ($body['cardType'] == '0') {
						$this->error('该订单不允许使用信用卡支付。');
					}
				}
				$card = M('QuickcardList')->where(
					array('uid'=>$uid, 'cardNo'=>$cardNo))->find();
				$bankinfo = $data['body'];

				if (!$card) {
					//所属银行编号
					$bankNo = $body['bankNo'];
					$bankNm = $body['bankNm'];

					if ($info['allow_creditcard'] == 0) {
						$is_quick = M('BankInfo')->where(array('is_quick'=>1, 'bank_code'=>$bankNo))->find();
						//不存在
						if(!$is_quick){
							$this->error('快捷支付暂不支持'.$bankNm.'的借记卡。');
						}
					}
					$storableCardNo = substr($cardNo, 0, 6) . substr($cardNo, strlen($cardNo) - 4);
					$id = M('QuickcardList')->add(array('uid'=>$uid, 'cardNo'=>$cardNo, 
						'bankNo'=> $bankinfo['bankNo'], 'cardType' =>$bankinfo['cardType'], 
						'bankNm' => $bankinfo['bankNm'], 'storableCardNo'=>$storableCardNo));

					$this->success('查询成功!', U('addstep2', 
						array('id'=>$id, 'merorderid'=>$merorderid)));
				} else {
					if ($card['status'] == 1) {
						$this->error('您已经绑定了该银行卡。');
					} else {
						$this->success('查询成功!', U('addstep2', 
							array('id'=>$card['id'], 'merorderid'=>$merorderid)));
						return;
					}
				}
			} else {
				$this->error($head['respMsg']);
			}
		}
	}

	/*页面返回操作*/
	public function callback() {
		if (empty($_POST['xml']) || empty($_POST['mac'])) {
			$this->error('非法操作。');
			exit();
		}
		$this->config = C('QUICK_PAY');

		$xml = $_POST['xml'];
		$mac = md5($xml . $this->config['KEY']);

		if ($mac == $_POST['mac']) {
			include_once(APP_PATH . '/BaoyiPay/BaoyiPay.php');

			$this->pay_finish($_POST, false);
		} else {
			D('AccountLog')->record(array('respMsg'=>$_POST['mac']), $xml, $mac, 2);
		}
	}
}
?>