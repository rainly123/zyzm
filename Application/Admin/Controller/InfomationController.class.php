<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: huajie <banhuajie@163.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Think\Page;

/**
 * 后台内容控制器
 * @author huajie <banhuajie@163.com>
 */
class InfomationController extends AdminController {
    /**
     * 列表页
     */
    public function index(){

    	$info = M('Infomation')->order('status desc,level desc,id desc')->select();
    	// 记录当前列表页的cookie
    	Cookie('__forward__',$_SERVER['REQUEST_URI']);
    	
    	int_to_string($info,array('status'=>array('-1'=>'已撤销','0'=>'已保存','1'=>'已发布')));

    	$this->assign('infomation',$info);
    	$this->display();
    }
    
    /**
     * 资讯新增页面初始化
     * @author zhaobb
     */
    public function add(){
    	$uid = is_login();
    	if(IS_GET) {
    		$this->meta_title = '新增资讯';
    		$this->display();
    	} else {
    		$data = array(
				'title'=>$_POST['title'], 
    			'description'=>$_POST['description'],
    			'cover'=>$_POST['cover'], 
    			'content'=>$_POST['content'],
    			'pub_time'=>strtotime($_POST['pub_time']), 
    			'info_from'=>$_POST['info_from'],
    			'author' => $_POST['author'], 
    			'view'=>$_POST['view'],
    			'comment'=>$_POST['comment'],
    			'level'=>$_POST['level'],
    			'display'=>$_POST['display'],
    			'create_id'=>$uid,
    			'create_time'=>NOW_TIME, 
    			'update_id'=>$uid,
    			'update_time'=>NOW_TIME);
    	
    		M('Infomation')->add($data);
    	
    		$this->success('添加成功', U('index'));
    	}
    }
    
    /**
     * 资讯编辑页面初始化
     * @author zhaobb
     */
    public function edit() {
    	$uid = is_login();
    	
    	if(IS_GET) {
    		$info	= M('Infomation')->where(array('id'=>$_GET['id']))->find();

    		$this->assign('infomation',$info);
    		$this->display('add');
    	} else {
    		$data = array(
    				'id'=>$_POST['id'],
    				'title'=>$_POST['title'],
    				'description'=>$_POST['description'],
    				'cover'=>$_POST['cover'],
    				'content'=>$_POST['content'],
    				'pub_time'=>strtotime($_POST['pub_time']),
    				'info_from'=>$_POST['info_from'],
    				'author' => $_POST['author'],
    				'view'=>$_POST['view'],
    				'comment'=>$_POST['comment'],
    				'level'=>$_POST['level'],
    				'display'=>$_POST['display'],
    				'update_id'=>$uid,
    				'update_time'=>NOW_TIME);

    		M('Infomation')->save($data);
    
    		$this->success('修改成功', U('index'));
    	}
    }

    /**
     * 资讯删除页面初始化
     * @author zhaobb
     */
	public function changestatus(){
		if(IS_AJAX){
			$data = array(
					'id'=>$_GET['id'],
					'status'=>$_GET['status']);
			
			M('Infomation')->save($data);
			$this->success('撤销成功', U('index'));
		}
		
	}
	
	/**
	 * 排序
	 * @author zhaobb
	 */
	public function sort(){
		if(IS_GET){

			$list = M('Infomation')->where(array('status'=>1))->field('id,title')->order('level DESC,id DESC')->select();
	
			$this->assign('list', $list);
			$this->meta_title = '排序';
			$this->display();
		}elseif (IS_POST){
			$ids = I('post.ids');
			$ids = array_reverse(explode(',', $ids));
			foreach ($ids as $key=>$value){
				$res = M('Infomation')->where(array('id'=>$value))->setField('level', $key+1);
			}
			if($res !== false){
				$this->success('排序成功！');
			}else{
				$this->error('排序失败！');
			}
		}else{
			$this->error('非法请求！');
		}
	}
    
	/**
	 * 评论列表页
	 * @param integer $cate_id 分类id
	 * @param integer $model_id 模型id
	 * @param integer $position 推荐标志
	 */
	public function comment(){
	
		$pid =$_GET['id'];

		$infomation = M('Infomation')->find($pid);
		
		if(!$infomation){
			$this->error('该资讯不存在');
		}
		
		$info = M('InfomationComment')->where(array('pid'=>$pid))->order('status desc,level desc,id desc')->select();
		// 记录当前列表页的cookie
		Cookie('__forward__',$_SERVER['REQUEST_URI']);
		 
		int_to_string($info,array('status'=>array('-1'=>'已撤销','0'=>'正常')));
	
		$this->assign('infomation',$infomation);
		$this->assign('info',$info);
		$this->display();
	}
	
	/**
	 * 评论新增页面初始化
	 * @author zhaobb
	 */
	public function addcomment(){
	
		$uid = is_login();
		if(IS_GET) {
			$pid = $_GET['pid'];
			$this->meta_title = '新增评论';
			$this->pid = $pid;
			$this->display();
		} else {
			$pid = $_POST['pid'];
			$data = array(
				'pid'=>$_POST['pid'],
				'comment_by'=>$_POST['comment_by'],
				'comment_time'=>strtotime($_POST['comment_time']),
				'face'=>$_POST['face'],
				'content' => $_POST['content'],
				'create_time'=>NOW_TIME,
				'create_id'=>$uid,
				'update_time'=>NOW_TIME,
				'update_id'=>$uid);
			 
			M('InfomationComment')->add($data);
			 
			$this->success('添加成功', U('comment',array('id'=>$pid)));
		}
	}
	
	/**
	 * 评论编辑页面初始化
	 * @author zhaobb
	 */
	public function editcomment() {
		if(IS_GET) {
			$info	= M('InfomationComment')->where(array('id'=>$_GET['id']))->find();
	
			if(!$info){
				$this->error(该评论不存在);
				return false;
			}
			
			$this->pid = $info['pid'];
			$this->assign('info',$info);
			$this->display('addcomment');
		} else {
			$pid =$_POST['pid'];
			$data = array(
					'id'=>$_POST['id'],
					'comment_by'=>$_POST['comment_by'],
					'comment_time'=>strtotime($_POST['comment_time']),
					'face'=>$_POST['face'],
					'content' => $_POST['content'],
					'update_time'=>NOW_TIME,
					'update_id'=>$uid);
	
			M('InfomationComment')->save($data);
	
			$this->success('修改成功', U('comment',array('id'=>$pid)));
		}
	}
	
	/**
	 * 资讯删除页面初始化
	 * @author zhaobb
	 */
	public function changecomment(){
		if(IS_AJAX){
			$pid =$_GET['pid'];
			$data = array(
				'id'=>$_GET['id'],
				'status'=>$_GET['status']);
				
			M('InfomationComment')->save($data);
			$this->success('撤销成功', U('comment',array('id'=>$pid)));
		}
	}
	

}