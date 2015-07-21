<?php 
namespace Home\Model;
use Think\Model;

Class AccountUserModel extends Model {
	protected $_auto = array(
        array('uid', 'is_login', self::MODEL_INSERT, 'function'),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH));

	protected $_validate = array(
		array('username', 'require', '真实姓名必须填写', self::MUST_VALIDATE),
		array('username', '1,10', '真实姓名不能多余10个字', self::MUST_VALIDATE, 'length'),
		array('certno', 'require', '身份证号码必须填写', self::MUST_VALIDATE),
		array('certno', 'validation_filter_id_card', '身份证号码不合法', self::MUST_VALIDATE, 'function'),
		array('mobile', 'require', '手机号码必须填写', self::MUST_VALIDATE),
		array('mobile', 'checkMobileValidity', '手机号码不合法', self::MUST_VALIDATE, 'callback'),
		);

	public function checkMobileValidity($mobilephone){ 
		$exp = "/^13[0-9]{1}[0-9]{8}$|15[012356789]{1}[0-9]{8}$|17[012356789]{1}[0-9]{8}$|18[012356789]{1}[0-9]{8}$|14[57]{1}[0-9]{8}$/"; 
		if(preg_match($exp,$mobilephone)){ 
			return true; 
		}else{ 
			return false; 
		} 
	}

	public function addAccount($uid) {
		$config = C('QUICK_PAY');
		$outuserid = $config['USER_PREFIX'] . sprintf("%014d", $uid);
		
		$account = array('outuserid' => $outuserid,'uid' => $uid,
			'username' => '', 'certno' => '', 'mobile' => '',
			'isverify' => '0', 'create_time'=>NOW_TIME, 'update_time'=>NOW_TIME);
		M('AccountUser')->add($account);

		return $account;
	}

	public function getInfo($uid) {
		$data = $this->where(array('uid'=>$uid))->find();
		if (!$data) {
			$data = $this->addAccount($uid);
		}

		return $data;
	}
}
?>