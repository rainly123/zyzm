<?php 
namespace Admin\Controller;
use Think\Controller;

class DrawcashController extends AdminController {
	public function index() {
		$list = M('DrawcashList')->order('create_time desc')->select();
		
		int_to_string($list,array('status'=>array(0=>'交易中',1=>'交易成功',2=>'交易失败')));
		int_to_string($list,array('state'=>array('00'=>'待结算','01'=>'结算中','02'=>'结算成功','03'=>'结算失败','04'=>'已撤销')));
		
		$this->assign('list',$list);
		$this->display();
	}

	public function cash() {
		$today = strtotime(date('Y-m-d', NOW_TIME));

		if (IS_GET) {
			$this->amount = M('OnlinePay')->where(array('state' => 1, 'update_time' =>array('lt',$today)))->sum('amountsum');
			$this->bankinfo = M('BankInfo')->order('bank_type')->select();
			$this->display('cash');	
		} else {
			$info = M('OnlinePay')->where(array('state' => 1, 'update_time' => array('lt',$today)))->select();
			if (!$info) {
				$this->error('没有可提现金额');
			}
			$amount = 0;
			foreach ($info as $key => $value) {
				$amount += $value['amountsum'];
			}

			$bankinfo= array(
				'bankId'=>$_POST['bank_type'],//银行代码,3位
				'acctNo'=>$_POST['card_number'],//银行卡或存折号码
				'acctName'=>$_POST['true_name'],//银行卡或存折上的所有人姓名
				'bankName'=>$_POST['sub_branch'],//开户行名称
				'bankProvince'=>$_POST['bank_province'],//开户行所在省
				'bankCity'=>$_POST['bank_city'],//开户行所在市
				'amount'=>sprintf("%01.2f",$amount)//金额
			);

			$notifyurl = 'http://'. $_SERVER['HTTP_HOST'] .U('Public/callback');

			$ret = $this->drawcash($bankinfo,$notifyurl);

			if (!empty($ret)) {
				foreach ($info as $key => $value) {
					M('ProductPay')->save(array('id'=>$value['id'], 'state'=>2));
					M('CashFlow')->add(array(
						'bussflowno' => $ret, 'merorderid'=>$value['merorderid'],
						'orderid' => $value['orderid'], 'ptype' => $value['ptype'],
						'pid' => $value['pid'], 'amount' => $value['amountsum'],
						'create_time' => NOW_TIME
					));
				}
			}

			$this->success('处理成功!');
		}
	}

	public function callback() {
    
  	include_once(APP_PATH . '/BaoyiPay/BaoyiPay.php');
  		
  	$xml = $_POST['data'];
  
  	$info = xml2arr($xml);
  	$body = $info['body'];
  		
  	//返回成功
  	if($body['state']=='02'){ // 结算成功
			$pay = M('DrawcashList')->where(array('bussflowno'=>$body['tranSeqId']))->find();
  		if ($pay['status'] == 0) {
  			//更新提现记录
  			$drawcashlist = array(
  					'id' => $pay['id'],
  					'real_amount' => $body['amount'],
  					'submitdate'=>$body['submitDate'],
  					'acctno'=>$body['acctNo'],
  					'acctname'=>$body['acctName'],
  					'state'=>$body['state'],
  					'proctime'=>$body['procTime'],
  					'remark'=>$body['remark'],
  					'update_time'=>NOW_TIME,
  					'status'=>'1');

  			M('CashFlow')->where(array('bussflowno'=>$body['tranSeqId']))->save(array('state'=>1));
  
  			M('DrawcashList')->save($drawcashlist);
  		}
  	} elseif($body['state']=='03') { // 结算失败
  		//查看交易记录
  		$pay = M('DrawcashList')->where(array('bussflowno'=>$body['tranSeqId']))->find();
  		if ($pay['status'] == 0) {
  			//更新提现金额
  			$productinfo = M('Product')->find($pay['pid']);
  
  			$drawcash_amount = $productinfo['drawcash_amount'] - $body['amount'];
  			$product = array(
  					'id' => $pay['pid'],
  					'drawcash_amount' => $drawcash_amount);
  
  			M('Product')->save($product);
  
  			//更新提现记录
  			$drawcashlist = array(
  					'id' => $pay['id'],
  					'real_amount' => $body['amount'],
  					'submitdate'=>$body['submitDate'],
  					'acctno'=>$body['acctNo'],
  					'acctname'=>$body['acctName'],
  					'state'=>$body['state'],
  					'proctime'=>$body['procTime'],
  					'remark'=>$body['remark'],
  					'update_time'=>NOW_TIME,
  					'status'=>'2');
  
  			M('DrawcashList')->save($drawcashlist);
  
  		}
  	}
	}

	//提现操作
	public function drawcash($bankinfo,$notifyurl){
		$uid = is_login();
		$this->config = C('DRAW_CASH');

		$time = NOW_TIME;

		$tradFlowNo =time_format($time,'Ymd').$this->config['MERCHANTID'].substr(floor(microtime($time) * 1000),-8);
		//head文件
		$head = array(
				'version'=>'01', //版本号
				'type'=>'0001',//请求报文：0001
				'channelNo'=>'HM', //第三方商户固定“HM”
				'tradDate'=>time_format($time,'Ymd'), //交易日期，格式：YYYYMMDD 如：20120628
				'tradTime'=>time_format($time,'His'),//交易时间，格式：HHMMSS 如：142356
				'tradFlowNo'=>$tradFlowNo, //商户规则：YYYYMMDD+商户号+8位序号
				'tradNo'=>'ES0007'); //交易代码
			
		//body文件
		$body = array(
				'tranSeqId'=>$tradFlowNo,//交易流水号yyyMMdd+商户号+8位序号
				'merchantNo'=>$this->config['MERCHANTID'],//商户号
				'alias'=>$this->config['ALIAS'],//账户别名
				'submitDate'=>time_format($time,'Ymd'),//提交日期yyyMMdd
				'isNeedNotify'=>'0',//是否需要主动通知受理结果0：需要1：不需要
				'notifyUrl'=>$notifyurl,//通知地址
				'batchUse'=>'01',//用途01-	提现      02-	放标       03-退款
				'bankId'=>$bankinfo['bankId'],//银行代码 3位
				'acctNo'=>$bankinfo['acctNo'],//银行卡或存折号码 32位
				'acctName'=>$bankinfo['acctName'],//银行卡或存折上的所有人姓名。
				'acctAttribute'=>'02',//账户属性01：对公  02：对私
				'bankName'=>$bankinfo['bankName'],//开户行名称
				'bankProvince'=>$bankinfo['bankProvince'],//填写时，不带"省"或"自治区"CHAR(20)
				'bankCity'=>$bankinfo['bankCity'],//填写时，直接使用之前录入的客户信息CHAR(20)
				'cityCode'=>'',//开户行城市的地区代码（参考大小额地区编码）
				'amount'=>$bankinfo['amount'],//单位元，保留至小数点后两位，不可为0
				'currencyType'=>'CNY',//人民币：CNY, 港元：HKD，美元：USD。不填时，默认为人民币。
				'mobilePhone'=>'',//手机号
				'remark'=>'',//备注
		);
	
		$message = array('head'=>$head, 'body'=>$body);

		include_once(APP_PATH . '/BaoyiPay/BaoyiPay.php');
		$xml = to_xmlstring1($message);

		$mac = md5($xml .$this->config['MERKEY']);
		$para = array(
				'tradNo'=>'ES0007',
				'type'=>'0001',
				'merchantNo'=>$this->config['MERCHANTID'],
				'data'=>$xml,
				'mac'=>$mac);
			
		// D('AccountLog')->record($head, $xml, $mac, 7);

		$text = $this->getHttpResponseGet($this->config['DRAW_URL'], $para);
		$para = md5Response($text, $this->config['MERKEY']);
	
		if (!$para) {
			$this->error('返回信息不正确');
		}
		if($para['status'] =='000000000'){

			//提现记录
			$drawcashlist = array(
					'pid' => 0,
					'bussflowno' => $tradFlowNo,
					'amount' => $bankinfo['amount'],
					'create_time'=>NOW_TIME,
					'update_time'=>NOW_TIME);
				
			M('DrawcashList')->add($drawcashlist);
			return $tradFlowNo;
		}else{
			$this->error($para['statusMsg']);
		}
	}
	/**
	 * get请求
	 * @param     $url   提交的地址
	 * @param   $para  传递参数
	 **/
	function getHttpResponseGet($url,$postData=null) {
		$ch = curl_init();
		$o='';
		if (!empty($postData)) {
			foreach ($postData as $k=>$v)
			{
				$o.= "$k=".urlencode($v)."&";
			}
	
			$postData=substr($o,0,-1);
			$url = $url.'?'.$postData;
		}
	
		$ch = curl_init();
		$header = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($ch);
	
		return $temp;
	
	}

}
?>