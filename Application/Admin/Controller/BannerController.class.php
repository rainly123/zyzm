<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;

/**
 * 后台频道控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */

class BannerController extends AdminController {

    /**
     * 频道列表
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function index(){
        // $pid = I('get.pid', 0);
        /* 获取频道列表 */
        $map  = array('status' => array('NEQ', -1), 'pid'=>$pid);
        $list = M('Banner')->where($map)->order('sort asc,id desc')->select();

        $this->assign('list', $list);
        $this->assign('pid', $pid);
        $this->meta_title = 'banner管理';
        $this->display();
    }

    /**
     * 添加频道
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function add(){
        if(IS_POST){
            $Banner = D('Banner');
            $data = $Banner->create();
            if($data){
                $data['type'] = 0;
                $data['create_time'] = $data['update_time'] = time();
                // var_dump($data);exit();
                $id = $Banner->add($data);
                if($id){
                    $this->success('新增成功', U('index'));
                    //记录行为
                    // action_log('update_Banner', 'Banner', $id, UID);
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($Banner->getError());
            }
        } else {
            $this->meta_title = '新增导航';
            $this->display('edit');
        }
    }

    /**
     * 编辑频道
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function edit($id = 0){
        if(IS_POST){
            $Banner = D('Banner');
            $data = $Banner->create();
            if($data){
                if($Banner->save()){
                    //记录行为
                    // action_log('update_Banner', 'Banner', $data['id'], UID);
                    $this->success('编辑成功', U('index'));
                } else {
                    $this->error('编辑失败');
                }

            } else {
                $this->error($Banner->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = M('Banner')->find($id);

            if(false === $info){
                $this->error('获取配置信息错误');
            }

            $pid = I('get.pid', 0);
            //获取父导航
            if(!empty($pid)){
            	$parent = M('Banner')->where(array('id'=>$pid))->field('title')->find();
            	$this->assign('parent', $parent);
            }

            $this->assign('pid', $pid);
            $this->assign('info', $info);
            $this->meta_title = '编辑导航';
            $this->display();
        }
    }

    /**
     * 删除频道
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function del(){
        // var_dump('expression');exit();
        $id = array_unique((array)I('id',0));

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id));
        $date['status'] = -1;
        $result = M('Banner')->where($map)->save($date);
        if($result){
            //记录行为
            // action_log('update_Banner', 'Banner', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

    /**
     * 导航排序
     * @author huajie <banhuajie@163.com>
     */
    public function sort(){
        if(IS_GET){
            $ids = I('get.ids');
            $pid = I('get.pid');

            //获取排序的数据
            $map = array('status'=>array('gt',-1));
            if(!empty($ids)){
                $map['id'] = array('in',$ids);
            }else{
                if($pid !== ''){
                    $map['pid'] = $pid;
                }
            }
            $list = M('Banner')->where($map)->field('id,name')->order('sort asc,id asc')->select();

            $this->assign('list', $list);
            $this->meta_title = '导航排序';
            $this->display();
        }elseif (IS_POST){
            $ids = I('post.ids');
            $ids = explode(',', $ids);
            $ids_count = count($ids);

            // var_dump($ids_count);exit();
            foreach ($ids as $key=>$value){
                //降序
                // $currentCounter = $ids_count - $key;
                $res = M('Banner')->where(array('id'=>$value))->setField('sort', $key+1);
            }
            if($res !== false){
                $this->success('排序成功！');
            }else{
                $this->error('排序失败！');
            }
        }else{
            $this->error('非法请求！');
        }
    }

    public function setStatus($id,$status){
        if (empty($id)) {
            $this->error('关键参数未获得。');
        }
        if (!in_array($status, array(0,1,-1))){
            $this->error('关键参数未获得');
        }
//         var_dump($status);
// var_dump($id);exit();
        $map = array('id'=>$id);
        $date['status'] = $status;

        $result = M('Banner')->where($map)->save($date);
        if($result){
            //记录行为
            // action_log('update_Banner', 'Banner', $id, UID);
            $this->success('修改成功');
        } else {
            $this->error('修改失败！');
        }
    }
}