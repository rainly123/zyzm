<?php 
namespace Home\Controller;
class ManageController extends HomeController {
	public $uid = "";

	public function index() {

	}

	function __construct(){
		parent::__construct();
		$this->uid = is_login();
		if (!$this->uid) {
			$this->redirect('User/login');
		}
	}

	public function investlist() {
		$uid = is_login();

		$invest = D('InvestorView')->where(
			array('investor.investor_id' => $uid, 'investor.status'=>array('egt','0')))->order('investor.create_time desc')->select();
		$this->invest = $invest;
		$this->version = 1;
		$this->display('investlist');
	}
	
	public function fundeddetail(){
		$this->display('fundeddetail');
	}
	public function editfundeddetail(){
		$this->display('editfundeddetail');
	}
	// 询价项目
	public function investinquiry() {
		$uid = is_login();

		$invest = D('InvestorView')->where(array('investor.investor_id' => $uid, 
			'investor.lead_type' => 1, 'investor.status'=>array('egt','0')))->
			order('investor.create_time desc')->select();
		$this->invest = $invest;
		$this->display('investinquiry');
	}

	// 领投项目
	public function investlead() {
		$uid = is_login();

		$invest = D('InvestorView')->where(array('investor.investor_id' => $uid, 
			'investor.lead_type' => array('in', '2,9'), 'investor.status'=>array('gt','0')))->
			order('investor.create_time desc')->select();

		$this->invest = $invest;
		$this->display('investlead');
	}

	// 领投项目
	public function investfollow() {
		$uid = is_login();

		$invest = D('InvestorView')->where(array('investor.investor_id' => $uid, 
			'investor.lead_type' => 3, 'investor.status'=>array('egt','0')))->
			order('investor.create_time desc')->select();

		$this->invest = $invest;
		$this->display('investfollow');
	}

	public function cancel() {
		if (IS_AJAX) {
			$id = $_GET['id'];
			if ($id) {
				$ivest = M('ProjectInvestor')->field('fund,investor_id, project_id, status, lead_type')->find($id);

				if ($ivest['investor_id'] != is_login()) {$this->error('非法操作。');}

				$proj = M('Project')->where(array('id'=>$ivest['project_id']))->
					field('project_name, uid, stage')->find();

				if ($ivest['status'] >= 2 && $proj['stage'] < 8) {
					M('ProjectFund')->where('project_id='.$ivest['project_id'])->
						setDec('has_fund', $ivest['fund']);
						if ($ivest['status'] >= 3) {
							M('ProjectFund')->where('project_id='.$ivest['project_id'])->
								setDec('agree_fund', $ivest['fund']);
						}
						if ($ivest['status'] == 4) {
							$data = M('AccountInvest')->where(array('iid'=>$id))->find();
							if ($data) {
								M('AccountUser')->where(array('uid'=>$data['uid']))
									->setInc('use_able',$data['amount']);
								M('AccountInvest')->where(array('iid'=>$id))->delete();
							}
						}
						M('AgreementInvest')->where(
							array('pid'=>$ivest['project_id'], 'uid'=>$ivest['investor_id']))->delete();
				}
				// 删除领投记录
				M('ProjLeader')->where(array('pid'=>$ivest['project_id'], 
					'uid'=>$ivest['investor_id'], 'del_flag'=>0))->save(array('del_flag'=>-1));

				$data = array('status'=> -1, 'id' => $id, 
					'update_time'=>NOW_TIME, 'update_id'=> is_login());
				M('ProjectInvestor')->save($data);
			
			// 发送系统消息(通知项目方有人询价)
			$ulink = '<a href="'.U('MCenter/profile?id='.$ivest['investor_id']).
				'">'.get_membername($ivest['investor_id']) .'</a>';
			$plink = '<a href="'.U('Manage/investinquiry').'">《'.$proj['project_name'].'》</a>';
			$content = $ulink .'撤消了对您'.$plink . "项目的认投";

			D('Message')->send(0,$proj['uid'],'', $content, 3);

			
			//更新待办事件
			update_pj_dolist($ivest['investor_id'],-1);
				$this->success('您撤消了对' .$proj['project_name'].'项目的投资');
			}
		} else {
		}
	}

	// 我的项目
	public function foundlist() {
		
		$id = is_login();
		// 我的项目
		$project = M('Project')->where(array('uid'=>$id))->order('create_time desc')->select();

		int_to_string($project,
			array('status'=>array(0=>'保存',1=>'审核中',2=>'审核未通过',9=>'已审核')));

		$this->projects = $project;
		$this->display();
	}
	
	//订单详细
	public function orderinfo($id){
		//获取订单信息
		$customer = M('Custom')->find($id);
		//获取订单地址信息
		$customeraddress = M('CustomAddress')->find($customer['address_id']);
		//获取项目信息
		$product = M('Product')->find($customer['pid']);
		//回报内容
		$recordProductPrice = M('ProductPrice')->where(array('id'=>$customer['price_id']))->find();
		
		$this->assign('customer',$customer);
		$this->assign('customeraddress',$customeraddress);
		$this->assign('product',$product);
		$this->assign('productprice',$recordProductPrice);
		
		$this->display();
	}

	// 询价信息
	public function foundinquiry() {
		
		$uid = is_login();

		$projects = D('InvestorView')->where(array('p.uid' => $uid, 
			'investor.lead_type' => 1, 'investor.status'=>array('egt','0')))->
			order('investor.create_time desc')->select();

		$this->projects = $projects;
		$this->display('foundinquiry');
	}

	// 领投信息
	public function foundlead() {
		
		$uid = is_login();

		$projects = D('InvestorView')->where(array('p.uid' => $uid, 
			'investor.lead_type' => array('in', '2,9'), 'investor.status'=>array('gt','0')))->
			order('investor.create_time desc')->select();

		$this->projects = $projects;
		$this->display('foundlead');
	}

	// 跟投信息
	public function foundfollow() {
		
		$uid = is_login();

		$projects = D('InvestorView')->where(array('p.uid' => $uid, 
			'investor.lead_type' => 3, 'investor.status'=>array('egt','0')))->
			order('investor.create_time desc')->select();

		$this->projects = $projects;
		$this->display('foundfollow');
	}

	// 投资人状态修改
	public function investstatus() {
		if(IS_AJAX) {
			$status = $_GET['status'];
			$id = $_GET['id'];
			$data = array('id' => $id,
				'status' => $status,
				'refuse_reason' => $_GET['refuse'],
				'update_time' => NOW_TIME,
				'update_id' => is_login());

			M('ProjectInvestor')->save($data);

			$investor = M('ProjectInvestor')->where(array('id'=>$id))->
				field('investor_id, project_id, fund')->find();
			$proj = M('Project')->where('id='.$investor['project_id'])->
				getfield('project_name');
			
			// 发送系统消息(通知项目方有人询价)
			$plink = '<a href="'.U('Manage/investinquiry').'">《'.$proj.'》</a>';
			if($status == 0) {
				$content = $plink . "项目方拒绝了您的询价<br>拒绝理由：".$_GET['refuse'];
			} else {
				M('ProjectFund')->where('project_id='.$investor['project_id'])->
					setInc('has_fund',$investor['fund']);
				$content = $plink . "项目方接受了您的询价";

				$leader = M('ProjectLeader')->where(array('project_id'=>$investor['project_id'], 
					'leader_id'=>$investor['investor_id']))->find();
				if ($leader && $leader['lead_type'] == 0) {
					M('ProjectLeader')->save(array('id'=>$leader['id'], 'lead_type'=>1));
				}
			}

			D('Message')->send(0,$investor['investor_id'],'', $content, 3);

			$this->success('操作成功');
		} else {
			$this->redirect('Index/index');
		}
	}

	// 统计认投
	public function statistical() {

		$uid = is_login();

		$projectid = I('id');
		
		//项目融资信息
		$project_fund = D('ProjectFundView')->where("p.id = ". $projectid)->find();
		
		//认投明细
		$project_investor = D('ProjectInvestorView')->where(array('p.id' => $projectid, 'investor.status'=>array('egt' ,2)))->order('investor.status desc, investor.create_time')->select();

		int_to_string($project_investor,
		array('lead_type'=>array(1=>'投资人',2=>'投资人',3=>'跟投人',9=>'领投人'),
			'status'=>array(0=>'拒绝',1=>'未认可',2=>'认可',3=>'接受',4=>'已确认投资', 8=>'协议已确认', 9=>'已支付')));

		$project_fund['pay_fund'] = 0;
		foreach ($project_investor as $k => $v) {
			if ($v['status'] == 9) {
				$project_fund['pay_fund'] += $v['fund'];
			}
		}
		$this->fund = $project_fund;
		$this->investor = $project_investor;

		$this->display();
	}

	public function ajaxGetInvestor($id){
		$investor = M('ProjectInvestor')->where(array('id'=>$id))->find();
		if (empty($investor)) {
			throw new Exception("无法获取项目信息", 1);
		}
		$this->assign($investor);

		$this->display();
	}

	// 接受认投
	public function agree() {
		if (IS_AJAX) {
			$map = array('id'=>$_GET['id'], 'status' => 2);

			$ret = $this->checkagree($map);

			if ($ret == -1) {
				$this->error('您接受的金额已经达到或超出了融资额，不能再接受认投了。');
			} else if ($_GET['over'] != 1 && $ret == 0) {
				$this->ajaxReturn(array('info'=>'如果您接受了该笔认投，实际总融资额将超出您设定的目标融资额。<br>请确定要接受吗？', 'status' =>'9'));
				exit();
			}
			M('ProjectInvestor')->where($map)->save(array('status'=>3));
			M('ProjectFund')->where('project_id='.$_GET['pid'])->setInc('agree_fund', $ret);

			$this->success('处理成功。');
		}
	}

	// 取消接受
	public function agreecancel() {
		if (IS_AJAX) {
			$map = array('id'=>$_GET['id'], 'status' => 3);

			$data = M('ProjectInvestor')->where($map)->find();
			if (!$data) {
				$this->error('处理对象不存在。');
			} else {
				M('ProjectInvestor')->where($map)->save(array('status'=>2));
				M('ProjectFund')->where('project_id='.$data['project_id'])->setDec('agree_fund', $data['fund']);	
			}

			$this->success('处理成功。');
		}
	}

	public function prepay() {
		$uid = is_login();

		$id = I('id');
		if (!$id) {$this->error('操作不正确。',U('Manage/investlist'));}
		$account = M('AccountUser')->where(array('uid'=>$uid, 'status'=>1))->find();
		;
		if (!$account) {
			$this->error('您还没有开户，开户并充值后，才可授权。', U('Account/createaccount'));
		} else {
			$data['use_able'] = $account['use_able'];
		}
		$invest = M('ProjectInvestor')->where(
			array('id' => $id, 'investor_id'=>$uid, 'status'=>3))->find();
		
		if (!$invest) {
			$this->error('您的投资已经确认。');
		} else {
			$data['fund'] = $invest['fund'];
		}

		$data['amount'] = $data['fund'] - $data['use_able'];
		if ($data['amount'] > 0) {
			$url = U('Account/recharge', array('amount'=>$data['amount'])) . '?url='. urlencode(U('prepay?id='.$id));
			$this->error('您账户的余额不足，请先充值。', $url);
		}

		if (IS_POST) {
			$acc_invest = array('uid'=>$uid, 'pid'=>$invest['project_id'], 
				'amount'=>$invest['fund'], 'create_time'=>NOW_TIME, 'iid'=>$id);
			M('AccountInvest')->add($acc_invest);
			M('ProjectInvestor')->where(array('id' => $id))->save(array('status'=>4));
			M('AccountUser')->where(array('id'=>$account['id']))
				->setDec('use_able', $invest['fund']);
			$this->success('操作成功。', U('Manage/investlist'));
		} else {
			$data['id'] = $id;
			$this->data = $data;
			$this->display('prepay');
		}
	}

	public function checkagree($map) {
		$projectid = I('pid');
		$fund = D('ProjectFundView')->where("p.id = ". $projectid)->find();
		if ($fund['need_fund'] <= $fund['agree_fund']) {
			return -1;
		}
		$add = M('ProjectInvestor')->where($map)->sum('fund');
		if ($_GET['over'] != 1 && $fund['need_fund'] < ($fund['agree_fund'] + $add)) { 
			return 0;
		}
		return $add;
	}

	public function agreeMore() {
		if (IS_AJAX) {
			$id = array_unique((array)I('id',0));
			$id = is_array($id) ? implode(',',$id) : $id;
			if (empty($id) ) {
        $this->error('请选择要操作的数据!');
     	}
			$map = array('id'=>array('in', $id), 'status' => 2);
			$ret = $this->checkagree($map);
			if ($ret == -1) {
				$this->error('您接受的金额已经达到或超出了融资额，不能再接受认投了。');
			} else if ($ret == 0) {
				$this->error('您选择的认投额加上已经接受的超出了，目标融资总额。请单个接受您需要投资额人。');
			}

			M('ProjectInvestor')->where($map)->save(array('status'=>3));
			M('ProjectFund')->where('project_id='.$_POST['pid'])->setInc('agree_fund', $ret);

			$this->success('操作成功。');
		}
	}

	public function pay() {
		$id = is_login();
		$iid = $_GET['id'];
		$uid = is_login();
		
		$investor = M('ProjectInvestor')->where('id='.$iid)->find();
		$fund = M('AccountFund')->where(array('pid'=>$investor['project_id']))->find();

		$this->assign('fund',$fund);
		$this->assign('investor',$investor);
		$this->display();
	}


	public function myCrowdfunding(){
		$modelProduct = M('Product');
		$Model = new \Think\Model();
		// 支持的项目
		$supportList = D('ProductPriceView')->where(array('c.uid'=>$this->uid))->order('start_time desc')->select();
		//$supportList = $Model->query("SELECT jm_product.start_time ,jm_product.id,jm_product.finish_amount,jm_product.amount AS required_amount,jm_product.days ,jm_custom.post_amount ,jm_product_price.price_type, jm_product_price.amount, jm_custom.id AS customId, jm_custom.status ,jm_product.name FROM jm_product_price INNER JOIN jm_custom ON jm_product_price.id = jm_custom.price_id INNER JOIN jm_product ON jm_product_price.pid = jm_product.id WHERE jm_custom.uid = ".$this->uid);

		//我发布的项目
		$myProductList = $modelProduct->where(array('uid'=>$this->uid))->order('create_time desc')->select();

		$this->assign('supportList',$supportList);
		$this->assign('myProductList',$myProductList);
		$this->display('myCrowdfunding');
	}

	public function myCrowdfundingOrder($pid){
		$page = I('p');
		if (empty($page)) {
			$page = 1;
		}
		$modelProduct = M('Product');
		$modelProductPrice = M('ProductPrice');
		$modelCustom = M('Custom');
		$modelCustomAddress = M('CustomAddress');

		$myProduct = $modelProduct->where(array('id'=>$pid))->field('name')->find();
		$myProductPriceIds = $modelProductPrice->where(array('pid'=>$pid))->getField('id',true);

		//购买数量不默认为1的时候需要注意。这段代码
		$whereSum['price_id'] = array('in',$myProductPriceIds);
		$whereSum['status'] = array('EQ',1);
		$listSum = $modelCustom->where($whereSum)->sum('amount');
		
		$where['price_id'] = array('in',$myProductPriceIds);
		$list = $modelCustom->where($where)->order('create_time desc')->page($page.',20')->select();
		
		$myCustomAddressIds = $modelCustom->where($where)->getField('address_id',true);
		$whereCustomAddress['id'] = array('in',$myCustomAddressIds);

		if(!empty($myCustomAddressIds)){
			$resultCustomAddress = $modelCustomAddress->where(array('id'=>array('in',$myCustomAddressIds)))->select();
		}

		foreach ($resultCustomAddress as $key => $value) {
			$newResultCustomAddress[$value['id']]=$value;
		}
		unset($resultCustomAddress);

		$count      = $modelCustom->where($where)->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数
		$show       = $Page->show();// 分页显示输出

		$this->assign('myProduct',$myProduct);
		$this->pid =$pid;
		$this->assign('listSum',$listSum);
		$this->assign('customAddress',$newResultCustomAddress);
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('list',$list);
		$this->display('myCrowdfundingOrder');
	}

	public function exploadMyCrowdfundingOrder($pid){
		if (empty($pid)) {
			$this->error('关键参数未获得');
		}

		$modelProduct = M('Product');
		$modelProductPrice = M('ProductPrice');
		$modelCustom = M('Custom');
		$modelCustomAddress = M('CustomAddress');

		$myProduct = $modelProduct->where(array('id'=>$pid))->field('name')->find();
			$myProductPriceIds = $modelProductPrice->where(array('pid'=>$pid))->getField('id',true);
			$where['price_id'] = array('in',$myProductPriceIds);
			$where['status'] = array('EQ',1);
			$myCustomAddressIds = $modelCustom->where($where)->getField('address_id',true);
			// var_dump($myProductPriceIds);exit();
			// var_dump($myCustomAddressIds);
		$myCustom = $modelCustom->where($where)->order('create_time desc')->select();
		
		$whereCustomAddress['id'] = array('in',$myCustomAddressIds);
		$resultCustomAddress = $modelCustomAddress->where(array('id'=>array('in',$myCustomAddressIds)))->select();

		foreach ($resultCustomAddress as $key => $value) {
			$newResultCustomAddress[$value['id']]=$value;
		}
		unset($resultCustomAddress);

		$list =array(
			'myProduct'=>$myProduct,
			'myCustom'=>$myCustom,
			'customAddress'=>$newResultCustomAddress
		);


		$this->exportexcel($list);
	}

	/**
     * 导出数据为excel表格
     *@param $data    一个二维数组,结构如同从数据库查出来的数组
	 */
    private function exportexcel($data)
    {
		$name = $data['myProduct']['name'].'-'.date('YmdHis');

		
    	vendor('PHPExcel.Classes.PHPExcel');
    	vendor('PHPExcel.Classes.PHPExcel.IOFactory');
    	error_reporting(E_ALL);  
    	date_default_timezone_set("PRC");

    	$objPHPExcel = new \PHPExcel();   
   	 	/*以下是一些设置 ，什么作者 标题啊之类的*/ 
    	$objPHPExcel->getProperties()
	    	->setCreator("")
	    	->setLastModifiedBy("")
	    	->setTitle("")
	    	->setSubject("")
	    	->setDescription("")
	    	->setKeywords("")
	    	->setCategory("");  
    	
	    /*以下就是对处理Excel里的数据， 横着取数据，主要是这一步，其他基本都不要改*/
	    
	    $objPHPExcel->setActiveSheetIndex(0)   
    	//Excel的第A列，uid是你查出数组的键值，下面以此类推   
    	->setCellValue('A1', "订单号")
    	->setCellValue('B1', "数量")
    	->setCellValue('C1', "总金额")
    	->setCellValue('D1', "邮费")
    	->setCellValue('E1', "备注")
    	->setCellValue('F1', "支付时间")
    	->setCellValue('G1', "姓名")
    	->setCellValue('H1', "手机号码")
    	->setCellValue('I1', "地址")
    	->setCellValue('J1', "邮编");
	    foreach($data['myCustom'] as $k => $v){
	    	
	    	
	    	if (empty($v['remarks'])) {
	    		$v['remarks'] = '无';
	    	}
	    	
	    	$addressInfo = $data['customAddress'][$v['address_id']];

	    	$addressStr = getProvinceCity($addressInfo['province'],$addressInfo['city']).' '.$addressInfo['address'];

	    	$num=$k+2;
	    	$objPHPExcel->setActiveSheetIndex(0)
	    	//Excel的第A列，$num是你查出数组的键值，下面以此类推  
    		->setCellValue('A'.$num, $v['id'])  
	    	->setCellValue('B'.$num, $v['count'])
	    	->setCellValue('C'.$num, '￥'.$v['amount'])
	    	->setCellValue('D'.$num, '￥'.$v['post_amount'])
	    	->setCellValue('E'.$num, $v['remarks'])
	    	->setCellValue('F'.$num, time_format($v['update_time'],'Y-m-d  H:i:s'))
	    	->setCellValue('G'.$num, $addressInfo['name'])
	    	->setCellValue('H'.$num, $addressInfo['phone'])
	    	->setCellValue('I'.$num, $addressStr)
	    	->setCellValue('J'.$num, $addressInfo['postno']);
	    }   
	  
		$objPHPExcel->getActiveSheet()->setTitle('User');  
		$objPHPExcel->setActiveSheetIndex(0);   

		$objWriter= \PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
	    	
		$FileName = $name.'.xls';
	    	
		header('Pragma:public');
		header('Content-Type:application/x-msexecl;name="'.$FileName.'"');
		header("Content-Disposition:inline;filename=$FileName");
	    	
		$objWriter->save('php://output');
	    	
 	}
}
?>