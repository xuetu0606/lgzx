<?php
class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'user_model',
            'list_model',
            'form_model',
            'main_model'
        ));
        $this->load->helper(array(
            'form',
            'url_helper',
            'cookie'
        ));
        $this->load->library(array(
            'session',
            'form_validation'
        ));

    }

    /**
     * 零工宝
     *
     */
    public function index()
    {
        if (!file_exists(APPPATH . 'views/home/user/center.php')) {
            show_404();
        }
        $data['title'] = '我的发布'; // 网页标题
        $data['foot_js']='<script src="/static/js/lgb.js"></script>';
        $data['head_css']='<link rel="stylesheet" href="/static/css/lgb-wdfb.css"/>
            <link rel="stylesheet" href="/static/css/lgb.css"/>
            <style>
            .m h1,.m h2,.m h3{ margin: 5px 0;}
            </style>';

        $citycode = $this->main_model->getCityCode();        //地区名
        $city_arr = $this->main_model->getCityInfoByCode($citycode);
        $data['cityname'] = $city_arr['name'];

        if (!$this->hasLogin()) {
            redirect('http://' . $_SERVER['HTTP_HOST'] . '/user/login');
        }

        $data['user'] = $this->user_model->getUserBaseInfo($_SESSION['uid'],0,0,1);

        //获取已发布工种
        $count = $this->form_model->getMyGZPublish($_SESSION['uid'],$start,$fenye,1);

        if ($this->session->is_co) {
            $data['zlg'] = $this->form_model->getMyZlgPublish($_SESSION['uid']);
        }

        $this->load->library('pagination');
        $fenye=6;//分页数

        $pagenum=count($count);

        $config['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/user/index/';
        $config['total_rows'] = $pagenum;
        $config['per_page'] = $fenye;
        $config['num_links']=3;
        $config['use_page_numbers']=true;
        $config['first_link'] = '首页';
        $config['prev_link'] = '上页';
        $config['next_link'] = '下页';
        $config['last_link'] = '最后页';


        $this->pagination->initialize($config);

        $data['page']=$this->pagination->create_links();

        $id=$this->uri->segment(3, 0);
        $id=$id?$id:1;
        $start=($id-1)*$fenye;
        $data['gong'] = $this->form_model->getMyGZPublish($_SESSION['uid'],$start,$fenye,1);
        $data['gong_del'] = $this->form_model->getMyGZPublish($_SESSION['uid'],$start,$fenye,-1);
        $data['gong_not'] = $this->form_model->getMyGZPublish($_SESSION['uid'],$start,$fenye,0);

        //var_dump($data['gong']);
        //var_dump($data);

        $this->load->view('home/user/templates/header', $data);
        $this->load->view('home/user/lgb', $data);
        $this->load->view('home/user/templates/footer', $data);
    }



    /**
     * 用户登录
     *
     */
    public function login()
    {
        if (!file_exists(APPPATH . 'views/home/user/login.php')) {
            show_404();
        }

        //获取来源url
        if(!$_POST){
            $_SESSION['source_url']=$_SERVER['HTTP_REFERER'];
        }
        $url=$_SESSION['source_url'];


        //是否登录
        if ($this->hasLogin()) {
            //redirect('http://' . $_SERVER['HTTP_HOST'] . '/user/center');
            redirect($url);
        }

        $data['title'] = '零工在线登录';//网页标题
        $data['localhost'] = $_SERVER['HTTP_HOST'];//获取当前域名

        $this->form_validation->set_rules('username', '用户名', 'trim|required|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('passwd', '密码', 'trim|required|min_length[6]');
        $this->form_validation->set_error_delimiters('<span>', '</span>');

        $this->load->view('templates/header', $data);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('home/user/login', $data);
        } else {
            $userdata['username'] = $this->input->post('username', TRUE);

            //密码是否cookie
            if ($this->input->post('passwd', TRUE) == get_cookie('passwd')) {
                $userdata['passwd'] = $this->input->post('passwd', TRUE);
            } else {
                $userdata['passwd'] = $this->user_model->encryptPwd($this->input->post('passwd', TRUE));
            }

            $user = $this->user_model->getuserlist($userdata);

            if (!empty($user)) {

                /** 记录用户登录状态 */
                $_SESSION['uid'] = $user['uid'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['no'] = $user['no'];
                $_SESSION['is_co'] = $user['is_co'];

                if ($this->input->post('remember', TRUE)) {
                    set_cookie("username", $userdata['username'], 60);
                    set_cookie("passwd", $userdata['passwd'], 60);
                } else {
                    delete_cookie('username');
                    delete_cookie('passwd');
                }

                if($url){
                    redirect($url);
                }else{
                    redirect('http://' . $_SERVER['HTTP_HOST'] . '/user');
                }

            } else {

                $data['error_string'] = '用户名和密码不符';
                $data['userdata'] = $userdata;

                $this->load->view('home/user/login', $data);
            }


        }
        //$this->load->view('templates/footer');
    }

    /**
     * 我要评价页登录===用户登录
     *
     */
    public function evallogin()
    {
        if (!file_exists(APPPATH . 'views/home/user/login.php')) {
            show_404();
        }

        //是否登录
        if ($this->hasLogin()) {
            redirect('http://' . $_SERVER['HTTP_HOST'] . 'home/tail/evaluate');
        }

        $data['title'] = '零工在线登录';//网页标题
        $data['localhost'] = $_SERVER['HTTP_HOST'];//获取当前域名

        $this->form_validation->set_rules('username', '用户名', 'trim|required|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('passwd', '密码', 'trim|required|min_length[6]');
        $this->form_validation->set_error_delimiters('<span>', '</span>');

        $this->load->view('templates/head_simple', $data);
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('home/user/login', $data);
        } else {
            $userdata['username'] = $this->input->post('username', TRUE);

            //密码是否cookie
            if ($this->input->post('passwd', TRUE) == get_cookie('passwd')) {
                $userdata['passwd'] = $this->input->post('passwd', TRUE);
            } else {
                $userdata['passwd'] = $this->user_model->encryptPwd($this->input->post('passwd', TRUE));
            }

            $user = $this->user_model->getuserlist($userdata);

            if (!empty($user)) {

                /** 记录用户登录状态 */
                $_SESSION['uid'] = $user['uid'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['no'] = $user['no'];
                $_SESSION['is_co'] = $user['is_co'];

                if ($this->input->post('remember', TRUE)) {
                    set_cookie("username", $userdata['username'], 60);
                    set_cookie("passwd", $userdata['passwd'], 60);
                } else {
                    delete_cookie('username');
                    delete_cookie('passwd');
                }
                redirect('http://' . $_SERVER['HTTP_HOST'] . '/home/tail/evaluate');
            } else {

                $data['error_string'] = '用户名和密码不符';
                $data['userdata'] = $userdata;

                $this->load->view('home/tail/evaluate', $data);
            }


        }
        $this->load->view('templates/footer2');
    }

    /**
     * 判断用户是否已经登录
     *
     */
    public function hasLogin()
    {
        /** 检查session，并与数据库里的数据相匹配 */
        if (!empty($_SESSION) and NULL !== $_SESSION['uid']) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


    /**
     * 用户登出
     *
     */
    public function logout()
    {
        $this->session->sess_destroy();

        redirect('http://' . $_SERVER['HTTP_HOST'] . '/user');
    }


    /**
     * session验证用户
     *
     */
    public function isuser($data)
    {
//    	$data = array('username'=>'shane','passwd'=>'123123');
        extract($data);
        $sql = "select uid from userlist where (username = '$username' or mobile='$username') and password = '$passwd'";
        $query = $this->db->query($sql);
        $arr = $query->row_array();
        if ($arr) {
            return $arr['uid'];
        } else {
            return false;
        }
    }

    /**
     * 所有省市联动下拉js
     *
     *
     */
    public function getProvinceCity_js(){
        $sql = "select dist_id,name,level,pinyin,pre_dist_id from province_city  ";
        $query = $this->db->query($sql);
        $list = array();
        while ($row = $query->unbuffered_row('array')) {
            if($row['level']==1){
                $list[$row['dist_id']] = array('name'=>$row['name']);
            }elseif($row['level']==2){
                $list[$row['pre_dist_id']][$row['dist_id']]['name']= $row['name'];
                $list[$row['pre_dist_id']][$row['dist_id']]['pinyin']= $row['pinyin'];
            }
        }

        foreach ($list as $k => $v){
            foreach ($v as $k1 => $v1) {
                if($k1!='name'){
                    $city.='{
                    "ct": "'.$v1['name'].'",
                    "cv": "'.$k1.'"
                },';
                }
            }
            $list_js.='{
            "p": "'.$v['name'].'",
            "v": "'.$k.'",
            "c": [
                '.$city.'
            ]
        },';
            $city='';
        }

        $js='
        $(function() {
            var list = [
                '.$list_js.'
            ];
            var pro = $(\'#province\');
            var city = $(\'#city\');
            var proDiv = $(\'#proDiv\');
            var cityDiv = $(\'#cityDiv\');
            var index=0;
            var divhtml2=\'\';
            var cityhtml=\'\';
            var proFun = function () {
                var prohtml = \'\';
                $.each(list, function (k, v) {
                    //prohtml+= "<option value=\'"+v.p+"\'>"+v.p+"</option>";
                    prohtml += "<a href=\'javascript:void(0);\' data-pro=\'"+v.v+"\' class=\'list-group-item\'>" + v.p + "</a>";
                });
                pro.html(prohtml);
                //初始化省份、城市------------------------------------
                var divhtml = proDiv.html() + "<span class=\'text\'>"+list[0].p+"</span>";
                proDiv.html(divhtml);
                console.log(proDiv.html());
            };
        
            var cityFun=function(){
                cityhtml=\'\';
                $.each(list[index].c,function(k,v){
                    cityhtml+= "<a href=\'javascript:void(0);\' data-city=\'"+v.cv+"\' class=\'list-group-item citya\'>" + v.ct + "</a>";
                });
                city.html(cityhtml);
                cityDiv.parent().find(\'span.text\').eq(0).text(list[index].c[0].ct);
                console.log(cityDiv.html());
        
            };
            proFun();
            cityFun();
        
          $(\'span.xl\').click(function(){
              $(this).parent().find(\'ul\').toggle();
              //$(\'#province\').toggle();
          });
            $(document).bind("click", function (e) {
                var target = $(e.target);
                if(target.closest("#province,#proDiv").length == 0){
                    //进入if则表明点击的不是#province,#proDiv元素中的一个
                    $("#province").hide();
                }if(target.closest("#city,#cityDiv").length == 0){
                    //进入if则表明点击的不是#province,#proDiv元素中的一个
                    $("#city").hide();
                }
                e.stopPropagation();
            });
$(\'#province a\').click(function(){
    $(\'#proDiv span.text\').text($(this).text());
    $(\'#province\').hide();
    index=$(this).index();
    cityFun();
    $(\'#pro_id\').val($(this).data("pro"));
    $(\'#city_id\').val($("body").find(".citya").eq(0).data("city"));

});
    $(document).on(\'click\',\'.citya\', function() {
        cityDiv.parent().find(\'span.text\').eq(0).text($(this).text());
        $(\'#city\').hide();
        $(\'#city_id\').val($(this).data("city"));

    });
});
        ';

        return $js;
    }

    /**
     * 注册
     *
     */
    public function reg()
    {
        if (!file_exists(APPPATH . 'views/home/user/reg.php')) {
            show_404();
        }

        //是否登录
        if ($this->hasLogin()) {
            redirect('http://' . $_SERVER['HTTP_HOST'] . '/user/center');
        }

        $data['js']=$this->getProvinceCity_js();

        $citycode = $this->main_model->getCityCode();//获取城市简码

        $city = $this->main_model->getCityInfoByCode($citycode);//根据简码获取城市信息

        $data['localhost'] = $_SERVER['HTTP_HOST'];// 当前域名
        $data['title'] = '注册'; // 网页标题
        $data['area'] = array($this->user_model->getProvince(), $this->user_model->getAllCity());//获取全部省市信息

        //$this->load->view('templates/header', $data);

        $this->form_validation->set_rules('username', '用户名', 'trim|required|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('password', '密码', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('passconf', '确认密码', 'trim|required|matches[password]');

        $this->form_validation->set_rules('mobile', '手机号', 'trim|required|numeric|exact_length[11]');
        $this->form_validation->set_rules('is_co', '', 'trim|required');
        $this->form_validation->set_rules('referer', '推介人', 'trim|min_length[4]|max_length[12]');
        $this->form_validation->set_error_delimiters();

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('home/user/reg', $data);
        } else {
            if (strtoupper($this->input->post('messagecode', TRUE)) == $_SESSION['regcode']) {
                $repost = $this->input->post();
                $repost['password'] = $this->user_model->encryptPwd($repost['password']);
                $return = $this->user_model->adduser($repost);
                if ($return['flag'] == 1) {
                	$mess['uid'] = $return['uid'];
                	$mess['title'] = "零工在线欢迎您";
                	$mess['message'] = "恭喜您注册成功，赠送您10个零工币，请马上开始体验我们的服务吧。";
                	
                	$this->main_model->addMessage($mess);
                    //redirect('http://'.$_SERVER['HTTP_HOST'].'/user/success');
                    $data['title'] = '注册成功';
                    $userdata['username'] = $this->input->post('username', TRUE);
                    $userdata['passwd'] = $this->user_model->encryptPwd($this->input->post('password', TRUE));
                    $userdata['uid'] = $return['uid'];
                    $userdata['no'] = $return['no'];
                    $userdata['is_co'] = $return['is_co'];
                    /** 自动登录 */
                    $_SESSION = $userdata;

                    $data['user'] = $this->user_model->getUserBaseInfo($return['uid']);
//print_r($data['user']);
//var_dump($return);exit;
                    //$data['info']=
                    $this->load->view('home/user/success', $data);
                    //$this->load->view('templates/footer');
                } else {
                    $data['formError'] = $return['info'];
                    $this->load->view('home/user/reg', $data);
                    //$this->load->view('templates/footer2');
                }
            } else {
                $data['codeError'] = '验证码错误';
                $this->load->view('home/user/reg', $data);
                //$this->load->view('templates/footer');
            }
        }


    }

    /**
     * 注册
     *
     */
    public function userAgreement()
    {
        if (!file_exists(APPPATH . 'views/home/user/userAgreement.php')) {
            show_404();
        }

        //是否登录
        if ($this->hasLogin()) {
            redirect('http://' . $_SERVER['HTTP_HOST'] . '/user/center');
        }

        $data['localhost'] = $_SERVER['HTTP_HOST'];// 当前域名
        $data['title'] = '零工在线用户协议'; // 网页标题

        $this->load->view('templates/head_simple', $data);
        $this->load->view('home/user/userAgreement', $data);
        $this->load->view('templates/footer2', $data);

    }


    /**
     * 零工宝
     *
     */
    public function center()
    {
        if (!file_exists(APPPATH . 'views/home/user/center.php')) {
            show_404();
        }
        $data['title'] = '零工宝'; // 网页标题
        $data['localhost'] = $_SERVER['HTTP_HOST'];// 当前域名
        $citycode = $this->main_model->getCityCode();        //地区名
        $city_arr = $this->main_model->getCityInfoByCode($citycode);
        $data['cityname'] = $city_arr['name'];
        if (!$this->hasLogin()) {
            redirect('http://' . $_SERVER['HTTP_HOST'] . '/user');
        }

        $data['user'] = $this->user_model->getUserBaseInfo($_SESSION['uid']);

        $this->load->view('templates/header', $data);
        $this->load->view('home/user/center', $data);
        $this->load->view('templates/footer');
    }




    /**
     * 手机验证码时间限制
     *
     */
    public function sendTime($mobile)
    {
        $spacing = 120; //间隔时间 秒
        if (!get_cookie($mobile)) {
            set_cookie($mobile, time(), 60);
            return TRUE;
        } else {
            if ((time() - get_cookie($mobile)) > $spacing) {
                return TRUE;
            } else {
                return FALSE;
            }
        }


    }




    /**
     * 获取城市下拉菜单  *不使用了
     *
     *
     * public function getCity(){
     *
     * $proid=$this->input->post('proid', TRUE);
     * $return["status"]="failed";
     *
     * if($proid){
     * $cityarr=$this->user_model->getCityByProvince($proid);
     * foreach ($cityarr as $k => $v){
     * $citylist.='<option value='.$k.'>'.$v.'</option>';
     * }
     * $return['msg']=$citylist;
     *
     * }else{
     *
     * $return['msg']='获取失败';
     * }
     * echo json_encode($return);
     *
     * }
     */
    /**
     * 重置密码
     *
     */
    public function reset()
    {
        if (!file_exists(APPPATH . 'views/home/user/resetPassword.php')) {
            show_404();
        }

        //是否登录
        if ($this->hasLogin()) {
            redirect('http://' . $_SERVER['HTTP_HOST'] . '/user/center');
        }

        $data['title'] = '重置密码';//网页标题
        $data['mobile'] = $this->input->post('mobile', TRUE);
        if($this->input->post('step', TRUE)){
            $step=$this->input->post('step', TRUE);
        }else{
            $step=1;
        }


        if($step=='1'){
            $this->form_validation->set_rules('mobile', '手机号', 'trim|required|numeric|exact_length[11]');
            $this->form_validation->set_rules('messagecode', '手机验证码', 'trim|required');
        }elseif($step=='2'){
            $this->form_validation->set_rules('password', '密码', 'trim|required|min_length[6]');
            $this->form_validation->set_rules('passconf', '确认密码', 'trim|required|matches[password]');
        }
        $this->form_validation->set_error_delimiters('<span class="stress">', '</span>');

        $this->load->view('templates/header', $data);

        if ($this->form_validation->run() == FALSE) {
            if($step=='1'){
                $this->load->view('home/user/resetPassword', $data);
            }elseif($step=='2'){
                $this->load->view('home/user/resetPassword_step2', $data);
            }

        } else {
            if($step=='1'){
                if (strtoupper($this->input->post('messagecode', TRUE)) == $_SESSION['rescode']) {
                    $this->load->view('home/user/resetPassword_step2', $data);
                } else {
                    $data['codeError'] = '验证码错误';
                    $this->load->view('home/user/resetPassword', $data);
                }
            }elseif($step=='2'){
                $return=$this->user_model->modifyPwd($this->input->post('mobile', TRUE),$this->input->post('password', TRUE));
                if($return){
                    $this->load->view('home/user/resetSuccess', $data);
                }else{
                    $this->main_model->alert('重置密码失败，请稍后重试', 'back');
                }

            }


        }

        // $this->load->view('templates/footer2');
    }

    /*
    *   根据手机号获取用户名
    * 
    */
    public function getUsername()
    {
        $mobile = $_POST['mobile'];

        $username = $this->user_model->getUserinfoByMobile($mobile);
        echo $username = json_encode($username);
        exit;
    }

    /**
     * 重置密码 检测手机和用户名是否相符
     *
     */
    public function userPassword($data)
    {
//    	$data = array('mobile'=>'123123');
        extract($data);
        $sql = "select uid from userlist where mobile='$mobile'";
        $query = $this->db->query($sql);
        $arr = $query->row_array();
        if ($arr) {
            return $arr['uid'];
        } else {
            return false;
        }
    }


    /**
     * 购买零工币 充值页
     *
     */
    public function recharge()
    {
        if (!file_exists(APPPATH . 'views/home/user/recharge.php')) {
            show_404();
        }

        //是否登录
        if (!$this->hasLogin()) {
            redirect('http://' . $_SERVER['HTTP_HOST'] . '/user');
        }

        $data['localhost'] = $_SERVER['HTTP_HOST'];// 当前域名
        $data['title'] = '零工币充值'; // 网页标题

        //$this->load->view('templates/head_simple', $data);
        $this->load->view('home/user/recharge', $data);
        //$this->load->view('templates/footer2', $data);

    }

    /**
     * 购买会员
     *
     */
    public function buyVIp()
    {
        if (!file_exists(APPPATH . 'views/home/user/buyvip.php')) {
            show_404();
        }

        //是否登录
        if (!$this->hasLogin()) {
            redirect('http://' . $_SERVER['HTTP_HOST'] . '/user');
        }

        $data['user'] = $this->user_model->getUserBaseInfo($_SESSION['uid']);
        $data['is_co'] = $_SESSION['is_co'];

        $data['localhost'] = $_SERVER['HTTP_HOST'];// 当前域名
        $data['title'] = '购买会员'; // 网页标题

        $this->form_validation->set_rules('vipid', 'VIP', 'trim|required');
        $this->form_validation->set_rules('credit', '零工币', 'trim|required');

        $this->form_validation->set_error_delimiters('<span>', '</span>');

        //$this->load->view('templates/head_simple', $data);

        if ($this->form_validation->run() == FALSE or $this->user_model->isVip($_SESSION['uid'])) {
            if ($this->user_model->isVip($_SESSION['uid'])) {
                $data['error'] = '您已经是vip会员';
            }
            $this->load->view('home/user/buyvip', $data);
        } else {
            $month = 60 * 60 * 24 * 30;
            $quarter = 60 * 60 * 24 * 30 * 3;
            $year = 60 * 60 * 24 * 30 * 3 * 4;
            $startime = time();

            $vip = $this->user_model->getServiceDic();
            foreach ($vip[$_SESSION['is_co']] as $value) {
                if ($value['id'] == $_POST['vipid']) {
                    $credit = $value['credit1'];
                    $vipname = $value['name'];
                    if ($vipname == '月度') {
                        $endtime = $startime + $month;
                    } elseif ($vipname == '季度') {
                        $endtime = $startime + $quarter;
                    } elseif ($vipname == '年度') {
                        $endtime = $startime + $year;
                    }
                }
            }


            $return = $this->user_model->buyVipService(array('uid' => $_SESSION['uid'], 'vipid' => $_POST['vipid'], 'credit' => $credit, 'startime' => $startime, 'endtime' => $endtime));

            $data['user'] = $this->user_model->getUserBaseInfo($_SESSION['uid']);

            if ($return['flag'] == 1) {
                $data['info'] = array('name' => $vipname, 'credit' => $credit);
                $this->load->view('home/user/buyvipSuccess', $data);
            } else {
                $data['error'] = $return['info'];
                $data['vip'] = $return;
                $this->load->view('home/user/buyvip', $data);
            }

        }

        //$this->load->view('templates/footer2', $data);

    }

    /**
     * 零工币提现
     *
     */
    public function exchange()
    {
        if (!file_exists(APPPATH . 'views/home/user/exchange.php')) {
            show_404();
        }

        //是否登录
        if (!$this->hasLogin()) {
            redirect('http://' . $_SERVER['HTTP_HOST'] . '/user');
        }

        $data['localhost'] = $_SERVER['HTTP_HOST'];// 当前域名
        $data['title'] = '零工币提现'; // 网页标题

        $this->load->view('templates/head_simple', $data);
        $this->load->view('home/user/exchange', $data);
        $this->load->view('templates/footer2', $data);

    }

    /**
     * 实名认证
     *
     */
    public function identify()
    {
        if (!file_exists(APPPATH . 'views/home/user/identify.php')) {
            show_404();
        }

        //是否登录
        if (!$this->hasLogin()) {
            redirect('http://' . $_SERVER['HTTP_HOST'] . '/user');
        }

        $uid = $_SESSION['uid'];
        $uinfo = $this->user_model->getUserinfoByUid($uid);

        $city_id = $uinfo['city_id'];
        $this->load->model('admin_model');
        $citycode = $this->admin_model->getCityCode($city_id);
        $citycode = $citycode['pinyin'];
        
        //$citycode = $this->main_model->getCityCode();

        //是否公司
        if ($is_so = $this->session->is_co) {
            $config['upload_path'] = getcwd() . '/upload/' . $citycode . '/gssm/' . date('ym');
        } else {
            $config['upload_path'] = getcwd() . '/upload/' . $citycode . '/grsm/' . date('ym');
        }

        if(!is_dir($config['upload_path'])){
            mkdir($config['upload_path'],0777,true);
        }
        //var_dump($config['upload_path']);

        $data['localhost'] = $_SERVER['HTTP_HOST'];// 当前域名
        $data['title'] = '实名认证'; // 网页标题

        $this->load->view('templates/head_simple', $data);


        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 10048;
        $config['file_name']  = time();

        //如果已认证 跳转 成功页面
        $return_isReal = $this->user_model->checkIsReal($uid);
        if ($return_isReal['flag'] == 1) {
            if($_SESSION['is_co'] == 1){
                $data['identifyinfo'] = $this->user_model->identifyinfo1($uid);
            }else{
                $data['identifyinfo'] = $this->user_model->identifyinfo2($uid);
            }
            $this->load->view('home/user/identifySuccess', $data);
        } elseif ($return_isReal['flag'] == 0) {//已提交未审核
            $data['info'] = '正在审核中,请耐心等待';
            $this->load->view('home/user/successPage', $data);
        } else {

            $this->form_validation->set_rules('idno', '证件号', 'trim|required');
            $this->form_validation->set_error_delimiters('<span>', '</span>');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('home/user/identify', $data);
            } else {
                //上传图片
                $this->load->library('upload', $config);

//                var_dump($config);
//                $this->upload->do_upload('idno_img');
//                $error = array('error' => $this->upload->display_errors());
//                    print_r($error);exit;

                if (!$this->upload->do_upload('idno_img')) {
                    $data['error'] = '请选择正确格式的图片文件';
                    $this->load->view('home/user/identify', $data);
                } else {
                    $upload_data = $this->upload->data();
                    //提交认证
                    $_POST['uid'] = $uid;
                    $_POST['idno_img'] = date('ym') . '/' . $upload_data['file_name'];


                    if ($this->session->is_co) {
                        $return = $this->user_model->updateCoRealInfo($_POST);
                    } else {
                        $return = $this->user_model->updatePersonalRealInfo($_POST);
                    }

                    if ($return['flag'] == 1) {
                        //var_dump($_POST);
                        $data['info'] = '认证信息已提交 <span class="fa fa-check red"></span><br>我们将在24小时内审核,请耐心等待';
                        $this->load->view('home/user/successPage', $data);
                    } else {
                        $data['error'] = $return['info'];
                        //var_dump($_POST);
                        $this->load->view('home/user/identify', $data);
                    }

                }
            }
        }

        $this->load->view('templates/footer2', $data);

    }


    /**
     * 我的账户
     *
     */
    public function myAccount()
    {
        if (!file_exists(APPPATH . 'views/home/user/myaccount.php')) {
            show_404();
        }

        //是否登录
        if (!$this->hasLogin()) {
            redirect('http://' . $_SERVER['HTTP_HOST'] . '/user');
        }

        $data['localhost'] = $_SERVER['HTTP_HOST'];// 当前域名
        $data['title'] = '我的账户'; // 网页标题

        $this->load->view('templates/head_simple', $data);
        $this->load->view('home/user/myaccount', $data);
        $this->load->view('templates/footer2', $data);

    }

    /**
     * 我的发布
     *
     */
    public function myPublish()
    {
        if (!file_exists(APPPATH . 'views/home/user/myPublish.php')) {
            show_404();
        }

        //是否登录
        if (!$this->hasLogin()) {
            redirect('http://' . $_SERVER['HTTP_HOST'] . '/user');
        }

        $data['localhost'] = $_SERVER['HTTP_HOST'];// 当前域名
        $data['title'] = '我的发布'; // 网页标题

        //获取已发布工种
        $data['gong'] = $this->form_model->getMyGZPublish($_SESSION['uid']);

        if ($this->session->is_co) {
            $data['zlg'] = $this->form_model->getMyZlgPublish($_SESSION['uid']);
        }

        //$this->load->view('templates/head_simple', $data);
        $this->load->view('home/user/myPublish', $data);
        //$this->load->view('templates/footer2', $data);

    }

    /**
     * 签约推广
     *
     */
    public function contractAds()
    {
        if (!file_exists(APPPATH . 'views/home/user/contractads.php')) {
            show_404();
        }

        //是否登录
        if (!$this->hasLogin()) {
            redirect('http://' . $_SERVER['HTTP_HOST'] . '/user');
        }

        $data['localhost'] = $_SERVER['HTTP_HOST'];// 当前域名
        $data['title'] = '签约推广'; // 网页标题

        $this->load->view('templates/head_simple', $data);
        $this->load->view('home/user/contractads', $data);
        $this->load->view('templates/footer2', $data);

    }




    /**
     * 发布招零工
     *
     */
    public function recruit($edit)
    {
        if (!file_exists(APPPATH . 'views/home/user/recruit.php')) {
            show_404();
        }

        //是否登录
        if (!$this->hasLogin()) {
            redirect('http://' . $_SERVER['HTTP_HOST'] . '/user');
        }

        //修改
        if ($edit) {
            $data['zlg'] = $this->form_model->getZlgDetal(array('uid' => $_SESSION['uid'], 'id' => $this->uri->segment(4, 0)));
            $data['three_level'] = $this->list_model->get_three_level();
            $this->main_model->getDistArea();
            $data['dist'] = $this->main_model->list_dist;
            $data['area'] = $this->main_model->list_area;
            $data['edit'] = $edit;
            $_POST['id'] = $this->uri->segment(4, 0);
//            var_dump($data['zlg']);

        }

        $data['localhost'] = $_SERVER['HTTP_HOST'];// 当前域名
        $data['title'] = '发布招零工'; // 网页标题

        $data['gong'] = $this->list_model->get_three_level();//获取行业职业工种　数组
        $data['user'] = array_merge($this->user_model->getUserinfoByUid($_SESSION['uid']), $this->user_model->getUserBaseInfo(),$this->user_model->identifyinfo1($_SESSION['uid']));//获取会员信息

        $city = $this->main_model->getCityInfoByCode($this->main_model->getCityCode());//获取当前城市ｉｄ 名字
        $_POST['uid'] = $_SESSION['uid'];//保存uid
        $data['city'] = $city['name'];
        $_POST['cityid'] = $city['id'];


        //获取工资单位数据
        $data['unit'] = $this->form_model->getUnit();
        //获取工资结算周期
        $data['pay_circle'] = $this->form_model->getPayCircle();
//print_r($data['unit']);
//print_r($data['pay_circle']);

        //获取当前城市区县街道
        $this->main_model->getDistArea();
        $data['area'] = array($this->main_model->list_dist, $this->main_model->list_area);

        $this->load->view('templates/head_simple', $data);//加载头部

        $this->form_validation->set_rules('title', '标题', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('mobile', '手机号', 'trim|required|numeric|exact_length[11]');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() == FALSE or !$_SESSION['is_co']) {
            $this->load->view('home/user/recruit', $data);
        } else {
            if ($edit) {
                $return = $this->form_model->updateZlg($_POST);
                $mess['uid'] = $_SESSION['uid'];
	            $mess['title'] = '您修改了一条招零工信息';
	            $mess['message'] = '您于'.date('Y-m-d H:i')."修改了一条招零工信息";
            } else {
                $return = $this->form_model->addZlg($_POST);
                $mess['uid'] = $_SESSION['uid'];
	            $mess['title'] = '您发布了一条招零工信息';
	            $mess['message'] = '您于'.date('Y-m-d H:i')."发布了一条招零工信息";
            }

            if ($return['flag'] == 1) {
                $_POST = array();  //防止重复提交

                if ($edit) {
                    $data['error'] = "<script> Alert('招零工信息修改成功!');location.href='/user/mypublish';</script>";
                    //$this->load->view('home/user/publish', $data);
                    redirect(site_url('user/mypublish'));
                } else {
                    $data['error'] = "<script> var sure1=confirm( '发布成功,是否继续发布? '); if (sure1==true){location.href='/user/recruit';}else{location.href='/user/mypublish';}</script>";
                    //$this->load->view('home/user/recruit', $data);
                    redirect(site_url('user/mypublish'));
                }

            } else {
                $data['formerror'] = $return['info'];
                $data['return'] = $return;
                $this->load->view('home/user/recruit', $data);
            }
        }

        $this->load->view('templates/footer2', $data);

    }

    /**
     * 快速发布
     *
     */
    public function quickPublish()
    {
        if (!file_exists(APPPATH . 'views/home/user/quickPublish.php')) {
            show_404();
        }

        //获取当前城市区县街道
        $this->main_model->getCityDist();
        $data['area'] = array($this->main_model->arr_city, $this->main_model->arr_city_dist);

        $data['localhost'] = $_SERVER['HTTP_HOST'];// 当前域名
        $data['title'] = '快速发布'; // 网页标题

        $this->load->view('templates/head_simple', $data);

        $uid = $this->user_model->checkMobile($_POST['mobile']);//根据手机获取uid
        $ksfb = $this->form_model->checkQuickPublish($uid);//根据uid判断是否快速发布过

        $this->form_validation->set_rules('mobile', '手机号', 'trim|required|numeric|exact_length[11]');
        $this->form_validation->set_rules('title', '服务内容', 'trim|required|min_length[5]|max_length[20]');
        $this->form_validation->set_error_delimiters();

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('home/user/quickPublish', $data);
        } else {

            if ($ksfb) {//是否快速发布qqqqqqqqqqqqqqqqqqqqqqqqq
                $data['script'] = "<script> var sure=confirm( '快速发布只能发布一次,是否进入正常发布? '); if (sure==true){location.href='/user/publish';}else{location.href=history.back(-1);}</script>";
                $this->load->view('home/user/quickPublish', $data);
            } else {

                $_POST['c_id'] = $_POST['cityid'];//自动注册 城市字段
                $_POST['p_id'] = $this->main_model->province_id;//自动注册 省份字段

                //判断手机验证码是否正确
                if (strtoupper($this->input->post('messagecode', TRUE)) == $_SESSION['ksfbcode']) {
                    if ($uid) {//如果
                        $_POST['uid'] = $uid;
                        $return = $this->form_model->addGzQuick($_POST);
                        $return['uid'] = $uid;

                        if ($return['flag'] == 1) {
                            $this->main_model->alert('发布成功', 'back');
                        } else {
                            $data['error'] = $return['info'];
                            $this->load->view('home/user/quickPublish', $data);
                        }

                    } else {
                        $return_adduser = $this->user_model->addUseAuto($_POST);
                        if ($return_adduser['flag'] == 1) {
                            $_POST['uid'] = $return_adduser['uid'];
                            $return = $this->form_model->addGzQuick($_POST);
                        } else {
                            $return = $return_adduser;
                        }

                        //var_dump($return);
                        if ($return['flag'] == 1) {
                            $data['user'] = $this->user_model->getUserBaseInfo($return['uid']);
                            $this->load->view('home/user/quickPublishSuccess', $data);
                        } else {
                            $data['error'] = $return['info'];
                            $this->load->view('home/user/quickPublish', $data);
                        }
                    }


                } else {
                    $data['codeError'] = '验证码错误';
                    $this->load->view('home/user/quickPublish', $data);
                    $this->load->view('templates/footer2');
                }
            }
        }


    }

    //点击零工宝我的资料，修改个人资料
    public function updateinfo()
    {
        if (!file_exists(APPPATH . 'views/home/user/updateinfo.php')) {
            show_404();
        }
        //var_dump($_SESSION);
        $citycode = $this->main_model->getCityCode();       //地区名
        $city_arr = $this->main_model->getCityInfoByCode($citycode);
        $data['cityname'] = $city_arr['name'];
        $data['title'] = '修改资料'; // 网页标题
        $uid = $_SESSION['uid'];

        if ($_SESSION['is_co'] == 1) {
            $data['info'] = $this->user_model->getCoUserInfo($uid);//根据用户uid查询公司用户基本信息
            $data['scale'] = $this->user_model->getCoScale();
        } else {
            $data['info'] = $this->user_model->getPersonalInfo($uid);//根据用户uid查询个人用户基本信息
        }

        $this->load->view('templates/header', $data);
        $this->load->view('home/user/updateinfo', $data);
        $this->load->view('templates/footer', $data);
    }


    //确认修改个人资料
    public function doupdateinfo()
    {
        if (!file_exists(APPPATH . 'views/home/user/updateinfo.php')) {
            show_404();
        }

        $uid = $_SESSION['uid'];
        $citycode = $this->main_model->getCityCode();       //地区名
        $city_arr = $this->main_model->getCityInfoByCode($citycode);
        $data['cityname'] = $city_arr['name'];
        $data['title'] = '修改资料'; // 网页标题
        if ($_SESSION['is_co'] == 1) {
            $data['info'] = $this->user_model->getCoUserInfo($uid);//根据用户uid查询公司用户基本信息
            $data['scale'] = $this->user_model->getCoScale();
        } else {
            $data['info'] = $this->user_model->getPersonalInfo($uid);//根据用户uid查询个人用户基本信息
        }
        $test['uid'] = $_SESSION['uid'];
        $test['address'] = $_POST['address'];
        $test['wechat'] = $_POST['wechat'];
        $test['qq'] = $_POST['qq'];
        $test['info'] = $_POST['info'];
        if ($_SESSION['is_co'] == 1) {
            $test['scale'] = $_POST['scale'];
            $test['coname'] = $_POST['coname'];
            $res = $this->user_model->updateMyCoInfo($test);
            if ($res['flag'] == -1) {
                $data['error'] = $res['info'];
            } else if ($res['flag'] == 1) {
                $data['error'] = '修改资料成功';
            }
        } else {
            $test['sex'] = $_POST['sex'];
            $test['realname'] = $_POST['realname'];
            $res = $this->user_model->updateMyPersonalInfo($test);
            if ($res['flag'] == -1) {
                $data['error'] = $res['info'];
            } else if ($res['flag'] == 1) {
                $data['error'] = '修改资料成功';
            }
        }
        if ($_SESSION['is_co'] == 1) {
            $data['info'] = $this->user_model->getCoUserInfo($uid);
        //根据用户uid查询公司用户基本信息
        } else {
            $data['info'] = $this->user_model->getPersonalInfo($uid);//根据用户uid查询个人用户基本信息
        }

        $this->load->view('templates/header', $data);
        $this->load->view('home/user/updateinfo', $data);
        $this->load->view('templates/footer', $data);

    }


    //修改密码
    public function updatepasswd()
    {
        if (!file_exists(APPPATH . 'views/home/user/updatepasswd.php')) {
            show_404();
        }
        $citycode = $this->main_model->getCityCode();       //地区名
        $city_arr = $this->main_model->getCityInfoByCode($citycode);
        $data['cityname'] = $city_arr['name'];
        $data['title'] = '修改密码'; // 网页标题
        $data['username'] = $_SESSION['username'];

        $this->load->view('templates/header', $data);
        $this->load->view('home/user/updatepasswd', $data);
        $this->load->view('templates/footer', $data);
    }

    //修改密码
    public function doupdatepasswd()
    {
        if (!file_exists(APPPATH . 'views/home/user/updatepasswd.php')) {
            show_404();
        }
        $citycode = $this->main_model->getCityCode();       //地区名
        $city_arr = $this->main_model->getCityInfoByCode($citycode);
        $data['cityname'] = $city_arr['name'];
        $data['title'] = '修改密码'; // 网页标题

        $data['username'] = $_SESSION['username'];
        $test['uid'] = $_SESSION['uid'];

        $oldpwd = $_POST['oldpasswd'];//获取form传过来的老密码
        $test['old_pwd'] = $this->user_model->encryptPwd($oldpwd);//旧密码加密
        $result = $this->user_model->checkOldPwd($test);//加密后的旧密码和数据库里的密码比较
        $newpwd = $_POST['newpasswd'];
        $renewpwd = $_POST['renewpasswd'];
        $newtest['uid'] = $_SESSION['uid'];

        //var_dump($result);
        if ($result['flag'] == 1) {//当输入的旧密码与数据库里的密码匹配上的时候
            if (!empty($newpwd)) {//判断密码是否为空
                if ($newpwd == $renewpwd) {//判断俩次密码输入是否一致
                    $newtest['pwd'] = $this->user_model->encryptPwd($newpwd);
                    $res = $this->user_model->updatePwd($newtest);//修改密码
                    if ($res['flag'] == 1) {
                        $data['error'] = '密码修改成功';
                    } else if ($res['flag'] == -1) {
                        $data['error'] = $res['info'];
                    }
                } else {
                    $data['error'] = '两次密码输入不一致，请确认是否一致。';
                }
            } else {
                $data['error'] = '密码不能为空,请重新输入';
            }
        } else if ($result['flag'] == -1) {
            $data['error'] = $result['info'];
        }

        $this->load->view('templates/header', $data);
        $this->load->view('home/user/updatepasswd', $data);
        $this->load->view('templates/footer', $data);
    }

    /**
     * 我的资料
     *
     */
    public function myInfo()
    {
        if (!file_exists(APPPATH . 'views/home/user/myinfo.php')) {
            show_404();
        }

        //是否登录
        if (!$this->hasLogin()) {
            redirect('http://' . $_SERVER['HTTP_HOST'] . '/user');
        }
        //var_dump($_SESSION);
        $data['is_co'] = $_SESSION['is_co'];
        $citycode = $this->main_model->getCityCode();       //地区名
        $city_arr = $this->main_model->getCityInfoByCode($citycode);
        $data['cityname'] = $city_arr['name'];
        $data['title'] = '我的资料'; // 网页标题
        $uid = $_SESSION['uid'];
        if ($_SESSION['is_co'] == 1) {
            $data['info'] = $this->user_model->getCoUserInfo($uid);//根据用户uid查询公司用户基本信息
        } else {
            $data['info'] = $this->user_model->getPersonalInfo($uid);//根据用户uid查询个人用户基本信息
        }

        $this->load->view('templates/header', $data);
        $this->load->view('home/user/myinfo', $data);
        $this->load->view('templates/footer', $data);

    }

    public function dealMyInfo()
    {
        $url_array = $this->uri->uri_to_assoc(3);
//    	print_r($url_array);
        if ($url_array['type'] == 'gz') {
            if ($url_array['ac'] == 'flush') {
                $flag = $this->form_model->flushGzInfo(array('uid' => $_SESSION['uid'], 'id' => $url_array['id']));
                if ($flag['flag'] == 1) {
                    $this->main_model->alert('刷新成功', 'back');
                } else {
                    $this->main_model->alert($flag['info'], 'back');
                }
            } elseif ($url_array['ac'] == 'del') {
                $flag = $this->form_model->delGzInfo(array('uid' => $_SESSION['uid'], 'id' => $url_array['id']));
                if ($flag == 1) {
                    $this->main_model->alert('删除成功', 'back');
                } else {
                    $this->main_model->alert('删除失败，请稍后重试', 'back');
                }
            }
        } elseif ($url_array['type'] == 'zlg') {
            if ($url_array['ac'] == 'flush') {
                $flag = $this->form_model->flushZlgInfo(array('uid' => $_SESSION['uid'], 'id' => $url_array['id']));
                if ($flag['flag'] == 1) {
                    $this->main_model->alert('刷新成功', 'back');
                } else {
                    $this->main_model->alert($flag['info'], 'back');
                }
            } elseif ($url_array['ac'] == 'del') {
                $flag = $this->form_model->delZlgInfo(array('uid' => $_SESSION['uid'], 'id' => $url_array['id']));
                if ($flag['flag'] == 1) {
                    $this->main_model->alert('删除成功', 'back');
                } else {
                    $this->main_model->alert('删除失败，请稍后重试', 'back');
                }
            }
        }
    }

    /**
     * 个人信息
     *
     */
    public function personalInfor()
    {
        if (!file_exists(APPPATH . 'views/home/user/personalinfor.php')) {
            show_404();
        }

        //是否登录
        if (!$this->hasLogin()) {
            redirect('http://' . $_SERVER['HTTP_HOST'] . '/user');
        }

        $uid = $_SESSION['uid'];
        $data['title'] = '个人信息'; // 网页标题
        $data['localhost'] = $_SERVER['HTTP_HOST'];// 当前域名

        $data['user'] = $this->user_model->getUserBaseInfo($uid);
        $data['nickname'] = $this->user_model->getNickname($uid);

        $this->load->view('templates/header', $data);

        $this->form_validation->set_rules('nickname', '昵称', 'trim');
        $this->form_validation->set_rules('toux_img', '头像', 'trim');
        $this->form_validation->set_error_delimiters('<span>', '</span>');

        $user=$this->user_model->getUserinfoByUid($uid);
        $city = $this->admin_model->getCityCode($user['city_id']);
        $citycode=$city['pinyin'];



        //是否公司
        if ($is_so = $this->session->is_co) {
            $config['upload_path'] = getcwd() . '/upload/' . $citycode . '/gstx/' . date('ym');
        } else {
            $config['upload_path'] = getcwd() . '/upload/' . $citycode . '/grtx/' . date('ym');
        }

        if(!is_dir($config['upload_path'])){
            mkdir($config['upload_path'],0777,true);
        }

        //if (!is_dir('../..'.$config['upload_path'])) mkdir($config['upload_path']); //

        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 10048;
        $config['file_name']  = time();


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('home/user/personalinfor', $data);
        } else {
            //上传图片
            $this->load->library('upload', $config);
            
            $this->upload->do_upload('toux_img');

            $upload_data = $this->upload->data();


            if($upload_data['file_name']==''){
                $img='';
            }else{
                $img=date('ym') . '/' . $upload_data['file_name'];
            }
            $return = $this->user_model->updatePersonalInfor(array(
                            'uid' => $uid,
                            'nickname' => $this->input->post('nickname', TRUE),
                            'img' => $img
                        )
                    );
            $this->main_model->alert($return['info'],'back');



        }

        $this->load->view('templates/footer2');
    }

}