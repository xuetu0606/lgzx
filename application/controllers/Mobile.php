<?php
	class Mobile extends CI_Controller {
		public function __construct(){
	        parent::__construct();
	        $this->load->model('User_model');
	        $this->load->helper('url_helper');
	    }
	    public function index(){
	    	$this->load->view('mobile');
	    }
	}
?>