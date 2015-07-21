<?php
namespace Home\Controller;
use Think\Controller;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/7/10
 * Time: 16:11
 */
class PubwelfareController extends Controller
{
    function  index()
    {
//        $this->pageTitle = "中瀛智募—中瀛众创";
        $this->assign('pageTitle','中瀛智募—中瀛众创');
        $this->display();
    }
}