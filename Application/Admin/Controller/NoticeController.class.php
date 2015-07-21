<?php 
namespace Admin\Controller;

class NoticeController extends AdminController {
	public function index() {
		$info = M("Notice")->where('status = 0')->order('is_top desc,update_time desc')->select();

		$this->assign('info',$info);
		$this->meta_title = '系统公告';
		$this->display();
	}

	public function add() {
		if (IS_POST) {
			if (!isset($_POST['title']) || empty($_POST['title'])) {
				$this->error('标题不能为空');
			} else if (!isset($_POST['content']) || empty($_POST['content'])) {
				$this->error('内容不能为空');
			}
			$data = array(
				'title'=>$_POST['title'], 
				'content'=>$_POST['content'],
				'create_time'=>NOW_TIME, 'create_id'=> is_login(),
				'update_time'=>NOW_TIME, 'update_id'=> is_login());

			M('Notice')->add($data);
			$this->success('添加成功。', U('index'));
		} else {
			$this->display();	
		}
	}

	public function del() {
		
		$data = array(
				'id'=>$_GET['id'],
				'status'=>'-1',
				'update_time'=>NOW_TIME, 'update_id'=> is_login());
	
		M('Notice')->save($data);

		$this->success('删除处理成功。');
	}
	
	public function view()
	{
		$id = I('id');
		/* 获取数据 */
		$info = M('Notice')->field(true)->find($id);
		if(false === $info){
			$this->error('获取信息错误');
		}
		$this->assign('info', $info);
			
		$this->display();
	}
	
	

	public function edit ()
	{
		if (IS_POST) {
			if (!isset($_POST['title']) || empty($_POST['title'])) {
				$this->error('标题不能为空');
			} else if (!isset($_POST['content']) || empty($_POST['content'])) {
				$this->error('内容不能为空');
			}

			$data = array(
					'id'=>$_POST['id'],
					'title'=>$_POST['title'], 'content'=>$_POST['content'],
					'update_time'=>NOW_TIME, 'update_id'=> is_login());
			
			M('Notice')->save($data);
			$this->success('修改成功。', U('index'));
			
		}else{
			$id = I('id');
			/* 获取数据 */
			$info = M('Notice')->field(true)->find($id);
			if(false === $info){
				$this->error('获取信息错误');
			}
			$this->assign('info', $info);
			
			$this->display('add');
		}

	}
	
	
	//是否置顶
	public function istop() {
		if (IS_AJAX) {
			$id = $_GET['id'];
			$status = $_GET['status'];
			if (!isset($id)) {
				$this->error('没有指定公告');
			}
	
			$notice = M('Notice')->find($id);
			if (!$notice) {$this->error('公告不存在。');}
				
			if($status==1){
				$message='置顶成功';
			}else{
				$message='取消置顶成功';
			}
				
			M('Notice')->save(array('is_top'=>$status, 'id'=> $id));
			$this->success($message);
		}
	}
	
}
?>