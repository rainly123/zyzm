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
 * 后台首页控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class PublicController extends \Think\Controller {

    /**
     * 后台用户登录
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function login($username = null, $password = null, $verify = null){
        if(IS_POST){
            /* 检测验证码 TODO: */
            if(!check_verify($verify)){
                $this->error('验证码输入错误！');
            }

            /* 调用UC登录接口登录 */
            $User = new UserApi;
            $uid = $User->login($username, $password);
            if(0 < $uid){ //UC登录成功
                /* 登录用户 */
                $Member = D('Member');
                if($Member->login($uid)){ //登录用户
                    //TODO:跳转到登录前页面
                    $this->success('登录成功！', U('Index/index'));
                } else {
                    $this->error($Member->getError());
                }

            } else { //登录失败
                switch($uid) {
                    case -1: $error = '用户不存在或被禁用！'; break; //系统级别禁用
                    case -2: $error = '密码错误！'; break;
                    default: $error = '未知错误！'; break; // 0-接口参数错误（调试阶段使用）
                }
                $this->error($error);
            }
        } else {
            if(is_login()){
                $this->redirect('Index/index');
            }else{
                /* 读取数据库中的配置 */
                $config	=	S('DB_CONFIG_DATA');
                if(!$config){
                    $config	=	D('Config')->lists();
                    S('DB_CONFIG_DATA',$config);
                }
                C($config); //添加配置
                
                $this->display();
            }
        }
    }

    /* 退出登录 */
    public function logout(){
        if(is_login()){
            D('Member')->logout();
            session('[destroy]');
            $this->success('退出成功！', U('login'));
        } else {
            $this->redirect('login');
        }
    }

    public function verify(){
        $verify = new \Think\Verify();
        $verify->entry(1);
    }

    //提现操作回调函数
    
    public function callback() {
    
        include_once(APP_PATH . '/BaoyiPay/BaoyiPay.php');
        
        $xml = $_POST['data'];
      
        $info = xml2arr($xml);
        $body = $info['body'];
            
        //返回成功
        if($body['state']=='02'){ // 结算成功
            Think\Log::write('业务号：（'.$body['tranSeqId'].'）处理成功(02)');
            $pay = M('DrawcashList')->where(array('bussflowno'=>$body['tranSeqId']))->find();
            if ($pay['status'] == 0) {
                //更新提现记录
                $drawcashlist = array(
                        'id' => $pay['id'],
                        'real_amount' => $body['amount'],
                        'submitdate'=>$body['submitDate'],
                        'acctno'=>$body['acctNo'],
                        'acctname'=>$body['acctName'],
                        'state'=>$body['state'],
                        'proctime'=>$body['procTime'],
                        'remark'=>$body['remark'],
                        'update_time'=>NOW_TIME,
                        'status'=>'1');

                M('CashFlow')->where(array('bussflowno'=>$body['tranSeqId']))->save(array('state'=>1));
      
                M('DrawcashList')->save($drawcashlist);
            }
        } elseif($body['state']=='03') { // 结算失败
            Think\Log::write('业务号：（'.$body['tranSeqId'].'）结算失败(03)');
            //查看交易记录
            $pay = M('DrawcashList')->where(array('bussflowno'=>$body['tranSeqId']))->find();
            if ($pay['status'] == 0) {
                //更新提现金额
                $productinfo = M('Product')->find($pay['pid']);
      
                $drawcash_amount = $productinfo['drawcash_amount'] - $body['amount'];
                $product = array(
                        'id' => $pay['pid'],
                        'drawcash_amount' => $drawcash_amount);
      
                M('Product')->save($product);
      
                //更新提现记录
                $drawcashlist = array(
                        'id' => $pay['id'],
                        'real_amount' => $body['amount'],
                        'submitdate'=>$body['submitDate'],
                        'acctno'=>$body['acctNo'],
                        'acctname'=>$body['acctName'],
                        'state'=>$body['state'],
                        'proctime'=>$body['procTime'],
                        'remark'=>$body['remark'],
                        'update_time'=>NOW_TIME,
                        'status'=>'2');
      
                M('DrawcashList')->save($drawcashlist);
      
            }
        } else if($body['state'] == '00') {
            Think\Log::write('业务号：（'.$body['tranSeqId'].'）待结算(00)');
        } else if($body['state'] == '01') {
            Think\Log::write('业务号：（'.$body['tranSeqId'].'）处理中(01)');
        } else if($body['state'] == '04') {
            Think\Log::write('业务号：（'.$body['tranSeqId'].'）处理中');
        }

    }
}