<?php
namespace Home\Controller;
use Think\Log;

class BaoyiPayApiController extends HomeController {
	public function send($amount,$orderId,$detailURL,$priceContent, $bankname=null) {

		require_once(APP_PATH.'BaoyiPay/BaoyiPay.php');
		define('currentDomian','http://'. $_SERVER['HTTP_HOST']); //'http://xiami121.oicp.net/jumu' 
		
		$config = C('NORMAL_PAY');

		$merorderid = $orderId;//提交宝易互通的订单号，不能有重复（建议商户每次提交时，均重新生成新的订单号）
		$amountsum  = $amount; 			 //购买金额    
		$currencytype   = "01";  			 //货种，固定不需要修改，01代表人民币
		
		//以下三个参数为支付结果页面通知方式所需，使用方式参考支付接口文档说明
		$autojump   = "1";   			    //银行付款成功后是否自动跳转到取货页面：0→不跳转；1→跳转；
		$waittime   = "5";   			    //跳转到取货页面的等待时间，以秒为单位，默认5秒；
		$merurl     = currentDomian.U('BaoyiPayApi/receive');   			 //商户端用于收取宝易互通主动通过页面方式推送支付结果的地址。商户可根据自己的实际URL地址填写。(采用get方式传送)

	  //以下三个参数为支付结果服务器通知方式所需，使用方式参考支付接口文档说明
	  $informmer  = "1";   			//将订单的状态通知给商户的URL：0→不通知；1→通知；
	  $informurl  = currentDomian.U('BaoyiPayApi/informurl');   			 //商户端用于收取宝易互通主动通过服务器方式推送支付结果的地址。商户可根据自己的实际URL地址填写。(采用post方式传送)
		$confirm    = "1";           //商户是否响应平台的确认信息：0→不返回；1→返回（该参数的使用请参考文档）
		
		$merbank    = "empty";       //该参数的使用请参考文档，若接口版本为标准版，请填写empty
		$tradetype  = "0";
		$bankInput  = "0";			// 宝易端选择银行
		$interface  = "5.00";
		$bankcardtype = "01";//支付银行卡类型  00-->借贷混合 01-->纯借记
		$pdtdetailurl = "http://www.dreammove.cn";//商品描述地址
		$pdtdnm = '聚募众筹充值';//商品描述
		$mac        = "";			        //md5校验码	

		if (!empty($bankname)) {
			$autojump = 1;
			$waittime = 0;
			$bankInput = 1;
			$merbank = $bankname;
		}
		
		$sour = "merchantid=".$config['MERCHANTID'].
						"&merorderid=".$merorderid.
						"&amountsum=".$amountsum.
						"&subject=" . $config['SUBJECT'] .
						"&currencytype=".$currencytype.
						"&autojump=".$autojump.
						"&waittime=".$waittime.
						"&merurl=".$merurl.
						"&informmer=".$informmer.
						"&informurl=".$informurl.
						"&confirm=".$confirm.
						"&merbank=".$merbank.
						"&tradetype=".$tradetype.
						"&bankInput=".$bankInput.
						"&interface=".$interface.
						"&bankcardtype=".$bankcardtype.
						"&pdtdetailurl=".$pdtdetailurl;	//MD5计算数据源

		$change = $sour . "&merkey=" . $config['MERKEY'];

		//调用签名函数生成签名串
		$mac = md5($change);
		// 存log  记录
		$modelPayLog = M('PayLog');
		$dataPayLog['type'] = 0;
		$dataPayLog['merorderid'] = $orderId;
		$dataPayLog['amountsum'] = $amount;
		$dataPayLog['content'] = $sour;
		$dataPayLog['mac'] = $mac;
		$dataPayLog['state'] = 0;
		$dataPayLog['create_time'] = time();
		$modelPayLog->data($dataPayLog)->add();

		$requestData['merchantid'] =$config['MERCHANTID']; 
		$requestData['merorderid'] =$merorderid; 
		$requestData['amountsum'] =$amountsum; 
		$requestData['subject'] =$config['SUBJECT']; 
		$requestData['currencytype'] =$currencytype; 
		$requestData['autojump'] =$autojump; 
		$requestData['waittime'] =$waittime; 
		$requestData['merurl'] =$merurl; 
		$requestData['informmer'] =$informmer; 
		$requestData['informurl'] =$informurl; 
		$requestData['confirm'] =$confirm; 
		$requestData['merbank'] =$merbank; 
		$requestData['tradetype'] =$tradetype;
		$requestData['bankInput'] =$bankInput;
		$requestData['interface'] =$interface; 
		$requestData['bankcardtype'] =$bankcardtype; 
		$requestData['pdtdetailurl'] =$pdtdetailurl; 
		$requestData['pdtdnm'] =$pdtdnm; 
		$requestData['remark'] ='无'; 
		$requestData['mac'] =$mac; 

		$result = buildHttpUrl($config['PAY_URL'],$requestData);
		return $result;
	}

	public function receive(){

		$config = C('NORMAL_PAY');

		$_merchantid= $_REQUEST["merchantid"];
	  $_merorderid= $_REQUEST["merorderid"];
	  $_amountsum= $_REQUEST["amountsum"];
	  $_currencytype= $_REQUEST["currencytype"];
	  $_subject= $_REQUEST["subject"];
	  $_state= $_REQUEST["state"];
	  $_paybank= $_REQUEST["paybank"];
	  $_banksendtime= $_REQUEST["banksendtime"];
	  $_merrecvtime= $_REQUEST["merrecvtime"];
	  $_interface= $_REQUEST["interface"];
	  $_mac= $_REQUEST["mac"];
	  $allData = $_REQUEST;
    //商户支付密钥，商户系统与宝易互通通讯时，用来做关键数据的MD5计算使用，商户投产时，需要替换（参考密钥修改操作手册），该参数不要作为form表单项传送
		$sour = "merchantid=".$_merchantid.
					"&merorderid=".$_merorderid.
					"&amountsum=".$_amountsum.
					"&currencytype=".$_currencytype.
					"&subject=".$_subject.
					"&state=".$_state.
					"&paybank=".$_paybank.
					"&banksendtime=".$_banksendtime.
					"&merrecvtime=".$_merrecvtime.
					"&interface=".$_interface;

		$change = $sour . "&merkey=". $config['MERKEY'];    //MD5计算数据源

		//生成客户端md5校验码
		$mysign=md5($change);

		if($_mac==$mysign){

			// 存log  记录
			$modelPayLog = M('PayLog');
			$dataPayLog['type'] = 1;
			$dataPayLog['merorderid'] = $_merorderid;
			$dataPayLog['amountsum'] = $_amountsum;
			$dataPayLog['content'] = $sour;
			$dataPayLog['mac'] = $_mac;
			$dataPayLog['state'] = $_state;
			$dataPayLog['create_time'] = time();
			$resultPayLog = $modelPayLog->data($dataPayLog)->add();
			
			$modelProductPay = M('ProductPay');
			$pay = $modelProductPay->where(array('merorderid'=>$_merorderid))->find();
	
			// change jm_product_pay status
			if (empty($pay)==false && $pay['state'] == 0) {
				$dataProductpay['state'] = $_state;
				$dataProductpay['paybank'] = $_paybank;
				$dataProductpay['real_amount'] = $_amountsum;
				$dataProductpay['update_time'] = time();
				$resultProductpaySave = $modelProductPay->where(array('merorderid' =>$_merorderid))->save($dataProductpay);
				if ($resultProductpaySave==false) {
					sleep(1);
				}
			}
			if($_state=="1") {
				// 充值处理
				if ($pay['state'] == 0) {
					$data=array('uid'=>$pay['uid'], 'amount'=>$pay['amountsum'], 
						'do_tag'=>$pay['type'], 'relation_id'=>$pay['merorderid']);
					$ret = D('AccStream')->recharge($data);
					if (!$ret) {
						$this->error("充值记录重复处理，请查看用户中心是否到账，如有疑问，请联系聚募客服。", U('Account/index'));
					}
				}
				
	   		//订单类型（0：实物、1：股权、2：期指）
		   	if($pay['type'] ==0){
		   		// 支付处理
					$data=array('uid'=>$pay['uid'], 'amount'=>$pay['pay_amount'], 
						'do_tag'=>$pay['type'], 'relation_id'=>$pay['orderid']);
					$ret = D('AccStream')->pay($data);
						if (!$ret) {
						$this->error("充值成功，但账户可用余额不足，未完成支付。", U('Account/index'));
					}

		   		A('ProductOrder')->payresult($pay);
		   	} elseif ($pay['type'] == 1) {
		   		// 支付处理
					$data=array('uid'=>$pay['uid'], 'amount'=>$pay['pay_amount'], 
						'do_tag'=>$pay['type'], 'relation_id'=>$pay['orderid']);
					$ret = D('AccStream')->pay($data);
					if (!$ret) {
						$this->error("充值成功，但账户可用余额不足，未完成支付。", U('Account/index'));
					}
		   		A('Account')->payback($pay);
		   	}elseif($pay['type'] == 2){ 
		   		// 支付处理
		   		$data=array('uid'=>$pay['uid'], 'amount'=>$pay['pay_amount'], 
						'do_tag'=>$pay['type'], 'relation_id'=>$pay['orderid']);
					$ret = D('AccStream')->pay($data);
					if (!$ret) {
							$this->error("充值成功，但账户可用余额不足，未完成支付。", U('Account/index'));
					}
		   		A('Stock')->payback($pay['orderid']);
		   	}else if($pay['type'] == 9) {
					$return_url = $pay['return_url'];
					if (empty($return_url)) {$return_url = U('Account/index');}
					$this->success('支付处理成功。', $return_url);	
		   	}
		  } else {
				Log::write("订单支付支付失败：$_merchantid");
				$this->error('订单支付失败。请联系聚募网。');
		  }
		}
	}

	// 服务器对服务器 通知
	public function informurl(){
		// 存log  记录
		$modelPayLog = M('PayLog');

		//新增 存回调一样的东西。。
		$_merchantid= $_REQUEST["merchantid"];
		$_merorderid= $_REQUEST["merorderid"];
		$_amountsum= $_REQUEST["amountsum"];
		$_currencytype= $_REQUEST["currencytype"];
		$_subject= $_REQUEST["subject"];
		$_state= $_REQUEST["state"];
		$_paybank= $_REQUEST["paybank"];
		$_banksendtime= $_REQUEST["banksendtime"];
		$_merrecvtime= $_REQUEST["merrecvtime"];
		$_interface= $_REQUEST["interface"];
		$_mac= $_REQUEST["mac"];
		$allData = $_REQUEST;
    
    //商户支付密钥，商户系统与宝易互通通讯时，用来做关键数据的MD5计算使用，商户投产时，需要替换（参考密钥修改操作手册），该参数不要作为form表单项传送
		$sour = "merchantid=".$_merchantid.
				"&merorderid=".$_merorderid.
				"&amountsum=".$_amountsum.
				"&currencytype=".$_currencytype.
				"&subject=".$_subject.
				"&state=".$_state.
				"&paybank=".$_paybank.
				"&banksendtime=".$_banksendtime.
				"&merrecvtime=".$_merrecvtime.
				"&interface=".$_interface;

		$config = C('NORMAL_PAY');
		//生成客户端md5校验码
		$mysign=md5($sour . "&merkey=" . $config['MERKEY']);

		if($_mac==$mysign){
			// 存log  记录
			$dataPayLog['type'] = 2;
			$dataPayLog['merorderid'] = $_merorderid;
			$dataPayLog['amountsum'] = $_amountsum;
			$dataPayLog['content'] = $sour;
			$dataPayLog['mac'] = $_mac;
			$dataPayLog['state'] = $_state;
			$dataPayLog['create_time'] = time();
			$resultPayLog = $modelPayLog->data($dataPayLog)->add();
			
			$modelProductPay = M('ProductPay');
			$pay = $modelProductPay->where(array('merorderid'=>$_merorderid))->find();
			// change jm_product_pay status
			if (empty($pay)==false && $pay['state'] == 0) {
				$dataProductpay['state'] = $_state;
				$dataProductpay['paybank'] = $_paybank;
				$dataProductpay['update_time'] = time();
				$resultProductpaySave = $modelProductPay->where(array('merorderid' =>$_merorderid))->save($dataProductpay);
			  if ($resultProductpaySave == false) {
					sleep(1);
			  }
				// 充值处理
				$data=array('uid'=>$pay['uid'], 'amount'=>$pay['amountsum'], 
					'do_tag'=>$pay['type'], 'relation_id'=>$pay['merorderid']);
				$ret = D('AccStream')->recharge($data);
				if (!$ret) {
					exit();
				}

				if($_state=="1") {
				  //订单类型（0：实物、1：股权、2：期指）
				 	if($pay['type'] ==0){
				   	// 支付处理
				   	$data=array('uid'=>$pay['uid'], 'amount'=>$pay['pay_amount'], 
							'do_tag'=>$pay['type'], 'relation_id'=>$pay['orderid']);
						$ret = D('AccStream')->pay($data);
						if (!$ret) {
							exit();
						}
			   		A('ProductOrder')->payresult($pay);	   		 
			   	} elseif ($pay['type'] == 1) {
				   	// 支付处理
						$data=array('uid'=>$pay['uid'], 'amount'=>$pay['pay_amount'], 
							'do_tag'=>$pay['type'], 'relation_id'=>$pay['orderid']);
						$ret = D('AccStream')->pay($data);
						if (!$ret) {
							exit();
						}
			   		A('Account')->payback($pay, false);
			   	} elseif($pay['type'] == 2) {
			   		// 支付处理
			   		$data=array('uid'=>$pay['uid'], 'amount'=>$pay['pay_amount'], 
							'do_tag'=>$pay['type'], 'relation_id'=>$pay['orderid']);
						$ret = D('AccStream')->pay($data);
						if (!$ret) {
							exit();
						}
			   		A('Stock')->payback($pay['orderid'], false);
			   	}else if($pay['type'] == 9) {
			   		// 无须处理
			   	}
			  }else{
			  	Log::write("订单支付支付失败：$_merchantid");
			  }
			}else{
			}
		}
		// 易宝服务器需要
		print_r('success=true');
	}
	
}