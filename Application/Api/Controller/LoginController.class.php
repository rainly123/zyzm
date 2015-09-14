<?php
namespace Api\Controller;
use Think\Controller;
/**
 * Created by PhpStorm.
 * User: 56bd
 * Date: 2015/9/9
 * Time: 13:41
 */
class LoginController extends Controller
{
    /**
     * 单点登录
     */
    function Login()
    {

    }

    /**
     * 接受url参数
     */
    function getUrl()
    {
        $encode=I("token");
        if(empty($encode))
        {
            $this->redirect("Home/Index/index");
        }
        $key=C("key");
        $decode = $this->decrypt($encode,$key);
        $arrys=explode("#",$decode);
        $str1=mb_ereg_replace("[^[a-z0-9]]","",$arrys[0]);//去除token中除数字和字母以外的字符
        $str2=mb_ereg_replace("[^[a-z0-9]]","",$arrys[1]);//去除appid中除数字和字母以外的字符
        $data=array(
            "siId"=>"",
            "appid"=>$str2,
            "token"=>$str1
        );
        $appid=C('appid');
        if(strcmp($appid,$str2)==0)//解析出来的appid和本地的appid进行比较
        {

        }
    }

    /**
     * @param $username
     * @param $password
     * @return int 1存在 0不存在
     * 判断该用户是否存在
     */
    function isExists($username,$password)
    {
        $Ucenter=D('UcenterMember');
        $where=array('username'=>$username,'password'=>$password);
        $count=$Ucenter->where($where)->count();
        if($count>0)
        {
            return 1;
        }
        else
        {
            return 0;
        }
       // $Ucenter->login($username,$password);
    }

    /**
     * @param $str
     * @param $key
     * @return string
     * DES加密
     */
    function encrypt($str,$key) {
        //加密，返回大写十六进制字符串
        $size = mcrypt_get_block_size (MCRYPT_DES, MCRYPT_MODE_ECB );
        $str = $this->pkcs5Pad ( $str, $size );
        return strtoupper( bin2hex( mcrypt_encrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB ) ) );
    }

    /**
     * @param $str
     * @param $key
     * @return string
     * DES解密
     */
    function decrypt($str,$key) {
        //解密
        $strBin = $this->hex2bin( strtolower( $str ) );
        $str = mcrypt_decrypt( MCRYPT_DES, $key, $strBin, MCRYPT_MODE_ECB );
        return $str;
    }

    /**
     * @param $hexData DES加密后的字符串
     * @return string ASCII编码
     */
    function hex2bin($hexData) {
        $binData = "";
        for($i = 0; $i  < strlen ( $hexData ); $i += 2) {
            $binData .= chr ( hexdec ( substr ( $hexData, $i, 2 ) ) );
        }
        return $binData;
    }

    function pkcs5Pad($text, $blocksize) {
        $pad = $blocksize - (strlen ( $text ) % $blocksize);
        return $text . str_repeat ( chr ( $pad ), $pad );
    }

    function pkcs5Unpad($text) {
        $pad = ord ( $text {strlen ( $text ) - 1} );
        if ($pad > strlen ( $text )) return false;

        if (strspn ( $text, chr ( $pad ), strlen ( $text ) - $pad ) != $pad)   return false;

        return substr ( $text, 0, - 1 * $pad );
    }


}