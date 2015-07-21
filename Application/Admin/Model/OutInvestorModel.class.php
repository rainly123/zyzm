<?php 
namespace Admin\Model;
use Think\Model;
use User\Api\UserApi;
use Think\Log;

class OutInvestorModel extends Model {
	public function getlist() {
		$data = D('OutInvestorView')->where(array(
			'out_state'=>array('neq', -1), 'state'=>array('neq', -1)))->order('state, create_time desc')->select();

		return $data;
	}

	public function invest($id) {
		$data = $this->find($id);

		$uid = M('UsersDetail')->where(array('phone'=>$data['phone']))->getField('id');

		if ($uid) {
			$invest = M('ProjectInvestor')->where(array('project_id'=>$data['pid'], 
				'investor_id'=>$uid, 'status'=>array('egt', 0)))->find();
			if ($invest) {
				$this->error = '该用户已在聚募投资该项目';
				return false;
			}

			$invest = array('investor_id'=>$uid, 'project_id'=>$data['pid'], 
				'fund'=>$data['fund'], 'step'=>4, 'status'=>9, 'pay_way'=>0, 
				'bak'=>$data['from_way']);
		
			D('ProjectInvestor')->invest($invest);
		} else {
			$api = new UserApi;
			$ret = $api->register($data['phone'], substr($data['cardid'], -6), $data['phone']);

			if ($ret < 0) {
				Log::write('用户注册失败:('.$ret .')');
				$this->error = '新用户注册失败，请联系管理员';

				return false;
			} else {
				$uid = $ret;
			}

			$Member = M('Users');
			$temp = array('id'=> $uid,
					'nickname'=> $data['phone'],
					'status' => 1,
					'photo_url' => '/Public/Home/images/default_face/' . rand(1, 14) . '.jpg',
					'reg_ip'=>get_client_ip(1),
					'create_time' => NOW_TIME,
					'reg_time'=>NOW_TIME);
			$temp = $Member->create($temp);
			$ret = $Member->add($temp);

			$detail = array('id'=>$uid, 'phone'=>$data['phone'], 
				'name'=>$data['real_name'], 'card_id'=>$data['cardid'],
				'create_time'=>NOW_TIME, 'update_time'=>NOW_TIME);
			M('UsersDetail')->add($detail);
			
			$auth = array('uid'=>$uid, 'auth_id'=>0, 'status'=>9);
			M('UserAuth')->add($auth);
			$auth['auth_id'] = 1;
			M('UserAuth')->add($auth);

			$invest = array('investor_id'=>$uid, 'project_id'=>$data['pid'], 
				'fund'=>$data['fund'], 'step'=>4, 'status'=>9, 'pay_way'=>'0', 
				'bak'=>$data['from_way']);
			D('ProjectInvestor')->invest($invest);
		}

		$this->save(array('id'=>$id, 'uid'=>$uid, 'state'=>1));

		return true;
	}

	function cancel($id) {
		$data = $this->find($id);

		$ret = D('ProjectInvestor')->cancel($data['pid'], $data['uid']);

		if (!$ret) {
			$this->error = D('ProjectInvestor')->getError();
			return false;
		}

		$this->save(array('id'=>$id, 'state'=> -1));

		return true;
	}
}
?>