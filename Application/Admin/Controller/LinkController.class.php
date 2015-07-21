<?php 
namespace Admin\Controller;

class LinkController extends AdminController {
	public function index() {
		$this->_list = M('link')->
		where(array('status'=>array('egt', 0)))->order('sort desc, create_time')->select();

		$this->display();
	}

	public function modify() {
		if (IS_POST) {
			$data = $_POST;

			if (empty($data['name'])) {
				$this->error('请输入名称');
			}

			if (empty($data['logo'])) {
				$this->error('请上传logo');
			}

			if (empty($data['url'])) {
				$this->error('请输入链接地址');
			}

			if ($data['id']) {
				M('Link')->save($data);
			} else {
				$data['status'] = 0;
				$data['create_time'] = NOW_TIME;
				M('Link')->add($data);
			}
			$this->success('友情链接修改成功。', U('index'));
		} else {
			$id = $_GET['id'];
			if ($id) {
				$this->data = M('Link')->find($id);
			}
			$this->display('modify');
		}
	}

	public function sort() {
		if(IS_GET){

      //获取排序的数据
      $map = array('status'=>array('egt',0));
   
      $list = M('Link')->where($map)->field('id,name')->order('sort desc,create_time')->select();

      $this->assign('list', $list);
      $this->meta_title = '导航排序';
      $this->display('sort');
    }elseif (IS_POST){
      $ids = I('post.ids');
      $ids = explode(',', $ids);
      $ids_count = count($ids);

      // var_dump($ids_count);exit();
      foreach ($ids as $key=>$value){
        //降序
        // $currentCounter = $ids_count - $key;
        $res = M('Link')->where(array('id'=>$value))->setField('sort', $ids_count);
        $ids_count = $ids_count - 1;
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

	public function changeStatus() {
		$id = $_GET['id'];
		$status = $_GET['status'];

		$data = array('id'=>$id, 'status'=>$status);
		M('Link')->save($data);

		$this->success('处理成功。');
	}

}
?>