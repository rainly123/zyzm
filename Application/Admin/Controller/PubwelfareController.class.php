<?php
/**
 * Created by PhpStorm.
 * User: chens
 * Date: 2015/8/5
 * Time: 14:58
 */

namespace Admin\Controller;
use Think\Page;


class PubwelfareController extends AdminController{
    public function index() {

        $map['status']    =   array('gt', -1);
        $list   =   $this->lists('public_output', $map);
        int_to_string($list);
        foreach ($list as $key=>$value){
            $model_id                  =   get_document_field($value['model'],"name","id");
            $list[$key]['model_id']    =   $model_id ? $model_id : 0;
        }
        $this->assign('info', $list);
        $this->display();

    }

    public function add() {
        if (IS_POST) {

            if (!is_numeric($_POST['fund']) || empty($_POST['fund'])) {
                $this->error('金额输入错误');
            } else if (!isset($_POST['title']) || empty($_POST['title'])) {
                $this->error('标题不能为空');
            } else if (!isset($_POST['content']) || empty($_POST['content'])) {
                $this->error('内容不能为空');
            }
            $data = array(
                'create_id'=> is_login(),
                'title'=>$_POST['title'],
                'fund'=>$_POST['fund'],
                'action_time'=>$_POST['action_time'],
                'content'=>$_POST['content'],
                'create_time'=> date('y-m-d H:i:s'));


                M('public_output')->add($data);
                 $this->success('添加成功。', U('index'));
        } else {
                $this->display();
        }
    }




    public function edit()
    {
        $id=$_GET['id'];
        if (IS_POST) {
                if (!is_numeric($_POST['fund']) || empty($_POST['fund'])) {
                    $this->error('金额输入错误');
                } else if (!isset($_POST['title']) || empty($_POST['title'])) {
                    $this->error('标题不能为空');
                } else if (!isset($_POST['content']) || empty($_POST['content'])) {
                    $this->error('内容不能为空');
                }
                $data = array(
                    'create_id'=> is_login(),
                    'title'=>$_POST['title'],
                    'fund'=>$_POST['fund'],
                    'action_time'=>$_POST['action_time'],
                    'content'=>$_POST['content'],
                    'create_time'=> date('y-m-d H:i:s')
                );
                M('public_output')->where(array('id'=>I('post.id')))->data($data)->save();

                 $this->success('修改成功。', U('index'));

        }else{
            $id = I('id');

            /* 获取数据 */
            $info =M('public_output')->field(true)->find($id);
            if(false === $info){
                $this->error('获取信息错误');
            }
            $this->assign('info', $info);
            $this->assign('id',$id);
            $this->display("add");
        }

    }

















    public function del() {
        $id=$_GET['id'];
        M('public_output')->where(array('id'=>$id))->delete();
        $this->success('删除处理成功。');
    }

}