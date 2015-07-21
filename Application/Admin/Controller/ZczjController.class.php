<?php 
namespace Admin\Controller;

class ZczjController extends AdminController {
	// 项目列表
	public function index () {
		$projects = D('ProjectInfoView')->where(array('p.stage'=>array('egt', 1), 'p.status'=>9))->group('p.id')->select();

		int_to_string($projects,
			array('stage'=>array(0=>'审核已通过',1=>'预热阶段',2=>'认投阶段',3=>'推选领投人阶段',4=>'合投阶段', 5=>'等待付款', 9=>'完成')));
		$this->_list = $projects;

		$this->display('index');
	}

	public function update() {
		$id = $_GET['id'];
		if (!$id) {echo '非法操作'; exit();}

		$v = D('ProjectInfoView')->where(array('p.stage'=>array('egt', 1), 'p.status'=>9, 'p.id'=>$id))->find();

		if (!$v) {echo '指定项目不存在。'; exit();}
    include_once(APP_PATH . 'Admin/zczj/zczj.api.php');
    //===============初始化==================//
    $options = array(
      'debug' => true,
      'UserName' => 'jumuzhongchou',
      'PassWord' => 'jumuzhongchou123',
      'PlatId' => 2,
    );
    $zczj = new \zczj($options);

    $var = get_cover($v['cover']);
    	
			
		$filename =  basename(APP_PATH . substr($var['path'], 1));
		//echo $filename;
		//echo getimagesize(substr($var['path'], 1)); die();
    //echo @file_get_contents(substr($var['path'], 1)); die();
		if ($v['stage'] == 1) {
			$state = 1;
		} else if($v['stage'] == 4) {
			$state = 2;
		} else if ($v['stage'] >= 8) {
			$state = 3;
		}

		$desc = str_replace('"/Uploads/', '"http://www.dreammove.cn/Uploads/', $v['description']); 
    
    $pics = M('ProjectTemp')->where(array('project_id'=>$id, 'temp_type'=>1))->order('sort')->limit(6)->select();
	  
    foreach ($pics as $k1 => $v1) {
      $path = get_cover($v1['info_key'], 'path');
      $desc = $desc . '<p><img src="http://www.dreammove.cn'.$path .'"/></p>';
    }

    $projects = array(
      'PlatProjectID' => $v['id'],                  // 平台项目ID
      'projectName' => $v['project_name'],          // 项目名称
      'description' => $desc,           						// 项目描述
      'currentAmount' => $v['has_fund'],    				// 累计投资额
      'targetAmount' => $v['need_fund'],    				// 目标融资额
      'endTime' => NULL,                            // 结束时间
      'targetDay' => 30,                            // 目标融资天数
      'projectSponsor' => get_membername($v['uid']),	// 项目发起人
      'support' => $v['follow'],                    // 支持人数
      'state' => $state,                            // 项目阶段（1:预热 2:众筹中 3:已完成）
      'projectCategoryId' => 23673,                 // 项目类型id
      'fileBytes' => @file_get_contents(substr($var['path'], 1)),  // 项目图片字节流
      'fileName' => $filename,                       // 项目图片文件名
      'url' => "http://www.dreammove.cn/Project/detail/id/" . $v['id'] . '.html',   // 项目地址
    );
    $ret = $zczj->projectsAdd($projects);
		//dump($ret); die();
    if ($ret->Result) {
    	echo "处理成功.";
    } else {
    	echo $ret->Message;
    }
	}
}
?>