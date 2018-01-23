<?php
/**
 * 测试脚本
 * User: wangyongqiang
 * Date: 2018/1/23 17:43
 */
require './vendor/autoload.php';
class Demo{
    /**
     * 获取图形验证码
     */
    public function getCode(){
        $captcha = new Captcha();

        $verifyid = uniqid();
        $res = $captcha->entry($verifyid);

        //step 1 缓存验证码键值对
        //Cache::set($res['verify_key'], $res['verify_code']);

        //step 2 通过接口返回
        echo json_encode(['verify_id'=>$verifyid, 'verify_img'=>$res['verify_img']]);
    }

    /**
     * 验证码校验
     */
    public function checkCode(){
        $verify_id  = $_REQUEST['verify_id'];
        $ucode      = $_REQUEST['verify_code'];
        $captcha = new Captcha();

        //step 1 根据请求的验证码ID,从缓存中获取 原始 验证码的值
        $capKey = $captcha->authcode($verify_id);
        //$verifycode = Cache::get($capKey);
        $verifycode = 'YS4G8';//TODO 缓存中获取的验证码示例
        if(!$verifycode){
            echo '验证码过期';
        }

        //step 2 对比用户输入验证码和原始验证码
        $flag = $captcha->check($ucode, $verifycode);
        if(!$flag){
            echo '请输入正确的验证码';
        }

        echo 'success';
    }
}
$demo = new Demo();
//1
$demo->getCode();
