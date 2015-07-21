<?php 
namespace Home\Controller;
use Think\Controller;
class UsersyncController extends Controller {

	  var $key = 'ppjijinj';
    var $iv = 0; //偏移量
   
    // function DES($key = '11001100', $iv=0 ) {
    // //key长度8例如:1234abcd
    //     $this->key = $key;
    //     if( $iv == 0 ) {
    //         $this->iv = $key; //默认以$key 作为 iv
    //     } else {
    //         $this->iv = $iv; //mcrypt_create_iv ( mcrypt_get_block_size (MCRYPT_DES, MCRYPT_MODE_CBC), MCRYPT_DEV_RANDOM );
    //     }
    // }

	public function login() {
		return decrypt('ca8ZGJpqFDRFv8hVAV0/Og==');
	}

	public function checkcode() {
		if ($_POST['code']) {

		}
	}
}
?>