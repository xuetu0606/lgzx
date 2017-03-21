<?php
class Admin extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model(array(
            'admin_model',
            'user_model',
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
     * 后台默认首页
     */
    public function index(){
        if ( ! file_exists(APPPATH.'views/admin/index.php')){
            show_404();
        }

        //是否登录
        if (!$this->hasLogin()){
            redirect('http://'.$_SERVER['HTTP_HOST'].'/admin/login');
        }

        $data['title'] = '管理后台'; // Capitalize the first letter
        $data['localhost'] = $_SERVER['HTTP_HOST'];//获取当前域名
        $data['index_class']='active';

        $data['users']=$this->admin_model->getuserinfo($_SESSION['admin_uid']);

        //var_dump($data['users']);

        $this->load->view('admin/templates/header',$data);
        $this->load->view('admin/index',$data);
        $this->load->view('admin/templates/footer',$data);
    }

    /**
     * 登录
     */
    public function login(){
		
        if ( ! file_exists(APPPATH.'views/admin/login.php')){
            show_404();
        }

        //是否登录
        if ($this->hasLogin()){
            redirect('http://'.$_SERVER['HTTP_HOST'].'/admin');
        }

        $data['title'] = '代理商登录'; // Capitalize the first letter
        $data['localhost'] = $_SERVER['HTTP_HOST'];//获取当前域名

        $this->form_validation->set_rules('username', '用户名', 'trim|required|min_length[3]|max_length[12]');
        $this->form_validation->set_rules('passwd', '密码', 'trim|required|min_length[6]');
        $this->form_validation->set_error_delimiters('<span>', '</span>');



        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/login', $data);
        } else {
            $userdata['username'] = $this->input->post('username', TRUE);
            $userdata['passwd'] = $this->admin_model->encryptPwd($this->input->post('passwd', TRUE));

            $user = $this->admin_model->getuserlist($userdata);

            if (!empty($user)) {

                /** 记录用户登录状态 */
                $_SESSION['admin_uid'] = $user['uid'];
                $_SESSION['admin_username'] = $user['username'];

                redirect('http://' . $_SERVER['HTTP_HOST'] . '/admin');

            } else {

                $data['error_string'] = '用户名和密码不符';
                $data['userdata'] = $userdata;

                $this->load->view('admin/login', $data);
            }
        }

    }


    /**
     * 是否登录验证
     */
    public function hasLogin()
    {
        /** 检查session，并与数据库里的数据相匹配 */
        if(!empty($_SESSION) and NULL !== $_SESSION['admin_uid'])
        {
            return TRUE;
        }else{
            return FALSE;
            //return TRUE;
        }
    }


    /**
     * 站内消息
     */
    public function mailbox(){
        if ( ! file_exists(APPPATH.'views/admin/mailbox.php')){
            show_404();
        }

        //是否登录
        if (!$this->hasLogin()){
            redirect('http://'.$_SERVER['HTTP_HOST'].'/admin/login');
        }

        $data['users']=$this->admin_model->getMemberInfo($_SESSION['admin_uid']);
        $data['mailbox_class']='active';

        $this->load->view('admin/templates/header',$data);
        $this->load->view('admin/mailbox',$data);
        $this->load->view('admin/templates/footer');

    }

    /**
     * 用户登出
     *
     */
    public function logout()
    {
        $this->session->sess_destroy();

        redirect('http://' . $_SERVER['HTTP_HOST'] . '/admin');
    }

    /**
     * 会员统计
     */
    public function hylb(){
        if ( ! file_exists(APPPATH.'views/admin/hylb.php')){
            show_404();
        }

        //是否登录
        if (!$this->hasLogin()){
            redirect('http://'.$_SERVER['HTTP_HOST'].'/admin/login');
        }

        $data['title']='会员列表';
        $data['localhost'] = $_SERVER['HTTP_HOST'];//获取当前域名
        $data['hytj_class']='active';
        $data['class']='class="bg-green"';
        $data['url_gong']=$this->uri->segment(4, 0);
        $data['url_reg']=$this->uri->segment(6, 0);
        $data['url_vip']=$this->uri->segment(8, 0);
        //获取全部省市信息
        $data['area'] = array($this->admin_model->getProvince(), $this->admin_model->getAllCity());
echo '<pre>';
//var_dump($data['area']);
echo '</pre>';
        $page=$this->uri->segment(10, 0);
        $this->load->library('pagination');
        $fenye=10;//分页数
        
        //$count=count($this->admin_model->getMemberInfo1($_SESSION['admin_uid'],$sql));

        $sql=" LIMIT {$page},{$fenye}";

        $riqi1=$this->input->post('riqi1',true);
        $riqi2=$this->input->post('riqi2',true);

        if($_POST){
            $starttime=strtotime($riqi1);
            $endtime= strtotime($riqi2) + 86300;
            if($this->input->post('quxiao_riqi',true)){
                unset(
                    $_SESSION['starttime'],
                    $_SESSION['endtime']
                );

            }elseif($riqi1 and $riqi2){
                $_SESSION['starttime']=$starttime;
                $_SESSION['endtime']=$endtime;
            }
            if($this->input->post('quxiao_city',true)){
                unset(
                    $_SESSION['city_id'],
                    $_SESSION['pro_id']
                );

            }elseif($this->input->post('c_id',true)){
                $_SESSION['city_id']=$this->input->post('c_id',true);
                $_SESSION['pro_id']=$this->input->post('p_id',true);
            }

        }


        $data1=array(
            'userid'=>$_SESSION['admin_uid'],
            'starttime'=>$_SESSION['starttime'],
            'endtime'=>$_SESSION['endtime'],
            'gong'=>$data['url_gong'],
            'reg'=>$data['url_reg'],
            'vip'=>$data['url_vip'],
            'addsql'=>$sql,
            'city_id'=>$_SESSION['city_id']
        );

        $data2=array(
            'userid'=>$_SESSION['admin_uid'],
            'starttime'=>$_SESSION['starttime'],
            'endtime'=>$_SESSION['endtime'],
            'gong'=>$data['url_gong'],
            'reg'=>$data['url_reg'],
            'vip'=>$data['url_vip'],
            'addsql'=>'',
            'city_id'=>$_SESSION['city_id']
        );
        $count=count($this->admin_model->getMemberInfo1($data2));


        $data['users']=$this->admin_model->getMemberInfo1($data1);


        $config['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/admin/hylb/gong/'.$data['url_gong'].'/reg/'.$data['url_reg'].'/vip/'.$data['url_vip'].'/page/';
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

        //第一个链接的起始标签。
        $config['first_tag_open'] = '<li class="paginate_button previous">';
        $config['first_tag_close'] = '</li>';
        //最后一个链接的起始标签。
        $config['last_tag_open'] = '<li class="paginate_button next">';
        $config['last_tag_close'] = '</li>';


        $this->pagination->initialize($config);

        $data['page']=$this->pagination->create_links();



        //var_dump($this->admin_model->getMemberInfo1($_SESSION['admin_uid']));
        $this->load->view('admin/templates/header',$data);
        $this->load->view('admin/hylb',$data);


    }

    /**
     * 会员资料修改
     */
    public function edit()
    {
        if (!file_exists(APPPATH . 'views/admin/edit.php')) {
            show_404();
        }

        //是否登录
        if (!$this->hasLogin()) {
            redirect('http://' . $_SERVER['HTTP_HOST'] . '/admin/login');
        }

        $data['title'] = '会员信息';
        $data['localhost'] = $_SERVER['HTTP_HOST'];//获取当前域名
        $data['hytj_class']='active';

        $no=$this->uri->segment(3, 0);

        $data['member']=$memberinfo=$this->admin_model->getMemberInfo($no);
        $data['provinceCity']=$this->admin_model->getProvinceCity($data['member']['city_id']);
        $data['scale']=$this->admin_model->getScale();

        var_dump($_POST);
        if($_POST){

            $return=$this->admin_model->seveMemberInfo($_POST);
        }

        $this->load->view('admin/templates/header',$data);
        $this->load->view('admin/edit',$data);
        $this->load->view('admin/templates/footer');

    }
	
	//打开查询页面
    public function reveal(){
        $data['users'] = $this->admin_model->getReveal();
        $this->load->view('admin/templates/header');
        $this->load->view('admin/reveal',$data);
        $this->load->view('admin/templates/footer');
    }
    //删除一条消息
    public function deleteReveal(){
        $id = $this->uri->segment(3);
        $this->admin_model->deleteReveal($id);
    }
    //打开修改页面,并根据ID查询要修改的数据
    public function toUpdateReveal(){
		$city_id = 224;
        $id = $this->uri->segment(3);
        $data['user'] = $this->admin_model->findReveal($id);
		
		$sql = "select name,id from district_dic where upid=".$city_id;
		$result = $this->db->query($sql);
		$name = $result->result_array();
		$data['district_names'] = $name;
		
		$sql = "select name,id from pay_unit_dic ";
		$result = $this->db->query($sql);
		$name = $result->result_array();
		$data['pay_unit_names'] = $name;
		
		$sql = "select name,id from pay_circle_dic ";
		$result = $this->db->query($sql);
		$name = $result->result_array();
		$data['pay_circle_names'] = $name;
		
		$sql = "select name,id from job_type ";
		$result = $this->db->query($sql);
		$name = $result->result_array();
		$data['job_names'] = $name;
		
		$this->load->view('admin/templates/header');
		$this->load->view('admin/updateReveal',$data);
        $this->load->view('admin/templates/footer');
    }
    //修改一条消息
    public function updateReveal(){
        $id = $_POST['id'];
        $job_code = $_POST['job_code'];
        $city_id = $_POST['city_id'];
        $district_id = $_POST['district_id'];
        $title = $_POST['title'];
        $pay = $_POST['pay'];
        $pay_unit = $_POST['pay_unit'];
        $pay_circle = $_POST['pay_circle'];
        $sum = $_POST['sum'];
        $worktime = $_POST['worktime'];
        $contacts = $_POST['contacts'];
        $mobile = $_POST['mobile'];
        $address = $_POST['address'];
        $info = $_POST['info'];
        $this->admin_model->updateReveal($id,$job_code,$district_id,$title,$pay,$pay_unit,$pay_circle,$sum,$worktime,$contacts,$mobile,$address,$info,$flag);
		$this->reveal();
    }
    //添加一个会员
    public function addMember(){
        if($_POST){
            $this->admin_model->addUser($_POST);
        }
        $data['job'] = $this->admin_model->getJob();
        $this->load->view('admin/templates/header');
        $this->load->view('admin/add-member',$data);
        $this->load->view('admin/templates/footer');
    }
    //获取根据省份城市查询区县街道
    public function getJoin(){
        $upid = $this->uri->segment(3);
        $data = $this->admin_model->getJoin($upid);
        $str = json_encode($data);
        echo $str;
    }
}