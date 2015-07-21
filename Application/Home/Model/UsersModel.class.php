<?php 
namespace Home\Model;
use Think\Model;
use User\Api\UserApi;

Class UsersModel extends Model{
	/* 用户模型自动完成 */
    protected $_auto = array(
        array('login', 0, self::MODEL_INSERT),
        array('reg_ip', 'get_client_ip', self::MODEL_INSERT, 'function', 1),
        array('reg_time', NOW_TIME, self::MODEL_INSERT),
        array('last_login_ip', 0, self::MODEL_INSERT),
        array('last_login_time', 0, self::MODEL_INSERT),
        array('status', 0, self::MODEL_INSERT),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
    );

    public function login($uid) {
        /* 检测是否在当前用户注册 */
        $user = $this->field(true)->find($uid);

        if (!$user) {
            $this->error = '用户不存在';
            return false;
        } else if(0 == $user['status']) {
            $this->error = '0';     //用户未激活
            return false;
        }

        /* 登录用户 */
        $this->autoLogin($user);

        //记录行为
        //action_log('user_login', 'users', $uid, $uid);

        return true;
    }
    
    /**
     * 注销当前用户
     * @return void
     */
    public function logout(){
        session('user_auth', null);
        session('user_auth_sign', null);
    }

    public function active($verify) {
        $data = M('UsersAction')->where(array('verify'=>$verify))
                ->order('verify_exptime desc')->find();
        if ($data) {
            if ($data['verify_exptime'] > NOW_TIME) {
                if ($data['type'] == 1) {
                    $user = $this->where(array('nickname'=>$data['username']))->find();
                    $this->where(array('status'=> 0, 'id' => $user['id']))->save(array('status'=>1));
                    M('UsersAction')->where(array('id'=>$data['id']))->save(array('status'=>1));
                    $ret = $this->login($user['id']);
                    return $ret;
                } else {
                    return true;
                }
            } else {
                $this->error = '激活码已经过期。';
                return -1;
            }
        } else {
            $this->error = '激活码无效。';
            return -2;
        }
    }

    /**
     * 自动登录用户
     * @param  integer $user 用户信息数组
     */
    private function autoLogin($user){
        /* 更新登录信息 */
        $data = array(
            'id'             => $user['id'],
            'login'           => array('exp', '`login`+1'),
            'last_login_time' => NOW_TIME,
            'last_login_ip'   => get_client_ip(1),
        );
        $this->save($data);

        /* 记录登录SESSION和COOKIES */
        $auth = array(
            'uid'             => $user['id'],
            'username'        => get_username($user['id']),
            'last_login_time' => $user['last_login_time'],
            'user_face' => $user['photo_url'],
        );

        session('user_auth', $auth);
        session('user_auth_sign', data_auth_sign($auth));

    }
    
    // 取得个人
    public function getdetail($id) {
    	
    	$this->user = M('Users')->find($id);
    	$this->detail = M('UsersDetail')->find($id);
    	
    	$userdynamic = array();
    	
    	// 个人信息
    	$userdynamic['user'] = M('Users')->find($id);
    	if (!$userdynamic['user'] || $userdynamic['user']['status'] != 1) {
    		$this->error = '用户不存在';
    		return false;
    	}
    	
    	//个人明细
    	$userdynamic['users_detail'] = M('users_detail')->find($id);
    	
    	//视图获取用户动态信息
    	$userdynamic['all'] = M('userdynamic')->where("user_id = ".$id)->order('create_time desc')->select();
  
    	$projectqty = 0;
    	$investorqty = 0;
    	$commentqty = 0;
    	
    	
        foreach ($userdynamic['all'] as $key=>$info)
    	{

    		if($info['type']=='1')
    		{
    			$userdynamic['investor'][$investorqty]=$info;
    			$investorqty++;
    			
    		}else if($info['type']=='2')
    		{
    			$userdynamic['project'][$projectqty]=$info;
    			$projectqty++;
    		}else if($info['type']=='3')
    		{
    			$userdynamic['comment'][$commentqty]=$info;
    			$commentqty++;
    		}
    		
    	}

        $userdynamic['attach'] = D('AttachView')->where(array('a.investor_id'=>$id))->order('create_time desc')->select();
        // $userdynamic['attach'] = M('project_attach')->where(array('investor_id'=>$id,'status'=>1))->order('create_time desc')->select();
        // foreach($userdynamic['attach'] as &$project){

        //     $project['project_name'] = M('project')->where(array('id'=>$project['project_id']))->getField('project_name');
        // }
    	return $userdynamic;
    }

    // 取得个人
    public function getmobiledetail($id) {

        $this->user = M('Users')->find($id);
        $this->detail = M('UsersDetail')->find($id);

        $userdynamic = array();

        // 个人信息
        $userdynamic['user'] = M('Users')->find($id);
        if (!$userdynamic['user'] || $userdynamic['user']['status'] != 1) {
            $this->error = '用户不存在';
            return false;
        }

        //个人明细
        $userdynamic['users_detail'] = M('users_detail')->find($id);

        //视图获取用户动态信息
        $userdynamic['all'] = M('userdynamic')->where("user_id = ".$id)->order('create_time desc')->select();

        $projectqty = 0;
        $investorqty = 0;
        $commentqty = 0;


        foreach ($userdynamic['all'] as $key=>$info)
        {

            if($info['type']=='1')
            {
                $userdynamic['investor'][$investorqty]=$info;
                $investorqty++;

            }else if($info['type']=='2')
            {
                $userdynamic['project'][$projectqty]=$info;
                $projectqty++;
            }else if($info['type']=='3')
            {
                $userdynamic['comment'][$commentqty]=$info;
                $commentqty++;
            }

        }
        // $userdynamic['attach'] = M('project_attach')->where(array('user_id'=>$id,'status'=>1))->order('create_time desc')->select();

        // foreach($userdynamic['attach'] as &$project){

        //     $project['project_name'] = M('project')->where(array('id'=>$project['project_id']))->getField('project_name');
        // }

        return $userdynamic;
    }

    public function add_attachInfo($uid){
        $attach = M('ProjectAttach')->where(array('investor_id'=>$uid, 'status'=>1))->find();
        $project['project'] = M('Project')->find($id);
    }
    
    public function user_auth($uid,$auth_id){
    	
    	$data=array(
    		'uid'=>$uid,
    		'auth_id'=>$auth_id,
    	);
    	
    	$this->add($data);
    	
    }
    
    public function getNameAndPhoto($uid){
        return M('Users')->where('id='.$uid)->field('nickname,photo_url')->find();
    }
    
    
}
?>