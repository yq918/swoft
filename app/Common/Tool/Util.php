<?php
/**
 * 工具类
 * Date: 2018/5/2
 * Time: 15:47
 */
namespace App\Common\Tool;

use Swoft\Http\Message\Server\Request;
use Swoft\Helper\ResponseHelper;
use Swoft\Helper\JsonHelper;

class Util{

    /**
     * 登录页面 生成token
     * @param Request $request
     * @return string
     */
    public static function generatingLoginToken(Request $request)
    {
        $server = $request->getSwooleRequest()->server;
        $token = md5( $server['remote_addr']. uniqid());
        return $token;
    }

    /**
     * 返回消息
     * @param array $data
     * @param $msgCode
     * @param $language
     * @return array
     */
    public static function showMsg($data=[],$msgCode,$language='zh')
    {
        $msg  = self::getMsg($msgCode,$language);
        $code = translate('Code.'.$msgCode, [], $language);
        $data = JsonHelper::encode($data);
        return  ResponseHelper::formatData($data,$msg,$code);
    }

    /**
     * 根据code 获取消息
     * @param $code
     * @param $language
     * @return string
     */
    public static function getMsg($code,$language='zh')
    {
        $msg  = translate('msg.'.$code, [], $language);
        return $msg;
    }


}

