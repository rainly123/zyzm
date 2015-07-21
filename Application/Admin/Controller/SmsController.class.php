<?php 
namespace Admin\Controller;

class SmsController extends AdminController {
	public function index() {
		if (IS_GET) {
			$this->display('index');
		} else {
			$id = $_POST['project_id'];
			if ($_POST['type'] == 1) {
				$data = M('ProjectAttach')->where(array('project_id'=>$id))->getField('investor_id', true);
			} else if ($_POST['type'] == 2) {
				$data = M('ProjectInvestor')->where(array('project_id'=>$id, 
					'status'=>array(array('egt', 4), array('elt', 8), 'AND')))->getField('investor_id', true);
			} else if ($_POST['type'] == 3) {
				$data = M('ProjectInvestor')->where(array('project_id'=>$id, 
					'status' => 9))->getField('investor_id', true);
			}
			
			if ($data) {
				$phones = M('UsersDetail')->where(array('id'=>array('in', $data), 'phone'=>array('neq', '')))->getField('phone', true);
				$phonelist = implode(',', $phones);
				$count = count($phones);

				$mac = md5(NOW_TIME . C('SMSKEY'));
				$info = array('phone'=>$phonelist, 'count'=>$count, 
					'content'=>$_POST['content'], 'time'=>NOW_TIME, 'mac'=>$mac);
	
				$url = 'http://www.dreammove.cn/Sms/sendsms.html';
				$ret = curlPost($url, $info);

				if ($ret == 1) {
					$this->success('短信发送成功。' . $ret);
				} else {
					$this->error('短信发送失败。' . $ret);
				}
			}

		}
	}

	public function getname() {
		if ($_POST['id']) {
			$id = $_POST['id'];

			$data = M('Project')->find($id);

			if ($data) {
				$this->success($data['project_name']);
			} else {
				$this->error('找不到对应的项目');
			}
		}
	}
}
?>