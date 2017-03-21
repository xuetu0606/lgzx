<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Getcode extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'user_model',
            'form_model'
        ));

        $this->load->library(array(
            'session'
        ));

//        $this->load->database();//测试用

    }

    /**
     * 手机验证码
     *$page异步提交参数  reg注册页  res重置密码页 ksfb快速发布
     */
    public function index($page)
    {

        $mobile = $this->input->post('mobile', TRUE);
        $page == 'res' && $username = $this->input->post('username', TRUE);
        $return["status"] = "failed";

        $uid = $this->user_model->checkMobile($mobile);//根据手机获取uid
        $username_db = $this->user_model->username;
        $ksfb = $this->form_model->checkQuickPublish($uid);//根据uid判断是否快速发布过

        if (!$mobile) {
            $return['msg'] = '请填写手机号码';
        } else {
            if (!$this->user_model->checkIsMobile($mobile)) {

                $return['msg'] = '请填写有效手机号';

            } elseif ($uid and $page == 'reg') {

                $return['msg'] = '该手机号已被注册';

            } elseif ($ksfb and $page == 'ksfb') {

                $return['msg'] = '该手机号已发布';
            } elseif ($username && $page == 'res' && $username != $username_db) {
                $return['msg'] = '您填写的手机号码匹配的用户名有误，请检查后重新填写';

            } else {
                //重新发送时间限制
                //if($this->sendTime($mobile)){
                //生成随机验证码
                $code = $this->random(6);
                //发送内容
                $content = '【零工在线】您的短信验证码：' . $code . '，请正确输入验证码完成操作。请勿向任何人提供您收到的短信验证码';
                if ($this->sendSMS($mobile, $content)) {
                    //if(1){
                    $return["status"] = "success";
                    $return['msg'] = '发送成功';
                    $_SESSION[$page . 'code'] = $code;

                } else {
                    $return['msg'] = '发送失败';
                }
                // }else{
                //$return['msg']='正在发送中';
                //}


            }


        }

        echo json_encode($return);

    }

    /**
     * 发送手机验证码
     *
     */
    public function sendSMS($mobile, $content, $time = '', $mid = '')
    {
        $uid = 'qdlgzx';    //用户账号
        $pwd = '63827c906e4e2995130b96c6267ca3da';    //用户密码
        $http = 'http://115.29.103.223:8080/smsServer/submit';        //发送地址
        $data = array
        (
            'CORPID' => $uid,                //用户账号
            'CPPW' => $pwd,                //密码
            'PHONE' => $mobile,                //被叫号码
            'CONTENT' => $content,                //内容
        );
        $re = '#' . $this->postSMS($http, $data);
        if (strpos($re, "SUCCESS") > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function postSMS($url, $data = '')
    {
        $row = parse_url($url);
        $host = $row['host'];
        $port = $row['port'] ? $row['port'] : 8080;
        $file = $row['path'];
        foreach ($data as $k => $v) {
            $post .= rawurlencode($k) . "=" . rawurlencode($v) . "&";    //转URL标准码
        }
        $post = substr($post, 0, -1);
        $len = strlen($post);
        $fp = fsockopen($host, $port, $errno, $errstr, 10);
        if (!$fp) {
            return "$errstr ($errno)\n";
        } else {
            $receive = '';
            $out = "POST $file HTTP/1.1\r\n";
            $out .= "Host: $host\r\n";
            $out .= "Content-type: application/x-www-form-urlencoded\r\n";
            $out .= "Connection: Close\r\n";
            $out .= "Content-Length: $len\r\n\r\n";
            $out .= $post;
            fwrite($fp, $out);
            while (!feof($fp)) {
                $receive .= fgets($fp, 128);
            }
            fclose($fp);
            $receive = explode("\r\n\r\n", $receive);
            unset($receive[0]);
            return implode("", $receive);
        }
    }

    /**
     * 生成随机数
     *
     */
    public function random($v)
    {
        srand((double)microtime() * 1000000);//create a random number feed.
        $ychar = "0,1,2,3,4,5,6,7,8,9";
        $list = explode(",", $ychar);
        for ($i = 0; $i < $v; $i++) {
            $randnum = rand(0, 10); // 10+26;
            $authnum .= $list[$randnum];
        }
        return $authnum;
    }

}
