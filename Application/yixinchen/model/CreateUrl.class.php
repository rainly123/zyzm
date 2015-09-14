<?php
namespace yixinchen\model;
/**
 * Created by PhpStorm.
 * User: 56bd
 * Date: 2015/9/1
 * Time: 16:16
 */
class CreateUrl
{
    private $baseurl="http://119.145.9.12/sendSMS.action";
    private $enterpriseID="16338";
    private $loginName="admin";
    private $password="hhsj543123";


    /**
     * @param $moblie
     * @param $contengt
     * 组装url
     */
     function createURL($moblie,$contengt)
    {
        $data=array("enterpriseID" =>$this->enterpriseID,"loginName"=>$this->loginName,
                    "password"=>md5($this->password),"content"=>$contengt,"mobiles"=>$moblie);
         $result= $this->sendSms($data);
         return $result;
    }

    /**
     * 向平台发送请求
     */
   private  function sendSms($data)
    {
        $xml=curlPost($this->baseurl,$data);
        return $this-> readXML($xml);
    }

    /**
     * 解析xml
     * @param $xml
     * @return array
     */
   private  function readXML($xml) {
        preg_match_all("/\<Response\>(.*)\<\/Response\>/",$xml,$parents);//匹配最外层
        foreach($parents[1] as $key=>$parent)
        {
            preg_match_all("/\<Result\>(.*)\<\/Result\>/",$parent,$result);
            if($result[1][0]==0)
            {
                preg_match_all("/\<SmsId\>(.*)\<\/SmsId\>/",$parent,$smsId);
                $Arrarys=array("result"=>$result[1][0],"smsId"=>$smsId[1][0]);
            }
            else
            {
                switch($result[1][0])
                {
                    case 1:
                        $Arrarys=array("result"=>$result[1][0],"smsId"=>"登录密码错误");
                        break;
                    case 2:
                        $Arrarys=array("result"=>$result[1][0],"smsId"=>"企业ID或登录名错误");
                        break;
                    case 3:
                        $Arrarys=array("result"=>$result[1][0],"smsId"=>"余额不足");
                        break;
                    case 4:
                        $Arrarys=array("result"=>$result[1][0],"smsId"=>"用户归属服务器错误");
                        break;
                    case 5:
                        $Arrarys=array("result"=>$result[1][0],"smsId"=>"帐户停用或不存在");
                        break;
                    case 6:
                        $Arrarys=array("result"=>$result[1][0],"smsId"=>"内容为空");
                        break;
                    case 7:
                        $Arrarys=array("result"=>$result[1][0],"smsId"=>"号码为空");
                        break;
                    case 8:
                        $Arrarys=array("result"=>$result[1][0],"smsId"=>"号码超过最大限制数");
                        break;
                    case 9:
                        $Arrarys=array("result"=>$result[1][0],"smsId"=>"内容包含关键字");
                        break;
                    case 10:
                        $Arrarys=array("result"=>$result[1][0],"smsId"=>"时间格式错误");
                        break;
                    case 11:
                        $Arrarys=array("result"=>$result[1][0],"smsId"=>"非法操作导致ip被锁");
                        break;
                    case 12:
                        $Arrarys=array("result"=>$result[1][0],"smsId"=>"访问过快");
                        break;
                    case 13:
                        $Arrarys=array("result"=>$result[1][0],"smsId"=>"批量一对一参数格式错误");
                        break;
                    case 14:
                        $Arrarys=array("result"=>$result[1][0],"smsId"=>"批量一对一出现重复信息(号码，内容同时重复)");
                        break;
                    case 17:
                        $Arrarys=array("result"=>$result[1][0],"smsId"=>"签名错误（没有签名）");
                        break;
                    case 99:
                        $Arrarys=array("result"=>$result[1][0],"smsId"=>"系统内部错误");
                        break;
                    default:
                        $Arrarys=array("result"=>$result[1][0],"smsId"=>"系统内部错误");
                        break;
                }
            }

        }
        return $Arrarys;
    }

}