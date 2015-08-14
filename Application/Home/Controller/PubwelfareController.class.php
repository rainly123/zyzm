<?php
namespace Home\Controller;
use Think\Controller;


class PubwelfareController extends Controller
{
    function  index()
    {
        $list1 = M('public_input')->order('create_time desc')->limit(20)->select();
        $this->assign('list1', $list1);
        $list2 = M('public_output')->order('create_time desc')->limit(20)->select();
        $this->assign('list2', $list2);

        $suminfo = get_sum_public();
        $this->assign('suminfo', $suminfo);

        $this->assign('pageTitle','中瀛智募—中瀛众创');
        $this->display();

    }
    /*
     * 公益募捐（入）
     * */
    public function pubwelfarelist()
    {
        $onepage =30;
        $totalCounter = M("public_input")->count();
        $Page = new \Think\Page($totalCounter,$onepage);
        $show= $Page->show();
        $list = M("public_input")->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list1',$list);
        $this->assign('Pages',$show);
        $this->assign('pageTitle','公益募捐');
        $suminfo = get_sum_public();
        $this->assign('suminfo', $suminfo);
        $this->display();
    }

    /*
     * 公益活动（出）
     * */
    public function actionlist() {
        $onepage =30;
        $totalCounter = M("public_output")->count();
        $Page = new \Think\Page($totalCounter,$onepage);
        $show= $Page->show();
        $list = M("public_output")->order('create_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list2',$list);
        $this->assign('Pages',$show);
        $this->pageTitle = "公益活动";
        $suminfo = get_sum_public();
        $this->assign('suminfo', $suminfo);
        $this->display();
    }


    function action()
    {
        $id = $_GET['id'];
        $info = M('public_output')->where(array('id' => $id))->find();
        $this->assign('info', $info);
        $this->assign('pageTitle','中瀛智募—中瀛众创');
        $this->display();

    }


}
