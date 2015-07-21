<?php
namespace Home\Controller;
use Think\Log;

class ProductOrderController extends HomeController{

	public function info($priceId,$reviseStatus=false){

		$uid = is_login();
		
		if (!$uid) {
			//$this->error('亲，您还没有登录噢！快点登录吧，等你噢〜'.showface('radio'), U('User/login'));
			$this->redirect('User/login');
		}
		
/* 		if ($reviseStatus) {
			if (!empty($_GET['cid'])) {
				$cid = $_GET['cid'];
			}else{
				$this->error('指定页面不存在');
			}
		} */
		//修改的ID
		$cid = $_GET['cid'];
		
		$modelProduct = M('Product');
		$modelProductPrice = M('ProductPrice');
		$resultProductPrice = $modelProductPrice->where(array('id'=>$priceId))->find();
		$modelCustomAddress = M('CustomAddress');
		$modelCustom = M('Custom');
		
		if (empty($cid)) {
			$aCustomRecord = null;
		}else{
			$aCustomRecord = $modelCustom->where(array('id'=>$cid))->find();
		}
		//是否有购买资格
		$this->buyRule($priceId);
		
		//是否有购买名额
		$this->buyPermissions($priceId);

		if (empty($priceId)) {
			$this->error('关键参数未获得');
		}
		if (IS_POST) {

			$data=$_POST;
			
			if ($data['count'] == 0) {
				$this->error('购买数量还没有填哦');
			}elseif ($data['count'] < 0) {
				$this->error('购买数量请输入大于0的数字');
			}elseif($data['count'] >$resultProductPrice['single_limit']){
				$this->error('购买数量大于单笔购买额，单笔最大购买量：'.$resultProductPrice['single_limit']);
			} elseif (!$data['address_id']) {
				$this->error('请先指定配送地址');
			}
			
			//判断是否需要验证码
			if($data['is_share'] == 3){
				$customid = $_POST['customid'];
				if(empty($customid) || $customid == ''){
					$this->error('参数不对！');
				}else{
					//根据分享ID获取分享的邀请码
					$shares = $modelCustom->find($customid);
					if(!$shares){
						$this->error('参数不对！');
					}
					//获取验证码
					$shareno = $shares['shareno'];

					//验证码有效性判断
					$shareinfo = $modelCustom->where(array('shareno'=>$shareno,'pid'=>$resultProductPrice['pid']))->find();
					if(!$shareinfo){
						$this->error('验证码无效');
					}else{
						//获取生成验证码的那条回报记录
						$sharelimit = $modelProductPrice->where(array('pid'=>$resultProductPrice['pid'],'is_share'=>2))->find();
					
						//是否还有剩余名额
						$share_num = $modelCustom->where(array('share_used'=>$shareno,'pid'=>$resultProductPrice['pid'],'status'=>1))->count();
					
						//超过限制购买额度
						if($share_num > $sharelimit['share_limit']){
							$this->error('验证码已使用');
						}
					}
				}
				
				
/* 				if($data['shareno'] == ''){
					$this->error('请输入验证码');
				}else{
					//验证码有效性判断
					$shareinfo = $modelCustom->where(array('shareno'=>$data['shareno'],'pid'=>$resultProductPrice['pid']))->find();
					
					if(!$shareinfo){
						$this->error('验证码无效');
					}else{
						//获取生成验证码的那条回报记录
						$sharelimit = $modelProductPrice->where(array('pid'=>$resultProductPrice['pid'],'is_share'=>2))->find();
						
						//是否还有剩余名额
						$share_num = $modelCustom->where(array('share_used'=>$data['shareno'],'pid'=>$resultProductPrice['pid'],'status'=>1))->count();
						
						//超过限制购买额度
						if($share_num > $sharelimit['share_limit']){
							$this->error('验证码已使用');
						}
						
					}
				} */
			}

			$saveData['pid'] = $resultProductPrice['pid'];
			$saveData['price_id'] = $priceId;
			$saveData['uid'] = $saveData['create_id'] = $saveData['update_id'] = $uid;
			$saveData['count'] = $data['count'];
			$saveData['address_id'] = $data['address_id'];
			$saveData['status'] = 0;
			$saveData['remarks'] = $data['remarks'];
			$saveData['share_used'] = $data['shareno'];
			$saveData['post_amount'] = $resultProductPrice['post_amount'];
			$saveData['create_time'] = $saveData['update_time'] = time();
			$saveData['amount'] = $resultProductPrice['amount'] * $saveData['count'];

			
			if (empty($cid)) {
				$saveData['id'] = 'PT'.sprintf("%06d",$uid).time();
				
				// 如果主键是自动增长型 成功后返回值就是最新插入的值(当前不是)
				$resultCustom = $modelCustom->data($saveData)->add();
				$myNewestCustom = $modelCustom->where(array('uid'=>$uid))->order('create_time desc')->limit(1)->find();
				$resultCustom = $myNewestCustom['id'];
			}else{
				$resultCustom = $modelCustom->where(array('id'=>$cid))->save($saveData);
				$resultCustom = $cid;
			}
			
			if ($resultCustom == false) {
				$this->error('订单信息保存失败');
			}else{
				//增加实物待办事项
				update_pr_dolist($uid,0);
				
				//如果mobile web 直接跳转到 支付。。。
				if (ismobile()) {
					$this->pay($resultCustom);
				}else{
					$this->success('处理成功！',U('confirm', array('customId'=>$resultCustom,'PriceId'=>$priceId)));
				}
			}

		}else{
			//判断是否需要验证码
			if($resultProductPrice['is_share'] == 3){
				$customid = I('customid');
				if(empty($customid) || $customid == ''){
					$this->error('参数不对！');
				}else{
					//根据分享ID获取分享的邀请码
					$shares = $modelCustom->find($customid);
					if(!$shares){
						$this->error('参数不对！');
					}
					//获取验证码
					$shareno = $shares['shareno'];
			
					//验证码有效性判断
					$shareinfo = $modelCustom->where(array('shareno'=>$shareno,'pid'=>$resultProductPrice['pid']))->select();
					if(!$shareinfo){
						$this->error('验证码无效');
					}else{
						//获取生成验证码的那条回报记录
						$sharelimit = $modelProductPrice->where(array('pid'=>$resultProductPrice['pid'],'is_share'=>2))->find();
							
						//是否还有剩余名额
						$share_num = $modelCustom->where(array('share_used'=>$shareno,'pid'=>$resultProductPrice['pid'],'status'=>1))->count();
							
						//超过限制购买额度
						if($share_num > $sharelimit['share_limit']){
							$this->error('验证码已使用');
						}
					}
				}
			}
			

			if (!empty($resultProductPrice)) {
				$resultProduct = $modelProduct->where(array('id'=>$resultProductPrice['pid']))->find();
			}
			$resultAddress = $modelCustomAddress->where(array('uid'=>$uid,'status'=>array('gt',-1)))->select();
			$defaultAddressId = null;
			foreach ($resultAddress as $key => $value) {
				if ($value['status']==1) {
					$value['flag']='default'; 
					$newResultAddress['default'] = $value;
					$defaultAddressId = $value['id'];
				}else{
					if ($value['id'] != $defaultAddressId) {
						$newResultAddress[] =$value;
					}
				}
			}
			$this->assign('pageTitle','订单详情');
			$this->assign('aCustomRecord',$aCustomRecord);
			$this->assign('productPriceList',$resultProductPrice);
			$this->assign('productList',$resultProduct);
			$this->assign('addressList',$newResultAddress);
			$this->assign('navFlage','step1');
			$this->assign('customid',$customid);
            $this->assign('priceId',$priceId);
			if (ismobile()) {
				$this->display('info');
			}else{
				$this->display('info');
			}
		}
	}

	public function addressList($pid){
		$uid = is_login();
		
		if (!$uid) {
			$this->error('亲，您还没有登录噢！快点登录吧，等你噢〜'.showface('radio'), U('User/login'));
		}
		
		if(IS_POST){
			
			
		}else{
			//获取所有地址信息
			$resultAddress = M('CustomAddress')->where(array('uid'=>$uid,'status'=>array('gt',-1)))->order('status desc,update_time desc')->select();

			$this->assign('pageTitle','修改地址');
			$this->assign('pid',$pid);
			$this->addresslist=$resultAddress;
			$this->display('addresslist');
		}
		
	}
	
	/*修改配送地址*/
	public function modify_addr() {
		$uid = is_login();
		if (IS_GET) {
			$id = $_GET['id'];
			$this->pid = $_GET['pid'];
			if ($id) {
				$detail = M('CustomAddress')->where(array('id'=>$id, 'uid'=>$uid))->find();
	
				$this->assign('detail', $detail);
			}
			$this->assign('pageTitle','添加新地址');
			$this->display('address');
		} else if (IS_POST) {
			$detail = $_POST;
			$model = M('CustomAddress');
			if (empty($_POST['id'])) {
				$detail['status'] = 0;
				$detail['uid'] = $uid;
				$detail['create_id'] = $uid;
				$detail['create_time'] = NOW_TIME;
				$detail['update_id'] = $uid;
				$detail['update_time'] = NOW_TIME;
				M('CustomAddress')->add($detail);
				$this->success('新地址添加成功。',U('ProductOrder/addressList?pid='. $_POST['pid']));
			} else {
				$data = $model->find($detail['id']);
				$detail['update_time'] = NOW_TIME;
				if (!$data || $data['uid'] != $uid) {
					$this->error('非法操作。。');
				}
				M('CustomAddress')->save($detail);
				$this->success('地址更新成功。',U('ProductOrder/addressList?pid=' . $_POST['pid']));
			}
		}
	}
	
	public function changeAddress($reviseStatus=false)
	{
		// var_dump('expression');exit();
		$this->login();
		$uid = is_login();
		$modelCustomAddress = M('CustomAddress');

		if (IS_POST) {
			$requestData = $_POST;
			$requestData['uid']=$uid;
			$requestData['phone']=$requestData['mobile'];
			$requestData['create_time']=$requestData['update_time']=time();
			$requestData['create_id']=$requestData['update_id']=$uid;
			$result = $modelCustomAddress->add($requestData);
			if ($result == false) {
				$this->error('保存失败，请联系管理员:service@dreammove.cn');
			}else{
				$this->success($result);
			}
		}else{
			$this->error('请求方式不正确');
		}
	}

	public function deleteAddress($addId){
		if (empty($addId)) {
			$this->error('关键参数未获得');
		}
		$modelCustomAddress = M('CustomAddress');
		//$result = $modelCustomAddress->where(array('id'=>$addId))->delete();
		
		$result = $modelCustomAddress->where(array('id'=>$addId))->save(array('status'=>-1));
		if ($result ==false) {
			$this->error('处理失败，请联系管理员:service@dreammove.cn');
		}else{
			$this->success('删除成功');
		}
	}

	public function revocation($customId){
		if (empty($customId)) {
			$this->error('关键参数未获得');
		}

		if (IS_POST) {
			$modelCustom = M('Custom');
			$isCustom = $modelCustom->where(array('id'=>$customId))->find();
			if (empty($isCustom)) {
				$this->error('订单不存在');
			}
			$resultCustom = $modelCustom->where(array('id'=>$customId))->save(array('status'=>-1));
			if ($resultCustom) {
				//更新待办事件
				update_pr_dolist($isCustom['uid'],-1);
				$this->success('撤销成功');
			}else{
				$this->error('撤销失败');
			}
		}
	}

	public function setDefaultAddress($addId,$pid){
		if (empty($addId)) {
			$this->error('关键参数未获得');
		}
		$uid = is_login();
		$modelCustomAddress = M('CustomAddress');

		$modelCustomAddress->where(array('uid'=>$uid,'status'=>array('gt',-1)))->save(array('status'=>0));
		$result = $modelCustomAddress->where(array('id'=>$addId))->save(array('status'=>1));
		
		if ($result ==false) {
			$this->error('处理失败，请联系管理员:service@dreammove.cn');
		}else{
			$this->success('设置成功',U('productOrder/info',array('priceId'=>$pid, 'load'=>1)));
		}
	}

	public function confirm($customId,$PriceId){
		$this->login();
		$modelProduct = M('Product');
		$modelCustom = M('Custom');
		$modelProductPrice = M('ProductPrice');
		$modelCustomAddress = M('CustomAddress');
		if (empty($customId)) {
			$this->error('关键参数未获得');
		}		
			$recordCustom = $modelCustom->where(array('id'=>$customId))->find();
			//是否有购买名额
			$this->buyPermissions($recordCustom['price_id']);

			if (empty($recordCustom)) {
				$this->error("当前订单不存在");
				exit();
			}
			if ($recordCustom['status'] == 1) {
				$this->error('啊哦，这个订单您已经付钱了');
			}elseif ($recordCustom['status'] == -1) {
				$this->error('当前订单被撤销');
			}elseif ($recordCustom['status'] == -2) {
				$this->error('当前订单没有名额');
			}
			
			if (ismobile()) {
				$this->redirect('pay', array('customId'=>$customId));
			}

			$recordProductPrice = $modelProductPrice->where(array('id'=>$recordCustom['price_id']))->find();
			$recordProduct = $modelProduct->where(array('id'=>$recordProductPrice['pid']))->find();
			$recordCustomAddress = $modelCustomAddress->where(array('id'=>$recordCustom['address_id']))->find();

			$address = M('CustomAddress')->where(array('id'=>$recordCustom['address_id']))->find();

			$this->assign('address', $address);
			$this->assign('recordCustom',$recordCustom);
			$this->assign('recordCustomAddress',$recordCustomAddress);
			$this->assign('recordProductPrice',$recordProductPrice);
			$this->assign('recordProduct',$recordProduct);
			$this->assign('navFlage','step2');
            $this->assign('PriceId',$PriceId);
			$this->display();
	}


	public function pay($customId){
		//判断是否登录
		$this->login();
		$uid = is_login();
		if (empty($customId)) {
			$this->error("关键参数未获得");
		}
		$modelCustom = M('Custom');
		$modelProductPrice = M('ProductPrice');
		$modelProductPay = M('ProductPay');


		//根据订单ID获取订单信息
		$recordCustom = $modelCustom->where(array('id' =>$customId))->find();

		//根据回报ID获取回报信息
		$recordProductPrice = $modelProductPrice->where(array('id' =>$recordCustom['price_id']))->find();


		$shareid = $recordCustom['id'];
		//confirm custom status
		if ($recordCustom['status'] <> 0) {
			$this->error('订单已支付或已撤销,请勿重复提交');
		}
		
		//如果支付金额=0，邮费=0
		if ($recordCustom['amount'] == 0 && $recordCustom['post_amount'] == 0) {
			

			if($recordCustom['status']==1){
				$this->success('支付成功！',U('MCenter/pr_support'));
			}

			// 购买数 +1
			$currentSellCount = $recordProductPrice['sell_count'] + 1;
			//更新购买数量
			$resultPricesave = $modelProductPrice->where(array('id' =>$recordCustom['price_id']))->save(array('sell_count'=>$currentSellCount));
			// status  购买成功
			$dataCustomSave['status']=1;
			if($recordProductPrice['is_luck']=='1'){
			
				$dataCustomSave['luckno']=$this->NoRand($recordProductPrice['pid']);
			}
			//生成验证码的场合
			if($recordProductPrice['is_share']=='2'){
				//生成分享码
				$shareid = $this->shareNo($recordProductPrice['pid']);
				$dataCustomSave['shareno'] = $shareid;
				
				//生成二维码
				$dataCustomSave['qrcode'] = $this->qrcode($recordProductPrice['pid'], $shareid,$customId);
			}
			
			//生成分享ID
			//$dataCustomSave['shareid'] = sprintf("%06d",$uid).time();
			//更新订单状态
			$resultCustomSave = $modelCustom->where(array('id'=>$recordCustom['id']))->save($dataCustomSave);
			
           			//获取实物基本表
//			$recordProduct = $modelProduct->where(array('id' =>$recordProductPrice['pid']))->find();
//			//已筹金额
//			$finishamount = $recordProduct['finish_amount'] + $recordCustom['amount'];
//
//			$resultProductSave = $modelProduct->where(array('id'=>$recordProduct['id']))->save(array('finish_amount'=>$finishamount));
//
			
			if ($resultPricesave == false || $resultCustomSave == false) {
				$this->error("订单处理出错，请联系管理员：service@dreammove.cn",U('Index/index'));
			}
			
			//更新待办事件
			update_pr_dolist($recordCustom['uid'],1);
		
			//处理成功跳转
			$this->success('处理成功',U('ProductOrder/share',array('id'=>$recordCustom['id'])));
		}

		//根据订单号，查询支付流水信息
		$data = $modelProductPay->where(array('orderid' => $customId))->find();

		//zhaobb2015.3.25
		//$modelProductPrice->startTrans();
		if (!$data) {
			//是否有购买名额
			$this->buyPermissions($recordCustom['price_id']);

/* 			$resultPaySave = $modelProductPrice->where(array('id'=>$recordCustom['price_id']))
				->setInc('sell_count', $recordCustom['count']);

			if ($resultPaySave == false) {
				$modelProductPrice->rollback();
				$this->error('处理错误，请联系管理员:service@dreammove.cn');
			} */

		}

		// 存流水 product_pay
		// 状态： 0→未付款(默认值)； 1→成功相符； 2→成功不符； 3→失败；
		$payData['orderid'] = $recordCustom['id'];
		$payData['merorderid'] = buildMerorderid();
		$payData['amountsum'] = $recordCustom['amount'] + $recordCustom['post_amount'];
		$payData['paytype'] = $_POST['paytype'];
		$payData['allow_creditcard'] = 1;
		$payData['state'] = 0;
		$payData['create_time'] = $payData['update_time'] = time();
		$payData['uid'] = $uid;
		$payData['pay_amount'] = $recordCustom['amount'] + $recordCustom['post_amount'];
		
		
		$resultPaySave = $modelProductPay->data($payData)->add();
		
		if ($resultPaySave == false) {
			//zhaobb2015.3.25
			//$modelProductPrice->rollback();
			$this->error('处理错误，请联系管理员:service@dreammove.cn');
		}
		
		//zhaobb2015.3.25
		//$modelProductPrice->commit();
		
		$this->success('处理成功！', U('Pay/index',array('merorderid'=>$payData['merorderid'],'customId'=>$customId)));
	}
	
	public function share(){
		
		$id = $_GET['id'];
		$custominfo = M('Custom')->find($id);
		$poduct = M('Product')->find($custominfo['pid']);

		//零元购买者
		$message1 ='恭喜你已经获得了这次“0元购”的特大福利，此外，您还有一项特邀特权——点击右上角的社交媒体按钮，分享你的邀请码，你的亲朋好友就能以成本价购得相同的生鲜套餐，机会只有一个，考验友谊的时候到了！';
		//成本价购买者
		$message2 ='如果你还不是聚募的投资人，却看到了这段话，那就说明在这世界上有一个人最在意你、最惦记你、最挂念你。邀请码只能使用一次，快来享受这次成本价购买源本生活生鲜套餐的福利吧~';
		
		$this->message1=$message1;
		$this->message2=$message2;
		$this->jumpUrl='';
		$this->pageTitle='源本生活邀您一起来尝鲜【邀请码:'.$custominfo['shareno'].'】';
		
		$this->shareno = $custominfo['shareno'];
		$this->qrcode = $custominfo['qrcode'];
		$this->barcode = $poduct['barcode'];
		$this->pid = $custominfo['pid'];
		$this->display();
	}
	
	
	
	public function normalpay() {
		$pay = M('ProductPay')->where(array('merorderid'=>$_GET['merorderid']))->find();
	
		if (!$pay) {
			$this->error('支付订单号不存在。');
		}
	
		$detailURL = 'http://'.$_SERVER['HTTP_HOST'].U('Product/viewDetail', array('pid'=>$_GET['pid']));
		$payResults = A('BaoyiPayApi')->send($pay['amountsum'],
				$_GET['merorderid'],$detailURL,'无', $_GET['bankname']);
	
		$message= '<script>window.location.href = "'. $payResults . '";</script>';
	
		$this->message = $message;
		$this->display('Account/loading');
	}
	
	public function payError(){

		$this->display('nocount');
	}

	public  function paymentSucc(){
		$this->assign('navFlage','step4');
		if(ismobile()){
			$this->display('mobile-paymentSucc');
		}else{
			$this->display('paymentSucc');
		}
		
	}
	
	// 判断是否有购买权限
	private function buyRule($priceId){
		if (empty($priceId)) {
			$this->error('关键参数未获得');
		}
		
		//获取当前用户ID
		$uid= is_login();
		$modelProductPrice = M('ProductPrice');
		//用户明细
		$modeluserinfo = M('UsersDetail');
		//股权项目投资
		$modelproject = M('ProjectInvestor');
		//实物项目投资
		$modelcustom = M('Custom');
		
		//获取回报信息
		$recordProductPrice = $modelProductPrice->where(array('id' =>$priceId))->find();
		//零元购 或者需要验证码购买的时候，每个人只能购买一次
		if($recordProductPrice['amount']==0 || $recordProductPrice['is_share']==3){
			//获取回报信息（,'price_id' =>$priceId 只能购买一个回报）
			$hasbuy = $modelcustom->where(array('uid' =>$uid,'status'=>1,'pid'=>$recordProductPrice['pid']))->find();
			if($hasbuy){
				$this->error('您已购买，本商品限购一件，感谢您的参与。');
			}
		}

		//城市
		if($recordProductPrice['city'] >0){
			$city = $modeluserinfo->where(array('id'=>$uid,'city' =>$recordProductPrice['city']))->find();
		
			//数据不存在
			if(!$city){
				$this->error('你好，我是源本生活的有机食材，由于我的保鲜期较短，只能通过冷链物流配送，所以只能被送到杭州地区的聚募小伙伴那里。我也好想到来到你身边噢，期待下次吧。。。。', U('Index/index'));
			}
		}else{
			
			if($recordProductPrice['province'] >0){
				$province = $modeluserinfo->where(array('id'=>$uid,'province' =>$recordProductPrice['province']))->find();
					
				//数据不存在
				if(!$province){
					$this->error('你好，我是源本生活的有机食材，由于我的保鲜期较短，只能通过冷链物流配送，所以只能被送到杭州地区的聚募小伙伴那里。我也好想到来到你身边噢，期待下次吧。。。。', U('Index/index'));
				}
			}
		}
		
		//股权项目投资金额
		//$projectfund = $modelproject->where(array('uid' =>$uid,'status'=>9))->sum('fund');
		//$projectfund = D('ProjectInvestorView')->where(array('investor_id'=>$uid))->select();
		$projectfund = D('ProjectInvestorView')->where(array('investor_id'=>$uid,'stage'=>9,'status'=>9))->sum('investor.fund');
		//$projectfund = D('ProjectInvestorView')->where(array('investor_id'=>$uid,'stage'=>9,'status'=>9))->select();
		//实物项目投资金额
		//$productfund = $modelcustom->where(array('uid' =>$uid,'status'=>1))->sum('amount');
		$productfund = D('ProductPriceView')->where(array('uid' =>$uid,'stage'=>9,'status'=>1))->sum('pp.amount');
		
		
		//股权项目
		if($recordProductPrice['invest_type'] ==1){
			$amount =$projectfund;
		}elseif ($recordProductPrice['invest_type'] ==2){
			$amount =$productfund;
		}else{
			$amount = $projectfund + $productfund;
		}
		
		//1000以上
		if($recordProductPrice['invest_select'] == 1){
			if($amount<1000){
				$this->error('你好，我是源本生活的有机食材，由于我的保鲜期较短，只能通过冷链物流配送，所以只能被送到杭州地区的聚募小伙伴那里。我也好想到来到你身边噢，期待下次吧。。。。', U('Index/index'));
			}
		}elseif($recordProductPrice['invest_select'] == 2){
			if($amount<5000){
				$this->error('你好，我是源本生活的有机食材，由于我的保鲜期较短，只能通过冷链物流配送，所以只能被送到杭州地区的聚募小伙伴那里。我也好想到来到你身边噢，期待下次吧。。。。', U('Index/index'));
			}
		}elseif($recordProductPrice['invest_select'] == 3){
			if($amount<10000){
				$this->error('你好，我是源本生活的有机食材，由于我的保鲜期较短，只能通过冷链物流配送，所以只能被送到杭州地区的聚募小伙伴那里。我也好想到来到你身边噢，期待下次吧。。。。', U('Index/index'));
			}
		}else{
			if($recordProductPrice['invest_type']>0){
				if($amount<1){
					$this->error('你好，我是源本生活的有机食材，由于我的保鲜期较短，只能通过冷链物流配送，所以只能被送到杭州地区的聚募小伙伴那里。我也好想到来到你身边噢，期待下次吧。。。。', U('Index/index'));
				}
			}
		}
		if ($recordProductPrice['amount'] == 0) {
			if (isMobile() && !$_GET['load']) {
				$this->url = U('productOrder/info', array('priceId'=>$priceId, 'load'=>1));
				$this->display('yanzhi');
				exit();
			}
		}
	}


	// 众筹购买权限判定ProductPrice里是否还有购买数量
	private function buyPermissions($priceId){
		if (empty($priceId)) {
			$this->error('关键参数未获得');
		}
		$modelProductPrice = M('ProductPrice');
		//回去回报信息
		$recordProductPrice = $modelProductPrice->where(array('id' =>$priceId))->find();

		//有回报数量限制的场合
		if($recordProductPrice['count'] >0){
			//已售数量>可买数量时
			if ($recordProductPrice['sell_count']>=$recordProductPrice['count']) {
				// M('Custom')->where(array('id' =>$customId))->save(array('status'=>-2));
				if (IS_AJAX) {
					$this->error('该挡名额已经卖完，请选择其他金额购买。',U('ProductOrder/payError'));
				} else {
					$this->redirect('ProductOrder/payError');	
				}
			}
		}

		//回去项目信息
		$product = M('Product')->where(array('id'=>$recordProductPrice['pid']))->find();
		//有众筹资金上限的场合
		if ($product['top_amount'] > 0) {
			//计算上限金额
			$amount = ($product['amount'] * $product['top_amount'] / 100);
			//如果金额超出
			if ($amount < ($product['finish_amount'] + $recordProductPrice['amount'])) {
				if (IS_AJAX) {
					$this->error('购买成功后，将超出发起人设置的众筹上限。请选择低档购买。',U('ProductOrder/payError'));
				} else {
					$this->redirect('ProductOrder/payError');	
				}
			}
		}
	}
	
	function payresult($recordProductPay,$flag){

		//处理商户端信息开始
		$modelCustom = M('Custom');
		$modelProductPrice = M('ProductPrice');
		$modelProduct = M('Product');

		//获取订单数据
		$recordCustom = $modelCustom->where(array('id' =>$recordProductPay['orderid']))->find();
		
		if($recordCustom['status']==1){
			$this->success('支付成功！',U('MCenter/pr_support'));
			return ;
			//订单已支付
			//$this->error("订单已支付",U('Index/index'));
		}

		//获取回报数据
		$recordProductPrice = $modelProductPrice->where(array('id' =>$recordCustom['price_id']))->find();
		//获取实物基本表
		$recordProduct = $modelProduct->where(array('id' =>$recordProductPrice['pid']))->find();
		 
		$currentSellCount = $recordProductPrice['sell_count'] + 1;
		// 购买数 +1
		$resultPricesave = $modelProductPrice->where(array('id' =>$recordCustom['price_id']))->save(array('sell_count'=>$currentSellCount));
		// status  购买成功
		$dataCustomSave['status']=1;
		if($recordProductPrice['is_luck']=='1'){
				
			$dataCustomSave['luckno']=$this->NoRand($recordProductPrice['pid']);
		}
		
		//生成验证码的场合
		if($recordProductPrice['is_share']=='2'){
		
			$dataCustomSave['shareno'] = $this->shareNo($recordProductPrice['pid']);
		}
		$resultCustomSave = $modelCustom->where(array('id'=>$recordCustom['id']))->save($dataCustomSave);
		//已筹金额
		$finishamount = $recordProduct['finish_amount'] + $recordCustom['amount'];

		$resultProductSave = $modelProduct->where(array('id'=>$recordProduct['id']))->save(array('finish_amount'=>$finishamount));
	
		if ($resultPricesave == false or $resultCustomSave == false or $resultProductSave == false) {
			$this->error("订单处理出错，请联系管理员：service@dreammove.cn",U('Index/index'));
		}
		
		//更新待办事件
		update_pr_dolist($recordCustom['uid'],1);
		
		//处理成功跳转
		$this->success('支付成功！',U('MCenter/pr_support'));
		
	}
	
	function NoRand($pid){
		while(1==1){
			$value = rand(1,999);//产生随机数
				
			//获取回报数据
			$recordProductPrice = M('Custom')->where(array('pid' =>$pid,'luckno'=>$value))->find();
			if($recordProductPrice){
				continue;
			}else{
				$luckno = $value;
				break;
			}
		}
	
		return $luckno;
	}
	function shareNo($pid){
		while(1==1){
			$value = rand(100000,999999);//产生随机数
	
			//获取回报数据
			$recordProductPrice = M('Custom')->where(array('pid' =>$pid,'luckno'=>$value))->find();
			if($recordProductPrice){
				continue;
			}else{
				$luckno = $value;
				break;
			}
		}
	
		return $luckno;
	}

	function qrcode($pid, $shareid,$customId){
		//引入工具包
		vendor("phpqrcode.phpqrcode");
		//图片输出路径
		$path = '/Uploads/Product/Qrcode/';
		
		if (!file_exists($path)){
    		mkdir($path);
    	}
    	
    	//获取使用二维码的回报ID
    	$proprice = M('ProductPrice')->where(array('pid'=>$pid,'is_share'=>3))->find();
    	
    	//添加链接地址
    	//$data = 'http://'.$_SERVER['HTTP_HOST'].U('ProductOrder/Info',array('priceId'=>$proprice['id'],'shareid'=>$shareid));
		
    	$data = 'http://'.$_SERVER['HTTP_HOST'].U('Product/viewDetail',array('pid'=>$pid,'customid'=>$customId));
    	// 纠错级别：L、M、Q、H
    	$level = 'L';
    	// 点的大小：1到10,用于手机端4就可以了
    	$size = 4;
    	// 生成的文件名
    	$fileName = $path.'share'.md5($pid.$shareid).'.png';
    	$QRcode = new \QRcode();
    	$QRcode::png($data, '.'. $fileName, $level, $size);
	
		return $fileName;
	}
	
	
}