<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use Home\Model\MessageModel;

/**
 *  用户中心
 *  
 */
class MCenterController extends HomeController {

	/* 消息首页 */
	public function index() {
    $this->pj_count = M('ProjectInvestor')->where(array('investor_id'=>is_login(), 'status'=>9))->count();
    $this->pr_count = M('Custom')->where(array('uid'=>is_login(), 'status'=>1))->count();
    $this->dolist = $this->get_dolist();
   
    $this->user = M('Users')->find($this->uid);
    $this->display('index'); 
	}
  /*用户必须登录后方可查看*/
  function __construct(){
    parent::__construct();
    $this->uid = is_login();
    if (!$this->uid && ACTION_NAME != 'profile') {
      $this->redirect('User/login');
    }
    $this->pageTitle = "用户中心";
  }
	
	/**
	 *   询价的项目（创业）
	 *
	 *    @author    Hyber
	 *    @return    void
	 */
	function founder_inquiry()
	{
		$id = is_login();
	
		$this->assign('mtype', 'inquiry');

		$this->assign('projects', $this->_list_founder_project('inquiry',$id));

		$this->display('manager.founder');
	}
	
	/**
	 *   领头的项目（创业）
	 *
	 *    @author    Hyber
	 *    @return    void
	 */
	function founder_lintou()
	{
		$id = is_login();
	
		$this->assign('mtype', 'lintou');
	
		$this->assign('projects', $this->_list_founder_project('lintou',$id));
	
		$this->display('manager.founder');
	}
	
	/**
	 *   跟投的项目（创业）
	 *
	 *    @author    Hyber
	 *    @return    void
	 */
	function founder_gentou()
	{
		$id = is_login();
	
		$this->assign('mtype', 'gentou');
	
		$this->assign('projects', $this->_list_founder_project('gentou',$id));
	
		$this->display('manager.founder');
	}
	
  /**
   * 获取数据列表
   * @author
   */
  function _list_founder_project($pattern,$id)
  {
	if($pattern=='inquiry'){
		$leadtype = 1;
	}else if($pattern=='lintou'){
		$leadtype = 2;
	}else if($pattern=='gentou'){
		$leadtype = 3;
	}

  	$project_investor_info = D('FounderView')->where(array('investor.lead_type'=>$leadtype,'p.uid'=>$id))->order('status desc')->select();
  	
  	return $project_investor_info;
  }
  
  /**
   *   询价的项目（投资）
   *
   *    @author    Hyber
   *    @return    void
   */
  function invest_inquiry()
  {
  	$id = is_login();
  
  	$this->assign('mtype', 'inquiry');
  
  	$this->assign('projects', $this->_list_invest_project('inquiry',$id));
  
  	$this->display('manager.invest');
  }
  
  /**
   *   领头的项目（投资）
   *
   *    @author    Hyber
   *    @return    void
   */
  function invest_lintou()
  {
  	$id = is_login();
  
  	$this->assign('mtype', 'lintou');
  
  	$this->assign('projects', $this->_list_invest_project('lintou',$id));
  
  	$this->display('manager.invest');
  }
  
  /**
   *   跟投的项目（投资）
   *
   *    @author    Hyber
   *    @return    void
   */
  function invest_gentou()
  {
  	$id = is_login();
  
  	$this->assign('mtype', 'gentou');
  
  	$this->assign('projects', $this->_list_invest_project('gentou',$id));
  
  	$this->display('manager.invest');
  }
  
  /**
   * 获取数据列表
   * @author
   */
  function _list_invest_project($pattern,$id)
  {
  	if($pattern=='inquiry'){
  		$leadtype = 1;
  	}else if($pattern=='lintou'){
  		$leadtype = 2;
  	}else if($pattern=='gentou'){
  		$leadtype = 3;
  	}

  	$project_investor_info = D('FounderView')->where(array('investor.lead_type'=>$leadtype,'investor.investor_id'=>$id))->order('status desc')->select();

  	return $project_investor_info;
  }
  
  /**
   * 接受
   */
  public function accept(){
  	
  	$id    =   I('request.id');
  	$status =   I('request.status');
  	$mtype =   I('request.mtype');

  	
  	if(empty($id)){
  		$this->error('请选择要操作的数据');
  	}
  	
  	$investormod =  M('project_investor');
  	$fundmod = M('project_fund');
  	
  	$data['status'] =   $status;
  	
  	$where = array_merge( array('id' => array('in', $id )) ,(array)$where );

  	if( $investormod->where($where)->save($data) != false ) {
  		
  		//获取投资信息
  		$project_investor = $investormod->find($id);
  		
  		$project_id = $project_investor['project_id'];
  		$investor_id = $project_investor['investor_id'];
  		$fund = $project_investor['fund'];
  		
  		//获取项目名称
  		$project = M('project')->find($project_id);
  		$project_name = $project['project_name'];

  		//获取已经募集的金额
  		$project_info = $fundmod->where("project_id = ". $project_id)->find();
  		
  		$project_info['has_fund'] =   $project_info['has_fund'] + $fund;
  		
  		//更新募集金额
  		$fundmod->where("project_id = ". $project_id)->save($project_info);
  		
  		$msg_content='您询价的项目【'.$project_name.'】已许可';
  		//如果是领头人，添加领头人数据
  		if($mtype=='lintou'){
  			// 项目信息
  			$leader_info = array(
  					'project_id'=>$project_id,
  					'leader_id'=>$investor_id,
  					'lead_type'=>0,
  					'create_time' => NOW_TIME,
  					'create_id' => is_login(),
  					'update_time' => NOW_TIME,
  					'update_id' => is_login(),);
  			 
  			// 项目信息登录数据库
  			M('project_leader')->add($leader_info);
  			
  			$msg_content='您领头的项目【'.$project_name.'】已许可';
  		}
  		
  		//发送消息
  		$modelmessage = new MessageModel();
  
  		$ret = $modelmessage->send(0, $investor_id, '', $msg_content,3);

  		$this->success('操作成功');
  	}else{
  		$this->error('操作失败');
  	}
  }
  

  /**
   * 拒绝
   */
  public function refuse(){
  	 
  	$investormod =  M('project_investor');
  	
  	$id    =   I('request.id');
  	$status =   I('request.status');
  	$mtype =   I('request.mtype');
  	
  	$refuse_reason = I('request.refuse_reason');
  	 
  	if(empty($id)){
  		$this->error('请选择要操作的数据');
  	}
  	 
  	$data['status'] =   $status;
  	$data['refuse_reason'] =   $refuse_reason;
  	 
  	$where = array_merge( array('id' => array('in', $id )) ,(array)$where );
  	 
  	$msg   = array_merge( array( 'success'=>'操作成功！', 'error'=>'操作失败！', 'url'=>'' ,'ajax'=>IS_AJAX) , (array)$msg );
  	if( $investormod->where($where)->save($data) != false ) {
  		
  		//获取投资信息
  		$project_investor = $investormod->find($id);
  		
  		$project_id = $project_investor['project_id'];
  		$investor_id = $project_investor['investor_id'];

  		//获取项目名称
  		$project = M('project')->find($project_id);
  		$project_name = $project['project_name'];
  		
  		//发送消息
  		$modelmessage = new MessageModel();
  		
  		if($mtype=='lintou'){
  			$msg_content='您领头的项目【'.$project_name.'】被拒绝;拒绝理由【'.$refuse_reason.'】';
  		}else{
  			$msg_content='您询价的项目【'.$project_name.'】被拒绝;拒绝理由【'.$refuse_reason.'】';
  		}
  		
  		$ret = $modelmessage->send(0, $investor_id, '', $msg_content,3);
  		
  		$this->success('操作成功');
  	}else{
  		$this->error('操作失败');
  	}
  }
  


  /**
   * 个人信息
   */
  public function profile() {
  	
  	$id = $_GET['id'];
    if (!$id) {$this->error('参数不合法。');}
  	$model = D('users');
    $userinfo = $model->getdetail($id);

  	if ($userinfo == false) {
  		$this->error($model->getError());
  	}

    $this->pageTitle = get_membername($id);
      $this->userphoto = get_memberface($id);
  	$this->userinfo = $userinfo;
  	$this->display();

  }
    
  function project()
  {
  	$id = is_login();
  	// 我的项目
  	$project = M('Project')->where(array('create_id'=>$id))->order('create_time desc')->select();
  	
  	int_to_string($project,
	array('status'=>array(0=>'保存',1=>'申请审核',2=>'审核未通过',9=>'已审核')));

  	$this->assign('mtype', 'project');
  	$this->projects = $project;
  	$this->display();
  }
  
  function statistical()
  {
  	//$id = is_login();
  	
  	$projectid = I('id');
  	
  	//项目融资信息
  	$project_fund = D('ProjectFundView')->where("p.id = ". $projectid)->find();
  	
  	//认投明细
  	$project_investor = D('ProjectInvestorView')->where("p.id = ". $projectid)->order('investor.status desc')->select();
  	
  	int_to_string($project_investor,
  	array('lead_type'=>array(1=>'投资人',2=>'投资人',3=>'跟投人',9=>'领投人'),
  		'status'=>array(0=>'拒绝',1=>'未认可',2=>'认可',3=>'资金冻结',4=>'已支付',9=>'接受')));
  

  	$this->fund = $project_fund;
  	$this->investor = $project_investor;

  	$this->display();
  }

  public function attach() {
    $data = D('AttachView')->where(array('a.investor_id' => is_login()))->select();
    
    $this->data = $data;
    $this->display();
  }

  public function pj_support() {

    $invest = D('InvestorView')->where(
      array('investor.investor_id' => $this->uid, 
        'investor.status'=>array('egt','0')))->order('investor.create_time desc')->select();
    foreach ($invest as $k => $v) {
      $invest[$k]['rate'] = round($v['has_fund'] * 100 / $v['need_fund']);
      $invest[$k]['m_rate'] = $invest[$k]['rate'] > 100 ? 100 :$invest[$k]['rate'];
    }

    $leader = D('ProjLeaderView')->where(
      array('leader.uid'=>$this->uid, 'leader.status'=>array('egt', 0), 'del_flag'=>0))->order('leader.create_time desc')->select();

    $this->leader = $leader;
    $this->invest = $invest;
    $this->version = 1;
    //返回跳转
    $this->assign("backurl",U('MCenter/index'));
    $this->display('pj_support');
  }

  public function pj_create() {
    // 我的项目
    $project = M('Project')->where(array('uid'=>$this->uid))->order('create_time desc')->select();

    int_to_string($project,
      array('status'=>array(0=>'保存',1=>'审核中',2=>'审核未通过',9=>'已审核')));

    $this->projects = $project;
    //返回跳转
    $this->assign("backurl",U('MCenter/index'));
    $this->display('pj_create');
  }

  public function pj_leaders() {
    $leaders = D('ProjLeaderView')->where(array('leader.del_flag'=>0, 'leader.pid'=>I('id')))->select();
    $this->leaders = $leaders;
    $this->display('pj_leaders');
  }

  public function pj_attach() {
    $data = D('AttachView')->where(array('a.investor_id' => $this->uid))->select();
    foreach ($data as $k => $v) {
      $data[$k]['rate'] = round($v['has_fund'] * 100 / $v['need_fund']);
      $data[$k]['m_rate'] = $data[$k]['rate'] > 100 ? 100 :$data[$k]['rate'];
    }
    $this->data = $data;
    //返回跳转
    $this->assign("backurl",U('MCenter/index'));
    $this->display('pj_attach');
  }

  //支持的项目
  public function pr_support() {
  	
  	$modelProduct = M('Product');
  	// 支持的项目
    $this->pageTitle = "支持项目";
  	$supportList = D('ProductPriceView')->where(array('c.uid'=>$this->uid,'c.status'=>array('egt','0')))->order('start_time desc')->select();

  	//（0:初始、1:预热、2:上线、8:众筹失败、9:众筹成功）
  	int_to_string($supportList,
  	array('stage'=>array(0=>'等待中',1=>'预热中',2=>'众筹中',8=>'众筹失败',9=>'众筹成功')));
  	
  	$this->assign('supportList',$supportList);
  	//返回跳转
  	$this->assign("backurl",U('MCenter/index'));
    $this->display('pr_support');
  }

  public function pr_create() {
  	$modelProduct = M('Product');
  	
  	//我发布的项目
  	$myProductList = $modelProduct->where(array('uid'=>$this->uid, 'status'=>array('egt', 0)))->order('create_time desc')->select();

  	$this->assign('myProductList',$myProductList);
  	//返回跳转
  	$this->assign("backurl",U('MCenter/index'));
    $this->pageTitle = "发布项目";
    $this->display('pr_create');
  }

  public function pr_attach() {
  	$modelProduct = M('Product');
  	 
  	//我发布的项目
  	$myProductList = $modelProduct->where(array('uid'=>$this->uid))->order('create_time desc')->select();
  	
  	$this->assign('myProductList',$myProductList);
  	$this->pageTitle = "收藏项目";
    $this->display('pr_attach');
  }
  
  //基金管理
  public function stock() {
  	// 我的项目
  	$stockinfo = D('StockView')->where(array('i.uid'=>$this->uid,'s.status'=>1,'i.status'=>0))->order('i.status desc,create_time desc')->select();

  	// 累计买入金额
  	$data['sumfund'] = D('StockView')->where(array('i.uid'=>$this->uid,'s.status'=>1,'i.status'=>0))->sum('i.fund');
  	// 累计利润金额
  	$data['sumover'] = D('StockView')->where(array('i.uid'=>$this->uid,'s.status'=>1,'i.status'=>0))->sum('i.over');
  	// 累计买入金额
  	$data['sumwaiting'] = D('StockView')->where(array('i.uid'=>$this->uid,'s.status'=>1,'i.status'=>0))->sum('i.waiting_fund');
  	$this->stockinfo = $stockinfo;
  	$this->assign('data',$data);
  	$this->pageTitle = "我的基金";
  	$this->display('stock');
  }

  public function leader_cancel() {
    $leader = M('ProjLeader')->where(array('id'=>$_GET['id'], 
      'del_flag'=>0))->find();
    if (!$leader){
      $this->error('指定记录不存在。');
    }elseif ($this->uid != $leader['uid']) {
      $this->error('非法操作。');
    } elseif ($leader['status'] == 1) {
      $this->error('项目方已经接受了你的领投人申请，不能撤销');
    }
    M('ProjLeader')->save(array('del_flag'=> -1, 'id'=>$_GET['id']));

    $this->success('撤销处理成功。');
  }

  public function agreeleader() {
    $id = $_GET['id'];
    $leader = M('ProjLeader')->find($id);
    $founder = M('Project')->where(array('id'=>$leader['pid']))->getField('uid');
    if ($founder != $this->uid) {
      $this->error('非法操作。');
    }

    M('ProjLeader')->where(array('pid'=>$leader['pid'], 
      'del_flag'=>0, 'id'=>array('neq', $id)))->save(array('status'=>2));
    M('ProjLeader')->where(array('id'=> $id))->save(array('status'=>1));

    M('ProjectFund')->where(array('project_id'=>$leader['pid']))->
      save(array('leader_id'=>$leader['uid'], 'update_time'=>NOW_TIME));
    M('ProjectLeader')->add(array('project_id'=>$leader['pid'], 'leader_id'=>$leader['uid'], 
      'lead_type'=>9, 'create_time'=>NOW_TIME, 'update_time'=>NOW_TIME));
    M('Project')->save(array('id'=>$leader['pid'], 'vote_leader'=>2));
    
    // 投资人信息表修改【领投人状态、非领投人取消候选领投】
    M('ProjectInvestor')->where(array('project_id'=>$leader['pid'], 
      'investor_id'=>$leader['uid'], 'status'=>array('egt', 4), 'lead_type'=>2))->save(
      array('lead_type'=>9, 'update_time'=>NOW_TIME));
    M('ProjectInvestor')->where(array('project_id'=>$leader['pid'], 
      'investor_id'=> array('neq', $leader['uid']), 'status'=>array('egt', 4), 'lead_type'=>2))->save(
      array('lead_type'=>3, 'update_time'=>NOW_TIME));

    $this->success('领投人设置成功。');
  }

  //基金交易管理
  public function stocklist() {
  	$id = I('id');
  	$data = M('Stock')->find($id);
  	
  	if($data['status'] != 1){
  		$this->error('该项目已下线！');
  	}
  	
  	// 我的项目
  	$stocklist = D('StockListView')->where(array('s.id'=>$id,'i.uid'=>$this->uid,'i.type'=>array('gt',0)))->order('create_time desc')->select();

  	//1：充值、2：提现
  	int_to_string($stocklist,array('type'=>array(1=>'投资',2=>'赎回')));
  	
  	int_to_string($stocklist,array('state'=>array(0=>'未处理',1=>'已处理')));
  	
  	$this->assign('stock',$data);
  	$this->stocklist = $stocklist;
  	$this->pageTitle = $data['name'];
  	$this->display('stocklist');
  }
  
  //获取待办件数
  public function get_dolist() {
	//获取当前用户ID
  	$uid = $this->uid;
  	//初始化待办件数
  	$pj_qty = 0;
  	$pr_qty = 0;
  	//待办事情表
  	$lists = M('Dolist')->where(array('uid' => $uid))->find();
  	
  	
  	if(!$lists){
  		$lists['pj_qty'] =0;
  		$lists['pr_qty'] =0;
  	}
  	
  	return $lists;
  	//返回
  	//$this->ajaxReturn(array('pj_qty'=>$pj_qty, 'pr_qty'=>$pr_qty));
  }
  
  
}
