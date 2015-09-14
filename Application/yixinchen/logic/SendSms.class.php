<?php
namespace yixinchen\logic;
/**
 * Created by PhpStorm.
 * User: 56bd
 * Date: 2015/9/1
 * Time: 16:28
 */
 class SendSms
 {
     function sendSMS($mobile,$content)
     {
        $Data=new \yixinchen\model\SendSms();
         $Arrarys=$Data->sendSMS($mobile,$content);
         return $Arrarys;
     }
 }