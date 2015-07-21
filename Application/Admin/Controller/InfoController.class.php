<?php 
namespace Admin\Controller;

class InfoController extends AdminController {
	public function index() {
		$info = M("Info")->order('level DESC,id DESC')->select();

		// 记录当前列表页的cookie
		Cookie('__forward__',$_SERVER['REQUEST_URI']);
		
		$this->assign('info',$info);
		$this->meta_title = '固定信息';
		$this->display();
	}

	public function add() {
		if (IS_POST) {
			if (!isset($_POST['key_word']) || empty($_POST['key_word'])) {
				$this->error('关键字不能为空');
			} else if (!isset($_POST['title']) || empty($_POST['title'])) {
				$this->error('标题不能为空');
			}
			$data = array('key_word'=>$_POST['key_word'], 
				'title'=>$_POST['title'], 'content'=>$_POST['content'],
				'create_time'=>NOW_TIME, 'create_id'=> is_login(),
				'update_time'=>NOW_TIME, 'update_id'=> is_login());

			M('Info')->add($data);
			$this->success('添加成功。', U('index'));
		} else {
			$this->display();	
		}
	}

	public function del() {
		M('Info')->where(array('id'=>$_GET['id']))->delete();

		$this->success('删除处理成功。');
	}
	
	public function view()
	{
		$id = I('id');
		/* 获取数据 */
		$info = M('Info')->field(true)->find($id);
		if(false === $info){
			$this->error('获取信息错误');
		}
		$this->assign('info', $info);
			
		$this->display();
	}
	
	

	public function edit ()
	{
		if (IS_POST) {
			if (!isset($_POST['key_word']) || empty($_POST['key_word'])) {
				$this->error('关键字不能为空');
			} else if (!isset($_POST['title']) || empty($_POST['title'])) {
				$this->error('标题不能为空');
			}

			$data = array(
					'id'=>$_POST['id'],
					'key_word'=>$_POST['key_word'],
					'title'=>$_POST['title'], 'content'=>$_POST['content'],
					'update_time'=>NOW_TIME, 'update_id'=> is_login());
			
			M('Info')->save($data);
			$this->success('修改成功。', U('index'));
			
		}else{
			$id = I('id');
			/* 获取数据 */
			$info = M('Info')->field(true)->find($id);
			if(false === $info){
				$this->error('获取信息错误');
			}
			$this->assign('info', $info);
			
			$this->display('add');
		}

	}
	
	/**
	 * 排序
	 * @author zhaobb
	 */
	public function sort(){
		if(IS_GET){
	
			$list = M('Info')->where(array('status'=>0))->field('id,title')->order('level DESC,id DESC')->select();
	
			$this->assign('list', $list);
			$this->meta_title = '排序';
			$this->display();
		}elseif (IS_POST){
			$ids = I('post.ids');
			$ids = array_reverse(explode(',', $ids));
			foreach ($ids as $key=>$value){
				$res = M('Info')->where(array('id'=>$value))->setField('level', $key+1);
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
	
}
?>