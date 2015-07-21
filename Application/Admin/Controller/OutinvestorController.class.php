<?php 
namespace Admin\Controller;

class OutinvestorController extends AdminController {
	public function index() {
		$data = D('OutInvestor')->getlist();

		$this->data = $data;
		$this->display();
		//dump($data);
	}

	public function invest() {
		$id = $_GET['id'];
		$ret = D('OutInvestor')->invest($id);

		if (!$ret) {
			$this->error(D('OutInvestor')->getError());
		} else {
			$this->success('操作成功。');
		}
	}

	public function cancel() {
		$id = $_GET['id'];

		$ret = D('OutInvestor')->cancel($id);
		if (!$ret) {
			$this->error(D('OutInvestor')->getError());
		} else {
			$this->success('操作成功。');
		}
	}
}
?>