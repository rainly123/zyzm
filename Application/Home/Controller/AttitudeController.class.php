<?php
/**
 * Created by PhpStorm.
 * User: adaman58
 * Date: 4/13/15
 * Time: 4:06 PM
 */

namespace Home\Controller;
class AttitudeController extends HomeController
{
    public function positive(){
        $pid = $_POST['pid'];
        if($pid>0){
            $this->ajaxReturn(D('ProjectAttitude')->positive($pid));
        }
        else{
            $this->ajaxReturn(array('success'=>false, 'info'=> '缺少参数!'));
        }
    }

    public function negative(){
        $pid = $_POST['pid'];
        if($pid>0){
            $this->ajaxReturn(D('ProjectAttitude')->negative($pid));
        }
        else{
            $this->ajaxReturn(array('success'=>false, 'info'=> '缺少参数!'));
        }
    }

    //获取支持的数量
    public function getNumberOfPositives(){
        $pid = $_GET['pid'];
        if($pid>0){
            $this->ajaxReturn(D('ProjectAttitude')->numberOfPositive($pid));
        }
        else{
            $this->ajaxReturn(array('success'=>false, 'info'=> '缺少参数!'));
        }
    }

    //获取反对的数量
    public function getNumberOfNegatives(){
        $pid = $_GET['pid'];
        if($pid>0){
            $this->ajaxReturn(D('ProjectAttitude')->numberOfNegative($pid));
        }
        else{
            $this->ajaxReturn(array('success'=>false, 'info'=> '缺少参数!'));
        }
    }

    //获取所有态度
    public function getNumberOfAttitudes(){
        $pid = $_GET['pid'];
        if($pid>0){
            $data['negative'] = D('ProjectAttitude')->numberOfNegative($pid)['info'];
            $data['positive'] = D('ProjectAttitude')->numberOfPositive($pid)['info'];
            $data['total'] = $data['negative']+$data['$positive'];
            $this->ajaxReturn(array('success'=>true, 'info'=> $data));
        }
        else{
            $this->ajaxReturn(array('success'=>false, 'info'=> '缺少参数!'));
        }
    }
}
?>