<?php
namespace Admin\Controller;

class ProductController extends AdminController{

	//项目信息
	public function index(){
		$page = I('p');
		if (empty($page)) {
			$page = 1;
		}
		$modelProduct = M('Product');
		$list = $modelProduct->order('update_time desc')->page($page.',10')->select();
		

		$count      = $modelProduct/*->where('status=1')*/->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
		$show       = $Page->show();// 分页显示输出
		// var_dump($show);
		// （0：普通、1：申请发布、2：不通过、9：审核通过）
		int_to_string($list, 
			array('status'=>array(0=>'未提交',1=>'申请发布',2=>'不通过',9=>'审核通过')));
		// （0:初始、1:预热、2:上线、8:众筹失败、9:众筹成功）
		int_to_string($list,
			array('stage'=>array(0=>'筹备中',1=>'预热中',2=>'众筹中',8=>'众筹失败',9=>'众筹成功')));
		 $this->_list = $list;
		$this->assign('page',$show);// 赋值分页输出
		
		$viewurl = "http://".$_SERVER['HTTP_HOST']."/Product/viewDetail/isshow/1/pid/";
		$this->assign('viewurl',$viewurl);
		$this->display();
	}

	public function custom(){
		$page = I('p');
		if (empty($page)) {
			$page = 1;
		}

		$modelCustom = M('Custom');
		$list = $modelCustom->order('update_time desc')->page($page.',10')->select();
		$count      = $modelCustom/*->where('status=1')*/->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数
		$show       = $Page->show();// 分页显示输出

		// 状态 回报相关id（0:购买成功、1:支付成功、-1:撤消 -2没有购买名额了）
		int_to_string($list, 
			array('status'=>array(0=>'购买成功',1=>'支付成功',-1=>'撤消',-2=>'没有购买名额了')));
		$this->_list = $list;
		$this->assign('page',$show);// 赋值分页输出

		$this->display();
	}

	//项目详情
	public function preview($cid) {
		$modelCustom = M('Custom');
		$modelCustomAddress = M('CustomAddress');
		$modelProductPrice = M('ProductPrice');
		$modelProduct = M('Product');

		$recordCustom = $modelCustom->where(array('id'=>$cid))->find();
	
		$recordCustomAddress = $modelCustomAddress->where(array('address_id'=>$recordCustom['address_id']))->find();
		$recordProductPrice = $modelProductPrice->where(array('id'=>$recordCustom['price_id']))->find();
		$recordProduct = $modelProduct->where(array('id'=>$recordProductPrice['pid']))->find();

		$this->assign('recordCustom',$recordCustom);
		$this->assign('recordCustomAddress',$recordCustomAddress);
		$this->assign('recordProductPrice',$recordProductPrice);
		$this->assign('recordProduct',$recordProduct);

		$this->display('custom_preview');
	}
	// 审核通过
	public function review() {
		if (IS_AJAX) {
			$id = $_GET['id'];
			$status = $_GET['status'];
			if (!isset($id)) {
				$this->error('没有指定项目');
			}
			if (!isset($status) || ($status != 2 && $status != 9)) {
				$this->error('未指定审核结果');
			}
			$product = M('Product')->find($id);
			if (!$product) {$this->error('指定项目不存在。');}
			$resultChangeStatus = M('Product')->save(array('status'=>$status, 'id'=> $id));
			if ($resultChangeStatus) {
				$this->success('项目(' . $product['name'] . ')审核处理完成。');
			}else{
				$this->error('审核失败，系统出错');
			}
		}
	}
	
	// 更改项目状态
	public function stagechange() {
		if (IS_AJAX) {
			$id = $_GET['id'];
			$status = $_GET['status'];
			if (!isset($id)) {
				$this->error('没有指定项目');
			}
			$product = M('Product')->find($id);
			if (!$product) {$this->error('指定项目不存在。');}
			
			if($product['status']  != 9){
				$this->error('改项目还未审核通过');
			}
			$data = array('stage'=>$status, 'id'=> $id, 'update_time'=>NOW_TIME);
			if($status==1){
				$message='【' . $product['name'] . '】项目阶段调整为预热';
			} elseif($status==2) {
				$message='【' . $product['name'] . '】项目阶段调整为上线';
				$data['start_time'] = strtotime(date('Y-m-d', NOW_TIME));
			} elseif($status==8) {
				$message='【' . $product['name'] . '】项目阶段调整为众筹失败';
			}elseif($status==9) {
				$message='【' . $product['name'] . '】项目阶段调整为众筹成功';
			}
		
			$resultChangeStatus = M('Product')->save($data);
			if ($resultChangeStatus) {
				$this->success($message);
			}else{
				$this->error('修改失败，系统出错');
			}
		}
	}

	// 更改订单状态
	public function customStatusChange() {
		if (IS_AJAX) {

			$id = $_GET['id'];
			$status = $_GET['status'];
			if (!isset($id)) {
				$this->error('没有指定项目');
			}
			//查看订单是否存在
			$custom = M('Custom')->find($id);
			if (!$custom) {$this->error('指定订单不存在。');}
			
			if($custom['status'] == -1 or $custom['status'] == -2){
				$this->error('改项目已撤销或者没有购买名额');
			}
			
			//获取项目信息
			$product = M('Product')->find($custom['pid']);
			
			//price_id
			$productprice = M('ProductPrice')->find($custom['price_id']);
			
			//限额不足
			if($productprice['count']>0){
				if($productprice['count']  < $productprice['sell_count']){
					$this->error('超出可购买件数，请联系管理员');
				}
			}
			
			if($status==0){
				$message='【' . $custom['id'] . '】订单调整为购买成功';
			} elseif($status==1) {
				$message='【' . $custom['id'] . '】订单调整为支付成功';
			} elseif($status==2) {
				$message='【' . $custom['id'] . '】订单调整为支付成功金额不足';
			}
		
			//修改订单状态
			$remarks = '手动修改,'.date("Y-m-d H:i:s",  NOW_TIME);
			$resultChangeStatus = M('Custom')->save(array('status'=>$status, 'id'=> $id,'remarks'=>$remarks));
			
			//更新
			if ($resultChangeStatus) {
				//更新卖出量 = 已购买数量+当前订单的购买数量
				$sell_count =  $productprice['sell_count'] +$custom['count'];
				M('ProductPrice')->save(array('sell_count'=>$sell_count, 'id'=> $productprice['id']));
				
				//更新已够金额=已认购金额 + 当前订单金额
				$amount = $product['finish_amount'] + $custom['amount'] ;
				M('Product')->save(array('finish_amount'=>$amount, 'id'=> $product['id']));	
			}
			
			if ($resultChangeStatus) {
				$this->success($message);
			}else{
				$this->error('修改失败，系统出错');
			}
		}
	}

	//查看订单 zhao
	public function CrowdfundingOrder($pid){
		//项目表
		$modelProduct = M('Product');
		//回报
		$modelProductPrice = M('ProductPrice');
		//订单
		$modelCustom = M('Custom');
		//获取项目名称
		$myProduct = $modelProduct->where(array('id'=>$pid))->field('name')->find();
		//获取当前项目所有的回报ID
		$myProductPriceIds = $modelProductPrice->where(array('pid'=>$pid))->getField('id',true);

		//统计金额值
		//购买数量不默认为1的时候需要注意。这段代码
		$whereSum['price_id'] = array('in',$myProductPriceIds);
		$whereSum['status'] = array('EQ',1);
		$listSum = $modelCustom->where($whereSum)->sum('amount');
		
		// 分页
		$page = I('p');
		if (empty($page)) {
			$page = 1;
		}

		//根据回报获取所有的交易记录
		$where['price_id'] = array('in',$myProductPriceIds);
		$list = $modelCustom->where($where)->order('create_time desc')->page($page.',15')->select();
		
		foreach ($list as $k=>$v)
		{
			//获取收货人姓名
			$myname = M('CustomAddress')->where(array('id'=>$v['address_id']))->field('name')->find();
			$list[$k]['myname'] = $myname['name'];
		}
		
		$count      = $modelCustom->where($where)->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
		$show       = $Page->show();// 分页显示输出

		$this->assign('myProduct',$myProduct);
		$this->assign('listSum',$listSum);
		$this->assign('list',$list);
		$this->assign('page',$show);// 赋值分页输出
		$this->display();
	}
	

	//TODO 实物众筹创建第一步
	public function addstep1(){
		$pid = $_GET['pid'];
		$uid = is_login();
		$modelProduct = M('product');
		$modelProductInfo = M('ProductInfo');
			
		if (IS_POST) {
			$product = $_POST;
			$product['start_time'] = time();
			$product['describe'] = $product['projectSummary'];
			$product['update_time'] = $product['create_time']= time();
			$product['create_id'] = $product['update_id'] = $product['uid'] = $uid;

				$isProduct = $modelProduct->where(array('id'=>$pid))->find();
				if (empty($isProduct)) {
					$this->error('此众筹项目不存在');
				}
				//数据已存在，则更新
				$id = $modelProduct->where(array('id'=>$pid))->save($product);


			if ($id === false) {
				//保存失败
				$this->error('部分信息保存失败');
			}else{
				$productInfo['pro_img'] = $product['project_img'];
				$productInfo['video_path'] = $product['videoAddr'];
				$productInfo['content'] = $product['datail'];
				$productInfo['create_id'] = $productInfo['update_id'] = $uid;;
				$productInfo['update_time'] = $productInfo['create_time']= time();
				//修改数据
					$productInfo['pid'] = $pid;
					$id=$pid;
					$resultProductInfo = $modelProductInfo->where(array('pid'=>$pid))->save($productInfo);
				
				if ($resultProductInfo === false) {
					$this->error('部分信息保存失败');
				}
			}
	
			// $this->redirect(U('addstep2', array('pid'=>$id)));
			
			$this->success('处理成功！', U('addstep2', array('pid'=>$id)));
		}else{
			//如果pid有值

				//获取信息
				$aProduct = $modelProduct->where(array('id'=>$pid))->find();
				$aProductInfo = $modelProductInfo->where(array('pid'=>$pid))->find();

// var_dump($aProduct);
			$this->assign($aProduct);
			$this->assign('aProductInfo',$aProductInfo);
			$this->assign('navFlage','step1');
			$this->display();
		}

	}

	//TODO 后端post数据校验。。
	public function addstep2(){
		$uid = is_login();
		$pid=$_GET['pid'];
		if(empty($pid)){
			$this->error('关键参数未获得');
		}

		$modelProductPrice = M('ProductPrice');

		if (IS_POST) {
// var_dump('expression');exit();
			$uid = is_login();
			$data = $_POST;

			$isProduct = M('product')->where(array('id'=>$pid))->find();
			if (empty($isProduct)) {
				$this->error('此众筹项目不存在');
			}
			
			$data['pid'] = $pid;
			$data['create_id'] = $data['update_id'] = $uid;;
			$data['update_time'] = $data['create_time']= time();

			if ($data['order_number'] > 0) 	{
				$result = $modelProductPrice->where(array('id'=>$data['order_number']))->save($data); 
			}else{
				$result = $modelProductPrice->add($data); 
			}

			if(!$result){
				$this->error('处理失败，请联系管理员:service@dreammove.cn');
			}

			$this->success('处理成功！', U('addstep3', array('pid'=>$id)));
		}else{

			$resultPrice = $modelProductPrice->where(array('pid'=>$pid))->select();
			// var_dump($resultPrice);exit();
			$this->assign('resultPrice',$resultPrice);
			$this->assign('navFlage','step2');
			$this->assign('pid',$pid);
			$this->display();
		}
	}

	//TODO 后端post数据校验。。
	public function addstep3(){
		$uid = is_login();

		$pid=$_GET['pid'];
		$modelProductHolder = M('ProductHolder');

		if (IS_POST) {
			$data = $_POST;

			$isProduct = M('product')->where(array('id'=>$pid))->find();
			if (empty($isProduct)) {
				$this->error('此众筹项目不存在');
			}
			
			$data['pid'] = $pid;
			$data['uid'] = $isProduct['uid'];
			$data['create_time']= time();
			if ($data['card_number'] != $data['confirm_card_number']) {
				$this->error('两次银行卡号输入不一致');
			}
			
			$info = $modelProductHolder->where(array('pid'=>$pid))->find();
			
			$id = $info['id'];

				$result = $modelProductHolder->where(array('id'=>$id))->save($data); 

			if(!$result){
				$this->error('处理失败，请联系管理员:service@dreammove.cn');
			}
			$this->success('处理成功！', U('Product/index'));

			
		}else{
			//开户银行信息
			$bankinfo = M('BankInfo')->where(array('is_drawcash'=>1))->select();
			$holderRecord = $modelProductHolder->where(array('pid'=>$pid))->find($data);

			$this->assign($holderRecord);
			$this->assign('navFlage','step3');
			$this->assign('pid',$pid);
			$this->assign('bankinfo',$bankinfo);
			$this->display();
		}
	}

	public function deleteProductPrice($id){
		if (empty($id)) {
			$this->error('关键参数未获得');
		}
		$modelProductPrice = M('ProductPrice');
		$result = $modelProductPrice->where('id='.$id)->delete();
		if ($result !=false) {
			$this->success('处理成功');
		}else{
			$this->error('处理失败');
		}
	}

	public function getPriceUsedRevise($id){
		if (empty($id)) {
			$this->error('关键参数未获得');
		}
		$modelProductPrice = M('ProductPrice');
		$resultRecord = $modelProductPrice->where(array('id'=>$id))->find();
	
		if (empty($resultRecord)) {
			$this->error('获取信息失败');
		}else{
			$resultRecord['image_url'] = get_cover($resultRecord['image'],'path');
			if (empty($resultRecord['image_url'])) {
				$resultRecord['image_url'] = null;
			}
			$this->success($resultRecord);
		}
	}

	/**
	 * 提现
	 *@param $data    一个二维数组,结构如同从数据库查出来的数组
	 */
	function dodrawcash(){
		//id
		$pid = $_GET['pid'];
		$uid = $_GET['uid'];

		//当前时间
		$drawcash_date = date('Ymd',NOW_TIME);
		$where = array('id'=>$pid,'drawcash_date'=>$drawcash_date);
		$product = M('Product')->where($where)->find();
			
		if($product){
			$this->error('当日已提现');
		}
			
		//获取提现卡信息
		$holder = M('ProductHolder')->where(array('pid'=>$pid,'uid'=>$uid))->find();
		if(!$holder){
			$this->error('提现卡信息不存在');
		}
			
		//获取银行卡信息
		$bank = M('BankInfo')->find($holder['bank_id']);
		if(!$bank){
			$this->error('银行卡信息不存在');
		}
			
		//计算提现金额
		$product = M('Product')->find($pid);
		if(!$product){
			$this->error('该项目信息不存在');
		}
		//计算可提金额
		$amount = $product['finish_amount'] - $product['drawcash_amount'];
			
		//如果余额不足
		if($amount <= 0 ){
			$this->error('可提金额不足');
		}
			
		$bankinfo= array(
				'pid'=>$pid,//银行代码,3位
				'bankId'=>$bank['bank_type'],//银行代码,3位
				'acctNo'=>$holder['card_number'],//银行卡或存折号码
				'acctName'=>$holder['true_name'],//银行卡或存折上的所有人姓名
				'bankName'=>$holder['sub_branch'],//开户行名称
				'bankProvince'=>$holder['bank_province'],//开户行所在省
				'bankCity'=>$holder['bank_city'],//开户行所在市
				'amount'=>sprintf("%01.2f",$amount)//金额
		);
			
		$notifyurl = 'http://'. $_SERVER['HTTP_HOST'] .U('Public/callback');

		$this->drawcash($bankinfo,$notifyurl);
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
	
	//提现操作
	public function drawcashlist(){

		$pid = $_GET['pid'];
		
		$where = array('pid'=>$pid);
		$drawcashlist = M('DrawcashList')->where($where)->find();

		// 分页
		$page = I('p');
		if (empty($page)) {
			$page = 1;
		}

		$list = M('DrawcashList')->page($page.',15')->where($where)->select();
		
		$count      = M('DrawcashList')->where($where)->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
		$show       = $Page->show();// 分页显示输出
		
		int_to_string($list,array('status'=>array(0=>'交易中',1=>'交易成功',2=>'交易失败')));
		
		int_to_string($list,array('state'=>array('00'=>'待结算','01'=>'结算中','02'=>'结算成功','03'=>'结算失败','04'=>'已撤销')));
		
		$this->assign('list',$list);
		$this->assign('page',$show);// 赋值分页输出
		$this->display();
		
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
			
		//D('AccountLog')->record($head, $xml, $mac, 0);

		$text = $this->getHttpResponseGet($this->config['DRAW_URL'], $para);
		$para = md5Response($text, $this->config['MERKEY']);
	
		if (!$para) {
			$this->ajaxReturn(array('status'=>0, 'info'=>'信息错误'));
			exit();
		}
			
		//D('AccountLog')->record($head, $para['data'], $para['mac'], 1);
	
		if($para['status'] =='000000000'){

			//修改提现金额
			$product = M('Product')->find($bankinfo['pid']);
			if(!$product){
				$this->error('该项目信息不存在');
			}
	
				
			//计算可提金额
			$amount = $product['finish_amount'] - $product['drawcash_amount'];
	
			//如果余额不足
			if($amount <= 0 ){
				$this->error('可提金额不足');
			}
				
			//当前时间
			$drawcash_date = date('Ymd',NOW_TIME);
	
			$drawcash_amount = $product['drawcash_amount'] + $bankinfo['amount'];
				
			$product = array('id'=>$bankinfo['pid'],'drawcash_date'=>$drawcash_date,'drawcash_amount'=>$drawcash_amount);
			M('Product')->save($product);
				
	
			//提现记录
			$drawcashlist = array(
					'pid' => $bankinfo['pid'],
					'bussflowno' => $tradFlowNo,
					'amount' => $bankinfo['amount'],
					'create_time'=>NOW_TIME,
					'update_time'=>NOW_TIME);
				
			M('DrawcashList')->add($drawcashlist);
				

			$this->success('提现成功，你注意账户变化');
		}else{
			$this->error($para['statusMsg']);
	
		}
	}
	
	
}