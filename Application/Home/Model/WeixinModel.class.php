<?php 
namespace Home\Model;
use User\Api\UserApi;

Class WeixinModel{
	protected $autoCheckFields =false;
	
	public function getRequest($url,$postData){
		$info = $this->getHttpResponseGet($url,$postData);
		return (Array)json_decode($info);
	}
	
	public function checkBind(){
		$uid = is_login();
		if(!$uid){
			return array('success'=>false, 'info'=> '用户未登录!');
		}else{
			$currentUser = M('UcenterMember')->where(" id = '". $uid . "'")->find();
			if($currentUser){
				if($currentUser['openid'] !=null){
					return array('success'=>true, 'info'=> '已绑定微信号!');
				}
			}
			return array('success'=>false, 'info'=> '未找到绑定微信号!');
		}
	}
	
	/**
	 * get请求
	 * @param     $url   提交的地址
	 * @param   $para  传递参数
	 **/
	function getHttpResponseGet($url,$postData=null) {
		$ch = curl_init();
		$o='';
		if (!empty($postData)) {
			foreach ($postData as $k=>$v)
			{
				$o.= "$k=".urlencode($v)."&";
			}
	
			$postData=substr($o,0,-1);
			$url = $url.'?'.$postData;
		}
		$ch = curl_init();
		$header = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($ch);
		return $temp;
	}
}
?>