<?php 
namespace Home\Controller;
// 开放银多接口
class ProjectInfoController extends HomeController {
	protected $allowMethod    = array('get','post'); // REST允许的请求类型列表
  protected $allowType      = array('html','xml','json'); // REST允许请求的资源类型列表

  public function read() {
  	$id = $_GET['id'];
  	echo 
  	$data = D('ProjectFundView')->where(array('p.id'=>$id, 'p.status'=>9))->find();

  	$out = array();
  	if (!$data) {
  		$this->ajaxReturn(array('status'=>'0', 'info'=>'指定项目不存在。'));
  		exit();
  	}
  	$out['project_name'] = $data['project_name'];
  	if ($data['stage'] < 4) {
  		$out['stage_text'] = '预热';
  		$out['stage'] = 1;
  		$out['rate'] = 0;
  		$out['count'] = 0;
  	} else {
  		if ($data['stage'] == 4) {
  			$out['stage_text'] = '合投';
  			$out['stage'] = 4;
  		} else {
  			$out['stage_text'] = '众筹结束';
  			$out['stage'] = 9;
  		}
  		$out['count'] = M('ProjectInvestor')->where(array('project_id'=>$id, 'status'=> array('egt', 4)))->count();
  		$out['count'] = intval($out['count']);
  		$out['rate'] = round($data['agree_fund'] / $data['need_fund'] * 100);
  	}

  	$this->ajaxReturn($out);
  }
}
?>