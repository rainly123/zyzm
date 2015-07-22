<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use User\Api\UserApi; 
use Think\Image;
use Think\Log;

/**
 * 用户控制器
 * 包括用户中心，用户登录及注册
 */
class UserController extends HomeController {

	/* 登录页面 */
	public function login($username = '', $password = '') {
		if (IS_POST) {
			/* 调用UC登录接口登录 */
			$user = new UserApi;
			$uid = $user->login($username, $password);

			if(0 < $uid){ //UC登录成功
				/* 登录用户 */
				$Member = D('Users');
				if($Member->login($uid)){ //登录用户
					//TODO:跳转到登录前页面
					$url = cookie('login_url');
					if (empty($url)) {$url = U('Index/index');}
					$this->success('登录成功！',$url);
				} else {
					$error = $Member->getError();
					if ($error == 0) {
						$this->error('该用户未激活，请联系管理员。');
					}
					$this->error($Member->getError());
				}
			} else { //登录失败
				switch($uid) {
					case -1: $error = '用户不存在或被禁用！'; break; //系统级别禁用
					case -2: $error = '密码错误！'; break;
					default: $error = '未知错误！'; break; // 0-接口参数错误（调试阶段使用）
				}
				$this->error($error);
			}
		} else {
			if (is_login()) {
				$this->redirect('Index/index');
			}

			$url = $_SERVER['HTTP_REFERER'];
			$host = $_SERVER['HTTP_HOST'];
			cookie('login_url', null);
			if (stristr($url, $host)) {
				if (!(stristr($url, 'logout') || stristr($url, 'changepwd')) && empty($_GET['goback'])) {
					cookie('login_url', $url, 600);
				}
			}
			$this->pageTitle="登录";
			$this->display();
		}
	}
	
	/* 注册页面 */
	public function quickregister( $mobile = '', $verify = '',$password= '',$repassword= ''){
		$mobile = $_POST['mobile'];
		$verify = $_POST['verify'];
		$password = $_POST['password'];
		$repassword = $_POST['repassword'];
		$username =$mobile;
		if($password=='' or $password==NULL )$password = substr($mobile,-6);
	    if($repassword=='' OR $repassword==NULL)$repassword = $password;
	    if($password!=$repassword){
	    	$data['success']=false;
	    	$data['info']='两次输入密码不一致！';
	    	$this->ajaxReturn($data);
	    }
		if(!C('USER_ALLOW_REGISTER')){
			$this->error('暂未开放注册。请联系客服。');
		}
		/* 检测验证码 */
		$code = session($mobile);
		if ($code != $verify) {
			$data['success']=false;
			$data['info']='验证码输入错误！';
			$this->ajaxReturn($data);
		}
		
		
	
	
			/* 调用注册接口注册用户 */
			$User = new UserApi;
			$uid = $User->register($username, $password, $mobile);
	
			if(0 < $uid){ //注册成功
	
				$Member = D('Users');
				$data = array('id'=> $uid,
						'nickname'=> $username,
						'status' => 1,
						'photo_url' => '/Public/Home/images/default_face/' . rand(1, 14) . '.jpg',
						'reg_ip'=>get_client_ip(1),
						'create_time' => NOW_TIME,
						'reg_time'=>NOW_TIME);
				$data = $Member->create($data);
				$ret = $Member->add($data);
				if (!$ret) {
					$this->ajaxReturn(array('status'=>'0', 'info'=>$Member->getError()));
					return;
				}
	
				$detail = array('id'=>$uid, 'phone'=>$mobile, 'create_time'=>NOW_TIME, 'update_time'=>NOW_TIME);
				M('UsersDetail')->add($detail);
	
				$Member->login($uid);
	
				$this->success('恭喜您，注册成功！', U('Index/index'));
			} else { //注册失败，显示错误信息
				$this->error($this->showRegError($uid));
			}
	}
	
	/* 注册页面 */
	public function register($username = '', $password = '', $repassword = '', $mobile = '', $verify = ''){
    
    if(!C('USER_ALLOW_REGISTER')){
        $this->error('暂未开放注册。请联系客服。');
    }
		if(IS_POST){ //注册用户
			/* 检测验证码 */
			$code = session($mobile);
			if ($code != $verify) {
				$this->error('验证码输入错误！');
				return;
			}

			/* 检测密码 */
			if($password != $repassword){
				$this->error('密码和重复密码不一致！');
				return;
			}		

			/* 调用注册接口注册用户 */
      $User = new UserApi;
			$uid = $User->register($username, $password, $mobile);

			if(0 < $uid){ //注册成功

   			$Member = D('Users');
				$data = array('id'=> $uid, 
					'nickname'=> $username, 
					'status' => 1,
					'photo_url' => '/Public/Home/images/default_face/' . rand(1, 14) . '.jpg',
					'reg_ip'=>get_client_ip(1), 
					'create_time' => NOW_TIME,
					'reg_time'=>NOW_TIME);
				$data = $Member->create($data);
				$ret = $Member->add($data);
				if (!$ret) {
					$this->ajaxReturn(array('status'=>'0', 'info'=>$Member->getError()));
					return;
   			}

				$detail = array('id'=>$uid, 'phone'=>$mobile, 'create_time'=>NOW_TIME, 'update_time'=>NOW_TIME);
				M('UsersDetail')->add($detail);

   			$Member->login($uid);
				
				$this->success('恭喜您，注册成功！', U('Index/index'));
			} else { //注册失败，显示错误信息
				$this->error($this->showRegError($uid));
			}

		} else { //显示注册表单
			if (is_login()) {$this->redirect('Index/index');}
			
			$this->pageTitle = "用户注册";
			$this->display();
			
		}
	}

	/*忘记密码*/
	public function forget() {
		if (IS_POST) {
			$mobile = $_POST['mobile'];
			$password = $_POST['password'];

			if (empty($mobile)) {$this->error('请输入手机号码');}
			if (empty($password)) {$this->error('请输入新密码');}
			$code = session($mobile);
			if ($code != $_POST['code']) {
				$this->error('验证码输入错误！');
				return;
			}

			$user = M('UcenterMember')->where(array('mobile'=>$mobile))->find();

			if ($user) {
				$Api = new UserApi();
				$data = array('password'=>$password);
	      $res = $Api->updatePwd($user['id'], $data);
	      if($res['status']){
	          $this->success('密码修改成功！', U('login?goback=1'));
	      }else{
	          $this->error($res['info']);
	      }
			} else {
				$this->error('该手机号码不存在');
			}

		} else {
			$this->pageTitle = "找回密码";
			$this->display('forget');
		}
	}
	
	/*修改密码*/
	public function modifypwd() {
		if (!is_login() ) {
			$this->error( '您还没有登陆',U('User/login'));
		}
        //获取参数
        $uid        =   is_login();
        $password   =   I('post.old');
        $repassword = I('post.repassword');
        $data['password'] = I('post.password');
        if(empty($password)){
        	$returndata['success'] = false;
        	$returndata['info'] = '请输入原密码';
        	$this->ajaxReturn($returndata);
        }
        if(empty($repassword)){
        	$returndata['success'] = false;
        	$returndata['info'] = '请输入确认密码';
        	$this->ajaxReturn($returndata);
        }
        if(empty($data['password'])){
        	$returndata['success'] = false;
        	$returndata['info'] = '请输入密码';
        	$this->ajaxReturn($returndata);
        }

        if($data['password'] !== $repassword){
        	$returndata['success'] = false;
        	$returndata['info'] = '您输入的新密码与确认密码不一致';
        	$this->ajaxReturn($returndata);
        }

        $Api = new UserApi();
        $res = $Api->updateInfo($uid, $password, $data);
        if($res['status']){
        	$returndata['success'] = true;
        	$returndata['info'] = '修改密码成功';
        	$this->ajaxReturn($returndata);
        }else if ($res['info'] < 0){
        	$returndata['success'] = false;
        	$returndata['info'] = $res['info'];
        	$this->ajaxReturn($returndata);
        }else{
        	$returndata['success'] = false;
        	$returndata['info'] = $res['info'];
        	$this->ajaxReturn($returndata);
        }
	}
	

	/* 退出登录 */
	public function logout(){
		if(is_login()){
			D('Users')->logout();
			$this->redirect('Index/index');
		} else {
			$this->redirect('User/login');
		}
	}

	/*请求手机验证码*/
	public function sendsms() {
		if (IS_POST) {
			$phone = $_POST['phone'];

			$needcheck = $_POST['ischeck'];
			if (empty($phone)) {
				$this->error('请填写手机号码');
			} else {
				$User = new UserApi;
				$ret = $User->checkMobile($phone);
				if ($needcheck && $ret == 1) {
					$this->error('该手机号码不存在。');
				} else if (!$needcheck && $ret <= 0) {
					$this->error('该手机号码已经注册。');
				}
				$code = rand(100000,999999);
				$mac = md5($phone . $code .C('SMSKEY'));
				$data = array('phone'=>$phone, 'code'=>$code, 'mac'=>$mac);
				$url = 'http://'.localhost.'/sms/sendcode.html';
				$ret = curlPost($url, $data);

				if ($ret) {
					session($phone, $code);
					$this->success('发送成功');
				} else {
					$this->error('短信发送失败，请重试。');
				}
			}
		}
	}

	/*完善个人资料*/
	public function detail() {
		$uid = is_login();
		if (!$uid) {
			$this->error('您还没有登录，请先登录', U('User/login'));
		}

		if (IS_POST) {
			// 登录信息
			$user = $_POST['user'];
			$detail = $_POST['detail'];
			$detail['province'] = $_POST['province'];
			$detail['city'] = $_POST['city'];

			if (empty($user['nickname'])) {$this->error('昵称不能为空');}
			$ret = M('UsersDetail')->find($id);

			$detail['id'] = $uid;
			if ($ret) {
				M('UsersDetail')->save($detail);
			} else {
				M('UsersDetail')->add($detail);
			}
			$user["id"] = $uid;
			M('Users')->save($user);
			// 更新缓存中的昵称
			memberupdate($uid, $user['nickname'], 1);
			$this->success("用户信息修改成功。");
		} else {

			$this->user = M('Users')->find($uid);
			$this->detail = M('UsersDetail')->find($uid);
			$this->userauth = M('user_auth')->where(array('uid'=>$uid,'auth_id'=>1))->find();
			$this->pageTitle = "个人信息";
			$this->display('detail');
		}
	}

	/*申请领投人*/
	public function applylead () {
		$id = is_login();
		if (!$id) {
			$this->error('您还没有登录，请先登录。', U('User/login'));
			return;
		}
		if (IS_POST) {
			$focus = $_POST['focus'];

			if(empty($focus)) {$this->error('请选择您感兴趣的领投领域。');}
			if(empty($_POST['resume'])) {$this->error('请完善您的个人简介。');}
			//领投资格
			$ret = M('user_auth')->where(array('uid'=>$id,'auth_id'=>1,'status'=>9))->find();
			if(!$ret){
				$this->error('您还没有进行实名认证，不能申请领投人。请先进行实名认证。', U('User/savecenter'));
			}
			
			$data = array('resume' => $_POST['resume'], 
				'focus' => arr2str($focus), 
				'id' => $id);

			M('UsersDetail')->save($data);
			
			//保存用户类别
			$auth_id = 3;
			$ret = M('user_auth')->where(array('uid'=>$id,'auth_id'=>$auth_id))->find();

			if (!$ret) {
				$data = array(
						'uid'=>$id,
						'auth_id'=>$auth_id);
				 
				M('user_auth')->add($data);
			} else {
				if ($ret['status'] != 9) {
					$ret['status'] = 0;
					M('user_auth')->save($ret);
				} 
			}
			
			$this->success('领投信息提交成功！');
		} else {
			$userdetail = M('UsersDetail')->find($id);
			$userauth = M('user_auth')->where(array('uid'=>$id,'auth_id'=>3))->find();
			
			if ($userauth['status'] == '1') {
				$describe = M('Users')->field('investor_content')->find($id);
				$this->describe = $describe['investor_content'];
			}
			
			$this->industry = get_code('industry');
			$this->userdetail = $userdetail;
			$this->userauth = $userauth;

			$this->display('applylead');	
		}
	}

	/*配送地址列表*/
  public function addrlist() {
  	$uid = is_login();
		if (!$uid) {
			$this->error('您还没有登录，请先登录', U('User/login'));
		}

		$address = M('CustomAddress')->where(array('uid'=>$uid, 'status'=>array('egt', 0)))->order('update_time desc')->select();
		$this->assign('address', $address);

		$this->pageTitle = "配送地址";
  	$this->display('addrlist');
  }

  /*设置默认配送地址*/
  public function defaultaddr($addId){
		if (empty($addId)) {
			$this->error('关键参数未获得');
		}
		$uid = is_login();
		$modelCustomAddress = M('CustomAddress');

		$modelCustomAddress->where(array('uid'=>$uid,'status'=>array('gt',-1)))->save(array('status'=>0));
		$result = $modelCustomAddress->where(array('id'=>$addId))->save(array('status'=>1));
		
		if ($result ==false) {
			$this->error('处理失败，请联系管理员:service@dreammove.cn');
		}else{
			$this->success('设置成功');
		}
	}

	/*删除指定的配送地址*/
	public function deleteaddr($addId){
		if (empty($addId)) {
			$this->error('关键参数未获得');
		}
		$modelCustomAddress = M('CustomAddress');
		//$result = $modelCustomAddress->where(array('id'=>$addId))->delete();
		
		$result = $modelCustomAddress->where(array('id'=>$addId))->save(array('status'=>-1));
		if ($result ==false) {
			$this->error('处理失败，请联系管理员:service@dreammove.cn');
		}else{
			$this->success('删除成功');
		}
	}

	/*修改配送地址*/
  public function modify_addr() {
  	$uid = is_login();
  	if (IS_GET) {
  		$id = $_GET['id'];
  		if ($id) {
  			$detail = M('CustomAddress')->where(array('id'=>$id, 'uid'=>$uid))->find();

  			$this->assign('detail', $detail);
  		}
  		$this->display('address');
  	} else if (IS_POST) {
  		$detail = $_POST;
  		$model = M('CustomAddress');
  		if (empty($_POST['id'])) {
  			$detail['status'] = 0;
  			$detail['uid'] = $uid;
  			$detail['create_id'] = $uid;
  			$detail['create_time'] = NOW_TIME;
  			$detail['update_id'] = $uid;
  			$detail['update_time'] = NOW_TIME;
  			M('CustomAddress')->add($detail);
	  		$this->success('新地址添加成功。');
  		} else {
  			$data = $model->find($detail['id']);
  			$detail['update_time'] = NOW_TIME;
  			if (!$data || $data['uid'] != $uid) {
  				$this->error('非法操作。。');
  			}
  			$this->pageTitle = "修改地址";
	  		M('CustomAddress')->save($detail);
	  		$this->success('地址更新成功。');
  		}
  	}
  }
  public function checklogin(){
  	$uid = is_login();
  	if($uid>0){
  		$data['success'] = true;
  		$data['info'] = $uid;
  	}else{
  		$data['success'] = false;
  		$data['info'] = "用户未登陆";
  	}
  	$this->ajaxReturn($data);
  }
  /*安全中心*/
  public function savecenter() {
  	$uid = is_login();
  	if (!$uid) {
			$this->error('您还没有登录，请先登录', U('User/login'));
		}
  	$this->userauth = M('user_auth')->where(array('uid'=>$uid,'auth_id'=>1))->find();
  	$User = new UserApi;
  	$userinfo = $User->info($uid);
  	if ($userinfo && $userinfo[3]){
  		$this->phone=substr($userinfo[3], 0,3) . '****' . substr($userinfo[3], -4);
  	}
  	$this->pageTitle = "安全中心";
  	$this->display('savecenter');
  }
  
  /*实名认证api*/
  public function realnameapi() {
  	$uid = is_login();
  	if (!$uid) {
  		$data['success']=false;
  		$data['info']='您还没有登录，请先登录！';
  		$this->ajaxReturn($data);
  		//$this->error('您还没有登录，请先登录', U('User/login'));
  	}
  	if (IS_GET) {
  		$this->userauth = M('user_auth')->where(array('uid'=>$uid,'auth_id'=>1, 'status'=>9))->find();
  
  		if (!empty($this->userauth)) {
  			$detail = M('UsersDetail')->field('name, card_id')->find($uid);
  			if ($detail) {
  				$detail['card_id'] = substr($detail['card_id'], 0,4). "*****" . substr($detail['card_id'], -6);
  			}
  
  			$this->detail = $detail;
  		}
  
  		$data['success']=false;
  		$data['info']='您曾实名认证了！';
  		$this->ajaxReturn($data);
  	} else {
  			
  		$detail['id'] = $uid;
  		$detail['name'] = $_POST['name'];
  		$detail['card_id'] = strtoupper($_POST['card_id']);
  			
  		if (empty($detail['name']) || empty($detail['card_id'])) {
  			$data['success']=false;
  			$data['info']='请输入真实姓名和身份证号码。';
  			$this->ajaxReturn($data);
  		} else {
  			$ret = validation_filter_id_card($detail['card_id']);
  			if (!$ret) {
  				$data['success']=false;
  				$data['info']='身份证号码不合法。';
  				$this->ajaxReturn($data);
  			}
  		}
  		
  		$user = M('UsersDetail')->where(array('card_id'=>$detail['card_id']))->find();
  		
  		if ($user && $user['id'] !=$uid) {
  			$data['success']=false;
  			$data['info']='该身份证已绑定聚募账号，一个身份证号只能绑定一个聚募账号。';
  			$this->ajaxReturn($data);
  		}

  		// TODO 调用实名认证接口
  		$ret = $this->savecheck($detail['name'], $detail['card_id']);
  		if ($ret['status'] == 0) {
  			$data['success']=false;
  			$data['info']= $ret['info'].'第三方认证失败';
  			$this->ajaxReturn($data);
  		}
  
  		$detail['update_id'] = $uid;
  		$detail['udpate_time'] = NOW_TIME;
  
  		$data = M('UsersDetail')->find($uid);
  		if ($data) {
  			M('UsersDetail')->save($detail);
  		} else {
  			$detail['create_id'] = $uid;
  			$detail['create_time'] = NOW_TIME;
  			M('UsersDetail')->add($detail);
  		}
  
  		$data = array('uid'=>$uid,'auth_id'=>0);
  		$auth = M('user_auth')->where($data)->find();
  		if (!$auth) {
  			$data['status']= 9;
  			M('user_auth')->add($data);
  		} else if ($auth['status'] != 9) {
  			$auth['status']= 9;
  			M('user_auth')->save($auth);
  		}
  		unset($data['status']);
  		$data['auth_id'] = 1;
  		$auth = M('user_auth')->where($data)->find();
  		if (!$auth) {
  			$data['status']= 9;
  			M('user_auth')->add($data);
  		} else if ($auth['status'] != 9) {
  			$auth['status']= 9;
  			M('user_auth')->save($auth);
  		}
  		$data['success']=true;
  		$data['info']='实名认证成功！';
  		$this->ajaxReturn($data);
  	}
  }

  /*实名认证*/
  public function realname() {
  	$uid = is_login();
  	if (!$uid) {
			$this->error('您还没有登录，请先登录', U('User/login'));
		}
		if (IS_GET) {
			$this->userauth = M('user_auth')->where(array('uid'=>$uid,'auth_id'=>1, 'status'=>9))->find();

	  	if (!empty($this->userauth)) {
	  		$detail = M('UsersDetail')->field('name, card_id')->find($uid);
	  		if ($detail) {
	  			$detail['card_id'] = substr($detail['card_id'], 0,4). "*****" . substr($detail['card_id'], -6);
	  		}

	  		$this->detail = $detail;
	  	}

  		$this->pageTitle = "实名认证";
	  	$this->display('realname');
		} else {
			
			$detail['id'] = $uid;
			$detail['name'] = $_POST['name'];
			$detail['card_id'] = strtoupper($_POST['card_id']);
			
			if (empty($detail['name']) || empty($detail['card_id'])) {
				$this->error('请输入真实姓名和身份证号码。');
			} else {
				$ret = validation_filter_id_card($detail['card_id']);
				if (!$ret) {
					$this->error('身份证号码不合法。');
				}
			}

			$user = M('UsersDetail')->where(array('card_id'=>$detail['card_id']))->find();

			if ($user && $user['id'] !=$uid) {
				$this->error('该身份证已绑定聚募账号，一个身份证号只能绑定一个聚募账号。');
			}

			// TODO 调用实名认证接口
			$ret = $this->savecheck($detail['name'], $detail['card_id']);

			if ($ret['status'] == 0) {
				$this->error($ret['info']);
			}

			$detail['update_id'] = $uid;
			$detail['udpate_time'] = NOW_TIME;

			$data = M('UsersDetail')->find($uid);
			if ($data) {
				M('UsersDetail')->save($detail);
			} else {
				$detail['create_id'] = $uid;
				$detail['create_time'] = NOW_TIME;
				M('UsersDetail')->add($detail);
			}

			$data = array('uid'=>$uid,'auth_id'=>0);
    	$auth = M('user_auth')->where($data)->find();
    	if (!$auth) {
    		$data['status']= 9;
    		M('user_auth')->add($data);	
    	} else if ($auth['status'] != 9) {
    		$auth['status']= 9;
    		M('user_auth')->save($auth);
    	}
			unset($data['status']);
			$data['auth_id'] = 1;
			$auth = M('user_auth')->where($data)->find();
			if (!$auth) {
    		$data['status']= 9;
    		M('user_auth')->add($data);	
    	} else if ($auth['status'] != 9) {
    		$auth['status']= 9;
    		M('user_auth')->save($auth);
    	}

    	$this->success('实名认证成功！');
		}	
  }

  /*实名认证*/
  private function savecheck($name, $cardid) {
  	$config = C('SAVE_CHECK');

  	$clientDate = time_format(NOW_TIME, 'YmdHis');
  	$head = array('version'=> '01', 'msgType'=>'0001', 'chanId'=>'99', 
  		'merchantNo'=>$config['MERCHANTID'], 'clientDate'=>time_format(NOW_TIME, 'YmdHis'), 
  		'tranFlow'=> $config['MERCHANTID'] . $clientDate . rand(10000, 999999), 'tranCode'=>'SC0002',
  		'respCode'=>'', 'respMsg'=>'');

  	$body = array('idName'=>$name, 'idNum'=>$cardid);
  	include_once(APP_PATH . '/BaoyiPay/BaoyiPay.php');
  	$xml = to_xmlstring(array('head'=>$head, 'body'=>$body));
		
		$mac = md5($xml . $config['MERKEY']);

		$this->checklog($xml . '&' . $mac, 1);
		$para = array('xml'=>$xml, 'mac'=>$mac);
		$text = getHttpResponsePost($config['URL'], $para);
		$this->checklog($text, 2);
		$para = md5Response($text, $config['MERKEY']);

		if (!$para) {
			//$this->ajaxReturn(array('status'=>0, 'info'=>'信息错误'));
			return array('status'=>0, 'info'=>'信息错误');
		}
		$data = xml2arr($para['xml']);
		if ($data['head']['respCode'] == 'C000000000') {
			return array('status'=>1, 'info'=>'');
		} else {
			return array('status'=>0, 'info'=>$data['head']['respMsg']);
		}
  }

  private function checklog($message, $type = 1) {
  	$path = C('LOG_PATH') . 'checkcard' . time_format(NOW_TIME, 'Ym') . '.txt';
  	if ($type == 1) {
  		Log::write($message, 'OUT','', $path);
  	} else {
  		Log::write($message, 'IN','', $path);	
  	}
  	
  }

   /*修改密码提交*/
  public function changepwd(){
		if ( !is_login() ) {
			$this->error( '您还没有登陆',U('User/login'));
		}
    if (IS_POST) {
        //获取参数
        $uid        =   is_login();
        $password   =   I('post.old');
        $repassword = I('post.repassword');
        $data['password'] = I('post.password');
        empty($password) && $this->error('请输入原密码');
        empty($data['password']) && $this->error('请输入新密码');
        empty($repassword) && $this->error('请输入确认密码');

        if($data['password'] !== $repassword){
            $this->error('您输入的新密码与确认密码不一致');
        }

        $Api = new UserApi();
        $res = $Api->updateInfo($uid, $password, $data);
        if($res['status']){
            $this->success('修改密码成功！', U('savecenter'));
        }else if ($res['info'] < 0){
        	$message = $this->showRegError($res['info']);
          $this->error($message);
        }else{
        	$this->error($res['info']);
        }
    }else{
  		$this->pageTitle = "修改密码";
      $this->display();
    }
  }

	/*修改注册手机号*/
  public function changephone() {
  	$uid = is_login();
  	if ( !$uid ) {
			$this->error( '您还没有登陆',U('User/login'));
		}

    if (IS_POST) {
    	$password = $_POST['password'];
    	$phone = $_POST['mobile'];
    	$code = session($phone);
    	
    	if ($_POST['code'] != $code) {
    		$this->error('输入验证码不正确');
    	}
    	$data=array('mobile'=>$_POST['mobile'], 'password'=>$password);
			$Api = new UserApi();
      $res = $Api->updateInfo($uid, $password, $data);

      if($res['status']){
        $this->success('手机号码更改成功。');
      }else if ($res['info'] < 0){
      	$message = $this->showRegError($res['info']);
        $this->error($message);
      }else{
      	$this->error($res['info']);
      }
    } else {
  		$this->pageTitle = "修改手机号码";
    	$this->display('changephone');
    }
  }

	/*验证手机号码是否存在 （存在正常、不存在异常）*/
	public function checkMobile() {
		if (IS_POST) {
			$name = I('post.name');
			$param = I('post.param');

			if ($name == 'mobile') {

				$User = new UserApi;
				$ret = $User->checkMobile($param);
				if ($ret == 1) {
					$this->error('该手机号码不存在');
					return;
				}
			}
		}
	}

	/*注册信息验证*/
	public function validateRegister() {
		if (IS_POST) {
			$name = I('post.name');
			$param = I('post.param');

			if ($name == 'username' || $name == 'mobile') {

				$User = new UserApi;
				$ret = $User->checkregister($param);
				if ($ret) {
					$name = $name == 'username' ? '用户名' : '手机号码';
					$this->ajaxReturn(array('status'=>'0', 'info'=> $name . '已被占用'));
				} else {
					$this->ajaxReturn(array('status'=>'1'));
				}
			} else if ($name == 'verify') {
				if(!($param)){
					$this->ajaxReturn(array('status'=>'0', 'info'=>'验证码输入错误'));
				} else {
					$this->ajaxReturn(array('status'=>'1', 'info'=>''));
				}
			}
		}
	}
	// 用户头像修改
	public function changePhoto() {
		if (IS_POST) {
			$id = is_login();
			$basepath = substr($_POST['basepath'], 1);
			$image = new Image();

			$image->open($basepath);
			$image->crop($_POST['w'],$_POST['h'],$_POST['x'],$_POST['y'], 200, 200);
			$last = strrpos($basepath, '/') + 1;
			$ext = substr($basepath, strrpos($basepath, '.'));
			$path = substr($basepath, 0, $last);
			$filename = $path . 'crop_' . $id . $ext;
			$image->save($filename, null, 100, false);
			$filename = '/' . $filename.'?t=' . NOW_TIME;

			$user = array('id'=>is_login(), 
				'photo'=>$_POST['photo'], 'photo_url'=>$filename);
			M('Users')->save($user);

			memberupdate($id, $user['photo_url']);

			$ret = array('status' => 1, 'info'=>'头像更改成功！', 
				'photo_url'=>($filename), 'photo'=>$_POST['photo']);
			$this->ajaxReturn($ret);

			$this->success('头像更改成功!');
		} else {
			$this->display('changePhoto');
		}
	}

	/**
	 * 获取用户注册错误信息
	 * @param  integer $code 错误编码
	 * @return string        错误信息
	 */
	private function showRegError($code = 0){
		switch ($code) {
			case -1:  $error = '用户名长度必须在16个字符以内！'; break;
			case -2:  $error = '用户名被禁止注册！'; break;
			case -3:  $error = '用户名被占用！'; break;
			case -4:  $error = '密码长度必须在6-30个字符之间！'; break;
			case -5:  $error = '邮箱格式不正确！'; break;
			case -6:  $error = '邮箱长度必须在1-32个字符之间！'; break;
			case -7:  $error = '邮箱被禁止注册！'; break;
			case -8:  $error = '邮箱被占用！'; break;
			case -9:  $error = '手机格式不正确！'; break;
			case -10: $error = '手机被禁止注册！'; break;
			case -11: $error = '手机号被占用！'; break;
			default:  $error = '未知错误';
		}
		return $error;
	}
}
