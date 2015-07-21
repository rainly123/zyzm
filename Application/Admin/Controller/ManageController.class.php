<?php 
namespace Admin\Controller;

class ManageController extends AdminController {
	public function index() {
		$list = M('Project')->where(array('status' => array('gt', '2'), 'stage'=>array('egt', 4)))->order('stage, create_time desc')->select();
		int_to_string($list,
		array('stage'=>array(0=>'审核已通过',1=>'预热阶段',2=>'认投阶段',3=>'推选领投人阶段',4=>'合投阶段', 5=>'等待付款', '8'=>'众筹失败', 9=>'众筹成功')));
		
		foreach ($list as $key=>$info)
		{
			$fund_info = M('project_fund')->where("project_id = ". $info['id'])->find();
			
			$list[$key]['needfund']=$fund_info['need_fund'];
			$list[$key]['hasfund']=$fund_info['has_fund'];
		}
		
		$this->_list = $list;
		$this->display();
	}

	public function payinfo() {
		if (IS_GET) {
			$id = $_GET['id'];
			$investor = M('ProjectInvestor')->where(array('id'=>$id))->find();

			$user = M('UsersDetail')->where(array('id'=>$investor['investor_id']))->find();
			$data = array('id'=> $investor['id'], 'fund'=>$investor['fund'], 
				'name'=>$user['name'], 'amount'=>$investor['fund']);
			$this->data = $data;
			$this->display('payinfo');
		} else {
			$data = array('id'=>$_POST['id'], 'fund'=>$_POST['amount'], 'status'=>9, 'update_time'=>NOW_TIME);
			M('ProjectInvestor')->save($data);

			$this->success('支付确认成功。');
		}
	}

	// 状态（-1：撤消、0：拒绝、1：未认可、2、认可、3：接受、4：资金冻结、9：已支付）
	public function seeInvestor($pj_id) {
		if (empty($pj_id)) {
			throw new Exception("没有获得项目ID", 1);
		}
		$list = null;
		$projectBase = M('Project')->where(array('id' => $pj_id))->find();
		$list = M('ProjectInvestor')->field(array('id', 'investor_id','fund','status', 'pay_way'))->where(array('project_id'=>$pj_id,'status' => array('gt', '2')))->order('status, create_time desc')->select();
		
		foreach ($list as $key => $value) {
			$userneme = M('UsersDetail')->where(array('id'=>$value['investor_id']))->field(array('id'=>'uid','name','phone'))->find();
			$list[$key] = array_merge($userneme,$list[$key]);
			switch ($value['status']) {
				case 2:
					$list[$key]['status_text'] = '认可';
					break;
				case 3:
					$list[$key]['status_text'] = '接受';
					break;
				case 4:
					$list[$key]['status_text'] = '资金冻结';
					break;
				case 8:
					$list[$key]['status_text'] = '协议已确认';
					break;
				case 9:
					$list[$key]['status_text'] = '已支付';
					break;
			}
		}
		// $resultInfo = M('Project')->field(array('id'))->field(array('id'));
		// $resultInfo
		// ->join('jm_project_investor ON jm_project.id = jm_project_investor.project_id')->field(array('investor_id','fund','status'))
		// ->join('jm_users_detail ON jm_project_investor.investor_id = jm_users_detail.id')->field(array('name'))
		// ->select();

		$this->assign('pj_id',$pj_id);
		$this->assign('list',$list);
		$this->assign('projectBase',$projectBase);
		$this->display('seeinvestor');
	}
	
	
	//导出
	public function exploadMyCrowdfundingOrder($pid){
		if (empty($pid)) {
			$this->error('关键参数未获得');
		}
		$projectinfo = M('Project')->where(array('id' => $pid))->find();
		$list = D('ExportorderView')->where(array('project_id'=>$pid))->select();
	
		$this->exportexcel($list,$projectinfo);
	}
	
	/**
	 * 导出数据为excel表格
	 *@param $data    一个二维数组,结构如同从数据库查出来的数组
	 */
	private function exportexcel($data,$projectinfo)
	{
		$name = $projectinfo['project_name'].'-'.date('YmdHis');
	
	
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
			->setCellValue('A1', "用户昵称")
			->setCellValue('B1', "真实姓名")
			->setCellValue('C1', "身份证号")
			->setCellValue('D1', "手机号码")
			->setCellValue('E1', "金额")
			->setCellValue('F1', "占比")
			->setCellValue('G1', "地址")
			->setCellValue('H1', "状态");
		
		foreach($data as $k => $v){
			$addressStr = $v['province'].' '.$v['city'].' '.$v['address'];
	
			$num=$k+2;
			$objPHPExcel->setActiveSheetIndex(0)
			//Excel的第A列，$num是你查出数组的键值，下面以此类推
			->setCellValue('A'.$num, $v['nickname'])
			->setCellValue('B'.$num, $v['name'])
			->setCellValue('C'.$num, $v['card_id'].' ')
			->setCellValue('D'.$num, $v['phone'].' ')
			->setCellValue('E'.$num, '￥'.$v['fund'])
			->setCellValue('F'.$num, $v['rate'])
			->setCellValue('G'.$num, $addressStr)
			->setCellValue('H'.$num, $v['status']);
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
	
	// 已支付用户取消投资
	public function cancel_pay() {
		if (IS_POST) {
			$id = $_POST['id'];
			$status = $_POST['status'];
			$remarks = $_POST['remarks'];

			if (empty($status)) {$this->error('请选择回退的状态。');}
			if (empty($remarks)) {$this->error('请填写撤消原因。');}

			$investor = M('ProjectInvestor')->find($id);

			if ($investor['status'] == 9) {
				$data= array('relation_id'=>$id, 'amount'=>$investor['fund'], 
					'uid'=>$investor['investor_id'], 'remarks'=>$_POST['remarks']);
				$ret = D('AccStream')->cancel_pay($data);

				// 退款处理失败。
				if (!$ret) {$this->error(D('AccStream')->getError());}
			}
			if ($status < 8 && $data['status'] > 4) {
				$data = M('AgreementInvest')->where(array('pid'=>$investor['project_id'],
					'uid'=>$investor['investor_id'], 'status'=>1))->find();

				// 协议状态设置为未确认
				if ($data) {
					M('AgreementInvest')->save(array('id'=>$data['id'], 'status'=>0));
				}
			}

			M('ProjectInvestor')->save(array('id'=>$id, 'status'=>$status));

			$this->success('用户状态修改成功。');
		} else {
			$id = $_GET['id'];
			$investor = M('ProjectInvestor')->where(array('id'=>$id))->find();

			$user = M('UsersDetail')->where(array('id'=>$investor['investor_id']))->find();
			$data = array('id'=> $investor['id'], 'fund'=>$investor['fund'], 
				'name'=>$user['name'], 'amount'=>$investor['fund']);
			$this->data = $data;
			$this->display('cancel_pay');
		}


	}
	
	public function leadlist() {
		$project = M('Project')->field('project_name')->find($_GET['id']);
		$data = D('ProjLeaderView')->where(array('pid'=>$_GET['id'], 'del_flag'=>0))->select();

		$this->project = $project;
		$this->data = $data;
		
		$this->display('leadlist');
	}
	
	
	
}
?>