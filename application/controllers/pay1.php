<?php
require_once (APPPATH.'libraries/log.php');
//初始化日志
$logHandler= new CLogFileHandler(APPPATH."libraries/logs/".date('Y-m-d').'.log');
Log::Init($logHandler, 15);
//我在控制器最顶部加了这个实例化，日志文件放在了application/logs文件夹
//调用方式：log::debug("输出信息");简单记录执行信息方便调试

class Pay extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('user_model');
        $this->load->helper ( array (
            'form',
            'url_helper',
            'cookie'
        ) );
        $this->load->library( array (
            'session',
            'form_validation'
        ) );
    }

    public function index()
    {
        //是否登录
        if (NULL == $_SESSION['username']) {
            redirect('http://' . $_SERVER['HTTP_HOST'] . '/user');
        }
        $data['title']='在线充值';

        $this->form_validation->set_rules('fee', '充值金额', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_error_delimiters('<span class="red" style="width:9rem;">','</span>');

        $this->load->view('templates/head_simple', $data);
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('home/user/recharge',$data);
        }else {

            switch ($this->input->post('paymethod', TRUE)) {
                case '01':
                    $this->weiXin($this->input->post('fee', TRUE), $_SESSION['username']);
                    break;
                case '02':
                    $data['payError'] = "暂不支持支付宝";
                    $this->load->view('home/user/recharge', $data);
                    break;
                default:
                    $data['payError'] = "请重新选择支付方式";
                    $this->load->view('home/user/recharge', $data);

            }

        }
        $this->load->view('templates/footer2', $data);

    }

    /**
     * 微信二维码支付页
     *
     */
    public function weiXin($total_fee,$username)
    {
        if (!file_exists(APPPATH . 'views/home/pay/weixin.php')) {
            show_404();
        }

        $this->load->config('wxpay_config');
        $wxconfig['appid'] = $this->config->item('appid');
        $wxconfig['mch_id'] = $this->config->item('mch_id');
        $wxconfig['apikey'] = $this->config->item('apikey');
        $wxconfig['appsecret'] = $this->config->item('appsecret');
        $wxconfig['sslcertPath'] = $this->config->item('sslcertPath');
        $wxconfig['sslkeyPath'] = $this->config->item('sslkeyPath');
//由于此类库构造函数需要传参，我们初始化类库就传参数给他吧
        $this->load->library('Wechatpay', $wxconfig);
        $out_trade_no = $this->getTradeNo();

        //必填 商品简单描述
        $param['body'] = "零工币充值";
        //附加数据，在查询API和支付通知中原样返回，可作为自定义参数使用。
        $param['attach'] = $username;
        //商品详细列表
        $param['detail'] = "fdsadsa";
        $param['out_trade_no'] = $out_trade_no;
        $param['total_fee'] = $total_fee * 100;//$total_fee * 100;//微信支付单位默认分
        $param["spbill_create_ip"] = $_SERVER['REMOTE_ADDR'];//客户端IP地址
        $param["time_start"] = date("YmdHis");//请求开始时间
        $param["time_expire"] = date("YmdHis", time() + 600);//请求超时时间
        $param["goods_tag"] = urldecode("零工币充值");//商品标签，自行填写
        $param["notify_url"] = "/user/wxnotify";//自行定义异步通知url
        $param["trade_type"] = "NATIVE";//扫码支付模式二
        $param["product_id"] = "1";//看文档说自己定义

        //调用统一下单API接口
        $result = $this->wechatpay->unifiedOrder($param);
        //这里可以加日志输出，log::debug(json_encode($result));
//成功（return_code和result_code都为SUCCESS）就会返回含有带支付二维码链接的数据
        if (isset($result["code_url"]) && !empty($result["code_url"])) { //二维码图片链接
            $data['wxurl'] = $result["code_url"];
//这里传递商户订单号到扫码视图，是因为我想做跳转，根据商户号去查询订单是否支付成功，如果成功了就跳转，定时轮询微信服务器

            $data['orderno'] = $out_trade_no;
            $data['uid']=$_SESSION['uid'];
            $data['type']='credit1';
            $data['wayid']=2;
            $data['credits']=$total_fee;
            $data['cost']=$total_fee;

            $data['localhost'] = $_SERVER['HTTP_HOST'];// 当前域名
            $data['title'] = '微信支付页'; // 网页标题

            $this->load->view('home/pay/weixin', $data);

        }
    }


    public function queryOrder()
    {
        $this->load->config('wxpay_config');
        $wxconfig['appid'] = $this->config->item('appid');
        $wxconfig['mch_id'] = $this->config->item('mch_id');
        $wxconfig['apikey'] = $this->config->item('apikey');
        $wxconfig['appsecret'] = $this->config->item('appsecret');
        $wxconfig['sslcertPath'] = $this->config->item('sslcertPath');
        $wxconfig['sslkeyPath'] = $this->config->item('sslkeyPath');
        $this->load->library('Wechatpay', $wxconfig);
        $out_trade_no = $_POST['orderno'];//调用查询订单API接口
        $array = $this->wechatpay->orderQuery('', $out_trade_no);
        $array['trade_state']=='SUCCESS';//测试
        if($array['trade_state']=='SUCCESS'){
            $return=$this->user_model->recharge($_POST);
            $array['flag']=$return['flag'];
            $array['info']=$return['info'];
        }
        echo json_encode($array);
    }

    public function qrcode()
    {
        require_once(APPPATH . 'libraries/phpqrcode/phpqrcode.php');
        $url = urldecode($_GET["data"]);
        QRcode::png($url);
    }

//微信异步通知
    public function WXnotify()
    {
//$postStr = file_get_contents("php://input");//因为很多都设置了register_globals禁止,不能用$GLOBALS["HTTP_RAW_POST_DATA']　　　　 //这部分困扰了好久用上面这种一直接受不到数据，或者接受了解析不正确，最终用下面的正常了，有哪位愿意指点的可以告知一二
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];//这个需要开启;always_populate_raw_post_data = On
        $this->load->config('wxpay_config');
        $wxconfig['appid'] = $this->config->item('appid');
        $wxconfig['mch_id'] = $this->config->item('mch_id');
        $wxconfig['apikey'] = $this->config->item('apikey');
        $wxconfig['appsecret'] = $this->config->item('appsecret');
        $wxconfig['sslcertPath'] = $this->config->item('sslcertPath');
        $wxconfig['sslkeyPath'] = $this->config->item('sslkeyPath');
        $this->load->library('Wechatpay', $wxconfig);
        libxml_disable_entity_loader(true);
        $array = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        log::debug($xml);
        log::debug(json_encode($array));
        if ($array != null) {
            $out_trade_no = $array['out_trade_no'];
            $trade_no = $array['transaction_id'];
            $data['orderid'] = $array['attach'];
            $this->load->model('payorder');
            $payinfo = $this->payorder->GetPayorder(array('orderno' => $out_trade_no));
            if (!$payinfo) {
                $data['orderno'] = $out_trade_no;
                $data['money'] = $array['total_fee'];
                $data['tradeno'] = $trade_no;
                $rs = $this->payorder->AddPayorder($data);
                if ($rs > 0) {//告知微信我成功了
                    $this->wechatpay->response_back();
                } else {//告知微信我失败了继续发
                    $this->wechatpay->response_back("FAIL");
                }
            } else {
                $this->wechatpay->response_back();
            }
        }
    }


    function getTradeNo()
    {//生成24位唯一订单号码，格式：YYYY-MMDD-HHII-SS-NNNN,NNNN-CC，其中：YYYY=年份，MM=月份，DD=日期，HH=24格式小时，II=分，SS=秒，NNNNNNNN=随机数，CC=检查码

        @date_default_timezone_set("PRC");

        while (true) {

            //订购日期

            $order_date = date('Y-m-d');

            //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）

            $order_id_main = date('YmdHis') . rand(10000000, 99999999);

            //订单号码主体长度

            $order_id_len = strlen($order_id_main);

            $order_id_sum = 0;

            for ($i = 0; $i < $order_id_len; $i++) {

                $order_id_sum += (int)(substr($order_id_main, $i, 1));

            }

            //唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）

            return $order_id = $order_id_main . str_pad((100 - $order_id_sum % 100) % 100, 2, '0', STR_PAD_LEFT);
        }
    }

    //点击零工宝页我的账户，跳转到账户明细页
    public function myaccount(){
        if ( ! file_exists(APPPATH.'views/home/pay/account.php')){
            show_404();
        }
        //var_dump($_SESSION);
        $uid = $_SESSION['uid'];
            $this->load->model('main_model');
            $citycode = $this->main_model->getCityCode();       //地区名
            $city_arr = $this->main_model->getCityInfoByCode($citycode);
            $data['cityname'] = $city_arr['name'];
            $data['title'] = '我的账户'; // 定义标题

            $test['uid'] = $_SESSION['uid'];
            $type = $this->uri->segment(3);
            if($type){
                $test['type'] = $type;
            }else{
                $test['type'] = 1;
            }
            $data['itemstype'] = $test['type'];
            $data['items'] = $this->user_model->getUsercreditsItems($test);//获取用户三类明细
            //var_dump($data['items']);
            $data['credit'] = $this->user_model->getUsercredit($uid);//根据uid获得用户零工比。工分余额

            $this->load->view('templates/header',$data);
            $this->load->view('home/pay/account',$data);
            $this->load->view('templates/footer2');
    }
}