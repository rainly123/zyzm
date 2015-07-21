<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use Think\Controller;

/**
 * 前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class HomeController extends Controller {

	/* 空操作，用于输出404页面 */
	public function _empty(){
		$this->redirect('Index/index');
	}

  /*用户必须登录后方可查看*/
  function __construct(){
    parent::__construct();

  }

  protected function _initialize(){
    /* 读取站点配置 */
    $config = api('Config/lists');
    C($config); //添加配置

    if(!C('WEB_SITE_CLOSE')){
        $this->error('站点已经关闭，请稍后访问~');
    }
    
  	$this->pageTitle = "中瀛智募";
    
    if (isMobile()) {
    	C('DEFAULT_THEME', 'mobile');
    	if (empty($_SERVER['HTTP_REFERER'])) {
    		$this->backurl = U('/');
    	} else {
				//$this->backurl = $_SERVER['HTTP_REFERER'];
    	}
    	
    	//echo $this->backurl;
    }
  }

	/* 用户登录检测 */
	protected function login(){
		/* 用户登录检测 */
		is_login() || $this->redirect('User/login');
	}
	
	/**
	 * 对数据表中的单行或多行记录执行修改 GET参数id为数字或逗号分隔的数字
	 *
	 * @param string $model 模型名称,供M函数使用的参数
	 * @param array  $data  修改的数据
	 * @param array  $where 查询时的where()方法的参数
	 * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 *
	 * @author 朱亚杰  <zhuyajie@topthink.net>
	 */
	final protected function editRow ( $model ,$data, $where , $msg ){
		$id    = array_unique((array)I('id',0));
		$id    = is_array($id) ? implode(',',$id) : $id;
		//如存在id字段，则加入该条件
		$fields = M($model)->getDbFields();
		if(in_array('id',$fields) && !empty($id)){
			$where = array_merge( array('id' => array('in', $id )) ,(array)$where );
		}
	
		$msg   = array_merge( array( 'success'=>'操作成功！', 'error'=>'操作失败！', 'url'=>'' ,'ajax'=>IS_AJAX) , (array)$msg );
		if( M($model)->where($where)->save($data)!==false ) {
			$this->success($msg['success'],$msg['url'],$msg['ajax']);
		}else{
			$this->error($msg['error'],$msg['url'],$msg['ajax']);
		}
	}
	
	/**
	 * 条目假删除
	 * @param string $model 模型名称,供D函数使用的参数
	 * @param array  $where 查询时的where()方法的参数
	 * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 *
	 * @author 朱亚杰  <zhuyajie@topthink.net>
	 */
	protected function delete ( $model , $status,$where = array() , $msg = array( 'success'=>'删除成功！', 'error'=>'删除失败！')) {
		$data['status']         =   $status;
		$this->editRow(   $model , $data, $where, $msg);
	}
	
	/**
	 * 禁用条目
	 * @param string $model 模型名称,供D函数使用的参数
	 * @param array  $where 查询时的 where()方法的参数
	 * @param array  $msg   执行正确和错误的消息,可以设置四个元素 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 *
	 * @author 朱亚杰  <zhuyajie@topthink.net>
	 */
	protected function forbid ( $model ,$status, $where = array() , $msg = array( 'success'=>'状态禁用成功！', 'error'=>'状态禁用失败！')){
		$data    =  array('status' => $status);
		$this->editRow( $model , $data, $where, $msg);
	}
	
	/**
	 * 恢复条目
	 * @param string $model 模型名称,供D函数使用的参数
	 * @param array  $where 查询时的where()方法的参数
	 * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 *
	 * @author 朱亚杰  <zhuyajie@topthink.net>
	 */
	protected function resume (  $model ,$status, $where = array() , $msg = array( 'success'=>'状态恢复成功！', 'error'=>'状态恢复失败！')){
		$data    =  array('status' => $status);
		$this->editRow(   $model , $data, $where, $msg);
	}
	
	/**
	 * 设置一条或者多条数据的状态
	 */
	public function setStatus($Model=CONTROLLER_NAME){
	
		$ids    =   I('request.ids');
		$status =   I('request.status');
		$type =   I('request.type');
		
		if(empty($ids)){
			$this->error('请选择要操作的数据');
		}
	
		$map['id'] = array('in',$ids);
		switch ($type){
			case -1 :
				$this->delete($Model,$status, $map, array('success'=>'删除成功','error'=>'删除失败'));
				break;
			case 0  :
				$this->forbid($Model,$status, $map, array('success'=>'禁用成功','error'=>'禁用失败'));
				break;
			case 1  :
				$this->resume($Model,$status, $map, array('success'=>'启用成功','error'=>'启用失败'));
				break;
			default :
				$this->error('参数错误');
				break;
		}
	}

}