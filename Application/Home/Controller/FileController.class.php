<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use Think\Image;
/**
 * 文件控制器
 * 主要用于下载模型的文件上传和下载
 */

class FileController extends HomeController {
    /* 文件上传 */
    public function upload(){
        $return  = array('status' => 1, 'info' => '上传成功', 'data' => '');
        /* 调用文件上传组件上传文件 */
        $File = D('File');
        $file_driver = C('DOWNLOAD_UPLOAD_DRIVER');
        $info = $File->upload(
            $_FILES,
            C('DOWNLOAD_UPLOAD'),
            C('DOWNLOAD_UPLOAD_DRIVER'),
            C("UPLOAD_{$file_driver}_CONFIG")
        );

        /* 记录附件信息 */
        if($info){
            $return['data'] = think_encrypt(json_encode($info['download']));
        } else {
            $return['status'] = 0;
            $return['info']   = $File->getError();
        }

        /* 返回JSON数据 */
        $this->ajaxReturn($return);
    }

    public function uploadProj() {

        /* 返回标准数据 */
        $return  = array('status' => 1, 'info' => '上传成功', 'data' => '');


        /* 调用文件上传组件上传文件 */
        $Picture = D('Picture');
        $pic_driver = C('PROJ_UPLOAD_DRIVER');
        $info = $Picture->upload(
            $_FILES,
            C('PROJ_UPLOAD'),
            C('PROJ_UPLOAD_DRIVER'),
            C("UPLOAD_{$pic_driver}_CONFIG")
        ); //TODO:上传到远程服务器
        //zhaobb2015.3.22
        $info = reset($info);
        /* 记录图片信息 */
        if($info){
            $return['status'] = 1;
            //$return = array_merge($info['download'], $return);
            //zhaobb2015.3.22
            $return = array_merge($info, $return);
        } else {
            $return['status'] = 0;
            $return['info']   = $Picture->getError();
        }

        /* 返回JSON数据 */
        echo json_encode($return);
        //$this->ajaxReturn($return);
    }

    public function uploadProduct() {

        /* 返回标准数据 */
        $return  = array('status' => 1, 'info' => '上传成功', 'data' => '');

        /* 调用文件上传组件上传文件 */
        $Picture = D('Picture');
        $pic_driver = C('PRODUCT_UPLOAD_DRIVER');

        $info = $Picture->upload(
            $_FILES,
            C('PRODUCT_UPLOAD'),
            C('PRODUCT_UPLOAD_DRIVER'),
            C("UPLOAD_{$pic_driver}_CONFIG")
        ); //TODO:上传到远程服务器
        $info = reset($info);

        /* 记录图片信息 */
        if($info){
            $return['status'] = 1;
            $return = array_merge($info, $return);
        } else {
            $return['status'] = 0;
            $return['info']   = $Picture->getError();
        }

        /* 返回JSON数据 */
        echo json_encode($return);
        //$this->ajaxReturn($return);
    }

    /* 下载文件 */
    public function download($id = null){
        if(empty($id) || !is_numeric($id)){
            $this->error('参数错误！');
        }

        $logic = D('Download', 'Logic');
        if(!$logic->download($id)){
            $this->error($logic->getError());
        }
        
    }

    /**
     * 上传头像图片
     * @author huajie <banhuajie@163.com>
     */
    public function uploadPhoto(){
        //TODO: 用户登录检测

        /* 返回标准数据 */
        $return  = array('status' => 1, 'info' => '上传成功', 'data' => '');

        /* 调用文件上传组件上传文件 */
        $Picture = D('Picture');
        $pic_driver = C('PHOTO_UPLOAD_DRIVER');
        $info = $Picture->upload(
            $_FILES,
            C('PHOTO_UPLOAD'),
            C('PHOTO_UPLOAD_DRIVER'),
            C("UPLOAD_{$pic_driver}_CONFIG")
        ); //TODO:上传到远程服务器

        /* 记录图片信息 */
        if($info){
          $return['status'] = 1;
          $return = array_merge($info['download'], $return);

	        $image = new Image();
	        $path = strpos($return['path'], '/') == 0 ? substr($return['path'], 1) : $return['path'];
	        $image->open($path);
	        if ($image->width() > 500 || $image->width > 300) {
	            $image->thumb(500,300);
	            $image->save($path, null, 100, true);
	        }
        } else {
            $return['status'] = 0;
            $return['info']   = $Picture->getError();
        }

        /* 返回JSON数据 */
        echo json_encode($return);
    	//$this->ajaxReturn($return);
    }

    /**
     * 上传头像图片
     * @author huajie <banhuajie@163.com>
     */
    public function uploadCard(){
        //TODO: 用户登录检测

        /* 返回标准数据 */
        $return  = array('status' => 1, 'info' => '上传成功', 'data' => '');

        /* 调用文件上传组件上传文件 */
        $Picture = D('Picture');
        $pic_driver = C('CARD_UPLOAD_DRIVER');
        $info = $Picture->upload(
            $_FILES,
            C('CARD_UPLOAD'),
            C('CARD_UPLOAD_DRIVER'),
            C("UPLOAD_{$pic_driver}_CONFIG")
        ); //TODO:上传到远程服务器

        /* 记录图片信息 */
        if($info){
            $return['status'] = 1;
            $return = array_merge($info['download'], $return);
        } else {
            $return['status'] = 0;
            $return['info']   = $Picture->getError();
        }

        /* 返回JSON数据 */
        $this->ajaxReturn($return);
    }
}
