<?php
namespace yixinchen\model;
/**
 * Created by PhpStorm.
 * User: 56bd
 * Date: 2015/9/1
 * Time: 16:27
 */
class SendSms
{
    function sendSMS($mobile,$content)
    {
        $Data=new Smssingle();
        $Arrarys =$Data->single()->createURL($mobile,$content);
        return $Arrarys;
    }
}