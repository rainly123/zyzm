<?php 
namespace Home\Controller;
use Think\Controller;
use Think\Log;

class SmsController extends Controller {
	private $url = 'http://sms.pro-group.com.cn/sms.aspx';

    /**
     * @return bool发送验证码
     */
	public function sendcode() {
		if (IS_POST) {
			$mac = md5($_POST['phone'] . $_POST['code'].C('SMSKEY'));
			if ($mac != $_POST['mac']) {
				return false;
			}
			$path = C('LOG_PATH') . 'sms.txt';
			Log::write($_POST['phone'] . ':' . $_POST['code'],
				'SMS-CODE', '', $path);
			$data = array('userid' => 416,  // 企业id
				'account' => 'HY-jmzc', // 发送用户帐号
				'password' => 'Hj1234', // 发送帐号密码
				'mobile' => $_POST['phone'], // 全部被叫号码
				'content' => '您好，您的验证码是：' . $_POST['code'] . '，感谢您的支持与关注！',
				'sendTime' => '', 
				'action' => 'send',
				'checkcontent' => '0',
				'taskName' => '',
				'countnumber' => 1,
				'mobilenumber' => 1,
				'telephonenumber' => 0
			);

			// 短信发送
			$xml = curlPost($this->url,$data);
			Log::write($xml, 'SMS-CODE', '', $path);
			$res = simplexml_load_string($xml);
    	$arr = json_decode(json_encode($res),true);

			if ($arr['returnstatus'] == 'Success') {
				echo true;
			} else {
				echo false;
			}
		}
	}
	public function sendsms() {
		if (IS_POST) {
			$mac = md5($_POST['time'] . C('SMSKEY'));
			if ($mac != $_POST['mac']) {
				return false;
			}
			if (empty($_POST['content']) || empty($_POST['phone'])) {
				return false;
			}
			$path = C('LOG_PATH') . 'sms.txt';
			Log::write($_POST['phone'] . ':' . $_POST['content'], 
				'SMS-CONTENT', '', $path);
			$data = array('userid' => 416,  // 企业id
				'account' => 'HY-jmzc', // 发送用户帐号
				'password' => 'Hj1234', // 发送帐号密码
				'mobile' => $_POST['phone'], // 全部被叫号码
				'content' => $_POST['content'],
				'sendTime' => '', 
				'action' => 'send',
				'checkcontent' => '0',
				'taskName' => '',
				'countnumber' => $_POST['count'],
				'mobilenumber' => $_POST['count'],
				'telephonenumber' => 0
			);
			// 短信发送
			$xml = curlPost($this->url,$data);
			Log::write($xml, 'SMS-CONTENT', '', $path);
			$res = simplexml_load_string($xml);
    	$arr = json_decode(json_encode($res),true);

			if ($arr['returnstatus'] == 'Success') {
				echo true;
			} else {
				echo false;
			}

		}
	}

	public function getinfo() {
		if (IS_GET) {
			$mac = md5($_GET['time'] . C('SMSKEY'));
			if ($mac != $_GET['mac']) {
				return false;
			}
			$data = array('userid' => 416,  // 企业id
				'account' => 'HY-jmzc', // 发送用户帐号
				'password' => 'Hj1234', // 发送帐号密码
				'action' => 'overage',	// 任务名称
			);

			// 短信发送
			$ret = curlPost($this->url,$data);
			header("Content-type:text/xml;charset=utf-8"); 
			echo $ret;
		}
	}
}
?>