<?php 
namespace Api\Controller;
use OAuth2;
class Oauth2Controller extends ApiController{
 	function __construct() {
    parent::__construct();
    if($_GET['appid'])$_SERVER['PHP_AUTH_USER']=$_GET['appid'];
 		if($_GET['appsecret'])$_SERVER['PHP_AUTH_PW']=$_GET['appsecret'];
 		
 		$_SERVER['REQUEST_METHOD']='POST';
   }

 	function Token(){
 		if($_GET['grant_type'])$_POST['grant_type'] = $_GET['grant_type'];
   	    $accessToken = $this->server->handleTokenRequest(OAuth2\Request::createFromGlobals())->getParameters();
   	    $accessToken['token_type']='dreammove';
   	    $this->ajaxReturn($accessToken);
  	}
  	function Resource(){
  		$response = new OAuth2\Response();
   	  	if (!$this->server->verifyResourceRequest(OAuth2\Request::createFromGlobals(), $response, $scopeRequired)) {
    		$this->server->getResponse()->send();
    		die;
		}
		$scope = $this->server->getResourceController()->getAccessTokenData(OAuth2\Request::createFromGlobals(), $response)['scope'];

		$this->ajaxReturn(array('success' => true, 'message' => 'You have accessed Dreammove APIs!'));
  	}
  
  	function Authorize(){
  		$request = OAuth2\Request::createFromGlobals();
  		$response = new OAuth2\Response();
  		if($_GET['access_token'])$_POST['access_token'] = $_GET['access_token'];
  		// validate the authorize request
  		if (!$this->server->validateAuthorizeRequest($request, $response)) {
  			$response->send();
  			die;
  		}
  		// display an authorization form
  		if (empty($_POST)) {
  			exit('
			<form method="post">
  				<label>Do You Authorize TestClient?</label><br />
  				<input type="submit" name="authorized" value="yes">
  				<input type="submit" name="authorized" value="no">
			</form>');
  		}
  		// print the authorization code if the user has authorized your client
  		$is_authorized = ($_POST['authorized'] === 'yes');
  		$server->handleAuthorizeRequest($request, $response, $is_authorized);
  	
  		if ($is_authorized) {
  			// this is only here so that you get to see your code in the cURL request. Otherwise, we'd redirect back to the client
  			$code = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=')+5, 40);
  			$openid = md5($uid.$code);
  			exit("SUCCESS! Authorization Code: $code,the user openid is $openid");
  		}
  		$response->send();
  	}
}
?>