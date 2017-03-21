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
        $this->load->model('User_model');
        $this->load->helper('url_helper');
    }

	public function index()
	{
		$param=array('username'=>'sh11111an','password'=>'aaaaaa1212223123','email'=>'28274664@qq.com','referer'=>'零工在线','p_id'=>'3','c_id'=>'74','mobile'=>'15275221233','is_co'=>'1','coname'=>'公司名名');
		 var_dump($this->User_model->addUser($param)) ;exit;
		 
		 $this->load->view('templates/header');
	    $this->load->view('home/index',$data);
	    $this->load->view('templates/footer');
		
	}
}
