<?php 

namespace Api\Controller;
use OAuth2;
use User\Api\UserApi;
use Think\Controller;
class UserapiController extends ApiController{
 	function __construct() {
    parent::__construct();
 		$_SERVER['REQUEST_METHOD']='POST';
  }
  
  private function checkscope($path,$scope){
		return true;
		// $projectInfoModel = D('ProjectInfo');//股权项目接口API model
		// return $projectInfoModel->checkscope($path,$scope);
	}

  public function getuserinfo() {
  	if (!$this->server->verifyResourceRequest(\OAuth2\Request::createFromGlobals())) {
  		$this->server->getResponse()->send();
  		die;
  	}
  	$scope = $this->server->getResourceController()->getAccessTokenData(\OAuth2\Request::createFromGlobals(), $response)['scope'];
  	if($this->checkscope($_SERVER['PATH_INFO'],$scope)){
  		
  		$encrypted=rawurldecode($_GET['text']);
  		$data = $this->decrypt($encrypted);
      $this->ajaxReturn($this->getmoreinfo($data));
    } else {
  		$data['errorcode'] = 40001;
  		$data['errmsg'] = "Invalid scope";
  		$this->ajaxReturn($data);
  	}
  }
  	
	private function getmoreinfo($encrypted_data){
		$dataarray = explode('&', $encrypted_data);
		$user = new UserApi;
		$username = rtrim($dataarray[0], "\0\4") ;//$dataarray[0];
		$password = rtrim($dataarray[1], "\0\4") ;//$dataarray[1];
    
		$uid = $user->login($username,$password);

		if($uid>0){
			$userinfo = M('UcenterMember')->where('id='.$uid)->field('username,email,mobile')->find();
			$encrypttext = $userinfo['username'].'&'.$userinfo['email'].'&'.$userinfo['mobile'];
			$data['success'] = true;
			$data['info'] = rawurlencode($this->encrypt($encrypttext));
		}
		else{
			$data['success'] = false;
			$data['errorcode'] = 40002;
			$data['errmsg'] = "Invalid username password";
		}
		return $data;
	}

}
?>