<?php
namespace Api\Controller;
use Think\Controller;

/**
 * 前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class ApiController extends Controller {

protected $server;

protected function token(){
	$server->handleTokenRequest(\OAuth2\Request::createFromGlobals())->send();
}
	/* 空操作，用于输出404页面 */
	public function _empty(){
		$this->redirect('Index/index');
	}

  /*用户必须登录后方可查看*/
  function __construct(){
    parent::__construct();

  }

  protected function _initialize(){
    $dsn      = 'mysql:dbname='.C('DB_NAME').';host='.C('DB_HOST');
		$username = C('DB_USER');
		$password = C('DB_PWD');
		Vendor('oauth2-server-php.src.OAuth2.Autoloader');
		$oauth2 = new \OAuth2\Autoloader();
		
		$oauth2::register();
		// $dsn is the Data Source Name for your database, for exmaple "mysql:dbname=my_oauth2_db;host=localhost"
		$storage = new \OAuth2\Storage\Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));
		
		// Pass a storage object or array of storage objects to the OAuth2 server class
		$this->server = new \OAuth2\Server($storage);

		// Add the "Client Credentials" grant type (it is the simplest of the grant types)
		$this->server->addGrantType(new \OAuth2\GrantType\ClientCredentials($storage));

		// Add the "Authorization Code" grant type (this is where the oauth magic happens)
		$this->server->addGrantType(new \OAuth2\GrantType\AuthorizationCode($storage));
  }

  private function pkcs5Pad($text) {
    $size = mcrypt_get_block_size(MCRYPT_DES, MCRYPT_MODE_CBC);
    $pad = $size - (strlen ( $text ) % $size);
    return $text . str_repeat ( chr ( $pad ), $pad );
  }


  protected function encrypt($str) {
  	//加密，返回大写十六进制字符串
    $key = C('TD_SECRET_KEY');
    
    $str = $this->pkcs5Pad($str);
    $str = mcrypt_cbc(MCRYPT_DES, $key, $str, MCRYPT_ENCRYPT, $key);
    $str = base64_encode($str);

    return $str;
  }
    
  protected function decrypt($text) {
  	//解密
    $key = C('TD_SECRET_KEY');
    $str = base64_decode($text);

    $str = mcrypt_cbc( MCRYPT_DES, $key, $str, MCRYPT_DECRYPT, $key);
    
    $str = $this->pkcs5Unpad($str);
    return  $str;
  }

	protected function pkcs5Unpad($text) {
    $pad = ord ( $text {strlen ( $text ) - 1} );  
    if ($pad > strlen ( $text )) return false;  

    if (strspn ( $text, chr ( $pad ), strlen ( $text ) - $pad ) != $pad)   
        return false;    

    return substr ( $text, 0, - 1 * $pad );  
  }

  // 验证访问和合法性
  protected function verifyRequest() {
    // 验证授权是否通过
    if (!$this->server->verifyResourceRequest(\OAuth2\Request::createFromGlobals())) {
      $this->server->getResponse()->send();
      die;
    }
    $scope = $this->server->getResourceController()->getAccessTokenData(\OAuth2\Request::createFromGlobals(), $response)['scope'];
    if(!$this->checkscope($_SERVER['PATH_INFO'],$scope)){
      $data['errorcode'] = 40001;
      $data['errmsg'] = "Invalid scope";
      $this->ajaxReturn($data);
      exit();
    }
  }

}