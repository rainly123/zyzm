<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use User\Api\UserApi;

/**
 * 后台机构控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class GroupController extends AdminController {

    /**
     * 机构管理首页
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function index(){
        $name       =   I('name');
        $map['status']  =   array('egt',0);
        if(is_numeric($name)){
            $map['id|name']=   array(intval($name),array('like','%'.$name.'%'),'_multi'=>true);
        }else{
            $map['name']    =   array('like', '%'.(string)$name.'%');
        }

        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        
        $list   = $this->lists('Group', $map);
        int_to_string($list);
        $this->assign('_list', $list);
        $this->meta_title = '机构列表';
        $this->display();
    }

    /**
     * 添加机构
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function add(){
    	if(IS_POST){
    		//机构名称
    		$name=$_POST['name'];
    		//简称
    		$shortname=$_POST['short_name'];
    		//联系人
    		$link_man=$_POST['link_man'];
    		//联系电话
    		$link_tel=$_POST['link_tel'];
    		//联系地址
    		$link_address=$_POST['link_address'];
    		//备注
    		$remarks=$_POST['remarks'];
    		//用户id
    		$uid = is_login();
    		if(empty($name)){
    			//请填写机构名称
    			$this->error('请填写机构名称！');
    		}
    		
    		$data= array('name'=>$name,
    			'short_name'=>$shortname,
    			'link_man'=>$link_man,
    			'link_tel'=>$link_tel,
    			'link_address'=>$link_address,
    			'create_id'=>$uid,
    			'create_time'=>NOW_TIME,
    			'update_id'=>$uid,
    			'update_time'=>NOW_TIME,
    			'remarks'=>$remarks);
    		
    		$res= M('Group')->add($data);
    		
    		if($res){
    			$this->success('操作成功', Cookie('__forward__'));
    		}else{
    			$this->error('操作失败！', Cookie('__forward__'));
    		}
    		
    	} else {
    		$this->meta_title = '新增机构';
    		$this->display();
    	}
    }
    
    /**
     * 修改机构
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function edit($id=''){
    	if(IS_POST){
    		//机构名称
    		$id=$_POST['id'];
    		//机构名称
    		$name=$_POST['name'];
    		//简称
    		$shortname=$_POST['short_name'];
    		//联系人
    		$link_man=$_POST['link_man'];
    		//联系电话
    		$link_tel=$_POST['link_tel'];
    		//联系地址
    		$link_address=$_POST['link_address'];
    		//备注
    		$remarks=$_POST['remarks'];
    		//用户id
    		$uid = is_login();
    		if(empty($name)){
    			//请填写机构名称
    			$this->error('请填写机构名称！');
    		}
    
    		$data= array('id'=>$id,'name'=>$name,
    				'short_name'=>$shortname,
    				'link_man'=>$link_man,
    				'link_tel'=>$link_tel,
    				'link_address'=>$link_address,
    				'update_id'=>$uid,
    				'update_time'=>NOW_TIME,
    				'remarks'=>$remarks);
    
    		$res= M('Group')->save($data);
    
    		if($res){
    			$this->success('操作成功！', Cookie('__forward__'));
    		}else{
    			$this->error('操作失败！', Cookie('__forward__'));
    		}
    
    	} else {
    		$info = array();
    		/*获取数据*/
    		$info = M('Group')->find($id);
    		$this->assign('info',$info);

    		$this->meta_title = '修改机构';
    		$this->display('edit');
    	}
    }
    
    /**
     * 状态修改
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function changeStatus($status=null){
    	$id = I('id',0);
        if ($status=='') {
    		$this->error('参数不对!');
    	}
    	
    	$info = M('Group')->find($id);
    	if(!$info){
    		$this->error('数据不存在!');
    	}
    	
    	$res = M('Group')->save(array('status'=>$status,'id'=>$id));
    	
    	if($res){
    		$this->success('操作成功！', Cookie('__forward__'));
    	}else{
    		$this->error('操作失败！', Cookie('__forward__'));
    	}
    }
     
    
    
    
}