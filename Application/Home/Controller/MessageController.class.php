<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use User\Api\UserApi;
use Home\Model\MessageModel;

/**
 *  消息控制器
 *  
 */
class MessageController extends HomeController {

	/* 消息首页 */
	public function index(){
    $id = is_login();
    if (!$id) {
        $this->redirect('User/login');
    }
    $this->pageTitle = "消息中心";
    $this->assign('msgtype', 'newpm');
    $this->assign('msgcount',  $this->_message_qty($id));

    $this->assign('messages', $this->_list_message('newpm',$id));
    $this->display('index');
	}

  public function system() {

    $id = is_login();
    if (!$id) {
        $this->error( '您还没有登陆',U('User/login') );
    }

    $this->assign('msgtype', 'sys');
    $this->assign('msgcount', $this->_message_qty($id));

    $this->assign('messages', $this->_list_message('sys',$id));
    $this->pageTitle = "消息中心";
    $this->display('system');
  }

  public function project() {
    
    $this->pageTitle = "消息中心";
    $this->display('project');
  }

  // 未读信息数
  public function news() {
    if (IS_AJAX) {
      $uid = is_login();
      if ($uid) {
        $count = M('Message')->where(array('to_id'=>$uid, 'new'=>1, 'status'=>3))->count();
        if($count > 99) {$count=99;}
        $this->ajaxReturn(array('status'=>1, 'count'=>$count));
      } else {
        $this->ajaxReturn(array('status'=>0, 'count'=>''));
      }
    }
  }
	
	/**
	 *    私信
	 *
	 *    @author    Hyber
	 *    @return    void
	 */
	function newpm()
	{
		$id = is_login();
        if (!$id) {
            $this->error( '您还没有登陆',U('User/login') );
        }

		$this->assign('msgtype', 'newpm');
		$this->assign('msgcount',  $this->_message_qty($id));

		$this->assign('messages', $this->_list_message('newpm',$id));

		$this->display('message.box');
	}
	
	/**
	 *    约谈信
	 *
	 *    @author    Hyber
	 *    @return    void
	 */
	function interview()
	{
		$id = is_login();
        if (!$id) {
            $this->error( '您还没有登陆',U('User/login') );
        }
	
		$this->assign('msgtype', 'interview');
		$this->assign('msgcount', $this->_message_qty($id));
	
		$this->assign('messages', $this->_list_message('interview',$id));
	
		$this->display('message.box');
	}
	
	/**
	 *    收藏通知
	 *
	 *    @author    Hyber
	 *    @return    void
	 */
	function invest()
	{
		$id = is_login();
        if (!$id) {
            $this->error( '您还没有登陆',U('User/login') );
        }

		$this->assign('msgtype', 'invest');
		$this->assign('msgcount', $this->_message_qty($id));
	
		$this->assign('messages', $this->_list_message('invest',$id));
	
		$this->display('message.box');
	}

  function readmessage() {
    if (IS_AJAX) {
      $id = is_login();
      $type = $_GET['msgtype'];
      if ($type == 'invest') {
        $type = 2; 
      } else if ($type == 'newpm') {
          $type = 0;
      } else if ($type == 'sys') {
          $type = 3;
      }
      M('Message')->where(array('to_id'=>$id,'msg_type'=>$type , 'new' => 1))->
        save(array('new'=>0));
    }
  }
	
	/**
	 *    系统通知
	 *
	 *    @author    Hyber
	 *    @return    void
	 */
	function sys()
	{
		$id = is_login();
        if (!$id) {
            $this->error( '您还没有登陆',U('User/login') );
        }
	
		$this->assign('msgtype', 'sys');
		$this->assign('msgcount', $this->_message_qty($id));
	
		$this->assign('messages', $this->_list_message('sys',$id));
	
		$this->display('message.box');
	}
	
	/**
	 *    发件箱
	 *
	 *    @author    Hyber
	 *    @return    void
	 */
	function outbox()
	{
		$id = is_login();

        if (!$id) {
            $this->error( '您还没有登陆',U('User/login') );
        }
	
		$modelmessage = new MessageModel();
	
		$newmessage = $modelmessage->where(" to_id= ". $id . " and new =1 ")->count();
	
		$this->assign('msgtype', '1');
		$this->assign('newmessage', $newmessage);
	
		$this->assign('messages', $this->_list_message('outbox',$id));
	
		$this->assign('_page',D('message')->page);//分页
		
		$this->display();
	}

    // 发送私信
    public function sendmsg() {
      $uid = is_login();
      $id = $_GET['id'];

      if (IS_POST) {
        if (!$uid) {
          $this->error('您还没有登录，请先登录。', U('User/login'));
        }

        if ($id == $uid) {
          $this->error('您不能给自己发私信');
        }

        $msg = D('Message')->send($uid, $id,'私信', $_POST['content']);
        $this->success('私信发送成功', U('MCenter/profile?id='.$id));
      } else {
        $id = $_GET['id'];

        if (!$uid) {
          $this->error('您还没有登录，请先登录。', U('User/login'));
          exit();
        }

        if ($id == $uid) {
          $this->message = '您不能给自己发私信';
          $this->display('Project/error');
          exit();        
      }
      }

      $this->pageTitle = '发送私信';
      $this->id = $id;
      $this->display('sendmsg');
    }

	/**
	 * 发送验证
	 * @author 
	 */
	public function validateRegister() {
		if (IS_POST) {
			$id = is_login();
			$name = I('post.name');
			$param = I('post.param');

			if ($name == 'username' || $name == 'email') {
				$data = M('UcenterMember')->where($name . " = '". $param . "' and id <>" . $id)->find();
	
				if ($data) {
					$this->ajaxReturn(array('status'=>'y'));
				} else {
					//$name = $name == 'username' ? '用户名' : '邮箱';
					$this->ajaxReturn(array('status'=>'n', 'info'=>'禁止给自己或非注册用户发送消息'));
					
				}
			} else if ($name == 'verify') {
				if(!check_verify($param)){
					$this->ajaxReturn(array('status'=>'n', 'info'=>'验证码输入错误'));
				} else {
					$this->ajaxReturn(array('status'=>'y', 'info'=>''));
				}
			}
		}
	}
	
    /**
     * 发送新消息
     * @author 
     */
    public function send(){
    	if ( !is_login() ) {
    		$this->error( '您还没有登陆',U('User/login') );
    	}
    	
    	if ( IS_POST ) {

    		$id=is_login();
    		$param = $_POST['username'];
    		
    		$msg_id = isset($_POST['msg_id']) ? intval($_POST['msg_id']) : 0;

    		$data = M('UcenterMember')->where("username= '". $param."'")->find();
    		
    		$modelmessage = D('Message');

    		$ret = $modelmessage->send($id, $data['id'], '', $_POST['describe'],0,$msg_id);
    
    		if (!$ret)
    		{
    			$this->error($modelmessage->getError());
    			return;
    		}
    		
    		$this->success('发送成功');
    		
    		$this->display();

    	}else{
    		$id = is_login();
    		$this->user = M('Users')->find($id);
    		$this->detail = M('UsersDetail')->find($id);
    		
    		$this->display();
    	}
    }
    
    function _message_qty($user_id)
    {
    	$data=array('msgcount1'=>0,
    			'msgcount2'=>0,
    			'msgcount3'=>0,
    			'msgcount4'=>0,);
    	
    	$messageqty = D('message_qty')->where("to_id = ". $user_id)->select();
    	
    	foreach ($messageqty as $key=>$message)
    	{
    		if($message['msg_type']==0){
    			$data['msgcount1']=$message['qty'];
    		}
    		else if ($message['msg_type']==1)
    		{
    			$data['msgcount2']=$message['qty'];
    		}
    		else if ($message['msg_type']==2)
    		{
    			$data['msgcount3']=$message['qty'];
    		}
    		else if ($message['msg_type']==3)
    		{
    			$data['msgcount4']=$message['qty'];
    		}
    	}
    	
    	
    	return $data;
    }
    /**
     * 获取数据列表
     * @author
     */
    function _list_message($pattern, $user_id)
    {
    	if($pattern=='outbox')
    	{
    		$data = M('Message')->where(" from_id = ". $user_id . " and status<>1 ")->order('add_time desc')->select();
    		foreach ($data as $key=>$message)
    		{
    			if($message['msg_type']==3){
    				$data[$key]['user_name']='系统消息';
    			}else{
    				$user_info = M('users')->where("id = ". $message['to_id'])->find();
    				 
    				$data[$key]['user_name']=$user_info['nickname'];
    			}
    		}
    		
    	}else{
    		if($pattern=='newpm'){
    			$msg_type=0;
    		}else if($pattern=='interview'){
    			$msg_type=1;
    		}else if($pattern=='invest'){
    			$msg_type=2;
    		}else if($pattern=='sys'){
    			$msg_type=3;
    		}
    		
    		$data = M('Message')->where(" to_id = ". $user_id . " and msg_type =". $msg_type ." and status<>2 ")->order('new desc, add_time desc')->select();
    	
    		foreach ($data as $key=>$message)
    		{
    			if($message['msg_type']==3){
    				$data[$key]['user_name']='系统消息';
    			}else{
    	
    				$user_info = M('users')->where("id = ". $message['from_id'])->find();

    				$data[$key]['user_name']=$user_info['nickname'];
    			}
    		}	
    	}
    	return $data;
    }
    
    /**
     * 查看
     * @author huajie <banhuajie@163.com>
     */
    public function view($id = 0,$type){
    	empty($id) && $this->error('参数错误！');
    
    	$message = M('Message')->where("id = ". $id)->find();
    	
    	if($message['msg_type']==3){
    		$message['user_name']='系统消息';
    	}else{
    		 
    		$user_info = M('users')->where("id = ". $message['from_id'])->find();
    	
    		$message['user_name']=$user_info['nickname'];
    		$message['photo_url']=$user_info['photo_url'];
    	}

    	$data = array(
    			'id'   => $id,
    			'new'     => 0,
    	);
    	
    	$ret = M('Message')->save($data);
    	
    	//回复的消息
    	$rmessages = M('Message')->where("parent_id = ". $id)->select();
    	
    	foreach ($rmessages as $key=>$rmessage)
    	{
    		if($rmessage['msg_type']==3){
    			$rmessages[$key]['user_name']='系统消息';
    		}else{
    			 
    			$user_info = M('users')->where("id = ". $rmessage['from_id'])->find();
    	
    			$rmessages[$key]['user_name']=$user_info['nickname'];
    			$rmessages[$key]['photo_url']=$user_info['photo_url'];
    		}
    	}
    	$this->assign('type', $type);
    	$this->assign('message', $message);
    	$this->assign('rmessages', $rmessages);

    	$this->display();
    }
    
    
}
