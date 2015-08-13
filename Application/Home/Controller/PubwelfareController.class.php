<?php
namespace Home\Controller;
use Think\Controller;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/7/10
 * Time: 16:11
 */
class PubwelfareController extends HomeController
{
    function  index()
    {
//        $this->pageTitle = "中瀛智募—中瀛众创";
        $this->assign('pageTitle','中瀛智募—中瀛众创');
<<<<<<< HEAD
        $this->must();
=======
        if(!is_login())
        {
            $this->redirect('User/login');
        }
        else
        {
            $this->display();
        }
>>>>>>> zyzm_version_1.0
    }
}