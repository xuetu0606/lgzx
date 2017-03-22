<?php
class Daili extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model(array(
            'daili_model',
            'main_model'
        ));
        $this->load->helper(array(
            'url_helper',
            'form',
            'url',
            'cookie'
        ));
        $this->load->library(array(
            'session',
            'form_validation'
        ));
    }


    /**
     * 代理商默认首页
     */
    public function index(){
        if ( ! file_exists(APPPATH.'views/daili/index.php')){
            show_404();
        }

        //是否登录
        if (!$this->hasLogin()){
            redirect('http://'.$_SERVER['HTTP_HOST'].'/daili/login');
        }

        $data['title'] = '代理商管理后台'; // Capitalize the first letter
        $data['localhost'] = $_SERVER['HTTP_HOST'];//获取当前域名
        $uid=$_SESSION['daili_uid'];
        $data['city']=$this->main_model->getcityName($_SESSION['daili_cityid']);
        $data['index_class']='active';

        //获取当前代理商所有会员信息
        $data['users']=$this->daili_model->getMemberInfo($uid);

        $beginThismonth=mktime(0,0,0,date('m'),1,date('Y')); //当月开始时间戳
        $endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));//当月结束时间戳

        $begin_month_1=mktime(0,0,0,date('m')-1,1,date('Y')); //上个月开始时间戳
        $end_month_1=mktime(23,59,59,date('m')-1,date('t', strtotime('-1 month')),date('Y'));//上个月结束时间戳


        foreach ($data['users'] as $v){

            //当月注册会员
            if($beginThismonth < $v['addtime'] and $v['addtime'] < $endThismonth){
                $data['month_add_users'][]=$v;
            }

            //上月注册会员
            if($begin_month_1 < $v['addtime'] and $v['addtime'] < $end_month_1){
                $data['month_1_add_users'][]=$v;
            }
            //是否vip
            if($v['is_vip']){
                $data['vip_users'][]=$v;
            }
            //是否公司会员
            if($v['is_co']==1){
                $data['co_users'][]=$v;
            }
            //是否实名会员
            if($v['is_real']==1){
                $data['real_users'][]=$v;
            }
            //是否签约推广来的会员
            if($v['promotion_flag']==1){
                $data['promotion_users'][]=$v;
            }

            for ($i=11;$i>=0;$i--){
                $begin_time=mktime(0,0,0,date('m')-$i,1,date('Y'));
                $end_time=mktime(23,59,59,date('m')-$i,date('t', strtotime('-'.$i.' month')),date('Y'));

                if($begin_time < $v['addtime'] and $v['addtime'] < $end_time){
                    $trend_data[date('Y-m',$begin_time)][]=$v;
                    $trend_data[date('Y-m',$begin_time)]['no']=1;
                }else{
                    $trend_data[date('Y-m',$begin_time)]['no']=0;
                }
            }

        }

        //var_dump($data['users']);

        foreach ($trend_data as $k=>$v){
            $trend_text.='{y: \''.$k.'\', item1: '.(count($v)-1).'},';
        }

        $data['script']='
        var line = new Morris.Line({
        element: \'line-chart\',
        resize: true,
        data: [
            '.$trend_text.'
        ],
        xkey: \'y\',
        ykeys: [\'item1\'],
        labels: [\'注册用户\'],
        lineColors: [\'#efefef\'],
        lineWidth: 2,
        hideHover: \'auto\',
        gridTextColor: "#fff",
        gridStrokeWidth: 0.4,
        pointSize: 4,
        pointStrokeColors: ["#efefef"],
        gridLineColor: "#efefef",
        gridTextFamily: "Open Sans",
        gridTextSize: 10
        });';

        $this->load->view('daili/templates/header',$data);
        $this->load->view('daili/index',$data);
        $this->load->view('daili/templates/footer',$data);
    }

    /**
     * 登录
     */
    public function login(){
        if ( ! file_exists(APPPATH.'views/daili/login.php')){
            show_404();
        }

        //是否登录
        if ($this->hasLogin()){
            redirect('http://'.$_SERVER['HTTP_HOST'].'/daili');
        }

        $data['title'] = '代理商登录'; // Capitalize the first letter
        $data['localhost'] = $_SERVER['HTTP_HOST'];//获取当前域名

        $this->form_validation->set_rules('username', '用户名', 'trim|required|min_length[3]|max_length[12]');
        $this->form_validation->set_rules('passwd', '密码', 'trim|required|min_length[6]');
        $this->form_validation->set_error_delimiters('<span>', '</span>');



        if ($this->form_validation->run() == FALSE) {
            $this->load->view('daili/login', $data);
        } else {
            $userdata['username'] = $this->input->post('username', TRUE);
            $userdata['passwd'] = $this->daili_model->encryptPwd($this->input->post('passwd', TRUE));

            $user = $this->daili_model->getuserlist($userdata);

            if (!empty($user)) {

                /** 记录用户登录状态 */
                $_SESSION['daili_uid'] = $user['uid'];
                $_SESSION['daili_username'] = $user['username'];
                $_SESSION['daili_coname'] = $user['coname'];
                $_SESSION['daili_cityid'] = $user['city_id'];

                redirect('http://' . $_SERVER['HTTP_HOST'] . '/daili');

            } else {

                $data['error_string'] = '用户名和密码不符';
                $data['userdata'] = $userdata;

                $this->load->view('daili/login', $data);
            }
        }

    }


    /**
     * 是否登录验证
     */
    public function hasLogin()
    {
        /** 检查session，并与数据库里的数据相匹配 */
        if(!empty($_SESSION) and NULL !== $_SESSION['daili_uid'])
        {
            return TRUE;
        }else{
            return FALSE;
            //return TRUE;
        }
    }

    /**
     * 会员统计
     */
    public function hytj1(){
        if ( ! file_exists(APPPATH.'views/daili/hytj.php')){
            show_404();
        }

        //是否登录
        if (!$this->hasLogin()){
            redirect('http://'.$_SERVER['HTTP_HOST'].'/daili/login');
        }

        $data['localhost'] = $_SERVER['HTTP_HOST'];//获取当前域名
        $data['hytj_class']='active';
        $data['class']='class="bg-green"';
        $data['url_gong']=$this->uri->segment(4, 0);
        $data['url_reg']=$this->uri->segment(6, 0);
        $data['url_vip']=$this->uri->segment(8, 0);

        $page=$this->uri->segment(10, 0);
        $this->load->library('pagination');
        $fenye=5;//分页数

        $data['city']=$this->main_model->getcityName($_SESSION['daili_cityid']);

        $sql='';

        if($data['url_gong']==1){
            $sql.=' and is_co=0';
        }
        if($data['url_gong']==2){
            $sql.=' and is_co=1';
        }
        if($data['url_reg']==1){
            $sql.=" and (promotion_flag=1)";
        }
        if($data['url_reg']==2){
            $sql.=" and (promotion_flag=0)";
        }

        $count=count($this->daili_model->getMemberInfo($_SESSION['daili_uid'],$sql));
        $sql.=" LIMIT {$page},{$fenye}";

        $data['users']=$this->daili_model->getMemberInfo($_SESSION['daili_uid'],$sql);

        if($data['url_vip']==1 and $data['users']){
            foreach ($data['users'] as $v){
                if($v['vip_starttime']-time()>2592000)
                    $users[]=$v;
            }
            $data['users']=$users;
        }

        $config['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/daili/hytj/gong/'.$data['url_gong'].'/reg/'.$data['url_reg'].'/vip/'.$data['url_vip'].'/page/';
        $config['total_rows'] = $count;
        $config['per_page'] = $fenye;
        $config['first_link'] = '第一页';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $config['last_link'] = '最后一页';

        //当前页链接的起始标签。
        $config['cur_tag_open'] = '<li class="paginate_button active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        //上一页标签
        $config['prev_tag_open'] = '<li class="paginate_button previous" id="example2_previous">';
        $config['prev_tag_close'] = '</li>';
        //下一页标签
        $config['next_tag_open'] = '<li class="paginate_button next" id="example2_next">';
        $config['next_tag_close'] = '</li>';
        //数字链接的起始标签
        $config['num_tag_open'] = '<li class="paginate_button ">';
        $config['num_tag_close'] = '</li>';


        $this->pagination->initialize($config);

        $data['page']=$this->pagination->create_links();

        //var_dump($this->daili_model->getMemberInfo1($_SESSION['daili_uid']));
        $this->load->view('daili/templates/header',$data);
        $this->load->view('daili/hytj',$data);
        $this->load->view('daili/templates/footer');

    }

    /**
     * 会员统计
     */
    public function hytj(){
        if ( ! file_exists(APPPATH.'views/daili/hytj.php')){
            show_404();
        }

        //是否登录
        if (!$this->hasLogin()){
            redirect('http://'.$_SERVER['HTTP_HOST'].'/daili/login');
        }

        $data['localhost'] = $_SERVER['HTTP_HOST'];//获取当前域名
        $data['hytj_class']='active';
        $data['class']='class="bg-green"';
        $data['url_gong']=$this->uri->segment(4, 0);
        $data['url_reg']=$this->uri->segment(6, 0);
        $data['url_vip']=$this->uri->segment(8, 0);

        $page=$this->uri->segment(10, 0);
        $this->load->library('pagination');
        $fenye=10;//分页数

        $data['city']=$this->main_model->getcityName($_SESSION['daili_cityid']);


        //$count=count($this->daili_model->getMemberInfo1($_SESSION['daili_uid'],$sql));

        $sql=" LIMIT {$page},{$fenye}";

        $riqi1=$this->input->post('riqi1',true);
        $riqi2=$this->input->post('riqi2',true);

        if($_POST){
            $starttime=strtotime($riqi1);
            $endtime= strtotime($riqi2) + 86300;
            if($this->input->post('quxiao',true)){
                unset(
                    $_SESSION['starttime'],
                    $_SESSION['endtime']
                );

            }else{
                $_SESSION['starttime']=$starttime;
                $_SESSION['endtime']=$endtime;
            }

        }


        $data1=array(
            'userid'=>$_SESSION['daili_uid'],
            'starttime'=>$_SESSION['starttime'],
            'endtime'=>$_SESSION['endtime'],
            'gong'=>$data['url_gong'],
            'reg'=>$data['url_reg'],
            'vip'=>$data['url_vip'],
            'addsql'=>$sql
        );

        $data2=array(
            'userid'=>$_SESSION['daili_uid'],
            'starttime'=>$_SESSION['starttime'],
            'endtime'=>$_SESSION['endtime'],
            'gong'=>$data['url_gong'],
            'reg'=>$data['url_reg'],
            'vip'=>$data['url_vip'],
            'addsql'=>'',
        );
        $count=count($this->daili_model->getMemberInfo1($data2));


        $data['users']=$this->daili_model->getMemberInfo1($data1);


        $config['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/daili/hytj/gong/'.$data['url_gong'].'/reg/'.$data['url_reg'].'/vip/'.$data['url_vip'].'/page/';
        $config['total_rows'] = $count;
        $config['per_page'] = $fenye;
        $config['first_link'] = '第一页';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $config['last_link'] = '最后一页';

        //当前页链接的起始标签。
        $config['cur_tag_open'] = '<li class="paginate_button active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        //上一页标签
        $config['prev_tag_open'] = '<li class="paginate_button previous" id="example2_previous">';
        $config['prev_tag_close'] = '</li>';
        //下一页标签
        $config['next_tag_open'] = '<li class="paginate_button next" id="example2_next">';
        $config['next_tag_close'] = '</li>';
        //数字链接的起始标签
        $config['num_tag_open'] = '<li class="paginate_button ">';
        $config['num_tag_close'] = '</li>';


        $this->pagination->initialize($config);

        $data['page']=$this->pagination->create_links();



        //var_dump($this->daili_model->getMemberInfo1($_SESSION['daili_uid']));
        $this->load->view('daili/templates/header',$data);
        $this->load->view('daili/hytj',$data);


    }

    /**
     * 站内消息
     */
    public function mailbox(){
        if ( ! file_exists(APPPATH.'views/daili/mailbox.php')){
            show_404();
        }

        //是否登录
        if (!$this->hasLogin()){
            redirect('http://'.$_SERVER['HTTP_HOST'].'/daili/login');
        }

        $data['users']=$this->daili_model->getMemberInfo($_SESSION['daili_uid']);
        $data['mailbox_class']='active';

        $this->load->view('daili/templates/header',$data);
        $this->load->view('daili/mailbox',$data);
        $this->load->view('daili/templates/footer');

    }

    /**
     * 用户登出
     *
     */
    public function logout()
    {
        $this->session->sess_destroy();

        redirect('http://' . $_SERVER['HTTP_HOST'] . '/daili');
    }
	
    /**
     * 代理商添加会员
     * 
     */
	public function add(){
        var_dump($_SESSION);
        $this->load->view('daili/templates/header',$data);
        $this->load->view('daili/add');
        $this->load->view('daili/templates/footer');
    }
}