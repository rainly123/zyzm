<?php 
namespace Home\Controller;
use Think\Controller;
use Think\Log;
class PayController extends HomeController {
	public function index() {
        $customId=$_GET['customId'];
        $this->changePayResult($customId);
		$uid = is_login();
		$maps=array('merorderid'=>$_GET['merorderid']);
		$this->data = M('ProductPay')->where($maps)->find();
		if (isMobile() && $this->data['type'] == 9) {
			$this->redirect('Quickpay/queryuser', array('merorderid'=>$_GET['merorderid']));
			exit();
		}
		$this->normal = M('BankInfo')->
			where(array('is_normal'=>1))->order('sort')->select();

		$this->quickpay = M('BankInfo')->
			where(array('is_quick'=>1))->order('sort')->select();

		$this->account = D('AccountUser')->getInfo($uid);
		$this->type = $_GET['type'];
		
		$this->need_pay = $this->data['pay_amount'] - $this->account['use_able'];
		$this->need_pay = $this->need_pay > 0? $this->need_pay:0;
		$maps = array('uid'=>$uid, 'q.status'=>1);
		if ($this->data['allow_creditcard'] == 0) {
			$maps['cardtype'] = 1;
		}
		$this->mycards = D('MycardView')->where($maps)->select();

		$this->pageTitle = "支付";
		$this->display('index');
	}

    /**
     * @param $customId
     *修改卖出数量和已筹款数
     */
    public  function changePayResult($customId)
    {
        $modelProductPrice = M('ProductPrice');
        $modelProductPay = M('ProductPay');
        $modelCustom = M('Custom');
        $modelProduct=M('Product');
        $recordCustom = $modelCustom->where(array('id' =>$customId))->find();
        $recordProductPrice = $modelProductPrice->where(array('id' =>$recordCustom['price_id']))->find();
        // 购买数 +1
        $currentSellCount = $recordProductPrice['sell_count'] + 1;
        //更新购买数量
        $resultPricesave = $modelProductPrice->where(array('id' =>$recordCustom['price_id']))->save(array('sell_count'=>$currentSellCount));
        //获取实物基本表
        $recordProduct = $modelProduct->where(array('id' =>$recordProductPrice['pid']))->find();
		//已筹金额
	    $finishamount = $recordProduct['finish_amount'] + $recordCustom['amount'];
		$resultProductSave = $modelProduct->where(array('id'=>$recordProduct['id']))->save(array('finish_amount'=>$finishamount));

    }

	/*网银支付*/
	public function normalpay() {
		$merorderid = $_GET['merorderid'];
		$bankcode = $_GET['bankcode'];
		$balance = I('balance', 0);  // 使用余额支付的金额

		if (empty($merorderid) || empty($bankcode)) {
			$this->error('指定参数不正确！');
		}

		$pay = M('ProductPay')->where(array('merorderid'=>$merorderid))->find();

		if (!$pay) {
			$this->error('非法参数');
		} else if($pay['state'] != 0){
			$this->error('流水号(' . $merorderid . ')已经处理。');
		}

		if (!empty($balance) && $balance > 0) {
			$account = D('AccountUser')->getInfo($pay['uid']);

			if ($account['use_able'] < $balance) {
				$this->error('可用余额不足。', U('Pay/index'));
			}
		}

		$pay['amountsum'] = $pay['pay_amount'] - $balance;
		M('ProductPay')->save(array('amountsum'=>$pay['amountsum'], 'paytype'=>0, 'id'=>$pay['id']));

		$payResults = A('BaoyiPayApi')->send($pay['amountsum'], 
				$merorderid,'','无', $bankcode);

		$message= '<script>window.location.href = "'. $payResults . '";</script>';
		
		$this->message = $message;
		$this->display('Account/loading');
	}

	/*快捷支付*/
	public function quickpay1() {
		$merorderid = $_GET['merorderid'];
		$balance = I('balance',0);  // 是否使用余额支付（0:不使用，1:使用）
		if (empty($merorderid)) {
			$this->error('参数不正确');
		}

		$pay = M('ProductPay')->where(array('merorderid'=>$merorderid))->find();

		if (!$pay) {
			$this->error('非法参数');
		} else if($pay['state'] != 0){
			$this->error('流水号(' . $merorderid . ')已经处理。');
		}
		if (isMobile() || ($pay['type'] != 9 && $balance > 0)) {
			$account = D('AccountUser')->getInfo($pay['uid']);
			$balance = $account['use_able'];	
		}

		$pay['amountsum'] = $pay['pay_amount'] - $balance;
		if ($pay['amountsum'] <= 0) {
			$this->error('账户余额大于支付金额，请刷新页面后重试。');
		}
		M('ProductPay')->save(array('amountsum'=>$pay['amountsum'], 'paytype'=>1, 'id'=>$pay['id']));

		$id = $_GET['id'];

		if ($id) { // 已绑定银行卡支付
			$this->success('', U('Quickpay/quickpay', 
				array('id'=>$id, 'merorderid'=>$merorderid)));
		} else { // 新卡支付
			if (isMobile()) {
				$this->success('',U('Quickpay/queryuser', array('merorderid'=>$_GET['merorderid'])));
			} else {
				$this->success('', U('Quickpay/addstep1',array('merorderid'=>$merorderid)));			
			}
		}
	}

	// 使用余额支付
	public function usebalance() {
		if (IS_AJAX) {
			$uid = is_login();
			$merorderid = $_GET['merorderid'];

			$pay = M('ProductPay')->where(array('merorderid'=>$merorderid))->find();
			if (!$pay) {
				$this->error('非法参数');
			} else if($pay['state'] != 0){
				$this->error('流水号(' . $merorderid . ')已经处理。');
			} else if ($pay['type'] != 0 && $pay['type'] != 1 && $pay['type'] != 2) { // 非实物、股票基金项目不可使用余额支付。
				$this->error('该订单不支持余额支付。');
			}
			M('ProductPay')->save(array('state'=>-1, 'id'=>$pay['id']));
			// 支付处理
			$data=array('uid'=>$pay['uid'], 'amount'=>$pay['pay_amount'], 
			'do_tag'=>$pay['type'], 'relation_id'=>$pay['orderid']);
			$ret = D('AccStream')->pay($data);

			if (!$ret) {
				$this->error('支付失败，账户可用余额不足。请先充值。');
			}

			if ($pay['type'] == 0) { // 实物项目支付
				// 实物订单更新
				A('ProductOrder')->payresult($pay, true);
			} else if ($pay['type'] == 1) {
				A('Account')->payback($pay, true);
			} else if ($pay['type'] == 2) { // 股票基金项目
				// 股权支付处理
				A('Stock')->payback($pay['orderid'], true);
			}
		}
	}

	public function offline() {
		$merorderid = $_GET['merorderid'];
		$data = M('ProductPay')->where(array('merorderid'=>$merorderid))->find();
		$this->amount = $data['amountsum'];
		$this->display('offline');
	}

	// 回调处理
	public function notify() {

	}

}
?>