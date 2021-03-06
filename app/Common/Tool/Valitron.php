<?php
/**
 * 验证类
 * Date: 2018/5/2
 * Time: 15:47
 */
namespace App\Common\Tool;

use phpDocumentor\Reflection\Types\Boolean;
use App\Lib\Valitron\Validator;
use App\Common\Tool\Util;
use Swoft\Bean\Annotation\Inject;

/**
 * @\Swoft\Bean\Annotation\Bean("Valitron")
 */
class Valitron{

    /**
     * @\Swoft\Bean\Annotation\Inject("Token")
     * @var \App\Common\Tool\Token
     */
    private $token;


    /**
     * 登录时表单验证
     * @param $data
     * @param $field
     * @param $request
     * @return array|bool
     */
    public function valitronSignin($data,$field,$request)
    {
        $token = $this->token->getCookie($request);
        $Validator = new Validator($data);
        $Validator->rule("required",$field);  //不能为空
        $Validator->rule('phone',['phone_num']); //检查电话
        $Validator->rule('length',['code'],4);   //检查CODE
        $Validator->rule('equals',$token,['token']);
        $message_list = array(
            'phone_num.required' => Util::getMsg('login_phone_empty'),
            'phone_num.phone'    =>  Util::getMsg('login_phone_error'),
            'token.required' =>  Util::getMsg('Infoexpired'),
            'code.required'  =>  Util::getMsg('login_input_code'),
            'code.lengthbetween'    =>  Util::getMsg('login_verify_error'),
            'token.equals'          => Util::getMsg('login_token_error'),
        );
        if ($Validator->validate($message_list)){
                $ret =  $this->token->verifyToken($token);
                return $ret;
        }else{
             return  $Validator->errors();
        }
    }

    /**
     * 发短信基本验证
     * @param $data
     * @param $field
     * @return array|bool
     */
    public static function valitronSendSms($data,$field)
    {
        $Validator = new Validator($data);
        $Validator->rule("required",$field);  //不能为空
        $Validator->rule('phone',['phone']); //检查电话
        $Validator->labels([
            'phone' => '手机号',
            'code'  => '验证码'
        ]);
        $message_list = array(
            'phone.required' => Util::getMsg('login_phone_empty'),
            'phone.phone'    => Util::getMsg('login_phone_error'),
            'token.required' => Util::getMsg('emptyCookie')
        );
        if ($Validator->validate($message_list)){
            return true;
        }else{
            return $Validator->errors();
        }
    }

    /**
     * 判断两个值是否相等
     * @param $str1
     * @param $str2
     */
    public static function valitronEquals($str1,$str2)
    {
        $data = ['str1' => $str1,'str2' => $str2];
        $Validator = new Validator($data);
        $Validator->rule('equals',$str1,['str2']);
        if ($Validator->validate()) {
            return true;
        }
        return false;
    }

    /**
     * 验证手机号
     * @param string $phone
     * @return array|bool
     */
    public static function valitronPhone($phone = '')
    {
        $data = ['phone' => $phone];
        $Validator = new Validator($data);
        $Validator->rule("required",['phone']);  //不能为空
        $Validator->rule('phone',['phone']); //检查电话
        $message_list = array(
            'phone.required' => 'login_phone_empty',
            'phone.phone'    => 'login_phone_error',
        );
        if ($Validator->validate($message_list)){
            return true;
        }else{
            return $Validator->errors();
        }
    }

    /**
     * 检查字符是否为空
     * @param $str
     * @return array|bool
     */
    public static function valitronString($str)
    {
        $data = ['str' => $str];
        $Validator = new Validator($data);
        $Validator->rule("required",['str']);  //不能为空
        if ($Validator->validate()){
            return true;
        }else{
            return $Validator->errors();
        }
    }

    /**
     * 数字验证
     * @param $numeric
     * @param int $min
     * @param int $max
     * @return array|bool
     */
    public function valitronNumeric($numeric,$min=1,$max=10000)
    {
        $data = ['numeric' => $numeric];
        $Validator = new Validator($data);
        $Validator->rule("required",['numeric']);  //不能为空
        $Validator->rule("numeric", ['numeric']);  //只能是数字
        $Validator->rule("min",$min,['numeric']);  //最小为1
        $Validator->rule("max",$max,['numeric']);  //最大为max
        if ($Validator->validate()){
              return true;
        }else{
            return $Validator->errors();
        }
    }


    /**
     * 注册验证
     * @param $data
     * @return boolean
     */
    public function verificationRegister($data)
    {
        if(strlen($data['password']) < 6){
            return [['login_password_length_min']];
        }
        if(strlen($data['password']) > 20){
            return [['login_password_length_max']];
        }
        $Validator = new Validator($data);
        $Validator->rule("required",['phone']);
        $Validator->rule("required",['password']);
        $Validator->rule("required",['nike_name']);
        $Validator->rule("required",['token']);
        $Validator->rule("required",['verCode']);
        $Validator->rule('phone',['phone']); //检查电话
        $Validator->rule('length',['verCode'],4);   //检查CODE
        $message_list = array(
            'phone.required' => 'login_phone_empty',
            'phone.phone'    => 'login_phone_error',
            'password.required'  => 'login_password_empty',
            'nike_name.required' => 'login_input_nickName',
            'verCode.required'   => 'login_input_code',
            'verCode.length'     => 'login_verify_error',
            'token.required'     => 'emptyCookie'
        );
        if ($Validator->validate($message_list)){
                return true;
        }else{
              return $Validator->errors();
        }
    }

    /**
     * 登录验证
     * @param $data
     * @return array
     */
    public function verificationSigin($data)
    {
         if(strlen($data['password']) < 6){
             return ['login_password_length_min'];
         }
        if(strlen($data['password']) > 20){
            return ['login_password_length_max'];
        }
        $newToken = md5($data['phone'].','.$data['password'].'zxr');
        $Validator = new Validator($data);
        $Validator->rule("required",['phone']);
        $Validator->rule("required",['password']);
        $Validator->rule("required",['token']);
        $Validator->rule('phone',['phone']);
        $Validator->rule('equals',$newToken,['token']);
        $message_list = array(
            'phone.required' => 'login_phone_empty',
            'phone.phone'    => 'login_phone_error',
            'password.required' => 'login_password_empty',
            'token.required'    => 'emptyCookie',
            'token.equals'      => 'emptyCookie'
        );
        if ($Validator->validate($message_list)){
               return true;
        }else{
            return $Validator->errors();
        }
    }

}


