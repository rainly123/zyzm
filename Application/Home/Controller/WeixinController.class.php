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
class WeixinController extends HomeController {
	function getConfig(){
		$config = array(
				'APPID' => 'wxc828421ba4322f23',
				'SECRET' => 'ce3cbeb41bf678d724bbbd6d22794b63',
				'STATE' => 'dreammove2015',
				'URL1' => 'https://api.weixin.qq.com/sns/oauth2/access_token',//获取凭证（access_token）
				'URL2' => 'https://api.weixin.qq.com/sns/auth',//检验授权凭证（access_token）是否有效
				'URL3' => 'https://api.weixin.qq.com/sns/userinfo',//获取用户信息
		);
		return $config;
	}
	
	function getWeixinData(){
		$config = $this->getConfig();
		$data['appid'] = $config['APPID'];
		$data['scope'] = "snsapi_login";
		$data['redirect_uri'] = urlencode('http://'. $_SERVER['HTTP_HOST'].U('Weixin/bindWx'));
		$data['state']=  $config['STATE'];
		$this->ajaxReturn($data);
	}
	function checkBindWx(){
		$uid = is_login();
		if (!$uid) {
			$this->ajaxReturn(array('success'=>false, 'info'=> '用户未登录!'));
			return;
		}
		$this->ajaxReturn(D('Weixin')->checkBind());
	}
	
	function checkbindmobile(){
		$mobile = $_GET['mobile'];
				
		if($mobile==null or !is_numeric($mobile)){
			$data['success']=false;
			$data['info']="请提供手机号码！";
			$this->ajaxReturn($data);
		}
		$User = new UserApi;
		$ret = $User->checkMobile($mobile);
		if ($ret == 1) {
			$data['success']=true;
			$data['exist']=false;
		
		}else{
			$data['success']=true;
			$data['exist']=true;
		}
		$this->ajaxReturn($data);
	}
	
	function createnewuser(){
		$User = new UserApi;
		$mobile = $_POST['mobile'];
		$verify = $_POST['verify'];
		$nickname = $_POST['nickname'];
		$headimgurl = $_POST['headimgurl'];
		$code = session($mobile);
		if ($code != $verify) {
			$data['success']=false;
			$data['info']='验证码输入错误！';
			$this->ajaxReturn($data);
		}
		$password = $_POST['password'];
		$repassword = $_POST['repassword'];
		$username =$mobile;
		if($password=='' or $password==NULL )$password = substr($mobile,-6);
	    if($repassword=='' or $repassword==NULL)$repassword = $password;
	    if($password!=$repassword){
	    	$data['success']=false;
	    	$data['info']='两次输入密码不一致！';
	    	$this->ajaxReturn($data);
	    }
	    
		$uid = $User->register($mobile,$password,$mobile);
		if($uid <= 0){
			$data['success']=false;
			$data['register'] = false;
			$data['info']="用户注册失败";
			$this->ajaxReturn($data);
		}else{
			$currentUser = M('UcenterMember')->where(" id = '". $uid . "'")->find();
			$currentUser['openid'] = $_POST['openid'];
			$updatecurrentUser = M('UcenterMember')->save($currentUser);
			/*
			if($update!=1){
				$this->ajaxReturn(array('success'=>false, 'info'=> '该微信未和您的账号取消绑定!'));
			}*/
			if(empty($nickname)){
				$nickname = $mobile;
			}
			
			if(empty($headimgurl)){
				$headimgurl = '/Public/Home/images/default_face/' . rand(1, 14) . '.jpg';
			}
			
			$Member = D('Users');
			$data = array('id'=> $uid,
				'nickname'=> $nickname,
				'status' => 1,
				'photo_url' => $headimgurl,
				'reg_ip'=>get_client_ip(1),
				'create_time' => NOW_TIME,
				'reg_time'=>NOW_TIME);
			$data = $Member->create($data);
			$ret = $Member->add($data);
			if (!$ret) {
				$this->ajaxReturn(array('success'=>false, 'info'=>$Member->getError()));
				return;
			}
		    $detail = array('id'=>$uid, 'phone'=>$mobile, 'create_time'=>NOW_TIME, 'update_time'=>NOW_TIME);
			M('UsersDetail')->add($detail);
			$Member->login($uid);
			$data['success']=true;
			$data['uid'] = $uid;
			$data['register'] = true;
			$data['info']="密码为您手机后六位！";
			$this->ajaxReturn($data);
		}
	}
	
	function bindRemoveWx(){
		$uid = is_login();
		if (!$uid) {
			$this->ajaxReturn(array('success'=>false, 'info'=> '用户未登录!'));
			return;
		}
		$currentUser = M('UcenterMember')->where(" id = '". $uid . "'")->find();
		$currentUser['openid'] = '';
		$update = M('UcenterMember')->save($currentUser);
		if($update==1){
			$this->ajaxReturn(array('success'=>true, 'info'=> '该微信已和您的账号取消绑定!'));
		}
		$this->ajaxReturn(array('success'=>false, 'info'=> '操作失败，请重新操作!'));
	}
	function loginWxLink(){
		if(isMobile() ){// & strpos($_SERVER["HTTP_USER_AGENT"],"MicroMessenger")
			
			$config = $this->getConfig();
			$state = $config['STATE'];
			$redirect_uri= urlencode('http://'. $_SERVER['HTTP_HOST'].U('Weixin/loginWx'));
			$wx_url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$config['APPID'].'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_login&state='.$config['STATE'].'#wechat_redirect';
			$this->ajaxReturn(array('success'=>true, 'info'=> '正用微信登录!','url'=>$wx_url));
		}else{
			$this->ajaxReturn(array('success'=>false, 'info'=> '请用微信登录!'));
		}
	}
	
	function bindWxLink(){
		if(isMobile() ){// & strpos($_SERVER["HTTP_USER_AGENT"],"MicroMessenger")
			$config = $this->getConfig();
			$state = $config['STATE'];
			$redirect_uri= urlencode('http://'. $_SERVER['HTTP_HOST'].U('Weixin/bindWx'));
			$wx_url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$config['APPID'].'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_login&state='.$config['STATE'].'#wechat_redirect';	
			$this->ajaxReturn(array('success'=>true, 'info'=> '正用微信登录!','url'=>$wx_url));
		}else{
			$this->ajaxReturn(array('success'=>false, 'info'=> '请用微信登录!'));
		}
	}
	
	function send_post($url, $post_data) {
		$postdata = http_build_query($post_data);
		$options = array(
				'http' => array(
						'method' => 'POST',
						'header' => 'Content-type:application/x-www-form-urlencoded',
						'content' => $postdata,
						'timeout' => 15 * 60 // 超时时间（单位:s）
				)
		);
		$context = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		return $result;
	}
	
	function loginWx(){
		$weixinModel = D('Weixin');
		//获取微信配置
		$config = $this->getConfig();
		$appid = $config['APPID'];
		$secret = $config['SECRET'];
		//获取返回code
		$code = $_GET['code'];
		//验证回调参数
		$state = $_GET['state'];
		$pid = $_GET['pid'];

		//验证回调参数是否正确，防止无效请求
		if($state ===  $config['STATE']){
			//第二步：通过code获取access_token
			//参数设置
			$postData = array(
					'appid'=>$appid,
					'secret'=>$secret,
					'code'=>$code,
					'grant_type'=>'authorization_code');
			$info = $weixinModel->getRequest($config['URL1'],$postData);
			$openid = $info['openid'];
			if(isset($info['errcode'])){
				//不合法或已过期的code
				$this->ajaxReturn(array('success'=>false, 'info'=> '已过期的code,请重新登录!'));
				return;
			}else{
				$authAccess = array(
						'access_token'=> $info['access_token'],//接口调用凭证
						'openid'=>$info['openid']);//授权用户唯一标识
				//检验授权凭证（access_token）是否有效
				$check_info = $weixinModel->getRequest($config['URL2'],$authAccess);
				if($check_info['errcode']==0){
					//获取用户信息
					$user_info =  $weixinModel->getRequest($config['URL3'],$authAccess);
						
					//用户名
					$username = $user_info['nickname'];
					$count = 0;
					$checkuser = M('UcenterMember')->where(" openid = '". $openid . "'")->find();
					if($checkuser){
						if(D('Users')->login($checkuser['id'])){ //登录用户
							if($pid>0){
								$this->redirect('project/follow', array('id' => $pid));
							}else{
								$this->redirect('/MCenter/index');
							}
                        }
					}else{
							$this->redirect('User/login', array('type' => bind,'userinfo'=>base64_encode(json_encode($user_info))));

					}
						
				}else{
					$this->error('检验授权失败，请重新注册。', U('User/login'));
					return;
				}
			}
		}
	}
	function bindAccount(){
		if ($_GET['password'] & $_GET['username']) {
			/* 调用UC登录接口登录 */
			$user = new UserApi;
			$uid = $user->login($_GET['username'], $_GET['password'] );
			if(0 < $uid){ //UC登录成功
				$Member = D('Users');
				$Member->login($uid);
				if($Member->login($uid)){ //登录用户
						$currentUser = M('UcenterMember')->where(" id = '". $uid . "'")->find();
						if($currentUser['openid']==null || $currentUser['openid']=''){
							$this->ajaxReturn(array('success'=>false, 'info'=> '该账号已绑定其他微信账号!','errorcode'=>1));
						}
						$currentUser['openid'] = $_GET['openid'];
						$update = M('UcenterMember')->save($currentUser);
						if($update==1){
							//$this->redirect('/MCenter/index');
							$this->ajaxReturn(array('success'=>true, 'info'=> '该微信已成功和您的账号绑定!'));		
						}
						$this->ajaxReturn(array('success'=>false, 'info'=> '绑定失败，请重新绑定!','url'=>'/MCenter/index'));
				}
				else {
					$error = $Member->getError();
					if ($error == 0) {
						$this->error('该用户未激活，请联系管理员。');
					}
					$this->ajaxReturn(array('success'=>false, 'info'=> $error));
				}
			}
			else{
				$this->ajaxReturn(array('success'=>false, 'info'=> '用户未登录!!'));
				return;
			}
		}
	}
	function bindWx(){
		$weixinModel = D('Weixin');
		$uid = is_login();
		if (!$uid) {
			$this->ajaxReturn(array('success'=>false, 'info'=> '用户未登录!'));
			return;
		}
		//获取微信配置
		$config = $this->getConfig();
		$appid = $config['APPID'];
		$secret = $config['SECRET'];
		//获取返回code
		$code = $_GET['code'];
		//验证回调参数
		$state = $_GET['state'];
		//验证回调参数是否正确，防止无效请求
		if($state ===  $config['STATE']){
			//第二步：通过code获取access_token
			//参数设置
			$postData = array(
					'appid'=>$appid,
					'secret'=>$secret,
					'code'=>$code,
					'grant_type'=>'authorization_code');
			$info = $weixinModel->getRequest($config['URL1'],$postData);
			$openid = $info['openid'];
			if(isset($info['errcode'])){
				$this->ajaxReturn(array('success'=>false, 'info'=> '已过期的code,请重新登录!'));
				return;
			}else{
				$authAccess = array(
						'access_token'=> $info['access_token'],//接口调用凭证
						'openid'=>$info['openid']);//授权用户唯一标识
				//检验授权凭证（access_token）是否有效
				$check_info = $weixinModel->getRequest($config['URL2'],$authAccess);
				if($check_info['errcode']==0){
					//获取用户信息
					$user_info =  $weixinModel->getRequest($config['URL3'],$authAccess);
			
					//用户名
					$username = $user_info['nickname'];
					$count = 0;
					$checkuser = M('UcenterMember')->where(" openid = '". $openid . "'")->find();
					if($checkuser){
						$nickname = M('users')->where(" id = '". $checkuser['id'] . "'")->getField('nickname');
                        $this->success('该微信账号已绑定昵称为'.$nickname.'的用户!', U('/User/detail'));
					}else{
						$currentUser = M('UcenterMember')->where(" id = '". $uid . "'")->find();
						$currentUser['openid'] = $openid;
						$update = M('UcenterMember')->save($currentUser);
						if($update==1){
							$this->redirect('/User/detail');
							//$this->ajaxReturn(array('success'=>true, 'info'=> '该微信已成功和您的账号绑定!'));
							
						}
						$this->ajaxReturn(array('success'=>false, 'info'=> '绑定失败，请重新绑定!'));
					}
			
				}else{
					$this->error('检验授权失败，请重新注册。', U('User/login'));
					return;
				}
			}
		}
	}
}
?>