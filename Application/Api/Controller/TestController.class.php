<?php 
namespace Api\Controller;
use Think\Controller;
use Think\Log;

class TestController extends Controller {

    public function unionpay() {
        $data = json_encode($_POST);
        Log::write($data);
    }

    public function test() {
        echo substr(1234567890, -6);
    }

    public function login() {
        
        $para = array('action'=>'PPLOGIN', 'username'=>'username',
            'password'=>$this->encrypt('abcdefghijk'),'iphone'=>'18658170800', 'time'=>NOW_TIME);
        include_once(APP_PATH . '/BaoyiPay/BaoyiPay.php');
        $key = '62def3a609f535dbc4ba6ac0471942dc';
        $xml = to_xmlstring($para);

        $mac = hash('sha256',$xml.$key);

        $para = array('xml'=>$xml, 'mac'=>$mac);

        $url = 'http://test.dreammove.cn/test/callback.html';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
        curl_setopt($curl,CURLOPT_POST,true); // post传输数据
        curl_setopt($curl,CURLOPT_POSTFIELDS,$para);// post传输数据
        $responseText = curl_exec($curl);
    
        curl_close($curl);

        echo $responseText;
    }


    public function pplogin() {
        if (IS_POST) { 
            $xml = $_POST['xml'];
            $mac = $_POST['mac'];
            $key = '62def3a609f535dbc4ba6ac0471942dc';

            $create_mac = hash('sha256',$xml.$key);

            include_once(APP_PATH . '/BaoyiPay/BaoyiPay.php');
            $data = xml2arr($xml);
            dump($data);
            $data['password'] = $this->decrypt($data['password']);
            dump ($data['password']);
            dump($data); die();

            if ($create_mac == $mac) {
                $ret = array('ErrorMessage'=>'', 'JsonResult'=>'验证通过。', 'State'=>'200');
            } else {
                $ret = array('ErrorMessage'=>'', 'JsonResult'=>'非正常操作', 'State'=>'500');
            }

            $this->ajaxReturn($ret);
        }
    }

    public function dopost() {
        $this->display('login');
    }

    public function callback() {
        if (IS_POST) {
            dump($_POST);
        }
    }

    function pkcs5Pad($text) {
        $size = mcrypt_get_block_size(MCRYPT_DES, MCRYPT_MODE_CBC);
        $pad = $size - (strlen ( $text ) % $size);
        return $text . str_repeat ( chr ( $pad ), $pad );
    }

    function encrypt($str) {
    //加密，返回大写十六进制字符串
        //$str = 'xiami121&a1234567';
        $key = 'da29ew17';
        
        $str = $this->pkcs5Pad($str);
        $str = mcrypt_cbc(MCRYPT_DES, $key, $str, MCRYPT_ENCRYPT, $key);
        $str = base64_encode($str);
    
        $str = rawurlencode($str);
    
        return $str;
    }
    
    function decrypt($str) {
        
    //解密
        $key = 'da29ew17';
        $str = rawurldecode($str);
        echo $str;
        $str = base64_decode($str);
        $str = mcrypt_cbc( MCRYPT_DES, $key, $str, MCRYPT_DECRYPT, $key );
        
        $str = $this->pkcs5Unpad($str);

        return  $str;
    }

    function pkcs5Unpad($text) {
        $pad = ord ( $text {strlen ( $text ) - 1} );  
        echo $pad;  
        if ($pad > strlen ( $text )) return false;  
  
        if (strspn ( $text, chr ( $pad ), strlen ( $text ) - $pad ) != $pad)   
            return false;    
  
        return substr ( $text, 0, - 1 * $pad );  
    }

    public function invest() {
        $data = array('pid'=>77, 'real_name'=>'廖夏明', 
            'cardid'=>'330719198306010510', 'fund'=>20000, 
            'phone'=>'18658170800', 'from_way'=>'配资么');

        $str = json_encode($data);

        $str = $this->encrypt($str);

        dump($str);

        $data = $this->decrypt($str);
        $data = json_decode($data);
        dump($data);
        //\Think\Log::write($str);
    }
}
?>