<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

/**
 * 前台公共库文件
 * 主要定义前台公共函数库
 */

/**
 * 检测验证码
 * @param  integer $id 验证码ID
 * @return boolean     检测结果
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function check_verify($code, $id = 1){
    $verify = new \Think\Verify(array('reset'=>false));
	return $verify->check($code, $id);
}

/**
 * 判断是否有不合法的词
 * @param  $string 验证字符串
 * @return boolean     检测结果
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function check_badkey($string){
	//$badkey = "敏感词|敏感词B|敏感词C";
	$badkey = C('BAD_KEY');
	
	if(preg_match("/$badkey/i",trimall($string))){
		$ret = true;
			
	}else{
		$ret = false;
	}
	
	return $ret;
}

function trimall($str)//删除空格
{
	$qian=array(" ","　","\t","\n","\r");
	$hou=array("","","","","");
	return str_replace($qian,$hou,$str);
}

/**
 * 获取列表总行数
 * @param  string  $category 分类ID
 * @param  integer $status   数据状态
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_list_count($category, $status = 1){
    static $count;
    if(!isset($count[$category])){
        $count[$category] = D('Document')->listCount($category, $status);
    }
    return $count[$category];
}

/**
 * 获取段落总数
 * @param  string $id 文档ID
 * @return integer    段落总数
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_part_count($id){
    static $count;
    if(!isset($count[$id])){
        $count[$id] = D('Document')->partCount($id);
    }
    return $count[$id];
}

/**
 * 获取导航URL
 * @param  string $url 导航URL
 * @return string      解析或的url
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_nav_url($url){
    switch ($url) {
        case 'http://' === substr($url, 0, 7):
        case '#' === substr($url, 0, 1):
            break;        
        default:
            $url = U($url);
            break;
    }
    return $url;
}

function get_proj_stage($type) {
    $stages = array('1'=>'预热中', '2'=>'认投中', '3'=>'推选领投人', 
        '4'=>'快速合投中','5'=>'付款中', '6'=>'项目已结束');
    if (!array_key_exists($type, $stages)) return '';
    else return $stages[$type];
}
// 实物众筹 众筹阶段（0:初始、1:预热、2:上线、8:众筹失败、9:众筹成功）
function get_product_stage($type) {
    $stages = array('0'=>'初始', '1'=>'预热', '2'=>'上线', 
        '8'=>'众筹失败','9'=>'众筹成功');
    if (!array_key_exists($type, $stages)) return '';
    else return $stages[$type];
}

function getlocation($id) {
    $v = getDistrict($id);
    $v = str_ireplace('省', '', $v);
    $v = str_ireplace('自治区', '', $v);
    $v = str_ireplace('市', '', $v);

    return $v;
}

/*********************************************************************
 * 函数名称:encrypt
 * 函数作用:加密解密字符串
 * 使用方法:
 * 加密     :encrypt('str','E','nowamagic');
 * 解密     :encrypt('被加密过的字符串','D','nowamagic');
 * 参数说明:
 *      $string   :需要加密解密的字符串
 *      $operation:判断是加密还是解密:E:加密   D:解密
 *      $key      :加密的钥匙(密匙);
*********************************************************************/
function encrypt($string,$operation,$key='jumu2014')
{
    $key=md5($key);
    $key_length=strlen($key);
    $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
    $string_length=strlen($string);
    $rndkey=$box=array();
    $result='';
    for($i=0;$i<=255;$i++)
    {
        $rndkey[$i]=ord($key[$i%$key_length]);
        $box[$i]=$i;
    }
    for($j=$i=0;$i<256;$i++)
    {
        $j=($j+$box[$i]+$rndkey[$i])%256;
        $tmp=$box[$i];
        $box[$i]=$box[$j];
        $box[$j]=$tmp;
    }
    for($a=$j=$i=0;$i<$string_length;$i++)
    {
        $a=($a+1)%256;
        $j=($j+$box[$a])%256;
        $tmp=$box[$a];
        $box[$a]=$box[$j];
        $box[$j]=$tmp;
        $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
    }
    if($operation=='D')
    {
        if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8))
        {
            return substr($result,8);
        }
        else
        {
            return'';
        }
    }
    else
    {
        return str_replace('=','',base64_encode($result));
    }
}

/**
 * select返回的数组进行整数映射转换
 *
 * @param array $map  映射关系二维数组  array(
 *                                          '字段名1'=>array(映射关系数组),
 *                                          '字段名2'=>array(映射关系数组),
 *                                           ......
 *                                       )
 * @author 朱亚杰 <zhuyajie@topthink.net>
 * @return array
 *
 *  array(
 *      array('id'=>1,'title'=>'标题','status'=>'1','status_text'=>'正常')
 *      ....
 *  )
 *
 */
function int_to_string(&$data,$map=array('status'=>array(1=>'正常',-1=>'删除',0=>'禁用',2=>'未审核',3=>'草稿'))) {
	if($data === false || $data === null ){
		return $data;
	}
	$data = (array)$data;
	foreach ($data as $key => $row){
		foreach ($map as $col=>$pair){
			if(isset($row[$col]) && isset($pair[$row[$col]])){
				$data[$key][$col.'_text'] = $pair[$row[$col]];
			}
		}
	}
	return $data;
}

// 身份证合法性验证 starting
function validation_filter_id_card($id_card) { 
    if(strlen($id_card) == 18) { 
    return idcard_checksum18($id_card); 
    } elseif((strlen($id_card) == 15)) { 
        $id_card = idcard_15to18($id_card); 
        return idcard_checksum18($id_card); 
    } else { 
        return false; 
    }
} 
// 计算身份证校验码，根据国家标准GB 11643-1999 
function idcard_verify_number($idcard_base) { 
    if(strlen($idcard_base) != 17) { 
        return false; 
    } 
    //加权因子 
    $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2); 
    //校验码对应值 
    $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'); 
    $checksum = 0; 
    for ($i = 0; $i < strlen($idcard_base); $i++) { 
        $checksum += substr($idcard_base, $i, 1) * $factor[$i]; 
    } 
    $mod = $checksum % 11; 
    $verify_number = $verify_number_list[$mod]; 
    return $verify_number; 
}

// 将15位身份证升级到18位 
function idcard_15to18($idcard){ 
    if (strlen($idcard) != 15){ 
        return false; 
    }else{ 
        // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码 
        if (array_search(substr($idcard, 12, 3), array('996', '997', '998', '999')) !== false){ 
            $idcard = substr($idcard, 0, 6) . '18'. substr($idcard, 6, 9); 
        }else{ 
            $idcard = substr($idcard, 0, 6) . '19'. substr($idcard, 6, 9); 
        } 
    } 
    $idcard = $idcard . idcard_verify_number($idcard); 
    return $idcard; 
} 
// 18位身份证校验码有效性检查 
function idcard_checksum18($idcard){ 
    if (strlen($idcard) != 18){ return false; } 
    $idcard_base = substr($idcard, 0, 17); 
    if (idcard_verify_number($idcard_base) != strtoupper(substr($idcard, 17, 1))){ 
        return false; 
    }else{ 
        return true; 
    }
}
// 身份证合法性验证 ending

//订单生成
 function buildMerorderid($id=""){

	$time = date('YmdHis',time());
	$randomNum = rand(1000,9999);
	$merorderid = 'PY'.$time.$randomNum;

	return $merorderid;
}

/**
 * 合计所项目、投资金额、注册会员
 * @return 
 * @author
 */
function get_sum_info(){
		//所有股权项目
		//项目数
		$pj_count = M('Project')->where(array('status'=>array('egt',9)))->count();
		
		//投资额
		$pj_fund = M('ProjectInvestor')->where(array('status'=>array('egt',4)))->sum('fund');
		
		//所有事物项目
		//项目数
		$pr_count = M('Product')->where(array('status'=>array('egt',9)))->count();
		//投资额
		$pr_fund = M('Custom')->where(array('status'=>1))->sum('amount');
		
		//会员数
		$member = M('UcenterMember')->where(array('status'=>1))->count();
		
		$total = $pj_fund + $pr_fund +20000000;
		
		if (abs($total) >= 10000) {
			$total = round($total /10000) . '万';
		} else {
			$total = round($total,2);
		}

		$data['sum_count'] = $pj_count + $pr_count;
		$data['sum_fund'] = $total;
		$data['sum_member'] = $member + 3600;
		return $data;
	
}

function get_format_comment($arr, $count) {
    $ret = array();
    $i = 0;
    foreach ($arr as $k => $v) {
        if ($i < $count) {
            if (!empty($v['reply_id'])) {
                $v['parent'] = array();
                $v['parent'][] = get_parent_comment($arr, $v, $v['reply_id']);
            }
            $ret[] = $v;
            $i++;
        } else {
            break;
        }
    }
    return $ret;
}
/**
 * 评论内容嵌套
 * @param  
 * @param
 */
function get_parent_comment($arr, &$child, $pid = 0) {
    if ($pid == 0) {
        return;
    }
    foreach ($arr as $k => $v1) {
        if ($v1['id'] ==  $pid) {
            if (!empty($v1['reply_id'])){
                $child['parent'][] = get_parent_comment($arr, $child, $v1['reply_id']);   
            }
            return $v1;
        }
    }
}

/**
 * 跟新股权待办件数
 * @param 用户ID
 * @param 更新阶段 -1:撤销 0：跟投，1：确认协议 ，2：支付
 */
function update_pj_dolist($uid,$type) {
	if ($uid == 0) {
		return;
	}
	//跟投时，添加一个待办事件
	if($type==0){
		$dolist = M('Dolist')->where(array('uid'=>$uid))->find();
		
		if($dolist){
			//有记录则更新
			$data=array('id'=>$dolist['id'],'pj_qty'=>$dolist['pj_qty']+1,'update_time'=>NOW_TIME);
			M('Dolist')->save($data);
			
		}else{
			//没有记录则添加
			$data=array('uid'=>$uid,'pj_qty'=>1,'add_time'=>NOW_TIME,'update_time'=>NOW_TIME);
			M('Dolist')->add($data);
		}
	}elseif($type==2){
		//获取最新记录
		$dolist = M('Dolist')->where(array('uid'=>$uid))->find();
	
		//更新
		$data=array('id'=>$dolist['id'],'pj_qty'=>$dolist['pj_qty']-1,'update_time'=>NOW_TIME);
		M('Dolist')->save($data);
			
	}elseif($type==-1){
		//获取最新记录
		$dolist = M('Dolist')->where(array('uid'=>$uid))->find();
	
		//更新
		$data=array('id'=>$dolist['id'],'pj_qty'=>$dolist['pj_qty']-1,'update_time'=>NOW_TIME);
		M('Dolist')->save($data);
			
	}
}

/**
 * 跟新实物待办件数
 * @param 用户ID
 * @param 更新阶段 -1:撤销 0：已购买，1：支付
 */
function update_pr_dolist($uid,$type) {
	if ($uid == 0) {
		return;
	}
	//购买时，添加一个待办事件
	if($type==0){
		$dolist = M('Dolist')->where(array('uid'=>$uid))->find();

		if($dolist){
			//有记录则更新
			$data=array('id'=>$dolist['id'],'pr_qty'=>$dolist['pr_qty']+1,'update_time'=>NOW_TIME);
			M('Dolist')->save($data);
				
		}else{
			//没有记录则添加
			$data=array('uid'=>$uid,'pr_qty'=>1,'update_time'=>NOW_TIME);
			M('Dolist')->add($data);
		}
	}elseif($type==1){
		//获取最新记录
		$dolist = M('Dolist')->where(array('uid'=>$uid))->find();

		//更新
		$data=array('id'=>$dolist['id'],'pr_qty'=>$dolist['pr_qty']-1,'update_time'=>NOW_TIME);
		M('Dolist')->save($data);
			
	}elseif($type==-1){
		//获取最新记录
		$dolist = M('Dolist')->where(array('uid'=>$uid))->find();

		//更新
		$data=array('id'=>$dolist['id'],'pr_qty'=>$dolist['pr_qty']-1,'update_time'=>NOW_TIME);
		M('Dolist')->save($data);
			
	}
}
/**
 * 公益前台资金总额
 */
function get_sum_public(){
    $pb_input = M('public_input')->sum('fund');
    $pb_output= M('public_output')->sum('fund');

    $total = number_format($pb_input - $pb_output);
    $data['sum_input'] = number_format($pb_input)."元";
    $data['sum_output'] = number_format($pb_output)."元";
    $data['sum_fund'] =$total."元" ;
    return $data;
}

