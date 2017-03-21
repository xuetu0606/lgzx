<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 public function __construct(){
        parent::__construct();
        $this->load->model('List_model');
        $this->load->model('Form_model');
        $this->load->model('User_model');
        $this->load->model('Main_model');
        $this->load->helper('url_helper');
    }

	public function index()
	{
//		$param=array('username'=>'shaqweqwe','password'=>'aaaaaa1212223123','email'=>'28274664@qq.com','referer'=>'零工在线','p_id'=>'3','c_id'=>'74','mobile'=>'15275221111','is_co'=>'0','realname'=>'testname');
//		 var_dump($this->User_model->checkIsMobile('136788627311')) ;
//		var_dump( $this->Form_model->getMyGZPublish(4));exit;
//		 print_r($this->List_model->list);
//		 print_r($this->List_model->count);
		 var_dump($this->Form_model->getGzDetal(array('uid'=>7,'id'=>22)));
//		 var_dump($this->Main_model->getCityList());exit;
var_dump($this->Form_model->baseinfo);
var_dump($this->Form_model->qyinfo);exit;
		 $this->load->view('templates/header');
	    $this->load->view('home/index',$data);
	    $this->load->view('templates/footer');
		
	}
}
