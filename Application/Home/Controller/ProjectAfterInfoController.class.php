<?php 
namespace Home\Controller;
class ProjectAfterInfoController extends HomeController {

	public function fundedmanagelist(){
		$pid = $_GET['pid'];
		$projectAfterInfo = D('ProjectAfterInfo');
		if(!$projectAfterInfo->validateUserAllByPID($pid)){
			$this->error('您没有权限操作。', U('project/detail?id='.$pid));
		}
		$projecttitle = M('Project')->where('id='.$pid)->getField('project_name');
		$this->assign("projecttitle",$projecttitle);
		$this->assign("pid",$pid);
		$this->display();
	}
	public function investormanagelist(){
		$pid = $_GET['pid'];
		$projectAfterInfo = D('ProjectAfterInfo');
		if(!$projectAfterInfo->validateUserAllByPID($pid)){
			$this->error('您没有权限操作。', U('project/detail?id='.$pid));
		}
		$projecttitle = M('Project')->where('id='.$pid)->getField('project_name');
		$this->assign("projecttitle",$projecttitle);
		$this->assign("pid",$pid);
		$this->display();
	}
	public function fundeddetail(){
		$pid = $_GET['pid'];
		$projecttitle = M('Project')->where('id='.$pid)->getField('project_name');
		$this->assign("projecttitle",$projecttitle);
		$this->assign("pid",$pid);
		$this->display();
	}
	public function editfundeddetail(){
		$pid = $_GET['pid'];
		$projectAfterInfo = D('ProjectAfterInfo');
		if(!$projectAfterInfo->validateEditorByPID($pid)){
				$this->error('您没有权限操作。', U('project/detail?id='.$pid));
		}
		
		$projecttitle = M('Project')->where('id='.$pid)->getField('project_name');
		$this->assign("projecttitle",$projecttitle);
		$this->assign("pid",$pid);
		$this->display();
	}

	
    function uploadpdf(){
    	
    	$upload = new \Think\Upload();// 实例化上传类
    	$upload->maxSize   =     3145728 ;// 设置附件上传大小
    	$upload->exts      =     array('pdf');// 设置附件上传类型
    	$upload->rootPath  =      './Uploads/'; // 设置附件上传根目录
    	$upload->savePath  =      ''; // 设置附件上传（子）目录
    	$upload->autoSub  = true;
    	$upload->subName  = array('date','Ymd');
    	$info   =   $upload->upload();
    	if(!$info) {// 上传错误提示错误信息
    		$data['success'] = false;
    		$data['info'] = $upload->getError();
    	}else{// 上传成功 获取上传文件信息
    		$data['success'] = true;
    		foreach($info as $file){
    			$data['info'][]= 'http://'.$_SERVER['HTTP_HOST'].'/Uploads/'.$file['savepath'].$file['savename'];
    		}
    	}
    	return $data;
    }
    /**
     *    新增或者更新项目动态信息
     *    @author    adam
     */
    function addProjectAfterInfo()
    {
    	$projectAfterInfo = D('ProjectAfterInfo');
    	if(!$projectAfterInfo->validateEditorByPID(I('project_id'))){
    		$this->ajaxReturn(array('success'=>false, 'info'=> '没有权限修改！'));
    	}
    	if(!I('id')){//新增项目投后管理
    		$data=array(
    				'project_id'=>I('project_id'),
    				'title' => I('title'),
    				'content' => I('content'),
    				'create_time'=>NOW_TIME,
    				'update_time'=>NOW_TIME,
    				'status'=>I('status'),
    		);
    		$name = I('filename');
    		if($name!=null){
    			$savefile =$this->uploadpdf();
    			if($savefile['success']==false){
    				$this->ajaxReturn(array('success'=>false, 'info'=> $savefile));
    			}
    			$uploadfilesurls = implode($savefile['info'], ';');
    			$data['attachment'] = $uploadfilesurls;
    			$data['filename'] =I('filename');
    		}		
    		
    		if (!$projectAfterInfo->create($data)){
    			$this->ajaxReturn(array('success'=>false, 'info'=> $projectAfterInfo->getError()));
    		}else{
    			$result = M('project_after_info')->add($data);
    			if ($result ==false) {
    				$this->ajaxReturn(array('success'=>false, 'info'=> '新增项目投后管理失败，请联系管理员:service@dreammove.cn'));
    			}else{
    				$this->ajaxReturn(array('success'=>true, 'info'=>'新增成功','url'=>$data['attachment'],'id'=>$result));
    			}
    		}
    	}else {//更新项目投后管理
    		$data = array(
    				'title' => I('title'),
    				'content' => I('content'),
    				'update_time' => NOW_TIME,
    				'status' => I('status'),
    		);
    		
    		$name = I('filename');
    		if($name!=null){
    			$savefile =$this->uploadpdf();
    			if($savefile['success']==false){
    				$this->ajaxReturn(array('success'=>false, 'info'=> $savefile));
    			}else{
    				$uploadfilesurls = implode($savefile['info'], ';');
    			}
    			$data['attachment'] = $uploadfilesurls;
    			$data['filename'] =I('filename');
    			$projectAfterInfo->removeatttachment(I('id'));
    		}
    		if (!$projectAfterInfo->create($data)) {
    			$this->ajaxReturn(array('success'=>false, 'info'=> $projectAfterInfo->getError()));
    		}else {
    			$result = M('project_after_info')->where('id='.I('id'))->save($data);
    			if ($result == false) {
    				$this->ajaxReturn(array('success'=>false, 'info'=> '更新项目投后管理失败，请联系管理员:service@dreammove.cn'));
    			} else {
    				$this->ajaxReturn(array('success'=>true, 'info'=> '更新成功','url'=>$data['attachment']));
    			}
    		}
    	}
    }
    
    function removeProjectAfterInfo(){
    	$id = I('id');
    	$projectAfterInfo = D('ProjectAfterInfo');
    	if(!$projectAfterInfo->validateEditorByPID(M('project_after_info')->where('id='.$id)->getField('project_id'))){
    		$this->ajaxReturn(array('success'=>false, 'info'=> '没有权限删除!'));
    	}
    	
    	$remove = $projectAfterInfo->removeatttachment($id);
    	$result = M('project_after_info')->delete($id);
    	if ($result==0) {
    		$this->ajaxReturn(array('success'=>false, 'info'=> '删除项目投后管理失败，请联系管理员:service@dreammove.cn'));
    	}else {
    		$this->ajaxReturn($remove);
    	}
    }
    function removeatttachment(){
    	$id = I('id');
    	$projectAfterInfo = D('ProjectAfterInfo');
    	$this->ajaxReturn($projectAfterInfo->removeatttachment($id));
    }
    
    /**
     * 	  传入参数为项目id
     *    投后管理列表，发布日期，标题，详情链接，附件
     *    @author    adam
     */
    
    function projectAfterInfolist(){
    	$pid = I('pid');
    	$ProjectAfterInfo = D('ProjectAfterInfo');
    	if($ProjectAfterInfo->validateUserByPID($pid)){
    		$list = D('ProjectAfterInfo')->getPublishedListByPID($pid);
    		$this->ajaxReturn(array('success'=>true,'owner'=>false, 'info'=> $list));
    	}
    	if($ProjectAfterInfo->validateEditorByPID($pid)){
    		$list = D('ProjectAfterInfo')->getAllListByPID($pid);
    		$this->ajaxReturn(array('success'=>true, 'owner'=>true, 'info'=> $list));
    	}
    	
    	$this->ajaxReturn(array('success'=>false, 'info'=> '没有权限查看'));
    }
    
    function projectAfterPublish(){
    	$id = I('id');
    	$pid = M('project_after_info')->where('id='.$id)->getField('project_id');
    	$ProjectAfterInfo = D('ProjectAfterInfo');
    	if($ProjectAfterInfo->validateEditorByPID($pid)){
    		$data = array(
    				'status' => 1,
    		);
    		$result = M('project_after_info')->where('id='.$id)->save($data);
    		if ($result == false) {
    			$this->ajaxReturn(array('success'=>false, 'info'=> '发布失败，请联系管理员:service@dreammove.cn'));
    		}
    		$this->ajaxReturn(array('success'=>true,'info'=> '发布成功'));
    	}
    	$this->ajaxReturn(array('success'=>false, 'info'=> '没有权限'));
    }

    function addComment(){
    	$id = I('id');
    	$projectAfterInfo = D('ProjectAfterInfo');
    	if($projectAfterInfo->validateByID($id)){
    		$data=array(
    				'comment_user'=>is_login(),
    				'content' => I('content'),
    				'create_time'=>NOW_TIME,
    				'project_after_id'=>$id,
    		);
    		$result = M('ProjectafterComment')->add($data);
    		if ($result ==false) {
    			$this->ajaxReturn(array('success'=>false,'info'=> '留言失败！'));
    		}else{
    			$this->ajaxReturn(array('success'=>true,'info'=>'留言成功'));
    		}
    	}
    	$this->ajaxReturn(array('success'=>false, 'info'=> '没有权限留言'));
    }
    
    function listComment(){
    	$id = I('id');
    	$projectAfterInfo = D('ProjectAfterInfo');
    	if($projectAfterInfo->validateByID($id)){
    		$this->ajaxReturn($projectAfterInfo->getCommentList($id));
    	}
    	$this->ajaxReturn(array('success'=>false, 'info'=> '没有权限查看'));
    }
    
    function getProjectAfterInfodetail(){
    	$id = I('id');
    	$projectAfterInfo = D('ProjectAfterInfo');
    	if(!$projectAfterInfo->validateByID($id)){
    		$this->ajaxReturn(array('success'=>false, 'info'=> '没有权限查看'));
    	}
    	$this->ajaxReturn($projectAfterInfo->getProjectAfterInfodetail($id));
    }
    
    //获取投资人列表
    public function getinvestormanagelist(){
    	$pid = $_GET['pid'];
    	$page = I('page',1);
    	$number = I('number',20);
    	//TODO
    	if(!D('ProjectAfterInfo')->validateUserAllByPID($pid)){
    		$this->ajaxReturn(array('success'=>false, 'info'=> "您没有权限！"));
    	}
    	$order = I('order','lead_type desc,create_time desc');
    	$this->ajaxReturn(D('ProjectAfterInfo')->getInvestorlist($pid,$page,$number,$order)); 
    }
}
?>