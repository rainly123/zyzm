<?php 
namespace Admin\Model;
use Think\Model;
class AccountUserModel extends Model {

	public function addAccount($uid) {
		$outuserid = 'ME2' . sprintf("%014d", $uid);
		
		$account = array('outuserid' => $outuserid,'uid' => $uid,
			'username' => '', 'certno' => '', 'mobile' => '',
			'isverify' => '0', 'create_time'=>NOW_TIME, 'update_time'=>NOW_TIME);
		M('AccountUser')->add($account);

		return $account;
	}
}
?>