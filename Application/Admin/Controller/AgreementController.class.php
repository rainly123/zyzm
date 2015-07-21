<?php 
namespace Admin\Controller;

class AgreementController extends AdminController {
	public function index() {
		$data = M('Agreement')->field('id, key, title, update_time, update_id')->
			order('create_time')->select();

		$this->_list = $data;

		$this->display('index');
	}

	public function add() {
		if (IS_POST) {
			if (empty($_POST['key'])) {
				$this->error('关键字必须填写');
			}
			if (empty($_POST['title'])) {
				$this->error('标题不能为空');
			}
			$data = array('key'=>$_POST['key'], 'title'=> $_POST['title'], 
				'content'=>$_POST['content'], 'seal' => $_POST['seal'], 
				'create_time'=>NOW_TIME, 'create_id'=>is_login(), 
				'update_time'=>NOW_TIME, 'update_id'=>is_login());

			M('Agreement')->add($data);
			$this->success('添加成功.', U('index'));
		} else {
			$this->display('add');
		}
	}

	public function edit() {
		if (IS_POST) {
			if (empty($_POST['key'])) {
				$this->error('关键字必须填写');
			}
			if (empty($_POST['title'])) {
				$this->error('标题不能为空');
			}
			$data = array('id'=>$_POST['id'], 'key'=>$_POST['key'], 'title'=> $_POST['title'], 
				'content'=>$_POST['content'], 'update_time'=>NOW_TIME, 
				'seal' => $_POST['seal'], 'update_id'=>is_login());

			//dump($data); die();
			M('Agreement')->save($data);
			$this->success('更新成功', U('index'));
		} else {
			$id = $_GET['id'];
			$data=M('Agreement')->find($id);
			$this->data = $data;
			$this->display('add');
		}
	}

	public function delete() {
		if (IS_AJAX) {
			$id = $_GET['id'];
			M('Agreement')->where(array('id'=>$id))->delete();
			$this->success('协议删除成功');
		}
	}
}
?>