<?php 

namespace Api\Controller;
use OAuth2;
use User\Api\UserApi;
use Think\Controller;
class UserapitestController extends ApiController{
	protected $server;
 	function __construct() {
        parent::__construct();
 		$_SERVER['REQUEST_METHOD']='POST';
 		//$this->server = initial();
    }
    
    function encryptdata(){
    	$username ="xiami121";
    	$password = "a1234567";
    	$encrypttext = $username.'&'.$password;
    	$encrypted = $this->encrypt($encrypttext);
    	//$encrypted = $this->encrypt($encrypttext);
    	echo "源信息：";
    	echo $encrypttext;

    	echo '</br>';
    	echo "传入加密信息：";
        echo $encrypted . '<br>';
        $encrypted = rawurlencode($encrypted);
    	echo $encrypted;
    }
    
    // private function encrypt($encrypttext){
    // 	$key = md5(C('TD_SECRET_KEY')); //to improve variance
    // 	$td = mcrypt_module_open('tripledes', '', 'cbc', '');
    // 	srand((double) microtime() * 1000000); //for sake of MCRYPT_RAND
    // 	$iv_size = mcrypt_enc_get_iv_size($td);
    // 	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    // 	if (mcrypt_generic_init($td, $key, $iv) != -1) {
    // 		/* Encrypt data */
    // 		$encrypttext = mcrypt_generic($td,$encrypttext);
    // 		$encrypttext = rtrim($encrypttext, "\0\4") ;
    // 		mcrypt_generic_deinit($td);
    // 		mcrypt_module_close($td);
    // 		$encrypttext = $iv.$encrypttext;
    // 		return $encrypttext;
    // 	}
    // 	return null;
    // }
    
    public function dmdecrypt(){
    	$encrypttext= rawurldecode($_GET['text']);
        echo $encrypttext; 
        echo '<br>';
    	echo $this->decrypt($encrypttext);
    }
}