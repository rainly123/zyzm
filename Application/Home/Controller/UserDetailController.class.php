<?php 
namespace Home\Controller;
class UserDetailController extends HomeController {
	/**
	 * 创业者基本信息
	 */
	public function founder() {
		$this->login();
		$id = is_login();
		$this->user = M('Users')->find($id);
		$this->detail = M('UsersDetail')->find($id);
		$this->userauth = M('user_auth')->where(array('uid'=>$id,'auth_id'=>0))->find();
		
		$this->display();
	}

	/**
     * 投资人基本信息
	 */
	public function investor() {
		$this->login();
		$id = is_login();
		$this->user = M('Users')->find($id);
		$this->detail = M('UsersDetail')->find($id);
		$this->userauth = M('user_auth')->where(array('uid'=>$id,'auth_id'=>1))->find();
		$this->display();
	}

	/**
	 * 基本信息保存到数据库
	 */
	public function addDetail() {
		if (IS_POST) {
			$id = I('id');
			$user_type = I('user_type');

			// 用户登录信息
			$user = array('id' => $id, 
				'photo' => I('photo'), 
				'photo_url' => I('photo_url'),
				'is_founder' => I('user_type') == 1 ? 1 : 0);

			// 用户基本信息
			$detail = array('id' => $id, 
				'name' => I('name'),
				'card_id' => I('card_id'),
				'province' => I('province'),
				'city' => I('city'), 
				'phone' => I('phone'),
				'address' => I('address'),);

			if (empty(I('name'))) {
				$this->error('真实姓名不能为空。');
			}

			if (empty(I('card_id'))) {
				$this->error('身份证号码不能为空。');
			}

			if ($user_type == 1) { // 创业者信息
				$user['is_founder'] = 1;
			} else {  // 投资人信息
				$user['is_investor'] = 1;
				$user['investor_type'] = I('investor_type');

				// 证件照保存地址
				// $detail['card_photo'] = I('card_photo');
				// 用户个人描述
				$detail['describe'] = I('describe');
			}
			$ret = M('Users')->save($user);
			
			$ret = M('UsersDetail')->find($id);
			if (!$ret) {
				$ret = M('UsersDetail')->add($detail);
			} else {
				$ret = M('UsersDetail')->save($detail);
			}

			//保存用户类别
			$auth_id = I('user_type') == 1 ? 0 : 1;
			$ret = M('user_auth')->where(array('uid'=>$id,'auth_id'=>$auth_id))->find();
			if (!$ret) {
	    		$data = array(
    				'uid'=>$id,
    				'auth_id'=>$auth_id);
	    		
				M('user_auth')->add($data);
			}
			memberupdate($id, $user['photo_url']);
			$this->success('操作成功',$_SERVER['HTTP_REFERER']);
		} else {
			$this->error('页面不存在');
		}
	}
}
?>