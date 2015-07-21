<?php 
  /**
   * 建立请求，以表单HTML形式构造（默认）
   * @param $para_temp 请求参数数组
   * @param $url 请求的地址
   * @param $method 提交方式。两个值可选：post、get
   * @param $button_name 确认按钮显示文字
   * @return 提交表单HTML文本
   */
  function buildRequestForm($para_temp, $url, $method = 'POST', $button_name="确认") {
    //待请求参数数组
    $sHtml = "<form id='paysubmit' name='paysubmit' action='".$url.
      "' _input_charset='utf-8' method='".$method."'>";

    foreach ($para_temp as $k => $v) {
      $sHtml.= "<input type='hidden' name='$k' value='".$v."'/>";
    }
  
    //submit按钮控件请不要含有name属性
    $sHtml = $sHtml."<input style='display:none' type='submit' value='".$button_name."'></form>";
  
    $sHtml = $sHtml."<script>document.forms['paysubmit'].submit();</script>";
  
    return $sHtml;
  }

  /**
   * 同步post提交
   * @param     $url   提交的地址
   * @param   $para  传递参数 
   **/
  function getHttpResponsePost($url, $para) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
  curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
  curl_setopt($curl,CURLOPT_POST,true); // post传输数据
  curl_setopt($curl,CURLOPT_POSTFIELDS,$para);// post传输数据
  $responseText = curl_exec($curl);
    
  curl_close($curl);

  return $responseText;
  }

  /**
   * 同步get提交
   * @param     $url   提交的地址
   * @param   $para  传递参数 
   **/
  function getHttpResponseGet($url,$postData=null) {
    $ch = curl_init();

    if (!empty($postData)) {
      foreach ($postData as $k=>$v)
      {
          $o.= "$k=".urlencode($v)."&";
      }
      $postData=substr($o,0,-1);
    $url = $url.'?'.$postData;
    }
// print_r($url);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    
    $output22 = curl_exec($ch);
    curl_close($ch);
    return $output22;
  }

  /**
   * 组装url
   * @param     $url   提交的地址
   * @param   $para  传递参数 
   **/
  function buildHttpUrl($url,$para=null) {
    // var_dump($para);exit();
    if (!empty($para)) {
      foreach ($para as $k=>$v)
      {
          $o.= "$k=".urlencode($v)."&";
      }
      $para=substr($o,0,-1);
      $url = $url.'?'.$para;
    }

    return $url;
  }

  /**
   * 宝易返回参数解析
   * @param     $text   待解析内容
   * @param     $key    宝易密钥
   **/
  function parseResponse($text, $key) {
    $para_split = explode('&',$text);
    //把切割后的字符串数组变成变量与数值组合的数组
    foreach ($para_split as $item) {
      //获得第一个=字符的位置
      $nPos = strpos($item,'=');
      //获得字符串长度
      $nLen = strlen($item);
      //获得变量名
      $k = substr($item,0,$nPos);
      //获得数值
      $value = substr($item,$nPos+1,$nLen-$nPos-1);
      //放入数组中
      $para_text[$k] = $value;
    }

    if (!empty($para_text['xml'])) {
      $mac = hash('sha256',$para_text['xml'].$key);
      if ($mac !== $para_text['mac']) return false;
    }

    return $para_text;
  }

  function md5Response($text, $key) {
    $para_split = explode('&',$text);
    //把切割后的字符串数组变成变量与数值组合的数组
    foreach ($para_split as $item) {
      //获得第一个=字符的位置
      $nPos = strpos($item,'=');
      //获得字符串长度
      $nLen = strlen($item);
      //获得变量名
      $k = substr($item,0,$nPos);
      //获得数值
      $value = substr($item,$nPos+1,$nLen-$nPos-1);
      //放入数组中
      $para_text[$k] = $value;
    }

    if (!empty($para_text['xml'])) {
      $mac = md5($para_text['xml'].$key);
      if ($mac !== $para_text['mac']) return false;
    }

    return $para_text;
  }

  /**
   * xml转arr
   * @param    $xml    需要转换的xml字符串
   **/
  function xml2arr($xml) {
    $res = simplexml_load_string($xml);
    $arr = json_decode(json_encode($res),true);
    return $arr;
  }

  /**
   * array 转xml字符串
   * @param     array    $arr   需要转换的array
   * @return    string   返回转换后的字符转
   **/
  function to_xmlstring($arr) {
    $xml = simplexml_load_string('<?xml version="1.0" encoding="UTF-8" ?><message />');
    arr2xml($arr,$xml);
    $xml = $xml->saveXML();

    // 出去生成xml中的换行
    $xml = str_replace("\n", '', $xml);
    $xml = str_replace("\r", '', $xml);

    return $xml;
}

/**
 * array 转xml字符串 for快捷支付接口调用
 * @param     array    $arr   需要转换的array
 * @return    string   返回转换后的字符转
 **/
function to_xmlstring1($arr) {
	$xml = simplexml_load_string('<?xml version="1.0" encoding="UTF-8" ?><message xmlns="http://www.w3school.com.cn"/>');
	arr2xml($arr,$xml);
	$xml = $xml->saveXML();

	// 出去生成xml中的换行
	$xml = str_replace("\n", '', $xml);
	$xml = str_replace("\r", '', $xml);

	return $xml;
}

function start_option($head, $type = 1, $remarks='') {
  M('AccountOption')->add(array('trancode'=>$head['trancode'], 
    'bussflowno'=>$head['bussflowno'], 'type'=>$type, 'remarks'=>$remarks, 
    'option_ip' => get_client_ip(0), 'status'=>0));
}

function finish_option($bussflowno) {
  $option = M('AccountOption')->where(array('bussflowno'=>$bussflowno))->find();
  M('AccountOption')->where(array('bussflowno'=>$bussflowno))->save(array('status'=>1));

  return $option;
}

  /**
   * 建立请求，以表单HTML形式构造（默认）
   * @param $arr 要转换的数组
   * @param $xml xml对象
   */
  function arr2xml($arr, $xml) {
    foreach($arr as $k=>$v) {
      if(is_array($v)) {
        $x = $xml->addChild($k);
        arr2xml($v, $x);
      }else {
        $xml->addChild($k, $v);
      }
    }
  }
?>