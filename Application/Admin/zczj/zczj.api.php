<?php
class zczj {
	
	public $soapClient;
	
	/**
	 * 
	 * 初始化
	 * @param  $options
	 * $options['debug'] 是否在测试环境
	 * $options['UserName'] 用户名
	 * $options['PassWord'] 密码
	 * $options['PlatId'] 平台ID
	 */
	public function __construct($options){
		$options['debug'] ? $wsd = "http://apitest.zczj.com/Project.asmx?wsdl" : $wsd = "http://api.zczj.com/project.asmx?wsdl";
		$soap_header = new SoapHeader("http://tempuri.org/",'ZCSoapHeader',array('UserName'=>$options['UserName'],'PassWord'=>$options['PassWord'],'PlatId'=>$options['PlatId']),true);
		$this->soapClient = new SoapClient($wsd);
		$this->soapClient->__setSoapHeaders(array($soap_header));
	}
	
	/**
	 * 
	 * 提交项目到众筹之家
	 * @param $projectId
	 */
	public function projectsAdd($param){
		$result = $this->soapClient->ProjectsAdd($param);
		//print_r($result);
        return $result->ProjectsAddResult;
	}
	
	/**
	 * 
	 * 提交平台数据到众筹之家
	 * @param  $data
	 */
	public function platDataAdd($data){
		$result = $this->soapClient->PlatDataAdd($data);
		//print_r($result);
        return $result->PlatDataAddResult;
	}
	
	/**
	 * 
	 * 提交投资人数据到众筹之家
	 * @param  $zczjId 众筹之家项目ID
	 * @param  $investors 投资人数组
	 */
	public function projectInvestorsAdd($zczjId,$investors){
        $param['ProjectID'] = $zczjId;
		$param['investors'] = $investors;
		$result = $this->soapClient->ProjectInvestorsAdd($param);
		//print_r($result);
        return $result->ProjectInvestorsAddResult;
	}
	
	
}