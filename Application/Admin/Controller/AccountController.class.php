<?php 
namespace Admin\Controller;

class AccountController extends AdminController {

	// 账户管理
	public function index() {

		$name = I('name');
		if(is_numeric($name)){
      $maps['name|phone']= array(intval($name),array('like','%'.$name.'%'),'_multi'=>true);
    }else{
      $maps['name']  = array('like', '%'.(string)$name.'%');
    }
    $state = I('state', 0);
    if ($state == 1) {
    	$maps['balance'] = array('gt', 0);
    }
    $this->name = $name;

		$this->_list = D('AccountView')->where($maps)->select();
		// 用户提现申请列表
		$this->display('index');
	}

	public function streamlist() {
		$uid = I('uid');

		$maps = array('uid'=>$uid);
		$type = $_GET['type'];

		if (!empty($type)) {
			$maps['type'] = $type;
		}

		$this->_list = D('AccStreamView')->where($maps)->order('create_time desc')->select();
		$this->uid = $uid;
		$this->display('streamlist');
	}

	// 线下充值
	public function payadd() {
		if (IS_GET) {
			$uid = $_GET['uid'];
			$this->data = M('UsersDetail')->where(array('id'=>$uid))->find();

			$this->display('payadd');
		} else {
			$uid = $_POST['uid'];
			$amount = $_POST['amount'];

			if (!is_numeric($amount)) {
				$this->error('输入的金额不合法。');
			}

			$data = array('uid'=>$uid, 'amount'=>$amount, 'remarks'=>$_POST['remarks']);
			$ret = D('AccStream')->recharge($data);

			$this->success('线下充值处理成功。当前可用余额为' . $ret. '元。', U('streamlist?uid='.$uid));
		}
	}

	public function createaccount() {
		if (IS_POST){
			$mobile = $_POST['mobile'];
			if (empty($mobile)) {
				$this->error('请填写用户的手机号码.');
			} else {
				$data = M('UsersDetail')->where(array('phone'=>$mobile))->select();
	
				$count = count($data);
				if ($count != 1) {
					$this->error('指定手机号码不存在，货关联用户超过1位。');
				}
	
				$id = D('AccountUser')->addAccount($data[0]['id']);
				$this->success('新账户添加成功。');
			}
		} else {
			$this->display('createaccount');
		}
	}

	// 提现管理
	public function cashlist() {
		$state = I('state', -1);

		$maps = array('type'=>3);
		if ($state != -1) {
			$maps['state'] = $state;
		}
		$name = I('name');
		if(is_numeric($name)){
      $maps['name|phone']= array(intval($name),array('like','%'.$name.'%'),'_multi'=>true);
    }else{
      $maps['name']  = array('like', '%'.(string)$name.'%');
    }
    $this->name = $name;

		$this->_list = D('AccStreamView')->where($maps)->select();
		// 用户提现申请列表
		$this->display('cashlist');
	}

	// 用户提现详细信息
	public function cashinfo() {
		if ($_GET) {
			$this->data = D('AccStreamView')->where(array('id'=>$_GET['id']))->find();
			$this->display('cashinfo');
		} else {
			$state = $_POST['state'];
			if ($state != 1 && $state != 2) {
				$this->error('状态设置不正确。');
			}
			if ($state == 2 && empty($_POST['remarks'])) {
				$this->error('提现不通过时，必须填写备注信息。');
			}
			
			// 验证提现流水是否处理
			$stream = M('AccStream')->where(array('id'=>$_POST['id'], 'state'=>0))->find();
			if (!$stream) {
				$this->error('指定提现记录已经处理。');
			}
			$account = M('AccountUser')->where(array('uid'=>$stream['uid']))->find();

			// 账户信息更新用
			$data = array('id'=>$account['id'], 'update_time'=>NOW_TIME);
			if ($state == 1) { // 提现通过
				if ($account['balance'] < $stream['amount']) {
					$this->error('提现金额大于账户余额');
				}
				$data['balance'] = $account['balance'] - $stream['amount'];

				M('AccountUser')->save($data);

			} else if ($state == 2) { // 提现不通过
				$data['use_able'] = $account['use_able'] + $stream['amount'];

				M('AccountUser')->save($data);
			}

			$data = $_POST;
			$data['update_time'] = NOW_TIME;
			$ret = M('AccStream')->save($data);

			$this->success('提现申请处理成功。', U('cashlist'));
		}
	}

	// 
	public function tongguo() {

	}

	// 
	public function over() {

	}
}
?>