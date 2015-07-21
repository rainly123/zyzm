<?php 
namespace Api\Controller;
use OAuth2;
class ProjectinfoController extends ApiController{
 	function __construct() {
    parent::__construct();
 		$_SERVER['REQUEST_METHOD']='POST';
  }

  // 获取项目列表
	public function getlist(){
    // 验证访问和合法性
    $this->verifyRequest();
		$projectInfoModel = D('ProjectInfo');
    $this->ajaxReturn($projectInfoModel->getlist());
	}
	
	protected function checkscope($path,$scope){
		return true;
		// $projectInfoModel = D('ProjectInfo');
		// return $projectInfoModel->checkscope($path,$scope);
	}
	
	public function getproject() {
    // 验证访问和合法性
    $this->verifyRequest();
		$projectInfoModel = D('ProjectInfo');
    $this->ajaxReturn($projectInfoModel->getproject());
	}
	
	public function getprojectstatis(){
    // 验证访问和合法性
    $this->verifyRequest();

		$projectInfoModel = D('ProjectInfo');
    $this->ajaxReturn($projectInfoModel->getprojectstatis());
	}

  /**
   * 获取项目基本信息列表
   * @param $page 分页的页码（为空或者0时，返回全部数据）
   *        $roll 每页数据条数
   */
  public function getbaselist() {
    // 验证访问和合法性
    $this->verifyRequest();
    $page = empty($_GET['page']) ? 0 : $_GET['page'];
    $roll = empty($_GET['roll']) ? 10 : $_GET['roll'];

    $baselist = D('ProjectFundView')->getbaselist($page, $roll);

    $baselist['state'] = true;

    $this->ajaxReturn($baselist);
    
    //dump($baselist);
  }

  /**
   * 获取项目详细信息
   */
  public function getprojectdetail() {
    // 验证访问和合法性
    $this->verifyRequest();
    $id = $_GET['id']; // 项目ID

    $data = D('ProjectFundView')->getdetail($id);

    if (!$data) {
      $data = array('state'=>false,'code'=>0, 'message'=>'未找到指定项目');
    } else {
      $data['state']=true;
    }


    $this->ajaxReturn($data);
    
    //dump($data);
  }

  /**
   * 外部投资人投资信息
   */
  public function invest() {
    // 验证访问和合法性
    
    $this->verifyRequest();
    $data = $this->decrypt($_GET['data']);
    $data = json_decode($data, true);

    $ret = D('OutInvestor')->addinvestor($data);

    $data = $ret['info'];
    if ($ret['status']) {
      $data['state'] = true;
    } else {
      $data['state'] = false;
    }

    $this->ajaxReturn($data);
  }

  /**
   * 外部投资人支付
   */
  public function pay_invest() {
    // 验证访问和合法性
    $this->verifyRequest();
    
    $outid = $_GET['outid'];
    $ret = D('OutInvestor')->pay($outid);
    
    $data = $ret['info'];
    if ($ret['status']) {
      $data['state'] = true;
    } else {
      $data['state'] = false;
    }

    $this->ajaxReturn($data);
  }

  /**
   * 撤消投资
   */
  public function cancel_invest() {
    // 验证访问和合法性
    $this->verifyRequest();
    
    $outid = $_GET['outid'];

    $ret = D('OutInvestor')->cancel($outid); 

    $data = $ret['info'];
    if ($ret['status']) {
      $data['state'] = true;
    } else {
      $data['state'] = false;
    }

    $this->ajaxReturn($data);
  }
}
?>